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
                        <span data-i18n="documents">DOCUMENTS</span>
                    </h1>
                </div>

                <form action="{{ route('documents.index') }}" method="GET" class="flex items-center gap-2">


                    <a href="{{route('documents.create')}}" class="btn-primary-custom" onclick="showPage('documents', null)">
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
                        <th class="px-4 py-2 text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="id">ID</th>
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
                                            <span data-i18n="by">By</span>: {{ $doc->createdBy->name ?? 'System' }}
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
                                    $status = strtolower($doc->status);
                                    $colors = match($status) {
                                        'draft'      => ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'],
                                        'active'     => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#93c5fd'],
                                        'approved', 'completed' => ['bg' => '#f0fdf4', 'text' => '#166534', 'border' => '#bbf7d0'], // Зеленый для готовых
                                        'processing' => ['bg' => '#fefce8', 'text' => '#854d0e', 'border' => '#fef08a'], // Желтый для процесса
                                        'rejected'   => ['bg' => '#fef2f2', 'text' => '#dc2626', 'border' => '#fecaca'],
                                        default      => ['bg' => '#fff7ed', 'text' => '#ea580c', 'border' => '#fdba74'],
                                    };
                                @endphp

                                <span style="display: inline-flex; align-items: center; justify-content: center; background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border: 1px solid {{ $colors['border'] }}; padding: 4px 12px; border-radius: 6px; font-weight: 800; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; min-width: 90px;">
        @if($status == 'processing')
                                        В процессе
                                    @elseif($status == 'completed')
                                        Завершено
                                    @else
                                        {{ $doc->status_label }}
                                    @endif
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
                                    <p class="text-[11px] font-bold uppercase tracking-widest text-black" data-i18n="docNotFound">Документ не найден</p>
                                    <p class="text-[9px] mt-1 mb-4 uppercase text-black opacity-70" data-i18n="tryDifferentSearch">Попробуйте изменить запрос</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const translations = {
                en: {
                    documents: "DOCUMENTS",
                    searchPlaceholder: "Search...",
                    newDocument: "New Document",
                    id: "ID",
                    docInfo: "Document Info",
                    deadline: "Deadline",
                    status: "Status",
                    actions: "Actions",
                    by: "By",
                    docNotFound: "Document not found",
                    tryDifferentSearch: "Try changing your search query",
                    resetSearch: "Reset search"
                },
                ru: {
                    documents: "ДОКУМЕНТЫ",
                    searchPlaceholder: "Поиск...",
                    newDocument: "Новый документ",
                    id: "ID",
                    docInfo: "Инфо о документе",
                    deadline: "Срок",
                    status: "Статус",
                    actions: "Действия",
                    by: "От",
                    docNotFound: "Документ не найден",
                    tryDifferentSearch: "Попробуйте изменить запрос",
                    resetSearch: "Сбросить поиск"
                },
                tj: {
                    documents: "ҲУҶҶАТҲО",
                    searchPlaceholder: "Ҷустуҷӯ...",
                    newDocument: "Ҳуҷҷати нав",
                    id: "ID",
                    docInfo: "Маълумоти ҳуҷҷат",
                    deadline: "Мӯҳлат",
                    status: "Статус",
                    actions: "Амалҳо",
                    by: "Аз ҷониби",
                    docNotFound: "Ҳуҷҷат ёфт нашуд",
                    tryDifferentSearch: "Кӯшиш кунед дархостро иваз кунед",
                    resetSearch: "Тоза кардани ҷустуҷӯ"
                }
            };

            function applyTranslations() {
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
            }

            applyTranslations();
            // Интервал для отслеживания смены языка без перезагрузки
            setInterval(applyTranslations, 1000);
        });
    </script>
@endsection




{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    --}}{{-- Главный контейнер --}}
{{--    <div class="doc-page-v2 bg-blue-theme min-h-[calc(100vh-64px)] py-6 px-4 md:px-8 relative">--}}

