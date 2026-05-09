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
                        <a href="{{ route('users.create') }}" class="btn-primary-system text-white px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-md transition-all hover:shadow-lg active:scale-95">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                                <path d="M12 4v16m8-8H4"/>
                            </svg>
                            Добавить
                        </a>
                    </div>

                    {{-- Таблица на сером фоне --}}
                    {{-- Ограничиваем общую ширину, чтобы было как навбар --}}
                    <div class="max-w-5xl">
                        <div class="table-card bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left users-table border-collapse">
                                    <thead>
                                    <tr class="bg-white border-b border-slate-100">
                                        <th class="w-12 text-center py-3 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">ID</th>
                                        <th class="py-3 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Сотрудник</th>
                                        <th class="py-3 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email / Контакты</th>
                                        <th class="py-3 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Телефон</th>
                                        <th class="text-center py-3 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Роль</th>
                                        <th class="text-right py-3 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Управление</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                    @foreach($users as $index => $user)
                                        <tr class="group bg-white border-b border-slate-50 last:border-0 hover:bg-slate-100 transition-colors duration-150">
                                            <td class="text-center font-black text-slate-400 text-[10px] py-2 px-3">
                                                #{{ $index + 1 }}
                                            </td>

                                            <td class="py-2 px-3">
                                                <div class="flex items-center gap-2">
                                                    <div class="relative">
                                                        <div class="w-7 h-7 rounded bg-white flex items-center justify-center text-[10px] font-black text-slate-500 border border-slate-200 shadow-sm transition-colors group-hover:border-slate-300">
                                                            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                                        </div>
                                                        <span class="absolute -bottom-0.5 -right-0.5 w-2 h-2 rounded-full border-2 border-white {{ $user->isOnline() ? 'bg-green-500' : 'bg-slate-300' }}"></span>
                                                    </div>

                                                    <div class="flex flex-col">
                                                        <div class="font-bold text-slate-800 tracking-tight text-[11px] leading-none group-hover:text-black transition-colors">{{ $user->name }}</div>
                                                        <span class="text-[7px] font-black {{ $user->isOnline() ? 'text-green-600' : 'text-slate-400' }} uppercase tracking-widest mt-0.5 text-nowrap">
                                        {{ $user->isOnline() ? 'Онлайн' : 'Офлайн' }}
                                    </span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="font-medium text-slate-500 text-[11px] py-2 px-3">
                                                {{ $user->email }}
                                            </td>

                                            <td class="py-2 px-3">
                                                <div class="inline-flex items-center gap-1 py-0.5 px-1.5 bg-white rounded border border-slate-200 shadow-sm transition-colors group-hover:bg-slate-50">
                                                    <span class="text-indigo-500 font-black text-[8px] uppercase">TJ</span>
                                                    <span class="font-black text-slate-700 text-[9px] tracking-tight text-nowrap">
                                    {{ $user->phone ?? '00 000 0000' }}
                                </span>
                                                </div>
                                            </td>

                                            <td class="text-center py-2 px-3">
                                                @php
                                                    $roleColor = match(strtolower($user->role)) {
                                                        'admin', 'админ' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                                        'editor', 'редактор' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                        default => 'bg-slate-50 text-slate-600 border-slate-200',
                                                    };
                                                @endphp
                                                <span class="inline-block px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-tighter border {{ $roleColor }} shadow-sm">
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
