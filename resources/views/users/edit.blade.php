@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#0f172a] py-8 users-page">
        <div class="container mx-auto px-4 flex flex-col items-center">
            <style>
                .users-page {
                    font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", sans-serif !important;
                    -webkit-font-smoothing: antialiased;
                }
                .doc-main-title { color: #ffffff !important; }
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
                .btn-primary-custom {
                    background-color: #f59e0b !important;
                    color: #ffffff !important;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }
                .alert-custom {
                    border-left: 4px solid #ef4444;
                    background: #fef2f2;
                    padding: 1rem;
                    border-radius: 0 0.75rem 0.75rem 0;
                    margin-bottom: 1.5rem;
                }
            </style>

            <div class="w-full max-w-2xl mb-6">
                <div class="mb-2">
                    <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-[8px] font-black uppercase tracking-[0.2em] text-amber-500 hover:opacity-80 transition">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="5"><path d="M15 19l-7-7 7-7"/></svg>
                        <span data-i18n="backBtn">Назад</span>
                    </a>
                </div>
                <div>
                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                        <span data-i18n="userTitle">Пользователь</span>
                    </h1>
                </div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1 ml-4 italic">
                    <span data-i18n="userIdText">ID пользователя:</span> #{{ $user->id }}
                </p>
            </div>

            <div class="form-card p-8">
                @if(session('error'))
                    <div class="alert-custom flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0-8V7m0 0a2 2 0 100 4 2 2 0 000-4zm-8 8a9 9 0 1118 0 9 9 0 01-18 0z" />
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest text-red-600">{{ session('error') }}</span>
                    </div>
                @endif

                @if(Auth::user()->role == 'admin' && $user->role == 'admin' && Auth::id() !== $user->id)
                    <div class="text-center py-10">
                        <p class="text-red-500 font-bold uppercase text-[10px] tracking-widest" data-i18n="accessDenied">Доступ ограничен: Админ не может изменять другого админа</p>
                    </div>
                @else
                    <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Основные личные данные (запрещены для роли user) --}}
                        <div class="@if($user->role == 'user') opacity-60 pointer-events-none @endif">
                            <div>
                                <label class="field-label" data-i18n="labelName">Полное имя</label>
                                <input name="name" type="text" id="name_input" value="{{ $user->name }}" required class="w-full input-custom shadow-sm" placeholder="Имя, Фамилия">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label class="field-label" data-i18n="labelEmail">Email адрес</label>
                                    <input name="email" type="email" value="{{ $user->email }}" required class="w-full input-custom shadow-sm" placeholder="mail@example.com">
                                </div>

                                <div>
                                    <label class="field-label" data-i18n="labelPhone">Телефон</label>
                                    <input name="phone" type="text" id="phone" required class="w-full input-custom shadow-sm"
                                           value="{{ $user->phone ?? '+992 ' }}" placeholder="+992 00 000 0000">
                                    <div id="phone-error" style="color: red; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 5px; display: none;" data-i18n="phoneErrorText">
                                        Нужно ввести 9 цифр
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Доступы и Компания --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="field-label" data-i18n="labelRole">Роль / Доступ</label>
                                <div class="relative">
                                    @if(Auth::id() === $user->id || $user->role == 'user')
                                        @php
                                            $roleReadOnlyKey = 'roleEmp';
                                            if ($user->role == 'admin') $roleReadOnlyKey = 'roleAdminStatic';
                                            if ($user->role == 'director') $roleReadOnlyKey = 'roleDir';
                                            if ($user->role == 'user') $roleReadOnlyKey = 'roleUserStatic';
                                        @endphp
                                        <input type="text" id="role_readonly_input" readonly class="w-full input-custom opacity-60 cursor-not-allowed" data-role-readonly="{{ $roleReadOnlyKey }}" value="">
                                        <input type="hidden" name="role" value="{{ $user->role }}">
                                    @else
                                        <select name="role" class="w-full input-custom appearance-none cursor-pointer pr-10">
                                            <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }} data-i18n="roleEmp">Сотрудник</option>
                                            <option value="director" {{ $user->role == 'director' ? 'selected' : '' }} data-i18n="roleDir">Директор</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Поле компании (блокируется, если это user) --}}
                            <div class="@if($user->role == 'user') opacity-60 pointer-events-none @endif">
                                <label class="field-label" data-i18n="labelCompany">Компания</label>
                                <input name="company" id="company_input" type="text" value="{{ $user->company ?? '' }}" required class="w-full input-custom shadow-sm" placeholder="Название компании">
                            </div>
                        </div>

                        {{-- Смена пароля --}}
                        <div class="grid grid-cols-1 @if($user->role == 'user') opacity-60 pointer-events-none @endif">
                            <div>
                                <label class="field-label" data-i18n="labelPass">Смена пароля</label>
                                <div class="relative">
                                    <input name="password" type="password" id="password" class="w-full input-custom pr-10" placeholder="••••••••">
                                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-indigo-600">
                                        <span id="pass-icon-container">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Кнопка сохранения изменений --}}
                        @if($user->role != 'user')
                            <div class="pt-6 flex justify-center">
                                <button type="submit" class="btn-primary-custom flex items-center justify-center gap-3 shadow-lg active:scale-95 transition-all px-10 py-2.5 text-[11px] font-black uppercase tracking-widest" style="border-radius: 10px;" data-i18n="btnSubmit">
                                    Сохранить изменения
                                </button>
                            </div>
                        @endif
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    backBtn: "Назад",
                    userTitle: "Пользователь",
                    userIdText: "ID пользователя:",
                    accessDenied: "Доступ ограничен: Админ не может изменять другого админа",
                    labelName: "Полное имя",
                    labelEmail: "Email адрес",
                    labelPhone: "Телефон",
                    labelRole: "Роль / Доступ",
                    labelCompany: "Компания",
                    labelPass: "Смена пароля",
                    btnSubmit: "Сохранить изменения",
                    phoneErrorText: "Нужно ввести 9 цифр после +992",
                    namePlaceholder: "Имя, Фамилия",
                    companyPlaceholder: "Название компании",
                    roleEmp: "Сотрудник",
                    roleDir: "Директор",
                    roleAdminStatic: "Администратор",
                    roleUserStatic: "USER (Прикасаться запрещено)"
                },
                tj: {
                    backBtn: "Ортга",
                    userTitle: "Корбар",
                    userIdText: "ID-и корбар:",
                    accessDenied: "Дастрасӣ маҳдуд аст: Админ наметавонад админи дигарро тағйир диҳад",
                    labelName: "Номи пурра",
                    labelEmail: "Суроғаи Email",
                    labelPhone: "Телефон",
                    labelRole: "Нақш / Дастрасӣ",
                    labelCompany: "Ширкат",
                    labelPass: "Тағйири рамз",
                    btnSubmit: "Захираи тағйирот",
                    phoneErrorText: "Бояд 9 рақам пас аз +992 ворид кунед",
                    namePlaceholder: "Ном, Насаб",
                    companyPlaceholder: "Номи ширкат",
                    roleEmp: "Корманд",
                    roleDir: "Директор",
                    roleAdminStatic: "Администратор",
                    roleUserStatic: "USER (Дахлнопазир)"
                },
                en: {
                    backBtn: "Back",
                    userTitle: "User Profile",
                    userIdText: "User ID:",
                    accessDenied: "Access Denied: Admin cannot edit another admin",
                    labelName: "Full Name",
                    labelEmail: "Email Address",
                    labelPhone: "Phone Number",
                    labelRole: "Role / Access",
                    labelCompany: "Company",
                    labelPass: "Change Password",
                    btnSubmit: "Save Changes",
                    phoneErrorText: "9 digits required after +992",
                    namePlaceholder: "First, Last Name",
                    companyPlaceholder: "Company Name",
                    roleEmp: "Employee",
                    roleDir: "Director",
                    roleAdminStatic: "Administrator",
                    roleUserStatic: "USER (Protected Role)"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang] || translations['ru'];

            // 1. Обычные текстовые блоки
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // 2. Локализация Readonly поля роли (если оно присутствует)
            const roleReadonlyInput = document.getElementById('role_readonly_input');
            if (roleReadonlyInput) {
                const roleKey = roleReadonlyInput.getAttribute('data-role-readonly');
                if (t[roleKey]) roleReadonlyInput.value = t[roleKey];
            }

            // 3. Локализация динамических плейсхолдеров
            const nameInput = document.getElementById('name_input');
            if (nameInput && t.namePlaceholder) nameInput.placeholder = t.namePlaceholder;

            const companyInput = document.getElementById('company_input');
            if (companyInput && t.companyPlaceholder) companyInput.placeholder = t.companyPlaceholder;

            // Логика маски и валидации телефона
            const phoneInput = document.getElementById('phone');
            const errorDisplay = document.getElementById('phone-error');
            const prefix = '+992 ';

            if (phoneInput) {
                const form = phoneInput.closest('form');

                phoneInput.addEventListener('input', function (e) {
                    if (!e.target.value.startsWith(prefix)) e.target.value = prefix;

                    let digits = e.target.value.substring(prefix.length).replace(/\D/g, '').substring(0, 9);

                    let formatted = '';
                    if (digits.length > 0) formatted += digits.substring(0, 2);
                    if (digits.length >= 3) formatted += ' ' + digits.substring(2, 5);
                    if (digits.length >= 6) formatted += ' ' + digits.substring(5, 7);
                    if (digits.length >= 8) formatted += ' ' + digits.substring(7, 9);

                    e.target.value = prefix + formatted;

                    if (digits.length === 9) {
                        errorDisplay.style.display = 'none';
                        phoneInput.style.borderColor = '';
                    }
                });

                phoneInput.addEventListener('blur', function () {
                    let digits = phoneInput.value.substring(prefix.length).replace(/\D/g, '');

                    if (digits.length < 9 && digits.length > 0) {
                        errorDisplay.style.display = 'block';
                        phoneInput.style.borderColor = '#ef4444';
                    } else {
                        errorDisplay.style.display = 'none';
                        phoneInput.style.borderColor = '';
                    }
                });

                if (form) {
                    form.addEventListener('submit', function (e) {
                        let digits = phoneInput.value.substring(prefix.length).replace(/\D/g, '');
                        if (digits.length < 9) {
                            e.preventDefault();
                            errorDisplay.style.display = 'block';
                            phoneInput.style.borderColor = '#ef4444';
                            phoneInput.focus();
                        }
                    });
                }
            }
        });

        function togglePassword() {
            const input = document.getElementById('password');
            const iconContainer = document.getElementById('pass-icon-container');

            if (input.type === 'password') {
                input.type = 'text';
                iconContainer.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                `;
            } else {
                input.type = 'password';
                iconContainer.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                `;
            }
        }
    </script>
@endsection
