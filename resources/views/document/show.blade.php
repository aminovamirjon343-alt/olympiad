@extends('layouts.admin')

@section('content')
    @if(session('error') || $errors->any())
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="fixed top-20 left-1/2 -translate-x-[70%] z-[9999] w-full max-w-md px-4">

            <div class="bg-white border-l-4 border-red-500 shadow-2xl rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-exclamation-octagon-fill text-red-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-red-600 mb-1" data-i18n="errorTitle">Ошибка доступа</h4>
                    <p class="text-[12px] font-bold text-black leading-tight" id="session-error-text" data-error-raw="{{ session('error') ?? $errors->first() }}">
                        {{ session('error') ?? $errors->first() }}
                    </p>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-black transition-colors">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="doc-page-v2 bg-[#f8fafc] min-h-[calc(100vh-64px)] py-6 px-4 md:px-8 relative font-inter">
        <div class="max-w-5xl mx-auto">

           <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200">
                <div class="flex items-center gap-4">
                    <a href="{{ route('documents.index') }}"
                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-black hover:bg-blue-600 hover:text-white shadow-sm transition-all">
                        <i class="bi bi-arrow-left text-sm"></i>
                    </a>
                    <h2 class="text-[12px] font-bold uppercase tracking-[0.2em] doc-title-adaptive" data-i18n="back">
                        Назад
                    </h2>
                </div>

                <div class="flex gap-2 items-center">
                   <div x-data="{ open: false }" class="relative inline-block">
                        <button @click="open = true" type="button" class="p-1.5 rounded bg-red-700 text-white text-[11px] border border-red-900 flex items-center justify-center transition-all hover:bg-red-800 shadow-sm">
                            <i class="bi bi-trash3"></i>
                        </button>

                        <div x-show="open"
                             class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-end="opacity-0"
                             x-cloak>

                            <div @click.away="open = false"
                                 class="bg-white border border-gray-200 rounded-xl p-5 max-w-sm w-full shadow-2xl text-left"
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:leave="transition ease-in duration-200 transform"
                                 x-transition:leave-end="opacity-0 scale-95">

                                <h3 class="text-black font-bold text-[16px] mb-2 flex items-center gap-2">
                                    <i class="bi bi-exclamation-triangle-fill text-red-600"></i>
                                    <span data-i18n="delete_confirm_title">Удалить ?</span>
                                </h3>

                                <p class="text-gray-600 text-[13px] mb-5 leading-relaxed" data-i18n="delete_confirm_desc">
                                    Вы уверены, что хотите удалить этот документ? Это действие невозможно будет отменить.
                                </p>

                                <div class="flex justify-end gap-2">
                                    <button @click="open = false" type="button"
                                            class="px-4 py-2 text-[12px] font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors border border-gray-300"
                                            data-i18n="cancel">
                                        Отмена
                                    </button>

                                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 text-[12px] font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors border border-red-700 flex items-center justify-center"
                                                data-i18n="delete_btn">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('documents.edit', $document->id) }}"
                       class="p-1.5 rounded bg-black text-white text-[11px] border border-stone-900 flex items-center justify-center hover:bg-blue-600 hover:border-blue-700 transition-all shadow-sm"
                       title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg border border-slate-200 p-6 md:p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            @if($document->type)
                                <span class="text-[9px] font-medium bg-blue-600 px-2.5 py-1 rounded text-white uppercase tracking-wider">
                                    {{ $document->type }}
                                </span>
                            @else
                                <span class="text-[9px] font-medium bg-blue-600 px-2.5 py-1 rounded text-white uppercase tracking-wider" data-i18n="general">
                                    General
                                </span>
                            @endif
                            <span class="text-[9px] font-[1000] bg-black text-white px-2.5 py-1 rounded uppercase tracking-[0.2em] !bg-black !text-white inline-block">
                                #{{ $document->id }}
                            </span>
                            @if($document->number)
                                <span class="text-[9px] font-black bg-blue-50 text-blue-700 px-2.5 py-1 rounded border border-blue-100 uppercase tracking-widest">
                                     {{ $document->number }}
                                </span>
                            @else
                                <span class="text-[9px] font-black bg-blue-50 text-blue-700 px-2.5 py-1 rounded border border-blue-100 uppercase tracking-widest" data-i18n="noNumber">
                                     Б/Н
                                </span>
                            @endif
                        </div>

                        <h1 class="text-xl font-medium text-black mb-6 leading-tight uppercase tracking-tight">
                            {{ $document->title }}
                        </h1>

                        <div class="text-[13px] text-black font-normal leading-relaxed border-t border-slate-100 pt-6">
                            <p class="whitespace-pre-line content-highlight break-words overflow-hidden w-full">
                                {{ $document->content ?? 'No detailed description available.' }}
                            </p>
                        </div>
                    </div>

                    @if($document->file_path)
                        @php
                            $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
                                if ($extension === 'docx' || $extension === 'doc') {
                                $themeClass = 'bg-blue-50 text-blue-600 border-blue-100 group-hover:bg-blue-600';
                                $btnClass = 'bg-blue-600';
                                $iconClass = 'bi bi-file-earmark-word-fill';
                                $i18nAssetKey = 'wordAsset';
                                $i18nDownloadKey = 'downloadWord';
                            } elseif ($extension === 'xlsx' || $extension === 'xls') {
                                $themeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100 group-hover:bg-emerald-600';
                                $btnClass = 'bg-emerald-600';
                                $iconClass = 'bi bi-file-earmark-excel-fill';
                                $i18nAssetKey = 'excelAsset';
                                $i18nDownloadKey = 'downloadExcel';
                            } elseif ($extension === 'rtf') {
                                $themeClass = 'bg-purple-50 text-purple-600 border-purple-100 group-hover:bg-purple-600';
                                $btnClass = 'bg-purple-600';
                                $iconClass = 'bi bi-file-earmark-richtext-fill';
                                $i18nAssetKey = 'rtfAsset';
                                $i18nDownloadKey = 'downloadRtf';
                            } else {
                                $themeClass = 'bg-red-50 text-red-600 border-red-100 group-hover:bg-red-600';
                                $btnClass = 'bg-green-600';
                                $iconClass = 'bi bi-file-earmark-pdf-fill';
                                $i18nAssetKey = 'pdfAsset';
                                $i18nDownloadKey = 'downloadPdf';
                            }

                            $isPdf = $extension === 'pdf';
                        @endphp

                        <div class="bg-white rounded-lg border border-slate-200 p-4 flex items-center justify-between group hover:border-blue-400 transition-all shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center border transition-colors {{ $themeClass }} group-hover:text-white">
                                    <i class="{{ $iconClass }} text-xl"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[11px] font-bold text-black uppercase tracking-wide truncate max-w-[200px] md:max-w-xs">
                                        {{ basename($document->file_path) }}
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-bold uppercase" data-i18n="{{ $i18nAssetKey }}">
                                            {{ strtoupper($extension) }} Asset
                                        </span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-[9px] text-black opacity-60 uppercase font-medium" data-i18n="readyView">Ready to View</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ asset('storage/' . $document->file_path) }}" @if($isPdf) target="_blank" @endif
                            class="flex items-center gap-2 px-3 py-2 rounded-md bg-slate-100 text-black hover:bg-blue-600 hover:text-white transition-all border border-slate-200 shadow-sm">
                                <span class="text-[10px] font-black uppercase tracking-tighter" data-i18n="viewBtn">Смотреть</span>
                                <i class="bi bi-eye-fill text-sm"></i>
                            </a>
                        </div>


                        <a href="{{ asset('storage/' . $document->file_path) }}"
                           download="{{ $document->title }}.{{ $extension }}"
                           class="h-10 px-4 {{ $btnClass }} text-white rounded-xl font-semibold uppercase tracking-widest text-xs flex items-center justify-center hover:scale-[1.01] active:scale-95 transition shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span data-i18n="{{ $i18nDownloadKey }}">СКАЧАТЬ {{ strtoupper($extension) }}</span>
                        </a>
                    @endif


                    <div class="space-y-4">
                        <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 flex items-center gap-2">
                            <i class="bi bi-chat-left-text-fill text-orange-500"></i> <span data-i18n="systemNotes">SYSTEM NOTES</span>
                        </h3>

                        <form action="{{ route('comments.store') }}" method="POST" class="relative group">
                            @csrf
                            <input type="hidden" name="document_id" value="{{ $document->id }}">
                            <textarea name="comment" rows="2"
                                      class="w-full bg-white border border-slate-200 rounded-2xl p-4 pr-12 text-[12px] text-black focus:border-orange-400 focus:ring-4 focus:ring-orange-50 outline-none transition-all placeholder:text-slate-400 shadow-sm"
                                      data-i18n-placeholder="commentPlaceholder"
                                      placeholder="Leave a comment..."></textarea>
                            <button class="absolute bottom-4 right-4 text-orange-500 hover:text-orange-600 hover:scale-110 transition-all">
                                <i class="bi bi-send-fill text-xl text-primary"></i>
                            </button>
                        </form>

                        <div class="space-y-3 mt-4">
                            @forelse($comments ?? [] as $comment)
                                <div class="p-4 rounded-2xl shadow-md border border-orange-400/20 flex flex-col min-w-0"
                                     style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%) !important;">

                                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-white/20">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-white truncate mr-2">
                                            {{ $comment->user?->name ?? 'System' }}
                                        </span>
                                        <span class="text-[9px] text-white/90 font-bold bg-black/10 px-2 py-0.5 rounded-full flex-shrink-0">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <p class="text-[12px] text-white font-medium leading-relaxed drop-shadow-sm break-words overflow-hidden">
                                        {{ $comment->comment }}
                                    </p>

                                    @if(auth()->id() === $document->user_id)
                                        <div class="flex justify-end mt-3 pt-2">
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center gap-1 text-[10px] text-white/80 hover:text-red-200 transition-colors font-bold uppercase tracking-tighter">
                                                    <i class="bi bi-trash3"></i>
                                                    <span data-i18n="delete">Удалить</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-8 border-2 border-dashed border-slate-100 rounded-2xl bg-slate-50/50">
                                    <i class="bi bi-chat-dots text-slate-300 text-2xl mb-2 block"></i>
                                    <p class="text-[10px] font-medium uppercase tracking-widest text-slate-400" data-i18n="noNotes">No notes yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>


                <div class="space-y-6">
                    <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
                        <p class="text-[10px] font-medium text-black uppercase mb-6 tracking-[0.2em] border-b border-slate-50 pb-2" data-i18n="details">Details</p>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 uppercase text-sm font-medium" data-i18n="signature">Signature</span>
                                @php
                                    $status = strtolower($document->status);
                                    $isFullySigned = in_array($status, ['completed', 'approved']);
                                    $hasAnySignature = $document->signatures->count() > 0;
                                @endphp

                                @if($isFullySigned)
                                    <div class="px-2 py-1 rounded border border-green-600/50 flex items-center gap-1 bg-green-50/50 shadow-sm">
                                        <i class="bi bi-check-all !text-black text-sm font-bold" style="color: #000000 !important;"></i>
                                        <span class="font-bold uppercase text-[10px] !text-black tracking-wide" style="color: #000000 !important;" data-i18n="signed">Signed</span>
                                    </div>
                                @elseif($hasAnySignature)
                                    <div class="px-2 py-1 rounded border border-amber-600/60 flex items-center gap-1 bg-amber-50/50 shadow-sm">
                                        <i class="bi bi-pen-fill !text-black text-[10px]" style="color: #000000 !important;"></i>
                                        <span class="font-bold uppercase text-[10px] !text-black tracking-wide" style="color: #000000 !important;" data-i18n="processing">Processing</span>
                                    </div>
                                @else
                                    <div class="px-2 py-1 rounded border border-red-600/50 flex items-center gap-1 bg-red-50/50 shadow-sm">
                                        <i class="bi bi-clock !text-black text-[10px]" style="color: #000000 !important;"></i>
                                        <span class="font-bold uppercase text-[10px] !text-black tracking-wide" style="color: #000000 !important;" data-i18n="notSigned">Not Signed</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-black opacity-60 uppercase tracking-wider" data-i18n="status">Status</span>
                                <span class="status-badge text-[9px] font-medium px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100 uppercase" data-status="{{ strtolower($document->status) }}">
                                    {{ $document->status ?? 'Draft' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-black opacity-60 uppercase tracking-wider" data-i18n="owner">Owner</span>
                                <span class="text-[10px] font-medium text-black">{{ $document->user?->name ?? 'Unassigned' }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-black opacity-60 uppercase tracking-wider" data-i18n="deadline">Deadline</span>
                                <span class="text-[10px] font-medium text-red-600 italic">
                                    {{ $document->deadline ? \Carbon\Carbon::parse($document->deadline)->format('d.m.Y') : '—' }}
                                </span>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-50 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-[9px] text-black opacity-40 uppercase" data-i18n="createdAt">Created At</span>
                                    <span class="text-[9px] text-black">{{ $document->created_at?->format('d M Y') ?? '—' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-[9px] text-black opacity-40 uppercase" data-i18n="lastUpdate">Last Update</span>
                                    <span class="text-[9px] text-black">{{ $document->updated_at?->diffForHumans() ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-black rounded-lg flex items-center gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></div>
                        <span class="text-[9px] font-medium text-white uppercase tracking-[0.2em]" data-i18n="liveDoc">Live Document</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const translations = {
                en: {
                    errorTitle: "Access Error",
                    back: "Back", edit: "Edit", delete: "Delete",
                    readyView: "Ready to View", viewBtn: "View",
                    downloadPdf: "DOWNLOAD PDF", downloadWord: "DOWNLOAD WORD", downloadExcel: "DOWNLOAD EXCEL", downloadRtf: "DOWNLOAD RTF",
                    systemNotes: "SYSTEM NOTES", commentPlaceholder: "Leave a comment...",
                    noNotes: "No notes yet", details: "Details", signature: "Signature",
                    signed: "Signed", notSigned: "Not Signed", processing: "Processing", status: "Status",
                    owner: "Owner", deadline: "Deadline", createdAt: "Created At",
                    lastUpdate: "Last Update", liveDoc: "Live Document",
                    draft: "Draft", active: "Active", approved: "Approved", completed: "Completed",
                    delete_confirm_title: "Delete ?",
                    delete_confirm_desc: "Are you sure you want to delete this document? This action cannot be undone.",
                    cancel: "Cancel",
                    delete_btn: "Delete",
                    general: "General",
                    noNumber: "W/N",
                    wordAsset: "WORD Asset",
                    pdfAsset: "PDF Asset",
                    excelAsset: "EXCEL Asset",
                    rtfAsset: "RTF Asset",
                    "У вас нет прав на удаление этого документа": "You do not have permission to delete this document."
                },
                ru: {
                    errorTitle: "Ошибка доступа",
                    back: "Назад", edit: "Редактировать", delete: "Удалить",
                    readyView: "Готов к просмотру", viewBtn: "Смотреть",
                    downloadPdf: "СКАЧАТЬ PDF", downloadWord: "СКАЧАТЬ WORD", downloadExcel: "СКАЧАТЬ EXCEL", downloadRtf: "СКАЧАТЬ RTF",
                    systemNotes: "СИСТЕМНЫЕ ЗАМЕТКИ", commentPlaceholder: "Оставьте комментарий...",
                    noNotes: "Заметок пока нет", details: "Детали", signature: "Подпись",
                    signed: "Подписан", notSigned: "Не подписан", processing: "В обработке", status: "Статус",
                    owner: "Владелец", deadline: "Срок", createdAt: "Создан",
                    lastUpdate: "Обновлено", liveDoc: "Живой документ",
                    draft: "Черновик", active: "Активен", approved: "Утвержден", completed: "Завершен",
                    delete_confirm_title: "Удалить ?",
                    delete_confirm_desc: "Вы уверены, что хотите удалить этот документ? Это действие невозможно будет отменить.",
                    cancel: "Отмена",
                    delete_btn: "Удалить",
                    general: "Общий",
                    noNumber: "Б/Н",
                    wordAsset: "WORD Документ",
                    pdfAsset: "PDF Документ",
                    excelAsset: "EXCEL Документ",
                    rtfAsset: "RTF Документ",
                    "У вас нет прав на удаление этого документа": "У вас нет прав на удаление этого документа"
                },
                tj: {
                    errorTitle: "Хатои дастрасӣ",
                    back: "Қафо", edit: "Вироиш", delete: "Ҳазф кардан",
                    readyView: "Барои тамошо омода", viewBtn: "Дидан",
                    downloadPdf: "БОРГИРИИ PDF", downloadWord: "БОРГИРИИ WORD", downloadExcel: "БОРГИРИИ EXCEL", downloadRtf: "БОРГИРИИ RTF",
                    systemNotes: "ҚАЙДҲОИ СИСТЕМА", commentPlaceholder: "Фикр гузоред...",
                    noNotes: "Қайдҳо нестанд", details: "Тафсилот", signature: "Имзо",
                    signed: "Имзошуда", notSigned: "Имзо нашудааст", processing: "Дар баррасӣ", status: "Ҳолат",
                    owner: "Соҳиб", deadline: "Мӯҳлат", createdAt: "Санаи эҷод",
                    lastUpdate: "Навсозӣ", liveDoc: "Ҳуҷҷати фаъол",
                    draft: "Пешнавис", active: "Фаъол", approved: "Тасдиқшуда", completed: "Иҷрошуда",
                    delete_confirm_title: "Нест кардан ?",
                    delete_confirm_desc: "Шумо мутмаин ҳастед, ки ин ҳуҷҷатро нест кардан мехоҳед? Ин амалро бекор кардан ғайриимкон аст.",
                    cancel: "Лағв",
                    delete_btn: "Нест кардан",
                    general: "Умумӣ",
                    noNumber: "Б/Р",
                    wordAsset: "WORD Ҳуҷҷат",
                    pdfAsset: "PDF Ҳуҷҷат",
                    excelAsset: "EXCEL Ҳуҷҷат",
                    rtfAsset: "RTF Ҳуҷҷат",
                    "У вас нет прав на удаление этого документа": "Шумо барои нест кардани ин ҳуҷҷат ҳуқуқ надоред."
                }
            };

            function applyShowTranslations() {
                const lang = localStorage.getItem('app-lang') || 'ru';
                const t = translations[lang];
                if (!t) return;

                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if (t[key]) {
                        el.textContent = t[key];
                    }
                });

                document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                    const key = el.getAttribute('data-i18n-placeholder');
                    if (t[key]) el.setAttribute('placeholder', t[key]);
                });

                document.querySelectorAll('.status-badge').forEach(el => {
                    const statusKey = el.getAttribute('data-status');
                    if (t[statusKey]) el.textContent = t[statusKey];
                });

                const errorTextEl = document.getElementById('session-error-text');
                if (errorTextEl) {
                    const rawError = errorTextEl.getAttribute('data-error-raw');
                    if (rawError && t[rawError]) {
                        errorTextEl.textContent = t[rawError];
                    } else if (rawError) {
                        errorTextEl.textContent = rawError;
                    }
                }
            }

            applyShowTranslations();
            setInterval(applyShowTranslations, 1000);
        });
    </script>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .doc-page-v2 a.bg-slate-100 { color: #000000 !important; }
        .doc-page-v2 a.bg-slate-100:hover { color: #ffffff !important; background-color: #2563eb !important; }
        .doc-page-v2 { background-color: #f8fafc !important; }
        .doc-page-v2 .bg-white { background-color: #ffffff !important; border: 1px solid #e2e8f0 !important; }
        .content-highlight { background-color: #fef08a !important; color: #000 !important; padding: 6px 10px; border-radius: 6px; display: inline-block; }
        .doc-page-v2 h1, .doc-page-v2 h2, .doc-page-v2 h3, .doc-page-v2 p, .doc-page-v2 span, .doc-page-v2 div, .doc-page-v2 label { color: #000 !important; }
        .font-inter { font-family: 'Inter', sans-serif; }
    </style>
@endpush
