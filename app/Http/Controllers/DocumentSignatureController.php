<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentSignature;
use App\Models\DocumentWorkflow;
use App\Models\Notification;
use App\Models\DocumentLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DocumentSignatureController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = DocumentSignature::with(['document', 'user']);
        if (!$user->is_admin) {
            $query->where('user_id', $user->id);
        }
        $signatures = $query->latest()->paginate(12);
        return view('signatures.index', compact('signatures'));
    }

    public function create(Request $request)
    {
        $documentId = $request->query('document_id');
        $document = $documentId ? Document::find($documentId) : null;
        $documents = Document::latest()->get();

        if ($documents->isEmpty()) {
            return redirect()->route('documents.index')->with('error', 'Сначала загрузите документ.');
        }

        return view('signatures.create', compact('document', 'documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
        ]);

        $document = Document::findOrFail($request->document_id);
        $signer = Auth::user();
        $creator = $document->user; // Автор (отправитель)

        $currentWorkflow = DocumentWorkflow::where('document_id', $document->id)
            ->where('status', 'pending')
            ->orderBy('step_order', 'asc')
            ->first();

        if ($currentWorkflow && (int)$signer->id !== (int)$currentWorkflow->user_id) {
            return back()->with('error', 'Сейчас очередь другого пользователя!');
        }

        // Формируем детальный текст для QR-кода
        $qrData = "DOCUMENT: {$document->title}\n";
        $qrData .= "SENDER: " . ($creator->name ?? 'System') . " (" . ($creator->email ?? '-') . ")\n";
        $qrData .= "SIGNED BY: {$signer->name} ({$signer->email})\n";
        $qrData .= "SENT AT: " . $document->created_at->format('d.m.Y H:i') . "\n";
        $qrData .= "SIGNED AT: " . now()->format('d.m.Y H:i:s');

        try {
            return DB::transaction(function () use ($document, $signer, $currentWorkflow, $qrData) {
                $result = $this->processPdfSigning($document, $qrData);

                DocumentSignature::create([
                    'document_id' => $document->id,
                    'user_id'     => $signer->id,
                    'signature'   => $result['qr_path'],
                    'signed_at'   => now(),
                ]);

                $document->update([
                    'file_path' => $result['pdf_path'],
                    'status'    => ($this->isLastStep($document)) ? 'completed' : 'processing'
                ]);

                $this->logAction($document->id, 'signed', "Документ подписан: {$signer->name}");
                $this->processWorkflow($document, $currentWorkflow, $signer);

                return redirect()->route('signatures.index')->with('success', 'Документ успешно подписан!');
            });
        } catch (\Exception $e) {
            \Log::error("Ошибка DocSign: " . $e->getMessage());
            return back()->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }

    public function show(DocumentSignature $signature) {
        return view('signatures.show', compact('signature'));
    }

    public function edit(DocumentSignature $signature) {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) abort(403);
        return view('signatures.edit', compact('signature'));
    }

    public function update(Request $request, DocumentSignature $signature)
    {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) abort(403);

        $document = $signature->document;
        $signer = Auth::user();
        $creator = $document->user;

        $qrData = "DOC: {$document->title} (UPDATED)\n";
        $qrData .= "SENDER: " . ($creator->name ?? 'System') . " (" . ($creator->email ?? '-') . ")\n";
        $qrData .= "SIGNED BY: {$signer->name} ({$signer->email})\n";
        $qrData .= "SIGNED AT: " . now()->format('d.m.Y H:i:s');

        try {
            return DB::transaction(function () use ($qrData, $signature) {
                $document = $signature->document;
                $result = $this->processPdfSigning($document, $qrData);

                Storage::disk('public')->delete([$document->file_path, $signature->signature]);

                $document->update(['file_path' => $result['pdf_path']]);
                $signature->update([
                    'signature' => $result['qr_path'],
                    'signed_at' => now(),
                ]);

                return redirect()->route('signatures.show', $signature->id)->with('success', 'Обновлено!');
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(DocumentSignature $signature) {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) abort(403);
        Storage::disk('public')->delete([$signature->document->file_path, $signature->signature]);
        $signature->delete();
        return back()->with('success', 'Запись удалена');
    }

    private function processPdfSigning($document, $qrPayload)
    {
        $tempDir = storage_path('app/temp_sigs');
        if (!File::exists($tempDir)) File::makeDirectory($tempDir, 0755, true);
        $tempImgPath = $tempDir . '/' . uniqid() . '.png';

        // Генерация QR через API
        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrPayload);
        $content = @file_get_contents($qrApiUrl);
        if (!$content) throw new \Exception("Ошибка API QR-кодов.");
        File::put($tempImgPath, $content);

        $originalPath = storage_path('app/public/' . $document->file_path);
        if (!File::exists($originalPath)) throw new \Exception("Файл PDF не найден.");

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false);

        $pageCount = $pdf->setSourceFile($originalPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Штамп на последнюю страницу
            if ($pageNo === $pageCount) {
                $qrSize = 28; // Меньший размер
                $margin = 15;
                $x = $size['width'] - $qrSize - $margin;
                $y = $size['height'] - $qrSize - $margin - 5;

                // Белая подложка под QR
                $pdf->SetFillColor(255, 255, 255);
                $pdf->Rect($x - 1, $y - 1, $qrSize + 2, $qrSize + 7, 'F');

                $pdf->Image($tempImgPath, $x, $y, $qrSize, $qrSize, 'PNG');

                // Текст под QR-кодом
                $pdf->SetFont('helvetica', 'B', 5);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Text($x + 1, $y + $qrSize + 1, "VERIFIED DOCSIGN");

                // Дата и время подписи в PDF
                $pdf->SetFont('helvetica', '', 4);
                $pdf->SetTextColor(80, 80, 80);
                $pdf->Text($x + 1, $y + $qrSize + 3, now()->format('d.m.Y H:i:s'));
            }
        }

        $newFileName = 'documents/signed_' . time() . '.pdf';
        $permanentQrName = 'signatures/qr_' . time() . '.png';

        $pdf->Output(storage_path('app/public/' . $newFileName), 'F');

        if (!File::exists(storage_path('app/public/signatures'))) {
            File::makeDirectory(storage_path('app/public/signatures'), 0755, true);
        }
        File::move($tempImgPath, storage_path('app/public/' . $permanentQrName));

        return ['pdf_path' => $newFileName, 'qr_path' => $permanentQrName];
    }

    private function isLastStep($document) {
        return !DocumentWorkflow::where('document_id', $document->id)->where('status', 'pending')->exists();
    }

    private function logAction($docId, $action, $desc) {
        DocumentLog::create(['document_id' => $docId, 'user_id' => Auth::id(), 'action' => $action, 'description' => $desc]);
    }

    private function processWorkflow($document, $currentWorkflow, $signer) {
        if ($currentWorkflow) {
            $currentWorkflow->update(['status' => 'approved']);
            $next = DocumentWorkflow::where('document_id', $document->id)->where('step_order', '>', $currentWorkflow->step_order)->orderBy('step_order')->first();
            if ($next) $next->update(['status' => 'pending']);
            else $document->update(['status' => 'approved']);
        }
    }
}
