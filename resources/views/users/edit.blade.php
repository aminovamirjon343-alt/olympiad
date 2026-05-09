@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#0f172a] py-8 users-page">
        <div class="container mx-auto px-4 flex flex-col items-center">
            <style>
                .users-page {
                    font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", sans-serif !important;
                    -webkit-font-smoothing: antialiased;
                }

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
                    max-width: 38rem;
                }

                .field-label {
                    display: block;
                    text-transform: uppercase;
                    letter-spacing: 0.08em;
                    font-size: 0.65rem;
                    font-weight: 800;
                    color: #000000 !important;
                    margin-bottom: 0.4rem;
                }

                /* ТЕКСТ ВНУТРИ: Увеличили размер (как в навбаре), убрали жир (font-normal) */
                .input-custom {
                    background-color: #f2f2f7 !important;
                    border: 1px solid #d1d1d6 !important;
                    color: #000000 !important;
                    font-size: 0.95rem !important; /* Увеличили до ~15px */
                    font-weight: 400 !important; /* Без жира */
                    padding: 0.85rem 1rem !important;
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
                    font-size: 0.8rem;
                    padding: 1rem !important;
                    border-radius: 0.6rem;
                }
            </style>


            <div class="w-full max-w-2xl mb-6">
                {{-- Компактная кнопка НАЗАД наверху --}}
                <div class="mb-2">
                    <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-[8px] font-black uppercase tracking-[0.2em] text-amber-500 hover:opacity-80 transition">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="5"><path d="M15 19l-7-7 7-7"/></svg>
                        Назад
                    </a>
                </div>
                <div>
                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                        User
                    </h1>
                </div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1 ml-4 italic">
                    ID пользователя: #{{ $user->id }}
                </p>
            </div>

            <div class="form-card p-8">
                <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="field-label">Полное имя</label>
                        <input name="name" type="text" value="{{ $user->name }}" required class="w-full input-custom shadow-sm" placeholder="Имя, Фамилия">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Email адрес</label>
                            <input name="email" type="email" value="{{ $user->email }}" required class="w-full input-custom shadow-sm" placeholder="mail@example.com">
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-bold mb-2 text-black dark:text-white">
                                Телефон
                            </label>
                            <input
                                name="phone"
                                type="text"
                                id="phone"
                                required
                                class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:outline-none
               bg-white text-black border-gray-300 focus:ring-blue-500
               dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:ring-blue-400
               shadow-sm transition-colors duration-200"
                                value="{{ old('phone', $user->phone ?? '+992 ') }}"
                                placeholder="+992 00 000 0000"
                            >
                        </div>

                        <script>
                            // Маленький хелпер: если пользователь удаляет всё, возвращаем префикс
                            const phoneInput = document.getElementById('phone');

                            phoneInput.addEventListener('input', function (e) {
                                if (!e.target.value.startsWith('+992 ')) {
                                    e.target.value = '+992 ';
                                }
                            });
                        </script>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Роль / Доступ</label>
                            <div class="relative">
                                <select name="role" class="w-full input-custom appearance-none cursor-pointer pr-10">
                                    <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Сотрудник</option>
                                    <option value="director" {{ $user->role == 'director' ? 'selected' : '' }}>Директор</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="field-label">{{ isset($user) ? 'Смена пароля' : 'Пароль' }}</label>
                            <div class="relative">
                                <input name="password" type="password" id="password" {{ isset($user) ? '' : 'required' }}
                                class="w-full input-custom pr-10" placeholder="••••••••">

                                {{-- Кнопка переключения --}}
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-indigo-600 transition-colors">
                                    {{-- Мы будем менять этот SVG через JS --}}
                                    <span id="pass-icon-container">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-center">
                        <button type="submit" class="btn-primary-custom flex items-center justify-center gap-3 shadow-lg active:scale-95 transition-all px-10 py-2.5 text-[11px] font-black uppercase tracking-widest" style="border-radius: 10px;">
                            Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const container = document.getElementById('pass-icon-container');

            // Иконка "Глаз открыт"
            const eyeOpen = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;

            // Иконка "Глаз закрыт" (зачеркнутый)
            const eyeClosed = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L4.22 4.22m15.56 15.56l-5.656-5.656m0 0a10.002 10.002 0 001.438-2.904c1.274-4.057-2.514-7-6.992-7a9.963 9.963 0 00-2.311.27l5.657 5.657z"/></svg>`;

            if (input.type === 'password') {
                input.type = 'text';
                container.innerHTML = eyeClosed;
            } else {
                input.type = 'password';
                container.innerHTML = eyeOpen;
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.getElementById('phone');
            const form = phoneInput.closest('form'); // Находим форму
            const prefix = '+992 ';

            // 1. Форматирование ввода (твой код)
            phoneInput.addEventListener('input', function (e) {
                if (!e.target.value.startsWith(prefix)) e.target.value = prefix;
                let digits = e.target.value.substring(prefix.length).replace(/\D/g, '').substring(0, 9);
                let formatted = '';
                if (digits.length > 0) formatted += digits.substring(0, 2);
                if (digits.length >= 3) formatted += ' ' + digits.substring(2, 5);
                if (digits.length >= 6) formatted += ' ' + digits.substring(5, 7);
                if (digits.length >= 8) formatted += ' ' + digits.substring(7, 9);
                e.target.value = prefix + formatted;

                // Убираем красную рамку при вводе
                phoneInput.style.borderColor = '';
            });

            // 2. Валидация перед сохранением
            form.addEventListener('submit', function (e) {
                // Считаем только цифры после +992
                let digitsOnly = phoneInput.value.substring(prefix.length).replace(/\D/g, '');

                if (digitsOnly.length < 9) {
                    e.preventDefault(); // ОСТАНАВЛИВАЕМ сохранение

                    // Визуальный сигнал пользователю
                    phoneInput.style.border = '2px solid #ef4444'; // Красный цвет (Tailwind red-500)
                    phoneInput.focus();

                    alert('Пожалуйста, введите номер телефона полностью (9 цифр после +992)');
                }
            });
        });
    </script>
@endsection
