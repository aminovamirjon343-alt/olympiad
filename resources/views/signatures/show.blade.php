@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 min-h-screen">
        <style>
            .view-sig-page {
                --primary-color: var(--primary, #6366f1);
            }

            .theme-text { color: var(--text-main, currentColor); }

            .cert-card {
                background: #ffffff !important;
                border-radius: 3rem;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
                overflow: hidden;
            }

            .cert-card h2, .cert-card p:not(.muted-text), .cert-card span:not(.badge) {
                color: #1e293b !important;
            }

            .cert-card label {
                color: var(--primary-color) !important;
                opacity: 0.8;
            }

            .cert-card .muted-text {
                color: #64748b !important;
            }

            .sig-display-area {
                background-color: #f8fafc !important;
                border: 1px solid #f1f5f9;
            }

            .btn-primary-system {
                background-color: var(--primary-color) !important;
                color: #ffffff !important;
            }

            /* Стиль для блока файла */
            .file-attachment {
                border: 2px dashed #e2e8f0;
                transition: all 0.3s ease;
            }
            .file-attachment:hover {
                border-color: var(--primary-color);
                background-color: #f5f7ff !important;
            }
        </style>

        <div class="view-sig-page">
            {{-- Навигация --}}
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('signatures.index') }}" class="font-bold text-[11px] uppercase tracking-[0.2em] transition flex items-center gap-2" style="color: var(--primary-color);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Назад к списку
                </a>

                <div class="flex gap-3">
                    <a href="{{ route('signatures.edit', $signature->id) }}" class="bg-amber-50 text-amber-600 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-amber-500 hover:text-white transition shadow-sm border border-amber-100">
                        Редактировать
                    </a>
                </div>
            </div>

            {{-- Основная карточка-сертификат --}}
            <div class="max-w-3xl mx-auto cert-card relative">

                {{-- Печать на фоне --}}
                <div class="absolute top-10 right-10 opacity-[0.04] pointer-events-none">
                    <svg class="w-64 h-64 text-indigo-900" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z" clip-rule="evenodd"/>
                    </svg>
                </div>

                <div class="p-12 md:p-16 relative">

                    {{-- Статус и Заголовок --}}
                    <div class="flex flex-col items-center text-center mb-12">
                        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-emerald-50 border border-emerald-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h2 class="text-2xl font-black uppercase tracking-tighter">Подтверждение подписи</h2>
                        <p class="muted-text text-sm font-medium mt-1">Электронный цифровой сертификат системы</p>
                    </div>

                    {{-- Сетка данных --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-8">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest">Документ</label>
                            <p class="text-lg font-bold leading-tight">
                                {{ $signature->document->title ?? '—' }}
                            </p>
                            <p class="text-[10px] font-mono muted-text">UUID: doc_{{ $signature->document_id }}</p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest">Сотрудник</label>
                            <p class="text-lg font-bold">
                                {{ $signature->user->name ?? '—' }}
                            </p>
                            <p class="text-xs font-medium muted-text italic">{{ $signature->user->email ?? '' }}</p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest">Дата и время</label>
                            <p class="font-bold">
                                {{ $signature->signed_at ? \Carbon\Carbon::parse($signature->signed_at)->format('d.m.Y — H:i:s') : '—' }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest">Статус верификации</label>
                            <div class="flex items-center gap-2 text-emerald-600 font-black text-sm uppercase">
                                <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                ПОДЛИННО
                            </div>
                        </div>
                    </div>

                    {{-- НОВЫЙ БЛОК: Прикрепленный файл --}}
                    <div class="mb-12">
                        <label class="text-[10px] font-black uppercase tracking-widest mb-3 block">Оригинал файла</label>
                        @if($signature->document && $signature->document->file_path)
                            <div class="file-attachment p-4 rounded-2xl flex items-center justify-between bg-slate-50/50">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-indigo-500 shadow-sm border border-gray-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-bold truncate max-w-[200px] md:max-w-xs">{{ basename($signature->document->file_path) }}</p>
                                        <p class="text-[10px] muted-text uppercase font-bold">Нажмите, чтобы просмотреть документ</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $signature->document->file_path) }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold text-[10px] uppercase tracking-wider hover:bg-indigo-700 transition">
                                    Открыть PDF
                                </a>
                            </div>
                        @else
                            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 text-center">
                                <p class="text-xs italic text-gray-400 font-medium">Файл документа не найден</p>
                            </div>
                        @endif
                    </div>

                    {{-- Визуальный блок подписи --}}
                    <div class="sig-display-area rounded-[2rem] p-10 flex flex-col items-center">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Цифровой оттиск</label>

                        <div class="relative group bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <img src="{{ $signature->signature }}" class="max-w-[320px] h-auto object-contain filter contrast-125" alt="Signature">
                        </div>

                        <p class="mt-8 text-[9px] muted-text font-bold text-center leading-relaxed max-w-sm uppercase tracking-wider">
                            Данная подпись является юридическим подтверждением согласия пользователя и зафиксирована в реестре системы.
                        </p>
                    </div>
                </div>

                {{-- Футер карточки --}}
                <div class="btn-primary-system py-5 px-12 flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">
                    <span class="opacity-80">Secure Signature v2.0</span>
                    <span>Digital ID: #{{ str_pad($signature->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
