<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentComment;
use App\Models\DocumentLog;
use App\Models\DocumentSignature;
use App\Models\Notification;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use http\Header\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use League\Uri\Http;
use setasign\Fpdi\Tcpdf\Fpdi;

class DocumentController extends Controller
{
    /**
     * Скачивание PDF версии (генерация из Blade)
     */
    public function downloadPdf($id)
    {
        $document = Document::with(['createdBy', 'receiver', 'signatures'])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.document', compact('document'));
        return $pdf->download('document_' . ($document->number ?? $id) . '.pdf');
    }

    /**
     * ПРОЦЕСС ПОДПИСАНИЯ: Вшивание Canvas-подписи в существующий PDF
     */
    public function storeFromPdf(Request $request)
    {
        $request->validate(['pdf_file' => 'required|mimes:pdf|max:10240']);

        // 1. Парсим PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('pdf_file')->path());
        $fullText = $pdf->getText();

        // 2. Отправляем текст в AI
        // Если используете локальный Ollama, адрес обычно http://localhost:11434/api/generate
        $response = Http::post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Ты помощник системы ЭДО. Твоя задача: прочитать текст документа и вернуть JSON с полями: title (название), content (основной текст в HTML), summary (краткое описание).'
                ],
                ['role' => 'user', 'content' => "Текст из PDF:\n" . $fullText],
            ],
            'response_format' => ['type' => 'json_object'],
        ]);

        $aiResult = $response->json()['choices'][0]['message']['content'];
        $data = json_decode($aiResult, true);

        // 3. Возвращаем данные на фронт, чтобы пользователь мог проверить перед сохранением
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function sign(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $signatureData = $request->input('signature');

        if (!$signatureData) return back()->with('error', 'Подпись не найдена!');

        // 1. Подготовка изображений
        $sigImage = str_replace('data:image/png;base64,', '', $signatureData);
        $sigImage = str_replace(' ', '+', $sigImage);
        $sigFileName = 'temp/sig_' . time() . '.png';
        Storage::disk('public')->put($sigFileName, base64_decode($sigImage));
        $fullPathToSig = storage_path('app/public/' . $sigFileName);
        $fullPathToPdf = storage_path('app/public/' . $document->file_path);

        try {
            $pdf = new Fpdi();
            // ВАЖНО: Отключаем авто-перенос страницы, чтобы не создавался лишний лист
            $pdf->SetAutoPageBreak(false);

            $pageCount = $pdf->setSourceFile($fullPathToPdf);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);

                // Вшиваем подпись ТОЛЬКО на последнюю страницу
                if ($pageNo == $pageCount) {
                    // Позиция: справа внизу
                    $x = $size['width'] - 75;
                    $y = $size['height'] - 45;

                    // Рисуем подпись
                    $pdf->Image($fullPathToSig, $x, $y, 45, 20, 'PNG');

                    // Добавляем дату (как на картинке 3b3c37.png)
                    $pdf->SetFont('helvetica', 'I', 7);
                    $pdf->SetTextColor(80, 80, 80);
                    $pdf->Text($x + 2, $y + 22, 'Signed: ' . now()->format('d.m.Y H:i'));
                }
            }

            // Сохраняем обновленный файл
            $content = $pdf->Output('', 'S');
            Storage::disk('public')->put($document->file_path, $content);

            // Обновляем запись в БД
            DocumentSignature::updateOrCreate(
                ['document_id' => $id, 'user_id' => Auth::id()],
                ['signature' => $signatureData, 'signed_at' => now()]
            );

        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка: ' . $e->getMessage());
        } finally {
            if (file_exists($fullPathToSig)) unlink($fullPathToSig);
        }

        return redirect()->route('documents.show', $id)->with('success', 'Документ успешно подписан!');
    }
    /**
     * Статистика для Dashboard
     */
    public function getStats()
    {
        $totalDocs = Document::visibleToAuth()->count();
        $previousDocsCount = Document::visibleToAuth()
            ->where('created_at', '<', now()->startOfMonth())
            ->count();

        $docsGrowth = $previousDocsCount > 0
            ? round((($totalDocs - $previousDocsCount) / $previousDocsCount) * 100, 1)
            : ($totalDocs > 0 ? 100 : 0);

        return view('dashboard', compact('totalDocs', 'docsGrowth'));
    }

    /**
     * Список документов с фильтрами
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Используем наш Scope, который мы прописали в модели
        $query = Document::visibleToAuth()->with(['user', 'receiver', 'signatures']);

        // 1. Поиск (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('number', 'LIKE', "%{$search}%");
            });
        }

        // 2. Фильтр Входящие / Исходящие
        if ($request->type === 'incoming') {
            $query->where('receiver_id', $user->id);
        } elseif ($request->type === 'outgoing') {
            $query->where('created_by', $user->id);
        }

        // 3. СТРОГИЙ ФИЛЬТР ПО СТАТУСУ (Исправляем тут)
        if ($request->filled('status')) {
            $status = $request->status;

            if ($status === 'waiting') {
                // Ожидающие: статус active + нет подписи
                $query->where('status', Document::STATUS_ACTIVE)
                    ->whereDoesntHave('signatures', function($sq) {
                        $sq->whereNotNull('signature')->where('signature', '!=', '');
                    });
            } elseif ($status === 'signed') {
                // Подписанные: статус active + есть подпись
                $query->where('status', Document::STATUS_ACTIVE)
                    ->whereHas('signatures', function($q) {
                        $q->whereNotNull('signature')->where('signature', '!=', '');
                    });
            } else {
                // Для draft или rejected используем прямое сравнение
                $query->where('status', $status);
            }
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        // Счётчики для плиток (чтобы цифры в меню были правильные)
        $totalDocs = Document::visibleToAuth()->count();
        $activeCount = Document::visibleToAuth()->where('status', 'active')->count();
        $draftCount = Document::visibleToAuth()->where('status', 'draft')->count();
        $usersCount = User::count();

        return view('document.index', compact(
            'documents', 'totalDocs', 'activeCount', 'draftCount', 'usersCount'
        ));
    }

    public function create()
    {
        return view('document.create', ['users' => User::all()]);
    }

    /**
     * Создание нового документа
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'status'         => 'required|in:draft,active',
            'receiver_email' => 'required|email',
            'file_path'      => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $receiver = User::where('email', $request->receiver_email)->first();
        if (!$receiver) {
            return back()->withErrors(['receiver_email' => 'Пользователь не найден!'])->withInput();
        }

        $filePath = $request->file('file_path')
            ? $request->file('file_path')->store('documents', 'public')
            : null;

        $document = Document::create([
            'number'      => $request->number,
            'title'       => $request->title,
            'content'     => $request->content,
            'type'        => $request->type ?? 'document',
            'status'      => $request->status,
            'file_path'   => $filePath,
            'user_id'     => Auth::id(),
            'created_by'  => Auth::id(),
            'receiver_id' => $receiver->id,
            'deadline'    => $request->deadline,
        ]);

        if ($request->status === 'active') {
            DocumentSignature::create([
                'document_id' => $document->id,
                'user_id'     => $receiver->id,
                'signature'   => $signaturePath ?? '',
            ]);

            Notification::create([
                'user_id' => $receiver->id,
                'type' => 'assigned',
                'message' => 'Новый документ на подпись: ' . $document->title,
                'data' => ['document_id' => $document->id],
                'notifiable_type' => User::class,
                'notifiable_id' => $receiver->id,
            ]);
        }

        return redirect()->route('documents.index')->with('success', 'Документ создан!');
    }
    public function pdf($id)
    {
        $document = Document::findOrFail($id);

        // Проверяем, существует ли файл физически
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download(
                $document->file_path,
                $document->title . '.pdf'
            );
        }

        return back()->with('error', 'Файл не найден');
    }
    public function show($id)
    {
        $document = Document::visibleToAuth()
            ->with(['createdBy', 'receiver', 'logs', 'signatures.user'])
            ->findOrFail($id);

        $comments = DocumentComment::with('user')->where('document_id', $id)->latest()->get();

        return view('document.show', compact('document', 'comments'));
    }

    public function edit($id)
    {
        // Находим документ или возвращаем 404, если его нет
        $document = Document::visibleToAuth()->findOrFail($id);

        // Здесь можно также подгрузить данные для выпадающих списков, если они есть (например, типы документов)
        return view('document.edit', compact('document'));
    }
    public function update(Request $request, Document $document)
    {
        if ($document->created_by !== Auth::id()) abort(403);

        $oldStatus = $document->status;
        $document->update($request->only(['number', 'title', 'content', 'status', 'deadline']));

        if ($oldStatus === 'draft' && $request->status === 'active') {
            DocumentSignature::updateOrCreate(
                ['document_id' => $document->id, 'user_id' => $document->receiver_id],
                ['signature' => '']
            );
        }

        return redirect()->route('documents.index')->with('success', 'Документ обновлен!');
    }

    public function destroy(Document $document)
    {
        // Разрешаем, если пользователь автор ИЛИ он админ
        if ($document->created_by !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'У вас нет прав на удаление этого документа');
        }

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();
        return back()->with('success', 'Документ удален!');
    }


}
