@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
            background-color: #0f172a;
        }

        /* Комфортный адаптивный просмотрщик на всю область контейнера */
        #previewViewport {
            position: relative;
            width: 100%;
            height: 100%;
            background: #0f172a;
            margin: auto;
            overflow-y: auto;
        }

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

        #word-preview {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            background-color: #ffffff;
        }
        .docx-wrapper { background: transparent !important; padding: 0 !important; }
        .docx { box-shadow: none !important; padding: 20px !important; width: 100% !important; min-height: 100% !important; }
    </style>

    <div class="container mx-auto px-2 py-4 sig-container">
        <form action="{{ route('signatures.store') }}" method="POST" id="signatureForm">
            @csrf
            <input type="hidden" name="qr_payload" id="qrPayloadInput">

            {{-- Передаем маркер -1, чтобы бэкенд знал, что штамп нужен строго на последней странице в углу --}}
            <input type="hidden" name="qr_x" id="qr_x" value="80">
            <input type="hidden" name="qr_y" id="qr_y" value="85">
            <input type="hidden" name="target_page" id="target_page" value="-1">

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
                            <span class="text-[10px] font-medium text-slate-400" id="dragNotice" data-i18n="autoNotice">Штамп будет наложен автоматически при подписании</span>
                        </div>
                        <a id="fullScreenBtn" href="#" target="_blank" class="hidden flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-[10px] font-bold text-black hover:bg-slate-50 hover:text-indigo-600 transition shadow-sm">
                            <i class="bi bi-arrows-fullscreen"></i>
                            <span data-i18n="btnFullScreen">На весь экран</span>
                        </a>
                    </div>

                    <div id="viewerContainer" class="bg-slate-950 p-2 rounded-[1.8rem] shadow-xl relative mb-4" style="height: calc(100vh - 220px); min-height: 520px;">
                        <div id="viewerLoader" class="viewer-loading">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                        </div>

                        <div id="localWarning" class="local-warning-box rounded-[1.5rem]">
                            <i class="bi bi-exclamation-triangle text-amber-500 text-3xl mb-3"></i>
                            <h4 class="text-base font-bold mb-1">Просмотр таблиц Excel на Localhost ограничен</h4>
                            <p class="text-xs text-slate-400 max-w-md">Внешние онлайн-сервисы просмотра не могут загрузить файл с локального ПК.</p>
                            <a id="localDownloadFallback" href="#" download class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2">
                                <i class="bi bi-download"></i> Скачать файл для проверки
                            </a>
                        </div>

                        <div class="document-wrapper h-full" id="documentWrapper">
                            <div id="previewViewport" class="rounded-xl">
                                <div id="renderTarget" class="w-full h-full"></div>
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
                    alertNoDoc: "Выберите документ!",
                    autoNotice: "Штамп будет наложен автоматически при подписании"
                },
                tj: {
                    signingTitle: "Муҳофизат ва QR",
                    selectDocLabel: "Интихоби ҳуҷҷат",
                    docPlaceholder: "-- Рӯйхати ҳуҷҷатҳо --",
                    btnSign: "Татбиқ кардани муҳр",
                    previewLabel: "Пешнамоиш",
                    btnFullScreen: "Дар тамоми экран",
                    alertNoDoc: "Ҳуҷҷатро интихоб кунед!",
                    autoNotice: "Муҳр ҳангоми имзо ба таври автоматикӣ гузошта мешавад"
                },
                en: {
                    signingTitle: "Security & QR",
                    selectDocLabel: "Select Document",
                    docPlaceholder: "-- Document List --",
                    btnSign: "Apply Stamp",
                    previewLabel: "Preview",
                    btnFullScreen: "Full Screen",
                    alertNoDoc: "Please select a document!",
                    autoNotice: "The stamp will be applied automatically upon signing"
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

            const form = document.getElementById('signatureForm');
            const select = document.getElementById('documentSelect');
            const previewViewport = document.getElementById('previewViewport');
            const renderTarget = document.getElementById('renderTarget');
            const fullScreenBtn = document.getElementById('fullScreenBtn');
            const formatBadge = document.getElementById('formatBadge');
            const loader = document.getElementById('viewerLoader');
            const qrPayloadInput = document.getElementById('qrPayloadInput');
            const localWarning = document.getElementById('localWarning');
            const localDownloadFallback = document.getElementById('localDownloadFallback');
            const wrapper = document.getElementById('documentWrapper');

            const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

            function updateSelection() {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption && selectedOption.value && selectedOption.value !== "") {
                    const fileUrl = selectedOption.getAttribute('data-file');
                    const type = selectedOption.getAttribute('data-type');
                    const ext = selectedOption.getAttribute('data-ext');
                    const qrText = selectedOption.getAttribute('data-qr-text');

                    qrPayloadInput.value = qrText;
                    localWarning.style.display = 'none';
                    wrapper.style.display = 'flex';
                    loader.style.display = 'block';
                    previewViewport.style.opacity = '0.3';
                    renderTarget.innerHTML = '';

                    formatBadge.textContent = ext.toUpperCase();
                    let badgeColor = 'bg-red-600';
                    if (type === 'word') badgeColor = 'bg-blue-600';
                    if (type === 'excel') badgeColor = 'bg-emerald-600';
                    if (type === 'rtf') badgeColor = 'bg-purple-600';
                    formatBadge.className = `px-2 py-0.5 rounded text-[9px] font-black uppercase text-white ${badgeColor} inline-block`;
                    formatBadge.classList.remove('hidden');

                    fullScreenBtn.href = fileUrl;
                    fullScreenBtn.classList.remove('hidden');

                    if (ext === 'docx') {
                        fetch(fileUrl)
                            .then(response => {
                                if(!response.ok) throw new Error('Ошибка скачивания файла');
                                return response.blob();
                            })
                            .then(blob => {
                                const wordDiv = document.createElement('div');
                                wordDiv.id = 'word-preview';
                                renderTarget.appendChild(wordDiv);

                                docx.renderAsync(blob, wordDiv)
                                    .then(() => {
                                        loader.style.display = 'none';
                                        previewViewport.style.opacity = '1';
                                    });
                            })
                            .catch(err => {
                                console.error(err);
                                loader.style.display = 'none';
                                previewViewport.style.opacity = '1';
                                renderTarget.innerHTML = `<div class="p-6 text-center text-sm font-semibold text-rose-500">Не удалось отобразить файл DOCX локально.</div>`;
                            });
                        return;
                    }

                    if (type === 'excel' && isLocal) {
                        loader.style.display = 'none';
                        wrapper.style.display = 'none';
                        localWarning.style.display = 'flex';
                        localDownloadFallback.href = fileUrl;
                        return;
                    }

                    let iframeSrc = '';
                    if (type === 'word' || type === 'excel') {
                        iframeSrc = `https://view.officeapps.live.com/op/view.aspx?src=${encodeURIComponent(fileUrl)}`;
                    } else if (type === 'rtf') {
                        iframeSrc = fileUrl;
                    } else {
                        iframeSrc = fileUrl + '#toolbar=0&navpanes=0&scrollbar=0&view=FitH';
                    }

                    const iframe = document.createElement('iframe');
                    iframe.src = iframeSrc;
                    iframe.className = "w-full h-full border-none block";
                    iframe.frameBorder = "0";

                    iframe.onload = () => {
                        loader.style.display = 'none';
                        previewViewport.style.opacity = '1';
                    };

                    renderTarget.appendChild(iframe);
                }
            }

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
            });
        });
    </script>
@endsection
