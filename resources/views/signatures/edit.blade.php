@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6 min-h-screen">

        <style>
            .edit-sig-page {
                --primary-color: #6366f1;
                /* Применяем шрифт навбара ко всему контейнеру страницы */
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }

            /* Ваш эталонный стиль навбара */
            .navbar-style-text,
            .theme-heading,
            label,
            button,
            .btn-update {
                font-weight: 700 !important;
                letter-spacing: -0.02em !important;
                text-transform: none;
            }

            /* Специфические настройки для мелких подписей (caps) */
            label, .badge-old, #placeholder-hint span {
                letter-spacing: 0.05em !important; /* Для капса чуть больше разрядка */
            }

            .form-card {
                background: rgba(255, 255, 255, 0.96) !important;
                backdrop-filter: blur(14px);
                border-radius: 2rem;
                border: 2px solid rgba(0, 0, 0, 0.12);
                box-shadow: 0 10px 30px rgba(0,0,0,0.06), 0 2px 10px rgba(0,0,0,0.03);
                overflow: hidden;
            }

            .dark .form-card {
                background: #1e293b !important;
                border-color: rgba(255,255,255,0.12);
            }

            .pad-container {
                background-color: rgba(255,255,255,0.04) !important;
                border: 2px dashed rgba(99,102,241,0.25);
                transition: all .3s ease;
            }

            .dark .pad-container {
                border-color: rgba(255,255,255,0.12);
            }

            .btn-update{
                background:#6366f1;
                color:#ffffff !important;
                font-weight: 900 !important; /* Усиливаем акцент на кнопке */
                text-transform:uppercase;
                letter-spacing:.08em !important;
                border:2px solid rgba(255,255,255,.08);
                box-shadow: 0 10px 25px rgba(99,102,241,.25);
                transition:.25s ease;
            }

            .btn-update:hover{
                transform:translateY(-2px);
            }

            .old-sig-display {
                background: rgba(255,255,255,0.05);
                border: 2px solid rgba(255,255,255,0.08);
                border-radius: 1.25rem;
                padding: 1.4rem;
            }

            .dark .old-signature {
                filter: invert(1) brightness(2);
                opacity: 0.85 !important;
            }

            .badge-old {
                position: absolute;
                top: -8px;
                right: -8px;
                background: #f43f5e;
                color: white;
                font-size: 9px;
                font-weight: 900 !important;
                padding: 4px 9px;
                border-radius: 999px;
                box-shadow: 0 0 14px rgba(244,63,94,.35);
                z-index: 20;
            }
        </style>

        <div class="edit-sig-page">

            <div class="mb-7 flex items-center justify-between">
                <div>

                    <a href="{{ route('signatures.show', $signature->id) }}"
                       class="text-[11px] font-black uppercase tracking-[0.18em]
                              text-indigo-500 flex items-center gap-2 mb-2
                              hover:gap-3 transition-all">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24"
                             stroke-width="3">

                            <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>

                        Назад к реестру
                    </a>

                    <h1 class="text-3xl navbar-style-text theme-heading">
                        Изменение подписи
                    </h1>

                </div>
            </div>

            <div class="max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- LEFT -->

                <div class="form-card">

                    <form method="POST"
                          action="{{ route('signatures.update', $signature->id) }}"
                          id="signatureForm"
                          class="p-7 space-y-7">

                        @csrf
                        @method('PUT')

                        <div>

                            <label class="text-[11px]
                                          font-black
                                          uppercase
                                          tracking-widest
                                          text-slate-400
                                          block
                                          mb-2">

                                Документ
                            </label>

                            <div class="text-lg navbar-style-text
                                        text-slate-800
                                        dark:text-white
                                        py-3
                                        border-b-2
                                        border-indigo-500/20">

                                {{ $signature->document->title }}
                            </div>

                        </div>

                        <div>

                            <div class="flex items-center justify-between mb-3">

                                <label class="text-[11px]
                                              font-black
                                              uppercase
                                              tracking-widest
                                              text-indigo-500">

                                    Новый оттиск
                                </label>

                                <button type="button"
                                        id="clearBtn"
                                        class="bg-rose-500/10
                                               text-rose-500
                                               px-3 py-1
                                               rounded-full
                                               text-[9px]
                                               font-black
                                               uppercase
                                               tracking-tight
                                               hover:bg-rose-500
                                               hover:text-white
                                               transition">

                                    Очистить
                                </button>

                            </div>

                            <div class="relative pad-container rounded-[1.7rem] overflow-hidden">

                                <canvas id="signature-pad"
                                        class="w-full h-52 cursor-crosshair touch-none">
                                </canvas>

                                <div id="placeholder-hint"
                                     class="absolute inset-0 flex items-center justify-center pointer-events-none">

                                    <span class="text-[10px]
                                                 font-black
                                                 uppercase
                                                 tracking-[0.25em]
                                                 text-slate-400
                                                 opacity-30">

                                        Здесь ваша подпись
                                    </span>
                                </div>

                            </div>

                        </div>

                        <input type="hidden"
                               name="signature"
                               id="signatureInput">

                        <button type="submit"
                                class="w-full btn-update
                                       py-4
                                       rounded-2xl
                                       text-[12px]">

                            Подтвердить и обновить PDF
                        </button>

                    </form>

                </div>

                <!-- RIGHT -->

                <div class="space-y-6">

                    <div class="form-card p-7">

                        <label class="text-[11px]
                                      font-black
                                      uppercase
                                      tracking-widest
                                      text-slate-400
                                      mb-5
                                      block
                                      text-center">

                            Текущий вариант
                        </label>

                        <div class="relative old-sig-display flex items-center justify-center">

                            <span class="badge-old tracking-tight italic">
                                Архив
                            </span>

                            <img src="{{ $signature->signature }}"
                                 class="old-signature max-h-24 object-contain"
                                 alt="Old Signature">

                        </div>

                    </div>

                    <div class="bg-indigo-950
                                rounded-[2.2rem]
                                p-7
                                text-white
                                shadow-2xl
                                relative
                                overflow-hidden
                                border-[2px]
                                border-white/15">

                        <div class="absolute -right-10 -bottom-10 opacity-10">

                            <svg class="w-52 h-52"
                                 fill="currentColor"
                                 viewBox="0 0 20 20">

                                <path d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z"/>
                            </svg>
                        </div>

                        <div class="bg-indigo-900
                                    rounded-[1.8rem]
                                    p-6
                                    text-white
                                    shadow-xl
                                    relative
                                    overflow-hidden
                                    border
                                    border-white/10">

                            <div class="absolute left-0
                                        top-1/4
                                        bottom-1/4
                                        w-1
                                        bg-indigo-400
                                        rounded-r-full">
                            </div>

                            <div class="relative z-10">

                                <div class="flex items-center gap-3 mb-4">

                                    <div class="w-8 h-8
                                                rounded-xl
                                                bg-white/10
                                                flex
                                                items-center
                                                justify-center
                                                border
                                                border-white/10">

                                        <svg class="w-4 h-4 text-indigo-200"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24"
                                             stroke-width="2.5">

                                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>

                                    <h4 class="text-[10px]
                                               font-black
                                               uppercase
                                               tracking-[0.22em]
                                               text-indigo-200">

                                        Внимание
                                    </h4>

                                </div>

                                <p class="text-[12px]
                                          font-medium
                                          leading-relaxed
                                          opacity-90
                                          navbar-style-text">

                                    При обновлении подписи система автоматически
                                    перегенерирует PDF-файл. Старый файл будет удален.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const canvas = document.getElementById('signature-pad');
            const hint = document.getElementById('placeholder-hint');

            const isDark =
                document.documentElement.classList.contains('dark');

            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255,255,255,0)',
                penColor: isDark ? '#ffffff' : '#0f172a',
                minWidth: 2,
                maxWidth: 4
            });

            function resizeCanvas() {

                const ratio =
                    Math.max(window.devicePixelRatio || 1, 1);

                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;

                canvas.getContext("2d").scale(ratio, ratio);

                signaturePad.clear();

                hint.style.opacity = '1';
            }

            window.addEventListener('resize', resizeCanvas);

            resizeCanvas();

            canvas.addEventListener('mousedown', () => {
                hint.style.opacity = '0';
            });

            canvas.addEventListener('touchstart', () => {
                hint.style.opacity = '0';
            });

            document.getElementById('clearBtn')
                .addEventListener('click', () => {

                    signaturePad.clear();

                    hint.style.opacity = '1';
                });

            document.getElementById('signatureForm')
                .addEventListener('submit', function (e) {

                    if (signaturePad.isEmpty()) {

                        e.preventDefault();

                        alert('Пожалуйста, оставьте подпись');

                    } else {

                        document.getElementById('signatureInput').value =
                            signaturePad.toDataURL();
                    }
                });
        });
    </script>
@endsection
