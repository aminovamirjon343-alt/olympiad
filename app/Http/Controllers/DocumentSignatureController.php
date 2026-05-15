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
use setasign\Fpdi\Fpdi;

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
        // Получаем ID из GET-параметра (если пришли из реестра карточек)
        $documentId = $request->query('document_id');

        // Ищем конкретный документ, только если передан ID
        $document = null;
        if ($documentId) {
            $document = Document::find($documentId);
        }

        // Получаем ВСЕ документы для выпадающего списка
        $documents = Document::latest()->get();

        // Если вообще никаких документов в системе нет — тогда отправляем создавать документы
        if ($documents->isEmpty()) {
            return redirect()->route('documents.index')->with('error', 'В системе ещё нет ни одного документа для подписи. Сначала загрузите документ.');
        }

        // Передаем пользователей (исполнителей), если нужно
        $users = User::all();

        return view('signatures.create', compact('document', 'documents', 'users'));
    }

    public function store(Request $request)
    {
        // 1. Валидация входных данных под QR-код
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'qr_payload'  => 'required|string'
        ]);

        $document = Document::findOrFail($request->document_id);
        $signer = Auth::user();

        // 2. Проверка очереди подписи (Workflow)
        $currentWorkflow = DocumentWorkflow::where('document_id', $document->id)
            ->where('status', 'pending')
            ->orderBy('step_order', 'asc')
            ->first();

        if ($currentWorkflow && (int)$signer->id !== (int)$currentWorkflow->user_id) {
            return back()->with('error', 'Сейчас очередь другого пользователя для подписи!');
        }

        // 3. Проверка: не подписал ли пользователь уже этот документ
        $alreadySigned = DocumentSignature::where('document_id', $document->id)
            ->where('user_id', $signer->id)
            ->exists();

        if ($alreadySigned) {
            return back()->with('error', 'Вы уже подписали этот документ.');
        }

        // 4. Запуск транзакции
        try {
            DB::transaction(function () use ($request, $document, $signer, $currentWorkflow) {
                // А. Вшивание QR-кода в PDF и получение путей к файлам
                $signingResult = $this->processPdfSigning($document, $request->qr_payload);

                $newPdfPath = $signingResult['pdf_path'];
                $savedQrPath = $signingResult['qr_path'];

                // Б. Обновление документа
                $document->update([
                    'file_path' => $newPdfPath,
                    'status'    => ($currentWorkflow && $this->isLastStep($document)) ? 'completed' : $document->status
                ]);

                // В. Создание записи о подписи
                DocumentSignature::create([
                    'document_id' => $document->id,
                    'user_id'     => $signer->id,
                    'signature'   => $savedQrPath,
                    'signed_at'   => now(),
                    'expires_at'  => $document->deadline ?? null,
                ]);

                // Г. Логирование, Уведомление и Воркфлоу
                $this->logAction($document->id, 'signed', "Документ защищен QR-кодом пользователем: {$signer->name}");

                // Уведомляем создателя документа
                $this->sendNotification($document->created_by, $signer, $document);

                // Двигаем воркфлоу на следующий шаг
                $this->processWorkflow($document, $currentWorkflow, $signer);
            });

            // Если всё прошло успешно внутри транзакции — редиректим
            return redirect()->route('signatures.index')->with('success', 'Документ успешно подписан, QR-код вшит в файл!');

        } catch (\Exception $e) {
            // Если упало ГДЕ УГОДНО внутри DB::transaction, управление переходит сюда
            \Log::error("Ошибка при подписании документа ID {$document->id}: " . $e->getMessage());
            return back()->with('error', 'Ошибка при обработке PDF или сохранении данных: ' . $e->getMessage());
        }

    }

    /**
     * Вшивание сгенерированного QR-кода в документ PDF
     */
    protected function processPdfSigning($document, $qrPayload)
    {
        $tempDir = storage_path('app/temp_sigs');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        // 1. Безопасное скачивание изображения QR-кода через cURL во временный файл
        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrPayload);
        $tempImgPath = $tempDir . '/' . uniqid() . '.png';

        $ch = curl_init($qrApiUrl);
        $fp = fopen($tempImgPath, 'wb');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        // Проверяем, удалось ли успешно создать локальный файл изображения
        if (!File::exists($tempImgPath) || File::size($tempImgPath) === 0) {
            throw new \Exception("Не удалось сгенерировать или скачать изображение QR-кода через API сервера.");
        }

        // Путь к оригинальному PDF
        $originalPath = storage_path('app/public/' . $document->file_path);

        if (!File::exists($originalPath)) {
            if (File::exists($tempImgPath)) File::delete($tempImgPath);
            throw new \Exception("Исходный файл PDF не найден по пути: " . $document->file_path);
        }

        try {
            $pdf = new \setasign\Fpdi\Fpdi();
            $pageCount = $pdf->setSourceFile($originalPath);

            // Пробегаем по всем страницам документа
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);

                // Накладываем штамп QR-кода только на САМУЮ ПОСЛЕДНЮЮ страницу
                if ($pageNo === $pageCount) {
                    // Размеры QR-кода на листе (квадрат 35х35 мм)
                    $qrW = 35;
                    $qrH = 35;

                    // Координаты размещения (отступаем от правого нижнего угла страницы)
                    $x = $size['width'] - $qrW - 15;
                    $y = $size['height'] - $qrH - 20;

                    // --- ШАГ 1: ОЧИСТКА ОБЛАСТИ ПОД ШТАМП (Белая подложка) ---
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->Rect($x - 2, $y - 2, $qrW + 4, $qrH + 10, 'F');

                    // --- ШАГ 2: ВШИВАНИЕ ЛОКАЛЬНОГО QR-КОДА ---
                    $pdf->Image($tempImgPath, $x, $y, $qrW, $qrH, 'PNG');

                    // --- ШАГ 3: ПОДПИСЬ ПОД QR-КОДОМ ---
                    $pdf->SetFont('Arial', 'I', 7);
                    $pdf->SetTextColor(100, 100, 100);

                    $dateText = "Verified DocSign";
                    $textWidth = $pdf->GetStringWidth($dateText);
                    $textX = $x + ($qrW / 2) - ($textWidth / 2);
                    $textY = $y + $qrH + 4;

                    $pdf->Text($textX, $textY, $dateText);
                }
            }

            // Формируем директории для постоянного сохранения результатов, если их нет
            if (!File::exists(storage_path('app/public/documents'))) {
                File::makeDirectory(storage_path('app/public/documents'), 0755, true);
            }
            if (!File::exists(storage_path('app/public/signatures'))) {
                File::makeDirectory(storage_path('app/public/signatures'), 0755, true);
            }

            // Генерируем пути постоянного сохранения результатов
            $newFileName = 'documents/signed_' . time() . '.pdf';
            $newFullPath = storage_path('app/public/' . $newFileName);

            $permanentQrName = 'signatures/qr_' . $document->id . '_' . Auth::id() . '_' . time() . '.png';
            $permanentQrPath = storage_path('app/public/' . $permanentQrName);

            // Сохраняем измененный PDF файл со штампом
            $pdf->Output($newFullPath, 'F');

            // Копируем временный QR-код в постоянное хранилище для истории подписей
            File::copy($tempImgPath, $permanentQrPath);

            return [
                'pdf_path' => $newFileName,
                'qr_path'  => $permanentQrName
            ];

        } catch (\Exception $e) {
            throw new \Exception("Ошибка при модификации PDF: " . $e->getMessage());
        } finally {
            // Обязательно чистим временную картинку с диска
            if (File::exists($tempImgPath)) {
                File::delete($tempImgPath);
            }
        }
    }

    public function update(Request $request, DocumentSignature $signature)
    {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'qr_payload' => 'required|string',
            'title'      => 'nullable|string|max:255'
        ]);

        $document = $signature->document;

        return DB::transaction(function () use ($request, $document, $signature) {
            if ($request->filled('title')) {
                $document->update(['title' => $request->title]);
            }

            try {
                $signingResult = $this->processPdfSigning($document, $request->qr_payload);

                // Чистим старые файлы
                if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                if ($signature->signature && Storage::disk('public')->exists($signature->signature)) {
                    Storage::disk('public')->delete($signature->signature);
                }

                $document->update(['file_path' => $signingResult['pdf_path']]);

                $signature->update([
                    'signature' => $signingResult['qr_path'],
                    'signed_at' => now(),
                ]);

                return redirect()->route('signatures.show', $signature->id)
                    ->with('success', 'QR-подпись успешно обновлена!');

            } catch (\Exception $e) {
                return back()->with('error', 'Ошибка при обновлении: ' . $e->getMessage());
            }
        });
    }

    private function isLastStep($document)
    {
        return !DocumentWorkflow::where('document_id', $document->id)
            ->where('status', 'pending')
            ->exists();
    }

    private function logAction($docId, $action, $desc) {
        DocumentLog::create([
            'document_id' => $docId,
            'user_id'     => Auth::id(),
            'action'      => $action,
            'description' => $desc,
        ]);
    }

    private function sendNotification($toUserId, $signer, $document) {
        if ($toUserId) {
            Notification::create([
                'user_id' => $toUserId,
                'type' => 'signed',
                'message' => "{$signer->name} подписал документ: {$document->title}",
                'is_read' => false,
                'notifiable_type' => User::class,
                'notifiable_id' => $toUserId,
                'data' => ['document_id' => $document->id]
            ]);
        }
    }

    private function processWorkflow($document, $currentWorkflow, $signer) {
        if ($currentWorkflow) {
            $currentWorkflow->update(['status' => 'approved']);
            $next = DocumentWorkflow::where('document_id', $document->id)
                ->where('step_order', '>', $currentWorkflow->step_order)
                ->orderBy('step_order')->first();

            if ($next) {
                $next->update(['status' => 'pending']);
            } else {
                $document->update(['status' => 'approved']);
            }
        }
    }

    public function show(DocumentSignature $signature) {
        return view('signatures.show', compact('signature'));
    }

    public function edit(DocumentSignature $signature) {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) abort(403);
        return view('signatures.edit', compact('signature'));
    }

    public function destroy(DocumentSignature $signature) {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) abort(403);

        if ($signature->document->file_path) {
            Storage::disk('public')->delete($signature->document->file_path);
        }
        if ($signature->signature) {
            Storage::disk('public')->delete($signature->signature);
        }

        $signature->delete();
        return back()->with('success', 'Запись удалена');
    }
}
