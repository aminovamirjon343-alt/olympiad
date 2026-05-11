


@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .sig-container {
            font-family: 'Inter', sans-serif !important;
        }

        /* Принудительный черный текст и солидный стиль селекта */
        #documentSelect {
            color: #000000 !important;
            background-color: #ffffff !important;
            font-size: 13px !important; /* Уменьшили текст */
            font-weight: 600 !important;
            border: 1.5px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: 0.75rem !important;
            padding: 0.6rem 1rem !important;
        }

        #documentSelect option {
            color: #000000 !important;
            background-color: #ffffff !important;
        }

        /* Карточка с четкой, но тонкой границей */
        .signature-card-container {
            background: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            border-radius: 1.5rem !important;
            box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .dark .signature-card-container {
            background: #1e293b !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* Уменьшенный заголовок и метки */
        .title-compact {
            font-size: 16px !important;
            letter-spacing: -0.02em;
        }

        .label-micro {
            font-size: 9px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: #64748b;
        }
    </style>

    <div class="container mx-auto px-2 py-4 sig-container">
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- ЛЕВАЯ КОЛОНКА --}}
            <div class="w-full lg:w-4/12 sticky top-4">
                <div class="signature-card-container p-5">
                    <h2 class="title-compact font-extrabold uppercase mb-5 text-black dark:text-white">Подписание</h2>

                    <form action="" method="POST" id="signatureForm">
                        @csrf
                        <input type="hidden" name="signature" id="signatureInput">

                        <div class="mb-5">
                            <label class="label-micro block mb-1.5 ml-1">Выбор документа</label>
                            <select name="document_id" id="documentSelect" class="w-full outline-none focus:border-indigo-500 transition">
                                <option value="" disabled {{ !isset($document) ? 'selected' : '' }}>-- Список документов --</option>
                                @foreach($documents as $doc)
                                    <option value="{{ $doc->id }}"
                                            data-pdf="{{ asset('storage/' . $doc->file_path) }}"
                                        {{ (isset($document) && $document->id == $doc->id) ? 'selected' : '' }}>
                                        #{{ $doc->id }} — {{ $doc->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="label-micro block mb-1.5 ml-1 text-indigo-500">Ваша подпись</label>
                        <div class="relative bg-slate-50 border border-slate-200 rounded-xl overflow-hidden" style="height: 160px;">
                            <canvas id="signature-pad" class="w-full h-full touch-none" style="cursor: crosshair;"></canvas>
                            <button type="button" id="clearBtn" class="absolute top-2 right-2 bg-white text-slate-400 p-1.5 rounded-lg hover:text-red-500 transition shadow-sm border border-slate-100 z-10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Вшить подпись
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ПРАВАЯ КОЛОНКА --}}
            <div class="w-full lg:w-8/12">
                <div class="flex items-center justify-between mb-3 px-4">
                    <span class="label-micro">Предпросмотр</span>
                    <a id="fullScreenBtn" href="#" target="_blank" class="hidden flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-[10px] font-bold text-black hover:bg-slate-50 hover:text-indigo-600 transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        На весь экран
                    </a>
                </div>
                <div class="bg-slate-900 p-1 rounded-[1.8rem] shadow-xl sticky top-4" style="height: calc(100vh - 140px);">
                    <iframe id="pdfViewer" src="" class="w-full h-full rounded-[1.5rem] bg-white border-none" frameborder="0"></iframe>
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
            const fullScreenBtn = document.getElementById('fullScreenBtn');

            // Инициализация подписи
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 1.2,
                maxWidth: 3.0
            });

            // Функция обновления превью и экшена формы
            function updateSelection() {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption && selectedOption.value && selectedOption.value !== "") {
                    const pdfUrl = selectedOption.getAttribute('data-pdf');

                    // Обновляем iframe и ссылку
                    viewer.src = pdfUrl + '#toolbar=0&view=FitH&pagemode=none';
                    fullScreenBtn.href = pdfUrl;
                    fullScreenBtn.classList.remove('hidden');

                    // Устанавливаем URL для отправки формы
                    form.action = `/documents/${selectedOption.value}/sign`;
                }
            }

            // Подгонка размера холста
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }

            // Слушатели событий
            window.addEventListener("resize", resizeCanvas);
            select.addEventListener('change', updateSelection);
            document.getElementById('clearBtn').addEventListener('click', () => signaturePad.clear());

            // Инициализация при загрузке
            setTimeout(resizeCanvas, 300);

            // Если документ уже выбран (через Blade), загружаем превью сразу
            if (select.value) {
                updateSelection();
            }

            // Обработка отправки
            form.addEventListener('submit', function (e) {
                if (!select.value) {
                    e.preventDefault();
                    alert("Выберите документ!");
                    return;
                }
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert("Нарисуйте подпись!");
                    return;
                }
                // Записываем Base64 картинки в скрытый инпут
                signatureInput.value = signaturePad.toDataURL('image/png');
            });
        });
    </script>
@endsection
