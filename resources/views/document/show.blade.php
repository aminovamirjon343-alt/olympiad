@extends('layouts.admin')

@section('content')
    {{-- Главный контейнер с принудительным светлым фоном --}}
    <div class="doc-page-v2 bg-[#f8fafc] min-h-[calc(100vh-64px)] py-6 px-4 md:px-8 relative font-inter">
        <div class="max-w-5xl mx-auto">

            {{-- Верхняя панель --}}
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200">
                <div class="flex items-center gap-4">
                    <a href="{{ route('documents.index') }}"
                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-black hover:bg-blue-600 hover:text-white shadow-sm transition-all">
                        <i class="bi bi-arrow-left text-sm"></i>
                    </a>
                    <h2 class="text-[12px] font-bold uppercase tracking-[0.2em] doc-title-adaptive">
                        Back
                    </h2>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('documents.edit', $document->id) }}"
                       class="px-3 py-1 rounded bg-black text-white text-[9px] font-bold uppercase tracking-widest hover:bg-blue-600 transition-all flex items-center justify-center">
                        Edit
                    </a>

                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Delete this document?')">
                        @csrf @method('DELETE')
                        <button class="px-3 py-1 rounded bg-[#dc2626] text-white text-[9px] font-bold uppercase tracking-widest hover:bg-red-700 transition-all border-none flex items-center justify-center">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Левая часть (Контент) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg border border-slate-200 p-6 md:p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-[9px] font-medium bg-blue-600 px-2.5 py-1 rounded text-white uppercase tracking-wider">
                                {{ $document->type ?? 'General' }}
                            </span>
                            <span class="text-[9px] font-[1000] bg-black text-white px-2.5 py-1 rounded uppercase tracking-[0.2em] !bg-black !text-white inline-block">
    #{{ $document->id }}
