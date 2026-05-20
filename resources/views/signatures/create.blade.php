@extends('layouts.admin')

@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
    <script src="https://unpkg.com/docx-preview/dist/docx-preview.min.js"></script>

    <style>

        .sig-container{
            font-family:'Inter',sans-serif !important;
        }

        .signature-card-container{
            background:#ffffff;
            border:1px solid rgba(0,0,0,0.08);
            border-radius:1.7rem;
            box-shadow:0 4px 20px rgba(0,0,0,0.05);
        }

        .dark .signature-card-container{
            background:#1e293b;
            border-color:rgba(255,255,255,0.08);
        }

        .title-compact{
            font-size:17px;
            letter-spacing:-0.03em;
        }

        .label-micro{
            font-size:9px;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#64748b;
        }

        #documentSelect{
            width:100%;
            color:#000;
            background:#fff;
            font-size:13px;
            font-weight:700;
            border:1.5px solid rgba(0,0,0,0.08);
            border-radius:1rem;
            padding:.85rem 1rem;
            outline:none;
            transition:.2s;
        }

        #documentSelect:focus{
            border-color:#4f46e5;
        }

        .viewer-loading{
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            display:none;
            z-index:50;
        }

        .document-wrapper{
            position:relative;
            width:100%;
            height:100%;
            overflow:auto;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#0f172a;
        }

        #previewViewport{
            width:100%;
            height:100%;
            overflow-y:auto;
            background:#0f172a;
        }

        #word-preview{
            width:100%;
            min-height:100%;
            background:#fff;
        }

        .docx-wrapper{
            background:transparent !important;
            padding:0 !important;
        }

        .docx{
            width:100% !important;
            min-height:100% !important;
            padding:20px !important;
            box-shadow:none !important;
        }

        .upload-zone{
            border:2px dashed #cbd5e1;
            border-radius:1.5rem;
            transition:.25s;
        }

        .upload-zone:hover{
            border-color:#4f46e5;
            background:rgba(79,70,229,.04);
        }

        .local-warning-box{
            display:none;
            position:absolute;
            inset:0;
            background:#1e293b;
            z-index:30;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            padding:2rem;
            color:white;
        }

    </style>

    <div class="container mx-auto px-2 py-4 sig-container">

        <form action="{{ route('signatures.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="signatureForm">

            @csrf

            <input type="hidden" name="qr_payload" id="qrPayloadInput">

            <input type="hidden" name="qr_x" value="80">
            <input type="hidden" name="qr_y" value="85">
            <input type="hidden" name="target_page" value="-1">

            <div class="flex flex-col lg:flex-row gap-6 items-start">

                {{-- LEFT --}}
                <div class="w-full lg:w-4/12 sticky top-4">

                    <div class="signature-card-container p-5 mb-4">

                        <h2 class="title-compact font-extrabold uppercase mb-5 text-black dark:text-white"
                            data-i18n="title">
                            Защита и QR
                        </h2>

                        {{-- DOCUMENT --}}
                        <div class="mb-5">

                            <label class="label-micro block mb-2 ml-1"
                                   data-i18n="selectDocument">
                                Выбор документа
                            </label>

                            <select name="document_id"
                                    id="documentSelect">

                                <option value="" disabled>
                                    -- Список документов --
                                </option>

                                @foreach($documents as $doc)

                                    @php

                                        $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));

                                        if(in_array($ext,['doc','docx'])){
                                            $formatType = 'word';
                                        }
                                        elseif(in_array($ext,['xls','xlsx'])){
                                            $formatType = 'excel';
                                        }
                                        elseif($ext === 'rtf'){
                                            $formatType = 'rtf';
                                        }
                                        else{
                                            $formatType = 'pdf';
                                        }

                                        $senderName = $doc->sender->name ?? 'Система';

                                        $signerName = auth()->user()->name ?? 'User';

                                        $dateSent = $doc->created_at
                                            ? $doc->created_at->format('d.m.Y H:i')
                                            : now()->format('d.m.Y H:i');

                                        $qrText = "DocSign | DOC: {$doc->title} | SENDER: {$senderName} | SIGNED BY: {$signerName} | DATE: {$dateSent}";

                                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($qrText);

                                    @endphp

                                    <option value="{{ $doc->id }}"
                                            {{ request('document_id') == $doc->id ? 'selected' : '' }}
                                            data-file="{{ asset('storage/'.$doc->file_path) }}"
                                            data-type="{{ $formatType }}"
                                            data-ext="{{ $ext }}"
                                            data-qr="{{ $qrUrl }}"
                                            data-qr-text="{{ $qrText }}">

                                        [{{ strtoupper($ext) }}] #{{ $doc->id }} — {{ $doc->title }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- QR --}}
                        <div class="mb-5">

                            <div class="flex items-center justify-between">

                                <div>

                                    <div class="label-micro mb-1">
                                        QR CODE
                                    </div>

                                    <div class="text-xs font-bold text-slate-700 dark:text-slate-200"
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

                        <span class="label-micro"
                              data-i18n="preview">
                            Предпросмотр
                        </span>

                            <span id="formatBadge"
                                  class="hidden px-2 py-0.5 rounded text-[9px] font-black uppercase text-white">
                        </span>

                        </div>

                        {{-- FILE INFO --}}


                    </div>

                </div>

                {{-- RIGHT --}}

                <div class="w-full lg:w-8/12">

                    <div class="flex items-center justify-between mb-3 px-4">
                        <a id="fullScreenBtn"
                           href="#"
                           target="_blank"
                           class="hidden flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-xl text-[10px] font-bold text-black hover:bg-slate-50 hover:text-indigo-600 transition">

                            <i class="bi bi-arrows-fullscreen"></i>

                            <span data-i18n="fullscreen">
                            На весь экран
                        </span>

                        </a>

                    </div>

                    {{-- VIEWER --}}
                    <div id="viewerContainer"
                         class="bg-slate-950 p-2 rounded-[1.8rem] shadow-xl relative mb-4"
                         style="height: calc(100vh - 220px); min-height: 520px;">

                        <div id="viewerLoader" class="viewer-loading">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                        </div>

                        <div id="localWarning"
                             class="local-warning-box rounded-[1.5rem]">

                            <i class="bi bi-exclamation-triangle text-amber-500 text-3xl mb-3"></i>

                            <h4 class="text-base font-bold mb-2">
                                Excel Preview
                            </h4>

                            <p class="text-xs text-slate-400 mb-4">
                                Office preview недоступен на localhost
                            </p>

                            <a id="localDownloadFallback"
                               href="#"
                               download
                               class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2">

                                <i class="bi bi-download"></i>

                                <span data-i18n="downloadFile">
                                Скачать файл
                            </span>

                            </a>

                        </div>

                        <div class="document-wrapper h-full"
                             id="documentWrapper">

                            <div id="previewViewport"
                                 class="rounded-xl">

                                <div id="renderTarget"
                                     class="w-full h-full"></div>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="px-2 flex justify-center">

                        <button type="submit"
                                class="w-72 bg-indigo-600 text-white py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">

                            <i class="bi bi-shield-check"></i>

                            <span data-i18n="applyStamp">
                            Применить штамп
                        </span>

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
                    title: "Защита и QR",
                    selectDocument: "Выбор документа",
                    signatureCheck: "Проверка подписи",
                    uploadFile: "Загрузка файла",
                    clickSelect: "Нажмите для выбора файла",
                    preview: "Предпросмотр",
                    fullscreen: "На весь экран",
                    downloadFile: "Скачать файл",
                    applyStamp: "Применить штамп",
                    selectAlert: "Выберите документ!"
                },

                en: {
                    title: "Security & QR",
                    selectDocument: "Select Document",
                    signatureCheck: "Signature Verification",
                    uploadFile: "Upload File",
                    clickSelect: "Click to select file",
                    preview: "Preview",
                    fullscreen: "Full Screen",
                    downloadFile: "Download File",
                    applyStamp: "Apply Stamp",
                    selectAlert: "Please select document!"
                },

                tj: {
                    title: "Муҳофизат ва QR",
                    selectDocument: "Интихоби ҳуҷҷат",
                    signatureCheck: "Санҷиши имзо",
                    uploadFile: "Боркунии файл",
                    clickSelect: "Барои интихоби файл пахш кунед",
                    preview: "Пешнамоиш",
                    fullscreen: "Тамоми экран",
                    downloadFile: "Боргирии файл",
                    applyStamp: "Татбиқи муҳр",
                    selectAlert: "Ҳуҷҷатро интихоб кунед!"
                }

            };

            const lang = localStorage.getItem('app-lang') || 'ru';

            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {

                const key = el.getAttribute('data-i18n');

                if(t[key]){
                    el.textContent = t[key];
                }

            });

            const form = document.getElementById('signatureForm');

            const select = document.getElementById('documentSelect');

            const renderTarget = document.getElementById('renderTarget');

            const previewViewport = document.getElementById('previewViewport');

            const loader = document.getElementById('viewerLoader');

            const formatBadge = document.getElementById('formatBadge');

            const fullScreenBtn = document.getElementById('fullScreenBtn');

            const qrPreview = document.getElementById('qrPreview');

            const qrPayloadInput = document.getElementById('qrPayloadInput');

            const localWarning = document.getElementById('localWarning');

            const localDownloadFallback = document.getElementById('localDownloadFallback');

            const wrapper = document.getElementById('documentWrapper');

            const customFileInput = document.getElementById('customFileInput');

            const fileInfo = document.getElementById('fileInfo');

            const fileName = document.getElementById('fileName');

            const fileSize = document.getElementById('fileSize');

            const isLocal =
                window.location.hostname === 'localhost'
                || window.location.hostname === '127.0.0.1';

            function updateSelection(){

                const selectedOption = select.options[select.selectedIndex];

                if(!selectedOption || !selectedOption.value){
                    return;
                }

                const fileUrl = selectedOption.getAttribute('data-file');

                const type = selectedOption.getAttribute('data-type');

                const ext = selectedOption.getAttribute('data-ext');

                const qrText = selectedOption.getAttribute('data-qr-text');

                const qrUrl = selectedOption.getAttribute('data-qr');

                qrPreview.src = qrUrl;

                qrPayloadInput.value = qrText;

                loader.style.display = 'block';

                previewViewport.style.opacity = '0.3';

                renderTarget.innerHTML = '';

                localWarning.style.display = 'none';

                wrapper.style.display = 'flex';

                formatBadge.textContent = ext.toUpperCase();

                let badgeColor = 'bg-red-600';

                if(type === 'word') badgeColor = 'bg-blue-600';

                if(type === 'excel') badgeColor = 'bg-emerald-600';

                if(type === 'rtf') badgeColor = 'bg-purple-600';

                formatBadge.className =
                    `px-2 py-0.5 rounded text-[9px] font-black uppercase text-white ${badgeColor} inline-block`;

                formatBadge.classList.remove('hidden');

                fullScreenBtn.href = fileUrl;

                fullScreenBtn.classList.remove('hidden');

                if(ext === 'docx'){

                    fetch(fileUrl)

                        .then(response => {

                            if(!response.ok){
                                throw new Error('Download error');
                            }

                            return response.blob();

                        })

                        .then(blob => {

                            const wordDiv = document.createElement('div');

                            wordDiv.id = 'word-preview';

                            renderTarget.appendChild(wordDiv);

                            docx.renderAsync(blob, wordDiv)

                                .then(() => {

                                    loader.style.display = 'none';

                                    previewViewport.style.opacity = '1';

                                });

                        })

                        .catch(() => {

                            loader.style.display = 'none';

                            previewViewport.style.opacity = '1';

                            renderTarget.innerHTML =
                                `<div class="p-6 text-center text-sm font-semibold text-rose-500">
                            DOCX preview error
                        </div>`;

                        });

                    return;

                }

                if(type === 'excel' && isLocal){

                    loader.style.display = 'none';

                    wrapper.style.display = 'none';

                    localWarning.style.display = 'flex';

                    localDownloadFallback.href = fileUrl;

                    return;

                }

                let iframeSrc = '';

                if(type === 'word' || type === 'excel'){

                    iframeSrc =
                        `https://view.officeapps.live.com/op/view.aspx?src=${encodeURIComponent(fileUrl)}`;

                }
                else if(type === 'rtf'){

                    iframeSrc = fileUrl;

                }
                else{

                    iframeSrc =
                        fileUrl + '#toolbar=0&navpanes=0&scrollbar=0&view=FitH';

                }

                const iframe = document.createElement('iframe');

                iframe.src = iframeSrc;

                iframe.className = 'w-full h-full border-none block';

                iframe.frameBorder = '0';

                iframe.onload = () => {

                    loader.style.display = 'none';

                    previewViewport.style.opacity = '1';

                };

                renderTarget.appendChild(iframe);

            }

            select.addEventListener('change', updateSelection);

            // AUTO OPEN DOCUMENT
            if(select.value && select.value !== ''){
                updateSelection();
            }

            customFileInput.addEventListener('change', function(){

                const file = this.files[0];

                if(!file){
                    return;
                }

                fileInfo.classList.remove('hidden');

                fileName.textContent = file.name;

                fileSize.textContent =
                    (file.size / 1024 / 1024).toFixed(2) + ' MB';

                const qrText =
                    `FILE: ${file.name} | SIZE: ${file.size} bytes | VERIFIED`;

                qrPreview.src =
                    `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(qrText)}`;

            });

            form.addEventListener('submit', function(e){

                if(!select.value){

                    e.preventDefault();

                    alert(t.selectAlert);

                }

            });

        });

    </script>

@endsection
