{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8 min-h-screen">--}}
{{--        <style>--}}
{{--            /* Переменные для привязки к твоей системе */--}}
{{--            .create-sig-page {--}}
{{--                --primary-color: var(--primary, #6366f1);--}}
{{--            }--}}

{{--            /* Заголовок подстраивается под фон админки (белый на темном) */--}}
{{--            .theme-heading {--}}
{{--                color: var(--text-main, currentColor);--}}
{{--            }--}}

{{--            /* Карточка ВСЕГДА белая, текст внутри ВСЕГДА темный */--}}
{{--            .form-card {--}}
{{--                background: #ffffff !important;--}}
{{--                border-radius: 2.5rem;--}}
{{--                border: 1px solid rgba(0, 0, 0, 0.05);--}}
{{--                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);--}}
{{--            }--}}

{{--            .form-card label {--}}
{{--                color: #64748b !important; /* Серый текст заголовков полей */--}}
{{--            }--}}

{{--            .form-card select, .form-card input {--}}
{{--                color: #1e293b !important; /* Черный текст в полях */--}}
{{--                background-color: #f8fafc !important;--}}
{{--                border: 1px solid #e2e8f0 !important;--}}
{{--            }--}}

{{--            /* Кнопка Primary из системы */--}}
{{--            .btn-save {--}}
{{--                background-color: var(--primary-color) !important;--}}
{{--                color: #ffffff !important;--}}
{{--                transition: all 0.2s ease;--}}
{{--            }--}}
{{--            .btn-save:hover {--}}
{{--                opacity: 0.9;--}}
{{--                transform: translateY(-1px);--}}
{{--            }--}}

{{--            /* Зона для рисования */--}}
{{--            .pad-container {--}}
{{--                background-color: #ffffff !important;--}}
{{--                border: 2px dashed #e2e8f0;--}}
{{--                transition: border-color 0.2s;--}}
{{--            }--}}
{{--            .pad-container:hover {--}}
{{--                border-color: var(--primary-color);--}}
{{--            }--}}
{{--        </style>--}}

{{--        <div class="create-sig-page">--}}
{{--             Header--}}
{{--            <div class="mb-8">--}}
{{--                <a href="{{ route('signatures.index') }}" class="font-bold text-xs uppercase tracking-widest hover:underline flex items-center gap-2 mb-2" style="color: var(--primary-color);">--}}
{{--                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>--}}
{{--                    Назад к списку--}}
{{--                </a>--}}
{{--                <h1 class="text-3xl font-bold tracking-tight theme-heading">Подписать документ</h1>--}}
{{--            </div>--}}

{{--            <div class="max-w-2xl form-card p-8 sm:p-12">--}}
{{--                @if(session('error'))--}}
{{--                    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 font-bold text-sm rounded-r-xl">--}}
{{--                        {{ session('error') }}--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                <form method="POST" action="{{ route('signatures.store') }}" onsubmit="return saveSignature(event)" class="space-y-6">--}}
{{--                    @csrf--}}

{{--                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">--}}
{{--                         Документ--}}
{{--                        <div>--}}
{{--                            <label class="block text-[11px] font-bold uppercase tracking-wider mb-2 ml-1">Выберите документ</label>--}}
{{--                            <select name="document_id" class="w-full rounded-xl px-5 py-3 font-semibold outline-none cursor-pointer" required>--}}
{{--                                @foreach($documents as $doc)--}}
{{--                                    <option value="{{ $doc->id }}">{{ $doc->title }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                         Пользователь--}}
{{--                        <div>--}}
{{--                            <label class="block text-[11px] font-bold uppercase tracking-wider mb-2 ml-1">Сотрудник</label>--}}
{{--                            <select name="user_id" class="w-full rounded-xl px-5 py-3 font-semibold outline-none cursor-pointer" required>--}}
{{--                                @foreach($users as $user)--}}
{{--                                    <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                     Зона подписи--}}
{{--                    <div>--}}
{{--                        <label class="block text-[11px] font-bold uppercase tracking-wider mb-2 ml-1">Ваша подпись</label>--}}
{{--                        <div class="relative pad-container rounded-3xl overflow-hidden group">--}}
{{--                            <canvas id="signature-pad" class="w-full h-48 cursor-crosshair touch-none"></canvas>--}}

{{--                            <div id="placeholder-hint" class="absolute inset-0 flex items-center justify-center pointer-events-none text-gray-300 font-medium text-sm">--}}
{{--                                Рисуйте здесь мышкой или пальцем--}}
{{--                            </div>--}}

{{--                            <button type="button" onclick="clearPad()" class="absolute top-4 right-4 p-2 bg-white shadow-md hover:bg-gray-50 text-rose-500 rounded-lg transition-all opacity-0 group-hover:opacity-100 border border-gray-100">--}}
{{--                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <input type="hidden" name="signature" id="signature">--}}

{{--                    <div class="pt-4">--}}
{{--                        <button type="submit" class="w-full btn-save py-4 rounded-2xl shadow-lg flex items-center justify-center gap-2 tracking-wide font-bold">--}}
{{--                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>--}}
{{--                            ПОДТВЕРДИТЬ И ПОДПИСАТЬ--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        const canvas = document.getElementById('signature-pad');--}}
{{--        const ctx = canvas.getContext('2d');--}}
{{--        const hint = document.getElementById('placeholder-hint');--}}
{{--        let drawing = false;--}}

{{--        function resizeCanvas() {--}}
{{--            const rect = canvas.getBoundingClientRect();--}}
{{--            canvas.width = rect.width;--}}
{{--            canvas.height = rect.height;--}}
{{--        }--}}
{{--        window.addEventListener('resize', resizeCanvas);--}}
{{--        resizeCanvas();--}}

{{--        function startDrawing(e) {--}}
{{--            drawing = true;--}}
{{--            hint.style.opacity = '0';--}}
{{--            draw(e);--}}
{{--        }--}}

{{--        function stopDrawing() {--}}
{{--            drawing = false;--}}
{{--            ctx.beginPath();--}}
{{--        }--}}

{{--        function draw(e) {--}}
{{--            if (!drawing) return;--}}
{{--            e.preventDefault();--}}

{{--            const rect = canvas.getBoundingClientRect();--}}
{{--            const x = (e.clientX || (e.touches && e.touches[0].clientX)) - rect.left;--}}
{{--            const y = (e.clientY || (e.touches && e.touches[0].clientY)) - rect.top;--}}

{{--            ctx.lineWidth = 3;--}}
{{--            ctx.lineCap = 'round';--}}
{{--            // Используем темно-синий цвет для чернил, который хорошо виден на белом--}}
{{--            ctx.strokeStyle = '#1e3a8a';--}}

{{--            ctx.lineTo(x, y);--}}
{{--            ctx.stroke();--}}
{{--            ctx.beginPath();--}}
{{--            ctx.moveTo(x, y);--}}
{{--        }--}}

{{--        canvas.addEventListener('mousedown', startDrawing);--}}
{{--        canvas.addEventListener('mousemove', draw);--}}
{{--        window.addEventListener('mouseup', stopDrawing);--}}
{{--        canvas.addEventListener('touchstart', startDrawing);--}}
{{--        canvas.addEventListener('touchmove', draw);--}}
{{--        canvas.addEventListener('touchend', stopDrawing);--}}

{{--        function clearPad() {--}}
{{--            ctx.clearRect(0, 0, canvas.width, canvas.height);--}}
{{--            hint.style.opacity = '1';--}}
{{--        }--}}

{{--        function saveSignature(e) {--}}
{{--            const blank = document.createElement('canvas');--}}
{{--            blank.width = canvas.width;--}}
{{--            blank.height = canvas.height;--}}

{{--            if (canvas.toDataURL() === blank.toDataURL()) {--}}
{{--                alert("Пожалуйста, оставьте подпись!");--}}
{{--                e.preventDefault();--}}
{{--                return false;--}}
{{--            }--}}

{{--            document.getElementById('signature').value = canvas.toDataURL();--}}
{{--            return true;--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8">--}}
{{--        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">--}}

{{--            --}}{{-- Левая колонка: Панель рисования --}}
{{--            <div class="lg:col-span-5">--}}
{{--                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100">--}}
{{--                    <h2 class="text-xl font-black uppercase tracking-tighter mb-6 text-slate-800">Создание подписи</h2>--}}

{{--                    <form action="{{ route('signatures.store') }}" method="POST" id="signatureForm">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="document_id" value="{{ $document->id }}">--}}
{{--                        <input type="hidden" name="signature" id="signatureInput">--}}

{{--                        <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500 block mb-2">Нарисуйте вашу подпись ниже</label>--}}
{{--                        <div class="relative bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl overflow-hidden group">--}}
{{--                            <canvas id="signature-pad" class="w-full h-64 touch-none cursor-crosshair"></canvas>--}}

{{--                            <button type="button" id="clearBtn" class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm text-slate-500 p-2 rounded-xl hover:bg-red-50 hover:text-red-500 transition shadow-sm">--}}
{{--                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}

{{--                        <div class="mt-8 space-y-4">--}}
{{--                            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 flex items-center justify-center gap-3">--}}
{{--                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>--}}
{{--                                Подтвердить и вшить в PDF--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            --}}{{-- Правая колонка: Просмотр PDF (чтобы видеть, что подписываем) --}}
{{--            <div class="lg:col-span-7">--}}
{{--                <div class="bg-slate-900 p-2 rounded-[2.8rem] shadow-2xl h-[700px]">--}}
{{--                    <iframe src="{{ asset('storage/' . $document->file_path) }}#toolbar=0" class="w-full h-full rounded-[2.2rem]" frameborder="0"></iframe>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    --}}{{-- Подключаем библиотеку для плавного рисования --}}
{{--    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const canvas = document.getElementById('signature-pad');--}}
{{--            const signaturePad = new SignaturePad(canvas, {--}}
{{--                backgroundColor: 'rgba(255, 255, 255, 0)',--}}
{{--                penColor: '#1e293b'--}}
{{--            });--}}

{{--            // Авто-ресайз канваса--}}
{{--            function resizeCanvas() {--}}
{{--                const ratio =  Math.max(window.devicePixelRatio || 1, 1);--}}
{{--                canvas.width = canvas.offsetWidth * ratio;--}}
{{--                canvas.height = canvas.offsetHeight * ratio;--}}
{{--                canvas.getContext("2d").scale(ratio, ratio);--}}
{{--                signaturePad.clear();--}}
{{--            }--}}
{{--            window.onresize = resizeCanvas;--}}
{{--            resizeCanvas();--}}

{{--            document.getElementById('clearBtn').addEventListener('click', () => signaturePad.clear());--}}

{{--            document.getElementById('signatureForm').addEventListener('submit', function (e) {--}}
{{--                if (signaturePad.isEmpty()) {--}}
{{--                    e.preventDefault();--}}
{{--                    alert("Пожалуйста, оставьте подпись.");--}}
{{--                } else {--}}
{{--                    // Записываем данные в скрытое поле--}}
{{--                    document.getElementById('signatureInput').value = signaturePad.toDataURL();--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}



@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Левая колонка --}}
            <div class="lg:col-span-5">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100">
                    <h2 class="text-xl font-black uppercase tracking-tighter mb-6 text-slate-800">Подписание документа</h2>

                    <form action="{{ route('signatures.store') }}" method="POST" id="signatureForm">
                        @csrf
                        <input type="hidden" name="signature" id="signatureInput">

                        {{-- Выбор документа --}}
                        <div class="mb-6">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-2 ml-1">Выберите документ</label>
                            <select name="document_id" id="documentSelect" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 font-bold text-slate-700 outline-none focus:border-indigo-500 transition">
                                @foreach($documents as $doc)
                                    <option value="{{ $doc->id }}"
                                            data-pdf="{{ asset('storage/' . $doc->file_path) }}"
                                        {{ (isset($document) && $doc->id == $document->id) ? 'selected' : '' }}>
                                        #{{ $doc->id }} — {{ $doc->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Зона подписи --}}
                        <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500 block mb-2 ml-1">Нарисуйте вашу подпись ниже</label>
                        <div class="relative bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl overflow-hidden" style="height: 260px;">
                            <canvas id="signature-pad" class="absolute inset-0 w-full h-full touch-none" style="cursor: crosshair; z-index: 5;"></canvas>

                            <button type="button" id="clearBtn" class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-slate-500 p-2 rounded-xl hover:bg-red-50 hover:text-red-500 transition shadow-sm border border-slate-100" style="z-index: 10;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>

                        <div class="mt-8">
                            <button type="submit" id="submitBtn" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Подтвердить подпись
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Правая колонка: PDF --}}
            <div class="lg:col-span-7">
                <div class="bg-slate-900 p-2 rounded-[2.8rem] shadow-2xl h-[750px] sticky top-8">
                    <iframe id="pdfViewer" src="" class="w-full h-full rounded-[2.2rem] bg-white" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('signature-pad');
            const signatureInput = document.getElementById('signatureInput');
            const form = document.getElementById('signatureForm');
            const select = document.getElementById('documentSelect');
            const viewer = document.getElementById('pdfViewer');

            // 1. Инициализация Signature Pad
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: '#1e293b',
                minWidth: 2,
                maxWidth: 4
            });

            // 2. Правильный ресайз
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear(); // При ресайзе очищаем, чтобы не было артефактов
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            // 3. Функция обновления PDF (вызываем сразу и при смене)
            function updatePdf() {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption) {
                    const pdfUrl = selectedOption.getAttribute('data-pdf');
                    viewer.src = pdfUrl + '#toolbar=0';
                }
            }

            updatePdf(); // Запуск при загрузке
            select.addEventListener('change', updatePdf);

            // 4. Очистка
            document.getElementById('clearBtn').addEventListener('click', () => signaturePad.clear());

            // 5. Отправка формы
            form.addEventListener('submit', function (e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert("Пожалуйста, нарисуйте подпись!");
                } else {
                    // КРИТИЧЕСКИЙ МОМЕНТ: Берем данные ПРЯМО ПЕРЕД отправкой
                    const dataURL = signaturePad.toDataURL('image/png');
                    signatureInput.value = dataURL;

                    // Если хочешь проверить, добавь:
                    // console.log(signatureInput.value);
                }
            });
        });
    </script>
@endsection
