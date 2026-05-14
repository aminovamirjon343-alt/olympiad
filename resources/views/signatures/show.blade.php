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

    <div class="container mx-auto px-4 py-6 min-h-screen">
        @php
            $filePath = $signature->document->file_path ?? '';
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $isWord = in_array(strtolower($extension), ['doc', 'docx']);
            $isPdf = strtolower($extension) === 'pdf';
            // Ссылка на Google Docs Viewer для предпросмотра Word
            $previewUrl = $isWord
                ? 'https://docs.google.com/gview?url=' . asset('storage/' . $filePath) . '&embedded=true'
                : asset('storage/' . $filePath);
        @endphp

        <style>
            .view-sig-page {
                --primary-color: #6366f1;
                font-family: 'Inter', sans-serif !important;
            }

            .view-sig-page *, .view-sig-page label, .view-sig-page p, .view-sig-page span {
                font-family: 'Inter', sans-serif !important;
            }

            .form-card {
                background: #ffffff !important;
                border-radius: 1.5rem;
                border: 1px solid rgba(0, 0, 0, 0.08);
                box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            }

            .dark .form-card {
                background: #1e293b !important;
                border-color: rgba(255,255,255,0.1);
            }

            .label-micro {
                font-size: 10px !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.1em !important;
                color: #94a3b8;
            }

            .data-text {
                font-size: 15px !important;
                font-weight: 700;
                color: #1e293b;
            }
            .dark .data-text { color: #f8fafc; }

            .badge-status {
                font-size: 10px;
                font-weight: 900;
                padding: 4px 12px;
                border-radius: 8px;
                text-transform: uppercase;
            }

            .preview-container {
                height: 800px;
                border-radius: 1.5rem;
                overflow: hidden;
                border: 1px solid rgba(0,0,0,0.1);
                background: #f1f5f9;
                position: relative;
            }

            .format-indicator {
                padding: 4px 10px;
                border-radius: 6px;
                color: white;
                font-size: 10px;
                font-weight: 900;
            }
        </style>

        <div class="view-sig-page">
            {{-- Шапка --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('signatures.index') }}" class="label-micro text-indigo-500 flex items-center gap-2 mb-2 hover:text-indigo-700 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                        <span data-i18n="backToList">Реестр документов</span>
                    </a>
                    <div class="flex items-center gap-4">
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white" data-i18n="cardTitle">Карточка документа</h1>
                        <span class="format-indicator {{ $isWord ? 'bg-blue-600' : 'bg-red-600' }}">
                            {{ strtoupper($extension ?: 'N/A') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">

                {{-- ИНФОРМАЦИОННАЯ КАРТОЧКА --}}
                <div class="form-card p-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                        {{-- Статус --}}
                        <div class="space-y-6">
                            <div class="flex items-center justify-between border-b pb-4 border-slate-50 dark:border-slate-800">
                                <span class="label-micro" data-i18n="statusLabel">Статус</span>
                                @if($signature->signed_at)
                                    <span class="badge-status bg-emerald-500/10 text-emerald-600" data-i18n="statusSigned">Подписано</span>
                                @else
                                    <span class="badge-status bg-rose-500/10 text-rose-600" data-i18n="statusPending">Ожидание</span>
                                @endif
                            </div>
                            <div>
                                <label class="label-micro block mb-1" data-i18n="idLabel">ID Номер</label>
                                <div class="data-text text-xl">#{{ str_pad($signature->id, 6, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>

                        {{-- Описание --}}
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="label-micro block mb-1" data-i18n="nameLabel">Название документа</label>
                                <div class="data-text truncate">{{ $signature->document->title ?? '—' }}</div>
                            </div>
                            <div>
                                <label class="label-micro block mb-1" data-i18n="descLabel">Краткое содержание</label>
                                <div class="text-sm font-medium text-slate-500 leading-relaxed">
                                    {{ $signature->document->content ?? 'Описание отсутствует' }}
                                </div>
                            </div>
                        </div>

                        {{-- Исполнитель и Подпись --}}
                        <div class="flex flex-col justify-between">
                            <div class="text-right">
                                <label class="label-micro block mb-1" data-i18n="executorLabel">Создал</label>
                                <div class="data-text">{{ $signature->user->name ?? 'Система' }}</div>
                                <div class="text-[11px] text-slate-400 font-bold">{{ $signature->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                            <div class="mt-4">
                                @if(!$signature->signed_at)
                                    <a href="{{ route('signatures.edit', $signature->id) }}"
                                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 transition-all shadow-lg shadow-indigo-500/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        <span data-i18n="signBtn">Подписать сейчас</span>
                                    </a>
                                @else
                                    <div class="bg-slate-50 dark:bg-slate-800/50 p-2 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 flex flex-col items-center">
                                        <img src="{{ $signature->signature }}" class="max-h-10 object-contain dark:invert opacity-80" alt="Sig">
                                        <span class="text-[8px] font-bold text-slate-400 mt-1 uppercase">Digital Signature Verified</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ПРЕДПРОСМОТР --}}
                <div class="form-card p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <span class="label-micro" data-i18n="previewLabel">Предпросмотр</span>
                            @if($isWord)
                                <span class="text-[9px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-bold uppercase">Online Viewer</span>
                            @endif
                        </div>

                        <div class="flex gap-3">
                            @if($filePath)
                                <button onclick="toggleFullScreen()" class="bg-slate-100 text-slate-600 p-2 rounded-lg hover:bg-indigo-600 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                </button>

                                <a href="{{ asset('storage/' . $filePath) }}" download
                                   class="bg-slate-900 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    <span data-i18n="downloadBtn">Скачать</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="preview-container" id="previewBox">
                        @if($filePath)
                            @if($isPdf)
                                <iframe src="{{ $previewUrl }}#toolbar=0" class="w-full h-full" frameborder="0"></iframe>
                            @elseif($isWord)
                                <iframe src="{{ $previewUrl }}" class="w-full h-full" frameborder="0"></iframe>
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-slate-400">
                                    <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    <p class="label-micro" data-i18n="noPreview">Предпросмотр недоступен для этого формата</p>
                                </div>
                            @endif
                        @else
                            <div class="flex items-center justify-center h-full text-slate-300 label-micro" data-i18n="noFile">Файл не найден</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    backToList: "Реестр документов",
                    cardTitle: "Карточка документа",
                    statusLabel: "Статус",
                    statusSigned: "Подписано",
                    statusPending: "Ожидание",
                    idLabel: "ID Номер",
                    descLabel: "Краткое содержание",
                    nameLabel: "Название документа",
                    executorLabel: "Создал",
                    signBtn: "Подписать сейчас",
                    previewLabel: "Предпросмотр",
                    downloadBtn: "Скачать",
                    noFile: "Файл не найден",
                    noPreview: "Предпросмотр недоступен"
                },
                tj: {
                    backToList: "Феҳристи ҳуҷҷатҳо",
                    cardTitle: "Корти ҳуҷҷат",
                    statusLabel: "Статус",
                    statusSigned: "Имзо шуд",
                    statusPending: "Интизорӣ",
                    idLabel: "ID Рақам",
                    descLabel: "Мазмуни кӯтоҳ",
                    nameLabel: "Номи ҳуҷҷат",
                    executorLabel: "Сохт",
                    signBtn: "Имзо кардан",
                    previewLabel: "Пешнамоиш",
                    downloadBtn: "Боргирӣ",
                    noFile: "Файл ёфт нашуд",
                    noPreview: "Пешнамоиш дастнорас аст"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });
        });

        function toggleFullScreen() {
            const el = document.getElementById('previewBox');
            if (!document.fullscreenElement) {
                el.requestFullscreen().catch(err => alert("Error: " + err.message));
            } else {
                document.exitFullscreen();
            }
        }
    </script>
@endsection