</span>
                            {{-- ДОБАВЛЕННЫЙ НОМЕР ДОКУМЕНТА --}}
                            <span class="text-[9px] font-black bg-blue-50 text-blue-700 px-2.5 py-1 rounded border border-blue-100 uppercase tracking-widest">
                                № {{ $document->number ?? 'Б/Н' }}
                            </span>
                        </div>

                        <h1 class="text-xl font-medium text-black mb-6 leading-tight uppercase tracking-tight">
                            {{ $document->title }}
                        </h1>

                        {{-- Исправленный блок описания --}}
                        <div class="text-[13px] text-black font-normal leading-relaxed border-t border-slate-100 pt-6">
                            <p class="whitespace-pre-line content-highlight break-words overflow-hidden w-full">
                                {{ $document->content ?? 'No detailed description available.' }}
                            </p>
                        </div>
                    </div>

                    {{-- Файл --}}
                    @if($document->file_path)
                        <div class="bg-white rounded-lg border border-slate-200 p-4 flex items-center justify-between group hover:border-blue-400 transition-all shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    <i class="bi bi-file-earmark-pdf-fill text-xl"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[11px] font-bold text-black uppercase tracking-wide truncate max-w-[200px] md:max-w-xs">
                                        {{ basename($document->file_path) }}
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-bold text-blue-600 uppercase">PDF Asset</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-[9px] text-black opacity-60 uppercase font-medium">Ready to View</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                               class="flex items-center gap-2 px-3 py-2 rounded-md bg-slate-100 text-black hover:bg-blue-600 hover:text-white transition-all border border-slate-200 shadow-sm">
                                <span class="text-[10px] font-black uppercase tracking-tighter">Смотреть</span>
                                <i class="bi bi-eye-fill text-sm"></i>
                            </a>
                        </div>
                    @endif

                    <a href="{{ route('documents.pdf', $document->id) }}"
                       class="h-10 px-4 bg-green-600 text-white rounded-xl font-semibold uppercase tracking-widest text-xs flex items-center justify-center hover:scale-[1.01] active:scale-95 transition shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        СКАЧАТЬ PDF
                    </a>

                    {{-- Комментарии --}}
                    <div class="space-y-4">
                        <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 flex items-center gap-2">
                            <i class="bi bi-chat-left-text-fill text-orange-500"></i> SYSTEM NOTES
                        </h3>

                        <form action="{{ route('comments.store') }}" method="POST" class="relative group">
                            @csrf
                            <input type="hidden" name="document_id" value="{{ $document->id }}">
                            <textarea name="comment" rows="2"
                                      class="w-full bg-white border border-slate-200 rounded-2xl p-4 pr-12 text-[12px] text-black focus:border-orange-400 focus:ring-4 focus:ring-orange-50 outline-none transition-all placeholder:text-slate-400 shadow-sm"
                                      placeholder="Leave a comment..."></textarea>
                            <button class="absolute bottom-4 right-4 text-orange-500 hover:text-orange-600 hover:scale-110 transition-all">
                                <i class="bi bi-send-fill text-xl"></i>
                            </button>
                        </form>

                        <div class="space-y-3 mt-4">
                            @forelse($comments ?? [] as $comment)
                                {{-- Улучшенный стиль Dashboard: градиент + тень --}}
                                <div class="p-4 rounded-2xl shadow-md border border-orange-400/20"
                                     style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%) !important;">

                                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-white/20">
                                        {{-- ИСПРАВЛЕНО: Добавлен ?-> для защиты от null user --}}
                                        <span class="text-[10px] font-black uppercase tracking-widest text-white">
                                            {{ $comment->user?->name ?? 'System' }}
                                        </span>
                                        <span class="text-[9px] text-white/90 font-bold bg-black/10 px-2 py-0.5 rounded-full">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <p class="text-[12px] text-white font-medium leading-relaxed drop-shadow-sm">
                                        {{ $comment->comment }}
                                    </p>
                                </div>
                            @empty
                                <div class="text-center py-8 border-2 border-dashed border-slate-100 rounded-2xl bg-slate-50/50">
                                    <i class="bi bi-chat-dots text-slate-300 text-2xl mb-2 block"></i>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">No notes yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Правая панель (Метаданные) --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
                        <p class="text-[10px] font-medium text-black uppercase mb-6 tracking-[0.2em] border-b border-slate-50 pb-2">Details</p>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 uppercase text-sm font-medium">Signature</span>
                                @php
                                    // ИСПРАВЛЕНО: Безопасное получение первой подписи
                                    $signatureEntry = $document->signatures?->first();
                                    $isSigned = $signatureEntry && !empty($signatureEntry->signature);
                                @endphp

                                @if($isSigned)
                                    <div class="px-2 py-1 rounded border border-green-600 text-green-600 flex items-center gap-1 bg-green-50">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span class="font-bold uppercase text-[10px]">Signed</span>
                                    </div>
                                @else
                                    <div class="px-2 py-1 rounded border border-red-600 text-red-600 flex items-center gap-1 bg-red-50">
                                        <i class="bi bi-clock"></i>
                                        <span class="font-bold uppercase text-[10px]">Not Signed</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-black opacity-60 uppercase tracking-wider">Status</span>
                                <span class="text-[9px] font-medium px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100 uppercase">
                                    {{ $document->status ?? 'Draft' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-black opacity-60 uppercase tracking-wider">Owner</span>
                                {{-- ИСПРАВЛЕНО: Добавлен ?-> для защиты от null user --}}
                                <span class="text-[10px] font-medium text-black">{{ $document->user?->name ?? 'Unassigned' }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-black opacity-60 uppercase tracking-wider">Deadline</span>
                                <span class="text-[10px] font-medium text-red-600 italic">
                                    {{ $document->deadline ? \Carbon\Carbon::parse($document->deadline)->format('d.m.Y') : '—' }}
                                </span>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-50 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-[9px] text-black opacity-40 uppercase">Created At</span>
                                    <span class="text-[9px] text-black">{{ $document->created_at?->format('d M Y') ?? '—' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-[9px] text-black opacity-40 uppercase">Last Update</span>
                                    <span class="text-[9px] text-black">{{ $document->updated_at?->diffForHumans() ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-black rounded-lg flex items-center gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></div>
                        <span class="text-[9px] font-medium text-white uppercase tracking-[0.2em]">Live Document</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .doc-page-v2 a.bg-slate-100 { color: #000000 !important; }
        .doc-page-v2 a.bg-slate-100:hover { color: #ffffff !important; background-color: #2563eb !important; }
        .doc-page-v2 { background-color: #f8fafc !important; }
        .doc-page-v2 .bg-white { background-color: #ffffff !important; border: 1px solid #e2e8f0 !important; }
        .doc-id-highlight { background-color: #f1f5f9 !important; color: #000 !important; font-weight: 800 !important; }
        .comment-highlight { background-color: #fef08a !important; color: #000 !important; padding: 12px; border-radius: 10px; }
        .no-notes-highlight { background-color: #fef08a !important; color: #000 !important; padding: 16px; border-radius: 10px; }
        .content-highlight { background-color: #fef08a !important; color: #000 !important; padding: 6px 10px; border-radius: 6px; display: inline-block; }
        .doc-page-v2 h1, .doc-page-v2 h2, .doc-page-v2 h3, .doc-page-v2 p, .doc-page-v2 span, .doc-page-v2 div, .doc-page-v2 label { color: #000 !important; }
        .text-red-600 { color: #dc2626 !important; }
        .text-green-600 { color: #16a34a !important; }
        .doc-page-v2 a.text-blue-600 { color: #2563eb !important; }
        .font-inter { font-family: 'Inter', sans-serif; }
    </style>
@endpush
