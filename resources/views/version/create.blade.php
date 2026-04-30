@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6 min-h-screen">
        <style>
            @font-face {
                font-family: 'Univers Condensed Bold';
                src: local('Univers Condensed Bold'), local('Univers-CondensedBold');
            }

            .versions-page {
                --primary-color: var(--primary, #6366f1);
                font-family: 'Univers Condensed Bold', 'Arial Narrow', sans-serif !important;
            }

            .theme-heading { color: var(--text-main, currentColor); }

            /* Супер-компактная карточка */
            .form-card {
                background: #ffffff !important;
                border-radius: 1rem;
                border: 1px solid rgba(0, 0, 0, 0.08);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            /* Компактные поля */
            .input-field {
                background-color: #f8fafc !important;
                border: 1px solid #e2e8f0 !important;
                color: #1e293b !important;
                font-weight: 900;
                font-size: 0.8rem; /* Уменьшили шрифт */
                padding: 0.75rem 1rem !important; /* Уменьшили отступы */
            }

            .input-field:focus {
                border-color: var(--primary-color) !important;
                background-color: #ffffff !important;
            }

            /* Мелкие подписи */
            .field-label {
                font-size: 0.65rem; /* Очень маленький */
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #94a3b8;
                margin-left: 0.25rem;
            }

            /* Компактная кнопка */
            .btn-submit {
                background-color: #0f172a !important;
                color: #ffffff !important;
                font-size: 0.75rem; /* Уменьшили шрифт */
                font-weight: 900;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                padding: 0.75rem 1.5rem !important;
                border-radius: 0.75rem;
                transition: all 0.2s ease;
            }

            .btn-submit:hover {
                background-color: #000000 !important;
                transform: translateY(-1px);
            }

            /* Сжатая инфо-плашка */
            .info-box {
                background-color: #fff1f2 !important;
                padding: 0.75rem 1rem !important;
                border-radius: 0.75rem;
            }
        </style>

        <div class="versions-page">
            {{-- Компактная шапка --}}
            <div class="mb-6">
                <a href="{{ route('versions.index') }}" class="text-[9px] font-black uppercase tracking-widest transition flex items-center gap-1.5 mb-2" style="color: var(--primary-color);">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M15 19l-7-7 7-7"/></svg>
                    Назад
                </a>
                <h1 class="text-2xl font-black tracking-tighter theme-heading uppercase">Новая ревизия</h1>
                <p class="text-[9px] font-black uppercase tracking-widest opacity-40 theme-heading">Upload system v2.0</p>
            </div>

            <div class="max-w-xl">
                <form action="{{ route('versions.store') }}" method="POST" enctype="multipart/form-data" class="form-card p-6 space-y-4">
                    @csrf

                    {{-- Выбор документа --}}
                    <div class="space-y-1.5">
                        <label for="document_id" class="field-label">Документ</label>
                        <select name="document_id" id="document_id" class="w-full rounded-lg input-field outline-none cursor-pointer">
                            @foreach($documents as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Поле загрузки файла --}}
                    <div class="space-y-1.5">
                        <label for="file_path" class="field-label">Файл версии (PDF/DOCX)</label>
                        <input type="file" name="file_path" id="file_path" required
                               class="w-full rounded-lg input-field file:mr-3 file:py-1 file:px-2 file:rounded file:border-0 file:text-[9px] file:font-black file:uppercase file:bg-gray-800 file:text-white cursor-pointer">
                    </div>

                    {{-- Инфо-плашка (минимализм) --}}
                    <div class="info-box flex items-center gap-3">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span class="text-[9px] font-black text-red-800 uppercase tracking-tight">Авто-инкремент версии включен.</span>
                    </div>

                    {{-- Кнопка --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full btn-submit flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Сохранить ревизию
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
