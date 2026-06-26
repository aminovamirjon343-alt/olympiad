@extends('layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
<script src="https://unpkg.com/docx-preview/dist/docx-preview.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';
</script>

<style>
    .sig-container {
        font-family: 'Inter', sans-serif !important;
        min-height: 100vh;
        padding: 32px 24px;
        color: var(--text);
    }

    /* === LAYOUT === */
    .sig-layout {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        align-items: start;
    }

    @media (min-width: 1024px) {
        .sig-layout {
            grid-template-columns: 380px 1fr;
        }
    }

    /* === LEFT PANEL === */
    .sig-panel {
        position: relative;
        background: linear-gradient(180deg, rgba(255,255,255,0.035), rgba(255,255,255,0.01));
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 22px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .sig-panel::before {
        content: "";
        position: absolute;
        inset: -1px;
        border-radius: var(--radius);
        padding: 1px;
        background: linear-gradient(135deg, rgba(var(--glow),0.4), transparent 40%, transparent 60%, rgba(var(--glow),0.2));
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0.6;
        pointer-events: none;
    }

    .sig-panel-title {
        font-size: 16px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--text);
        margin: 0 0 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sig-panel-title::before {
        content: "";
        width: 3px;
        height: 18px;
        background: linear-gradient(180deg, rgba(var(--glow), 1), rgba(var(--glow), 0.3));
        border-radius: 2px;
        box-shadow: 0 0 8px rgba(var(--glow), 0.6);
    }

    /* Info box */
    .info-box {
        background: linear-gradient(135deg, rgba(var(--glow), 0.15), rgba(var(--glow), 0.05));
        border: 1px solid rgba(var(--glow), 0.3);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 18px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(var(--glow), 0.1), inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .info-box::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(var(--glow), 0.8), transparent);
    }

    .info-box h3 {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: rgba(var(--glow), 1);
        margin: 0 0 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-box h3 i {
        font-size: 14px;
        filter: drop-shadow(0 0 4px rgba(var(--glow), 0.6));
    }

    .info-box p {
        font-size: 12px;
        line-height: 1.6;
        color: var(--text);
        margin: 0 0 6px;
        font-weight: 500;
    }

    .info-box p:last-child {
        margin-bottom: 0;
        font-size: 11px;
        color: var(--muted);
    }

    .info-box p strong {
        color: var(--text);
        font-weight: 700;
    }

    /* Select */
    .sig-select-wrapper {
        margin-bottom: 18px;
    }

    .sig-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--muted);
        margin-bottom: 8px;
        display: block;
    }

    .sig-label .required {
        color: #ff6363;
        margin-left: 2px;
    }

    .sig-select {
        width: 100%;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 12px 14px;
        color: var(--text);
        font-size: 13px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238892a6' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    .sig-select option {
        background: #161a26;
        color: var(--text);
    }

    .sig-select:focus {
        border-color: rgba(var(--glow), 0.6);
        box-shadow: 0 0 0 3px rgba(var(--glow), 0.15), 0 0 12px rgba(var(--glow), 0.1);
        background: rgba(255,255,255,0.05);
    }

    /* === DEADLINE SECTION === */
    .deadline-section {
        margin-bottom: 18px;
        padding: 14px;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--line);
        border-radius: 12px;
        transition: all 0.25s ease;
    }

    .deadline-section:hover {
        border-color: rgba(var(--glow), 0.3);
        background: rgba(var(--glow), 0.03);
    }

    .deadline-section.error {
        border-color: rgba(255, 99, 99, 0.5);
        background: rgba(255, 99, 99, 0.05);
    }

    .deadline-section.warning {
        border-color: rgba(255, 181, 71, 0.5);
        background: rgba(255, 181, 71, 0.05);
    }

    .deadline-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .deadline-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .deadline-label .required {
        color: #ff6363;
    }

    .deadline-label i {
        font-size: 12px;
        color: rgba(var(--glow), 1);
    }

    .deadline-input-wrapper {
        position: relative;
    }

    .deadline-input {
        width: 100%;
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--line);
        border-radius: 8px;
        padding: 10px 12px;
        color: var(--text);
        font-size: 13px;
        font-weight: 600;
        font-family: 'JetBrains Mono', monospace;
        outline: none;
        transition: all 0.2s ease;
    }

    .deadline-input:focus {
        border-color: rgba(var(--glow), 0.6);
        box-shadow: 0 0 0 3px rgba(var(--glow), 0.15);
        background: rgba(255,255,255,0.06);
    }

    .deadline-input::-webkit-calendar-picker-indicator {
        filter: invert(0.8);
        cursor: pointer;
    }

    .deadline-status {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
        font-size: 11px;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 6px;
    }

    .deadline-status.hidden {
        display: none;
    }

    .deadline-status.ok {
        background: rgba(76, 217, 130, 0.1);
        color: #4cd982;
        border: 1px solid rgba(76, 217, 130, 0.25);
    }

    .deadline-status.warning {
        background: rgba(255, 181, 71, 0.1);
        color: #ffb547;
        border: 1px solid rgba(255, 181, 71, 0.25);
    }

    .deadline-status.error {
        background: rgba(255, 99, 99, 0.1);
        color: #ff6363;
        border: 1px solid rgba(255, 99, 99, 0.25);
    }

    .deadline-status i {
        font-size: 13px;
    }

    .deadline-error-text {
        font-size: 10px;
        color: #ff6363;
        margin-top: 6px;
        font-weight: 600;
        display: none;
    }

    .deadline-error-text.show {
        display: block;
    }

    /* Quick deadline buttons */
    .deadline-quick {
        display: flex;
        gap: 6px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .deadline-quick-btn {
        flex: 1;
        min-width: 60px;
        padding: 6px 8px;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--line);
        border-radius: 6px;
        color: var(--muted);
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }

    .deadline-quick-btn:hover {
        border-color: rgba(var(--glow), 0.4);
        color: var(--text);
        background: rgba(var(--glow), 0.08);
    }

    .deadline-quick-btn.active {
        border-color: rgba(var(--glow), 0.6);
        color: rgba(var(--glow), 1);
        background: rgba(var(--glow), 0.15);
    }

    /* QR Preview */
    .qr-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--line);
        border-radius: 12px;
        margin-bottom: 18px;
    }

    .qr-info {
        flex: 1;
        min-width: 0;
    }

    .qr-title {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--muted);
        margin-bottom: 4px;
    }

    .qr-subtitle {
        font-size: 12px;
        font-weight: 700;
        color: var(--text);
    }

    .qr-preview-box {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        background: #ffffff;
        border: 2px solid rgba(var(--glow), 0.3);
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(var(--glow), 0.2), 0 0 0 1px rgba(255,255,255,0.05);
        flex-shrink: 0;
    }

    .qr-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    /* Format badge */
    .format-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #ffffff;
        font-family: 'JetBrains Mono', monospace;
        box-shadow: 0 0 10px currentColor;
    }

    .format-badge.pdf { background: #ff6363; color: #ff6363; }
    .format-badge.word { background: rgba(79, 140, 255, 1); color: rgba(79, 140, 255, 1); }
    .format-badge.excel { background: #4cd982; color: #4cd982; }
    .format-badge.rtf { background: #a78bfa; color: #a78bfa; }

    /* === RIGHT PANEL === */
    .sig-viewer-wrapper {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .viewer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .viewer-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .viewer-title::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(var(--glow), 1);
        box-shadow: 0 0 8px rgba(var(--glow), 0.8);
    }

    .btn-fullscreen {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--line);
        border-radius: 10px;
        color: var(--muted);
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-fullscreen:hover {
        color: var(--text);
        border-color: rgba(var(--glow), 0.4);
        background: rgba(var(--glow), 0.08);
        box-shadow: 0 0 12px rgba(var(--glow), 0.2);
    }

    /* Viewer container */
    .viewer-container {
        position: relative;
        background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
        border: 1px solid var(--line);
        border-radius: var(--radius);
        overflow: hidden;
        height: calc(100vh - 260px);
        min-height: 520px;
    }

    .viewer-container::before {
        content: "";
        position: absolute;
        inset: -1px;
        border-radius: var(--radius);
        padding: 1px;
        background: linear-gradient(135deg, rgba(var(--glow),0.4), transparent 40%, transparent 60%, rgba(var(--glow),0.2));
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0.6;
        pointer-events: none;
        z-index: 2;
    }

    .viewer-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 50;
    }

    .viewer-loading .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(255,255,255,0.1);
        border-top-color: rgba(var(--glow), 1);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        box-shadow: 0 0 20px rgba(var(--glow), 0.4);
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .document-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: auto;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        background: #0a0d14;
    }

    #previewViewport {
        width: 100%;
        height: 100%;
        overflow-y: auto;
        background: #0a0d14;
        transition: opacity 0.3s ease;
    }

    #word-preview {
        width: 100%;
        min-height: 100%;
        background: #fff;
        position: relative;
    }

    .docx-wrapper {
        background: transparent !important;
        padding: 0 !important;
    }

    .docx {
        width: 100% !important;
        min-height: 100% !important;
        padding: 20px !important;
        box-shadow: none !important;
    }

    .local-warning-box {
        display: none;
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(22, 26, 38, 0.98), rgba(16, 19, 28, 0.98));
        z-index: 30;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        color: var(--text);
    }

    .local-warning-box i {
        font-size: 48px;
        color: #ffb547;
        margin-bottom: 16px;
        filter: drop-shadow(0 0 12px rgba(255, 181, 71, 0.5));
    }

    .local-warning-box h4 {
        font-size: 18px;
        font-weight: 800;
        margin: 0 0 8px;
        color: var(--text);
    }

    .local-warning-box p {
        font-size: 13px;
        color: var(--muted);
        margin: 0 0 20px;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        background: linear-gradient(180deg, rgba(var(--glow), 0.95), rgba(var(--glow), 0.65));
        color: #0a0d14;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 8px 24px rgba(var(--glow), 0.35), inset 0 1px 0 rgba(255,255,255,0.3);
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(var(--glow), 0.5);
    }

    /* Submit button */
    .submit-wrapper {
        display: flex;
        justify-content: center;
    }

    .btn-submit {
        appearance: none;
        border: 1.5px solid rgba(var(--glow), 0.6);
        background: linear-gradient(180deg, rgba(var(--glow), 0.25), rgba(var(--glow), 0.1));
        color: #fff;
        font: 700 12px 'Inter', sans-serif;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 16px 32px;
        border-radius: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 0 20px rgba(var(--glow), 0.25), inset 0 1px 0 rgba(255,255,255,0.1);
        transition: all 0.25s ease;
        width: 100%;
        max-width: 360px;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .btn-submit:hover::before {
        transform: translateX(100%);
    }

    .btn-submit:hover {
        background: linear-gradient(180deg, rgba(var(--glow), 0.35), rgba(var(--glow), 0.15));
        border-color: rgba(var(--glow), 0.8);
        box-shadow: 0 0 28px rgba(var(--glow), 0.4), inset 0 1px 0 rgba(255,255,255,0.15);
        transform: translateY(-2px);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-submit i {
        font-size: 18px;
        filter: drop-shadow(0 0 6px rgba(var(--glow), 0.6));
    }

    /* Empty state */
    .viewer-empty {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        text-align: center;
        padding: 40px;
    }

    .viewer-empty i {
        font-size: 56px;
        opacity: 0.3;
        margin-bottom: 16px;
    }

    .viewer-empty p {
        font-size: 13px;
        font-weight: 600;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sig-container { padding: 20px 16px; }
        .sig-panel { padding: 18px; }
        .viewer-container { height: calc(100vh - 240px); min-height: 400px; }
    }
</style>

<div class="sig-container">
    <div class="sig-layout">

        {{-- ЛЕВАЯ ПАНЕЛЬ --}}
        <div class="sig-panel" style="position: sticky; top: 88px;">
            <h2 class="sig-panel-title" data-i18n="title">
                Подпись документа
            </h2>

            {{-- ИНФОРМАЦИОННЫЙ БЛОК --}}
            <div class="info-box">
                <h3>
                    <i class="bi bi-info-circle-fill"></i>
                    <span data-i18n="autoSignTitle">Автоматическая подпись</span>
                </h3>
                <p data-i18n="autoSignDesc">
                    QR-код с подписью будет автоматически размещён на <strong>последней странице</strong> документа в правом нижнем углу.
                </p>
                <p>
                    ✅ PDF — последняя страница<br>
                    ✅ DOCX — последняя страница<br>
                    ✅ XLSX — последний лист<br>
                    ✅ RTF — конвертируется в DOCX
                </p>
            </div>

            <form action="{{ route('signatures.store') }}" method="POST" id="signatureForm">
                @csrf

                <div class="sig-select-wrapper">
                    <label class="sig-label" data-i18n="selectDocument">
                        Выбор документа <span class="required">*</span>
                    </label>
                    <select name="document_id" id="documentSelect" class="sig-select" required>
                        <option value="" disabled {{ $documents->isEmpty() ? 'selected' : '' }} data-i18n="selectPlaceholder">
                            -- Список документов --
                        </option>
                        @foreach($documents as $index => $doc)
                        @php
                        $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                        $formatType = 'pdf';
                        if(in_array($ext,['doc','docx'])){ $formatType = 'word'; }
                        elseif(in_array($ext,['xls','xlsx'])){ $formatType = 'excel'; }
                        elseif($ext === 'rtf'){ $formatType = 'rtf'; }

                        $senderName = $doc->sender->name ?? 'Система';
                        $signerName = auth()->user()->name ?? 'Пользователь';
                        $dateSent = $doc->created_at ? $doc->created_at->format('d.m.Y H:i') : now()->format('d.m.Y H:i');

                        $qrText = "DocSign | DOC: {$doc->title} | SENDER: {$senderName} | SIGNED BY: {$signerName} | DATE: {$dateSent}";
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($qrText);
                        @endphp
                        <option value="{{ $doc->id }}"
                                {{ (request('document_id') == $doc->id) || (!request('document_id') && $index == 0 && !$documents->isEmpty()) ? 'selected' : '' }}
                        data-file="{{ asset('storage/'.$doc->file_path) }}"
                        data-type="{{ $formatType }}"
                        data-ext="{{ $ext }}"
                        data-qr="{{ $qrUrl }}"
                        data-qr-text="{{ $qrText }}"
                        data-signer="{{ $signerName }}"
                        data-deadline="{{ $doc->deadline ?? '' }}">
                        [{{ strtoupper($ext) }}] #{{ $doc->id }} — {{ $doc->title }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- DEADLINE SECTION --}}
                <div class="deadline-section" id="deadlineSection">
                    <div class="deadline-header">
                        <label class="deadline-label" for="deadline">
                            <i class="bi bi-calendar-event-fill"></i>
                            <span data-i18n="deadlineLabel">Срок подписания</span>
                            <span class="required">*</span>
                        </label>
                    </div>

                    <div class="deadline-input-wrapper">
                        <input type="date" name="deadline" id="deadline" class="deadline-input" required>
                    </div>

                    {{-- Quick buttons --}}
                    <div class="deadline-quick">
                        <button type="button" class="deadline-quick-btn" data-days="1" data-i18n="deadline1d">1 день</button>
                        <button type="button" class="deadline-quick-btn" data-days="3" data-i18n="deadline3d">3 дня</button>
                        <button type="button" class="deadline-quick-btn active" data-days="7" data-i18n="deadline7d">7 дней</button>
                        <button type="button" class="deadline-quick-btn" data-days="14" data-i18n="deadline14d">14 дней</button>
                        <button type="button" class="deadline-quick-btn" data-days="30" data-i18n="deadline30d">30 дней</button>
                    </div>

                    {{-- Status indicator --}}
                    <div class="deadline-status hidden" id="deadlineStatus">
                        <i class="bi bi-info-circle-fill"></i>
                        <span id="deadlineStatusText"></span>
                    </div>

                    <div class="deadline-error-text" id="deadlineError" data-i18n="deadlineError">
                        Срок должен быть в будущем
                    </div>
                </div>

                <div class="qr-section">
                    <div class="qr-info">
                        <div class="qr-title">QR CODE</div>
                        <div class="qr-subtitle" data-i18n="signatureCheck">Проверка подписи</div>
                    </div>
                    <div class="qr-preview-box">
                        <img id="qrPreview" src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=DocSign" alt="QR Preview">
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <span class="sig-label" style="margin: 0;" data-i18n="preview">Предпросмотр</span>
                    <span id="formatBadge" class="format-badge hidden"></span>
                </div>

                {{-- Submit button внутри формы --}}
                <div class="submit-wrapper" style="margin-top: 20px;">
                    <button type="submit" id="submitBtn" class="btn-submit">
                        <i class="bi bi-shield-check"></i>
                        <span data-i18n="applyStamp">Подписать документ</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ПРАВАЯ ПАНЕЛЬ --}}
        <div class="sig-viewer-wrapper">
            <div class="viewer-header">
                <div class="viewer-title" data-i18n="docPreview">Предпросмотр документа</div>
                <a id="fullScreenBtn" href="#" target="_blank" class="btn-fullscreen hidden">
                    <i class="bi bi-arrows-fullscreen"></i>
                    <span data-i18n="fullscreen">На весь экран</span>
                </a>
            </div>

            <div class="viewer-container">
                <div id="viewerLoader" class="viewer-loading">
                    <div class="spinner"></div>
                </div>

                <div id="localWarning" class="local-warning-box">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <h4 data-i18n="excelPreview">Excel Preview</h4>
                    <p data-i18n="officePreviewLocal">Office preview недоступен на localhost</p>
                    <a id="localDownloadFallback" href="#" download class="btn-download">
                        <i class="bi bi-download"></i>
                        <span data-i18n="downloadFile">Скачать файл</span>
                    </a>
                </div>

                <div class="document-wrapper" id="documentWrapper">
                    <div id="previewViewport">
                        <div id="renderTarget" style="width: 100%; height: 100%; position: relative;">
                            <div class="viewer-empty">
                                <i class="bi bi-file-earmark-text"></i>
                                <p data-i18n="selectDocPreview">Выберите документ для предпросмотра</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ============================================================
        // ЛОКАЛЬНЫЙ СЛОВАРЬ СТРАНИЦЫ ПОДПИСИ
        // ============================================================
        const SIGN_TRANSLATIONS = {
            ru: {
                title: 'Подпись документа',
                autoSignTitle: 'Автоматическая подпись',
                autoSignDesc: 'QR-код с подписью будет автоматически размещён на последней странице документа.',
                selectDocument: 'Выбор документа',
                selectPlaceholder: '-- Список документов --',
                signatureCheck: 'Проверка подписи',
                preview: 'Предпросмотр',
                docPreview: 'Предпросмотр документа',
                fullscreen: 'На весь экран',
                downloadFile: 'Скачать файл',
                applyStamp: 'Подписать документ',
                applyingStamp: 'Подписание...',
                selectAlert: 'Выберите документ!',
                selectDocPreview: 'Выберите документ для предпросмотра',
                excelPreview: 'Excel Preview',
                officePreviewLocal: 'Office preview недоступен на localhost',
                deadlineLabel: 'Срок подписания',
                deadline1d: '1 день',
                deadline3d: '3 дня',
                deadline7d: '7 дней',
                deadline14d: '14 дней',
                deadline30d: '30 дней',
                deadlineError: 'Срок должен быть в будущем',
                deadlineOk: 'Осталось {days} дн.',
                deadlineWarning: 'Осталось {days} дн. — скоро истекает',
                deadlineOverdue: 'Срок истёк',
                deadlineToday: 'Сегодня — последний день'
            },
            tj: {
                title: 'Имзои ҳуҷҷат',
                autoSignTitle: 'Имзои автоматикӣ',
                autoSignDesc: 'QR-коди имзо ба таври худкор дар саҳифаи охирини ҳуҷҷат ҷойгир мешавад.',
                selectDocument: 'Интихоби ҳуҷҷат',
                selectPlaceholder: '-- Рӯйхати ҳуҷҷатҳо --',
                signatureCheck: 'Санҷиши имзо',
                preview: 'Пешнамоиш',
                docPreview: 'Пешнамоиши ҳуҷҷат',
                fullscreen: 'Тамоми экран',
                downloadFile: 'Боргирии файл',
                applyStamp: 'Имзо кардан',
                applyingStamp: 'Имзо шуда истодааст...',
                selectAlert: 'Ҳуҷҷатро интихоб кунед!',
                selectDocPreview: 'Барои пешнамоиш ҳуҷҷатро интихоб кунед',
                excelPreview: 'Пешнамоиши Excel',
                officePreviewLocal: 'Пешнамоиши Office дар localhost дастрас нест',
                deadlineLabel: 'Муҳлати имзо',
                deadline1d: '1 рӯз',
                deadline3d: '3 рӯз',
                deadline7d: '7 рӯз',
                deadline14d: '14 рӯз',
                deadline30d: '30 рӯз',
                deadlineError: 'Муҳлат бояд дар оянда бошад',
                deadlineOk: '{days} рӯз монд',
                deadlineWarning: '{days} рӯз монд — наздик аст',
                deadlineOverdue: 'Муҳлат гузашт',
                deadlineToday: 'Имрӯз — рӯзи охирин'
            },
            en: {
                title: 'Document Signing',
                autoSignTitle: 'Automatic Signature',
                autoSignDesc: 'QR code with signature will be automatically placed on the last page of the document.',
                selectDocument: 'Select Document',
                selectPlaceholder: '-- Document List --',
                signatureCheck: 'Signature Verification',
                preview: 'Preview',
                docPreview: 'Document Preview',
                fullscreen: 'Full Screen',
                downloadFile: 'Download File',
                applyStamp: 'Sign Document',
                applyingStamp: 'Signing...',
                selectAlert: 'Please select a document!',
                selectDocPreview: 'Select a document to preview',
                excelPreview: 'Excel Preview',
                officePreviewLocal: 'Office preview is not available on localhost',
                deadlineLabel: 'Signing Deadline',
                deadline1d: '1 day',
                deadline3d: '3 days',
                deadline7d: '7 days',
                deadline14d: '14 days',
                deadline30d: '30 days',
                deadlineError: 'Deadline must be in the future',
                deadlineOk: '{days} days remaining',
                deadlineWarning: '{days} days left — expiring soon',
                deadlineOverdue: 'Deadline passed',
                deadlineToday: 'Today is the last day'
            }
        };

        // ============================================================
        // ФУНКЦИЯ ПОЛУЧЕНИЯ АКТУАЛЬНОГО СЛОВАРЯ
        // ============================================================
        function getCurrentDict() {
            const lang = localStorage.getItem('docsign_lang') || 'ru';
            return SIGN_TRANSLATIONS[lang] || SIGN_TRANSLATIONS.ru;
        }

        // ============================================================
        // ФУНКЦИЯ ПРИМЕНЕНИЯ ПЕРЕВОДОВ
        // ============================================================
        function applySignTranslations(lang) {
            const dict = SIGN_TRANSLATIONS[lang] || SIGN_TRANSLATIONS.ru;

            // 1) Переводим все элементы с data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dict[key] !== undefined) el.textContent = dict[key];
            });

            // 2) Переводим placeholder
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (dict[key] !== undefined) el.setAttribute('placeholder', dict[key]);
            });

            // 3) Переводим title
            document.querySelectorAll('[data-i18n-title]').forEach(el => {
                const key = el.getAttribute('data-i18n-title');
                if (dict[key] !== undefined) el.setAttribute('title', dict[key]);
            });

            // 4) Обновляем deadline status (если он видимый)
            updateDeadlineStatus();
        }

        // ============================================================
        // DOM ЭЛЕМЕНТЫ
        // ============================================================
        const form = document.getElementById('signatureForm');
        const select = document.getElementById('documentSelect');
        const deadlineInput = document.getElementById('deadline');
        const deadlineSection = document.getElementById('deadlineSection');
        const deadlineStatus = document.getElementById('deadlineStatus');
        const deadlineStatusText = document.getElementById('deadlineStatusText');
        const deadlineError = document.getElementById('deadlineError');
        const quickBtns = document.querySelectorAll('.deadline-quick-btn');

        const renderTarget = document.getElementById('renderTarget');
        const previewViewport = document.getElementById('previewViewport');
        const loader = document.getElementById('viewerLoader');
        const formatBadge = document.getElementById('formatBadge');
        const fullScreenBtn = document.getElementById('fullScreenBtn');
        const qrPreview = document.getElementById('qrPreview');
        const localWarning = document.getElementById('localWarning');
        const localDownloadFallback = document.getElementById('localDownloadFallback');
        const wrapper = document.getElementById('documentWrapper');
        const submitBtn = document.getElementById('submitBtn');

        const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

        // ============================================================
        // DEADLINE LOGIC
        // ============================================================
        function updateDeadlineStatus() {
            const value = deadlineInput.value;
            const dict = getCurrentDict(); // ← БЕРЁМ АКТУАЛЬНЫЙ СЛОВАРЬ

            if (!value) {
                deadlineStatus.classList.add('hidden');
                deadlineError.classList.remove('show');
                deadlineSection.classList.remove('error', 'warning');
                return;
            }

            const selected = new Date(value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            selected.setHours(0, 0, 0, 0);

            const diffTime = selected - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            deadlineSection.classList.remove('error', 'warning');
            deadlineError.classList.remove('show');

            if (diffDays < 0) {
                deadlineSection.classList.add('error');
                deadlineStatus.classList.remove('hidden', 'ok', 'warning');
                deadlineStatus.classList.add('error');
                deadlineStatus.querySelector('i').className = 'bi bi-x-circle-fill';
                deadlineStatusText.textContent = dict.deadlineOverdue;
                deadlineError.classList.add('show');
            } else if (diffDays === 0) {
                deadlineSection.classList.add('warning');
                deadlineStatus.classList.remove('hidden', 'ok', 'warning', 'error');
                deadlineStatus.classList.add('warning');
                deadlineStatus.querySelector('i').className = 'bi bi-exclamation-triangle-fill';
                deadlineStatusText.textContent = dict.deadlineToday;
            } else if (diffDays <= 3) {
                deadlineSection.classList.add('warning');
                deadlineStatus.classList.remove('hidden', 'ok', 'warning', 'error');
                deadlineStatus.classList.add('warning');
                deadlineStatus.querySelector('i').className = 'bi bi-exclamation-triangle-fill';
                deadlineStatusText.textContent = dict.deadlineWarning.replace('{days}', diffDays);
            } else {
                deadlineStatus.classList.remove('hidden', 'ok', 'warning', 'error');
                deadlineStatus.classList.add('ok');
                deadlineStatus.querySelector('i').className = 'bi bi-check-circle-fill';
                deadlineStatusText.textContent = dict.deadlineOk.replace('{days}', diffDays);
            }
        }

        function setQuickDeadline(days) {
            const date = new Date();
            date.setDate(date.getDate() + days);
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            deadlineInput.value = `${yyyy}-${mm}-${dd}`;
            updateDeadlineStatus();

            quickBtns.forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.querySelector(`.deadline-quick-btn[data-days="${days}"]`);
            if (activeBtn) activeBtn.classList.add('active');
        }

        // Quick buttons
        quickBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const days = parseInt(btn.dataset.days);
                setQuickDeadline(days);
            });
        });

        // Input change
        if (deadlineInput) {
            deadlineInput.addEventListener('change', updateDeadlineStatus);

            // Set min date to today
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            deadlineInput.setAttribute('min', `${yyyy}-${mm}-${dd}`);

            // Set default to 7 days
            setQuickDeadline(7);
        }

        // Load deadline from document if available
        function loadDocumentDeadline() {
            const selectedOption = select ? select.options[select.selectedIndex] : null;
            if (selectedOption && selectedOption.dataset.deadline) {
                deadlineInput.value = selectedOption.dataset.deadline;
                updateDeadlineStatus();
            }
        }

        // ============================================================
        // DOCUMENT RENDER LOGIC
        // ============================================================
        function renderDocument(fileSource, type, ext) {
            loader.style.display = 'block';
            previewViewport.style.opacity = '0.3';
            renderTarget.innerHTML = '';
            localWarning.style.display = 'none';
            wrapper.style.display = 'flex';

            formatBadge.textContent = ext.toUpperCase();
            formatBadge.className = 'format-badge ' + ext + ' inline-flex';

            if (ext === 'pdf') {
                fullScreenBtn.classList.add('hidden');
            } else {
                fullScreenBtn.href = fileSource;
                fullScreenBtn.classList.remove('hidden');
            }

            if (ext === 'docx') {
                const docxSource = fetch(fileSource).then(res => res.blob());
                docxSource.then(blob => {
                    const wordDiv = document.createElement('div');
                    wordDiv.id = 'word-preview';
                    renderTarget.appendChild(wordDiv);
                    docx.renderAsync(blob, wordDiv)
                        .then(() => {
                            loader.style.display = 'none';
                            previewViewport.style.opacity = '1';
                        })
                        .catch(e => {
                            loader.style.display = 'none';
                            previewViewport.style.opacity = '1';
                            renderTarget.innerHTML = '<div style="padding: 24px; text-align: center; color: #ff6363; font-weight: 600;">Ошибка предпросмотра DOCX: ' + (e.message || 'Не удалось загрузить') + '</div>';
                        });
                }).catch((e) => {
                    loader.style.display = 'none';
                    previewViewport.style.opacity = '1';
                    renderTarget.innerHTML = '<div style="padding: 24px; text-align: center; color: #ff6363; font-weight: 600;">Ошибка получения DOCX: ' + e.message + '</div>';
                });
                return;
            }

            if (ext === 'pdf') {
                const loadingTask = pdfjsLib.getDocument(fileSource);
                loadingTask.promise.then(function (pdf) {
                    const totalPages = pdf.numPages;

                    renderTarget.innerHTML = '';
                    renderTarget.style.display = 'flex';
                    renderTarget.style.flexDirection = 'column';
                    renderTarget.style.alignItems = 'center';

                    if (totalPages === 0) {
                        loader.style.display = 'none';
                        previewViewport.style.opacity = '1';
                        renderTarget.innerHTML = '<div style="padding: 24px; text-align: center; color: #ff6363; font-weight: 600;">PDF не содержит страниц.</div>';
                        return;
                    }

                    const renderPage = (pageNum) => {
                        return pdf.getPage(pageNum).then(function (page) {
                            const scale = 1.5;
                            const viewport = page.getViewport({scale: scale});
                            const canvas = document.createElement('canvas');
                            const context = canvas.getContext('2d');
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;
                            canvas.style.marginBottom = '10px';
                            canvas.style.border = '1px solid rgba(255,255,255,0.06)';
                            canvas.style.maxWidth = '100%';
                            canvas.style.height = 'auto';

                            return page.render({canvasContext: context, viewport: viewport}).promise.then(function () {
                                return canvas;
                            });
                        });
                    };

                    const pageRenderPromises = [];
                    for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                        pageRenderPromises.push(renderPage(pageNum));
                    }

                    Promise.allSettled(pageRenderPromises).then(results => {
                        results.forEach(result => {
                            if (result.status === 'fulfilled') {
                                renderTarget.appendChild(result.value);
                            }
                        });

                        loader.style.display = 'none';
                        previewViewport.style.opacity = '1';
                    });
                }).catch(function (error) {
                    loader.style.display = 'none';
                    previewViewport.style.opacity = '1';
                    renderTarget.innerHTML = '<div style="padding: 24px; text-align: center; color: #ff6363; font-weight: 600;">Ошибка предпросмотра PDF: ' + error.message + '</div>';
                });
                return;
            }

            if (type === 'excel' && isLocal) {
                loader.style.display = 'none';
                wrapper.style.display = 'none';
                localWarning.style.display = 'flex';
                localDownloadFallback.href = fileSource;
                return;
            }

            let iframeSrc = '';
            if (type === 'word' || type === 'excel') {
                iframeSrc = 'https://view.officeapps.live.com/op/view.aspx?src=' + encodeURIComponent(fileSource);
            } else if (type === 'rtf') {
                iframeSrc = fileSource;
            } else {
                iframeSrc = fileSource + '#toolbar=0&navpanes=0&scrollbar=0&view=FitH';
            }

            const iframe = document.createElement('iframe');
            iframe.src = iframeSrc;
            iframe.style.cssText = 'width: 100%; height: 100%; border: none; display: block;';
            iframe.frameBorder = '0';
            iframe.onload = () => {
                loader.style.display = 'none';
                previewViewport.style.opacity = '1';
            };
            iframe.onerror = (e) => {
                loader.style.display = 'none';
                previewViewport.style.opacity = '1';
                renderTarget.innerHTML = '<div style="padding: 24px; text-align: center; color: #ff6363; font-weight: 600;">Ошибка загрузки предпросмотра.</div>';
            };
            renderTarget.appendChild(iframe);
        }

        function updateSelection() {
            const dict = getCurrentDict();
            const selectedOption = select ? select.options[select.selectedIndex] : null;

            if (selectedOption && selectedOption.value) {
                const fileUrl = selectedOption.getAttribute('data-file');
                const type = selectedOption.getAttribute('data-type');
                const ext = selectedOption.getAttribute('data-ext');
                const qrUrl = selectedOption.getAttribute('data-qr');

                if (qrPreview) qrPreview.src = qrUrl;
                loadDocumentDeadline();
                renderDocument(fileUrl, type, ext);
            } else {
                if (renderTarget) renderTarget.innerHTML = '<div class="viewer-empty"><i class="bi bi-file-earmark-text"></i><p>' + dict.selectDocPreview + '</p></div>';
                if (loader) loader.style.display = 'none';
                if (previewViewport) previewViewport.style.opacity = '1';
                if (formatBadge) formatBadge.classList.add('hidden');
                if (fullScreenBtn) fullScreenBtn.classList.add('hidden');
                if (localWarning) localWarning.style.display = 'none';
                if (wrapper) wrapper.style.display = 'flex';
            }
        }

        if (select) {
            select.addEventListener('change', updateSelection);
        }

        if (select && select.value && select.value !== '') {
            updateSelection();
        }

        // ============================================================
        // FORM VALIDATION
        // ============================================================
        if (form) {
            form.addEventListener('submit', function (e) {
                const dict = getCurrentDict(); // ← БЕРЁМ АКТУАЛЬНЫЙ СЛОВАРЬ

                if (!select.value) {
                    e.preventDefault();
                    alert(dict.selectAlert);
                    return false;
                }

                // Validate deadline
                if (deadlineInput && deadlineInput.value) {
                    const selected = new Date(deadlineInput.value);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    selected.setHours(0, 0, 0, 0);

                    if (selected < today) {
                        e.preventDefault();
                        deadlineSection.classList.add('error');
                        deadlineError.classList.add('show');
                        deadlineInput.focus();
                        deadlineInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return false;
                    }
                }

                // Block button
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split" style="font-size: 18px;"></i><span>' + dict.applyingStamp + '</span>';
            });
        }

        // ============================================================
        // 1. Применяем сразу при загрузке
        // ============================================================
        const initialLang = localStorage.getItem('docsign_lang') || 'ru';
        applySignTranslations(initialLang);

        // ============================================================
        // 2. Слушаем событие смены языка от layouts/admin.blade.php
        // ============================================================
        window.addEventListener('docsign:lang-changed', (e) => {
            const lang = e.detail?.lang || 'ru';
            applySignTranslations(lang);
        });

        // ============================================================
        // 3. Синхронизация между вкладками браузера
        // ============================================================
        window.addEventListener('storage', (e) => {
            if (e.key === 'docsign_lang' && e.newValue) {
                applySignTranslations(e.newValue);
            }
        });
    });
</script>

@endsection