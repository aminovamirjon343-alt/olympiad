@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 min-h-screen">
        <style>
            /* Привязка к системным цветам */
            .edit-sig-page {
                --primary-color: var(--primary, #6366f1);
            }

            /* Заголовок страницы адаптируется к темной/светлой теме админки */
            .theme-heading {
                color: var(--text-main, currentColor);
            }

            /* Карточка формы: всегда белая с темным текстом внутри */
            .form-card {
                background: #ffffff !important;
                border-radius: 2.5rem;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            /* Принудительно темные тексты внутри белой карточки */
            .form-card h3 { color: #1e293b !important; }
            .form-card p, .form-card label { color: #64748b !important; }

            /* Область холста */
            .pad-container {
                background-color: #f8fafc !important;
                border: 2px dashed #e2e8f0;
            }
            .pad-container:hover {
                border-color: var(--primary-color);
            }

            /* Главная кнопка — теперь Primary из системы */
            .btn-update {
                background-color: var(--primary-color) !important;
                color: #ffffff !important;
                transition: all 0.2s ease;
            }
            .btn-update:hover {
                opacity: 0.9;
                transform: translateY(-1px);
            }
        </style>

        <div class="edit-sig-page">
            {{-- Навигация назад --}}
            <div class="mb-8">
                <a href="{{ route('signatures.index') }}" class="font-bold text-[11px] uppercase tracking-[0.2em] transition flex items-center gap-2 mb-3" style="color: var(--primary-color);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Вернуться в реестр
                </a>
                <h1 class="text-3xl font-bold tracking-tight theme-heading">Обновить подпись</h1>
            </div>

            <div class="max-w-2xl form-card">
                {{-- Инфо-панель сверху --}}
                <div class="px-10 py-6 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center" style="color: var(--primary-color);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest leading-none">Редактируемый документ</p>
                            <h3 class="text-sm font-bold mt-1">{{ $signature->document->title ?? '—' }}</h3>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-3 py-1 rounded-lg uppercase" style="background: rgba(99, 102, 241, 0.1); color: var(--primary-color);">ID: {{ $signature->id }}</span>
                </div>

                <form method="POST" action="{{ route('signatures.update', $signature->id) }}" onsubmit="return saveSignature(event)" class="p-10 space-y-8">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="document_id" value="{{ $signature->document_id }}">

                    {{-- Зона рисования --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-[11px] font-bold uppercase tracking-widest ml-1">Новая визуальная подпись</label>
                            <button type="button" onclick="clearPad()" class="text-[10px] font-bold text-rose-500 hover:text-rose-700 uppercase tracking-widest transition-colors">
                                Очистить холст
                            </button>
                        </div>

                        <div class="relative pad-container rounded-[2rem] overflow-hidden group transition-all">
                            <canvas id="signature-pad" class="w-full h-56 cursor-crosshair touch-none"></canvas>

                            <div id="placeholder-hint" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-gray-300 transition-opacity">
                                <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                <span class="font-bold text-xs uppercase tracking-widest">Распишитесь заново</span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="signature" id="signature">

                    {{-- Кнопка отправки --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full btn-update py-4 rounded-2xl shadow-xl flex items-center justify-center gap-3 tracking-[0.1em] text-xs font-bold">
                            ОБНОВИТЬ ЦИФРОВУЮ ПОДПИСЬ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        const hint = document.getElementById('placeholder-hint');
        let drawing = false;

        function resizeCanvas() {
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        function startDrawing(e) {
            drawing = true;
            hint.style.opacity = '0';
            draw(e);
        }

        function stopDrawing() {
            drawing = false;
            ctx.beginPath();
        }

        function draw(e) {
            if (!drawing) return;
            e.preventDefault();

            const rect = canvas.getBoundingClientRect();
            const x = (e.clientX || (e.touches && e.touches[0].clientX)) - rect.left;
            const y = (e.clientY || (e.touches && e.touches[0].clientY)) - rect.top;

            ctx.lineWidth = 3;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#0f172a'; // Темные чернила для контраста на белом фоне

            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        canvas.addEventListener('touchend', stopDrawing);

        function clearPad() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            hint.style.opacity = '1';
        }

        function saveSignature(e) {
            const blank = document.createElement('canvas');
            blank.width = canvas.width;
            blank.height = canvas.height;

            if (canvas.toDataURL() === blank.toDataURL()) {
                alert("Пожалуйста, поставьте новую подпись!");
                e.preventDefault();
                return false;
            }

            document.getElementById('signature').value = canvas.toDataURL();
            return true;
        }
    </script>
@endsection
