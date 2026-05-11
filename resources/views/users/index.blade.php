@php
    // Эта логика отмечает тебя живым в кэше, как только ты открываешь список
    if(auth()->check()) {
        \Illuminate\Support\Facades\Cache::put('user-is-online-' . auth()->id(), true, now()->addMinutes(5));
    }
@endphp

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

                /* ТВОЯ СЕРАЯ КАРТОЧКА */
                .table-card {
                    background: #f8fafc !important;
                    border-radius: 1.25rem;
                    border: 1px solid rgba(15, 23, 42, 0.08);
                    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
                    overflow: hidden;
                }

                /* ГРАДИЕНТНАЯ ШАПКА НА PRIMARY COLOR */
                .table-header-primary {
                    background: linear-gradient(90deg, var(--primary, #2563eb) 0%, #3b82f6 100%);
                }

                .users-table td {
                    padding: 0.85rem 1.25rem;
                    font-size: 0.8rem;
                    color: #334155 !important;
                    vertical-align: middle;
                    border-bottom: 1px solid #f1f5f9;
                }

                /* Эффект при наведении */
                .tr-hover:hover {
                    background-color: #ffffff !important;
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
                    <a href="{{ route('users.create') }}" class="btn-primary-system text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                            <path d="M12 4v16m8-8H4"/>
                        </svg>
                        Добавить
                    </a>
                </div>

                {{-- Таблица --}}
                <div class="max-w-6xl">
                    <div class="table-card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left users-table border-collapse">
                                <thead class="table-header-primary">
                                <tr>
                                    <th class="w-12 text-center py-2.5 px-3 text-[9px] font-black text-white/90 uppercase tracking-widest rounded-tl-xl">ID</th>
                                    <th class="py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest">Сотрудник</th>
                                    <th class="py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest">Email / Контакты</th>
                                    <th class="py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest">Телефон</th>
                                    <th class="text-center py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest">Роль</th>
                                    <th class="text-right py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest rounded-tr-xl">Управление</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $index => $user)
                                    <tr class="group tr-hover border-b border-slate-50 last:border-0 transition-colors duration-150">
                                        <td class="text-center font-black text-slate-300 text-[9px] py-2 px-3">
                                            #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>

                                        <td class="py-2 px-3">
                                            <div class="flex items-center gap-2">
                                                <div class="relative">
                                                    {{-- Аватар --}}
                                                    @php
                                                        // Массив приятных цветов для фона и текста
                                                        $colors = [
                                                            ['bg' => '#e0f2fe', 'text' => '#0369a1'], // Голубой
                                                            ['bg' => '#dcfce7', 'text' => '#15803d'], // Зеленый
                                                            ['bg' => '#fef3c7', 'text' => '#b45309'], // Желтый
                                                            ['bg' => '#f3e8ff', 'text' => '#7e22ce'], // Фиолетовый
                                                            ['bg' => '#fee2e2', 'text' => '#b91c1c'], // Красный
                                                            ['bg' => '#ffedd5', 'text' => '#c2410c'], // Оранжевый
                                                            ['bg' => '#e0e7ff', 'text' => '#4338ca'], // Индиго
                                                        ];

                                                        // Выбираем цвет на основе ID (чтобы он был постоянным для юзера)
                                                        $colorIndex = $user->id % count($colors);
                                                        $currentColor = $colors[$colorIndex];
                                                    @endphp

                                                    <div class="w-6 h-6 rounded flex items-center justify-center text-[9px] font-black shadow-sm border border-black/5 transition-all group-hover:scale-110"
                                                         style="background-color: {{ $currentColor['bg'] }}; color: {{ $currentColor['text'] }};">
                                                        {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                                    </div>
                                                    {{-- ТОЧКА ОНЛАЙН --}}
                                                    @if($user->isOnline())
                                                        <span class="absolute -bottom-0.5 -right-0.5 flex h-2.5 w-2.5">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500 border-2 border-white"></span>
                                                        </span>
                                                    @else
                                                        <span class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full bg-slate-300 border-2 border-white"></span>
                                                    @endif
                                                </div>

                                                <div class="flex flex-col">
                                                    <div class="font-bold text-slate-800 tracking-tight text-[11px] leading-none group-hover:text-blue-600 transition-colors">{{ $user->name }}</div>
                                                    <span class="text-[7px] font-black {{ $user->isOnline() ? 'text-green-600' : 'text-slate-400' }} uppercase tracking-widest mt-0.5">
                                                        {{ $user->isOnline() ? 'Онлайн' : 'Офлайн' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="font-medium text-slate-500 text-[10px] py-2 px-3">
                                            {{ $user->email }}
                                        </td>

                                        <td class="py-2 px-3">
                                            <div class="inline-flex items-center gap-1 py-0.5 px-1.5 bg-white rounded border border-slate-100 shadow-sm transition-all group-hover:border-blue-100">
                                                <span class="font-black text-[8px] uppercase" style="color: var(--primary)">TJ</span>
                                                <span class="font-black text-slate-700 text-[9px] tracking-tight">
                                                    {{ $user->phone ?? '00 000 0000' }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="text-center py-2 px-3">
                                            @php
                                                $isAdmin = in_array(strtolower($user->role), ['admin', 'админ']);
                                            @endphp
                                            <span class="inline-block px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-tighter border shadow-sm {{ $isAdmin ? 'text-white' : 'bg-white text-slate-500 border-slate-200' }}"
                                                  style="{{ $isAdmin ? 'background-color: var(--primary); border-color: var(--primary);' : '' }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>

                                        <td class="text-right py-2 px-3">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('users.show', $user->id) }}" class="p-1.5 bg-white border border-slate-100 text-slate-400 hover:text-blue-600 rounded-md shadow-sm transition-all hover:border-blue-200">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Удалить?')">
                                                    @csrf @method('DELETE')
                                                    <button class="p-1.5 bg-white border border-slate-100 text-slate-400 hover:text-red-600 rounded-md shadow-sm transition-all hover:border-red-200">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
    </div>
@endsection
