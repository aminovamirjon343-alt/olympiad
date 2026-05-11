@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <div class="min-h-screen bg-gray-50 px-6 py-8" style="font-family: Inter, sans-serif;">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('versions.index') }}"
                   class="text-xs text-gray-500 hover:text-black transition">
                    ← <span data-i18n="backBtn">Back</span>
                </a>

                <h1 class="text-2xl font-semibold text-gray-900 mt-1">
                    <span data-i18n="editTitle">Edit Version</span> v{{ $version->version }}
                </h1>

                <p class="text-sm text-gray-500" data-i18n="editSubTitle">
                    Update file or change version data
                </p>
            </div>
        </div>

        {{-- FORM --}}
        <div class="max-w-2xl bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

            <form action="{{ route('versions.update', $version->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- DOCUMENT --}}
                <div class="mb-5">
                    <label class="text-xs text-gray-400 uppercase" data-i18n="labelDoc">Document</label>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $version->document->title ?? 'Deleted' }}
                    </p>
                </div>

                {{-- CURRENT FILE --}}
                <div class="mb-5">
                    <label class="text-xs text-gray-400 uppercase" data-i18n="labelCurrentFile">Current File</label>
                    <a href="{{ asset('storage/' . $version->file_path) }}"
                       target="_blank"
                       class="block text-blue-600 text-sm hover:underline" data-i18n="btnViewFile">
                        View current file
                    </a>
                </div>

                {{-- UPLOAD NEW FILE --}}
                <div class="mb-5">
                    <label class="text-xs text-gray-400 uppercase" data-i18n="labelNewFile">New File (optional)</label>
                    <input type="file"
                           name="file_path"
                           class="w-full mt-2 p-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- CHANGE NOTE --}}
                <div class="mb-6">
                    <label class="text-xs text-gray-400 uppercase" data-i18n="labelSummary">Change Summary</label>
                    <textarea name="change_summary"
                              id="change_summary"
                              rows="3"
                              class="w-full mt-2 p-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="What changed in this version?">{{ $version->change_summary }}</textarea>
                </div>

                {{-- BUTTONS --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('versions.index') }}"
                       class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 text-sm hover:bg-gray-200 transition" data-i18n="btnCancel">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-5 py-2 rounded-xl bg-black text-white text-sm font-medium hover:bg-gray-800 transition" data-i18n="btnSave">
                        Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    backBtn: "Назад",
                    editTitle: "Редактировать версию",
                    editSubTitle: "Обновите файл или измените данные версии",
                    labelDoc: "Документ",
                    labelCurrentFile: "Текущий файл",
                    btnViewFile: "Посмотреть текущий файл",
                    labelNewFile: "Новый файл (необязательно)",
                    labelSummary: "Описание изменений",
                    placeholderSummary: "Что изменилось в этой версии?",
                    btnCancel: "Отмена",
                    btnSave: "Сохранить изменения"
                },
                tj: {
                    backBtn: "Бозгашт",
                    editTitle: "Таҳрири нусха",
                    editSubTitle: "Файлро нав кунед ё маълумоти нусхаро тағйир диҳед",
                    labelDoc: "Ҳуҷҷат",
                    labelCurrentFile: "Файли ҷорӣ",
                    btnViewFile: "Дидани файли ҷорӣ",
                    labelNewFile: "Файли нав (ихтиёрӣ)",
                    labelSummary: "Тавсифи тағйирот",
                    placeholderSummary: "Дар ин нусха чӣ тағйир ёфт?",
                    btnCancel: "Бекор кардан",
                    btnSave: "Захира кардани тағйирот"
                },
                en: {
                    backBtn: "Back",
                    editTitle: "Edit Version",
                    editSubTitle: "Update file or change version data",
                    labelDoc: "Document",
                    labelCurrentFile: "Current File",
                    btnViewFile: "View current file",
                    labelNewFile: "New File (optional)",
                    labelSummary: "Change Summary",
                    placeholderSummary: "What changed in this version?",
                    btnCancel: "Cancel",
                    btnSave: "Save Changes"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            // Перевод текстовых элементов
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // Перевод плейсхолдера
            const textarea = document.getElementById('change_summary');
            if (textarea && t.placeholderSummary) {
                textarea.placeholder = t.placeholderSummary;
            }
        });
    </script>
@endsection
