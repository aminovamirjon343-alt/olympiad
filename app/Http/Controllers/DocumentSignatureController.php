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
use Illuminate\Support\Facades\DB; // Добавлено для транзакций
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
        // 1. Получаем ID из запроса
        $documentId = $request->query('document_id');

        // 2. Ищем документ. Если ID нет, берем первый доступный для подписи
        $document = Document::when($documentId, function($query) use ($documentId) {
            return $query->where('id', $documentId);
        })->first();

        // 3. Если вообще нет документов в базе — кидаем ошибку, чтобы страница не ломалась
        if (!$document) {
            return redirect()->route('documents.index')->with('error', 'Нет доступных документов для подписи.');
        }

        // 4. Получаем список документов для селекта
        $documents = Document::all();
        $users = User::all();

        return view('signatures.create', compact('document', 'documents', 'users'));
    }

    public function store(Request $request)
    {
        // 1. Валидация входных данных
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'signature'   => 'required|string' // Здесь приходит Base64 от Signature Pad
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

        // 4. Запуск транзакции для атомарности действий
        return DB::transaction(function () use ($request, $document, $signer, $currentWorkflow) {
            try {
                // А. Сохраняем саму картинку подписи как файл (для истории)
                $signatureData = $request->signature;
                $signaturePath = null;

                if (preg_match('/^data:image\/(\w+);base64,/', $signatureData, $type)) {
                    $data = substr($signatureData, strpos($signatureData, ',') + 1);
                    $data = base64_decode($data);
                    $fileName = 'sig_' . $document->id . '_' . $signer->id . '_' . time() . '.png';
                    $signaturePath = 'signatures/' . $fileName;

                    \Storage::disk('public')->put($signaturePath, $data);
                }

                // Б. Вшивание подписи в PDF (вызывает твой внутренний метод)
                // Метод должен вернуть путь к НОВОМУ файлу PDF
                $newPdfPath = $this->processPdfSigning($document, $request->signature);

                // В. Обновление документа (меняем путь к PDF на подписанный)
                // Если хочешь хранить историю версий, лучше создать отдельную таблицу под файлы
                $document->update([
                    'file_path' => $newPdfPath,
                    'status'    => ($currentWorkflow && $this->isLastStep($document)) ? 'completed' : $document->status
                ]);

                // Г. Создание записи о подписи
                // В методе store используй $signaturePath (путь к файлу)
                DocumentSignature::create([
                    'document_id' => $document->id,
                    'user_id'     => $signer->id,
                    'signature'   => $signaturePath, // ПУТЬ К ФАЙЛУ
                    'signed_at'   => now(),
                    'expires_at'  => $document->deadline ?? null,
                ]);

                // Д. Логирование, Уведомление и Воркфлоу
                $this->logAction($document->id, 'signed', "Документ подписан пользователем: {$signer->name}");

                // Уведомляем создателя документа
                $this->sendNotification($document->created_by, $signer, $document);

                // Двигаем воркфлоу на следующий шаг
                $this->processWorkflow($document, $currentWorkflow, $signer);

                return redirect()->route('signatures.index')->with('success', 'Документ успешно подписан и вшит в PDF!');

            } catch (\Exception $e) {
                // Если что-то пошло не так, удаляем созданный файл подписи, если он успел создаться
                if (isset($signaturePath)) {
                    \Storage::disk('public')->delete($signaturePath);
                }

                // Бросаем исключение дальше для отката транзакции или логируем
                \Log::error("Ошибка при подписании документа ID {$document->id}: " . $e->getMessage());

                return back()->with('error', 'Ошибка при обработке PDF: ' . $e->getMessage());
            }
        });
    }

    /**
     * Вспомогательный метод для проверки, является ли этот шаг последним
     */
    private function isLastStep($document)
    {
        return !DocumentWorkflow::where('document_id', $document->id)
            ->where('status', 'pending')
            ->exists();
    }
    public function update(Request $request, DocumentSignature $signature)
    {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'signature' => 'required|string',
            'title'     => 'nullable|string|max:255'
        ]);

        $document = $signature->document;

        return DB::transaction(function () use ($request, $document, $signature) {
            if ($request->filled('title')) {
                $document->update(['title' => $request->title]);
            }

            try {
                // Вшиваем новую подпись (создается новый файл)
                $newFileName = $this->processPdfSigning($document, $request->signature);

                // Удаляем старый файл, чтобы не засорять память
                if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }

                // Обновляем пути в БД
                $document->update(['file_path' => $newFileName]);

                $signature->update([
                    'signature' => $request->signature,
                    'signed_at' => now(),
                ]);

                return redirect()->route('signatures.show', $signature->id)
                    ->with('success', 'Подпись успешно обновлена!');

            } catch (\Exception $e) {
                return back()->with('error', 'Ошибка при обновлении: ' . $e->getMessage());
            }
        });
    }
    protected function processPdfSigning($document, $base64Signature)
    {
        // 1. Подготовка временной папки и декодирование base64
        $tempDir = storage_path('app/temp_sigs');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $imgData = preg_replace('#^data:image/\w+;base64,#i', '', $base64Signature);
        $imgData = str_replace(' ', '+', $imgData);
        $tempImgPath = $tempDir . '/' . uniqid() . '.png';
        File::put($tempImgPath, base64_decode($imgData));

        $pdf = new \setasign\Fpdi\Fpdi();
        $originalPath = storage_path('app/public/' . $document->file_path);

        if (!File::exists($originalPath)) {
            if (File::exists($tempImgPath)) File::delete($tempImgPath);
            throw new \Exception("Файл PDF не найден по пути: " . $document->file_path);
        }

        try {
            $pageCount = $pdf->setSourceFile($originalPath);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);

                // Накладываем изменения только на последнюю страницу
                if ($pageNo === $pageCount) {
                    // Размеры области подписи
                    $sigW = 45; // Ширина картинки
                    $sigH = 20; // Высота картинки

                    // Координаты (подняли выше, чтобы не перекрывать футер)
                    $x = $size['width'] - $sigW - 20;
                    $y = $size['height'] - $sigH - 40;

                    // --- ШАГ 1: ОЧИСТКА СТАРОЙ ОБЛАСТИ ---
                    // Устанавливаем белый цвет заливки (RGB)
                    $pdf->SetFillColor(255, 255, 255);
                    // Рисуем белый прямоугольник без рамки ('F'), который закроет старую подпись
                    // Делаем его чуть больше самой подписи, чтобы скрыть и старую дату
                    $pdf->Rect($x - 5, $y - 5, $sigW + 10, $sigH + 15, 'F');

                    // --- ШАГ 2: ВСТАВКА НОВОЙ ПОДПИСИ ---
                    $pdf->Image($tempImgPath, $x, $y, $sigW);

                    // --- ШАГ 3: ДОБАВЛЕНИЕ НОВОЙ ДАТЫ ---
                    $pdf->SetFont('Arial', 'I', 8);
                    $pdf->SetTextColor(80, 80, 80); // Цвет текста чуть мягче черного

                    $dateText = "Signed: " . date('d.m.Y H:i');

                    // Рассчитываем центр текста относительно подписи
                    $textWidth = $pdf->GetStringWidth($dateText);
                    $textX = $x + ($sigW / 2) - ($textWidth / 2);
                    $textY = $y + $sigH + 4; // 4 мм ниже картинки

                    $pdf->Text($textX, $textY, $dateText);
                }
            }

            // Сохранение нового файла
            $newFileName = 'documents/signed_' . time() . '.pdf';
            $newFullPath = storage_path('app/public/' . $newFileName);

            // Убедимся, что директория существует
            if (!File::exists(storage_path('app/public/documents'))) {
                File::makeDirectory(storage_path('app/public/documents'), 0755, true);
            }

            $pdf->Output($newFullPath, 'F');

            return $newFileName;

        } catch (\Exception $e) {
            throw new \Exception("Ошибка при работе с PDF: " . $e->getMessage());
        } finally {
            // Удаляем временное изображение подписи в любом случае
            if (File::exists($tempImgPath)) {
                File::delete($tempImgPath);
            }
        }
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

        // Опционально: удаляем файл при удалении записи
        if ($signature->document->file_path) {
            Storage::disk('public')->delete($signature->document->file_path);
        }

        $signature->delete();
        return back()->with('success', 'Запись удалена');
    }
}
