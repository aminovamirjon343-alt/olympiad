@extends('layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
    }

    .signature-card-container {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 1.7rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .dark .signature-card-container {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.08);
    }

    .title-compact {
        font-size: 17px;
        letter-spacing: -0.03em;
    }

    .label-micro {
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #64748b;
    }

    #documentSelect {
        width: 100%;
        color: #000;
        background: #fff;
        font-size: 13px;
        font-weight: 700;
        border: 1.5px solid rgba(0, 0, 0, 0.08);
        border-radius: 1rem;
        padding: .85rem 1rem;
        outline: none;
        transition: .2s;
    }

    #documentSelect:focus {
        border-color: #4f46e5;
    }

    .viewer-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 50;
    }

    .document-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: auto;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        background: #0f172a;
    }

    #previewViewport {
        width: 100%;
        height: 100%;
        overflow-y: auto;
        background: #0f172a;
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
        background: #1e293b;
        z-index: 30;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        color: white;
    }

    .info-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 1rem;
        margin-bottom: 1rem;
    }

    .info-box h3 {
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.5rem;
    }

    .info-box p {
        font-size: 12px;
        line-height: 1.6;
        opacity: 0.95;
    }
</style>

<div class="container mx-auto px-2 py-4 sig-container">

    <form action="{{ route('signatures.store') }}"
          method="POST"
          id="signatureForm">

        @csrf

        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- ЛЕВАЯ ПАНЕЛЬ --}}
            <div class="w-full lg:w-4/12 sticky top-4">

                <div class="signature-card-container p-5 mb-4">

                    <h2 class="title-compact font-extrabold uppercase mb-5 text-black dark:text-white"
                        data-i18n="title">
                        Подпись документа
                    </h2>

                    {{-- ИНФОРМАЦИОННЫЙ БЛОК --}}
                    <div class="info-box">
                        <h3>
                            <i class="bi bi-info-circle-fill"></i> Автоматическая подпись
                        </h3>
                        <p>
                            QR-код с подписью будет автоматически размещён на <strong>последней странице</strong> документа в правом нижнем углу.
                        </p>
                        <p style="margin-top: 0.5rem; font-size: 11px; opacity: 0.85;">
                            ✅ PDF — последняя страница<br>
                            ✅ DOCX — последняя страница<br>
                            ✅ XLSX — последний лист<br>
                            ✅ RTF — конвертируется в DOCX
                        </p>
                    </div>

                    <div class="mb-5">
                        <label class="label-micro block mb-2 ml-1"
                               data-i18n="selectDocument">
                            Выбор документа
                        </label>
                        <select name="document_id"
                                id="documentSelect"
                                required>
                            <option value="" disabled {{ $documents->isEmpty() ? 'selected' : '' }}>
                                -- Список документов --
                            </option>
                            @foreach($documents as $index => $doc)
                            @php
                            $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                            $formatType = 'pdf';
                            if(in_array($ext,['doc','docx'])){
                            $formatType = 'word';
                            } elseif(in_array($ext,['xls','xlsx'])){
                            $formatType = 'excel';
                            } elseif($ext === 'rtf'){
                            $formatType = 'rtf';
                            }

                            $senderName = $doc->sender->name ?? 'Система';
                            $signerName = auth()->user()->name ?? 'Пользователь';
                            $dateSent = $doc->created_at
                            ? $doc->created_at->format('d.m.Y H:i')
                            : now()->format('d.m.Y H:i');

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
                            data-signer="{{ $signerName }}">
                            [{{ strtoupper($ext) }}] #{{ $doc->id }} — {{ $doc->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="label-micro mb-1">
                                    QR CODE
                                </div>
                                <div class="text-xs font-bold text-slate-700 dark:text-white"
                                     data-i18n="signatureCheck">
                                    Проверка подписи
                                </div>
                            </div>
                            <div class="w-24 h-24 rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-sm">
                                <img id="qrPreview"
                                     src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=DocSign"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="label-micro" data-i18n="preview">Предпросмотр</span>
                        <span id="formatBadge" class="hidden px-2 py-0.5 rounded text-[9px] font-black uppercase text-white"></span>
                    </div>
                </div>
            </div>

            {{-- ПРАВАЯ ПАНЕЛЬ --}}
            <div class="w-full lg:w-8/12">
                <div class="flex items-center justify-between mb-3 px-4">
                    <a id="fullScreenBtn"
                       href="#"
                       target="_blank"
                       class="hidden flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-xl text-[10px] font-bold text-black hover:bg-slate-50 hover:text-indigo-600 transition">
                        <i class="bi bi-arrows-fullscreen"></i>
                        <span data-i18n="fullscreen">На весь экран</span>
                    </a>
                </div>

                <div id="viewerContainer"
                     class="bg-slate-950 p-2 rounded-[1.8rem] shadow-xl relative mb-4"
                     style="height: calc(100vh - 220px); min-height: 520px;">

                    <div id="viewerLoader" class="viewer-loading">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                    </div>

                    <div id="localWarning" class="local-warning-box rounded-[1.5rem]">
                        <i class="bi bi-exclamation-triangle text-amber-500 text-3xl mb-3"></i>
                        <h4 class="text-base font-bold mb-2">Excel Preview</h4>
                        <p class="text-xs text-slate-400 mb-4">Office preview недоступен на localhost</p>
                        <a id="localDownloadFallback"
                           href="#"
                           download
                           class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2">
                            <i class="bi bi-download"></i>
                            <span data-i18n="downloadFile">Скачать файл</span>
                        </a>
                    </div>

                    <div class="document-wrapper h-full" id="documentWrapper">
                        <div id="previewViewport" class="rounded-xl">
                            <div id="renderTarget" class="w-full h-full relative"></div>
                        </div>
                    </div>
                </div>

                <div class="px-2 flex justify-center">
                    <button type="submit"
                            id="submitBtn"
                            class="w-80 bg-indigo-600 text-white py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                        <i class="bi bi-shield-check text-lg"></i>
                        <span data-i18n="applyStamp">Подписать документ</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const translations = {
            ru: {
                title: "Подпись документа",
                selectDocument: "Выбор документа",
                signatureCheck: "Проверка подписи",
                preview: "Предпросмотр",
                fullscreen: "На весь экран",
                downloadFile: "Скачать файл",
                applyStamp: "Подписать документ",
                selectAlert: "Выберите документ!"
            },
            en: {
                title: "Document Signing",
                selectDocument: "Select Document",
                signatureCheck: "Signature Verification",
                preview: "Preview",
                fullscreen: "Full Screen",
                downloadFile: "Download File",
                applyStamp: "Sign Document",
                selectAlert: "Please select a document!"
            },
            tj: {
                title: "Имзои ҳуҷҷат",
                selectDocument: "Интихоби ҳуҷҷат",
                signatureCheck: "Санҷиши имзо",
                preview: "Пешнамоиш",
                fullscreen: "Тамоми экран",
                downloadFile: "Боргирии файл",
                applyStamp: "Имзо кардан",
                selectAlert: "Ҳуҷҷатро интихоб кунед!"
            }
        };

        const lang = localStorage.getItem('app-lang') || 'ru';
        const t = translations[lang];

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key]) el.textContent = t[key];
        });

        const form = document.getElementById('signatureForm');
        const select = document.getElementById('documentSelect');
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

        function renderDocument(fileSource, type, ext) {
            loader.style.display = 'block';
            previewViewport.style.opacity = '0.3';
            renderTarget.innerHTML = '';
            localWarning.style.display = 'none';
            wrapper.style.display = 'flex';

            formatBadge.textContent = ext.toUpperCase();
            let badgeColor = 'bg-red-600';
            if (type === 'word') badgeColor = 'bg-blue-600';
            if (type === 'excel') badgeColor = 'bg-emerald-600';
            if (type === 'rtf') badgeColor = 'bg-purple-600';
            formatBadge.className = `px-2 py-0.5 rounded text-[9px] font-black uppercase text-white ${badgeColor} inline-block`;
            formatBadge.classList.remove('hidden');

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
                            renderTarget.innerHTML = `<div class="p-6 text-center text-sm font-semibold text-rose-500">Ошибка предпросмотра DOCX: ${e.message || 'Не удалось загрузить'}</div>`;
                        });
                }).catch((e) => {
                    loader.style.display = 'none';
                    previewViewport.style.opacity = '1';
                    renderTarget.innerHTML = `<div class="p-6 text-center text-sm font-semibold text-rose-500">Ошибка получения DOCX: ${e.message}</div>`;
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
                        renderTarget.innerHTML = `<div class="p-6 text-center text-sm font-semibold text-rose-500">PDF не содержит страниц.</div>`;
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
                            canvas.style.border = '1px solid #eee';
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
                    renderTarget.innerHTML = `<div class="p-6 text-center text-sm font-semibold text-rose-500">Ошибка предпросмотра PDF: ${error.message}</div>`;
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
                iframeSrc = `https://view.officeapps.live.com/op/view.aspx?src=${encodeURIComponent(fileSource)}`;
            } else if (type === 'rtf') {
                iframeSrc = fileSource;
            } else {
                iframeSrc = fileSource + '#toolbar=0&navpanes=0&scrollbar=0&view=FitH';
            }

            const iframe = document.createElement('iframe');
            iframe.src = iframeSrc;
            iframe.className = 'w-full h-full border-none block';
            iframe.frameBorder = '0';
            iframe.onload = () => {
                loader.style.display = 'none';
                previewViewport.style.opacity = '1';
            };
            iframe.onerror = (e) => {
                loader.style.display = 'none';
                previewViewport.style.opacity = '1';
                renderTarget.innerHTML = `<div class="p-6 text-center text-sm font-semibold text-rose-500">Ошибка загрузки предпросмотра.</div>`;
            };
            renderTarget.appendChild(iframe);
        }

        function updateSelection() {
            const selectedOption = select ? select.options[select.selectedIndex] : null;

            if (selectedOption && selectedOption.value) {
                const fileUrl = selectedOption.getAttribute('data-file');
                const type = selectedOption.getAttribute('data-type');
                const ext = selectedOption.getAttribute('data-ext');
                const qrUrl = selectedOption.getAttribute('data-qr');

                if (qrPreview) qrPreview.src = qrUrl;
                renderDocument(fileUrl, type, ext);
            } else {
                if (renderTarget) renderTarget.innerHTML = '';
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

        // ✅ ВАЛИДАЦИЯ ПЕРЕД ОТПРАВКОЙ
        if (form) {
            form.addEventListener('submit', function (e) {
                if (!select.value) {
                    e.preventDefault();
                    alert(t.selectAlert);
                    return false;
                }

                // Блокируем кнопку
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split text-lg"></i><span>Подписание...</span>';
            });
        }
    });
</script>

@endsection