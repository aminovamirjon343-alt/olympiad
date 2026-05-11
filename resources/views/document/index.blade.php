@extends('layouts.admin')

@section('content')
    {{-- Главный контейнер --}}
    <div class="doc-page-v2 bg-blue-theme min-h-[calc(100vh-64px)] py-6 px-4 md:px-8 relative">

        <div class="relative z-10 max-w-7xl mx-auto">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                        <span data-i18n="documentsTitle">DOCUMENTS</span>
                    </h1>
                </div>

                <form action="{{ route('documents.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative flex items-center">
                        <input type="text"
                               name="search"
                               id="search-input"
                               list="documents-list"
                               value="{{ request('search') }}"
                               class="bg-white border border-slate-200 text-[10px] text-black rounded-lg pl-3 pr-8 py-1.5 w-40 focus:ring-1 focus:ring-blue-500 outline-none transition-all font-bold shadow-sm"
                               placeholder="Search..."
                               data-i18n-placeholder="searchPlaceholder"
                               autocomplete="off">

                        <datalist id="documents-list">
                            @foreach($documents as $doc)
                                <option value="{{ $doc->title }}">
                            @endforeach
                        </datalist>

                        <button type="submit" class="absolute right-1 px-1.5 py-1 text-slate-500 hover:text-blue-600 transition-colors">
                            <i class="bi bi-arrow-right-short text-xl leading-none"></i>
                        </button>
                    </div>

                    <a href="{{route('documents.create')}}" class="btn-primary-custom">
                        <i class="bi bi-plus-lg me-1"></i>
                        <span data-i18n="newDocument">New Document</span>
                    </a>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse bg-white">
                    <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50">
                        <th class="px-4 py-2 text-[9px] font-medium text-black uppercase tracking-[0.2em]">ID</th>
                        <th class="px-4 py-2 text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="docInfo">Document Info</th>
                        <th class="px-4 py-2 text-center text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="deadline">Deadline</th>
                        <th class="px-4 py-2 text-center text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="status">Status</th>
                        <th class="px-4 py-2 text-right text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $index=>$doc)
                        <tr class="group hover:bg-slate-50 transition-all">
                            <td class="px-4 py-2 text-[10px] text-black font-normal italic">#{{ ($documents->currentPage() - 1) * $documents->perPage() + $index + 1 }}</td>

                            <td class="px-4 py-2">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-medium text-black uppercase tracking-wider">
                                            {{ Str::limit($doc->title, 45) }}
                                        </span>
                                        <span class="text-[10px] font-bold text-blue-600 italic">
                                            {{ $doc->number ?? $doc->id }}
                                        </span>
                                    </div>

                                    @if(auth()->user()->is_admin)
                                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter">
                                            <span data-i18n="authorBy">By</span>: {{ $doc->createdBy->name ?? 'System' }}
                                        </span>
                                    @endif

                                    <span class="text-[9px] text-black font-normal opacity-80 mt-0.5">
                                        {{ Str::limit($doc->content, 40) ?: 'No description' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-2 text-center">
                                <span class="text-[10px] font-normal text-black italic">
                                    {{ $doc->deadline ? $doc->deadline->format('d.m.Y') : '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                @php
                                    $statusVal = strtolower($doc->status);
                                    $colors = match($statusVal) {
                                        'draft' => ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'],
                                        'active', 'approved' => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#93c5fd'],
                                        'rejected' => ['bg' => '#fef2f2', 'text' => '#dc2626', 'border' => '#fecaca'],
                                        default => ['bg' => '#fff7ed', 'text' => '#ea580c', 'border' => '#fdba74'],
                                    };
                                @endphp

                                <span class="status-badge" data-status="{{ $statusVal }}" style="display: inline-flex; align-items: center; justify-content: center; background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border: 1px solid {{ $colors['border'] }}; padding: 4px 12px; border-radius: 6px; font-weight: 800; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; min-width: 90px;">
                                    {{ $doc->status_label }}
                                </span>
                            </td>

                            <td class="px-4 py-2 text-right">
                                <div class="flex justify-end gap-3 text-black opacity-40 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('documents.show', $doc->id) }}" title="View"><i class="bi bi-eye text-[11px]"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3" style="background-color: #f1f5f9; border: 1px solid #e2e8f0;">
                                        <i class="bi bi-search text-xl text-black opacity-30"></i>
                                    </div>
                                    <p class="text-[11px] font-bold uppercase tracking-widest text-black" data-i18n="noDocFound">Документ не найден</p>
                                    <p class="text-[9px] mt-1 mb-4 uppercase text-black opacity-70" data-i18n="tryChangeQuery">Попробуйте изменить запрос</p>
                                    <a href="{{ route('documents.index') }}" class="px-3 py-1 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-600 text-[9px] font-bold uppercase rounded transition-all" data-i18n="resetSearch">
                                        Сбросить поиск
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $documents->links() }}
            </div>
        </div>
    </div>

    {{-- Скрипт перевода внизу страницы --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const translations = {
                en: {
                    documentsTitle: "DOCUMENTS",
                    searchPlaceholder: "Search documents...",
                    newDocument: "New Document",
                    docInfo: "Document Info",
                    deadline: "Deadline",
                    status: "Status",
                    actions: "Actions",
                    authorBy: "By",
                    noDocFound: "Document not found",
                    tryChangeQuery: "Try changing your search query",
                    resetSearch: "Reset Search",
                    draft: "Draft",
                    active: "Active",
                    approved: "Approved",
                    rejected: "Rejected",
                    pending: "Pending"
                },
                ru: {
                    documentsTitle: "ДОКУМЕНТЫ",
                    searchPlaceholder: "Поиск документов...",
                    newDocument: "Новый документ",
                    docInfo: "Информация",
                    deadline: "Срок",
                    status: "Статус",
                    actions: "Действия",
                    authorBy: "Автор",
                    noDocFound: "Документ не найден",
                    tryChangeQuery: "Попробуйте изменить запрос",
                    resetSearch: "Сбросить поиск",
                    draft: "Черновик",
                    active: "Активен",
                    approved: "Утвержден",
                    rejected: "Отклонен",
                    pending: "Ожидает"
                },
                tj: {
                    documentsTitle: "ҲУҶҶАТҲО",
                    searchPlaceholder: "Ҷустуҷӯи ҳуҷҷатҳо...",
                    newDocument: "Ҳуҷҷати нав",
                    docInfo: "Маълумот",
                    deadline: "Мӯҳлат",
                    status: "Ҳолат",
                    actions: "Амалҳо",
                    authorBy: "Муаллиф",
                    noDocFound: "Ҳуҷҷат ёфт нашуд",
                    tryChangeQuery: "Кӯшиш кунед дархостро иваз кунед",
                    resetSearch: "Тоза кардан",
                    draft: "Пешнавис",
                    active: "Фаъол",
                    approved: "Тасдиқшуда",
                    rejected: "Радшуда",
                    pending: "Дар интизорӣ"
                }
            };

            function applyIndexTranslations() {
                const lang = localStorage.getItem('app-lang') || 'ru';
                const t = translations[lang];
                if (!t) return;

                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if (t[key]) el.textContent = t[key];
                });

                document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                    const key = el.getAttribute('data-i18n-placeholder');
                    if (t[key]) el.setAttribute('placeholder', t[key]);
                });

                document.querySelectorAll('.status-badge').forEach(el => {
                    const statusKey = el.getAttribute('data-status');
                    if (t[statusKey]) el.textContent = t[statusKey];
                });
            }

            applyIndexTranslations();

            // Следим за изменениями в localStorage (смена языка в другом окне/компоненте)
            window.addEventListener('storage', (e) => {
                if (e.key === 'app-lang') applyIndexTranslations();
            });

            // Для мгновенного обновления, если кнопка смены языка просто меняет localStorage
            setInterval(applyIndexTranslations, 1000);
        });
    </script>
@endsection
