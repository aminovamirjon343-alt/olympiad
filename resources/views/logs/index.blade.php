@extends('layouts.admin')

@section('content')
    {{-- Добавили bg-slate-50 для мягкого системного фона --}}
    <div class="min-h-screen bg-[#f8fafc] py-8">
        <div class="container mx-auto px-4">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700;900&display=swap');

                .logs-page {
                    font-family: 'Inter Tight', sans-serif !important;
                }

                /* Контейнер таблицы теперь "парит" над серым фоном */
                .table-container {
                    background: #ffffff !important;
                    border-radius: 1.25rem;
                    border: 1px solid rgba(15, 23, 42, 0.05);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
                    overflow: hidden;
                }

                .logs-table th {
                    padding: 0.85rem 1.25rem;
                    font-size: 0.65rem !important;
                    font-weight: 900;
                    letter-spacing: 0.08em;
                    text-transform: uppercase;
                    color: #64748b !important;
                    background-color: #fcfdfe; /* Чуть светлее для шапки */
                    border-bottom: 1px solid #f1f5f9;
                }

                .logs-table td {
                    padding: 0.85rem 1.25rem;
                    font-size: 0.8rem;
                    color: #334155 !important;
                    vertical-align: middle;
                }

                .action-badge {
                    padding: 0.3rem 0.7rem;
                    font-size: 0.65rem;
                    font-weight: 900;
                    text-transform: uppercase;
                    border-radius: 0.5rem;
                }

                /* Эффект при наведении на строку */
                .tr-hover:hover {
                    background-color: #f8fafc !important;
                }
            </style>

            <div class="logs-page">
                {{-- Шапка --}}
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-black tracking-tighter text-slate-900 uppercase">История событий</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">System Log Archive</p>
                    </div>
                    <a href="{{ route('logs.create') }}"
                       class="text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg hover:brightness-110 active:scale-95 flex items-center gap-2"
                       style="background-color: var(--primary) !important;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M12 4v16m8-8H4"/></svg>
                        Добавить лог
                    </a>
                </div>

                {{-- Уведомление --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-white border-l-4 border-green-500 shadow-sm text-green-700 rounded-r-xl text-[10px] font-black uppercase flex items-center gap-3">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-container">
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

                            <tbody class="divide-y divide-slate-50">
                            @forelse($logs as $log)
                                <tr class="tr-hover transition-colors">
                                    <td class="text-center font-black text-slate-300">#{{ $log->id }}</td>

                                    <td>
                                        <span class="font-black text-slate-800 truncate block max-w-[180px]">
                                            {{ $log->document->title ?? '—' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 border border-slate-200">
                                                {{ mb_substr($log->user->name ?? 'S', 0, 1) }}
                                            </div>
                                            <span class="font-bold text-slate-600 text-[11px]">{{ $log->user->name ?? 'System' }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $actionColor = match(strtolower($log->action)) {
                                                'создание', 'create' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                                'удаление', 'delete' => 'bg-rose-50 text-rose-700 border border-rose-100',
                                                'изменение', 'update' => 'bg-sky-50 text-sky-700 border border-sky-100',
                                                default => 'bg-slate-50 text-slate-600 border border-slate-100',
                                            };
                                        @endphp
                                        <span class="action-badge {{ $actionColor }}">
                                            {{ $log->action }}
                                        </span>
                                    </td>

                                    <td class="hidden lg:table-cell">
                                        <span class="text-slate-400 font-medium text-[11px] italic">{{ Str::limit($log->description, 45) }}</span>
                                    </td>

                                    <td class="font-bold text-slate-400 text-[10px]">
                                        {{ $log->created_at->format('d.m.y / H:i') }}
                                    </td>

                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-4">
                                            <form action="{{ route('logs.destroy', $log->id) }}" method="POST" onsubmit="return confirm('ВНИМАНИЕ: Вы уверены, что хотите безвозвратно удалить этот лог?')" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:text-red-700 active:scale-95 transition-all duration-200 flex items-center gap-1 group">

                                                    {{-- Иконка тоже в цвет текста --}}
                                                    <svg class="w-3 h-3 text-red-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>

                                                    <span class="border-b border-red-200 group-hover:border-red-600 transition-colors">Удалить</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-20 text-center">
                                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-200">No logs found</span>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($logs->hasPages())
                        <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/20 flex items-center justify-between">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Total entries: {{ $logs->total() }}</span>
                            <div class="pagination-small">
                                {{ $logs->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
