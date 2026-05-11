@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] dark:bg-slate-950 py-8 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700;900&display=swap');

                .logs-page { font-family: 'Inter Tight', sans-serif !important; }

                /* Контейнер таблицы */
                .table-container {
                    background: #ffffff !important;
                    border-radius: 1.25rem;
                    border: 1px solid rgba(15, 23, 42, 0.05);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
                    overflow: hidden;
                }
                .dark .table-container {
                    background: #1e293b !important;
                    border-color: rgba(255, 255, 255, 0.05);
                }

                /* Шапка таблицы */
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
                .dark .logs-table th {
                    background-color: #1e293b;
                    border-bottom-color: #334155;
                }

                /* Ячейки */
                .logs-table td {
                    padding: 1rem 1.25rem;
                    font-size: 0.8rem;
                    color: #334155 !important;
                    vertical-align: middle;
                }
                .dark .logs-table td { color: #cbd5e1 !important; }

                .action-badge {
                    padding: 0.35rem 0.75rem;
                    font-size: 0.6rem;
                    font-weight: 900;
                    text-transform: uppercase;
                    border-radius: 2rem;
                    letter-spacing: 0.05em;
                }

                .tr-hover:hover { background-color: #f8fafc !important; }
                .dark .tr-hover:hover { background-color: #334155 !important; }
            </style>

            <div class="logs-page">
                {{-- Заголовок --}}
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-black tracking-tighter text-slate-900 dark:text-white uppercase">История событий</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">System Log Archive</p>
                    </div>
                </div>

                <div class="table-container shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left logs-table border-collapse">
                            <thead>
                            <tr>
                                <th class="w-20 text-center">ID</th>
                                <th>Документ</th>
                                <th>Инициатор</th>
                                <th>Тип действия</th>
                                <th class="hidden lg:table-cell">Мета-данные</th>
                                <th>Время</th>
                                <th class="text-right">Управление</th>
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
                                            $actionColor = match(true) {
                                                str_contains($action, 'delete') || str_contains($action, 'удаление') =>
                                                    'bg-red-50 text-red-700 border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
                                                str_contains($action, 'create') || str_contains($action, 'создание') =>
                                                    'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
                                                str_contains($action, 'update') || str_contains($action, 'обновление') =>
                                                    'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
                                                str_contains($action, 'sign') || str_contains($action, 'подпись') =>
                                                    'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20',
                                                default => 'bg-slate-50 text-slate-500 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700'
                                            };
                                        @endphp
                                        <span class="action-badge px-2 py-1 rounded-lg {{ $actionColor }}">
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
                                            <button type="submit"
                                                    onclick="return confirm('Вы уверены, что хотите удалить эту запись?')"
                                                    class="text-[8px] font-black uppercase tracking-[0.12em] text-red-600 hover:text-red-500 dark:text-red-500/80 transition-all flex items-center justify-end gap-1 group">
                                                <i class="bi bi-trash3-fill text-[10px]"></i>
                                                <span class="border-b border-red-100 dark:border-red-900 group-hover:border-red-500 pb-0.5"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-20 text-center">
                                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-200 dark:text-slate-800">No logs found</span>
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
@endsection
