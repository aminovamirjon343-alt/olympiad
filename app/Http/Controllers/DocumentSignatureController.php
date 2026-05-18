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
// Импортируем классы PHPWord для работы со штампами в DOCX
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

        // Проверка очереди подписания (Workflow)
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

        // Сборка метаданных для QR-кода
        $qrData = "DocSign | ";
        $qrData .= "DOC: {$document->title} | ";
        $qrData .= "SENDER: {$senderName} ({$senderEmail}) | ";
        $qrData .= "SIGNED BY: {$signerName} ({$signerEmail}) | ";
        $qrData .= "SENT AT: {$sentDate} | ";
        $qrData .= "SIGNED AT: {$signedDate}";

        $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));

        try {
            return DB::transaction(function () use ($document, $signer, $currentWorkflow, $qrData, $request, $extension) {

                // 🔥 1. МОДИФИКАЦИЯ И ВНЕДРЕНИЕ ШТАМПА В ДОКУМЕНТЫ WORD (.DOCX) - КАК В PDF
                if ($extension === 'docx') {

                    // Вызываем логику физического изменения Word файла
                    $result = $this->processDocxSigning($document, $qrData);

                    // Сохраняем информацию о подписи в БД
                    DocumentSignature::updateOrCreate(
                        ['document_id' => $document->id, 'user_id' => $signer->id],
                        ['signature' => $result['qr_path'], 'signed_at' => now()]
                    );

                    $this->processWorkflow($document, $currentWorkflow, $signer);

                    // Переопределяем file_path документа на новый подписанный файл
                    $document->update([
                        'file_path' => $result['docx_path'],
                        'status'    => ($this->isLastStep($document)) ? 'completed' : 'processing'
                    ]);

                    $this->logAction($document->id, 'signed', "В структуру файла DOCX внедрен штамп подписи: {$signer->name}");

                    return redirect()->route('signatures.index')->with('success', 'Документ Word успешно подписан, штамп внедрен в файл!');
                }

                // 🔥 2. СЛИЯНИЕ ШТАМПА С PDF ФАЙЛОМ
                if ($extension === 'pdf') {
                    $result = $this->processPdfSigning($document, $qrData, $request);

                    DocumentSignature::updateOrCreate(
                        ['document_id' => $document->id, 'user_id' => $signer->id],
                        ['signature' => $result['qr_path'], 'signed_at' => now()]
                    );

                    $this->processWorkflow($document, $currentWorkflow, $signer);

                    $document->update([
                        'file_path' => $result['pdf_path'],
                        'status'    => ($this->isLastStep($document)) ? 'completed' : 'processing'
                    ]);

                    $this->logAction($document->id, 'signed', "В файл PDF внедрен штамп подписи: {$signer->name}");

                    return redirect()->route('signatures.index')->with('success', 'Документ PDF успешно подписан и обновлен!');
                }

                // 🔥 3. ОБРАБОТКА ТАБЛИЦ EXCEL И ОСТАЛЬНЫХ ФОРМАТОВ (XLSX, XLS, RTF)
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

                $document->update([
                    'status' => ($this->isLastStep($document)) ? 'completed' : 'processing'
                ]);

                $this->logAction($document->id, 'signed', "Документ Excel/Таблица (" . strtoupper($extension) . ") подписан в системе: {$signer->name}");

                return redirect()->route('signatures.index')->with('success', 'Документ успешно подписан электронным штампом!');
            });
        } catch (Exception $e) {
            \Log::error("Ошибка сохранения подписи DocSign: " . $e->getMessage() . " в файле " . $e->getFile() . ":" . $e->getLine());
            return back()->withInput()->with('error', 'Критическая ошибка сохранения: ' . $e->getMessage());
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

        try {
            return DB::transaction(function () use ($qrData, $signature, $request, $document, $extension) {

                // Обновление подписи для DOCX
                if ($extension === 'docx') {
                    if ($signature->signature) {
                        Storage::disk('public')->delete($signature->signature);
                    }
                    if ($document->file_path) {
                        Storage::disk('public')->delete($document->file_path);
                    }

                    $result = $this->processDocxSigning($document, $qrData);

                    $document->update(['file_path' => $result['docx_path']]);
                    $signature->update([
                        'signature' => $result['qr_path'],
                        'signed_at' => now(),
                    ]);

                    return redirect()->route('signatures.show', $signature->id)->with('success', 'Файл Word и штамп обновлены!');
                }

                // Обновление подписи для PDF
                if ($extension === 'pdf') {
                    $result = $this->processPdfSigning($document, $qrData, $request);

                    Storage::disk('public')->delete([$document->file_path, $signature->signature]);

                    $document->update(['file_path' => $result['pdf_path']]);
                    $signature->update([
                        'signature' => $result['qr_path'],
                        'signed_at' => now(),
                    ]);

                    return redirect()->route('signatures.show', $signature->id)->with('success', 'Файл PDF и штамп обновлены!');
                }

                // Обновление подписи для Excel и прочих
                if ($signature->signature) {
                    Storage::disk('public')->delete($signature->signature);
                }

                $permanentQrName = 'signatures/qr_' . time() . '.svg';
                $qrCodeSvg = QrCode::format('svg')->size(300)->margin(1)->generate($qrData);
                File::put(storage_path('app/public/' . $permanentQrName), $qrCodeSvg);

                $signature->update([
                    'signature' => $permanentQrName,
                    'signed_at' => now(),
                ]);

                return redirect()->route('signatures.show', $signature->id)->with('success', 'Данные подписи обновлены!');
            });
        } catch (Exception $e) {
            return back()->with('error', 'Ошибка обновления: ' . $e->getMessage());
        }
    }

    public function destroy(DocumentSignature $signature) {
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) abort(403);

        $extension = strtolower(pathinfo($signature->document->file_path, PATHINFO_EXTENSION));
        // Удаляем файлы с диска как для PDF, так и для DOCX
        if (in_array($extension, ['pdf', 'docx'])) {
            Storage::disk('public')->delete($signature->document->file_path);
        }

        if ($signature->signature) {
            Storage::disk('public')->delete($signature->signature);
        }

        $signature->delete();
        return back()->with('success', 'Запись удалена');
    }

    /**
     * МОДЕРНИЗИРОВАННАЯ логика DOCX: Создает штамп ТОЧНО КАК В PDF (Компактный квадрат поверх текста)
     */
    /**
     * МОДЕРНИЗИРОВАННАЯ логика DOCX: Исправлено позиционирование штампа (как в PDF)
     */
    /**
     * МОДЕРНИЗИРОВАННАЯ логика DOCX: Исправлена ошибка с константой WIDTH_BIT.
     * Штамп идет строго за текстом компактным квадратом.
     */
    /**
     * МОДЕРНИЗИРОВАННАЯ логика DOCX: Штамп создается ГОРИЗОНТАЛЬНЫМ (двухколоночным),
     * полностью повторяя структуру штампа из PDF.
     */
    /**
     * МОДЕРНИЗИРОВАННАЯ логика DOCX: Штамп ставится точно по координатам перетаскивания (qr_x, qr_y)
     */
    private function processDocxSigning($document, $qrPayload, Request $request = null)
    {
        $originalPath = storage_path('app/public/' . $document->file_path);
        if (!File::exists($originalPath)) {
            throw new Exception("Исходный файл Word не найден по пути: " . $originalPath);
        }

        // 1. Создаем временную директорию для PNG штампа
        $tempDir = storage_path('app/temp_sigs');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }
        $tempQrPath = $tempDir . '/' . uniqid() . '.png';

        // Стабильное получение QR-кода через API
        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrPayload);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $qrApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $content = curl_exec($ch);
        curl_close($ch);

        if (!$content) {
            $content = @file_get_contents($qrApiUrl);
        }
        if (!$content) {
            throw new Exception("Не удалось сгенерировать PNG штамп для Word.");
        }
        File::put($tempQrPath, $content);

        // 2. Загружаем документ Word
        try {
            $phpWord = IOFactory::load($originalPath);
        } catch (Exception $e) {
            $phpWord = new PhpWord();
        }

        $sections = $phpWord->getSections();
        $section = count($sections) > 0 ? $sections[count($sections) - 1] : $phpWord->addSection();

        // 3. ТОЧНЫЙ РАСЧЕТ КООРДИНАТ (Перевод процентов с фронтенда в Твипы Word)
        // Стандартный лист А4 в PHPWord: 11906 x 16838 twips
        $pageW = 11906;
        $pageH = 16838;

        // Компактная фиксированная ширина штампа-кубика (около 3.5 см = ~2000 twips)
        $stampWidthTwips = 2000;

        if ($request && $request->filled('qr_x') && $request->filled('qr_y') && $request->input('qr_x') !== 'NaN') {
            $pctX = (float)$request->input('qr_x');
            $pctY = (float)$request->input('qr_y');

            $x = ($pctX / 100) * $pageW;
            $y = ($pctY / 100) * $pageH;
        } else {
            // Если координаты не пришли, аккуратно смещаем в правый нижний угол
            $margin = 850;
            $x = $pageW - $stampWidthTwips - $margin;
            $y = $pageH - $stampWidthTwips - $margin;
        }

        // Защита от вылета за границы страницы листа (как в PDF контроллере)
        if ($x > ($pageW - $stampWidthTwips)) $x = $pageW - $stampWidthTwips;
        if ($y > ($pageH - $stampWidthTwips)) $y = $pageH - $stampWidthTwips;
        if ($x < 0) $x = 0;
        if ($y < 0) $y = 0;

        // 4. СТРОИМ ВЕРТИКАЛЬНЫЙ ШТАМП-КУБИК (Вариант 2)
        $tableStyle = [
            'borderColor'  => '000000', // Черная или темно-синяя строгая рамка, как на скриншоте 2
            'borderSize'   => 8,         // Толщина рамки
            'cellMargin'   => 50,        // Минимальные внутренние отступы
            'position'     => [
                'posHorizontal' => 'left',
                'posVertical'   => 'top',
                'horzAnchor'    => 'page',  // Считаем абсолютно от краев страницы
                'vertAnchor'    => 'page',
                'leftFromText'  => (int)$x,
                'topFromText'   => (int)$y,
                'overlap'       => 'never'
            ]
        ];

        $table = $section->addTable($tableStyle);

        // Ряд 1: Большой QR-код сверху
        $row1 = $table->addRow();
        $cell1 = $row1->addCell($stampWidthTwips);
        $cell1->addImage($tempQrPath, [
            'width'     => 75, // Оптимальный размер картинки внутри рамки
            'height'    => 75,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

        // Ряд 2: Текст верификации (Строго под QR по центру)
        $row2 = $table->addRow();
        $cell2 = $row2->addCell($stampWidthTwips);
        $cell2->addText(
            "VERIFIED DOCSIGN",
            ['bold' => true, 'size' => 6, 'color' => '1A365D'],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore' => 30, 'spaceAfter' => 10]
        );

        // Ряд 3: Дата подписания без лишнего текста
        $row3 = $table->addRow();
        $cell3 = $row3->addCell($stampWidthTwips);
        $cell3->addText(
            now()->format('d.m.Y H:i'),
            ['size' => 5.5, 'color' => '505050'],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 20]
        );

        // 5. Сохранение и финализация путей
        $newFileName = 'documents/signed_' . time() . '.docx';
        $permanentQrName = 'signatures/qr_' . time() . '.png';

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/' . $newFileName));

        $publicSigsPath = storage_path('app/public/signatures');
        if (!File::exists($publicSigsPath)) {
            File::makeDirectory($publicSigsPath, 0755, true, true);
        }
        File::move($tempQrPath, storage_path('app/public/' . $permanentQrName));

        return [
            'docx_path' => $newFileName,
            'qr_path'   => $permanentQrName
        ];
    }
    /**
     * Приватная логика слияния штампа с PDF файлом
     */
    private function processPdfSigning($document, $qrPayload, Request $request = null)
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

        if (!$content) {
            $content = @file_get_contents($qrApiUrl);
        }

        if (!$content) throw new Exception("Ошибка API QR-кодов. Не удалось получить штамп.");
        File::put($tempImgPath, $content);

        $originalPath = storage_path('app/public/' . $document->file_path);
        if (!File::exists($originalPath)) throw new Exception("Файл PDF не найден по пути: " . $originalPath);

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false);

        $pageCount = $pdf->setSourceFile($originalPath);
        $targetPage = ($request && $request->filled('target_page')) ? (int)$request->input('target_page') : $pageCount;

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            if ($pageNo === $targetPage) {
                $stampW = 35;
                $stampH = 35;
                $qrSize = 25;

                if ($request && $request->filled('qr_x') && $request->filled('qr_y') && $request->input('qr_x') !== 'NaN') {
                    $pctX = (float)$request->input('qr_x');
                    $pctY = (float)$request->input('qr_y');

                    $x = ($pctX / 100) * $size['width'];
                    $y = ($pctY / 100) * $size['height'];
                } else {
                    $margin = 15;
                    $x = $size['width'] - $stampW - $margin;
                    $y = $size['height'] - $stampH - $margin;
                }

                if ($x > ($size['width'] - $stampW)) $x = $size['width'] - $stampW;
                if ($y > ($size['height'] - $stampH)) $y = $size['height'] - $stampH;
                if ($x < 0) $x = 0;
                if ($y < 0) $y = 0;

                $pdf->setCellPaddings(0, 0, 0, 0);

                $brandColorR = 26;
                $brandColorG = 54;
                $brandColorB = 93;

                $pdf->SetFillColor(255, 255, 255);
                $pdf->Rect($x, $y, $stampW, $stampH, 'F');

                $pdf->SetDrawColor($brandColorR, $brandColorG, $brandColorB);
                $pdf->SetLineWidth(0.3);
                $pdf->Rect($x, $y, $stampW, $stampH, 'D');

                $pdf->Image($tempImgPath, $x + 5, $y + 2, $qrSize, $qrSize, 'PNG');

                $pdf->SetFont('helvetica', 'B', 5);
                $pdf->SetTextColor($brandColorR, $brandColorG, $brandColorB);
                $pdf->SetXY($x, $y + $qrSize + 3);
                $pdf->Cell($stampW, 2.5, "VERIFIED DOCSIGN", 0, 0, 'C');

                $pdf->SetFont('helvetica', '', 4.5);
                $pdf->SetTextColor(80, 80, 80);
                $pdf->SetXY($x, $y + $qrSize + 5.5);
                $pdf->Cell($stampW, 2.5, now()->format('d.m.Y H:i'), 0, 0, 'C');
            }
        }

        $newFileName = 'documents/signed_' . time() . '.pdf';
        $permanentQrName = 'signatures/qr_' . time() . '.png';

        $pdf->Output(storage_path('app/public/' . $newFileName), 'F');

        $publicSigsPath = storage_path('app/public/signatures');
        if (!File::exists($publicSigsPath)) {
            File::makeDirectory($publicSigsPath, 0755, true, true);
        }

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

            if ($next) {
                $next->update(['status' => 'pending']);
            }
        }
    }
}
