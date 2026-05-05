@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 min-h-screen">
        <style>
            /* Переменные для привязки к твоей системе */
            .create-sig-page {
                --primary-color: var(--primary, #6366f1);
            }

            /* Заголовок подстраивается под фон админки (белый на темном) */
            .theme-heading {
                color: var(--text-main, currentColor);
            }

            /* Карточка ВСЕГДА белая, текст внутри ВСЕГДА темный */
            .form-card {
                background: #ffffff !important;
                border-radius: 2.5rem;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            }

            .form-card label {
                color: #64748b !important; /* Серый текст заголовков полей */
            }

            .form-card select, .form-card input {
                color: #1e293b !important; /* Черный текст в полях */
                background-color: #f8fafc !important;
                border: 1px solid #e2e8f0 !important;
            }

            /* Кнопка Primary из системы */
            .btn-save {
                background-color: var(--primary-color) !important;
                color: #ffffff !important;
                transition: all 0.2s ease;
            }
            .btn-save:hover {
                opacity: 0.9;
                transform: translateY(-1px);
            }

            /* Зона для рисования */
            .pad-container {
                background-color: #ffffff !important;
                border: 2px dashed #e2e8f0;
                transition: border-color 0.2s;
            }
            .pad-container:hover {
                border-color: var(--primary-color);
            }
        </style>

        <div class="create-sig-page">
             Header
            <div class="mb-8">
                <a href="{{ route('signatures.index') }}" class="font-bold text-xs uppercase tracking-widest hover:underline flex items-center gap-2 mb-2" style="color: var(--primary-color);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Назад к списку
                </a>
                <h1 class="text-3xl font-bold tracking-tight theme-heading">Подписать документ</h1>
            </div>

            <div class="max-w-2xl form-card p-8 sm:p-12">
                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 font-bold text-sm rounded-r-xl">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('signatures.store') }}" onsubmit="return saveSignature(event)" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         Документ
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider mb-2 ml-1">Выберите документ</label>
                            <select name="document_id" class="w-full rounded-xl px-5 py-3 font-semibold outline-none cursor-pointer" required>
                                @foreach($documents as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->title }}</option>
                                @endforeach
                            </select>
                        </div>

                         Пользователь
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider mb-2 ml-1">Сотрудник</label>
                            <select name="user_id" class="w-full rounded-xl px-5 py-3 font-semibold outline-none cursor-pointer" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     Зона подписи
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider mb-2 ml-1">Ваша подпись</label>
                        <div class="relative pad-container rounded-3xl overflow-hidden group">
                            <canvas id="signature-pad" class="w-full h-48 cursor-crosshair touch-none"></canvas>

                            <div id="placeholder-hint" class="absolute inset-0 flex items-center justify-center pointer-events-none text-gray-300 font-medium text-sm">
                                Рисуйте здесь мышкой или пальцем
                            </div>

                            <button type="button" onclick="clearPad()" class="absolute top-4 right-4 p-2 bg-white shadow-md hover:bg-gray-50 text-rose-500 rounded-lg transition-all opacity-0 group-hover:opacity-100 border border-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="signature" id="signature">

                    <div class="pt-4">
                        <button type="submit" class="w-full btn-save py-4 rounded-2xl shadow-lg flex items-center justify-center gap-2 tracking-wide font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                            ПОДТВЕРДИТЬ И ПОДПИСАТЬ
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
            // Используем темно-синий цвет для чернил, который хорошо виден на белом
            ctx.strokeStyle = '#1e3a8a';

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
                alert("Пожалуйста, оставьте подпись!");
                e.preventDefault();
                return false;
            }

            document.getElementById('signature').value = canvas.toDataURL();
            return true;
        }
    </script>
@endsection
