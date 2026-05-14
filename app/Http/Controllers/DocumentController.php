<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentComment;
use App\Models\DocumentLog;
use App\Models\DocumentSignature;
use App\Models\Notification;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use setasign\Fpdi\Tcpdf\Fpdi;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

class DocumentController extends Controller
{
    /**
     * Скачивание Word версии (.docx), сгенерированной из БД
     */
    public function downloadWord($id)
    {
        $document = Document::with(['createdBy', 'receiver', 'signatures.user'])->findOrFail($id);

        $phpWord = new PhpWord();

        $properties = $phpWord->getDocInfo();
        $properties->setTitle($document->title ?? 'Документ');
        $properties->setDescription('Сгенерировано в системе ЭДО');

        $section = $phpWord->addSection([
            'paperSize' => 'A4',
            'marginLeft' => 1134,
            'marginRight' => 1134,
            'marginTop' => 1134,
            'marginBottom' => 1134,
        ]);

        $phpWord->addTitleStyle(1, ['name' => 'Arial', 'size' => 18, 'bold' => true, 'color' => '1A365D'], ['spaceAfter' => 240]);
        $bodyStyle = ['name' => 'Arial', 'size' => 11, 'color' => '2D3748'];
        $metaStyle = ['name' => 'Arial', 'size' => 10, 'italic' => true, 'color' => '718096'];

        $section->addTitle($document->title, 1);
        $section->addText('Номер документа: ' . ($document->number ?? 'Б/Н'), ['bold' => true] + $bodyStyle);
        $section->addText('Дата создания: ' . ($document->created_at ? $document->created_at->format('d.m.Y H:i') : now()->format('d.m.Y')), $metaStyle);
        $section->addText('Отправитель: ' . optional($document->createdBy)->name, $bodyStyle);
        $section->addText('Получатель: ' . optional($document->receiver)->name, $bodyStyle);

        $section->addTextBreak(2);

        $section->addText('ОСНОВНОЙ ТЕКСТ ДОКУМЕНТА:', ['bold' => true, 'size' => 12]);

        if (!empty($document->content)) {
            Html::addHtml($section, $document->content, false, false);
        } else {
            $section->addText('Содержимое документа отсутствует.', ['italic' => true]);
        }

        $section->addTextBreak(3);

        $section->addText('СТАТУС ЭЛЕКТРОННЫХ ПОДПИСЕЙ:', ['bold' => true, 'size' => 12]);

        $tableStyle = ['borderSize' => 6, 'borderColor' => 'CBD5E0', 'cellMargin' => 100];
        $phpWord->addTableStyle('SigTable', $tableStyle);
        $table = $section->addTable('SigTable');

        $table->addRow();
        $table->addCell(3000, ['bgColor' => 'EBF8FF'])->addText('Участник', ['bold' => true]);
        $table->addCell(3000, ['bgColor' => 'EBF8FF'])->addText('Роль', ['bold' => true]);
        $table->addCell(4000, ['bgColor' => 'EBF8FF'])->addText('Статус / Дата', ['bold' => true]);

        $table->addRow();
        $table->addCell(3000)->addText(optional($document->createdBy)->name);
        $table->addCell(3000)->addText('Автор / Отправитель');
        $table->addCell(4000)->addText('Создано ' . ($document->created_at ? $document->created_at->format('d.m.Y') : ''));

        foreach ($document->signatures as $sig) {
            $table->addRow();
            $table->addCell(3000)->addText(optional($sig->user)->name);
            $table->addCell(3000)->addText('Получатель / Подписант');

            if (!empty($sig->signature)) {
                $statusText = 'ПОДПИСАНО (' . ($sig->signed_at ? \Carbon\Carbon::parse($sig->signed_at)->format('d.m.Y H:i') : '') . ')';
                $table->addCell(4000)->addText($statusText, ['color' => '2F855A', 'bold' => true]);
            } else {
                $table->addCell(4000)->addText('Ожидает подписи', ['color' => 'C53030', 'italic' => true]);
            }
        }

        $fileName = 'document_' . ($document->number ?? $id) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword');

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

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
     * ПРОЦЕСС АВТОЗАПОЛНЕНИЯ: Чтение текста ИИ из PDF или Word (DOCX)
     */
    public function storeFromPdf(Request $request)
    {
        $request->validate(['pdf_file' => 'required|mimes:pdf,docx|max:10240']);

        $file = $request->file('pdf_file');
        $extension = strtolower($file->getClientOriginalExtension());
        $fullText = '';

        if ($extension === 'pdf') {
            // Используем автономный класс библиотеки, если она установлена (например, Smalot PdfParser)
            if (class_exists('\\Smalot\\PdfParser\\Parser')) {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($file->path());
                $fullText = $pdf->getText();
            } else {
                return response()->json(['status' => 'error', 'message' => 'Библиотека Smalot/PdfParser не установлена.'], 500);
            }
        } elseif ($extension === 'docx') {
            // Прямое чтение текста из структуры XML документа Word
            $zip = new \ZipArchive();
            if ($zip->open($file->path()) === true) {
                if (($index = $zip->locateName('word/document.xml')) !== false) {
                    $data = $zip->getFromIndex($index);
                    $fullText = strip_tags($data);
                }
                $zip->close();
            }
        }

        $response = Http::post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Ты помощник системы ЭДО. Твоя задача: прочитать текст документа и вернуть JSON с полями: title (название), content (основной текст в HTML), summary (краткое описание).'
                ],
                ['role' => 'user', 'content' => "Текст из документа:\n" . $fullText],
            ],
            'response_format' => ['type' => 'json_object'],
        ]);

        $aiResult = $response->json()['choices'][0]['message']['content'];
        $data = json_decode($aiResult, true);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Подписание Canvas-подписью (Поддерживает и PDF, и Word)
     */
    public function sign(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $signatureData = $request->input('signature');

        if (!$signatureData) return back()->with('error', 'Подпись не найдена!');

        $sigImage = str_replace('data:image/png;base64,', '', $signatureData);
        $sigImage = str_replace(' ', '+', $sigImage);
        $sigFileName = 'temp/sig_' . time() . '.png';
        Storage::disk('public')->put($sigFileName, base64_decode($sigImage));
        $fullPathToSig = storage_path('app/public/' . $sigFileName);
        $fullPathToFile = storage_path('app/public/' . $document->file_path);

        try {
            $extension = strtolower(pathinfo($fullPathToFile, PATHINFO_EXTENSION));

            // Если это документ Word (.docx) — сохраняем электронную подпись в БД без изменения самого файла
            if ($extension === 'docx') {
                DocumentSignature::updateOrCreate(
                    ['document_id' => $id, 'user_id' => Auth::id()],
                    ['signature' => $signatureData, 'signed_at' => now()]
                );

                if (file_exists($fullPathToSig)) unlink($fullPathToSig);
                return redirect()->route('documents.show', $id)->with('success', 'Документ Word успешно подписан!');
            }

            // Если это PDF — вшиваем изображение визуальной подписи на последнюю страницу
            $pdf = new Fpdi();
            $pdf->SetAutoPageBreak(false);
            $pageCount = $pdf->setSourceFile($fullPathToFile);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);

                if ($pageNo == $pageCount) {
                    $x = $size['width'] - 75;
                    $y = $size['height'] - 45;

                    $pdf->Image($fullPathToSig, $x, $y, 45, 20, 'PNG');

                    $pdf->SetFont('helvetica', 'I', 7);
                    $pdf->SetTextColor(80, 80, 80);
                    $pdf->Text($x + 2, $y + 22, 'Signed: ' . now()->format('d.m.Y H:i'));
                }
            }

            $content = $pdf->Output('', 'S');
            Storage::disk('public')->put($document->file_path, $content);

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
        $query = Document::visibleToAuth()->with(['user', 'receiver', 'signatures']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('number', 'LIKE', "%{$search}%");
            });
        }

        if ($request->type === 'incoming') {
            $query->where('receiver_id', $user->id);
        } elseif ($request->type === 'outgoing') {
            $query->where('created_by', $user->id);
        }

        if ($request->filled('status')) {
            $status = $request->status;

            if ($status === 'waiting') {
                $query->where('status', Document::STATUS_ACTIVE)
                    ->whereDoesntHave('signatures', function($sq) {
                        $sq->whereNotNull('signature')->where('signature', '!=', '');
                    });
            } elseif ($status === 'signed') {
                $query->where('status', Document::STATUS_ACTIVE)
                    ->whereHas('signatures', function($q) {
                        $q->whereNotNull('signature')->where('signature', '!=', '');
                    });
            } else {
                $query->where('status', $status);
            }
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

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
     * Создание нового документа (Принимает PDF и Word)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'status'         => 'required|in:draft,active',
            'receiver_email' => 'required|email',
            'file_path'      => 'nullable|file|mimes:pdf,docx|max:10240',
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
                'signature'   => '',
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

    /**
     * Скачивание прикрепленного к модели файла с сохранением оригинального расширения
     */
    public function pdf($id)
    {
        $document = Document::findOrFail($id);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);

            return Storage::disk('public')->download(
                $document->file_path,
                $document->title . '.' . $extension
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
        $document = Document::visibleToAuth()->findOrFail($id);
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
