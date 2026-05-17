@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] dark:bg-slate-950 py-5 transition-colors duration-300">

        <div class="max-w-6xl mx-auto px-3">

            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

                .logs-page{
                    font-family:'Inter',sans-serif !important;
                }

                .table-container{
                    background:#ffffff !important;
                    border-radius:1rem;
                    border:1px solid rgba(15,23,42,0.05);
                    box-shadow:0 4px 14px rgba(15,23,42,0.04);
                    overflow:hidden;
                }

                .dark .table-container{
                    background:#0f172a !important;
                    border-color:rgba(255,255,255,0.05);
                }

                .logs-table th{
                    padding:0.7rem 0.9rem;
                    font-size:0.56rem !important;
                    font-weight:900;
                    letter-spacing:0.08em;
                    text-transform:uppercase;
                    color:#94a3b8 !important;
                    background:#ffffff;
                    border-bottom:1px solid #f1f5f9;
                    white-space:nowrap;
                }

                .dark .logs-table th{
                    background:#0f172a;
                    border-bottom-color:#1e293b;
                }

                .logs-table td{
                    padding:0.7rem 0.9rem;
                    font-size:0.72rem;
                    color:#334155 !important;
                    vertical-align:middle;
                }

                .dark .logs-table td{
                    color:#cbd5e1 !important;
                }

                .action-badge{
                    padding:0.23rem 0.55rem;
                    font-size:0.52rem;
                    font-weight:900;
                    text-transform:uppercase;
                    border-radius:999px;
                    letter-spacing:0.05em;
                    border-width:1px;
                }

                .tr-hover{
                    transition:all .18s ease;
                }

                .tr-hover:hover{
                    background:#f8fafc !important;
                }

                .dark .tr-hover:hover{
                    background:#172033 !important;
                }

                .mini-avatar{
                    width:30px;
                    height:30px;
                    border-radius:10px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:10px;
                    font-weight:900;
                    border-width:1px;
                    box-shadow:0 1px 2px rgba(0,0,0,0.04);
                }

                .delete-btn{
                    width:28px;
                    height:28px;
                    border-radius:9px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    transition:all .2s ease;
                }

                .delete-btn:hover{
                    transform:scale(1.05);
                }

                .custom-scroll::-webkit-scrollbar{
                    height:5px;
                }

                .custom-scroll::-webkit-scrollbar-thumb{
                    background:#cbd5e1;
                    border-radius:20px;
                }

                .dark .custom-scroll::-webkit-scrollbar-thumb{
                    background:#334155;
                }
            </style>

            <div class="logs-page">

                {{-- HEADER --}}
                <div class="flex items-end justify-between mb-5">

                    <div>
                        <h1
                            class="text-2xl font-black tracking-[-0.05em] text-slate-900 dark:text-white uppercase"
                            data-i18n="historyTitle"
                        >
                            История событий
                        </h1>

                        <p
                            class="text-[9px] font-black text-slate-400 uppercase tracking-[0.22em] mt-1"
                            data-i18n="systemArchive"
                        >
                            System Log Archive
                        </p>
                    </div>

                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-500/10 dark:bg-white/5 border border-slate-500/10 dark:border-white/10 shadow-sm">
                        {{-- Пульсирующая точка --}}
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>

                        {{-- Текст счетчика с поддержкой локализации --}}
                        <span class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-600 dark:text-slate-300 flex gap-1 items-center" id="logsCounterContainer">
        <span id="logsCountNumber">{{ count($logs) }}</span>
        <span data-i18n="logsText">логов</span>
    </span>
                    </div>

                </div>

                {{-- TABLE --}}
                <div class="table-container shadow-lg">

                    <div class="overflow-x-auto custom-scroll">

                        <table class="w-full text-left logs-table border-collapse min-w-[850px]">

                            {{-- HEAD --}}
                            <thead>
                            <tr>

                                <th class="w-16 text-center" data-i18n="colId">
                                    ID
                                </th>

                                <th data-i18n="colDoc">
                                    Документ
                                </th>

                                <th data-i18n="colUser">
                                    Инициатор
                                </th>

                                <th data-i18n="colAction">
                                    Тип действия
                                </th>

                                <th class="hidden lg:table-cell" data-i18n="colMeta">
                                    Мета-данные
                                </th>

                                <th data-i18n="colTime">
                                    Время
                                </th>

                                <th class="text-right" data-i18n="colManage">
                                    Управление
                                </th>

                            </tr>
                            </thead>

                            {{-- BODY --}}
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                            @forelse($logs as $index => $log)

                                <tr class="tr-hover">

                                    {{-- ID --}}
                                    <td class="text-center font-black text-slate-300 dark:text-slate-600 text-[11px]">
                                        #{{ $index + 1 }}
                                    </td>

                                    {{-- DOCUMENT --}}
                                    <td>

                                    <span class="font-black text-slate-800 dark:text-slate-200 truncate block max-w-[150px] text-[11px]">
                                        {{ $log->document->title ?? '—' }}
                                    </span>

                                    </td>

                                    {{-- USER --}}
                                    <td>

                                        <div class="flex items-center gap-2">

                                            @php
                                                $name = $log->user->name ?? 'System';
                                                $firstChar = mb_substr($name, 0, 1);

                                                $avatarStyle = match(strtoupper($firstChar)) {
                                                    'A','R' => 'bg-red-50 text-red-600 border-red-100 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
                                                    'B','D' => 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
                                                    'S'     => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700',
                                                    default => 'bg-indigo-50 text-indigo-600 border-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20'
                                                };
                                            @endphp

                                            <div class="mini-avatar {{ $avatarStyle }}">
                                                {{ strtoupper($firstChar) }}
                                            </div>

                                            <span class="font-bold text-slate-600 dark:text-slate-400 text-[10px] truncate max-w-[90px]">
                                            {{ $name }}
                                        </span>

                                        </div>

                                    </td>

                                    {{-- ACTION --}}
                                    <td>

                                        @php
                                            $action = strtolower($log->action);

                                            $actionKey = match(true) {
                                                str_contains($action, 'create') || str_contains($action, 'создание') => 'actionCreated',
                                                str_contains($action, 'update') || str_contains($action, 'обновление') => 'actionUpdated',
                                                str_contains($action, 'delete') || str_contains($action, 'удаление') => 'actionDeleted',
                                                str_contains($action, 'sign') || str_contains($action, 'подпись') => 'actionSigned',
                                                str_contains($action, 'status') || str_contains($action, 'статус') => 'actionStatus',
                                                default => 'actionUnknown'
                                            };

                                            $actionColor = match($actionKey) {
                                                'actionDeleted' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
                                                'actionCreated' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
                                                'actionUpdated' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
                                                'actionSigned'  => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20',
                                                default         => 'bg-slate-50 text-slate-500 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700'
                                            };
                                        @endphp

                                        <span
                                            class="action-badge {{ $actionColor }}"
                                            data-i18n="{{ $actionKey }}"
                                        >
                                        {{ $log->action }}
                                    </span>

                                    </td>

                                    {{-- META --}}
                                    <td class="hidden lg:table-cell">

                                    <span class="text-slate-400 dark:text-slate-500 font-medium text-[10px] italic leading-tight block max-w-[180px] truncate">
                                        {{ $log->description }}
                                    </span>

                                    </td>

                                    {{-- TIME --}}
                                    <td class="font-bold text-slate-900 dark:text-slate-300 text-[9px] whitespace-nowrap">

                                        {{ $log->created_at->format('d.m.y / H:i') }}

                                    </td>

                                    {{-- DELETE --}}
                                    <td class="text-right">

                                        <form
                                            action="{{ route('logs.destroy', $log->id) }}"
                                            method="POST"
                                            class="inline-block"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                data-confirm-i18n="confirmDelete"
                                                class="delete-btn bg-red-50 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400"
                                            >
                                                <i class="bi bi-trash3 text-[11px]"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="py-14 text-center">

                                    <span
                                        class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-300 dark:text-slate-700"
                                        data-i18n="noLogs"
                                    >
                                        No logs found
                                    </span>

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const translations = {

                ru: {
                    historyTitle: "История событий",
                    systemArchive: "System Log Archive",
                    colId: "ID",
                    colDoc: "Документ",
                    colUser: "Инициатор",
                    colAction: "Тип действия",
                    colMeta: "Мета-данные",
                    colTime: "Время",
                    colManage: "Управление",
                    actionCreated: "Создание",
                    actionUpdated: "Обновление",
                    actionDeleted: "Удаление",
                    actionSigned: "Подписание",
                    actionStatus: "Смена статуса",
                    actionUnknown: "Действие",
                    noLogs: "Записи не найдены",
                    confirmDelete: "Удалить запись?",
                    logsText: "логов"
                },

                tj: {
                    historyTitle: "Таърихи ҳодисаҳо",
                    systemArchive: "Системаи Лог Архив",
                    colId: "ID",
                    colDoc: "Ҳуҷҷат",
                    colUser: "Ташаббускор",
                    colAction: "Навъи амал",
                    colMeta: "Мета-маълумот",
                    colTime: "Вақт",
                    colManage: "Идоракунӣ",
                    actionCreated: "Сохтан",
                    actionUpdated: "Навсозӣ",
                    actionDeleted: "Нест кардан",
                    actionSigned: "Имзо",
                    actionStatus: "Ивази статус",
                    actionUnknown: "Амал",
                    noLogs: "Сабтҳо ёфт нашуданд",
                    confirmDelete: "Сабт нест шавад?",
                    logsText: "логҳо"
                },

                en: {
                    historyTitle: "Event History",
                    systemArchive: "System Log Archive",
                    colId: "ID",
                    colDoc: "Document",
                    colUser: "Initiator",
                    colAction: "Action Type",
                    colMeta: "Meta Data",
                    colTime: "Time",
                    colManage: "Management",
                    actionCreated: "Creation",
                    actionUpdated: "Update",
                    actionDeleted: "Deletion",
                    actionSigned: "Signing",
                    actionStatus: "Status Change",
                    actionUnknown: "Action",
                    noLogs: "No logs found",
                    confirmDelete: "Delete this record?",
                    logsText: "logs"
                }

            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {

                const key = el.getAttribute('data-i18n');

                if (t[key]) {
                    el.textContent = t[key];
                }

            });

            document.querySelectorAll('[data-confirm-i18n]').forEach(el => {

                const key = el.getAttribute('data-confirm-i18n');

                el.onclick = (e) => {

                    if (t[key]) {

                        if (!confirm(t[key])) {
                            e.preventDefault();
                        }

                    }

                };

            });

        });
    </script>

@endsection
