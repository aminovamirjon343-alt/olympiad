{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="min-h-[calc(100vh-64px)] bg-slate-50 py-10 px-4 md:px-8 font-inter text-slate-900">--}}
{{--        <div class="max-w-2xl mx-auto">--}}

{{--            --}}{{-- BACK --}}
{{--            <div class="flex items-center gap-3 mb-6">--}}
{{--                <a href="{{ route('documents.index') }}"--}}
{{--                   class="w-11 h-11 flex items-center justify-center rounded-xl bg-white border border-slate-200 shadow-sm hover:bg-black hover:text-white transition">--}}
{{--                    <i class="bi bi-arrow-left text-base"></i>--}}
{{--                </a>--}}
{{--                <div class="text-sm font-medium tracking-widest text-slate-600 uppercase" data-i18n="mainMenu">--}}
{{--                    Назад--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            --}}{{-- CARD --}}
{{--            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">--}}
{{--                <div class="p-9 md:p-11">--}}

{{--                    --}}{{-- HEADER --}}
{{--                    <div class="text-center mb-10">--}}
{{--                        <div class="w-16 h-16 mx-auto bg-black text-white rounded-2xl flex items-center justify-center text-2xl mb-4">--}}
{{--                            📄--}}
{{--                        </div>--}}
{{--                        <h1 class="text-3xl font-semibold text-black tracking-tight" data-i18n="newDocument">--}}
{{--                            Новый документ--}}
{{--                        </h1>--}}
{{--                        <p class="text-sm font-medium text-black tracking-widest uppercase mt-2 opacity-70" data-i18n="management">--}}
{{--                            Панель управления--}}
{{--                        </p>--}}
{{--                    </div>--}}

{{--                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">--}}
{{--                        @csrf--}}

{{--                        --}}{{-- Number --}}
{{--                        <div>--}}
{{--                            <label class="label">🔢 <span data-i18n="docNumberLabel">Номер документа</span></label>--}}
{{--                            <input type="text" id="doc_number" name="number"--}}
{{--                                   value="{{ old('number', '№ ') }}"--}}
{{--                                   class="input font-[1000] !text-black"--}}
{{--                                   required>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Type & Deadline --}}
{{--                        <div class="grid md:grid-cols-2 gap-5">--}}
{{--                            <div>--}}
{{--                                <label class="label">📌 <span data-i18n="docType">Тип документа</span></label>--}}
{{--                                <input type="text" name="type" class="input"--}}
{{--                                       data-i18n-placeholder="typePlaceholder"--}}
{{--                                       value="{{ old('type') }}" required>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <label class="label">📅 <span data-i18n="deadline">Дедлайн</span></label>--}}
{{--                                <input type="date" name="deadline" class="input">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Title --}}
{{--                        <div>--}}
{{--                            <label class="label">✏️ <span data-i18n="titleLabel">Заголовок</span></label>--}}
{{--                            <input type="text" name="title" class="input"--}}
{{--                                   data-i18n-placeholder="titlePlaceholder" required>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Description --}}
{{--                        <div>--}}
{{--                            <label class="label">💬 <span data-i18n="descriptionLabel">Описание</span></label>--}}
{{--                            <textarea name="content" rows="5" class="input"--}}
{{--                                      data-i18n-placeholder="descriptionPlaceholder"></textarea>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Recipient --}}
{{--                        <div>--}}
{{--                            <label class="label">📧 <span data-i18n="recipientEmail">Email получателя</span></label>--}}
{{--                            <input type="email" id="receiver_email" name="receiver_email" class="input font-bold"--}}
{{--                                   placeholder="user@email.com" required>--}}
{{--                            <div id="user-info" class="text-[10px] font-bold mt-2 uppercase tracking-wider"></div>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Status & File --}}
{{--                        <div class="grid md:grid-cols-2 gap-5">--}}
{{--                            <div>--}}
{{--                                <label class="label">⚙️ <span data-i18n="status">Статус</span></label>--}}
{{--                                <select name="status" class="input">--}}
{{--                                    <option value="draft" data-i18n="draft">Черновик</option>--}}
{{--                                    <option value="active" selected data-i18n="active">Активен</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <label class="label">📎 <span data-i18n="fileLabel">Файл</span></label>--}}
{{--                                --}}{{-- ИСПРАВЛЕНО: Добавлен accept=".pdf,.docx", чтобы операционная система сразу предлагала только нужные форматы --}}
{{--                                <input type="file" name="file_path" id="file" accept=".pdf,.docx" class="hidden">--}}
{{--                                <label for="file" class="flex items-center justify-between px-6 h-12 border border-slate-200 rounded-2xl bg-white cursor-pointer shadow-sm hover:border-black transition">--}}
{{--                                    <span id="file-name" class="text-[10px] font-[1000] uppercase tracking-[0.2em] text-black truncate pr-2" data-i18n="chooseFile">--}}
{{--                                        Выберите файл--}}
{{--                                    </span>--}}
{{--                                    <span class="text-xl">📂</span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="flex justify-center w-full pt-8">--}}
{{--                            <button type="submit" class="w-80 h-14 bg-black rounded-full font-[1000] uppercase text-[14px] tracking-[0.25em] text-white hover:opacity-90 active:scale-95 transition-all flex items-center justify-center gap-3">--}}
{{--                                <span data-i18n="send">Отправить</span>--}}
{{--                                <span class="text-xl">🚀</span>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    --}}{{-- SCRIPTS --}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function() {--}}
{{--            const translations = {--}}
{{--                en: {--}}
{{--                    mainMenu: "Back",--}}
{{--                    newDocument: "New Document",--}}
{{--                    management: "Management Panel",--}}
{{--                    docNumberLabel: "Document Number",--}}
{{--                    docType: "Document Type",--}}
{{--                    typePlaceholder: "e.g. Contract",--}}
{{--                    deadline: "Deadline",--}}
{{--                    titleLabel: "Title",--}}
{{--                    titlePlaceholder: "Enter title...",--}}
{{--                    descriptionLabel: "Description",--}}
{{--                    descriptionPlaceholder: "Add description...",--}}
{{--                    recipientEmail: "Recipient Email",--}}
{{--                    status: "Status",--}}
{{--                    draft: "Draft",--}}
{{--                    active: "Active",--}}
{{--                    fileLabel: "File",--}}
{{--                    chooseFile: "Choose File",--}}
{{--                    send: "Send"--}}
{{--                },--}}
{{--                ru: {--}}
{{--                    mainMenu: "Назад",--}}
{{--                    newDocument: "Новый документ",--}}
{{--                    management: "Панель управления",--}}
{{--                    docNumberLabel: "Номер документа",--}}
{{--                    docType: "Тип документа",--}}
{{--                    typePlaceholder: "Например: Договор",--}}
{{--                    deadline: "Дедлайн",--}}
{{--                    titleLabel: "Заголовок",--}}
{{--                    titlePlaceholder: "Введите название...",--}}
{{--                    descriptionLabel: "Описание",--}}
{{--                    descriptionPlaceholder: "Добавьте описание...",--}}
{{--                    recipientEmail: "Email получателя",--}}
{{--                    status: "Статус",--}}
{{--                    draft: "Черновик",--}}
{{--                    active: "Активен",--}}
{{--                    fileLabel: "Файл",--}}
{{--                    chooseFile: "Выберите файл",--}}
{{--                    send: "Отправить"--}}
{{--                },--}}
{{--                tj: {--}}
{{--                    mainMenu: "Қафо",--}}
{{--                    newDocument: "Ҳуҷҷати нав",--}}
{{--                    management: "Панели идоракунӣ",--}}
{{--                    docNumberLabel: "Рақами ҳуҷҷат",--}}
{{--                    docType: "Намуди ҳуҷҷат",--}}
{{--                    typePlaceholder: "Масалан: Шартнома",--}}
{{--                    deadline: "Мӯҳлат",--}}
{{--                    titleLabel: "Сарлавҳа",--}}
{{--                    titlePlaceholder: "Номро ворид кунед...",--}}
{{--                    descriptionLabel: "Тавсиф",--}}
{{--                    descriptionPlaceholder: "Тавсифро илова кунед...",--}}
{{--                    recipientEmail: "Email-и қабулкунанда",--}}
{{--                    status: "Ҳолат",--}}
{{--                    draft: "Пешнавис",--}}
{{--                    active: "Фаъол",--}}
{{--                    fileLabel: "Файл",--}}
{{--                    chooseFile: "Файлро интихоб кунед",--}}
{{--                    send: "Фиристодан"--}}
{{--                }--}}
{{--            };--}}

{{--            function applyTranslations() {--}}
{{--                const lang = localStorage.getItem('app-lang') || 'ru';--}}
{{--                const t = translations[lang];--}}
{{--                if (!t) return;--}}

{{--                document.querySelectorAll('[data-i18n]').forEach(el => {--}}
{{--                    const key = el.getAttribute('data-i18n');--}}
{{--                    if (t[key]) el.textContent = t[key];--}}
{{--                });--}}

{{--                document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {--}}
{{--                    const key = el.getAttribute('data-i18n-placeholder');--}}
{{--                    if (t[key]) el.setAttribute('placeholder', t[key]);--}}
{{--                });--}}
{{--            }--}}

{{--            applyTranslations();--}}
{{--            setInterval(applyTranslations, 1000);--}}

{{--            // Логика "№ " в инпуте--}}
{{--            const numInput = document.getElementById('doc_number');--}}
{{--            numInput.addEventListener('input', function() {--}}
{{--                if (!this.value.startsWith('№ ')) {--}}
{{--                    this.value = '№ ' + this.value.replace(/^№?\s?/, '');--}}
{{--                }--}}
{{--            });--}}

{{--            // Логика отображения имени файла--}}
{{--            document.getElementById('file').addEventListener('change', function() {--}}
{{--                const name = this.files[0] ? this.files[0].name.toUpperCase() : "ВЫБЕРИТЕ ФАЙЛ";--}}
{{--                document.getElementById('file-name').textContent = name;--}}
{{--                document.getElementById('file-name').removeAttribute('data-i18n'); // Убираем автоперевод после выбора--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

{{--    <style>--}}
{{--        .label { font-size: 12px; font-weight: 500; letter-spacing: .18em; text-transform: uppercase; display:block; margin-bottom:7px; color:#334155; }--}}
{{--        .input { width:100%; height:54px; border-radius:16px; border:1px solid #e2e8f0; padding:0 16px; font-weight:500; font-size:14px; outline:none; transition:.2s; color:#0f172a; background:#fff; }--}}
{{--        .input:focus { border-color:#000; box-shadow:0 6px 0 #000; transform:translateY(-2px); }--}}
{{--        textarea.input { min-height:140px; padding-top:14px; }--}}
{{--    </style>--}}
{{--@endsection--}}


@extends('layouts.admin')

@section('content')
    <div class="min-h-[calc(100vh-64px)] bg-slate-50 py-10 px-4 md:px-8 font-inter text-slate-900">
        <div class="max-w-2xl mx-auto">

            {{-- BACK --}}
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('documents.index') }}"
                   class="w-11 h-11 flex items-center justify-center rounded-xl bg-white border border-slate-200 shadow-sm hover:bg-black hover:text-white transition">
                    <i class="bi bi-arrow-left text-base"></i>
                </a>
                <div class="text-sm font-medium tracking-widest text-slate-600 uppercase" data-i18n="mainMenu">
                    Назад
                </div>
            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
                <div class="p-9 md:p-11">

                    {{-- HEADER --}}
                    <div class="text-center mb-10">
                        <div class="w-16 h-16 mx-auto bg-black text-white rounded-2xl flex items-center justify-center text-2xl mb-4">
                            📄
                        </div>
                        <h1 class="text-3xl font-semibold text-black tracking-tight" data-i18n="newDocument">
                            Новый документ
                        </h1>
                        <p class="text-sm font-medium text-black tracking-widest uppercase mt-2 opacity-70" data-i18n="management">
                            Панель управления
                        </p>
                    </div>

                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('button[type=submit]').opacity = '0.7';">
                        @csrf

                        {{-- Number --}}
                        <div>
                            <label class="label">🔢 <span data-i18n="docNumberLabel">Номер документа</span></label>
                            <input type="text" id="doc_number" name="number"
                                   value="{{ old('number', '№ ') }}"
                                   class="input font-[1000] !text-black"
                                   required>
                        </div>

                        {{-- Type & Deadline --}}
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">📌 <span data-i18n="docType">Тип документа</span></label>
                                <input type="text" name="type" class="input"
                                       data-i18n-placeholder="typePlaceholder"
                                       value="{{ old('type') }}" required>
                            </div>
                            <div>
                                <label class="label">📅 <span data-i18n="deadline">Дедлайн</span></label>
                                <input type="date" name="deadline" class="input">
                            </div>
                        </div>

                        {{-- Title --}}
                        <div>
                            <label class="label">✏️ <span data-i18n="titleLabel">Заголовок</span></label>
                            <input type="text" name="title" class="input"
                                   data-i18n-placeholder="titlePlaceholder" required>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="label">💬 <span data-i18n="descriptionLabel">Описание</span></label>
                            <textarea name="content" rows="5" class="input"
                                      data-i18n-placeholder="descriptionPlaceholder"></textarea>
                        </div>

                        {{-- Recipient --}}
                        <div>
                            <label class="label">📧 <span data-i18n="recipientEmail">Email получателя</span></label>
                            <input type="email" id="receiver_email" name="receiver_email" class="input font-bold"
                                   placeholder="user@email.com" required>
                        </div>

                        {{-- Status & File --}}
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">⚙️ <span data-i18n="status">Статус</span></label>
                                <select name="status" class="input">
                                    <option value="draft" data-i18n="draft">Черновик</option>
                                    <option value="active" selected data-i18n="active">Активен</option>
                                </select>
                            </div>
                            <div>
                                <label class="label">📎 <span data-i18n="fileLabel">Файл (PDF, DOCX, XLSX)</span></label>
                                {{-- ИСПРАВЛЕНО: Добавлен .xlsx в accept --}}
                                <input type="file" name="file_path" id="file" accept=".pdf,.docx,.xlsx" class="hidden">
                                <label for="file" class="flex items-center justify-between px-6 h-12 border border-slate-200 rounded-2xl bg-white cursor-pointer shadow-sm hover:border-black transition">
                                    <span id="file-name" class="text-[10px] font-[1000] uppercase tracking-[0.2em] text-black truncate pr-2" data-i18n="chooseFile">
                                        Выберите файл
                                    </span>
                                    <span class="text-xl">📂</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-center w-full pt-8">
                            <button type="submit" class="w-80 h-14 bg-black rounded-full font-[1000] uppercase text-[14px] tracking-[0.25em] text-white hover:opacity-90 active:scale-95 transition-all flex items-center justify-center gap-3">
                                <span data-i18n="send">Отправить</span>
                                <span class="text-xl">🚀</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const translations = {
                en: {
                    mainMenu: "Back",
                    newDocument: "New Document",
                    management: "Management Panel",
                    docNumberLabel: "Document Number",
                    docType: "Document Type",
                    typePlaceholder: "e.g. Contract",
                    deadline: "Deadline",
                    titleLabel: "Title",
                    titlePlaceholder: "Enter title...",
                    descriptionLabel: "Description",
                    descriptionPlaceholder: "Add description...",
                    recipientEmail: "Recipient Email",
                    status: "Status",
                    draft: "Draft",
                    active: "Active",
                    fileLabel: "File (PDF, DOCX, XLSX)",
                    chooseFile: "Choose File",
                    send: "Send"
                },
                ru: {
                    mainMenu: "Назад",
                    newDocument: "Новый документ",
                    management: "Панель управления",
                    docNumberLabel: "Номер документа",
                    docType: "Тип документа",
                    typePlaceholder: "Например: Договор",
                    deadline: "Дедлайн",
                    titleLabel: "Заголовок",
                    titlePlaceholder: "Введите название...",
                    descriptionLabel: "Описание",
                    descriptionPlaceholder: "Добавьте описание...",
                    recipientEmail: "Email получателя",
                    status: "Статус",
                    draft: "Черновик",
                    active: "Активен",
                    fileLabel: "Файл (PDF, DOCX, XLSX)",
                    chooseFile: "Выберите файл",
                    send: "Отправить"
                },
                tj: {
                    mainMenu: "Қафо",
                    newDocument: "Ҳуҷҷати нав",
                    management: "Панели идоракунӣ",
                    docNumberLabel: "Рақами ҳуҷҷат",
                    docType: "Намуди ҳуҷҷат",
                    typePlaceholder: "Масалан: Шартнома",
                    deadline: "Мӯҳлат",
                    titleLabel: "Сарлавҳа",
                    titlePlaceholder: "Номро ворид кунед...",
                    descriptionLabel: "Тавсиф",
                    descriptionPlaceholder: "Тавсифро илова кунед...",
                    recipientEmail: "Email-и қабулкунанда",
                    status: "Ҳолат",
                    draft: "Пешнавис",
                    active: "Фаъол",
                    fileLabel: "Файл (PDF, DOCX, XLSX)",
                    chooseFile: "Файлро интихоб кунед",
                    send: "Фиристодан"
                }
            };

            function applyTranslations() {
                const lang = localStorage.getItem('app-lang') || 'ru';
                const t = translations[lang];
                if (!t) return;

                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if (t[key]) el.textContent = t[key];
                });

                document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                    const key = el.getAttribute('data-i18n-placeholder');
                    if (t[key]) el.setAttribute('placeholder', t[key]);
                });
            }

            applyTranslations();
            // Вызываем один раз, setInterval здесь не нужен, если язык не меняется динамически без перезагрузки
            // Но оставим для совместимости с твоим кодом.

            const numInput = document.getElementById('doc_number');
            numInput.addEventListener('input', function() {
                if (!this.value.startsWith('№ ')) {
                    this.value = '№ ' + this.value.replace(/^№?\s?/, '');
                }
            });

            document.getElementById('file').addEventListener('change', function() {
                const name = this.files[0] ? this.files[0].name.toUpperCase() : "ВЫБЕРИТЕ ФАЙЛ";
                document.getElementById('file-name').textContent = name;
                document.getElementById('file-name').removeAttribute('data-i18n');
            });
        });
    </script>

    <style>
        .label { font-size: 12px; font-weight: 500; letter-spacing: .18em; text-transform: uppercase; display:block; margin-bottom:7px; color:#334155; }
        .input { width:100%; height:54px; border-radius:16px; border:1px solid #e2e8f0; padding:0 16px; font-weight:500; font-size:14px; outline:none; transition:.2s; color:#0f172a; background:#fff; }
        .input:focus { border-color:#000; box-shadow:0 6px 0 #000; transform:translateY(-2px); }
        textarea.input { min-height:140px; padding-top:14px; }
    </style>
@endsection
