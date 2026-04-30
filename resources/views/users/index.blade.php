@extends('layouts.admin')

@section('content')
    {{-- Фон всей страницы --}}
    <div class="min-h-screen bg-[#f1f5f9] py-8">
        <div class="container mx-auto px-4">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700;900&family=Inter:wght@400;600;800&display=swap');

                .users-page {
                    font-family: 'Inter', sans-serif !important;
                }

                .users-page h1 {
                    font-family: 'Inter Tight', sans-serif !important;
                }

                /* ТЕПЕРЬ КАРТОЧКА СЕРАЯ */
                .table-card {
                    background: #f8fafc !important; /* Светло-серый фон карточки */
                    border-radius: 1.25rem;
                    border: 1px solid rgba(15, 23, 42, 0.08);
                    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
                    overflow: hidden;
                }

                /* Шапка таблицы чуть темнее */
                .users-table th {
                    padding: 0.85rem 1.25rem;
                    font-size: 0.65rem !important;
                    font-weight: 900;
                    letter-spacing: 0.08em;
                    text-transform: uppercase;
                    color: #64748b !important;
                    background-color: #f1f5f9;
                    border-bottom: 1px solid #e2e8f0;
                }

                .users-table td {
                    padding: 0.85rem 1.25rem;
                    font-size: 0.8rem;
                    color: #334155 !important;
                    vertical-align: middle;
                    border-bottom: 1px solid #f1f5f9;
                }

                /* Эффект при наведении на серую строку */
                .tr-hover:hover {
                    background-color: #ffffff !important; /* При наведении строка становится белой */
                    transition: background 0.2s ease;
                }

                .btn-primary-system {
                    background-color: var(--primary, #4f46e5) !important;
                    transition: all 0.2s ease;
                }
            </style>

            <div class="users-page">
                {{-- Header --}}
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-black tracking-tighter text-slate-900 uppercase">Пользователи</h1>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1 italic">Управление командой и доступом</p>
                    </div>
                    <a href="{{ route('users.create') }}" class="btn-primary-system text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M12 4v16m8-8H4"/></svg>
                        Добавить
                    </a>
                </div>

                {{-- Таблица на сером фоне --}}
                <div class="table-card">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left users-table border-collapse">
                            <thead>
                            <tr>
                                <th class="w-16 text-center">ID</th>
                                <th>Сотрудник</th>
                                <th>Email / Контакты</th>
                                <th>Телефон</th>
                                <th class="text-center">Роль</th>
                                <th class="text-right">Управление</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $index => $user)
                                <tr class="tr-hover">
                                    <td class="text-center font-black text-slate-400">#{{ $index + 1 }}</td>

                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-[11px] font-black text-slate-500 border border-slate-200 shadow-sm">
                                                {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="font-black text-slate-800 tracking-tight">{{ $user->name }}</div>
                                        </div>
                                    </td>

                                    <td class="font-semibold text-slate-500 italic">
                                        {{ $user->email }}
                                    </td>

                                    <td>
                                        <div class="inline-flex items-center gap-1.5 py-1 px-2.5 bg-white rounded-md border border-slate-200 shadow-sm">
                                            <span class="text-indigo-500 font-black text-[9px] uppercase">TJ</span>
                                            <span class="font-black text-slate-700 text-[10px] tracking-tight">
                                            {{ $user->phone ?? '00 000 0000' }}
                                        </span>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @php
                                            $roleColor = match(strtolower($user->role)) {
                                                'admin', 'админ' => 'bg-indigo-600 text-white border-indigo-700',
                                                'editor', 'редактор' => 'bg-amber-500 text-white border-amber-600',
                                                default => 'bg-slate-100 text-slate-800 border-slate-200',
                                            };
                                        @endphp
                                        <span class="inline-block px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter border {{ $roleColor }} shadow-sm">
        {{ $user->role }}
    </span>
                                    </td>

                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('users.show', $user->id) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Удалить?')">
                                                @csrf @method('DELETE')
                                                <button class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
