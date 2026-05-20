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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Exception;

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
        ], [
            'document_id.required' => 'Идентификатор документа не передан.',
            'document_id.exists' => 'Выбранный документ не найден в базе данных.',
        ]);

        $document = Document::findOrFail($request->document_id);
        $signer = Auth::user();
        $creator = $document->user;

        $currentWorkflow = DocumentWorkflow::where('document_id', $document->id)
            ->where('status', 'pending')
            ->orderBy('step_order', 'asc')
            ->first();

        if ($currentWorkflow && (int)$signer->id !== (int)$currentWorkflow->user_id) {
            return back()->with('error', 'Сейчас очередь другого пользователя!');
        }

        $senderName = $creator->name ?? 'System';
        $senderEmail = $creator->email ?? '-';
        $signerName = $signer->name ?? 'Unknown';
        $signerEmail = $signer->email ?? '-';

        $sentDate = $document->created_at ? $document->created_at->format('d.m.Y H:i') : now()->format('d.m.Y H:i');
        $signedDate = now()->format('d.m.Y H:i:s');

        $qrData = "DocSign | DOC: {$document->title} | SENDER: {$senderName} ({$senderEmail}) | SIGNED BY: {$signerName} ({$signerEmail}) | SENT AT: {$sentDate} | SIGNED AT: {$signedDate}";
        $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));

        $redirectType = 'other';

        try {
            DB::transaction(function () use ($document, $signer, $currentWorkflow, $qrData, $extension, &$redirectType) {

                if ($extension === 'docx') {
                    $result = $this->processDocxSigning($document, $qrData);

                    DocumentSignature::updateOrCreate(
                        ['document_id' => $document->id, 'user_id' => $signer->id],
                        ['signature' => $result['qr_path'], 'signed_at' => now()]
                    );

                    $this->processWorkflow($document, $currentWorkflow, $signer);

                    $document->update([
                        'file_path' => $result['docx_path'],
                        'status'    => ($this->isLastStep($document)) ? 'completed' : 'processing'
                    ]);

                    $this->logAction($document->id, 'signed', "Автоштамп подписи (последняя страница, угол) добавлен в DOCX: {$signer->name}");

                    $redirectType = 'docx';
                    return;
                }

                if ($extension === 'pdf') {
                    $result = $this->processPdfSigning($document, $qrData);

                    DocumentSignature::updateOrCreate(
                        ['document_id' => $document->id, 'user_id' => $signer->id],
                        ['signature' => $result['qr_path'], 'signed_at' => now()]
                    );

                    $this->processWorkflow($document, $currentWorkflow, $signer);

                    $document->update([
                        'file_path' => $result['pdf_path'],
                        'status'    => ($this->isLastStep($document)) ? 'completed' : 'processing'
                    ]);

                    $this->logAction($document->id, 'signed', "Автоштамп подписи (последняя страница, угол) внедрен в PDF: {$signer->name}");

                    $redirectType = 'pdf';
                    return;
                }

                // Обработка EXCEL и остальных форматов (Генерация простого QR-кода)
                $permanentQrName = 'signatures/qr_' . time() . '.svg';
                $publicSigsPath = storage_path('app/public/signatures');
                if (!File::exists($publicSigsPath)) {
                    File::makeDirectory($publicSigsPath, 0755, true, true);
                }

                $qrCodeSvg = QrCode::format('svg')->size(300)->margin(1)->generate($qrData);
                File::put(storage_path('app/public/' . $permanentQrName), $qrCodeSvg);

                DocumentSignature::updateOrCreate(
                    ['document_id' => $document->id, 'user_id' => $signer->id],
                    ['signature' => $permanentQrName, 'signed_at' => now()]
                );

                $this->processWorkflow($document, $currentWorkflow, $signer);

                $document->update(['status' => ($this->isLastStep($document)) ? 'completed' : 'processing']);
                $this->logAction($document->id, 'signed', "Документ Excel подписан системой: {$signer->name}");
            });

            if ($redirectType === 'docx') {
                return redirect()->route('signatures.index')->with('success', 'Документ Word успешно подписан!');
            } elseif ($redirectType === 'pdf') {
                return redirect()->route('signatures.index')->with('success', 'Документ PDF успешно подписан!');
            }

            return redirect()->route('signatures.index')->with('success', 'Документ успешно подписан!');

        } catch (Exception $e) {
            \Log::error("Ошибка автоматического сохранения подписи: " . $e->getMessage());
            return back()->with('error', 'Критическая ошибка: ' . $e->getMessage());
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

        $senderName = $creator->name ?? 'System';
        $senderEmail = $creator->email ?? '-';
        $signerName = $signer->name ?? 'Unknown';
        $signerEmail = $signer->email ?? '-';

        $sentDate = $document->created_at ? $document->created_at->format('d.m.Y H:i') : now()->format('d.m.Y H:i');
        $signedDate = now()->format('d.m.Y H:i:s');

        $qrData = "DocSign (UPDATED) | DOC: {$document->title} | SENDER: {$senderName} ({$senderEmail}) | SIGNED BY: {$signerName} ({$signerEmail}) | SENT AT: {$sentDate} | SIGNED AT: {$signedDate}";
        $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));

        $redirectType = 'other';

        try {
            return DB::transaction(function () use ($qrData, $signature, $document, $extension, &$redirectType) {

                if ($extension === 'docx') {
                    if ($signature->signature) Storage::disk('public')->delete($signature->signature);
                    if ($document->file_path) Storage::disk('public')->delete($document->file_path);

                    $result = $this->processDocxSigning($document, $qrData);

                    $document->update(['file_path' => $result['docx_path']]);
                    $signature->update(['signature' => $result['qr_path'], 'signed_at' => now()]);

                    $redirectType = 'docx';
                    return;
                }

                if ($extension === 'pdf') {
                    if ($signature->signature) Storage::disk('public')->delete($signature->signature);
                    if ($document->file_path) Storage::disk('public')->delete($document->file_path);

                    $result = $this->processPdfSigning($document, $qrData);

                    $document->update(['file_path' => $result['pdf_path']]);
                    $signature->update(['signature' => $result['qr_path'], 'signed_at' => now()]);

                    $redirectType = 'pdf';
                    return;
                }

                if ($signature->signature) Storage::disk('public')->delete($signature->signature);

                $permanentQrName = 'signatures/qr_' . time() . '.svg';
                $qrCodeSvg = QrCode::format('svg')->size(300)->margin(1)->generate($qrData);
                File::put(storage_path('app/public/' . $permanentQrName), $qrCodeSvg);

                $signature->update(['signature' => $permanentQrName, 'signed_at' => now()]);
            });

            if ($redirectType === 'docx') {
                return redirect()->route('signatures.show', $signature->id)->with('success', 'Файл Word автоматически переподписан!');
            } elseif ($redirectType === 'pdf') {
                return redirect()->route('signatures.show', $signature->id)->with('success', 'Файл PDF автоматически обновлен!');
            }

            return redirect()->route('signatures.show', $signature->id)->with('success', 'Данные подписи обновлены!');

        } catch (Exception $e) {
            return back()->with('error', 'Ошибка обновления: ' . $e->getMessage());
        }
    }

    public function destroy(DocumentSignature $signature) {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) abort(403);

        $extension = strtolower(pathinfo($signature->document->file_path, PATHINFO_EXTENSION));
        if (in_array($extension, ['pdf', 'docx'])) {
            Storage::disk('public')->delete($signature->document->file_path);
        }

        if ($signature->signature) {
            Storage::disk('public')->delete($signature->signature);
        }

        $signature->delete();
        return back()->with('success', 'Запись удалена');
    }


    private function processDocxSigning($document, $qrPayload)
    {
        $originalPath = storage_path('app/public/' . $document->file_path);
        if (!File::exists($originalPath)) {
            throw new Exception("Исходный файл Word не найден.");
        }

        $tempDir = storage_path('app/temp_sigs');
        if (!File::exists($tempDir)) File::makeDirectory($tempDir, 0755, true);

        $tempQrPath = $tempDir . '/' . uniqid() . '_qr.png';
        $tempStampPath = $tempDir . '/' . uniqid() . '_stamp.png';

        // 1. Скачивание QR-кода
        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrPayload);
        $content = @file_get_contents($qrApiUrl);
        if (!$content) throw new Exception("Не удалось сгенерировать базовый QR-код.");
        File::put($tempQrPath, $content);

        // 2. Генерация штампа через GD
        $stampW = 220; $stampH = 260;
        $im = imagecreatetruecolor($stampW, $stampH);
        imagefill($im, 0, 0, imagecolorallocate($im, 255, 255, 255));
        $black = imagecolorallocate($im, 0, 0, 0);

        imagerectangle($im, 0, 0, $stampW - 1, $stampH - 1, $black);

        $qrSource = imagecreatefrompng($tempQrPath);
        imagecopyresampled($im, $qrSource, 20, 15, 0, 0, 180, 180, 300, 300);
        imagedestroy($qrSource);

        imagestring($im, 3, 50, 210, "VERIFIED DOCSIGN", $black);
        imagestring($im, 3, 60, 230, now()->format('d.m.Y H:i'), $black);

        imagepng($im, $tempStampPath);
        imagedestroy($im);


        $phpWord = IOFactory::load($originalPath);
        $sections = $phpWord->getSections();
        $section = count($sections) > 0 ? end($sections) : $phpWord->addSection();

       $section->addImage($tempStampPath, [
            'width'            => 90,
            'height'           => 105,
            'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
            'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
            'posVertical'      => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_BOTTOM,
            'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
            'marginLeft'       => -20,
            'marginTop'        => -20,
            'wrappingStyle'    => \PhpOffice\PhpWord\Style\Image::WRAPPING_STYLE_BEHIND
        ]);


        $time = time();
        $newFileName = 'documents/signed_' . $time . '.docx';
        $permanentQrName = 'signatures/qr_' . $time . '.png';

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/' . $newFileName));


        $publicSigsPath = storage_path('app/public/signatures');
        if (!File::exists($publicSigsPath)) File::makeDirectory($publicSigsPath, 0755, true, true);

        File::move($tempStampPath, storage_path('app/public/' . $permanentQrName));
        if (File::exists($tempQrPath)) File::delete($tempQrPath);

        return ['docx_path' => $newFileName, 'qr_path' => $permanentQrName];
    }

    private function processPdfSigning($document, $qrPayload)
    {
        $tempDir = storage_path('app/temp_sigs');
        if (!File::exists($tempDir)) File::makeDirectory($tempDir, 0755, true);
        $tempImgPath = $tempDir . '/' . uniqid() . '.png';

        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrPayload);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $qrApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $content = curl_exec($ch);
        curl_close($ch);

        if (!$content) $content = @file_get_contents($qrApiUrl);
        if (!$content) throw new Exception("Не удалось сгенерировать штамп.");
        File::put($tempImgPath, $content);

        $originalPath = storage_path('app/public/' . $document->file_path);
        if (!File::exists($originalPath)) throw new Exception("Файл PDF не найден.");

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

            if ($pageNo === $pageCount) {
                $stampW = 30;
                $stampH = 35;
                $qrSize = 22;

                $marginRight = 5;
                $marginBottom = 5;

                $x = $size['width'] - $stampW - $marginRight;
                $y = $size['height'] - $stampH - $marginBottom;

                $pdf->setCellPaddings(0, 0, 0, 0);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->Rect($x, $y, $stampW, $stampH, 'F');

                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetLineWidth(0.3);
                $pdf->Rect($x, $y, $stampW, $stampH, 'D');

                $pdf->Image($tempImgPath, $x + 4, $y + 3, $qrSize, $qrSize, 'PNG');

                $pdf->SetFont('courier', 'B', 5);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY($x, $y + $qrSize + 4.5);
                $pdf->Cell($stampW, 2.5, "VERIFIED DOCSIGN", 0, 0, 'C');

                $pdf->SetFont('courier', 'B', 4.5);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY($x, $y + $qrSize + 7);
                $pdf->Cell($stampW, 2.5, now()->format('d.m.Y H:i'), 0, 0, 'C');
            }
        }

        $newFileName = 'documents/signed_' . time() . '.pdf';
        $permanentQrName = 'signatures/qr_' . time() . '.png';

        $pdf->Output(storage_path('app/public/' . $newFileName), 'F');

        $publicSigsPath = storage_path('app/public/signatures');
        if (!File::exists($publicSigsPath)) File::makeDirectory($publicSigsPath, 0755, true, true);
        File::move($tempImgPath, storage_path('app/public/' . $permanentQrName));

        return ['pdf_path' => $newFileName, 'qr_path' => $permanentQrName];
    }

    private function isLastStep($document) {
        $hasWorkflow = DocumentWorkflow::where('document_id', $document->id)->exists();
        if (!$hasWorkflow) return true;
        return !DocumentWorkflow::where('document_id', $document->id)->where('status', 'pending')->exists();
    }

    private function logAction($docId, $action, $desc) {
        DocumentLog::create([
            'document_id' => $docId,
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $desc
        ]);
    }

    private function processWorkflow($document, $currentWorkflow, $signer) {
        if ($currentWorkflow) {
            $currentWorkflow->update(['status' => 'approved']);
            $next = DocumentWorkflow::where('document_id', $document->id)
                ->where('step_order', '>', $currentWorkflow->step_order)
                ->orderBy('step_order')
                ->first();
            if ($next) $next->update(['status' => 'pending']);
        }
    }
}
