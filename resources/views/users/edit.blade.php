@extends('layouts.admin')

@section('content')
    {{-- Если ты поменяешь bg-[#0f172a] на bg-white, текст ниже сам адаптируется --}}
    <div class="min-h-screen bg-[#0f172a] py-12 users-page transition-colors duration-500">
        <div class="container mx-auto px-4 flex flex-col items-center">
            <style>
                .users-page {
                    font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", sans-serif !important;
                    -webkit-font-smoothing: antialiased;
                }

                /* УМНЫЙ ЗАГОЛОВОК: Он будет инвертировать цвет */
                .main-title {
                    /* Используем специальный класс или переменную для адаптивности */
                    color: white;
                    mix-blend-mode: exclusion; /* Магия: делает текст видимым на любом фоне */
                    font-size: 1.25rem !important;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }

                /* Если фон светлый (например, через родительский класс), меняем цвет принудительно */
                .bg-white .main-title, .bg-slate-50 .main-title { color: #000000 !important; mix-blend-mode: normal; }
                .bg-[#0f172a] .main-title { color: #ffffff !important; }

                /* Аналогично для ID пользователя */
                .id-label {
                    font-size: 9px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 0.2em;
                    margin-top: 4px;
                    font-style: italic;
                }
                .bg-[#0f172a] .id-label { color: #94a3b8; } /* Серый на темном */
                .bg-white .id-label { color: #64748b; }    /* Темно-серый на светлом */

                /* КАРТОЧКА ВСЕГДА БЕЛАЯ — ТЕКСТ ВНУТРИ ВСЕГДА ЧЕРНЫЙ */
                .form-card {
                    background: #ffffff !important;
                    border-radius: 1rem;
                    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
                    width: 100%;
                    max-width: 38rem;
                    border: 1px solid rgba(0,0,0,0.05);
                }

                .field-label {
                    display: block;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    font-size: 0.75rem;
                    font-weight: 900;
                    color: #000000 !important; /* Внутри карточки всегда черный */
                    margin-bottom: 0.5rem;
                }

                .input-custom {
                    background-color: #ffffff !important;
                    border: 2px solid #e2e8f0 !important;
                    color: #000000 !important;
                    font-size: 0.9rem !important;
                    font-weight: 700 !important;
                    padding: 0.8rem 1rem !important;
                    border-radius: 0.6rem !important;
                }

                .input-custom:focus {
                    border-color: #f59e0b !important;
                    outline: none;
                }

                .btn-save {
                    background-color: #f59e0b !important;
                    color: #ffffff !important;
                    font-weight: 900;
                    text-transform: uppercase;
                    font-size: 0.8rem;
                    padding: 1rem !important;
                    border-radius: 0.6rem;
                }
            </style>

            {{-- Блок заголовка --}}
            <div class="w-full max-w-2xl mb-8">
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-amber-500 mb-3 transition hover:text-amber-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                    Назад
                </a>

                {{-- Эти тексты теперь адаптируются --}}
                <h1 class="main-title">Редактировать сотрудника</h1>
                <p class="id-label">ID пользователя: #{{ $user->id }}</p>
            </div>

            <div class="form-card p-10">
                <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="field-label">Полное имя</label>
                        <input name="name" type="text" value="{{ $user->name }}" required
                               class="w-full input-custom shadow-sm" placeholder="Имя...">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Email адрес</label>
                            <input name="email" type="email" value="{{ $user->email }}" required
                                   class="w-full input-custom shadow-sm">
                        </div>

                        <div>
                            <label class="field-label">Телефон</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 font-black text-amber-600 text-[10px]">TJ</span>
                                <input name="phone" type="text" value="{{ $user->phone }}"
                                       class="w-full input-custom pl-12 shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="field-label">Роль / Доступ</label>
                        <select name="role" class="w-full input-custom cursor-pointer appearance-none">
                            <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Сотрудник</option>
                            <option value="director" {{ $user->role == 'director' ? 'selected' : '' }}>Директор</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                        </select>
                    </div>

                    <div class="pt-6 border-t-2 border-primary/10">
                        <button type="submit" class="w-full btn-primary-custom shadow-lg shadow-primary/20 active:scale-[0.98]">
                            Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
