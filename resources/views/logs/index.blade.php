@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] dark:bg-slate-950 py-8 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700;900&display=swap');
                .logs-page { font-family: 'Inter Tight', sans-serif !important; }
                .table-container {
                    background: #ffffff !important;
                    border-radius: 1.25rem;
                    border: 1px solid rgba(15, 23, 42, 0.05);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
                    overflow: hidden;
                }
                .dark .table-container { background: #1e293b !important; border-color: rgba(255, 255, 255, 0.05); }
                .logs-table th {
                    padding: 1rem 1.25rem;
                    font-size: 0.65rem !important;
                    font-weight: 900;
                    letter-spacing: 0.08em;
                    text-transform: uppercase;
                    color: #94a3b8 !important;
                    background-color: #ffffff;
                    border-bottom: 1px solid #f1f5f9;
                }
                .dark .logs-table th { background-color: #1e293b; border-bottom-color: #334155; }
                .logs-table td { padding: 1rem 1.25rem; font-size: 0.8rem; color: #334155 !important; vertical-align: middle; }
                .dark .logs-table td { color: #cbd5e1 !important; }
                .action-badge { padding: 0.35rem 0.75rem; font-size: 0.6rem; font-weight: 900; text-transform: uppercase; border-radius: 2rem; letter-spacing: 0.05em; }
                .tr-hover:hover { background-color: #f8fafc !important; }
                .dark .tr-hover:hover { background-color: #334155 !important; }
            </style>

            <div class="logs-page">
                {{-- Заголовок --}}
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-black tracking-tighter text-slate-900 dark:text-white uppercase" data-i18n="historyTitle">История событий</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1" data-i18n="systemArchive">System Log Archive</p>
                    </div>
                </div>

                <div class="table-container shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left logs-table border-collapse">
                            <thead>
                            <tr>
                                <th class="w-20 text-center" data-i18n="colId">ID</th>
                                <th data-i18n="colDoc">Документ</th>
                                <th data-i18n="colUser">Инициатор</th>
                                <th data-i18n="colAction">Тип действия</th>
                                <th class="hidden lg:table-cell" data-i18n="colMeta">Мета-данные</th>
                                <th data-i18n="colTime">Время</th>
                                <th class="text-right" data-i18n="colManage">Управление</th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @forelse($logs as $index=>$log)
                                <tr class="tr-hover transition-colors">
                                    <td class="text-center font-black text-slate-300 dark:text-slate-600">#{{ $index + 1 }}</td>
                                    <td>
                                        <span class="font-black text-slate-800 dark:text-slate-200 truncate block max-w-[180px]">
                                            {{ $log->document->title ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2.5">
                                            @php
                                                $name = $log->user->name ?? 'System';
                                                $firstChar = mb_substr($name, 0, 1);
                                                // Твои стили аватарок
                                                $avatarStyle = match(strtoupper($firstChar)) {
                                                    'A','R' => 'bg-red-50 text-red-600 border-red-100 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
                                                    'B','D' => 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
                                                    'S'     => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700',
                                                    default => 'bg-indigo-50 text-indigo-600 border-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20'
                                                };
                                            @endphp
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-[11px] font-[900] border shadow-sm {{ $avatarStyle }}">
                                                {{ strtoupper($firstChar) }}
                                            </div>
                                            <span class="font-bold text-slate-600 dark:text-slate-400 text-[11px]">{{ $name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $action = strtolower($log->action);
                                            // Маппинг для перевода и цвета
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
                                        <span class="action-badge px-2 py-1 rounded-lg border {{ $actionColor }}" data-i18n="{{ $actionKey }}">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <span class="text-slate-400 dark:text-slate-500 font-medium text-[11px] italic leading-tight block max-w-xs truncate">
                                            {{ $log->description }}
                                        </span>
                                    </td>
                                    <td class="font-bold text-slate-900 dark:text-slate-300 text-[10px]">
                                        {{ $log->created_at->format('d.m.y / H:i') }}
                                    </td>
                                    <td class="text-right">
                                        <form action="{{ route('logs.destroy', $log->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-confirm-i18n="confirmDelete"
                                                    class="text-[8px] font-black uppercase tracking-[0.12em] text-red-600 hover:text-red-500 dark:text-red-500/80 transition-all flex items-center justify-end gap-1 group">
                                                <span class="border-b border-red-100 dark:border-red-900 group-hover:border-red-500 pb-0.5" data-i18n="btnDelete">Удалить</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-20 text-center">
                                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-200 dark:text-slate-800" data-i18n="noLogs">No logs found</span>
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
                    btnDelete: "Удалить",
                    noLogs: "Записи не найдены",
                    confirmDelete: "Вы уверены, что хотите удалить эту запись?"
                },
                tj: {
                    historyTitle: "Таърихи ҳодисаҳо",
                    systemArchive: "Системаи Лог Архив",
                    colId: "ID",
                    colDoc: "Ҳуҷҷат",
                    colUser: "Ташаббускор",
                    colAction: "Намуди амал",
                    colMeta: "Мета-маълумот",
                    colTime: "Вақт",
                    colManage: "Идоракунӣ",
                    actionCreated: "Сохтан",
                    actionUpdated: "Навсозӣ",
                    actionDeleted: "Нест кардан",
                    actionSigned: "Имзо",
                    actionStatus: "Ивази статус",
                    actionUnknown: "Амал",
                    btnDelete: "Нест кардан",
                    noLogs: "Сабтҳо ёфт нашуданд",
                    confirmDelete: "Шумо боварӣ доред, ки ин сабтро нест кардан мехоҳед?"
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
                    btnDelete: "Delete",
                    noLogs: "No logs found",
                    confirmDelete: "Are you sure you want to delete this entry?"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            // Текстовые переводы
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // Перевод подтверждения удаления
            document.querySelectorAll('[data-confirm-i18n]').forEach(el => {
                const key = el.getAttribute('data-confirm-i18n');
                if (t[key]) {
                    el.onclick = (e) => {
                        if (!confirm(t[key])) e.preventDefault();
                    };
                }
            });
        });
    </script>
@endsection
