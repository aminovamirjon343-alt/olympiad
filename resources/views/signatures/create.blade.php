{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">--}}

{{--    <style>--}}
{{--        .sig-container { font-family: 'Inter', sans-serif !important; }--}}
{{--        #documentSelect {--}}
{{--            color: #000000 !important;--}}
{{--            background-color: #ffffff !important;--}}
{{--            font-size: 13px !important;--}}
{{--            font-weight: 600 !important;--}}
{{--            border: 1.5px solid rgba(0, 0, 0, 0.1) !important;--}}
{{--            border-radius: 0.75rem !important;--}}
{{--            padding: 0.6rem 1rem !important;--}}
{{--        }--}}
{{--        #documentSelect option { color: #000000 !important; background-color: #ffffff !important; }--}}
{{--        .signature-card-container {--}}
{{--            background: #ffffff !important;--}}
{{--            border: 1px solid rgba(0, 0, 0, 0.08) !important;--}}
{{--            border-radius: 1.5rem !important;--}}
{{--            box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.05);--}}
{{--        }--}}
{{--        .dark .signature-card-container { background: #1e293b !important; border-color: rgba(255, 255, 255, 0.1) !important; }--}}
{{--        .title-compact { font-size: 16px !important; letter-spacing: -0.02em; }--}}
{{--        .label-micro {--}}
{{--            font-size: 9px !important;--}}
{{--            font-weight: 700 !important;--}}
{{--            text-transform: uppercase !important;--}}
{{--            letter-spacing: 0.05em !important;--}}
{{--            color: #64748b;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <div class="container mx-auto px-2 py-4 sig-container">--}}
{{--        <div class="flex flex-col lg:flex-row gap-6 items-start">--}}

{{--            --}}{{-- ЛЕВАЯ КОЛОНКА --}}
{{--            <div class="w-full lg:w-4/12 sticky top-4">--}}
{{--                <div class="signature-card-container p-5">--}}
{{--                    <h2 class="title-compact font-extrabold uppercase mb-5 text-black dark:text-white" data-i18n="signingTitle">Подписание</h2>--}}

{{--                    <form action="" method="POST" id="signatureForm">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="signature" id="signatureInput">--}}

{{--                        <div class="mb-5">--}}
{{--                            <label class="label-micro block mb-1.5 ml-1" data-i18n="selectDocLabel">Выбор документа</label>--}}
{{--                            <select name="document_id" id="documentSelect" class="w-full outline-none focus:border-indigo-500 transition">--}}
{{--                                <option value="" disabled {{ !isset($document) ? 'selected' : '' }} data-i18n="docPlaceholder">-- Список документов --</option>--}}
{{--                                @foreach($documents as $doc)--}}
{{--                                    <option value="{{ $doc->id }}"--}}
{{--                                            data-pdf="{{ asset('storage/' . $doc->file_path) }}"--}}
{{--                                        {{ (isset($document) && $document->id == $doc->id) ? 'selected' : '' }}>--}}
{{--                                        #{{ $doc->id }} — {{ $doc->title }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <label class="label-micro block mb-1.5 ml-1 text-indigo-500" data-i18n="yourSigLabel">Ваша подпись</label>--}}
{{--                        <div class="relative bg-slate-50 border border-slate-200 rounded-xl overflow-hidden" style="height: 160px;">--}}
{{--                            <canvas id="signature-pad" class="w-full h-full touch-none" style="cursor: crosshair;"></canvas>--}}
{{--                            <button type="button" id="clearBtn" class="absolute top-2 right-2 bg-white text-slate-400 p-1.5 rounded-lg hover:text-red-500 transition shadow-sm border border-slate-100 z-10">--}}
{{--                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}

{{--                        <div class="mt-6">--}}
{{--                            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">--}}
{{--                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>--}}
{{--                                <span data-i18n="btnSign">Вшить подпись</span>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            --}}{{-- ПРАВАЯ КОЛОНКА --}}
{{--            <div class="w-full lg:w-8/12">--}}
{{--                <div class="flex items-center justify-between mb-3 px-4">--}}
{{--                    <span class="label-micro" data-i18n="previewLabel">Предпросмотр</span>--}}
{{--                    <a id="fullScreenBtn" href="#" target="_blank" class="hidden flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-[10px] font-bold text-black hover:bg-slate-50 hover:text-indigo-600 transition shadow-sm">--}}
{{--                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>--}}
{{--                        <span data-i18n="btnFullScreen">На весь экран</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="bg-slate-900 p-1 rounded-[1.8rem] shadow-xl sticky top-4" style="height: calc(100vh - 140px);">--}}
{{--                    <iframe id="pdfViewer" src="" class="w-full h-full rounded-[1.5rem] bg-white border-none" frameborder="0"></iframe>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const translations = {--}}
{{--                ru: {--}}
{{--                    signingTitle: "Подписание",--}}
{{--                    selectDocLabel: "Выбор документа",--}}
{{--                    docPlaceholder: "-- Список документов --",--}}
{{--                    yourSigLabel: "Ваша подпись",--}}
{{--                    btnSign: "Вшить подпись",--}}
{{--                    previewLabel: "Предпросмотр",--}}
{{--                    btnFullScreen: "На весь экран",--}}
{{--                    alertNoDoc: "Выберите документ!",--}}
{{--                    alertNoSig: "Нарисуйте подпись!"--}}
{{--                },--}}
{{--                tj: {--}}
{{--                    signingTitle: "Имзогузорӣ",--}}
{{--                    selectDocLabel: "Интихоби ҳуҷҷат",--}}
{{--                    docPlaceholder: "-- Рӯйхати ҳуҷҷатҳо --",--}}
{{--                    yourSigLabel: "Имзои шумо",--}}
{{--                    btnSign: "Гузоштани имзо",--}}
{{--                    previewLabel: "Пешнамоиш",--}}
{{--                    btnFullScreen: "Дар тамоми экран",--}}
{{--                    alertNoDoc: "Ҳуҷҷатро интихоб кунед!",--}}
{{--                    alertNoSig: "Имзоро кашед!"--}}
{{--                },--}}
{{--                en: {--}}
{{--                    signingTitle: "Signing",--}}
{{--                    selectDocLabel: "Select Document",--}}
{{--                    docPlaceholder: "-- Document List --",--}}
{{--                    yourSigLabel: "Your Signature",--}}
{{--                    btnSign: "Apply Signature",--}}
{{--                    previewLabel: "Preview",--}}
{{--                    btnFullScreen: "Full Screen",--}}
{{--                    alertNoDoc: "Please select a document!",--}}
{{--                    alertNoSig: "Please provide a signature!"--}}
{{--                }--}}
{{--            };--}}

{{--            const lang = localStorage.getItem('app-lang') || 'ru';--}}
{{--            const t = translations[lang];--}}

{{--            // Применяем переводы текстов--}}
{{--            document.querySelectorAll('[data-i18n]').forEach(el => {--}}
{{--                const key = el.getAttribute('data-i18n');--}}
{{--                if (t[key]) el.textContent = t[key];--}}
{{--            });--}}

{{--            const canvas = document.getElementById('signature-pad');--}}
{{--            const signatureInput = document.getElementById('signatureInput');--}}
{{--            const form = document.getElementById('signatureForm');--}}
{{--            const select = document.getElementById('documentSelect');--}}
{{--            const viewer = document.getElementById('pdfViewer');--}}
{{--            const fullScreenBtn = document.getElementById('fullScreenBtn');--}}

{{--            const signaturePad = new SignaturePad(canvas, {--}}
{{--                backgroundColor: 'rgb(255, 255, 255)',--}}
{{--                penColor: 'rgb(0, 0, 0)',--}}
{{--                minWidth: 1.2,--}}
{{--                maxWidth: 3.0--}}
{{--            });--}}

{{--            function updateSelection() {--}}
{{--                const selectedOption = select.options[select.selectedIndex];--}}
{{--                if (selectedOption && selectedOption.value && selectedOption.value !== "") {--}}
{{--                    const pdfUrl = selectedOption.getAttribute('data-pdf');--}}
{{--                    viewer.src = pdfUrl + '#toolbar=0&view=FitH&pagemode=none';--}}
{{--                    fullScreenBtn.href = pdfUrl;--}}
{{--                    fullScreenBtn.classList.remove('hidden');--}}
{{--                    form.action = `/documents/${selectedOption.value}/sign`;--}}
{{--                }--}}
{{--            }--}}

{{--            function resizeCanvas() {--}}
{{--                const ratio = Math.max(window.devicePixelRatio || 1, 1);--}}
{{--                canvas.width = canvas.offsetWidth * ratio;--}}
{{--                canvas.height = canvas.offsetHeight * ratio;--}}
{{--                canvas.getContext("2d").scale(ratio, ratio);--}}
{{--                signaturePad.clear();--}}
{{--            }--}}

{{--            window.addEventListener("resize", resizeCanvas);--}}
{{--            select.addEventListener('change', updateSelection);--}}
{{--            document.getElementById('clearBtn').addEventListener('click', () => signaturePad.clear());--}}

{{--            setTimeout(resizeCanvas, 300);--}}
{{--            if (select.value) updateSelection();--}}

{{--            form.addEventListener('submit', function (e) {--}}
{{--                if (!select.value) {--}}
{{--                    e.preventDefault();--}}
{{--                    alert(t.alertNoDoc);--}}
{{--                    return;--}}
{{--                }--}}
{{--                if (signaturePad.isEmpty()) {--}}
{{--                    e.preventDefault();--}}
{{--                    alert(t.alertNoSig);--}}
{{--                    return;--}}
{{--                }--}}
{{--                signatureInput.value = signaturePad.toDataURL('image/png');--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}


@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Добавляем иконки Bootstrap для наглядности форматов -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .sig-container { font-family: 'Inter', sans-serif !important; }
        #documentSelect {
            color: #000000 !important;
            background-color: #ffffff !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            border: 1.5px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: 0.75rem !important;
            padding: 0.6rem 1rem !important;
        }
        #documentSelect option { color: #000000 !important; background-color: #ffffff !important; }
        .signature-card-container {
            background: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            border-radius: 1.5rem !important;
            box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.05);
        }
        .dark .signature-card-container { background: #1e293b !important; border-color: rgba(255, 255, 255, 0.1) !important; }
        .title-compact { font-size: 16px !important; letter-spacing: -0.02em; }
        .label-micro {
            font-size: 9px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: #64748b;
        }
        /* Стили для лоадера при загрузке документа */
        .viewer-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }
    </style>

    <div class="container mx-auto px-2 py-4 sig-container">
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- ЛЕВАЯ КОЛОНКА --}}
            <div class="w-full lg:w-4/12 sticky top-4">
                <div class="signature-card-container p-5">
                    <h2 class="title-compact font-extrabold uppercase mb-5 text-black dark:text-white" data-i18n="signingTitle">Подписание</h2>

                    <form action="" method="POST" id="signatureForm">
                        @csrf
                        <input type="hidden" name="signature" id="signatureInput">

                        <div class="mb-5">
                            <label class="label-micro block mb-1.5 ml-1" data-i18n="selectDocLabel">Выбор документа</label>
                            <select name="document_id" id="documentSelect" class="w-full outline-none focus:border-indigo-500 transition">
                                <option value="" disabled {{ !isset($document) ? 'selected' : '' }} data-i18n="docPlaceholder">-- Список документов --</option>
                                @foreach($documents as $doc)
                                    @php
                                        $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                        $isWord = in_array(strtolower($ext), ['doc', 'docx']);
                                    @endphp
                                    <option value="{{ $doc->id }}"
                                            data-file="{{ asset('storage/' . $doc->file_path) }}"
                                            data-type="{{ $isWord ? 'word' : 'pdf' }}"
                                        {{ (isset($document) && $document->id == $doc->id) ? 'selected' : '' }}>
                                        [{{ strtoupper($ext) }}] #{{ $doc->id }} — {{ $doc->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="label-micro block mb-1.5 ml-1 text-indigo-500" data-i18n="yourSigLabel">Ваша подпись</label>
                        <div class="relative bg-slate-50 border border-slate-200 rounded-xl overflow-hidden" style="height: 160px;">
                            <canvas id="signature-pad" class="w-full h-full touch-none" style="cursor: crosshair;"></canvas>
                            <button type="button" id="clearBtn" class="absolute top-2 right-2 bg-white text-slate-400 p-1.5 rounded-lg hover:text-red-500 transition shadow-sm border border-slate-100 z-10">
                                <i class="bi bi-eraser-fill"></i>
                            </button>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                                <i class="bi bi-pen-fill"></i>
                                <span data-i18n="btnSign">Вшить подпись</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ПРАВАЯ КОЛОНКА --}}
            <div class="w-full lg:w-8/12">
                <div class="flex items-center justify-between mb-3 px-4">
                    <div class="flex items-center gap-3">
                        <span class="label-micro" data-i18n="previewLabel">Предпросмотр</span>
                        <span id="formatBadge" class="hidden px-2 py-0.5 rounded text-[9px] font-black uppercase text-white"></span>
                    </div>
                    <a id="fullScreenBtn" href="#" target="_blank" class="hidden flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-[10px] font-bold text-black hover:bg-slate-50 hover:text-indigo-600 transition shadow-sm">
                        <i class="bi bi-arrows-fullscreen"></i>
                        <span data-i18n="btnFullScreen">На весь экран</span>
                    </a>
                </div>
                <div class="bg-slate-900 p-1 rounded-[1.8rem] shadow-xl sticky top-4 relative" style="height: calc(100vh - 140px);">
                    <div id="viewerLoader" class="viewer-loading">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                    </div>
                    <iframe id="pdfViewer" src="" class="w-full h-full rounded-[1.5rem] bg-white border-none" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    signingTitle: "Подписание",
                    selectDocLabel: "Выбор документа",
                    docPlaceholder: "-- Список документов --",
                    yourSigLabel: "Ваша подпись",
                    btnSign: "Вшить подпись",
                    previewLabel: "Предпросмотр",
                    btnFullScreen: "На весь экран",
                    alertNoDoc: "Выберите документ!",
                    alertNoSig: "Нарисуйте подпись!"
                },
                tj: {
                    signingTitle: "Имзогузорӣ",
                    selectDocLabel: "Интихоби ҳуҷҷат",
                    docPlaceholder: "-- Рӯйхати ҳуҷҷатҳо --",
                    yourSigLabel: "Имзои шумо",
                    btnSign: "Гузоштани имзо",
                    previewLabel: "Пешнамоиш",
                    btnFullScreen: "Дар тамоми экран",
                    alertNoDoc: "Ҳуҷҷатро интихоб кунед!",
                    alertNoSig: "Имзоро кашед!"
                },
                en: {
                    signingTitle: "Signing",
                    selectDocLabel: "Select Document",
                    docPlaceholder: "-- Document List --",
                    yourSigLabel: "Your Signature",
                    btnSign: "Apply Signature",
                    previewLabel: "Preview",
                    btnFullScreen: "Full Screen",
                    alertNoDoc: "Please select a document!",
                    alertNoSig: "Please provide a signature!"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            const canvas = document.getElementById('signature-pad');
            const signatureInput = document.getElementById('signatureInput');
            const form = document.getElementById('signatureForm');
            const select = document.getElementById('documentSelect');
            const viewer = document.getElementById('pdfViewer');
            const fullScreenBtn = document.getElementById('fullScreenBtn');
            const formatBadge = document.getElementById('formatBadge');
            const loader = document.getElementById('viewerLoader');

            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 1.2,
                maxWidth: 3.0
            });

            function updateSelection() {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption && selectedOption.value && selectedOption.value !== "") {
                    const fileUrl = selectedOption.getAttribute('data-file');
                    const type = selectedOption.getAttribute('data-type');

                    loader.style.display = 'block';
                    viewer.style.opacity = '0.5';

                    // Логика отображения
                    if (type === 'word') {
                        // Используем Office Online Viewer для Word
                        viewer.src = `https://view.officeapps.live.com/op/view.aspx?src=${encodeURIComponent(fileUrl)}`;
                        formatBadge.textContent = 'Word';
                        formatBadge.className = 'px-2 py-0.5 rounded text-[9px] font-black uppercase text-white bg-blue-600 inline-block';
                    } else {
                        viewer.src = fileUrl + '#toolbar=0&view=FitH';
                        formatBadge.textContent = 'PDF';
                        formatBadge.className = 'px-2 py-0.5 rounded text-[9px] font-black uppercase text-white bg-red-600 inline-block';
                    }

                    viewer.onload = () => {
                        loader.style.display = 'none';
                        viewer.style.opacity = '1';
                    };

                    formatBadge.classList.remove('hidden');
                    fullScreenBtn.href = fileUrl;
                    fullScreenBtn.classList.remove('hidden');
                    form.action = `/documents/${selectedOption.value}/sign`;
                }
            }

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }

            window.addEventListener("resize", resizeCanvas);
            select.addEventListener('change', updateSelection);
            document.getElementById('clearBtn').addEventListener('click', () => signaturePad.clear());

            setTimeout(resizeCanvas, 300);
            if (select.value) updateSelection();

            form.addEventListener('submit', function (e) {
                if (!select.value) {
                    e.preventDefault();
                    alert(t.alertNoDoc);
                    return;
                }
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert(t.alertNoSig);
                    return;
                }
                signatureInput.value = signaturePad.toDataURL('image/png');
            });
        });
    </script>
@endsection
