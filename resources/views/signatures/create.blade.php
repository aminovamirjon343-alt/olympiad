@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Подключаем библиотеки для рендеринга Word (.docx) на клиенте -->
    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
    <script src="https://unpkg.com/docx-preview/dist/docx-preview.min.js"></script>

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
        .viewer-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            z-index: 40;
        }

        .document-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        /* Слои для предотвращения лагов при dragging */
        .drag-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 30;
        }

        /* Штамп DocSign */
        #draggable-qr-stamp {
            position: absolute;
            width: 95px;
            height: 95px;
            background: #ffffff !important;
            border: 1.5px solid #000000;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
            cursor: move;
            pointer-events: auto;
            display: none;
            touch-action: none;
            padding: 4px;
            left: 50px;
            top: 50px;
            box-sizing: border-box;
            text-align: center;
            z-index: 35;
        }
        #dynamic-qr-img {
            width: 100%;
            height: 65px;
            object-fit: contain;
        }
        .stamp-text-footer {
            font-size: 5.5px !important;
            font-weight: 800 !important;
            color: #000000 !important;
            line-height: 1.1;
            text-transform: uppercase;
            margin-top: 2px;
            font-family: monospace;
        }

        /* Заглушка для Excel/локальных ограничений */
        .local-warning-box {
            display: none;
            position: absolute;
            inset: 0;
            background: #1e293b;
            color: #f1f5f9;
            z-index: 25;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }

        .dragging-active iframe, .dragging-active #word-preview {
            pointer-events: none !important;
        }

        /* Оформление области превью Word */
        #word-preview {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            background-color: #ffffff;
        }
        .docx-wrapper { background: transparent !important; padding: 14px !important; }
        .docx { box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important; padding: 20px !important; }
    </style>

    <div class="container mx-auto px-2 py-4 sig-container">
        <form action="{{ route('signatures.store') }}" method="POST" id="signatureForm">
            @csrf
            <input type="hidden" name="qr_payload" id="qrPayloadInput">
            <input type="hidden" name="qr_x" id="qr_x" value="0">
            <input type="hidden" name="qr_y" id="qr_y" value="0">
            <input type="hidden" name="target_page" id="target_page" value="1">

            <div class="flex flex-col lg:flex-row gap-6 items-start">

                {{-- ЛЕВАЯ ПАНЕЛЬ --}}
                <div class="w-full lg:w-4/12 sticky top-4">
                    <div class="signature-card-container p-5">
                        <h2 class="title-compact font-extrabold uppercase mb-5 text-black dark:text-white" data-i18n="signingTitle">Защита и QR</h2>

                        <div class="mb-2">
                            <label class="label-micro block mb-1.5 ml-1" data-i18n="selectDocLabel">Выбор документа</label>
                            <select name="document_id" id="documentSelect" class="w-full outline-none focus:border-indigo-500 transition">
                                <option value="" disabled {{ (!isset($document) && !request('document_id')) ? 'selected' : '' }} data-i18n="docPlaceholder">-- Список документов --</option>
                                @foreach($documents as $doc)
                                    @php
                                        $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));

                                        if (in_array($ext, ['doc', 'docx'])) {
                                            $formatType = 'word';
                                        } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                            $formatType = 'excel';
                                        } elseif ($ext === 'rtf') {
                                            $formatType = 'rtf';
                                        } else {
                                            $formatType = 'pdf';
                                        }

                                        $senderName = $doc->sender->name ?? 'Система';
                                        $signerName = auth()->user()->name ?? 'Пользователь';
                                        $dateSent = $doc->created_at ? $doc->created_at->format('d.m.Y H:i') : date('d.m.Y H:i');

                                        $qrText = "DocSign | DOC: {$doc->title} | SENDER: {$senderName} | SIGNED BY: {$signerName} | SENT AT: {$dateSent}";
                                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrText);
                                        $isSelected = (isset($document) && $document->id == $doc->id) || (request('document_id') == $doc->id);
                                    @endphp
                                    <option value="{{ $doc->id }}"
                                            {{ $isSelected ? 'selected' : '' }}
                                            data-file="{{ asset('storage/' . $doc->file_path) }}"
                                            data-type="{{ $formatType }}"
                                            data-ext="{{ $ext }}"
                                            data-qr-url="{{ $qrUrl }}"
                                            data-qr-text="{{ $qrText }}">
                                        [{{ strtoupper($ext) }}] #{{ $doc->id }} — {{ $doc->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ПРАВАЯ ПАНЕЛЬ --}}
                <div class="w-full lg:w-8/12">
                    <div class="flex items-center justify-between mb-3 px-4">
                        <div class="flex items-center gap-3">
                            <span class="label-micro" data-i18n="previewLabel">Предпросмотр</span>
                            <span id="formatBadge" class="hidden px-2 py-0.5 rounded text-[9px] font-black uppercase text-white"></span>
                            <span class="text-[10px] font-medium text-slate-400 animate-pulse hidden" id="dragNotice">← Перетащите штамп в нужное место на документе</span>
                        </div>
                        <a id="fullScreenBtn" href="#" target="_blank" class="hidden flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-[10px] font-bold text-black hover:bg-slate-50 hover:text-indigo-600 transition shadow-sm">
                            <i class="bi bi-arrows-fullscreen"></i>
                            <span data-i18n="btnFullScreen">На весь экран</span>
                        </a>
                    </div>

                    <div id="viewerContainer" class="bg-slate-900 p-1 rounded-[1.8rem] shadow-xl relative mb-4" style="height: calc(100vh - 220px); min-height: 500px;">
                        <div id="viewerLoader" class="viewer-loading">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                        </div>

                        {{-- Окно предупреждения о localhost (для Excel) --}}
                        <div id="localWarning" class="local-warning-box rounded-[1.5rem]">
                            <i class="bi bi-exclamation-triangle text-amber-500 text-3xl mb-3"></i>
                            <h4 class="text-base font-bold mb-1">Просмотр таблиц Excel на Localhost ограничен</h4>
                            <p class="text-xs text-slate-400 max-w-md">Внешние онлайн-сервисы просмотра не могут загрузить файл с локального ПК. На реальном сервере таблица отобразится корректно.</p>
                            <a id="localDownloadFallback" href="#" download class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2">
                                <i class="bi bi-download"></i> Скачать файл для проверки
                            </a>
                        </div>

                        <div class="document-wrapper h-full" id="documentWrapper">
                            <div class="drag-overlay" id="dragOverlay">
                                <div id="draggable-qr-stamp">
                                    <img id="dynamic-qr-img" src="" class="w-full object-contain pointer-events-none select-none" alt="stamp">
                                    <div class="stamp-text-footer">
                                        VERIFIED DOCSIGN<br>
                                        <span id="stamp-date-node">18.05.2026</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Область для вывода структуры документов --}}
                            <div id="previewViewport" class="w-full h-full rounded-[1.5rem] overflow-hidden bg-white">
                                <!-- Контент внедряется через JavaScript динамически -->
                            </div>
                        </div>
                    </div>

                    <div class="px-2">
                        <button type="submit" id="btnSubmitForm" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                            <i class="bi bi-shield-check"></i>
                            <span data-i18n="btnSign">Применить штамп</span>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    signingTitle: "Защита и QR",
                    selectDocLabel: "Выбор документа",
                    docPlaceholder: "-- Список документов --",
                    btnSign: "Применить штамп",
                    previewLabel: "Предпросмотр",
                    btnFullScreen: "На весь экран",
                    alertNoDoc: "Выберите документ!"
                },
                tj: {
                    signingTitle: "Муҳофизат ва QR",
                    selectDocLabel: "Интихоби ҳуҷҷат",
                    docPlaceholder: "-- Рӯйхати ҳуҷҷатҳо --",
                    btnSign: "Татбиқ кардани муҳр",
                    previewLabel: "Пешнамоиш",
                    btnFullScreen: "Дар тамоми экран",
                    alertNoDoc: "Ҳуҷҷатро интихоб кунед!"
                },
                en: {
                    signingTitle: "Security & QR",
                    selectDocLabel: "Select Document",
                    docPlaceholder: "-- Document List --",
                    btnSign: "Apply Stamp",
                    previewLabel: "Preview",
                    btnFullScreen: "Full Screen",
                    alertNoDoc: "Please select a document!"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            function applyTranslations() {
                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if (t[key]) el.textContent = t[key];
                });
            }
            applyTranslations();

            const today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const yyyy = today.getFullYear();
            document.getElementById('stamp-date-node').textContent = `${dd}.${mm}.${yyyy}`;

            const form = document.getElementById('signatureForm');
            const select = document.getElementById('documentSelect');
            const previewViewport = document.getElementById('previewViewport');
            const fullScreenBtn = document.getElementById('fullScreenBtn');
            const formatBadge = document.getElementById('formatBadge');
            const loader = document.getElementById('viewerLoader');
            const qrPayloadInput = document.getElementById('qrPayloadInput');
            const localWarning = document.getElementById('localWarning');
            const localDownloadFallback = document.getElementById('localDownloadFallback');

            const stamp = document.getElementById('draggable-qr-stamp');
            const stampImg = document.getElementById('dynamic-qr-img');
            const dragNotice = document.getElementById('dragNotice');
            const wrapper = document.getElementById('documentWrapper');

            let currentX = 0;
            let currentY = 0;

            const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

            function updateSelection() {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption && selectedOption.value && selectedOption.value !== "") {
                    const fileUrl = selectedOption.getAttribute('data-file');
                    const type = selectedOption.getAttribute('data-type');
                    const ext = selectedOption.getAttribute('data-ext');
                    const qrUrl = selectedOption.getAttribute('data-qr-url');
                    const qrText = selectedOption.getAttribute('data-qr-text');

                    qrPayloadInput.value = qrText;
                    localWarning.style.display = 'none';
                    wrapper.style.display = 'block';
                    loader.style.display = 'block';
                    previewViewport.style.opacity = '0.3';
                    previewViewport.innerHTML = ''; // Очищаем вьюпорт

                    // Сброс позиции штампа
                    currentX = 0;
                    currentY = 0;
                    stamp.style.transform = `translate(0px, 0px)`;

                    // Выставляем индикатор формата
                    formatBadge.textContent = ext.toUpperCase();
                    let badgeColor = 'bg-red-600';
                    if (type === 'word') badgeColor = 'bg-blue-600';
                    if (type === 'excel') badgeColor = 'bg-emerald-600';
                    if (type === 'rtf') badgeColor = 'bg-purple-600';
                    formatBadge.className = `px-2 py-0.5 rounded text-[9px] font-black uppercase text-white ${badgeColor} inline-block`;
                    formatBadge.classList.remove('hidden');

                    fullScreenBtn.href = fileUrl;
                    fullScreenBtn.classList.remove('hidden');

                    // 1. Локальный рендеринг DOCX файлов (работает везде, включая Localhost)
                    if (ext === 'docx') {
                        fetch(fileUrl)
                            .then(response => {
                                if(!response.ok) throw new Error('Ошибка скачивания файла');
                                return response.blob();
                            })
                            .then(blob => {
                                const wordDiv = document.createElement('div');
                                wordDiv.id = 'word-preview';
                                previewViewport.appendChild(wordDiv);

                                docx.renderAsync(blob, wordDiv)
                                    .then(() => {
                                        loader.style.display = 'none';
                                        previewViewport.style.opacity = '1';
                                        showStamp(qrUrl);
                                    });
                            })
                            .catch(err => {
                                console.error(err);
                                loader.style.display = 'none';
                                previewViewport.style.opacity = '1';
                                previewViewport.innerHTML = `<div class="p-6 text-center text-sm font-semibold text-rose-500">Не удалось отобразить файл DOCX локально.</div>`;
                                showStamp(qrUrl);
                            });
                        return;
                    }

                    // 2. Ограничения для Excel на Localhost
                    if (type === 'excel' && isLocal) {
                        loader.style.display = 'none';
                        wrapper.style.display = 'none';
                        localWarning.style.display = 'flex';
                        localDownloadFallback.href = fileUrl;
                        showStamp(qrUrl);
                        return;
                    }

                    // 3. Стандартный рендеринг остальных файлов в iframe
                    let iframeSrc = '';
                    if (type === 'word' || type === 'excel') {
                        iframeSrc = `https://view.officeapps.live.com/op/view.aspx?src=${encodeURIComponent(fileUrl)}`;
                    } else if (type === 'rtf') {
                        iframeSrc = fileUrl;
                    } else {
                        iframeSrc = fileUrl + '#toolbar=0&view=FitH';
                    }

                    const iframe = document.createElement('iframe');
                    iframe.src = iframeSrc;
                    iframe.className = "w-full h-full border-none";
                    iframe.frameBorder = "0";

                    iframe.onload = () => {
                        loader.style.display = 'none';
                        previewViewport.style.opacity = '1';
                        showStamp(qrUrl);
                    };

                    previewViewport.appendChild(iframe);
                }
            }

            function showStamp(qrUrl) {
                stamp.style.display = 'block';
                stampImg.src = qrUrl;
                dragNotice.classList.remove('hidden');
                calculateCoordinates();
            }

            function calculateCoordinates() {
                if (stamp.style.display === 'block') {
                    const targetContainer = localWarning.style.display === 'flex' ? localWarning : wrapper;
                    const parentW = targetContainer.clientWidth || wrapper.clientWidth;
                    const parentH = targetContainer.clientHeight || wrapper.clientHeight;

                    const leftPx = stamp.offsetLeft + currentX;
                    const topPx = stamp.offsetTop + currentY;

                    let pctX = (leftPx / parentW) * 100;
                    let pctY = (topPx / parentH) * 100;

                    pctX = Math.max(0, Math.min(100, pctX));
                    pctY = Math.max(0, Math.min(100, pctY));

                    document.getElementById('qr_x').value = pctX.toFixed(4);
                    document.getElementById('qr_y').value = pctY.toFixed(4);
                }
            }

            interact('#draggable-qr-stamp').draggable({
                modifiers: [
                    interact.modifiers.restrictRect({
                        restriction: '#viewerContainer',
                        endOnly: false
                    })
                ],
                listeners: {
                    start(event) {
                        document.getElementById('viewerContainer').classList.add('dragging-active');
                    },
                    move(event) {
                        currentX += event.dx;
                        currentY += event.dy;

                        event.target.style.transform = `translate(${currentX}px, ${currentY}px)`;
                        calculateCoordinates();
                    },
                    end(event) {
                        document.getElementById('viewerContainer').classList.remove('dragging-active');
                    }
                }
            });

            if (select.value && select.value !== "") {
                updateSelection();
            }

            select.addEventListener('change', updateSelection);

            form.addEventListener('submit', function (e) {
                if (!select.value || select.value === "") {
                    e.preventDefault();
                    alert(t.alertNoDoc || "Выберите документ!");
                    return;
                }
                calculateCoordinates();
            });
        });
    </script>
@endsection
