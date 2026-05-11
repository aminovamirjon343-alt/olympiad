@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        .search-page { font-family: 'Inter', sans-serif !important; }
        .search-page * { font-family: 'Inter', sans-serif !important; }
        .label-micro {
            font-size: 8px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: #94a3b8;
        }
        .row-result {
            background: #ffffff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }
        .dark .row-result {
            background: #1e293b !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .row-result:hover {
            background: #f8fafc !important;
            transform: translateX(3px);
        }
        .dark .row-result:hover { background: #334155 !important; }
        .data-title {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
        }
        .dark .data-title { color: #f1f5f9; }
        .badge-type {
            font-size: 7px;
            font-weight: 900;
            padding: 2px 5px;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .compact-td { padding: 0.75rem 1rem !important; }
        .text-excerpt {
            font-size: 10px;
            color: #64748b;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-all;
        }
        .dark .text-excerpt { color: #94a3b8; }
    </style>

    <div class="search-page container mx-auto px-4 py-4">
        {{-- Шапка --}}
        <div class="mb-6 flex justify-between items-end">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-0.5 h-3 bg-indigo-500 rounded-full"></div>
                    <span class="label-micro !text-indigo-500">Global Search System</span>
                </div>
                <h1 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">
                    <span data-i18n="resultsFor">Результаты:</span> <span class="text-indigo-500">"{{ $query }}"</span>
                </h1>
            </div>
            <div class="label-micro pb-1"><span data-i18n="totalFound">Всего найдено:</span> {{ $results->count() }}</div>
        </div>

        {{-- Основная таблица --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/60 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <th class="compact-td label-micro" data-i18n="thObject">Объект и описание</th>
                        <th class="compact-td label-micro" data-i18n="thCategory">Категория</th>
                        <th class="compact-td label-micro" data-i18n="thDetails">Детали</th>
                        <th class="compact-td label-micro" data-i18n="thStatus">Статус / Дата</th>
                        <th class="compact-td label-micro text-right" data-i18n="thAction">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($results as $item)
                        @php
                            $isUser = $item instanceof \App\Models\User;
                            $isSig = $item instanceof \App\Models\DocumentSignature;
                        @endphp
                        <tr class="row-result group">
                            <td class="compact-td">
                                <div class="flex items-center gap-3">
                                    <div class="shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-[10px] font-black
                                        {{ $isUser ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10' : ($isSig ? 'bg-amber-50 text-amber-600 dark:bg-amber-500/10' : 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10') }}">
                                        @if($isUser) {{ Str::upper(Str::substr($item->name, 0, 1)) }}
                                        @elseif($isSig) <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        @else <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg> @endif
                                    </div>
                                    <div class="flex flex-col min-w-0 max-w-[200px] lg:max-w-[350px]">
                                        <span class="data-title truncate">{{ $item->name ?? ($item->title ?? 'Запись #'.$item->id) }}</span>
                                        <span class="text-excerpt">
                                            @if($isUser) {{ $item->email }}
                                            @elseif($isSig) <span data-i18n="docPrefix">Документ:</span> {{ $item->document->title ?? 'N/A' }}
                                            @else {{ $item->content ?? '...' }} @endif
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="compact-td">
                                @if($isUser)
                                    <span class="badge-type bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400" data-i18n="typeUser">User</span>
                                @elseif($isSig)
                                    <span class="badge-type bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400" data-i18n="typeSig">Signature</span>
                                @else
                                    <span class="badge-type bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400" data-i18n="typeDoc">Document</span>
                                @endif
                            </td>

                            <td class="compact-td text-[10px] font-bold text-slate-600 dark:text-slate-400">
                                @if($isUser) {{ $item->role ?? 'User' }}
                                @elseif($isSig) ID: {{ $item->id }}
                                @else <span data-i18n="typeStandard">Стандартный</span> @endif
                            </td>

                            <td class="compact-td">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300">
                                        {{ $item->created_at->format('d.m.Y') }}
                                    </span>
                                    <span class="label-micro !text-[7px]">
                                        @if($isSig)
                                            <span data-i18n="{{ $item->signed_at ? 'statusSigned' : 'statusProcess' }}"></span>
                                        @else
                                            <span data-i18n="statusActive">Активен</span>
                                        @endif
                                    </span>
                                </div>
                            </td>

                            <td class="compact-td text-right">
                                <a href="{{ $isUser ? route('users.show', $item->id) : ($isSig ? route('signatures.show', $item->id) : route('documents.show', $item->id)) }}"
                                   class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-500 transition-all shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-16 text-center text-slate-300 dark:text-slate-600">
                                <span class="label-micro" data-i18n="noResults">По запросу ничего не найдено</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const translations = {
                ru: {
                    resultsFor: "Результаты:",
                    totalFound: "Всего найдено:",
                    thObject: "Объект и описание",
                    thCategory: "Категория",
                    thDetails: "Детали",
                    thStatus: "Статус / Дата",
                    thAction: "Действие",
                    typeUser: "Пользователь",
                    typeSig: "Подпись",
                    typeDoc: "Документ",
                    typeStandard: "Стандартный",
                    statusSigned: "Подписан",
                    statusProcess: "В процессе",
                    statusActive: "Активен",
                    docPrefix: "Документ:",
                    noResults: "По запросу ничего не найдено"
                },
                tj: {
                    resultsFor: "Натиҷаҳо:",
                    totalFound: "Ҳамагӣ ёфт шуд:",
                    thObject: "Объект ва тавсиф",
                    thCategory: "Категория",
                    thDetails: "Тафсилот",
                    thStatus: "Статус / Сана",
                    thAction: "Амал",
                    typeUser: "Корбар",
                    typeSig: "Имзо",
                    typeDoc: "Ҳуҷҷат",
                    typeStandard: "Стандартӣ",
                    statusSigned: "Имзо шуд",
                    statusProcess: "Дар ҷараён",
                    statusActive: "Фаъол",
                    docPrefix: "Ҳуҷҷат:",
                    noResults: "Тибқи дархост чизе ёфт нашуд"
                },
                en: {
                    resultsFor: "Results for:",
                    totalFound: "Total found:",
                    thObject: "Object & Description",
                    thCategory: "Category",
                    thDetails: "Details",
                    thStatus: "Status / Date",
                    thAction: "Action",
                    typeUser: "User",
                    typeSig: "Signature",
                    typeDoc: "Document",
                    typeStandard: "Standard",
                    statusSigned: "Signed",
                    statusProcess: "In Process",
                    statusActive: "Active",
                    docPrefix: "Document:",
                    noResults: "No results found"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });
        });
    </script>
@endsection
