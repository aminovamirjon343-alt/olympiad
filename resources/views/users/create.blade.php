@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#0f172a] py-12 users-page">
        <div class="container mx-auto px-4 flex flex-col items-center">
            <style>
                .users-page {
                    font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", sans-serif !important;
                    -webkit-font-smoothing: antialiased;
                }

                /* Заголовок над формой — белый, так как фон страницы темно-синий */
                .doc-main-title {
                    color: #ffffff !important;
                }

                /* КАРТОЧКА: Всегда белый фон, всегда черный текст внутри */
                .form-card {
                    background: #ffffff !important;
                    color: #000000 !important; /* Принудительно черный текст для всех потомков */
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
                    color: #000000 !important; /* Жестко черный */
                    margin-bottom: 0.4rem;
                }

                .input-custom {
                    background-color: #f2f2f7 !important;
                    border: 1px solid #d1d1d6 !important;
                    color: #000000 !important; /* Текст в инпуте всегда черный */
                    font-size: 0.95rem !important;
                    font-weight: 400 !important;
                    padding: 0.85rem 1rem !important;
                    border-radius: 0.6rem !important;
                    transition: all 0.2s ease;
                }

                /* Цвет текста для выпадающего списка (Option) */
                .input-custom option {
                    color: #000000 !important;
                    background-color: #ffffff !important;
                }

                .input-custom:focus {
                    border-color: #3b82f6 !important;
                    background-color: #ffffff !important;
                    outline: none;
                }

                /* СТРЕЛКИ И ИКОНКИ: Делаем их всегда черными/темными */
                .icon-dark {
                    color: #000000 !important;
                    opacity: 0.6;
                }

                .btn-save-custom {
                    background-color: #000000 !important;
                    color: #ffffff !important;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    font-size: 0.75rem;
                    transition: all 0.2s ease;
                }

                .btn-save-custom:hover {
                    background-color: #1a1a1a !important;
                    transform: translateY(-1px);
                }
            </style>

            <div class="w-full max-w-2xl mb-8">
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-4 transition hover:text-white">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                    Назад к списку
                </a>

                <div>
                    <h1 class="text-2xl font-bold do'Новый пользователь'c-main-title tracking-tight flex items-center gap-3">
                        <span class="w-1.5 h-8 bg-blue-500 rounded-full shadow-[0_0_15px_rgba(59,130,246,0.6)]"></span>
                        {{ isset($user) ? 'Редактировать' : 'Новый пользователь' }}
                    </h1>
                </div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-2 opacity-70">
                    {{ isset($user) ? 'Изменение данных аккаунта' : 'Регистрация в системе управления' }}
                </p>
            </div>

            <div class="form-card p-10">
                <form method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" class="space-y-6">
                    @csrf
                    @if(isset($user)) @method('PUT') @endif

                    <div>
                        <label class="field-label">Полное имя</label>
                        <input name="name" type="text" required class="w-full input-custom shadow-sm"
                               value="{{ $user->name ?? '' }}" placeholder="Иван Иванов">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Email адрес</label>
                            <input name="email" type="email" required class="w-full input-custom shadow-sm"
                                   value="{{ $user->email ?? '' }}" placeholder="mail@example.com">
                        </div>

                        <div>
                            <label class="field-label">Телефон</label>
                            <input name="phone" type="text" id="phone" required class="w-full input-custom shadow-sm"
                                   value="{{ $user->phone ?? '+992 ' }}" placeholder="+992 00 000 0000">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label">Роль в системе</label>
                            <div class="relative">
                                <select name="role" class="w-full input-custom appearance-none cursor-pointer pr-10">
                                    <option value="employee" {{ (isset($user) && $user->role == 'employee') ? 'selected' : '' }}>Сотрудник</option>
                                    <option value="director" {{ (isset($user) && $user->role == 'director') ? 'selected' : '' }}>Директор</option>
                                    <option value="admin" {{ (isset($user) && $user->role == 'admin') ? 'selected' : '' }}>Администратор</option>
                                </select>
                                <!-- Стрелочка селекта: теперь всегда черная -->
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none icon-dark">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="field-label">{{ isset($user) ? 'Новый пароль' : 'Пароль' }}</label>
                            <div class="relative">
                                <input name="password" type="password" id="password" {{ isset($user) ? '' : 'required' }}
                                class="w-full input-custom shadow-sm pr-10" placeholder="••••••••">
                                <!-- Иконка глаза: теперь всегда черная -->
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center icon-dark hover:opacity-100 transition-opacity">
                                    <i id="password-icon" class="bi bi-eye-fill text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-center">
                        <button type="submit" class="btn-save-custom w-full md:w-auto px-8 py-2.5 rounded-lg text-[11px] font-black uppercase tracking-wider shadow-md active:scale-95 transition-all">
                            {{ isset($user) ? 'Обновить данные' : 'Создать аккаунт' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('password-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            }
        }

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