{{--        <div class="relative z-10 max-w-7xl mx-auto">--}}
{{--            --}}{{-- Header --}}
{{--            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">--}}
{{--                <div>--}}
{{--                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">--}}
{{--                        <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>--}}
{{--                        <span data-i18n="documents">DOCUMENTS</span>--}}
{{--                    </h1>--}}
{{--                </div>--}}

{{--                <form action="{{ route('documents.index') }}" method="GET" class="flex items-center gap-2">--}}
{{--                    <a href="{{route('documents.create')}}" class="btn-primary-custom" onclick="showPage('documents', null)">--}}
{{--                        <i class="bi bi-plus-lg me-1"></i>--}}
{{--                        <span data-i18n="newDocument">New Document</span>--}}
{{--                    </a>--}}
{{--                </form>--}}
{{--            </div>--}}

{{--            --}}{{-- Table --}}
{{--            <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">--}}
{{--                <table class="w-full text-left border-collapse bg-white">--}}
{{--                    <thead>--}}
{{--                    <tr class="border-b border-slate-200 bg-slate-50/50">--}}
{{--                        <th class="px-4 py-2 text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="id">ID</th>--}}
{{--                        <th class="px-4 py-2 text-left text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="docInfo">Document Info</th>--}}
{{--                        <th class="px-4 py-2 text-center text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="deadline">Deadline</th>--}}
{{--                        <th class="px-4 py-2 text-center text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="status">Status</th>--}}
{{--                        <th class="px-4 py-2 text-right text-[9px] font-medium text-black uppercase tracking-[0.2em]" data-i18n="actions">Actions</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="divide-y divide-slate-100">--}}
{{--                    @forelse($documents as $index=>$doc)--}}
{{--                        <tr class="group hover:bg-slate-50 transition-all">--}}
{{--                            <td class="px-4 py-2 text-[10px] text-black font-normal italic">#{{ ($documents->currentPage() - 1) * $documents->perPage() + $index + 1 }}</td>--}}

{{--                            <td class="px-4 py-2">--}}
{{--                                <div class="flex items-start gap-2.5">--}}
{{--                                    --}}{{-- ДОБАВЛЕНО: Индикатор формата файла (PDF или Word) на основе расширения --}}
{{--                                    @php--}}
{{--                                        $ext = $doc->file_path ? strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION)) : 'none';--}}
{{--                                    @endphp--}}
{{--                                    <div class="mt-0.5 select-none text-base">--}}
{{--                                        @if($ext === 'docx')--}}
{{--                                            <span title="Microsoft Word (DOCX)">🟦</span>--}}
{{--                                        @elseif($ext === 'pdf')--}}
{{--                                            <span title="Adobe PDF">🟥</span>--}}
{{--                                        @else--}}
{{--                                            <span title="Без файла">📄</span>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}

{{--                                    <div class="flex flex-col">--}}
{{--                                        <div class="flex items-center gap-2">--}}
{{--                                            <span class="text-[11px] font-medium text-black uppercase tracking-wider">--}}
{{--                                                {{ Str::limit($doc->title, 45) }}--}}
{{--                                            </span>--}}
{{--                                            <span class="text-[10px] font-bold text-blue-600 italic">--}}
{{--                                                {{ $doc->number ?? $doc->id }}--}}
{{--                                            </span>--}}
{{--                                        </div>--}}

{{--                                        @if(auth()->user()->is_admin)--}}
{{--                                            <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter">--}}
{{--                                                <span data-i18n="by">By</span>: {{ $doc->createdBy->name ?? 'System' }}--}}
{{--                                            </span>--}}
{{--                                        @endif--}}

{{--                                        <span class="text-[9px] text-black font-normal opacity-80 mt-0.5">--}}
{{--                                            {{ Str::limit($doc->content, 40) ?: 'No description' }}--}}
{{--                                        </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </td>--}}

{{--                            <td class="px-4 py-2 text-center">--}}
{{--                                <span class="text-[10px] font-normal text-black italic">--}}
{{--                                    {{ $doc->deadline ? $doc->deadline->format('d.m.Y') : '—' }}--}}
{{--                                </span>--}}
{{--                            </td>--}}
{{--                            <td class="px-4 py-2 text-center">--}}
{{--                                @php--}}
{{--                                    $status = strtolower($doc->status);--}}
{{--                                    $colors = match($status) {--}}
{{--                                        'draft' => ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'],--}}
{{--                                        'active', 'approved' => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#93c5fd'],--}}
{{--                                        'rejected' => ['bg' => '#fef2f2', 'text' => '#dc2626', 'border' => '#fecaca'],--}}
{{--                                        default => ['bg' => '#fff7ed', 'text' => '#ea580c', 'border' => '#fdba74'],--}}
{{--                                    };--}}
{{--                                @endphp--}}

{{--                                <span style="display: inline-flex; align-items: center; justify-content: center; background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border: 1px solid {{ $colors['border'] }}; padding: 4px 12px; border-radius: 6px; font-weight: 800; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; min-width: 90px;">--}}
{{--                                    {{ $doc->status_label }}--}}
{{--                                </span>--}}
{{--                            </td>--}}

{{--                            <td class="px-4 py-2 text-right">--}}
{{--                                <div class="flex justify-end gap-3 text-black opacity-40 group-hover:opacity-100 transition-opacity">--}}
{{--                                    <a href="{{ route('documents.show', $doc->id) }}" title="View"><i class="bi bi-eye text-[11px]"></i></a>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="5" class="py-16 text-center">--}}
{{--                                <div class="flex flex-col items-center justify-center">--}}
{{--                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3" style="background-color: #f1f5f9; border: 1px solid #e2e8f0;">--}}
{{--                                        <i class="bi bi-search text-xl text-black opacity-30"></i>--}}
{{--                                    </div>--}}
{{--                                    <p class="text-[11px] font-bold uppercase tracking-widest text-black" data-i18n="docNotFound">Документ не найден</p>--}}
{{--                                    <p class="text-[9px] mt-1 mb-4 uppercase text-black opacity-70" data-i18n="tryDifferentSearch">Попробуйте изменить запрос</p>--}}
{{--                                    <a href="{{ route('documents.index') }}" class="px-3 py-1 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-600 text-[9px] font-bold uppercase rounded transition-all" data-i18n="resetSearch">--}}
{{--                                        Сбросить поиск--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                {{ $documents->links() }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function() {--}}
{{--            const translations = {--}}
{{--                en: {--}}
{{--                    documents: "DOCUMENTS",--}}
{{--                    searchPlaceholder: "Search...",--}}
{{--                    newDocument: "New Document",--}}
{{--                    id: "ID",--}}
{{--                    docInfo: "Document Info",--}}
{{--                    deadline: "Deadline",--}}
{{--                    status: "Status",--}}
{{--                    actions: "Actions",--}}
{{--                    by: "By",--}}
{{--                    docNotFound: "Document not found",--}}
{{--                    tryDifferentSearch: "Try changing your search query",--}}
{{--                    resetSearch: "Reset search"--}}
{{--                },--}}
{{--                ru: {--}}
{{--                    documents: "ДОКУМЕНТЫ",--}}
{{--                    searchPlaceholder: "Поиск...",--}}
{{--                    newDocument: "Новый документ",--}}
{{--                    id: "ID",--}}
{{--                    docInfo: "Инфо о документе",--}}
{{--                    deadline: "Срок",--}}
{{--                    status: "Статус",--}}
{{--                    actions: "Действия",--}}
{{--                    by: "От",--}}
{{--                    docNotFound: "Документ не найден",--}}
{{--                    tryDifferentSearch: "Попробуйте изменить запрос",--}}
{{--                    resetSearch: "Сбросить поиск"--}}
{{--                },--}}
{{--                tj: {--}}
{{--                    documents: "ҲУҶҶАТҲО",--}}
{{--                    searchPlaceholder: "Ҷустуҷӯ...",--}}
{{--                    newDocument: "Ҳуҷҷати нав",--}}
{{--                    id: "ID",--}}
{{--                    docInfo: "Маълумоти ҳуҷҷат",--}}
{{--                    deadline: "Мӯҳлат",--}}
{{--                    status: "Статус",--}}
{{--                    actions: "Амалҳо",--}}
{{--                    by: "Аз ҷониби",--}}
{{--                    docNotFound: "Ҳуҷҷат ёфт нашуд",--}}
{{--                    tryDifferentSearch: "Кӯшиш кунед дархостро иваз кунед",--}}
{{--                    resetSearch: "Тоза кардани ҷустуҷӯ"--}}
{{--                }--}}
{{--            };--}}

{{--            function applyTranslations() {--}}
{{--                const lang = localStorage.getItem('app-lang') || 'ru';--}}
{{--                const t = translations[lang];--}}
{{--                if (!t) return;--}}

{{--                document.querySelectorAll('[data-i18n]').forEach(el => {--}}
{{--                    const key = el.getAttribute('data-i18n');--}}
{{--                    if (t[key]) el.textContent = t[key];--}}
{{--                });--}}

{{--                document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {--}}
{{--                    const key = el.getAttribute('data-i18n-placeholder');--}}
{{--                    if (t[key]) el.setAttribute('placeholder', t[key]);--}}
{{--                });--}}
{{--            }--}}

{{--            applyTranslations();--}}
{{--            setInterval(applyTranslations, 1000);--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
