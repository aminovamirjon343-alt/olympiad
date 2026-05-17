@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#0f172a] py-12 users-page">
        <div class="container mx-auto px-4 flex flex-col items-center">
            <style>
                .users-page {
                    font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", sans-serif !important;
                    -webkit-font-smoothing: antialiased;
                }

                .form-card {
                    background: #ffffff !important;
                    color: #000000 !important;
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

                .input-custom {
                    background-color: #f2f2f7 !important;
                    border: 1px solid #d1d1d6 !important;
                    color: #000000 !important;
                    font-size: 0.95rem !important;
                    font-weight: 400 !important;
                    padding: 0.85rem 1rem !important;
                    border-radius: 0.6rem !important;
                    transition: all 0.2s ease;
                }

                .input-custom option {
                    color: #000000 !important;
                    background-color: #ffffff !important;
                }

                .input-custom:focus {
                    border-color: #3b82f6 !important;
                    background-color: #ffffff !important;
                    outline: none;
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

                .icon-dark { color: #000000 !important; opacity: 0.6; }
            </style>

            <div class="w-full max-w-2xl mb-8">
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-4 transition hover:text-white">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                    <span data-i18n="backToList">Назад к списку</span>
                </a>

                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-2 opacity-70" data-i18n="{{ isset($user) ? 'editDesc' : 'createDesc' }}">
                    {{ isset($user) ? 'Изменение данных аккаунта' : 'Регистрация в системе управления' }}
                </p>
            </div>

            <div class="form-card p-10">
                <form method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" class="space-y-6">
                    @csrf
                    @if(isset($user)) @method('PUT') @endif

                    {{-- Поле имени --}}
                    <div>
                        <label class="field-label" data-i18n="labelFullName">Полное имя</label>
                        <input name="name" type="text" required class="w-full input-custom shadow-sm"
                               value="{{ $user->name ?? '' }}" placeholder="Иван Иванов">
                    </div>

                    {{-- Блок: Email и Телефон --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label" data-i18n="labelEmail">Email адрес</label>
                            <input name="email" type="email" required class="w-full input-custom shadow-sm"
                                   value="{{ $user->email ?? '' }}" placeholder="mail@example.com">
                        </div>

                        <div>
                            <label class="field-label" data-i18n="labelPhone">Телефон</label>
                            <input name="phone" type="text" id="phone" required class="w-full input-custom shadow-sm"
                                   value="{{ $user->phone ?? '+992 ' }}" placeholder="+992 00 000 0000">
                        </div>
                    </div>

                    {{-- Блок: Роль и Название компании --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="field-label" data-i18n="labelRole">Роль в системе</label>
                            <div class="relative">
                                <select name="role" class="w-full input-custom appearance-none cursor-pointer pr-10">
                                    <option value="employee" {{ (isset($user) && $user->role == 'employee') ? 'selected' : '' }} data-i18n="roleEmployee">Сотрудник</option>
                                    <option value="director" {{ (isset($user) && $user->role == 'director') ? 'selected' : '' }} data-i18n="roleDirector">Директор</option>
                                    @if(isset($user) && $user->role == 'admin')
                                        <option value="admin" selected data-i18n="roleAdmin">Администратор</option>
                                    @endif
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none icon-dark">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="field-label" data-i18n="labelCompany">Компания</label>
                            <input name="company" type="text" id="company" required class="w-full input-custom shadow-sm"
                                   value="{{ $user->company ?? '' }}" placeholder="ООО «Вектор»">
                        </div>
                    </div>

                    {{-- Поле пароля --}}
                    <div>
                        <label class="field-label" data-i18n="{{ isset($user) ? 'labelNewPass' : 'labelPass' }}">
                            {{ isset($user) ? 'Новый пароль' : 'Пароль' }}
                        </label>
                        <div class="relative">
                            <input name="password" type="password" id="password" {{ isset($user) ? '' : 'required' }}
                            class="w-full input-custom shadow-sm pr-10" placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center icon-dark hover:opacity-100 transition-opacity">
                                <i id="password-icon" class="bi bi-eye-fill text-lg"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Кнопка отправки формы --}}
                    <div class="pt-6 flex justify-center">
                        <button type="submit" class="btn-save-custom w-full md:w-auto px-8 py-2.5 rounded-lg text-[11px] font-black uppercase tracking-wider shadow-md active:scale-95 transition-all" data-i18n="{{ isset($user) ? 'btnUpdate' : 'btnCreate' }}">
                            {{ isset($user) ? 'Обновить данные' : 'Создать аккаунт' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    backToList: "Назад к списку",
                    newUser: "Новый пользователь",
                    editUser: "Редактировать",
                    createDesc: "Регистрация в системе управления",
                    editDesc: "Изменение данных аккаунта",
                    labelFullName: "Полное имя",
                    labelEmail: "Email адрес",
                    labelPhone: "Телефон",
                    labelRole: "Роль в системе",
                    labelCompany: "Компания",
                    labelPass: "Пароль",
                    labelNewPass: "Новый пароль",
                    roleEmployee: "Сотрудник",
                    roleDirector: "Директор",
                    roleAdmin: "Администратор",
                    btnCreate: "Создать аккаунт",
                    btnUpdate: "Обновить данные",
                    alertPhone: "Пожалуйста, введите номер телефона полностью (9 цифр после +992)",
                    companyPlaceholder: "ООО «Вектор»"
                },
                tj: {
                    backToList: "Бозгашт ба рӯйхат",
                    newUser: "Корбари нав",
                    editUser: "Таҳрири корбар",
                    createDesc: "Бақайдгирӣ дар системаи идоракунӣ",
                    editDesc: "Тағйири маълумоти аккаунт",
                    labelFullName: "Номи пурра",
                    labelEmail: "Суроғаи Email",
                    labelPhone: "Телефон",
                    labelRole: "Нақш дар система",
                    labelCompany: "Ширкат",
                    labelPass: "Рамз",
                    labelNewPass: "Рамзи нав",
                    roleEmployee: "Корманд",
                    roleDirector: "Директор",
                    roleAdmin: "Администратор",
                    btnCreate: "Эҷоди аккаунт",
                    btnUpdate: "Навсозии маълумот",
                    alertPhone: "Лутфан, рақами телефонро пурра ворид кунед (9 рақам пас аз +992)",
                    companyPlaceholder: "ҶДММ «Вектор»"
                },
                en: {
                    backToList: "Back to List",
                    newUser: "New User",
                    editUser: "Edit User",
                    createDesc: "Registration in Management System",
                    editDesc: "Account Details Modification",
                    labelFullName: "Full Name",
                    labelEmail: "Email Address",
                    labelPhone: "Phone",
                    labelRole: "System Role",
                    labelCompany: "Company",
                    labelPass: "Password",
                    labelNewPass: "New Password",
                    roleEmployee: "Employee",
                    roleDirector: "Director",
                    roleAdmin: "Administrator",
                    btnCreate: "Create Account",
                    btnUpdate: "Update Details",
                    alertPhone: "Please enter the full phone number (9 digits after +992)",
                    companyPlaceholder: "Vector LLC"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang] || translations['ru'];

            // Применение переводов для текстов с атрибутом data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // Динамический перевод плейсхолдера для компании
            const companyInput = document.getElementById('company');
            if (companyInput && t.companyPlaceholder) {
                companyInput.placeholder = t.companyPlaceholder;
            }

            const phoneInput = document.getElementById('phone');
            const form = phoneInput.closest('form');
            const prefix = '+992 ';

            // Форматирование и маска телефона
            phoneInput.addEventListener('input', function (e) {
                if (!e.target.value.startsWith(prefix)) e.target.value = prefix;
                let digits = e.target.value.substring(prefix.length).replace(/\D/g, '').substring(0, 9);
                let formatted = '';
                if (digits.length > 0) formatted += digits.substring(0, 2);
                if (digits.length >= 3) formatted += ' ' + digits.substring(2, 5);
                if (digits.length >= 6) formatted += ' ' + digits.substring(5, 7);
                if (digits.length >= 8) formatted += ' ' + digits.substring(7, 9);
                e.target.value = prefix + formatted;
                phoneInput.style.borderColor = '';
            });

            // Валидация перед отправкой формы
            form.addEventListener('submit', function (e) {
                let digitsOnly = phoneInput.value.substring(prefix.length).replace(/\D/g, '');
                if (digitsOnly.length < 9) {
                    e.preventDefault();
                    phoneInput.style.border = '2px solid #ef4444';
                    phoneInput.focus();
                    alert(t.alertPhone);
                }
            });
        });

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
    </script>
@endsection
