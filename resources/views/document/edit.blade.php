@extends('layouts.admin')

@section('content')
    @php
        $ownerId = (int) ($document->created_by ?? 0);
        $currentUserId = (int) auth()->id();
        $isOwner = ($currentUserId === $ownerId);
    @endphp

    <div class="min-h-[calc(100vh-64px)] bg-slate-50 py-10 px-4 md:px-8 font-inter text-slate-900">
       <div class="max-w-5xl mx-auto">


            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('documents.index') }}"
                   class="w-11 h-11 flex items-center justify-center rounded-xl bg-white border border-slate-200 shadow-sm hover:bg-black hover:text-white transition text-black">
                    <i class="bi bi-arrow-left text-base"></i>
                </a>
                <div class="text-sm font-medium tracking-widest text-slate-600 uppercase" data-i18n="backToDoc">
                    Назад к документу
                </div>
            </div>


            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
                <div class="p-9 md:p-11 text-black">


                    <div class="text-center mb-10">
                        <div class="w-16 h-16 mx-auto bg-black text-white rounded-2xl flex items-center justify-center text-2xl mb-4">
                            {{ $isOwner ? '✏️' : '🔒' }}
                        </div>
                        <h1 class="text-3xl font-semibold text-black tracking-tight" data-i18n="{{ $isOwner ? 'editTitle' : 'viewOnlyTitle' }}">
                            {{ $isOwner ? 'Редактировать' : 'Только просмотр' }}
                        </h1>

                        @if(!$isOwner)
                            <div class="mt-2 inline-block px-3 py-1 bg-amber-100 text-amber-900 text-[9px] font-bold uppercase tracking-widest rounded-full">
                                <i class="bi bi-shield-lock-fill"></i> Access: Read Only
                            </div>
                        @endif

                        <p class="text-[10px] font-[1000] text-black tracking-[0.3em] uppercase mt-2 opacity-70">
                            <span data-i18n="updateId">Обновление ID</span> #{{ $document->id }}
                        </p>
                    </div>

                    <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6"
                          @if($isOwner) onsubmit="let btn = this.querySelector('button[type=submit]'); if(btn) { btn.disabled = true; btn.style.opacity = '0.7'; }" @endif>
                        @csrf
                        @method('PUT')


                        <div>
                            <label class="label"><span data-i18n="docNumberLabel">Номер документа</span></label>
                            <input type="text" name="number" value="{{ old('number', $document->number) }}"
                                   class="input font-bold text-black {{ !$isOwner ? 'bg-slate-50 cursor-not-allowed opacity-70' : '' }}"
                                {{ !$isOwner ? 'readonly' : '' }}>
                        </div>


                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label"><span data-i18n="docType">Тип</span></label>
                                <input type="text" name="type" class="input font-bold text-black {{ !$isOwner ? 'bg-slate-50' : '' }}"
                                       value="{{ old('type', $document->type ?? '') }}"
                                       {{ !$isOwner ? 'readonly' : '' }} required>
                            </div>
                            <div>
                                <label class="label"><span data-i18n="deadline">Дедлайн</span></label>
                                <input type="date" name="deadline" value="{{ old('deadline', $document->deadline ? $document->deadline->format('Y-m-d') : '') }}"
                                       class="input font-bold text-black {{ !$isOwner ? 'bg-slate-50' : '' }}"
                                    {{ !$isOwner ? 'readonly' : '' }}>
                            </div>
                        </div>


                        <div>
                            <label class="label"><span data-i18n="recipientEmail">Email получателя</span></label>
                            <input type="email" name="receiver_email" value="{{ old('receiver_email', $document->receiver_email ?? '') }}"
                                   class="input font-bold text-black {{ !$isOwner ? 'bg-slate-50' : '' }}"
                                   data-i18n-placeholder="emailPlaceholder"
                                   {{ !$isOwner ? 'readonly' : '' }} required>
                        </div>


                        <div>
                            <label class="label"><span data-i18n="titleLabel">Заголовок</span></label>
                            <input type="text" name="title" value="{{ old('title', $document->title) }}"
                                   class="input font-bold text-black {{ !$isOwner ? 'bg-slate-50' : '' }}"
                                   {{ !$isOwner ? 'readonly' : '' }} required>
                        </div>


                        <div>
                            <label class="label"><span data-i18n="descriptionLabel">Описание</span></label>
                            <textarea name="content" rows="5"
                                      class="input py-4 text-black {{ !$isOwner ? 'bg-slate-50 cursor-not-allowed' : '' }}"
                                      {{ !$isOwner ? 'readonly' : '' }}>{{ old('content', $document->content) }}</textarea>
                        </div>


                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label"><span data-i18n="currentStatus">Текущий статус</span></label>
                                <select name="status" class="input font-[1000] text-black {{ !$isOwner ? 'bg-slate-50 pointer-events-none' : '' }}" {{ !$isOwner ? 'disabled' : '' }}>
                                    <option value="draft" class="text-black" {{ old('status', $document->status) == 'draft' ? 'selected' : '' }} data-i18n="draft">ЧЕРНОВИК</option>
                                    <option value="active" class="text-black" {{ old('status', $document->status) == 'active' ? 'selected' : '' }} data-i18n="active">АКТИВЕН</option>
                                </select>
                                @if(!$isOwner) <input type="hidden" name="status" value="{{ $document->status }}"> @endif
                            </div>

                            @if($isOwner)
                                <div>
                                    <label class="label">📎 <span data-i18n="newFileOptional">Новый файл (PDF, DOCX, XLSX, RTF)</span></label>
                                    <input type="file" name="file_path" id="file" accept=".pdf,.docx,.xlsx,.rtf" class="hidden">
                                    <label for="file" class="flex items-center justify-between px-6 h-[54px] border border-slate-200 rounded-2xl bg-white cursor-pointer shadow-sm hover:border-black transition">
                                        <span id="file-name" data-is-custom="false" class="text-[10px] font-[1000] uppercase tracking-[0.2em] text-black truncate pr-2">
                                            {{ $document->file_path ? basename($document->file_path) : 'Выбрать файл' }}
                                        </span>
                                        <span class="text-xl">📂</span>
                                    </label>
                                </div>
                            @endif
                        </div>


                        @if($isOwner)
                            <div class="flex justify-center w-full pt-8">
                                <button type="submit"
                                        class="w-80 h-14 rounded-full bg-black font-[1000] uppercase text-[14px] tracking-[0.25em] text-white hover:opacity-90 active:scale-95 transition-all shadow-lg flex items-center justify-center gap-3">
                                    <span data-i18n="save">Сохранить</span>
                                    <span class="text-xl">💾</span>
                                </button>
                            </div>
                        @else
                            <div class="text-center pt-8">
                                <p class="text-[10px] font-bold text-black uppercase tracking-widest" data-i18n="cannotSaveHint">
                                    Вы не можете сохранить изменения, так как не являетесь владельцем.
                                </p>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .label { font-size: 11px; font-weight: 1000; letter-spacing: .25em; text-transform: uppercase; display:block; margin-bottom:8px; color:#000000 !important; }
        .input { width:100%; height:54px; border-radius:16px; border:1px solid #e2e8f0; padding:0 16px; font-weight:500; font-size:14px; outline:none; transition:.2s; color:#000000 !important; background:#ffffff; }
        .input:focus:not([readonly]) { border-color:#000; box-shadow:0 6px 0 #000; transform:translateY(-2px); }
        textarea.input { min-height:140px; }
        select.input option { color: #000000 !important; background-color: #ffffff !important; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const translations = {
                en: {
                    backToDoc: "Back to Document",
                    editTitle: "Edit Document",
                    viewOnlyTitle: "View Only",
                    updateId: "Update ID",
                    docNumberLabel: "Document Number",
                    docType: "Type",
                    typePlaceholder: "e.g. Contract",
                    deadline: "Deadline",
                    titleLabel: "Title",
                    recipientEmail: "Recipient Email",
                    emailPlaceholder: "example@mail.com",
                    descriptionLabel: "Description",
                    currentStatus: "Current Status",
                    draft: "DRAFT",
                    active: "ACTIVE",
                    newFileOptional: "New File (PDF, DOCX, XLSX, RTF)",
                    chooseFile: "Choose File",
                    save: "Save",
                    cannotSaveHint: "You cannot save changes because you are not the owner."
                },
                ru: {
                    backToDoc: "Назад к документу",
                    editTitle: "Редактировать",
                    viewOnlyTitle: "Только просмотр",
                    updateId: "Обновление ID",
                    docNumberLabel: "Номер документа",
                    docType: "Тип",
                    typePlaceholder: "Например: Договор",
                    deadline: "Дедлайн",
                    titleLabel: "Заголовок",
                    recipientEmail: "Email получателя",
                    emailPlaceholder: "example@mail.com",
                    descriptionLabel: "Описание",
                    currentStatus: "Текущий статус",
                    draft: "ЧЕРНОВИК",
                    active: "АКТИВЕН",
                    newFileOptional: "Новый файл (PDF, DOCX, XLSX, RTF)",
                    chooseFile: "Выбрать файл",
                    save: "Сохранить",
                    cannotSaveHint: "Вы не можете сохранить изменения, так как не являетесь владельцем."
                },
                tj: {
                    backToDoc: "Қафо ба ҳуҷҷат",
                    editTitle: "Вироиш кардан",
                    viewOnlyTitle: "Танҳо барои тамошо",
                    updateId: "Навсозии ID",
                    docNumberLabel: "Рақами ҳуҷҷат",
                    docType: "Намуд",
                    typePlaceholder: "Масалан: Шартнома",
                    deadline: "Мӯҳлат",
                    titleLabel: "Сарлавҳа",
                    recipientEmail: "Email-и қабулкунанда",
                    emailPlaceholder: "example@mail.com",
                    descriptionLabel: "Тавсиф",
                    currentStatus: "Ҳолати ҷорӣ",
                    draft: "ПЕШНАВИС",
                    active: "ФАЪОЛ",
                    newFileOptional: "Файли нав (PDF, DOCX, XLSX, RTF)",
                    chooseFile: "Интихоби файл",
                    save: "Захира кардан",
                    cannotSaveHint: "Шумо наметавонед тағиротро захира кунед, зеро шумо соҳиби он нестед."
                }
            };

            const fileInput = document.getElementById('file');
            const nameDisplay = document.getElementById('file-name');

            function applyEditTranslations() {
                const lang = localStorage.getItem('app-lang') || 'ru';
                const t = translations[lang];
                if (!t) return;

                document.querySelectorAll('[data-i18n]').forEach(el => {
                    if (el.id === 'file-name' && el.getAttribute('data-is-custom') === 'true') {
                        return;
                    }
                    const key = el.getAttribute('data-i18n');
                    if (t[key]) el.textContent = t[key];
                });

                document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                    const key = el.getAttribute('data-i18n-placeholder');
                    if (t[key]) el.setAttribute('placeholder', t[key]);
                });
            }

            if (fileInput && nameDisplay) {
                fileInput.addEventListener('change', () => {
                    if (fileInput.files.length > 0) {
                        nameDisplay.textContent = fileInput.files[0].name.toUpperCase();
                        nameDisplay.setAttribute('data-is-custom', 'true');
                    } else {
                        nameDisplay.setAttribute('data-is-custom', 'false');
                        applyEditTranslations();
                    }
                });
            }

            applyEditTranslations();
            window.addEventListener('storage', function(e) {
                if (e.key === 'app-lang') applyEditTranslations();
            });
        });
    </script>
@endsection
