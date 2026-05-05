@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] py-8">
        <div class="container mx-auto px-4">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700;900&display=swap');

                .logs-page {
                    font-family: 'Inter Tight', sans-serif !important;
                }

                .table-container {
                    background: #ffffff !important;
                    border-radius: 1.25rem;
                    border: 1px solid rgba(15, 23, 42, 0.05);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
                    overflow: hidden;
                }

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

                .logs-table td {
                    padding: 1rem 1.25rem;
                    font-size: 0.8rem;
                    color: #334155 !important;
                    vertical-align: middle;
                }

                .action-badge {
                    padding: 0.35rem 0.75rem;
                    font-size: 0.6rem;
                    font-weight: 900;
                    text-transform: uppercase;
                    border-radius: 2rem; /* Сделал более овальными как на скрине */
                    letter-spacing: 0.05em;
                }

                .tr-hover:hover {
                    background-color: #f8fafc !important;
                }
            </style>

            <div class="logs-page">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-black tracking-tighter text-slate-900 uppercase">История событий</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">System Log Archive</p>
                    </div>
                </div>

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
                            @forelse($logs as $index=>$log)
                                <tr class="tr-hover transition-colors">
                                    <td class="text-center font-black text-slate-300">#{{ $index + 1 }}</td>

                                    <td>
                                        <span class="font-black text-slate-800 truncate block max-w-[180px]">
                                            {{ $log->document->title ?? '—' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="flex items-center gap-2.5">
                                            @php
                                                // Генерация мягкого цвета на основе первой буквы имени
                                                $name = $log->user->name ?? 'System';
                                                $firstChar = mb_substr($name, 0, 1);
                                                $colors = [
                                                    'A' => 'bg-red-50 text-red-600 border-red-100',
                                                    'B' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                    'S' => 'bg-slate-100 text-slate-600 border-slate-200',
                                                    // Можно добавить другие буквы или сделать рандом
                                                ];
                                                $avatarStyle = $colors[strtoupper($firstChar)] ?? 'bg-indigo-50 text-indigo-600 border-indigo-100';
                                            @endphp

                                            {{-- Контейнер аватарки в стиле Inter Tight --}}
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-[11px] font-[900] border shadow-sm transition-transform hover:scale-110 {{ $avatarStyle }}">
                                                {{ strtoupper($firstChar) }}
                                            </div>
                                            <span class="font-bold text-slate-600 text-[11px]">{{ $log->user->name ?? 'System' }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $action = strtolower($log->action);

                                            $actionColor = match(true) {

                                                // ❌ УДАЛЕНИЕ — КРИТ (красный)
                                                str_contains($action, 'delete') || str_contains($action, 'удаление') =>
                                                    'bg-red-50 text-red-700 border border-red-200',

                                                // ➕ СОЗДАНИЕ — УСПЕХ (зелёный)
                                                str_contains($action, 'create') || str_contains($action, 'создание') =>
                                                    'bg-emerald-50 text-emerald-700 border border-emerald-200',

                                                // ✏️ ОБНОВЛЕНИЕ — ИНФО (синий)
                                                str_contains($action, 'update') || str_contains($action, 'обновление') =>
                                                    'bg-blue-50 text-blue-700 border border-blue-200',

                                                // ✍️ ПОДПИСЬ — ОСОБОЕ ДЕЙСТВИЕ (фиолетовый)
                                                str_contains($action, 'sign') || str_contains($action, 'подпись') =>
                                                    'bg-indigo-50 text-indigo-700 border border-indigo-200',

                                                // ⚠️ ПРЕДУПРЕЖДЕНИЕ
                                                str_contains($action, 'reject') || str_contains($action, 'отказ') =>
                                                    'bg-amber-50 text-amber-700 border border-amber-200',

                                                // 📤 ОТПРАВКА
                                                str_contains($action, 'send') || str_contains($action, 'отправка') =>
                                                    'bg-cyan-50 text-cyan-700 border border-cyan-200',

                                                // 📥 ПОЛУЧЕНИЕ
                                                str_contains($action, 'receive') || str_contains($action, 'получение') =>
                                                    'bg-teal-50 text-teal-700 border border-teal-200',

                                                // 💤 ДЕФОЛТ
                                                default =>
                                                    'bg-slate-50 text-slate-500 border border-slate-200',
                                            };
                                        @endphp

                                        <span class="action-badge px-2 py-1 rounded-lg text-[11px] font-semibold {{ $actionColor }}">
        {{ $log->action }}
    </span>
                                    </td>

                                    <td class="hidden lg:table-cell">
                                        <span class="text-slate-400 font-medium text-[11px] italic leading-tight block max-w-xs">
                                            {{ $log->description }}
                                        </span>
                                    </td>

                                    <td class="font-bold text-slate-900 text-[10px]">
                                        {{ $log->created_at->format('d.m.y / H:i') }}
                                    </td>

                                    <td class="text-right">
                                        <form action="{{ route('logs.destroy', $log->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:opacity-70 transition-all flex items-center justify-end gap-1 group">
                                                <i class="bi bi-trash3-fill text-[12px]"></i>
                                                <span class="border-b-2 border-red-100 group-hover:border-red-600">Удалить</span>
                                            </button>
                                        </form>
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
                </div>
            </div>
        </div>
    </div>
@endsection
