@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <div class="container mx-auto px-4 py-6 min-h-screen">
        <style>
            .view-sig-page {
                --primary-color: #6366f1;
                font-family: 'Inter', sans-serif !important;
            }

            .view-sig-page *, .view-sig-page label, .view-sig-page p, .view-sig-page span {
                font-family: 'Inter', sans-serif !important;
            }

            .form-card {
                background: #ffffff !important;
                border-radius: 1.5rem;
                border: 1px solid rgba(0, 0, 0, 0.08);
                box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            }

            .dark .form-card {
                background: #1e293b !important;
                border-color: rgba(255,255,255,0.1);
            }

            .label-micro {
                font-size: 10px !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.1em !important;
                color: #94a3b8;
            }

            .data-text {
                font-size: 15px !important;
                font-weight: 700;
                color: #1e293b;
            }
            .dark .data-text { color: #f8fafc; }

            .description-box {
                font-size: 14px !important;
                font-weight: 600;
                color: #64748b;
                white-space: normal !important;
                word-break: break-word;
            }

            .badge-status {
                font-size: 10px;
                font-weight: 900;
                padding: 4px 12px;
                border-radius: 8px;
                text-transform: uppercase;
            }

            .pdf-container {
                height: 900px; /* Увеличил высоту для удобства чтения */
                border-radius: 1.5rem;
                overflow: hidden;
                border: 1px solid rgba(0,0,0,0.1);
            }
        </style>

        <div class="view-sig-page">
            {{-- Шапка --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('signatures.index') }}" class="label-micro text-indigo-500 flex items-center gap-2 mb-2 hover:text-indigo-700 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                        Реестр документов
                    </a>
                    <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">Карточка документа</h1>
                </div>
            </div>

            <div class="flex flex-col gap-6">

                {{-- ВЕРХНЯЯ КАРТОЧКА (ИНФОРМАЦИЯ) --}}
                <div class="form-card p-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12">

                        {{-- Статус и ID --}}
                        <div class="space-y-6">
                            <div class="flex items-center justify-between border-b pb-4 border-slate-50 dark:border-slate-800">
                                <span class="label-micro">Статус записи</span>
                                @if($signature->signed_at)
                                    <span class="badge-status bg-emerald-500/10 text-emerald-600">Подписано</span>
                                @else
                                    <span class="badge-status bg-rose-500/10 text-rose-600">Ожидание</span>
                                @endif
                            </div>

                            <div>
                                <label class="label-micro block mb-1">ID Записи / Номер</label>
                                <div class="data-text text-xl">#{{ str_pad($signature->id, 6, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>

                        {{-- Описание (занимает 2 колонки для красоты) --}}
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="label-micro block mb-1">Описание документа</label>
                                <div class="description-box leading-relaxed">
                                    {{ $signature->document->content ?? 'Описание отсутствует' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="label-micro block mb-1">Название</label>
                                    <div class="data-text">{{ $signature->document->title ?? '—' }}</div>
                                </div>
                                <div>
                                    <label class="label-micro block mb-1">Тип документа</label>
                                    <div class="data-text">{{ $signature->document->type ?? '—' }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Действия и Исполнитель --}}
                        <div class="flex flex-col justify-between">
                            <div class="text-right">
                                <label class="label-micro block mb-1">Исполнитель</label>
                                <div class="data-text">{{ $signature->user->name ?? 'Не назначен' }}</div>
                                <div class="text-[11px] text-slate-400 font-medium">{{ $signature->created_at->format('d.m.Y') }}</div>
                            </div>

                            <div class="mt-4">
                                @if(!$signature->signed_at)
                                    <a href="{{ route('signatures.create', ['document_id' => $signature->document_id]) }}"
                                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl text-[11px] font-black uppercase tracking-widest flex items-center justify-center gap-2 transition-all shadow-lg shadow-indigo-500/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                        </svg>
                                        Подписать
                                    </a>
                                @else
                                    <div class="sig-display-area flex items-center justify-center py-2 px-4 rounded-xl">
                                        <img src="{{ $signature->signature }}" class="max-h-12 object-contain dark:invert" alt="Sig">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- НИЖНЯЯ КАРТОЧКА (PDF ДОКУМЕНТ) --}}
                <div class="form-card p-6">
                    <div class="flex items-center justify-between mb-6">
                        <span class="label-micro">Предпросмотр документа</span>
                        <div class="flex gap-3">
                            @if($signature->document && $signature->document->file_path)
                                <a href="{{ asset('storage/' . $signature->document->file_path) }}"
                                   download="{{ $signature->document->title ?? 'document' }}.pdf"
                                   class="bg-white border border-slate-200 text-slate-700 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all flex items-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Скачать PDF
                                </a>
                            @endif
                            @if($signature->signed_at)
                                <a href="{{ route('signatures.edit', $signature->id) }}" class="bg-amber-500/10 text-amber-600 border border-amber-500/20 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-500 hover:text-white transition-all">
                                    Обновить оттиск
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="pdf-container bg-slate-50">
                        @if($signature->document && $signature->document->file_path)
                            <iframe src="{{ asset('storage/' . $signature->document->file_path) }}#toolbar=0" class="w-full h-full" frameborder="0"></iframe>
                        @else
                            <div class="flex items-center justify-center h-full text-slate-300 label-micro">Файл не прикреплен</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
