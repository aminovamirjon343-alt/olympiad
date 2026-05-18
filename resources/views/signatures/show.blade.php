{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">--}}

{{--    <div class="container mx-auto px-4 py-6 min-h-screen">--}}
{{--        <style>--}}
{{--            .view-sig-page {--}}
{{--                --primary-color: #6366f1;--}}
{{--                font-family: 'Inter', sans-serif !important;--}}
{{--            }--}}

{{--            .view-sig-page *, .view-sig-page label, .view-sig-page p, .view-sig-page span {--}}
{{--                font-family: 'Inter', sans-serif !important;--}}
{{--            }--}}

{{--            .form-card {--}}
{{--                background: #ffffff !important;--}}
{{--                border-radius: 1.5rem;--}}
{{--                border: 1px solid rgba(0, 0, 0, 0.08);--}}
{{--                box-shadow: 0 4px 20px rgba(0,0,0,0.03);--}}
{{--            }--}}

{{--            .dark .form-card {--}}
{{--                background: #1e293b !important;--}}
{{--                border-color: rgba(255,255,255,0.1);--}}
{{--            }--}}

{{--            .label-micro {--}}
{{--                font-size: 10px !important;--}}
{{--                font-weight: 800 !important;--}}
{{--                text-transform: uppercase !important;--}}
{{--                letter-spacing: 0.1em !important;--}}
{{--                color: #94a3b8;--}}
{{--            }--}}

{{--            .data-text {--}}
{{--                font-size: 15px !important;--}}
{{--                font-weight: 700;--}}
{{--                color: #1e293b;--}}
{{--            }--}}
{{--            .dark .data-text { color: #f8fafc; }--}}

{{--            .description-box {--}}
{{--                font-size: 14px !important;--}}
{{--                font-weight: 600;--}}
{{--                color: #64748b;--}}
{{--                white-space: normal !important;--}}
{{--                word-break: break-word;--}}
{{--            }--}}

{{--            .badge-status {--}}
{{--                font-size: 10px;--}}
{{--                font-weight: 900;--}}
{{--                padding: 4px 12px;--}}
{{--                border-radius: 8px;--}}
{{--                text-transform: uppercase;--}}
{{--            }--}}

{{--            .pdf-container {--}}
{{--                height: 900px;--}}
{{--                border-radius: 1.5rem;--}}
{{--                overflow: hidden;--}}
{{--                border: 1px solid rgba(0,0,0,0.1);--}}
{{--                background: #f8fafc;--}}
{{--                position: relative;--}}
{{--            }--}}

{{--            .pdf-container:fullscreen { width: 100vw; height: 100vh; border-radius: 0; }--}}
{{--            .pdf-container:-webkit-full-screen { width: 100vw; height: 100vh; border-radius: 0; }--}}
{{--        </style>--}}

{{--        <div class="view-sig-page">--}}
{{--            --}}{{-- Шапка --}}
{{--            <div class="mb-6 flex items-center justify-between">--}}
{{--                <div>--}}
{{--                    <a href="{{ route('signatures.index') }}" class="label-micro text-indigo-500 flex items-center gap-2 mb-2 hover:text-indigo-700 transition-all">--}}
{{--                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>--}}
{{--                        <span data-i18n="backToList">Реестр документов</span>--}}
{{--                    </a>--}}
{{--                    <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white" data-i18n="cardTitle">Карточка документа</h1>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="flex flex-col gap-6">--}}

{{--                --}}{{-- ВЕРХНЯЯ КАРТОЧКА (ИНФОРМАЦИЯ) --}}
{{--                <div class="form-card p-8">--}}
{{--                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12">--}}
{{--                        --}}{{-- Статус и ID --}}
{{--                        <div class="space-y-6">--}}
{{--                            <div class="flex items-center justify-between border-b pb-4 border-slate-50 dark:border-slate-800">--}}
{{--                                <span class="label-micro" data-i18n="statusLabel">Статус записи</span>--}}
{{--                                @if($signature->signed_at)--}}
{{--                                    <span class="badge-status bg-emerald-500/10 text-emerald-600" data-i18n="statusSigned">Подписано</span>--}}
{{--                                @else--}}
{{--                                    <span class="badge-status bg-rose-500/10 text-rose-600" data-i18n="statusPending">Ожидание</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <label class="label-micro block mb-1" data-i18n="idLabel">ID Записи / Номер</label>--}}
{{--                                <div class="data-text text-xl">#{{ str_pad($signature->id, 6, '0', STR_PAD_LEFT) }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Описание --}}
{{--                        <div class="md:col-span-2 space-y-4">--}}
{{--                            <div>--}}
{{--                                <label class="label-micro block mb-1" data-i18n="descLabel">Описание документа</label>--}}
{{--                                <div class="description-box leading-relaxed">--}}
{{--                                    {{ $signature->document->content ?? '—' }}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="grid grid-cols-2 gap-4">--}}
{{--                                <div>--}}
{{--                                    <label class="label-micro block mb-1" data-i18n="nameLabel">Название</label>--}}
{{--                                    <div class="data-text">{{ $signature->document->title ?? '—' }}</div>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <label class="label-micro block mb-1" data-i18n="typeLabel">Тип документа</label>--}}
{{--                                    <div class="data-text">{{ $signature->document->type ?? '—' }}</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Действия --}}
{{--                        <div class="flex flex-col justify-between">--}}
{{--                            <div class="text-right">--}}
{{--                                <label class="label-micro block mb-1" data-i18n="executorLabel">Исполнитель</label>--}}
{{--                                <div class="data-text">{{ $signature->user->name ?? '—' }}</div>--}}
{{--                                <div class="text-[11px] text-slate-400 font-medium">{{ $signature->created_at->format('d.m.Y') }}</div>--}}
{{--                            </div>--}}
{{--                            <div class="mt-4">--}}
{{--                                @if(!$signature->signed_at)--}}
{{--                                    <a href="{{ route('signatures.create', ['document_id' => $signature->document_id]) }}"--}}
{{--                                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl text-[11px] font-black uppercase tracking-widest flex items-center justify-center gap-2 transition-all shadow-lg shadow-indigo-500/20">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/></svg>--}}
{{--                                        <span data-i18n="signBtn">Подписать</span>--}}
{{--                                    </a>--}}
{{--                                @else--}}
{{--                                    <div class="sig-display-area flex items-center justify-center py-2 px-4 rounded-xl">--}}
{{--                                        <img src="{{ $signature->signature }}" class="max-h-12 object-contain dark:invert" alt="Sig">--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{-- НИЖНЯЯ КАРТОЧКА (PDF) --}}
{{--                <div class="form-card p-6">--}}
{{--                    <div class="flex items-center justify-between mb-6">--}}
{{--                        <span class="label-micro" data-i18n="previewLabel">Предпросмотр документа</span>--}}
{{--                        <div class="flex gap-3">--}}
{{--                            @if($signature->document && $signature->document->file_path)--}}
{{--                                <button id="fullScreenBtn" onclick="toggleFullScreen()" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-lg shadow-indigo-500/20">--}}
{{--                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>--}}
{{--                                    <span data-i18n="fsBtn">Во весь экран</span>--}}
{{--                                </button>--}}

{{--                                <a href="{{ asset('storage/' . $signature->document->file_path) }}"--}}
{{--                                   download="{{ $signature->document->title ?? 'document' }}.pdf"--}}
{{--                                   class="bg-white border border-slate-200 text-slate-700 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all flex items-center gap-2 shadow-sm">--}}
{{--                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>--}}
{{--                                    <span data-i18n="downloadBtn">Скачать PDF</span>--}}
{{--                                </a>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="pdf-container">--}}
{{--                        @if($signature->document && $signature->document->file_path)--}}
{{--                            <iframe src="{{ asset('storage/' . $signature->document->file_path) }}#toolbar=0" class="w-full h-full" frameborder="0"></iframe>--}}
{{--                        @else--}}
{{--                            <div class="flex items-center justify-center h-full text-slate-300 label-micro" data-i18n="noFile">Файл не прикреплен</div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const translations = {--}}
{{--                ru: {--}}
{{--                    backToList: "Реестр документов",--}}
{{--                    cardTitle: "Карточка документа",--}}
{{--                    statusLabel: "Статус записи",--}}
{{--                    statusSigned: "Подписано",--}}
{{--                    statusPending: "Ожидание",--}}
{{--                    idLabel: "ID Записи / Номер",--}}
{{--                    descLabel: "Описание документа",--}}
{{--                    nameLabel: "Название",--}}
{{--                    typeLabel: "Тип документа",--}}
{{--                    executorLabel: "Исполнитель",--}}
{{--                    signBtn: "Подписать",--}}
{{--                    previewLabel: "Предпросмотр документа",--}}
{{--                    fsBtn: "Во весь экран",--}}
{{--                    exitFs: "Выйти",--}}
{{--                    downloadBtn: "Скачать PDF",--}}
{{--                    noFile: "Файл не прикреплен"--}}
{{--                },--}}
{{--                tj: {--}}
{{--                    backToList: "Феҳристи ҳуҷҷатҳо",--}}
{{--                    cardTitle: "Корти ҳуҷҷат",--}}
{{--                    statusLabel: "Статуси сабт",--}}
{{--                    statusSigned: "Имзо шуд",--}}
{{--                    statusPending: "Дар интизорӣ",--}}
{{--                    idLabel: "ID-и сабт / Рақам",--}}
{{--                    descLabel: "Тавсифи ҳуҷҷат",--}}
{{--                    nameLabel: "Ном",--}}
{{--                    typeLabel: "Намуди ҳуҷҷат",--}}
{{--                    executorLabel: "Иҷрокунанда",--}}
{{--                    signBtn: "Имзо кардан",--}}
{{--                    previewLabel: "Пешнамоиши ҳуҷҷат",--}}
{{--                    fsBtn: "Экрани пурра",--}}
{{--                    exitFs: "Баромадан",--}}
{{--                    downloadBtn: "Боргирии PDF",--}}
{{--                    noFile: "Файл замима нашудааст"--}}
{{--                },--}}
{{--                en: {--}}
{{--                    backToList: "Document Registry",--}}
{{--                    cardTitle: "Document Card",--}}
{{--                    statusLabel: "Record Status",--}}
{{--                    statusSigned: "Signed",--}}
{{--                    statusPending: "Pending",--}}
{{--                    idLabel: "Record ID / Number",--}}
{{--                    descLabel: "Document Description",--}}
{{--                    nameLabel: "Title",--}}
{{--                    typeLabel: "Document Type",--}}
{{--                    executorLabel: "Executor",--}}
{{--                    signBtn: "Sign",--}}
{{--                    previewLabel: "Document Preview",--}}
{{--                    fsBtn: "Full Screen",--}}
{{--                    exitFs: "Exit",--}}
{{--                    downloadBtn: "Download PDF",--}}
{{--                    noFile: "No file attached"--}}
{{--                }--}}
{{--            };--}}

{{--            const lang = localStorage.getItem('app-lang') || 'ru';--}}
{{--            const t = translations[lang];--}}

{{--            document.querySelectorAll('[data-i18n]').forEach(el => {--}}
{{--                const key = el.getAttribute('data-i18n');--}}
{{--                if (t[key]) el.textContent = t[key];--}}
{{--            });--}}

{{--            // Функция для обновления текста кнопки FS (нужна из-за динамики)--}}
{{--            window.updateFsBtnText = (isFull) => {--}}
{{--                const btnSpan = document.querySelector('#fullScreenBtn [data-i18n]');--}}
{{--                if(btnSpan) {--}}
{{--                    btnSpan.textContent = isFull ? t.exitFs : t.fsBtn;--}}
{{--                }--}}
{{--            };--}}
{{--        });--}}

{{--        function toggleFullScreen() {--}}
{{--            const container = document.querySelector('.pdf-container');--}}
{{--            if (!document.fullscreenElement && !document.webkitFullscreenElement) {--}}
{{--                if (container.requestFullscreen) container.requestFullscreen();--}}
{{--                else if (container.webkitRequestFullscreen) container.webkitRequestFullscreen();--}}
{{--            } else {--}}
{{--                if (document.exitFullscreen) document.exitFullscreen();--}}
{{--                else if (document.webkitExitFullscreen) document.webkitExitFullscreen();--}}
{{--            }--}}
{{--        }--}}

{{--        const updateBtnState = () => {--}}
{{--            const isFull = !!(document.fullscreenElement || document.webkitFullscreenElement);--}}
{{--            if (window.updateFsBtnText) window.updateFsBtnText(isFull);--}}
{{--        };--}}

{{--        document.addEventListener('fullscreenchange', updateBtnState);--}}
{{--        document.addEventListener('webkitfullscreenchange', updateBtnState);--}}
{{--    </script>--}}
{{--@endsection--}}


@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Подключаем необходимые библиотеки для локального рендеринга .docx -->
    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
    <script src="https://unpkg.com/docx-preview/dist/docx-preview.min.js"></script>

    <div class="container mx-auto px-4 py-6 min-h-screen">
        @php
            $doc = $signature->document ?? (object)[];
            $filePath = $doc->file_path ?? '';
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $isWord = in_array($extension, ['doc', 'docx']);
            $isPdf = $extension === 'pdf';
            $fullFileUrl = $filePath ? asset('storage/' . $filePath) : '';

            // Форматирование размера файла
            $fileSize = $doc->file_size ?? 0;
            $formattedSize = $fileSize > 1048576
                ? round($fileSize / 1048576, 2) . ' МБ'
                : ($fileSize > 1024 ? round($fileSize / 1024, 1) . ' КБ' : $fileSize . ' Б');
        @endphp

        <style>
            .view-sig-page { --primary: #6366f1; --success: #10b981; --warning: #f59e0b; --danger: #ef4444; font-family: 'Inter', sans-serif !important; }

            /* Карточка с эффектом "живого" свечения */
            .form-card {
                background: #ffffff !important;
                border-radius: 1.5rem !important;
                border: 1px solid rgba(99, 102, 241, 0.15) !important;
                box-shadow: 0 4px 20px rgba(99, 102, 241, 0.08) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                position: relative;
                overflow: hidden;
            }
            .form-card::before {
                content: '';
                position: absolute;
                top: 0; left: -100%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(99,102,241,0.08), transparent);
                transition: left 0.6s ease;
                pointer-events: none;
            }
            .form-card:hover::before { left: 100%; }
            .form-card:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 8px 30px rgba(99, 102, 241, 0.15) !important;
                border-color: rgba(99, 102, 241, 0.3) !important;
            }
            .dark .form-card {
                background: #1e293b !important;
                border-color: rgba(99, 102, 241, 0.25) !important;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
            }

            /* Типографика */
            .label-micro {
                font-size: 12px !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.12em !important;
                color: #64748b !important;
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .label-micro svg { opacity: 0.8; width: 14px; height: 14px; }
            .dark .label-micro { color: #94a3b8 !important; }

            .data-text {
                font-size: 17px !important;
                font-weight: 700;
                color: #0f172a !important;
                transition: color 0.2s;
            }
            .dark .data-text { color: #f8fafc !important; }

            /* Бейджи с анимацией */
            .badge-status {
                font-size: 12px;
                font-weight: 900;
                padding: 6px 16px;
                border-radius: 999px;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                animation: badgePulse 2.5s infinite;
            }
            @keyframes badgePulse {
                0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
                50% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            }
            .badge-status.pending {
                background: rgba(244, 63, 94, 0.12) !important;
                color: #dc2626 !important;
                animation-name: badgePulseRed;
            }
            @keyframes badgePulseRed {
                0%, 100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.3); }
                50% { box-shadow: 0 0 0 6px rgba(244, 63, 94, 0); }
            }

            /* Контейнер предпросмотра */
            .preview-container {
                height: 800px;
                border-radius: 1.5rem;
                overflow: hidden;
                border: 1px solid rgba(148, 163, 184, 0.25);
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                position: relative;
                transition: all 0.3s ease;
            }
            .preview-container:hover { border-color: rgba(99, 102, 241, 0.4); }
            .dark .preview-container {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                border-color: rgba(148, 163, 184, 0.15);
            }

            .format-indicator {
                padding: 6px 14px;
                border-radius: 8px;
                color: white;
                font-size: 12px;
                font-weight: 900;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                background: linear-gradient(135deg, #6366f1, #8b5cf6);
                box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
            }

            .btn-action { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
            .btn-action:hover { transform: translateY(-1px); }

            .divider {
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.3), transparent);
                margin: 14px 0;
            }

            .animate-in { opacity: 0; transform: translateY(12px); }

            /* Настройки для рендерера docx */
            .docx-wrapper { background: transparent !important; padding: 20px !important; }
            .docx { box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important; border-radius: 8px !important; }
        </style>

        <div class="view-sig-page">
            {{-- Шапка --}}
            <div class="mb-6 flex items-center justify-between animate-in">
                <div>
                    <a href="{{ route('signatures.index') }}" class="label-micro text-indigo-500 flex items-center gap-2 mb-3 hover:text-indigo-700 transition-all group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M15 19l-7-7 7-7"/></svg>
                        <span data-i18n="backToList" class="font-semibold text-[13px]">Реестр документов</span>
                    </a>
                    <div class="flex items-center gap-4">
                        <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white" data-i18n="cardTitle">Карточка документа</h1>
                        <span class="format-indicator">{{ strtoupper($extension ?: 'N/A') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                {{-- ИНФОРМАЦИОННАЯ КАРТОЧКА --}}
                <div class="form-card p-8 animate-in">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                        {{-- Статус + Мета --}}
                        <div class="space-y-5">
                            <div class="flex items-center justify-between border-b pb-4 border-slate-100 dark:border-slate-800">
                                <span class="label-micro">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span data-i18n="statusLabel">Статус</span>
                                </span>
                                @if($signature->signed_at)
                                    <span class="badge-status bg-emerald-500/10 text-emerald-600">
                                        <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                                        <span data-i18n="statusSigned">Подписано</span>
                                    </span>
                                @else
                                    <span class="badge-status pending">
                                        <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                                        <span data-i18n="statusPending">Ожидание</span>
                                    </span>
                                @endif
                            </div>

                            <div>
                                <label class="label-micro block mb-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                                    <span data-i18n="idLabel">ID</span>
                                </label>
                                <div class="data-text text-2xl font-mono">#{{ str_pad($signature->id, 6, '0', STR_PAD_LEFT) }}</div>
                            </div>

                            <div>
                                <label class="label-micro block mb-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    <span data-i18n="numberLabel">№ Документа</span>
                                </label>
                                <div class="data-text text-lg">{{ $doc->number ?? '—' }}</div>
                            </div>
                        </div>

                        {{-- Название + Содержание --}}
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="label-micro block mb-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span data-i18n="nameLabel">Название</span>
                                </label>
                                <div class="data-text text-xl break-words">{{ $doc->title ?? '—' }}</div>
                            </div>

                            <div class="divider"></div>

                            <div>
                                <label class="label-micro block mb-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                    <span data-i18n="descLabel">Содержание</span>
                                </label>
                                <div class="text-[15px] font-medium text-slate-600 dark:text-slate-300 leading-relaxed max-h-24 overflow-y-auto pr-2">
                                    {{ $doc->content ?? 'Описание отсутствует' }}
                                </div>
                            </div>
                        </div>

                        {{-- Исполнитель + Действия --}}
                        <div class="flex flex-col justify-between">
                            <div class="text-right space-y-3">
                                <div>
                                    <label class="label-micro block mb-1.5 justify-end">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <span data-i18n="executorLabel">Создал</span>
                                    </label>
                                    <div class="data-text">{{ $signature->user->name ?? $doc->created_by ?? 'Система' }}</div>
                                    <div class="text-[12px] text-slate-400 font-semibold">{{ $signature->created_at?->format('d.m.Y H:i') ?? '—' }}</div>
                                </div>

                                <div class="divider"></div>

                                <div>
                                    <label class="label-micro block mb-1.5 justify-end">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <span data-i18n="receiverLabel">Получатель</span>
                                    </label>
                                    <div class="data-text">#{{ $doc->receiver_id ? $doc->receiver_id : '—' }}</div>
                                </div>
                            </div>

                            <div class="mt-4">
                                @if(!$signature->signed_at)
                                    <a href="{{ route('signatures.create', ['document_id' => $signature->document_id]) }}"
                                       class="btn-action w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 shadow-lg shadow-indigo-500/25">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        <span data-i18n="signBtn">Подписать + QR</span>
                                    </a>
                                @else
                                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/60 dark:from-emerald-900/20 dark:to-emerald-800/10 p-2.5 rounded-xl border border-emerald-200/60 dark:border-emerald-700/40 flex flex-col items-center">
                                        <img src="{{ asset('storage/' . $signature->signature) }}" class="max-h-10 object-contain mb-1" alt="✓">
                                        <span class="text-[9px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-tight">✓ Verified</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ПРЕДПРОСМОТР --}}
                <div class="form-card p-6 animate-in">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <span class="label-micro">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span data-i18n="previewLabel">Предпросмотр</span>
                            </span>
                            @if($isWord) <span class="text-[11px] bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 px-3 py-1 rounded-full font-bold uppercase">WORD</span> @endif
                            @if($isPdf) <span class="text-[11px] bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 px-3 py-1 rounded-full font-bold uppercase">PDF</span> @endif
                            <span class="text-[12px] text-slate-400 font-medium">• {{ $formattedSize }}</span>
                        </div>

                        {{-- Управляющие кнопки --}}
                        <div class="flex items-center gap-2">
                            @if($filePath)
                                <button id="fullScreenBtn" onclick="toggleFullScreen()" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-md shadow-indigo-500/20">
                                    <span data-i18n="fsBtn">Во весь экран</span>
                                </button>
                                <a href="{{ $fullFileUrl }}" download="{{ $doc->title ?? 'document' }}.{{ $extension }}" class="bg-white border border-slate-200 text-slate-700 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-200 px-4 py-2 rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                                    <span data-i18n="downloadBtn">Скачать</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Блок самого плеера --}}
                    <div id="previewBox" class="preview-container">
                        @if($filePath)
                            @if($extension === 'docx')
                                <!-- Локальный асинхронный рендеринг DOCX файла на клиенте -->
                                <div id="word-preview" class="w-full h-full overflow-y-auto bg-white/80 dark:bg-slate-900/40" data-url="{{ $fullFileUrl }}"></div>
                            @else
                                <!-- Стандартный Iframe для PDF, RTF и старых XLS/DOC шлюзов -->
                                @php
                                    if (in_array($extension, ['doc', 'xls', 'xlsx'])) {
                                        $iframeSrc = 'https://view.officeapps.live.com/op/view.aspx?src=' . rawurlencode($fullFileUrl);
                                    } elseif ($extension === 'rtf') {
                                        $iframeSrc = $fullFileUrl;
                                    } else {
                                        $iframeSrc = $fullFileUrl . '#toolbar=0&view=FitH';
                                    }
                                @endphp
                                <iframe src="{{ $iframeSrc }}" class="w-full h-full border-0" loading="lazy" title="Document Preview"></iframe>
                            @endif
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-slate-400 gap-2">
                                <svg class="w-12 h-12 stroke-current opacity-60" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <div class="label-micro" data-i18n="noFile">Файл не загружен</div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Инициализация Word превью, если блок присутствует на странице
            const wordContainer = document.getElementById("word-preview");
            if (wordContainer) {
                const fileUrl = wordContainer.getAttribute("data-url");
                fetch(fileUrl)
                    .then(response => {
                        if (!response.ok) throw new Error('Сбой сети при получении файла');
                        return response.blob();
                    })
                    .then(blob => {
                        docx.renderAsync(blob, wordContainer)
                            .then(() => console.log("docx-preview: рендеринг успешно завершен"))
                            .catch(e => console.error("Ошибка библиотеки docx-preview:", e));
                    })
                    .catch(err => {
                        console.error("Не удалось загрузить файл по URL:", err);
                        wordContainer.innerHTML = `<div class="flex h-full items-center justify-center text-rose-500 font-semibold p-4 text-center">Не удалось отобразить документ. Проверьте соединение или откройте на внешнем сервере.</div>`;
                    });
            }

            // Полные переводы на 3 языка
            const translations = {
                ru: {
                    backToList: "Реестр документов",
                    cardTitle: "Карточка документа",
                    statusLabel: "Статус",
                    statusSigned: "Подписано",
                    statusPending: "Ожидание",
                    idLabel: "ID",
                    numberLabel: "№ Документа",
                    nameLabel: "Название",
                    descLabel: "Содержание",
                    typeLabel: "Тип",
                    executorLabel: "Создал",
                    receiverLabel: "Получатель",
                    deadlineLabel: "Дедлайн",
                    signBtn: "Подписать + QR",
                    previewLabel: "Предпросмотр",
                    fsBtn: "Во весь экран",
                    exitFs: "Выйти",
                    downloadBtn: "Скачать",
                    noFile: "Файл не загружен"
                },
                tj: {
                    backToList: "Феҳристи ҳуҷҷатҳо",
                    cardTitle: "Корти ҳуҷҷат",
                    statusLabel: "Статус",
                    statusSigned: "Имзо шуд",
                    statusPending: "Интизорӣ",
                    idLabel: "ID",
                    numberLabel: "Рақами ҳуҷҷат",
                    nameLabel: "Ном",
                    descLabel: "Мазмун",
                    typeLabel: "Намуд",
                    executorLabel: "Сохт",
                    receiverLabel: "Гиранда",
                    deadlineLabel: "Муҳлат",
                    signBtn: "Имзо + QR",
                    previewLabel: "Пешнамоиш",
                    fsBtn: "Экрани пурра",
                    exitFs: "Баромадан",
                    downloadBtn: "Боргирӣ",
                    noFile: "Файл нест"
                },
                en: {
                    backToList: "Document Registry",
                    cardTitle: "Document Card",
                    statusLabel: "Status",
                    statusSigned: "Signed",
                    statusPending: "Pending",
                    idLabel: "ID",
                    numberLabel: "Document No.",
                    nameLabel: "Title",
                    descLabel: "Content",
                    typeLabel: "Type",
                    executorLabel: "Created By",
                    receiverLabel: "Receiver",
                    deadlineLabel: "Deadline",
                    signBtn: "Sign + QR",
                    previewLabel: "Preview",
                    fsBtn: "Full Screen",
                    exitFs: "Exit",
                    downloadBtn: "Download",
                    noFile: "No file uploaded"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang] || translations.ru;

            // Применяем локализацию к атрибутам data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) {
                    const icon = el.querySelector('svg');
                    el.textContent = t[key];
                    if (icon) el.insertBefore(icon, el.firstChild);
                }
            });

            // Анимация плавного появления блоков
            document.querySelectorAll('.animate-in').forEach((el, i) => {
                setTimeout(() => {
                    el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 100 + (i * 100));
            });

            window.updateFsBtnText = (isFull) => {
                const btnSpan = document.querySelector('#fullScreenBtn [data-i18n]');
                if(btnSpan) btnSpan.textContent = isFull ? t.exitFs : t.fsBtn;
            };
        });

        function toggleFullScreen() {
            const el = document.getElementById('previewBox');
            if (!el) return;
            if (!document.fullscreenElement && !document.webkitFullscreenElement) {
                el.requestFullscreen?.() || el.webkitRequestFullscreen?.() || el.msRequestFullscreen?.();
            } else {
                document.exitFullscreen?.() || document.webkitExitFullscreen?.() || document.msExitFullscreen?.();
            }
        }

        const updateBtnState = () => {
            const isFull = !!(document.fullscreenElement || document.webkitFullscreenElement);
            if (window.updateFsBtnText) window.updateFsBtnText(isFull);
        };

        document.addEventListener('fullscreenchange', updateBtnState);
        document.addEventListener('webkitfullscreenchange', updateBtnState);
    </script>
@endsection
