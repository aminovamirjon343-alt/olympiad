{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-6 min-h-screen">--}}

{{--        <style>--}}
{{--            .edit-sig-page {--}}
{{--                --primary-color: #6366f1;--}}
{{--                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;--}}
{{--            }--}}

{{--            .navbar-style-text,--}}
{{--            .theme-heading,--}}
{{--            label,--}}
{{--            button,--}}
{{--            .btn-update {--}}
{{--                font-weight: 700 !important;--}}
{{--                letter-spacing: -0.02em !important;--}}
{{--                text-transform: none;--}}
{{--            }--}}

{{--            label, .badge-old, #placeholder-hint span {--}}
{{--                letter-spacing: 0.05em !important;--}}
{{--            }--}}

{{--            .form-card {--}}
{{--                background: rgba(255, 255, 255, 0.96) !important;--}}
{{--                backdrop-filter: blur(14px);--}}
{{--                border-radius: 2rem;--}}
{{--                border: 2px solid rgba(0, 0, 0, 0.12);--}}
{{--                box-shadow: 0 10px 30px rgba(0,0,0,0.06), 0 2px 10px rgba(0,0,0,0.03);--}}
{{--                overflow: hidden;--}}
{{--            }--}}

{{--            .dark .form-card {--}}
{{--                background: #1e293b !important;--}}
{{--                border-color: rgba(255,255,255,0.12);--}}
{{--            }--}}

{{--            .pad-container {--}}
{{--                background-color: rgba(255,255,255,0.04) !important;--}}
{{--                border: 2px dashed rgba(99,102,241,0.25);--}}
{{--                transition: all .3s ease;--}}
{{--            }--}}

{{--            .dark .pad-container {--}}
{{--                border-color: rgba(255,255,255,0.12);--}}
{{--            }--}}

{{--            .btn-update{--}}
{{--                background:#6366f1;--}}
{{--                color:#ffffff !important;--}}
{{--                font-weight: 900 !important;--}}
{{--                text-transform:uppercase;--}}
{{--                letter-spacing:.08em !important;--}}
{{--                border:2px solid rgba(255,255,255,.08);--}}
{{--                box-shadow: 0 10px 25px rgba(99,102,241,.25);--}}
{{--                transition:.25s ease;--}}
{{--            }--}}

{{--            .btn-update:hover{--}}
{{--                transform:translateY(-2px);--}}
{{--            }--}}

{{--            .old-sig-display {--}}
{{--                background: rgba(255,255,255,0.05);--}}
{{--                border: 2px solid rgba(255,255,255,0.08);--}}
{{--                border-radius: 1.25rem;--}}
{{--                padding: 1.4rem;--}}
{{--            }--}}

{{--            .dark .old-signature {--}}
{{--                filter: invert(1) brightness(2);--}}
{{--                opacity: 0.85 !important;--}}
{{--            }--}}

{{--            .badge-old {--}}
{{--                position: absolute;--}}
{{--                top: -8px;--}}
{{--                right: -8px;--}}
{{--                background: #f43f5e;--}}
{{--                color: white;--}}
{{--                font-size: 9px;--}}
{{--                font-weight: 900 !important;--}}
{{--                padding: 4px 9px;--}}
{{--                border-radius: 999px;--}}
{{--                box-shadow: 0 0 14px rgba(244,63,94,.35);--}}
{{--                z-index: 20;--}}
{{--            }--}}
{{--        </style>--}}

{{--        <div class="edit-sig-page">--}}

{{--            <div class="mb-7 flex items-center justify-between">--}}
{{--                <div>--}}
{{--                    <a href="{{ route('signatures.show', $signature->id) }}"--}}
{{--                       class="text-[11px] font-black uppercase tracking-[0.18em]--}}
{{--                              text-indigo-500 flex items-center gap-2 mb-2--}}
{{--                              hover:gap-3 transition-all">--}}
{{--                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">--}}
{{--                            <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>--}}
{{--                        </svg>--}}
{{--                        <span data-i18n="backBtn">Назад к реестру</span>--}}
{{--                    </a>--}}

{{--                    <h1 class="text-3xl navbar-style-text theme-heading" data-i18n="pageTitle">--}}
{{--                        Изменение подписи--}}
{{--                    </h1>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-6">--}}

{{--                <div class="form-card">--}}
{{--                    <form method="POST" action="{{ route('signatures.update', $signature->id) }}" id="signatureForm" class="p-7 space-y-7">--}}
{{--                        @csrf--}}
{{--                        @method('PUT')--}}

{{--                        <div>--}}
{{--                            <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 block mb-2" data-i18n="labelDoc">--}}
{{--                                Документ--}}
{{--                            </label>--}}
{{--                            <div class="text-lg navbar-style-text text-slate-800 dark:text-white py-3 border-b-2 border-indigo-500/20">--}}
{{--                                {{ $signature->document->title }}--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <div class="flex items-center justify-between mb-3">--}}
{{--                                <label class="text-[11px] font-black uppercase tracking-widest text-indigo-500" data-i18n="labelNewSig">--}}
{{--                                    Новый оттиск--}}
{{--                                </label>--}}
{{--                                <button type="button" id="clearBtn" class="bg-rose-500/10 text-rose-500 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tight hover:bg-rose-500 hover:text-white transition" data-i18n="clearBtn">--}}
{{--                                    Очистить--}}
{{--                                </button>--}}
{{--                            </div>--}}

{{--                            <div class="relative pad-container rounded-[1.7rem] overflow-hidden">--}}
{{--                                <canvas id="signature-pad" class="w-full h-52 cursor-crosshair touch-none"></canvas>--}}
{{--                                <div id="placeholder-hint" class="absolute inset-0 flex items-center justify-center pointer-events-none">--}}
{{--                                    <span class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 opacity-30" data-i18n="sigPlaceholder">--}}
{{--                                        Здесь ваша подпись--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <input type="hidden" name="signature" id="signatureInput">--}}

{{--                        <button type="submit" class="w-full btn-update py-4 rounded-2xl text-[12px]" data-i18n="submitBtn">--}}
{{--                            Подтвердить и обновить PDF--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </div>--}}

{{--                <div class="space-y-6">--}}
{{--                    <div class="form-card p-7">--}}
{{--                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-5 block text-center" data-i18n="labelCurrent">--}}
{{--                            Текущий вариант--}}
{{--                        </label>--}}
{{--                        <div class="relative old-sig-display flex items-center justify-center">--}}
{{--                            <span class="badge-old tracking-tight italic" data-i18n="badgeArchive">--}}
{{--                                Архив--}}
{{--                            </span>--}}
{{--                            <img src="{{ $signature->signature }}" class="old-signature max-h-24 object-contain" alt="Old Signature">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="bg-indigo-950 rounded-[2.2rem] p-7 text-white shadow-2xl relative overflow-hidden border-[2px] border-white/15">--}}
{{--                        <div class="absolute -right-10 -bottom-10 opacity-10">--}}
{{--                            <svg class="w-52 h-52" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                <path d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z"/>--}}
{{--                            </svg>--}}
{{--                        </div>--}}
{{--                        <div class="bg-indigo-900 rounded-[1.8rem] p-6 text-white shadow-xl relative overflow-hidden border border-white/10">--}}
{{--                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-indigo-400 rounded-r-full"></div>--}}
{{--                            <div class="relative z-10">--}}
{{--                                <div class="flex items-center gap-3 mb-4">--}}
{{--                                    <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center border border-white/10">--}}
{{--                                        <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">--}}
{{--                                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                    <h4 class="text-[10px] font-black uppercase tracking-[0.22em] text-indigo-200" data-i18n="infoTitle">Внимание</h4>--}}
{{--                                </div>--}}
{{--                                <p class="text-[12px] font-medium leading-relaxed opacity-90 navbar-style-text" data-i18n="infoText">--}}
{{--                                    При обновлении подписи система автоматически перегенерирует PDF-файл. Старый файл будет удален.--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const translations = {--}}
{{--                ru: {--}}
{{--                    backBtn: "Назад к реестру",--}}
{{--                    pageTitle: "Изменение подписи",--}}
{{--                    labelDoc: "Документ",--}}
{{--                    labelNewSig: "Новый оттиск",--}}
{{--                    clearBtn: "Очистить",--}}
{{--                    sigPlaceholder: "Здесь ваша подпись",--}}
{{--                    submitBtn: "Подтвердить и обновить PDF",--}}
{{--                    labelCurrent: "Текущий вариант",--}}
{{--                    badgeArchive: "Архив",--}}
{{--                    infoTitle: "Внимание",--}}
{{--                    infoText: "При обновлении подписи система автоматически перегенерирует PDF-файл. Старый файл будет удален.",--}}
{{--                    alertEmpty: "Пожалуйста, оставьте подпись"--}}
{{--                },--}}
{{--                tj: {--}}
{{--                    backBtn: "Бозгашт ба феҳрист",--}}
{{--                    pageTitle: "Тағйири имзо",--}}
{{--                    labelDoc: "Ҳуҷҷат",--}}
{{--                    labelNewSig: "Нақши нав",--}}
{{--                    clearBtn: "Тоза кардан",--}}
{{--                    sigPlaceholder: "Имзои шумо дар ин ҷо",--}}
{{--                    submitBtn: "Тасдиқ ва навсозии PDF",--}}
{{--                    labelCurrent: "Нусхаи ҷорӣ",--}}
{{--                    badgeArchive: "Архив",--}}
{{--                    infoTitle: "Диққат",--}}
{{--                    infoText: "Ҳангоми навсозии имзо, система ба таври худкор файли PDF-ро аз нав таҳия мекунад. Файли кӯҳна нест карда мешавад.",--}}
{{--                    alertEmpty: "Лутфан, имзо гузоред"--}}
{{--                },--}}
{{--                en: {--}}
{{--                    backBtn: "Back to Registry",--}}
{{--                    pageTitle: "Edit Signature",--}}
{{--                    labelDoc: "Document",--}}
{{--                    labelNewSig: "New Impression",--}}
{{--                    clearBtn: "Clear",--}}
{{--                    sigPlaceholder: "Your signature here",--}}
{{--                    submitBtn: "Confirm & Update PDF",--}}
{{--                    labelCurrent: "Current Version",--}}
{{--                    badgeArchive: "Archive",--}}
{{--                    infoTitle: "Attention",--}}
{{--                    infoText: "When updating the signature, the system will automatically regenerate the PDF. The old file will be deleted.",--}}
{{--                    alertEmpty: "Please provide a signature"--}}
{{--                }--}}
{{--            };--}}

{{--            const lang = localStorage.getItem('app-lang') || 'ru';--}}
{{--            const t = translations[lang];--}}

{{--            // Применяем переводы--}}
{{--            document.querySelectorAll('[data-i18n]').forEach(el => {--}}
{{--                const key = el.getAttribute('data-i18n');--}}
{{--                if (t[key]) el.textContent = t[key];--}}
{{--            });--}}

{{--            const canvas = document.getElementById('signature-pad');--}}
{{--            const hint = document.getElementById('placeholder-hint');--}}
{{--            const isDark = document.documentElement.classList.contains('dark');--}}

{{--            const signaturePad = new SignaturePad(canvas, {--}}
{{--                backgroundColor: 'rgba(255,255,255,0)',--}}
{{--                penColor: isDark ? '#ffffff' : '#0f172a',--}}
{{--                minWidth: 2,--}}
{{--                maxWidth: 4--}}
{{--            });--}}

{{--            function resizeCanvas() {--}}
{{--                const ratio = Math.max(window.devicePixelRatio || 1, 1);--}}
{{--                canvas.width = canvas.offsetWidth * ratio;--}}
{{--                canvas.height = canvas.offsetHeight * ratio;--}}
{{--                canvas.getContext("2d").scale(ratio, ratio);--}}
{{--                signaturePad.clear();--}}
{{--                hint.style.opacity = '1';--}}
{{--            }--}}

{{--            window.addEventListener('resize', resizeCanvas);--}}
{{--            resizeCanvas();--}}

{{--            ['mousedown', 'touchstart'].forEach(type => {--}}
{{--                canvas.addEventListener(type, () => hint.style.opacity = '0');--}}
{{--            });--}}

{{--            document.getElementById('clearBtn').addEventListener('click', () => {--}}
{{--                signaturePad.clear();--}}
{{--                hint.style.opacity = '1';--}}
{{--            });--}}

{{--            document.getElementById('signatureForm').addEventListener('submit', function (e) {--}}
{{--                if (signaturePad.isEmpty()) {--}}
{{--                    e.preventDefault();--}}
{{--                    alert(t.alertEmpty);--}}
{{--                } else {--}}
{{--                    document.getElementById('signatureInput').value = signaturePad.toDataURL();--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}


@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6 min-h-screen">
        @php
            $extension = pathinfo($signature->document->file_path, PATHINFO_EXTENSION);
            $isWord = in_array(strtolower($extension), ['doc', 'docx']);

            // Собираем текст для QR, идентичный логике страницы создания
            $doc = $signature->document;
            $senderName = $doc->sender->name ?? 'Система';
            $signerName = auth()->user()->name ?? 'Пользователь';
            $dateSent = $doc->created_at ? $doc->created_at->format('d.m.Y H:i') : date('d.m.Y H:i');
            $dateSigned = date('d.m.Y H:i');

            $qrText = "Документ: {$doc->title}\n" .
                      "От кого: {$senderName}\n" .
                      "Кто подписал: {$signerName}\n" .
                      "Дата отправки: {$dateSent}\n" .
                      "Дата подписания: {$dateSigned}";

            // URL для рендеринга картинки на фронтенде
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrText);
        @endphp

        <style>
            .edit-sig-page {
                --primary-color: #6366f1;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }

            .navbar-style-text, .theme-heading, label, button, .btn-update {
                font-weight: 700 !important;
                letter-spacing: -0.02em !important;
                text-transform: none;
            }

            .form-card {
                background: rgba(255, 255, 255, 0.96) !important;
                backdrop-filter: blur(14px);
                border-radius: 2rem;
                border: 2px solid rgba(0, 0, 0, 0.12);
                box-shadow: 0 10px 30px rgba(0,0,0,0.06);
                overflow: hidden;
            }

            .dark .form-card { background: #1e293b !important; border-color: rgba(255,255,255,0.12); }

            .pad-container {
                background-color: rgba(0,0,0,0.02) !important;
                border: 2px dashed {{ $isWord ? '#2b579a' : '#6366f1' }};
                transition: all .3s ease;
            }
            .dark .pad-container { background-color: rgba(255,255,255,0.02) !important; }

            .btn-update {
                background: {{ $isWord ? '#2b579a' : '#6366f1' }};
                color: #ffffff !important;
                font-weight: 900 !important;
                text-transform: uppercase;
                letter-spacing: .08em !important;
                border: 2px solid rgba(255,255,255,.08);
                box-shadow: 0 10px 25px rgba(0,0,0,.15);
                transition: .25s ease;
            }

            .btn-update:hover { transform: translateY(-2px); opacity: 0.9; }

            .old-sig-display {
                background: rgba(0,0,0,0.02);
                border: 2px solid rgba(0,0,0,0.05);
                border-radius: 1.25rem;
                padding: 1.4rem;
            }

            .format-badge {
                padding: 2px 8px;
                border-radius: 6px;
                font-size: 10px;
                font-weight: 900;
                color: white;
                text-transform: uppercase;
                margin-left: 10px;
            }
        </style>

        <div class="edit-sig-page">
            <div class="mb-7 flex items-center justify-between">
                <div>
                    <a href="{{ route('signatures.show', $signature->id) }}"
                       class="text-[11px] font-black uppercase tracking-[0.18em] text-indigo-500 flex items-center gap-2 mb-2 hover:gap-3 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span data-i18n="backBtn">Назад</span>
                    </a>

                    <div class="flex items-center">
                        <h1 class="text-3xl navbar-style-text theme-heading" data-i18n="pageTitle">Обновление QR-защиты</h1>
                        <span class="format-badge {{ $isWord ? 'bg-blue-600' : 'bg-red-600' }}">
                            {{ $extension }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- ЛЕВАЯ КОЛОНКА (ФОРМА) --}}
                <div class="form-card">
                    <form method="POST" action="{{ route('signatures.update', $signature->id) }}" id="signatureForm" class="p-7 space-y-7">
                        @csrf
                        @method('PUT')

                        {{-- Текст штампа улетает в контроллер в эту переменную --}}
                        <input type="hidden" name="qr_payload" id="qrPayloadInput" value="{{ $qrText }}">

                        <div>
                            <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 block mb-2" data-i18n="labelDoc">Документ</label>
                            <div class="text-lg navbar-style-text text-slate-800 dark:text-white py-3 border-b-2 border-indigo-500/20 truncate">
                                {{ $signature->document->title }}
                            </div>
                        </div>

                        <div>
                            <label class="text-[11px] font-black uppercase tracking-widest text-indigo-500 block mb-3" data-i18n="labelNewSig">Новый QR-код Верификации</label>

                            <div class="pad-container rounded-[1.7rem] p-6 flex flex-col items-center justify-center min-h-52">
                                <div class="bg-white p-3 rounded-2xl shadow-md border border-slate-100 flex items-center justify-center">
                                    <img src="{{ $qrUrl }}" alt="New QR Verification" class="w-[120px] h-[120px] object-contain block">
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-[0.15em] text-slate-400 mt-3 block text-center">Verified DocSign</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-update py-4 rounded-2xl text-[12px]">
                            <span data-i18n="submitBtn">Обновить документ</span> ({{ strtoupper($extension) }})
                        </button>
                    </form>
                </div>

                {{-- ПРАВАЯ КОЛОНКА (ИНФОРМАЦИЯ) --}}
                <div class="space-y-6">
                    <div class="form-card p-7">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-5 block text-center" data-i18n="labelCurrent">Предыдущий QR Штамп</label>
                        <div class="relative old-sig-display flex items-center justify-center bg-slate-50 dark:bg-slate-900 rounded-2xl p-4">
                            @if($signature->signature && Storage::disk('public')->exists($signature->signature))
                                <img src="{{ asset('storage/' . $signature->signature) }}" class="max-h-32 object-contain rounded-xl" alt="Current QR Signature">
                            @else
                                <div class="text-center py-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                                    <i class="bi bi-qr-code text-3xl block mb-1 opacity-40"></i>
                                    Файл штампа не найден
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-[2.2rem] p-7 text-white shadow-2xl relative overflow-hidden border-[2px] border-white/15">
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h4 class="text-[10px] font-black uppercase tracking-[0.22em] text-indigo-200" data-i18n="infoTitle">Внимание</h4>
                            </div>
                            <p class="text-[12px] font-medium leading-relaxed opacity-90" id="infoTextContainer">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    backBtn: "Назад",
                    pageTitle: "Обновление QR-защиты",
                    labelDoc: "Документ",
                    labelNewSig: "Новый QR-код Верификации",
                    submitBtn: "Обновить документ",
                    labelCurrent: "Предыдущий QR Штамп",
                    infoTitle: "Внимание",
                    infoTextPdf: "При обновлении штампа система полностью перегенерирует PDF-документ. Текущий QR-код будет замещён актуальной версией, а старый файл удалён из системы для оптимизации памяти.",
                    infoTextWord: "Для документов Word (.docx) штамп защиты перезапишется в структуре файла. Убедитесь, что формат файла корректен."
                },
                tj: {
                    backBtn: "Бозгашт",
                    pageTitle: "Навсозии муҳофизати QR",
                    labelDoc: "Ҳуҷҷат",
                    labelNewSig: "QR-коди нави тасдиқкунанда",
                    submitBtn: "Навсозии ҳуҷҷат",
                    labelCurrent: "Муҳри QR-и қаблӣ",
                    infoTitle: "Диққат",
                    infoTextPdf: "Ҳангоми навсозии муҳр система ҳуҷҷати PDF-ро комилан аз нав месозад. QR-коди ҷорӣ бо нусхаи нав иваз карда шуда, файли кӯҳна барои сарфаи хотира нест карда мешавад.",
                    infoTextWord: "Барои ҳуҷҷатҳои Word (.docx) муҳри муҳофизатӣ дар сохтори файл аз нав навишта мешавад. Боварӣ ҳосил кунед, ки формати файл дуруст аст."
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            // Применяем переводы атрибутов data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // Подставляем информационный текст динамически в зависимости от формата
            const isWordDoc = "{{ $isWord }}";
            const infoContainer = document.getElementById('infoTextContainer');
            if (infoContainer) {
                infoContainer.textContent = isWordDoc ? t.infoTextWord : t.infoTextPdf;
            }
        });
    </script>
@endsection
