@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 min-h-screen">
        <style>
            .edit-sig-page { --primary-color: var(--primary, #6366f1); }
            .theme-heading { color: var(--text-main, currentColor); }

            .form-card {
                background: #ffffff !important;
                border-radius: 3rem;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .pad-container {
                background-color: #f8fafc !important;
                border: 2px dashed #e2e8f0;
                transition: all 0.3s ease;
            }
            .pad-container:hover { border-color: var(--primary-color); background-color: #f5f7ff !important; }

            .btn-update {
                background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
                color: #ffffff !important;
                box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
            }
        </style>

        <div class="edit-sig-page">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <a href="{{ route('signatures.show', $signature->id) }}" class="font-bold text-[11px] uppercase tracking-[0.2em] transition flex items-center gap-2 mb-3" style="color: var(--primary-color);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Вернуться к просмотру
                    </a>
                    <h1 class="text-3xl font-black tracking-tighter uppercase theme-heading">Изменение подписи</h1>
                </div>
            </div>

            <div class="max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Форма редактирования --}}
                <div class="form-card">
                    <div class="px-10 py-6 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Обновление данных</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('signatures.update', $signature->id) }}" id="signatureForm" class="p-10 space-y-8">
                        @csrf
                        @method('PUT')

                        {{-- Если Амир разрешил менять заголовок (опционально) --}}
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500 ml-1 block mb-2">Название документа</label>
                            <input type="text" name="title" value="{{ $signature->document->title }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 font-bold text-slate-700 outline-none focus:border-indigo-500 transition">
                        </div>

                        {{-- Холст для новой подписи --}}
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500 ml-1">Нарисуйте новую подпись</label>
                                <button type="button" id="clearBtn" class="text-[9px] font-black text-rose-500 uppercase tracking-widest hover:bg-rose-50 px-3 py-1 rounded-lg transition">
                                    Очистить
                                </button>
                            </div>

                            <div class="relative pad-container rounded-[2rem] overflow-hidden group">
                                <canvas id="signature-pad" class="w-full h-64 cursor-crosshair touch-none"></canvas>
                                <div id="placeholder-hint" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                    <svg class="w-10 h-10 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    <span class="font-black text-[10px] uppercase tracking-widest">Место для новой подписи</span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="signature" id="signatureInput">

                        <button type="submit" class="w-full btn-update py-5 rounded-[1.5rem] text-white font-black uppercase tracking-widest text-xs flex items-center justify-center gap-3 transition hover:scale-[1.01] active:scale-[0.99]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                            Переподписать документ
                        </button>
                    </form>
                </div>

                {{-- Правая колонка: Текущая подпись --}}
                <div class="space-y-6">
                    <div class="form-card p-10 flex flex-col items-center justify-center text-center">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Текущий оттиск в документе</label>
                        <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 mb-4 shadow-inner">
                            <img src="{{ $signature->signature }}" class="max-h-32 object-contain filter contrast-125 opacity-50" alt="Old Signature">
                        </div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase leading-relaxed">Эта подпись будет заменена на новую <br> во всех версиях PDF файла</p>
                    </div>

                    {{-- Инфо о документе --}}
                    <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden">
                        <svg class="absolute -right-10 -bottom-10 w-40 h-40 text-white/5" fill="currentColor" viewBox="0 0 20 20"><path d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z"/></svg>
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-4 text-indigo-300">Внимание</h4>
                        <p class="text-sm font-medium leading-relaxed opacity-90">При обновлении подписи система автоматически перегенерирует PDF-файл. Старый файл будет удален в целях безопасности.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Подключаем библиотеку для качественной подписи --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('signature-pad');
            const hint = document.getElementById('placeholder-hint');

            // Настройка Signature Pad
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: '#0f172a'
            });

            // Функция корректного изменения размера (Retina support)
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
                hint.style.opacity = '1';
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            // Скрываем подсказку при начале рисования
            canvas.addEventListener('mousedown', () => hint.style.opacity = '0');
            canvas.addEventListener('touchstart', () => hint.style.opacity = '0');

            // Очистка
            document.getElementById('clearBtn').addEventListener('click', () => {
                signaturePad.clear();
                hint.style.opacity = '1';
            });

            // Валидация перед отправкой
            document.getElementById('signatureForm').addEventListener('submit', function (e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert("Пожалуйста, нарисуйте новую подпись!");
                } else {
                    document.getElementById('signatureInput').value = signaturePad.toDataURL();
                }
            });
        });
    </script>
@endsection
