@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#0f172a] flex flex-col items-center justify-center py-12 px-6 font-inter tracking-tight">

        <style>
            /* Чуть больше ширины для солидности (было 520px) */
            .versions-container {
                width: 100%;
                max-width: 620px;
            }

            .glass-form-card {
                background: #ffffff;
                border-radius: 1.8rem;
                box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.8);
                border: 1px solid rgba(255, 255, 255, 0.1);
                overflow: hidden;
            }

            /* Инпуты: чуть больше паддинга для масштабности */
            .custom-input {
                background-color: #f8fafc !important;
                border: 1px solid #e2e8f0 !important;
                color: #000000 !important;
                font-weight: 700;
                font-size: 0.9rem;
                padding: 0.9rem 1.1rem !important;
                transition: all 0.2s ease;
            }

            .custom-input:focus {
                border-color: #3b82f6 !important;
                background-color: #ffffff !important;
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
            }

            .field-label {
                font-size: 0.68rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.12em;
                color: #94a3b8;
                margin-bottom: 0.6rem;
                display: block;
            }

            .btn-dark-modern {
                background: #0f172a;
                color: #ffffff !important;
                font-size: 10px; /* Сделал чуть-чуть крупнее для баланса */
                font-weight: 900;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                padding: 0.7rem 1.5rem !important;
                border-radius: 0.6rem;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.6rem;
            }

            .btn-dark-modern:hover {
                background: #3b82f6;
                transform: translateY(-1px);
                box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
            }
        </style>

        <div class="versions-container">

            <!-- Заголовок стал шире вместе с формой -->
            <div class="mb-8 flex items-end justify-between px-2">
                <div>
                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                        РЕВИЗИЯ
                    </h1>
                    <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-slate-500 mt-1">Version Control & Deployment</p>
                </div>

                <a href="{{ route('versions.index') }}" class="text-[10px] font-black uppercase text-slate-400 hover:text-amber-500 transition-colors flex items-center gap-1.5 pb-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5"><path d="M15 19l-7-7 7-7"/></svg>
                    Вернуться
                </a>
            </div>

            <div class="glass-form-card">
                <!-- Увеличили p-8 до p-10 -->
                <form action="{{ route('versions.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-7">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label for="document_id" class="field-label">Основной документ</label>
                            <select name="document_id" id="document_id" class="w-full rounded-xl custom-input outline-none cursor-pointer appearance-none">
                                @foreach($documents as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="file_path" class="field-label">Новая редакция файла</label>
                            <input type="file" name="file_path" id="file_path" required
                                   class="w-full rounded-xl custom-input file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[9px] file:font-black file:uppercase file:bg-slate-900 file:text-white cursor-pointer hover:file:bg-blue-600 file:transition-colors">
                        </div>
                    </div>

                    <!-- Нижняя панель -->
                    <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                        </div>

                        <button type="submit" class="btn-dark-modern">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Зафиксировать
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center text-[9px] font-bold text-slate-700 uppercase mt-8 tracking-[0.4em] opacity-40">
                Official Revision Protocol — 2026
            </p>
        </div>
    </div>
@endsection
