@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#0f172a] py-12 users-page">
        <div class="container mx-auto px-4 flex flex-col items-center">
            <style>
                .users-page {
                    font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", sans-serif !important;
                    -webkit-font-smoothing: antialiased;
                }

                /* Заголовок: еще чуть компактнее */
                .main-title {
                    color: #ffffff !important;
                    font-size: 1.25rem !important;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }

                .form-card {
                    background: #ffffff !important;
                    border-radius: 1rem;
                    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
                    width: 100%;
                    max-width: 38rem; /* Чуть сузили для аккуратности */
                }

                /* МЕТКИ: сделали меньше (0.6rem) */
                .field-label {
                    display: block;
                    text-transform: uppercase;
                    letter-spacing: 0.08em;
                    font-size: 0.6rem;
                    font-weight: 800;
                    color: #000000 !important;
                    margin-bottom: 0.4rem;
                }

                /* ТЕКСТ ВНУТРИ ИНПУТОВ: уменьшили до 0.85rem */
                .input-custom {
                    background-color: #f2f2f7 !important;
                    border: 1px solid #d1d1d6 !important;
                    color: #000000 !important;
                    font-size: 0.85rem !important;
                    font-weight: 500 !important;
                    padding: 0.75rem 1rem !important;
                    border-radius: 0.6rem !important;
                    transition: all 0.2s ease;
                }

                .input-custom:focus {
                    border-color: #f59e0b !important;
                    background-color: #ffffff !important;
                    outline: none;
                }

                .btn-save {
                    background-color: #f59e0b !important;
                    color: #ffffff !important;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    font-size: 0.75rem; /* Уменьшили текст кнопки */
                    padding: 0.9rem !important;
                    border-radius: 0.6rem;
                }
            </style>

            <div class="w-full max-w-2xl mb-8">
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-[9px] font-bold uppercase tracking-widest text-amber-500 mb-3 transition">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                    Назад
                </a>
                <h1 class="main-title">Новый сотрудник</h1>
                <p class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-1 opacity-70">Регистрация в системе</p>
            </div>

            <div class="form-card p-8">
                <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="field-label">Полное имя</label>
                        <input name="name" type="text" required class="w-full input-custom shadow-sm" placeholder="Имя сотрудника">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="field-label">Email</label>
                            <input name="email" type="email" required class="w-full input-custom shadow-sm" placeholder="mail@example.com">
                        </div>

                        <div>
                            <label class="field-label">Телефон</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-3 font-black text-amber-600 text-[9px]">TJ</span>
                                <input name="phone" type="text" class="w-full input-custom pl-10 shadow-sm" placeholder="92 123 4567">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="field-label">Роль</label>
                        <div class="relative">
                            <select name="role" class="w-full input-custom appearance-none cursor-pointer pr-10">
                                <option value="employee">Сотрудник</option>
                                <option value="director">Директор</option>
                                <option value="admin">Администратор</option>
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="field-label">Пароль</label>
                        <input name="password" type="password" required class="w-full input-custom shadow-sm" placeholder="••••••••">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full btn-save flex items-center justify-center gap-3 shadow-lg shadow-amber-500/10">
                            Создать аккаунт
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
