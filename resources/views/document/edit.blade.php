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

                <div class="text-sm font-medium tracking-widest text-slate-600 uppercase" data-i18n="backToDoc">
                    Назад к документу
                </div>
            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">

                <div class="p-9 md:p-11">

                    {{-- HEADER --}}
                    <div class="text-center mb-10">
                        <div class="w-16 h-16 mx-auto bg-black text-white rounded-2xl flex items-center justify-center text-2xl mb-4">
                            ✏️
                        </div>
                        <h1 class="text-3xl font-semibold text-black tracking-tight" data-i18n="editTitle">
                            Редактировать
                        </h1>
                        <p class="text-[10px] font-[1000] text-black tracking-[0.3em] uppercase mt-2 opacity-70">
                            <span data-i18n="updateId">Обновление ID</span> #{{ $document->id }}
                        </p>
                    </div>

                    {{-- ERRORS --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-2xl border border-red-200 bg-red-50">
                            @foreach($errors->all() as $error)
                                <div class="text-sm text-red-600 font-bold uppercase text-[10px]">• {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Number --}}
                        <div>
                            <label class="label">🔢 <span data-i18n="docNumberLabel">Номер документа</span></label>
                            <div class="relative flex items-center">
                                <input type="text"
                                       name="number"
                                       value="{{ $document->number }}"
                                       class="input font-bold !pl-11"
                                       placeholder="47-А">
                            </div>
                        </div>

                        {{-- ROW: Type & Deadline --}}
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">📌 <span data-i18n="docType">Тип</span></label>
                                <input type="text"
                                       name="type"
                                       class="input font-bold"
                                       value="{{ old('type', $document->type ?? '') }}"
                                       placeholder="УПД, Договор..."
                                       data-i18n-placeholder="typePlaceholder"
                                       required>
                            </div>
                            <div>
                                <label class="label">📅 <span data-i18n="deadline">Дедлайн</span></label>
                                <input type="date" name="deadline" value="{{ optional($document->deadline)->format('Y-m-d') }}" class="input font-bold">
                            </div>
                        </div>

                        {{-- Title --}}
                        <div>
                            <label class="label">✏️ <span data-i18n="titleLabel">Заголовок</span></label>
                            <input type="text" name="title" value="{{ $document->title }}" class="input font-bold" required>
                        </div>

                        {{-- Recipient --}}
                        <div>
                            <label class="block text-[11px] font-[1000] uppercase mb-2 tracking-widest text-black flex items-center gap-1.5">
                                <span class="text-base">📧</span> <span data-i18n="recipientEmail">Email получателя</span>
                            </label>
                            <div class="relative flex items-center">
                                <input type="email"
                                       name="receiver_email"
                                       value="{{ old('receiver_email', $document->receiver->email ?? '') }}"
                                       class="input font-bold !pl-11"
                                       placeholder="example@mail.com"
                                       required>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="label">💬 <span data-i18n="descriptionLabel">Описание</span></label>
                            <textarea name="content" rows="5" class="input py-4">{{ $document->content }}</textarea>
                        </div>

                        {{-- ROW: Status & File --}}
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">⚙️ <span data-i18n="currentStatus">Текущий статус</span></label>
                                <select name="status" class="input font-[1000] text-black">
                                    <option value="draft" {{ $document->status == 'draft' ? 'selected' : '' }} data-i18n="draft">ЧЕРНОВИК</option>
                                    <option value="active" {{ $document->status == 'active' ? 'selected' : '' }} data-i18n="active">АКТИВЕН</option>
                                </select>
                            </div>
                            <div>
                                <label class="label">📎 <span data-i18n="newFileOptional">Новый файл (Опционально)</span></label>
                                {{-- ИСПРАВЛЕНО: Добавлен accept=".pdf,.docx" для фильтрации расширений файлов --}}
                                <input type="file" name="file_path" id="file" accept=".pdf,.docx" class="hidden">
                                <label for="file" class="flex items-center justify-between px-6 h-[54px] border border-slate-200 rounded-2xl bg-white cursor-pointer shadow-sm hover:border-black transition">
                                    <span id="file-name" class="text-[10px] font-[1000] uppercase tracking-[0.2em] text-black truncate max-w-[120px]">
                                        {{ $document->file_path ? basename($document->file_path) : 'Выбрать файл' }}
                                    </span>
                                    <span class="text-xl">📂</span>
                                </label>
                            </div>
                        </div>

                        {{-- SAVE BUTTON --}}
                        <div class="flex justify-center w-full pt-8">
                            <button type="submit"
                                    class="w-80 h-14 rounded-full bg-black font-[1000] uppercase text-[14px] tracking-[0.25em] text-white hover:scale-[1.02] active:scale-95 transition-all shadow-lg flex items-center justify-center gap-3">
                                <span data-i18n="save">Сохранить</span>
                                <span class="text-xl">💾</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .label { font-size: 11px; font-weight: 1000; letter-spacing: .25em; text-transform: uppercase; display:block; margin-bottom:8px; color:#000; }
        .input { width:100%; height:54px; border-radius:16px; border:1px solid #e2e8f0; padding:0 16px; font-weight:500; font-size:14px; outline:none; transition:.2s; color:#0f172a; background:#fff; }
        .input:focus { border-color:#000; box-shadow:0 6px 0 #000; transform:translateY(-2px); }
        textarea.input { min-height:140px; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const translations = {
                en: {
                    backToDoc: "Back to Document",
                    editTitle: "Edit Document",
                    updateId: "Update ID",
                    docNumberLabel: "Document Number",
                    docType: "Type",
                    typePlaceholder: "e.g. Contract",
                    deadline: "Deadline",
                    titleLabel: "Title",
                    recipientEmail: "Recipient Email",
                    descriptionLabel: "Description",
                    currentStatus: "Current Status",
                    draft: "DRAFT",
                    active: "ACTIVE",
                    newFileOptional: "New File (Optional)",
                    chooseFile: "Choose File",
                    save: "Save"
                },
                ru: {
                    backToDoc: "Назад к документу",
                    editTitle: "Редактировать",
                    updateId: "Обновление ID",
                    docNumberLabel: "Номер документа",
                    docType: "Тип",
                    typePlaceholder: "Например: Договор",
                    deadline: "Дедлайн",
                    titleLabel: "Заголовок",
                    recipientEmail: "Email получателя",
                    descriptionLabel: "Описание",
                    currentStatus: "Текущий статус",
                    draft: "ЧЕРНОВИК",
                    active: "АКТИВЕН",
                    newFileOptional: "Новый файл (Опционально)",
                    chooseFile: "Выбрать файл",
                    save: "Сохранить"
                },
                tj: {
                    backToDoc: "Қафо ба ҳуҷҷат",
                    editTitle: "Вироиш кардан",
                    updateId: "Навсозии ID",
                    docNumberLabel: "Рақами ҳуҷҷат",
                    docType: "Намуд",
                    typePlaceholder: "Масалан: Шартнома",
                    deadline: "Мӯҳлат",
                    titleLabel: "Сарлавҳа",
                    recipientEmail: "Email-и қабулкунанда",
                    descriptionLabel: "Тавсиф",
                    currentStatus: "Ҳолати ҷорӣ",
                    draft: "ПЕШНАВИС",
                    active: "ФАЪОЛ",
                    newFileOptional: "Файли нав (Ихтиёрӣ)",
                    chooseFile: "Интихоби файл",
                    save: "Захира кардан"
                }
            };

            function applyEditTranslations() {
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

            applyEditTranslations();
            setInterval(applyEditTranslations, 1000);

            // Логика выбора файла
            const file = document.getElementById('file');
            const nameDisplay = document.getElementById('file-name');
            file.addEventListener('change', () => {
                nameDisplay.textContent = file.files[0] ? file.files[0].name.toUpperCase() : "ВЫБРАТЬ ФАЙЛ";
                nameDisplay.removeAttribute('data-i18n');
            });
        });
    </script>
@endsection
