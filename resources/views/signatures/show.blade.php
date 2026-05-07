{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8 min-h-screen">--}}
{{--        <style>--}}
{{--            .view-sig-page {--}}
{{--                --primary-color: var(--primary, #6366f1);--}}
{{--            }--}}

{{--            .theme-text { color: var(--text-main, currentColor); }--}}

{{--            .cert-card {--}}
{{--                background: #ffffff !important;--}}
{{--                border-radius: 3rem;--}}
{{--                border: 1px solid rgba(0, 0, 0, 0.05);--}}
{{--                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);--}}
{{--                overflow: hidden;--}}
{{--            }--}}

{{--            .cert-card h2, .cert-card p:not(.muted-text), .cert-card span:not(.badge) {--}}
{{--                color: #1e293b !important;--}}
{{--            }--}}

{{--            .cert-card label {--}}
{{--                color: var(--primary-color) !important;--}}
{{--                opacity: 0.8;--}}
{{--            }--}}

{{--            .cert-card .muted-text {--}}
{{--                color: #64748b !important;--}}
{{--            }--}}

{{--            .sig-display-area {--}}
{{--                background-color: #f8fafc !important;--}}
{{--                border: 1px solid #f1f5f9;--}}
{{--            }--}}

{{--            .btn-primary-system {--}}
{{--                background-color: var(--primary-color) !important;--}}
{{--                color: #ffffff !important;--}}
{{--            }--}}

{{--            /* Стиль для блока файла */--}}
{{--            .file-attachment {--}}
{{--                border: 2px dashed #e2e8f0;--}}
{{--                transition: all 0.3s ease;--}}
{{--            }--}}
{{--            .file-attachment:hover {--}}
{{--                border-color: var(--primary-color);--}}
{{--                background-color: #f5f7ff !important;--}}
{{--            }--}}
{{--        </style>--}}

{{--        <div class="view-sig-page">--}}
{{--            --}}{{-- Навигация --}}
{{--            <div class="mb-8 flex items-center justify-between">--}}
{{--                <a href="{{ route('signatures.index') }}" class="font-bold text-[11px] uppercase tracking-[0.2em] transition flex items-center gap-2" style="color: var(--primary-color);">--}}
{{--                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>--}}
{{--                    Назад к списку--}}
{{--                </a>--}}

{{--                <div class="flex gap-3">--}}
{{--                    <a href="{{ route('signatures.edit', $signature->id) }}" class="bg-amber-50 text-amber-600 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-amber-500 hover:text-white transition shadow-sm border border-amber-100">--}}
{{--                        Редактировать--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            --}}{{-- Основная карточка-сертификат --}}
{{--            <div class="max-w-3xl mx-auto cert-card relative">--}}

{{--                --}}{{-- Печать на фоне --}}
{{--                <div class="absolute top-10 right-10 opacity-[0.04] pointer-events-none">--}}
{{--                    <svg class="w-64 h-64 text-indigo-900" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z" clip-rule="evenodd"/>--}}
{{--                    </svg>--}}
{{--                </div>--}}

{{--                <div class="p-12 md:p-16 relative">--}}

{{--                    --}}{{-- Статус и Заголовок --}}
{{--                    <div class="flex flex-col items-center text-center mb-12">--}}
{{--                        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-emerald-50 border border-emerald-200">--}}
{{--                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>--}}
{{--                        </div>--}}
{{--                        <h2 class="text-2xl font-black uppercase tracking-tighter">Подтверждение подписи</h2>--}}
{{--                        <p class="muted-text text-sm font-medium mt-1">Электронный цифровой сертификат системы</p>--}}
{{--                    </div>--}}

{{--                    --}}{{-- Сетка данных --}}
{{--                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-8">--}}
{{--                        <div class="space-y-1">--}}
{{--                            <label class="text-[10px] font-black uppercase tracking-widest">Документ</label>--}}
{{--                            <p class="text-lg font-bold leading-tight">--}}
{{--                                {{ $signature->document->title ?? '—' }}--}}
{{--                            </p>--}}
{{--                            <p class="text-[10px] font-mono muted-text">UUID: doc_{{ $signature->document_id }}</p>--}}
{{--                        </div>--}}

{{--                        <div class="space-y-1">--}}
{{--                            <label class="text-[10px] font-black uppercase tracking-widest">Сотрудник</label>--}}
{{--                            <p class="text-lg font-bold">--}}
{{--                                {{ $signature->user->name ?? '—' }}--}}
{{--                            </p>--}}
{{--                            <p class="text-xs font-medium muted-text italic">{{ $signature->user->email ?? '' }}</p>--}}
{{--                        </div>--}}

{{--                        <div class="space-y-1">--}}
{{--                            <label class="text-[10px] font-black uppercase tracking-widest">Дата и время</label>--}}
{{--                            <p class="font-bold">--}}
{{--                                {{ $signature->signed_at ? \Carbon\Carbon::parse($signature->signed_at)->format('d.m.Y — H:i:s') : '—' }}--}}
{{--                            </p>--}}
{{--                        </div>--}}

{{--                        <div class="space-y-1">--}}
{{--                            <label class="text-[10px] font-black uppercase tracking-widest">Статус верификации</label>--}}
{{--                            <div class="flex items-center gap-2 text-emerald-600 font-black text-sm uppercase">--}}
{{--                                <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>--}}
{{--                                ПОДЛИННО--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    --}}{{-- НОВЫЙ БЛОК: Прикрепленный файл --}}
{{--                    <div class="mb-12">--}}
{{--                        <label class="text-[10px] font-black uppercase tracking-widest mb-3 block">Оригинал файла</label>--}}
{{--                        @if($signature->document && $signature->document->file_path)--}}
{{--                            <div class="file-attachment p-4 rounded-2xl flex items-center justify-between bg-slate-50/50">--}}
{{--                                <div class="flex items-center gap-4">--}}
{{--                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-indigo-500 shadow-sm border border-gray-100">--}}
{{--                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>--}}
{{--                                    </div>--}}
{{--                                    <div class="overflow-hidden">--}}
{{--                                        <p class="text-sm font-bold truncate max-w-[200px] md:max-w-xs">{{ basename($signature->document->file_path) }}</p>--}}
{{--                                        <p class="text-[10px] muted-text uppercase font-bold">Нажмите, чтобы просмотреть документ</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <a href="{{ asset('storage/' . $signature->document->file_path) }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold text-[10px] uppercase tracking-wider hover:bg-indigo-700 transition">--}}
{{--                                    Открыть PDF--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 text-center">--}}
{{--                                <p class="text-xs italic text-gray-400 font-medium">Файл документа не найден</p>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}

{{--                    --}}{{-- Визуальный блок подписи --}}
{{--                    <div class="sig-display-area rounded-[2rem] p-10 flex flex-col items-center">--}}
{{--                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Цифровой оттиск</label>--}}

{{--                        <div class="relative group bg-white p-4 rounded-xl shadow-sm border border-gray-100">--}}
{{--                            <img src="{{ $signature->signature }}" class="max-w-[320px] h-auto object-contain filter contrast-125" alt="Signature">--}}
{{--                        </div>--}}

{{--                        <p class="mt-8 text-[9px] muted-text font-bold text-center leading-relaxed max-w-sm uppercase tracking-wider">--}}
{{--                            Данная подпись является юридическим подтверждением согласия пользователя и зафиксирована в реестре системы.--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{-- Футер карточки --}}
{{--                <div class="btn-primary-system py-5 px-12 flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">--}}
{{--                    <span class="opacity-80">Secure Signature v2.0</span>--}}
{{--                    <span>Digital ID: #{{ str_pad($signature->id, 6, '0', STR_PAD_LEFT) }}</span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}


@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 min-h-screen">
        <style>
            .view-sig-page { --primary-color: var(--primary, #6366f1); }
            .cert-card {
                background: #ffffff !important;
                border-radius: 3rem;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
                overflow: hidden;
            }
            .pdf-preview-box {
                height: 650px;
                border-radius: 2rem;
                overflow: hidden;
                border: 1px solid #e2e8f0;
                background: #f8fafc;
            }
            .btn-sign {
                background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
                box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
            }
        </style>

        <div class="view-sig-page">
            {{-- Навигация --}}
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('signatures.index') }}" class="font-bold text-[11px] uppercase tracking-[0.2em] transition flex items-center gap-2" style="color: var(--primary-color);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Назад к списку
                </a>

                @if($signature->signed_at)
                    <div class="flex gap-3">
                        <a href="{{ route('signatures.edit', $signature->id) }}" class="bg-amber-50 text-amber-600 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-amber-500 hover:text-white transition shadow-sm border border-amber-100">
                            Изменить подпись
                        </a>
                        <span class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl font-bold text-[10px] uppercase tracking-widest border border-emerald-100 flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            Документ подписан
                        </span>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- ЛЕВАЯ КОЛОНКА: Статус и Детали --}}
                <div class="lg:col-span-5">
                    <div class="cert-card relative h-full">
                        <div class="p-10">
                            <div class="text-center mb-10">
                                @if($signature->signed_at)
                                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-200 shadow-sm">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>
                                    <h2 class="text-xl font-black uppercase tracking-tight text-slate-800">Сертификат верифицирован</h2>
                                @else
                                    <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-amber-200 shadow-sm">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <h2 class="text-xl font-black uppercase tracking-tight text-slate-800">Ожидает подписи</h2>
                                @endif
                            </div>

                            <div class="space-y-8">
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500 block mb-1">Документ</label>
                                    <p class="font-bold text-lg text-slate-700 leading-tight">{{ $signature->document->title ?? 'Без названия' }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500 block mb-1">Отправитель</label>
                                        <p class="font-bold text-slate-700 text-sm">{{ $signature->document->user->name ?? 'Администратор' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500 block mb-1">Дата назначения</label>
                                        <p class="font-bold text-slate-700 text-sm">{{ $signature->created_at->format('d.m.Y') }}</p>
                                    </div>
                                </div>

                                {{-- Блок самой подписи --}}
                                @if($signature->signed_at)
                                    <div class="pt-8 border-t border-dashed border-slate-200">
                                        <label class="text-[10px] font-black uppercase tracking-widest text-indigo-500 block text-center mb-4">Ваш цифровой оттиск</label>
                                        <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 flex justify-center shadow-inner">
                                            {{-- Отображаем сохраненную base64 подпись --}}
                                            <img src="{{ $signature->signature }}" class="max-h-28 object-contain contrast-125" alt="Signature">
                                        </div>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase text-center mt-4 tracking-widest">
                                            Подписано: {{ \Carbon\Carbon::parse($signature->signed_at)->format('d.m.Y H:i') }}
                                        </p>
                                    </div>
                                @else
                                    <div class="pt-6">
                                        {{-- Ссылка на создание подписи для этого документа --}}
                                        <a href="{{ route('signatures.create', ['document_id' => $signature->document_id]) }}" class="btn-sign w-full text-white py-5 rounded-2xl font-black uppercase tracking-[0.15em] flex items-center justify-center gap-3 transition hover:scale-[1.02] active:scale-[0.98]">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            Подписать документ
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="absolute bottom-0 left-0 w-full bg-indigo-600 py-4 px-10 text-[9px] font-bold text-white uppercase tracking-widest flex justify-between">
                            <span>Digital ID: #{{ str_pad($signature->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span>System Security Verified</span>
                        </div>
                    </div>
                </div>

                {{-- ПРАВАЯ КОЛОНКА: Предпросмотр PDF --}}
                <div class="lg:col-span-7">
                    <div class="bg-white p-6 rounded-[3rem] border border-slate-100 shadow-xl h-full">
                        <div class="flex items-center justify-between mb-6 px-4">
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-3">
                                <span class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </span>
                                Просмотр документа
                            </h3>
                            @if($signature->document && $signature->document->file_path)
                                <a href="{{ asset('storage/' . $signature->document->file_path) }}" download class="bg-slate-900 text-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-indigo-600 transition">
                                    Скачать PDF
                                </a>
                            @endif
                        </div>

                        <div class="pdf-preview-box shadow-inner">
                            @if($signature->document && $signature->document->file_path)
                                {{-- Вставляем PDF через iframe для предпросмотра --}}
                                <iframe src="{{ asset('storage/' . $signature->document->file_path) }}#toolbar=0" class="w-full h-full" frameborder="0"></iframe>
                            @else
                                <div class="flex flex-col items-center justify-center h-full bg-slate-50">
                                    <svg class="w-12 h-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-slate-400 font-bold uppercase text-[10px]">Файл не найден</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
