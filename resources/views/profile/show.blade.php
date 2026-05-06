@extends('layouts.admin')

@section('content')
    {{-- Подключаем Inter для премиального вида --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <div class="min-h-screen bg-[#0f172a] py-12 font-inter tracking-tight">
        <div class="container mx-auto px-6">

            <style>
                .font-inter { font-family: 'Inter', sans-serif; }

                /* Заголовки */
                .text-main-title {
                    color: #ffffff;
                    font-size: 1.75rem;
                    font-weight: 900;
                    text-transform: uppercase;
                    letter-spacing: -0.02em;
                }
                .text-sub-title {
                    color: #64748b;
                    font-size: 0.75rem;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                }

                /* Карточки */
                .glass-profile-card {
                    background: #ffffff;
                    border-radius: 2rem;
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                }

                /* Аватар с одной буквой (темная буква на светлом/золотом фоне) */
                .avatar-box {
                    background: var(--primary, #f59e0b);
                    border-radius: 1.5rem;
                    box-shadow: 0 15px 30px rgba(245, 158, 11, 0.2);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: transform 0.3s ease;
                }
                .avatar-box:hover { transform: translateY(-5px); }

                /* Бейджи и Кнопки */
                .badge-black {
                    background: #000000;
                    color: #ffffff;
                    padding: 0.6rem 1.5rem;
                    border-radius: 0.75rem;
                    font-size: 10px;
                    font-weight: 900;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }

                .btn-edit {
                    background: #f59e0b;
                    color: #ffffff;
                    font-weight: 800;
                    text-transform: uppercase;
                    font-size: 0.7rem;
                    letter-spacing: 0.05em;
                    padding: 0.8rem 1.8rem;
                    border-radius: 1rem;
                    transition: all 0.3s ease;
                }
                .btn-edit:hover {
                    background: #ffffff;
                    color: #000000;
                    box-shadow: 0 10px 20px rgba(255,255,255,0.1);
                }

                .info-label {
                    color: #94a3b8;
                    font-size: 0.65rem;
                    font-weight: 800;
                    text-transform: uppercase;
                    margin-bottom: 0.25rem;
                    display: block;
                }
                .info-value {
                    color: #0f172a;
                    font-size: 1rem;
                    font-weight: 700;
                }
            </style>

            <!-- ВЕРХНЯЯ ПАНЕЛЬ -->
            <div class="max-w-5xl mx-auto mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase text-amber-500 mb-4 hover:ml-[-4px] transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                        Назад к списку
                    </a>
                    <h1 class="text-main-title">Карточка <span class="text-amber-500 italic">ID_{{ $user->id }}</span></h1>
                    <p class="text-sub-title font-inter">Системный профиль пользователя</p>
                </div>

                <a href="{{ route('users.edit', $user->id) }}" class="btn-edit shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Редактировать данные
                </a>
            </div>

            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ЛЕВАЯ КОЛОНКА (АВАТАР И СТАТУС) -->
                <div class="lg:col-span-1">
                    <div class="glass-profile-card p-10 text-center flex flex-col items-center">
                        <div class="w-32 h-32 avatar-box mb-6">
                            {{-- Одна большая буква, темная на золотом --}}
                            <span class="text-slate-900 text-6xl font-black italic">
                                {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                            </span>
                        </div>

                        <h2 class="text-2xl font-black text-slate-900 mb-1 leading-tight">{{ $user->name }}</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter mb-8 break-all px-4">
                            {{ $user->email }}
                        </p>

                        <div class="badge-black shadow-lg">
                            {{ $user->role ?? 'Сотрудник' }}
                        </div>
                    </div>
                </div>

                <!-- ПРАВАЯ КОЛОНКА (ДЕТАЛИ) -->
                <div class="lg:col-span-2">
                    <div class="glass-profile-card overflow-hidden h-full">
                        <div class="px-10 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Основная информация</span>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[9px] font-black uppercase text-emerald-600">Active</span>
                            </div>
                        </div>

                        <div class="p-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div>
                                    <label class="info-label">Полное имя</label>
                                    <p class="info-value">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="info-label">Почтовый индекс</label>
                                    <p class="info-value">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="info-label">Контактный телефон</label>
                                    <p class="info-value text-amber-600">
                                        {{ $user->phone ? '+992 ' . $user->phone : 'Не указан' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="info-label">Дата создания</label>
                                    <p class="info-value italic">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>

                            <div class="mt-12 pt-8 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <label class="info-label">Уровень доступа</label>
                                    <p class="text-[11px] font-black text-slate-900 uppercase">Полный административный контроль</p>
                                </div>
                                <div class="opacity-10">
                                    <svg class="w-12 h-12 text-slate-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.47 4.34-2.85 8.14-7 9.3V12H5V6.3l7-3.11v8.8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FOOTER INFO -->
            <div class="max-w-5xl mx-auto mt-10 text-center">
                <p class="text-[9px] font-bold text-slate-600 uppercase tracking-[0.2em]">
                    Последний вход: {{ now()->format('d.m.Y H:i') }} • Данные защищены системой
                </p>
            </div>

        </div>
    </div>
@endsection
