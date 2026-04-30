{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8 max-w-3xl">--}}

{{--        --}}{{-- Кнопка Назад --}}
{{--        <div class="mb-6">--}}
{{--            <a href="{{ route('documents.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition">--}}
{{--                <svg class="w-5 h-5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>--}}
{{--                </svg>--}}
{{--                Вернуться к списку--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">--}}
{{--            <div class="p-8">--}}
{{--                <div class="mb-8">--}}
{{--                    <h2 class="text-2xl font-extrabold text-gray-900">Новый документ</h2>--}}
{{--                    <p class="text-gray-500 mt-1">Заполните данные для создания нового электронного документа.</p>--}}
{{--                </div>--}}

{{--                --}}{{-- Блок ошибок --}}
{{--                @if ($errors->any())--}}
{{--                    <div class="mb-6 p-4 bg-red-50 border-s-4 border-red-500 rounded-lg">--}}
{{--                        <div class="flex">--}}
{{--                            <div class="flex-shrink-0">--}}
{{--                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">--}}
{{--                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />--}}
{{--                                </svg>--}}
{{--                            </div>--}}
{{--                            <div class="ml-3">--}}
{{--                                <h3 class="text-sm font-medium text-red-800">Обнаружены ошибки:</h3>--}}
{{--                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">--}}
{{--                                    @foreach ($errors->all() as $error)--}}
{{--                                        <li>{{ $error }}</li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">--}}
{{--                    @csrf--}}

{{--                    <div>--}}
{{--                        <label class="block text-sm font-bold text-gray-700 mb-2">Название документа</label>--}}
{{--                        <input type="text" name="title" value="{{ old('title') }}"--}}
{{--                               class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm"--}}
{{--                               placeholder="Например: Отчет по продажам за март">--}}
{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label class="block text-sm font-bold text-gray-700 mb-2">Описание / Текст</label>--}}
{{--                        <textarea name="content" rows="4"--}}
{{--                                  class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm"--}}
{{--                                  placeholder="Краткое описание содержания...">{{ old('content') }}</textarea>--}}
{{--                    </div>--}}

{{--                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">--}}
{{--                        <div>--}}
{{--                            <label class="block text-sm font-bold text-gray-700 mb-2">Статус</label>--}}
{{--                            <select name="status" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">--}}
{{--                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Черновик</option>--}}
{{--                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Активный</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label class="block text-sm font-bold text-gray-700 mb-2">Крайний срок (Дедлайн)</label>--}}
{{--                            <input type="date" name="deadline" value="{{ old('deadline') }}"--}}
{{--                                   class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label class="block text-sm font-bold text-gray-700 mb-2">Назначить ответственного</label>--}}
{{--                        <div class="relative">--}}
{{--                            <select name="user_id" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm appearance-none">--}}
{{--                                <option value="" disabled selected>Выберите пользователя...</option>--}}
{{--                                @foreach($users as $user)--}}
{{--                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>--}}
{{--                                        👤 {{ $user->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="p-6 border-2 border-dashed border-gray-200 rounded-2xl hover:border-indigo-400 transition bg-gray-50/50">--}}
{{--                        <label class="block text-sm font-bold text-gray-700 mb-2 text-center">Прикрепить файл</label>--}}
{{--                        <div class="flex flex-col items-center">--}}
{{--                            <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>--}}
{{--                            </svg>--}}
{{--                            <input type="file" name="file_path" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="pt-6 flex items-center justify-end gap-4 border-t border-gray-100">--}}
{{--                        <a href="{{ route('documents.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Отмена</a>--}}
{{--                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg shadow-indigo-200 active:scale-95">--}}
{{--                            Создать и сохранить--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

@extends('layouts.admin')

@section('content')
    <div class="doc-page-v2 bg-[#f8fafc] min-h-[calc(100vh-64px)] py-10 px-4 md:px-8 font-inter">
        <div class="max-w-2xl mx-auto">

            {{-- BACK BUTTON --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('documents.index') }}"
                   class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-black hover:bg-blue-600 hover:text-white shadow-sm transition-all">
                    <i class="bi bi-arrow-left text-sm"></i>
                </a>
                <h2 class="text-[12px] font-bold uppercase tracking-[0.2em] doc-title-adaptive">
                    Back
                </h2>
            </div>

            {{-- MAIN CARD --}}
            <div class="bg-white rounded-3xl border-[3px] border-black shadow-[8px_8px_0px_rgba(0,0,0,1)] overflow-hidden">
                <div class="p-8 md:p-12">

                    {{-- HEADER --}}
                    <div class="mb-10 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-black text-white rounded-2xl mb-4 shadow-xl">
                            <span class="text-3xl">📄</span>
                        </div>
                        <h2 class="text-3xl font-[900] text-black tracking-tighter uppercase">New Document</h2>
                        <p class="text-black font-[800] text-[10px] mt-2 uppercase tracking-[0.3em]">Official administration panel</p>
                    </div>

                    {{-- ERRORS --}}
                    @if ($errors->any())
                        <div class="mb-8 p-5 bg-red-50 border-[3px] border-black rounded-2xl">
                            <div class="flex items-center mb-3">
                                <span class="text-xl me-2">⚠️</span>
                                <span class="text-sm font-[900] text-black uppercase tracking-tight">System Errors:</span>
                            </div>
                            @foreach ($errors->all() as $error)
                                <div class="text-[12px] text-black font-[800] leading-relaxed mb-1 ps-6">• {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- TYPE --}}
                            <div class="space-y-3">
                                <label class="text-[12px] font-[900] uppercase tracking-widest text-black flex items-center">
                                    <span class="me-2 text-base">📌</span> Category
                                </label>
                                <div class="relative">
                                    <select name="type" required class="custom-input w-full appearance-none">
                                        <option value="">SELECT TYPE</option>
                                        <option value="УПД">УПД (UPD)</option>
                                        <option value="Договор">CONTRACT</option>
                                    </select>
                                    <i class="bi bi-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-black text-lg"></i>
                                </div>
                            </div>

                            {{-- DEADLINE --}}
                            <div class="space-y-3">
                                <label class="text-[12px] font-[900] uppercase tracking-widest text-black flex items-center">
                                    <span class="me-2 text-base">📅</span> Deadline
                                </label>
                                <div class="relative">
                                    <input type="date" name="deadline" class="w-full mt-1 px-4 py-2 border border-slate-200 rounded-lg text-[11px] text-black">
                                </div>
                            </div>
                        </div>

                        {{-- TITLE --}}
                        <div class="space-y-3">
                            <label class="text-[12px] font-[900] uppercase tracking-widest text-black flex items-center">
                                <span class="me-2 text-base">✏️</span> Subject
                            </label>
                            <input type="text" name="title" placeholder="ENTER DOCUMENT TITLE..." required class="custom-input w-full">
                        </div>

                        {{-- CONTENT --}}
                        <div class="space-y-3">
                            <label class="text-[12px] font-[900] uppercase tracking-widest text-black flex items-center">
                                <span class="me-2 text-base">💬</span> Description
                            </label>
                            <textarea name="content" rows="4" placeholder="DESCRIBE THE CONTENT HERE..." class="custom-input w-full resize-none"></textarea>
                        </div>

                        {{-- RECEIVER EMAIL --}}
                        <div class="space-y-3">
                            <label class="text-[12px] font-[900] uppercase tracking-widest text-black flex items-center">
                                <span class="me-2 text-base">📧</span> Recipient
                            </label>
                            <div class="relative">
                                <input type="email" name="receiver_email" placeholder="user67@gmail.com" required class="custom-input w-full ps-14">
                          </div>
                            <div id="user-info" class="text-[12px] font-[900] transition-all min-h-[1.2rem] ps-2 italic"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                            {{-- STATUS --}}
                            <div class="space-y-3">
                                <label class="text-[12px] font-[900] uppercase tracking-widest text-black flex items-center">
                                    <span class="me-2 text-base">⚙️</span> Status
                                </label>
                                <div class="relative">
                                    <select name="status" class="custom-input w-full appearance-none text-black">
                                        <option value="draft">DRAFT MODE</option>
                                        <option value="pending">PENDING</option>
                                    </select>
                                    <i class="bi bi-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-black"></i>
                                </div>
                            </div>

                            {{-- FILE UPLOAD --}}
                            <div class="space-y-3">
                                <label class="text-[12px] font-[900] uppercase tracking-widest text-black">📎 Attach</label>
                                <div class="relative">
                                    <input type="file" name="file_path" id="file_path" class="hidden">
                                    <label for="file_path" class="flex items-center justify-between w-full h-[60px] px-5 border-[3px] border-black rounded-2xl cursor-pointer hover:bg-black group transition-all">
                                        <span class="text-xs font-[900] text-black group-hover:text-white truncate uppercase" id="file-name">CHOOSE FILE</span>
                                        <span class="text-xl group-hover:scale-125 transition-transform">📂</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <div class="pt-6">
                            {{-- Добавляем небольшую правку в стили для тени --}}
                            @push('styles')
                                <style>
                                    .btn-primary-custom {
                                        background-color: var(--primary-color, #000000);
                                        /* Создаем эффект тени чуть темнее основного цвета */
                                        box-shadow: 0 8px 0 rgba(0, 0, 0, 0.2);
                                    }
                                    .btn-primary-custom:hover {
                                        filter: brightness(90%);
                                    }
                                    .btn-primary-custom:active {
                                        box-shadow: none;
                                    }
                                </style>
                            @endpush

                            <button type="submit"
                                    class="btn-primary-custom w-full text-white h-16 rounded-2xl font-[900] uppercase text-[15px] tracking-[0.4em] active:translate-y-1 transition-all flex items-center justify-center">
                                <span>Finalize & Send</span>
                                <span class="ms-3 text-xl">🚀</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.querySelector('input[name="receiver_email"]');
            const info = document.getElementById('user-info');
            const fileInput = document.getElementById('file_path');
            const fileNameDisplay = document.getElementById('file-name');

            fileInput.addEventListener('change', function() {
                fileNameDisplay.innerText = this.files[0] ? this.files[0].name.toUpperCase() : "CHOOSE FILE";
            });

            input.addEventListener('blur', function () {
                let email = this.value;
                if (!email) { info.innerHTML = ""; return; }

                fetch('/check-user?email=' + email)
                    .then(res => res.json())
                    .then(data => {
                        if (data.exists) {
                            info.innerHTML = `✨ VERIFIED: ${data.name.toUpperCase()}`;
                            info.className = "block text-[12px] font-[900] text-green-600";
                        } else {
                            info.innerHTML = `🚫 RECIPIENT NOT FOUND`;
                            info.className = "block text-[12px] font-[900] text-red-600";
                        }
                    });
            });
        });
    </script>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .font-inter { font-family: 'Inter', sans-serif; }

        .custom-input {
            background-color: #ffffff;
            border: 3px solid #000000; /* Толстая черная граница */
            border-radius: 18px; /* Более округлые */
            height: 60px; /* Увеличенная высота */
            padding: 0 20px;
            font-size: 15px;
            font-weight: 900 !important;
            color: #000000 !important;
            transition: all 0.1s ease-in-out;
            outline: none !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        textarea.custom-input {
            height: auto;
            padding: 20px;
        }

        .custom-input:focus {
            background-color: #fff;
            box-shadow: 4px 4px 0px #000; /* Нео-брутализм эффект при фокусе */
            transform: translate(-2px, -2px);
        }

        .custom-input::placeholder {
            color: rgba(0,0,0,0.2);
            font-weight: 900;
        }

        /* Все шрифты принудительно Inter 900 и черные */
        * {
            font-family: 'Inter', sans-serif !important;
        }

        input, select, textarea, option, label, i, p, div, span {
            color: #000000 !important;
            -webkit-text-fill-color: #000000 !important;
        }

        /* Белый текст только для элементов на черном фоне */
        .bg-black, button, button *, .group-hover\:text-white {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
        }

        /* Корректный цвет для анимированных кнопок */
        .group:hover label, .group:hover span {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
        }
    </style>
    <style>
        /* ПРИНУДИТЕЛЬНЫЙ СТИЛЬ "БЕЛЫЙ ФОН / ЧЕРНЫЙ ТЕКСТ" */
        input[type="date"].custom-input,
        .custom-input {
            /* 1. Отключаем автоматическую темную тему браузера */
            color-scheme: light !important;

            /* 2. Цвета */
            background-color: #ffffff !important;
            color: #000000 !important;

            /* 3. Границы и шрифт */
            border: 3px solid #000000 !important;
            border-radius: 18px;
            font-family: 'Inter', sans-serif !important;
            font-weight: 900 !important;

            /* 4. Сброс системных теней и прозрачности */
            opacity: 1 !important;
            -webkit-text-fill-color: #000000 !important;
            box-shadow: none !important;
        }

        /* Настройка внутренних полей даты, чтобы они не просвечивали */
        input[type="date"]::-webkit-datetime-edit,
        input[type="date"]::-webkit-datetime-edit-fields-wrapper,
        input[type="date"]::-webkit-datetime-edit-text,
        input[type="date"]::-webkit-datetime-edit-month-field,
        input[type="date"]::-webkit-datetime-edit-day-field,
        input[type="date"]::-webkit-datetime-edit-year-field {
            color: #000000 !important;
            -webkit-text-fill-color: #000000 !important;
        }

        /* Черная иконка календаря */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0) !important; /* Убирает инверсию в белый */
            opacity: 1 !important;
            cursor: pointer;
        }

        /* Убираем синее выделение при фокусе (делаем его черным) */
        .custom-input:focus {
            outline: none !important;
            border-color: #000000 !important;
            box-shadow: 4px 4px 0px #000000 !important; /* Твоя фирменная жесткая тень */
        }
    </style>
@endpush

{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8">--}}

{{--        --}}{{-- Навигация назад --}}
{{--        <div class="mb-6">--}}
{{--            <a href="{{ route('documents.index') }}" class="inline-flex items-center text-[10px] font-black text-gray-400 hover:text-blue-600 transition uppercase tracking-[0.2em]">--}}
{{--                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>--}}
{{--                </svg>--}}
{{--                Вернуться в реестр--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">--}}

{{--            --}}{{-- ОСНОВНАЯ ФОРМА (8 колонок) --}}
{{--            <div class="lg:col-span-8">--}}
{{--                <div class="bg-white rounded-[2.5rem] border border-blue-900 overflow-hidden shadow-sm">--}}
{{--                    <div class="p-8 md:p-12">--}}

{{--                        <div class="mb-10 border-s-4 border-blue-600 ps-6">--}}
{{--                            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Регистрация документа</h2>--}}
{{--                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-1">Система электронного документооборота</p>--}}
{{--                        </div>--}}

{{--                        @if ($errors->any())--}}
{{--                            <div class="mb-8 p-5 bg-red-50 border border-blue-900 rounded-2xl">--}}
{{--                                <p class="text-xs font-black text-red-800 uppercase mb-2 italic">Внимание, ошибки:</p>--}}
{{--                                <ul class="text-[11px] text-red-700 font-bold list-disc list-inside space-y-1">--}}
{{--                                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">--}}
{{--                            @csrf--}}

{{--                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">--}}
{{--                                --}}{{-- Тип документа --}}
{{--                                <div>--}}
{{--                                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Категория</label>--}}
{{--                                    <select id="doc_type" name="type" class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white focus:border-red-600 focus:ring-0 transition-all font-bold text-gray-900 outline-none text-sm appearance-none cursor-pointer">--}}
{{--                                        <optgroup label="Финансовые">--}}
{{--                                            <option value="УПД">УПД</option>--}}
{{--                                            <option value="Счёт">Счёт на оплату</option>--}}
{{--                                            <option value="Акт">Акт выполненных работ</option>--}}
{{--                                        </optgroup>--}}
{{--                                        <optgroup label="Административные">--}}
{{--                                            <option value="Договор">Договор</option>--}}
{{--                                            <option value="Приказ">Приказ</option>--}}
{{--                                            <option value="Служебная записка">Служебная записка</option>--}}
{{--                                        </optgroup>--}}
{{--                                    </select>--}}
{{--                                </div>--}}

{{--                                --}}{{-- Название --}}
{{--                                <div>--}}
{{--                                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Название документа</label>--}}
{{--                                    <input type="text" id="doc_title" name="title" value="{{ old('title') }}" required--}}
{{--                                           class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white focus:border-red-600 focus:ring-0 transition-all font-bold text-gray-900 outline-none text-sm"--}}
{{--                                           placeholder="Напр: Поставка оборудования #12">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Содержимое --}}
{{--                            <div>--}}
{{--                                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Текстовая часть</label>--}}
{{--                                <textarea id="doc_content" name="content" rows="10"--}}
{{--                                          class="w-full px-6 py-5 rounded-[2rem] border border-blue-900 bg-white focus:border-red-600 focus:ring-0 transition-all font-medium text-gray-700 outline-none leading-relaxed"--}}
{{--                                          placeholder="Введите текст или используйте AI..."></textarea>--}}
{{--                            </div>--}}

{{--                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">--}}
{{--                                --}}{{-- Статус --}}
{{--                                <div>--}}
{{--                                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Статус при создании</label>--}}
{{--                                    <select name="status" class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white font-bold text-sm outline-none focus:border-red-600">--}}
{{--                                        <option value="draft">Черновик</option>--}}
{{--                                        <option value="active">Активный / В работе</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                --}}{{-- Срок --}}
{{--                                <div>--}}
{{--                                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Дедлайн (если есть)</label>--}}
{{--                                    <input type="date" name="deadline" class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white font-bold text-sm outline-none focus:border-red-600 transition-all">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Загрузка файла --}}
{{--                            <div class="relative group">--}}
{{--                                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 text-center">Электронный образ (PDF, JPG, DOCX)</label>--}}
{{--                                <div class="relative flex flex-col items-center justify-center p-10 border-2 border-dashed border-blue-900 rounded-[2rem] bg-blue-50/30 group-hover:bg-red-50/30 group-hover:border-red-600 transition-all cursor-pointer">--}}
{{--                                    <input type="file" name="file_path" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">--}}
{{--                                    <div class="text-center pointer-events-none">--}}
{{--                                        <div class="w-16 h-16 bg-white border border-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-red-600 group-hover:border-red-600 transition-all">--}}
{{--                                            <i class="fas fa-file-upload text-xl text-blue-900 group-hover:text-white transition-colors"></i>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-[10px] font-black uppercase tracking-widest text-blue-900">Перетащите файл сюда</p>--}}
{{--                                        <p class="text-[9px] font-bold text-gray-400 uppercase mt-1">или нажмите для выбора</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Ответственный --}}
{{--                            <div>--}}
{{--                                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Ответственное лицо</label>--}}
{{--                                <select name="user_id" required class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white focus:border-red-600 font-bold text-sm outline-none transition-all">--}}
{{--                                    <option value="" disabled selected>Выберите из списка...</option>--}}
{{--                                    @foreach($users as $user)--}}
{{--                                        <option value="{{ $user->id }}">👤 {{ $user->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Кнопки действий --}}
{{--                            <div class="pt-10 flex items-center justify-between border-t border-gray-100">--}}
{{--                                <a href="{{ route('documents.index') }}" class="text-[11px] font-black text-gray-400 hover:text-blue-900 transition uppercase tracking-[0.2em]">Отменить</a>--}}
{{--                                <button type="submit" class="bg-white border border-blue-900 text-blue-900 hover:bg-red-600 hover:border-red-600 hover:text-white px-12 py-5 rounded-2xl font-black transition-all uppercase text-[11px] tracking-[0.2em] shadow-sm active:scale-95">--}}
{{--                                    Создать и отправить--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            --}}{{-- AI ASSISTANT (4 колонки) --}}
{{--            <div class="lg:col-span-4 lg:sticky lg:top-8 h-fit">--}}
{{--                <div class="bg-white border border-blue-900 rounded-[2rem] p-8 shadow-sm">--}}
{{--                    <div class="flex items-center gap-4 mb-8">--}}
{{--                        <div class="w-12 h-12 bg-blue-900 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-900/10">--}}
{{--                            <i class="fas fa-bolt text-white text-xl animate-pulse"></i>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <h4 class="text-sm font-black uppercase tracking-tight text-blue-900">AI Конструктор</h4>--}}
{{--                            <div class="flex items-center gap-1.5 mt-1">--}}
{{--                                <span class="w-2 h-2 bg-green-500 rounded-full animate-ping"></span>--}}
{{--                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Ассистент готов</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="space-y-6">--}}
{{--                        <div class="p-5 bg-blue-900 rounded-2xl">--}}
{{--                            <p class="text-[10px] font-bold text-blue-50 leading-relaxed uppercase">--}}
{{--                                Напишите тему документа, и я создам профессиональный текст за несколько секунд.--}}
{{--                            </p>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label class="block text-[9px] font-black text-gray-500 uppercase mb-2 tracking-widest">Тема запроса</label>--}}
{{--                            <textarea id="ai_prompt" rows="4"--}}
{{--                                      class="w-full p-4 border border-blue-900 rounded-2xl text-xs font-bold focus:border-red-600 outline-none bg-blue-50/30 focus:bg-white transition-all"--}}
{{--                                      placeholder="Напр: Смена реквизитов компании..."></textarea>--}}
{{--                        </div>--}}

{{--                        <button type="button" onclick="generateAI()" id="ai_btn"--}}
{{--                                class="w-full bg-white border border-blue-900 text-blue-900 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.25em] hover:bg-red-600 hover:border-red-600 hover:text-white transition-all group">--}}
{{--                            <i class="fas fa-wand-magic-sparkles me-2 group-hover:rotate-12 transition-transform"></i> Сгенерировать--}}
{{--                        </button>--}}

{{--                        <div id="ai_loader" class="hidden text-center py-6">--}}
{{--                            <div class="inline-block animate-spin rounded-full h-6 w-6 border-2 border-blue-900 border-t-red-600"></div>--}}
{{--                            <p class="text-[10px] font-black uppercase mt-3 tracking-widest text-red-600">Нейросеть пишет...</p>--}}
{{--                        </div>--}}

{{--                        <div class="pt-6 border-t border-gray-100">--}}
{{--                            <p class="text-[9px] font-black text-gray-400 uppercase mb-4 tracking-tighter">Популярные сценарии:</p>--}}
{{--                            <div class="grid grid-cols-1 gap-2">--}}
{{--                                <button onclick="useTemplate('Объяснительная записка об опоздании')" class="text-left text-[9px] font-black uppercase p-3 border border-blue-50 rounded-xl hover:border-blue-900 hover:bg-blue-50 transition-all text-blue-900">🚩 Опоздание</button>--}}
{{--                                <button onclick="useTemplate('Запрос на предоставление отпуска')" class="text-left text-[9px] font-black uppercase p-3 border border-blue-50 rounded-xl hover:border-blue-900 hover:bg-blue-50 transition-all text-blue-900">🏖 Заявление на отпуск</button>--}}
{{--                                <button onclick="useTemplate('Акт приема-передачи ключей')" class="text-left text-[9px] font-black uppercase p-3 border border-blue-50 rounded-xl hover:border-blue-900 hover:bg-blue-50 transition-all text-blue-900">🔑 Акт приема-передачи</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        function useTemplate(text) {--}}
{{--            document.getElementById('ai_prompt').value = text;--}}
{{--        }--}}

{{--        async function generateAI() {--}}
{{--            const prompt = document.getElementById('ai_prompt').value;--}}
{{--            const btn = document.getElementById('ai_btn');--}}
{{--            const loader = document.getElementById('ai_loader');--}}
{{--            const textarea = document.getElementById('doc_content');--}}

{{--            if(!prompt) return alert('О чем должен быть документ?');--}}

{{--            btn.classList.add('hidden');--}}
{{--            loader.classList.remove('hidden');--}}

{{--            try {--}}
{{--                const response = await fetch('/admin/ai-generate', {--}}
{{--                    method: 'POST',--}}
{{--                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },--}}
{{--                    body: JSON.stringify({ prompt: prompt, type: document.getElementById('doc_type').value })--}}
{{--                });--}}

{{--                const data = await response.json();--}}

{{--                textarea.value = "";--}}
{{--                let i = 0;--}}
{{--                function type() {--}}
{{--                    if (i < data.text.length) {--}}
{{--                        textarea.value += data.text.charAt(i);--}}
{{--                        i++;--}}
{{--                        setTimeout(type, 10);--}}
{{--                    }--}}
{{--                }--}}
{{--                type();--}}
{{--            } catch (e) {--}}
{{--                alert('Ошибка соединения с AI');--}}
{{--            } finally {--}}
{{--                btn.classList.remove('hidden');--}}
{{--                loader.classList.add('hidden');--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
