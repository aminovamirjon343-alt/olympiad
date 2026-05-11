@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* РАДИКАЛЬНЫЙ ЧЕРНЫЙ ТЕКСТ ДЛЯ ВСЕХ ЭЛЕМЕНТОВ ВНУТРИ КАРТОЧЕК */
        .force-black-text *,
        .force-black-text input,
        .force-black-text select,
        .force-black-text textarea {
            color: #000000 !important;
        }

        /* Дополнительная четкость для инпутов */
        .force-black-text input {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
        }

        .btn-save-custom {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            font-size: 10px !important;
            padding: 10px 20px !important;
            border-radius: 10px !important;
            transition: all 0.2s ease !important;
            border: none !important;
        }
        .btn-save-custom:hover {
            background-color: #f59e0b !important;
        }
    </style>

    <div class="min-h-screen bg-[#0f172a] py-8 font-['Inter'] tracking-tight">
        <div class="container mx-auto px-4 max-w-2xl">

            <div class="mb-6 flex flex-col">
                <a href="{{ route('profile.show') }}" class="group inline-flex items-center gap-2 text-[10px] font-black uppercase text-amber-500 mb-2 transition-all hover:text-amber-400">
                    <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                    <span data-i18n="btnBack">Назад</span>
                </a>
                <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2 text-white">
                    <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                    <span data-i18n="settingsTitle">Настройка</span>
                </h1>
            </div>

            <div class="space-y-6">

                <div class="bg-white rounded-2xl shadow-2xl shadow-black/40 overflow-hidden force-black-text">
                    <div class="bg-slate-100 px-6 py-3 border-b border-slate-200 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-widest" data-i18n="tabProfile">Профиль</span>
                    </div>
                    <div class="p-6 md:p-8 [&_h2]:hidden">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-2xl shadow-black/40 overflow-hidden force-black-text">
                    <div class="bg-slate-100 px-6 py-3 border-b border-slate-200 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-widest" data-i18n="tabSecurity">Безопасность</span>
                    </div>
                    <div class="p-6 md:p-8 [&_h2]:hidden">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <section class="space-y-6">
                    <div style="display: none;">
                        <form id="delete-user-form" method="post" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')
                            <input type="password" name="password">
                        </form>
                    </div>

                    @if($errors->userDeletion->has('password'))
                        <div class="max-w-4xl mx-auto mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-center font-bold animate-pulse" data-i18n="errorPassword">
                            ❌ Неверный пароль. Попробуйте еще раз.
                        </div>
                    @endif

                    <div class="relative group overflow-hidden max-w-4xl mx-auto my-10 font-sans" style="isolation: isolate;">
                        <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-orange-600 rounded-[2rem] blur opacity-0 group-hover:opacity-10 transition duration-500"></div>
                        <div class="relative bg-white rounded-2xl border border-red-200/50 shadow-xl overflow-hidden">
                            <div class="flex flex-col md:flex-row items-center justify-between gap-6 p-6">
                                <div class="flex flex-col items-center md:items-start gap-2">
                                    <div class="flex items-center gap-2.5">
                                        <div class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                                        </div>
                                        <h3 class="text-red-600 text-[11px] font-black uppercase tracking-[0.2em]">Danger Zone</h3>
                                    </div>
                                    <p class="text-black text-[13px] font-bold leading-tight m-0 opacity-80" data-i18n="deleteWarning">
                                        Удаление аккаунта сотрет все данные безвозвратно.
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" onclick="openCustomDeleteModal()" class="bg-red-50 text-red-600 border-2 border-red-600/20 font-black uppercase text-[9px] tracking-widest px-5 py-2 rounded-lg transition-all duration-300 hover:bg-red-600 hover:text-white hover:border-red-600 hover:shadow-[0_0_15px_rgba(220,38,38,0.3)] active:scale-95" data-i18n="btnDeleteAccount">
                                        УДАЛИТЬ АККАУНТ
                                    </button>
                                </div>
                            </div>
                            <div class="h-1 w-full bg-gradient-to-r from-transparent via-red-500/20 to-transparent"></div>
                        </div>
                    </div>

                    <div id="customDeleteModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
                        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-red-100">
                            <div class="p-6 text-center">
                                <h2 class="text-xl font-black text-gray-900 uppercase mb-2" data-i18n="confirmPassTitle">Подтвердите пароль</h2>
                                <p class="text-gray-500 text-sm mb-6" data-i18n="confirmPassDesc">Это действие необратимо. Введите пароль для удаления.</p>
                                <form onsubmit="submitLaravelDeletion(event)">
                                    <input type="password" id="customPasswordInput" data-i18n-placeholder="placeholderPass" placeholder="Ваш пароль" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 outline-none mb-4 text-center text-black">
                                    <div class="flex gap-3">
                                        <button type="button" onclick="closeCustomDeleteModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl uppercase text-[10px]" data-i18n="btnCancel">Отмена</button>
                                        <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white font-bold rounded-xl uppercase text-[10px]" data-i18n="btnConfirmDelete">Удалить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const translations = {
                ru: {
                    btnBack: "Назад",
                    settingsTitle: "Настройка",
                    tabProfile: "Профиль",
                    tabSecurity: "Безопасность",
                    deleteWarning: "Удаление аккаунта сотрет все данные безвозвратно.",
                    btnDeleteAccount: "УДАЛИТЬ АККАУНТ",
                    confirmPassTitle: "Подтвердите пароль",
                    confirmPassDesc: "Это действие необратимо. Введите пароль для удаления.",
                    placeholderPass: "Ваш пароль",
                    btnCancel: "Отмена",
                    btnConfirmDelete: "Удалить",
                    errorPassword: "❌ Неверный пароль. Попробуйте еще раз."
                },
                tj: {
                    btnBack: "Бозгашт",
                    settingsTitle: "Танзимот",
                    tabProfile: "Профил",
                    tabSecurity: "Амният",
                    deleteWarning: "Нест кардани аккаунт ҳамаи маълумотро ба таври ҳамешагӣ нест мекунад.",
                    btnDeleteAccount: "НЕСТ КАРДАНИ АККАУНТ",
                    confirmPassTitle: "Рамзро тасдиқ кунед",
                    confirmPassDesc: "Ин амал бозгашт надорад. Барои нест кардан рамзро ворид кунед.",
                    placeholderPass: "Рамзи шумо",
                    btnCancel: "Бекор кардан",
                    btnConfirmDelete: "Нест кардан",
                    errorPassword: "❌ Рамз нодуруст аст. Дубора кӯшиш кунед."
                },
                en: {
                    btnBack: "Back",
                    settingsTitle: "Settings",
                    tabProfile: "Profile",
                    tabSecurity: "Security",
                    deleteWarning: "Deleting your account will erase all data permanently.",
                    btnDeleteAccount: "DELETE ACCOUNT",
                    confirmPassTitle: "Confirm Password",
                    confirmPassDesc: "This action is irreversible. Enter your password to delete.",
                    placeholderPass: "Your password",
                    btnCancel: "Cancel",
                    btnConfirmDelete: "Delete",
                    errorPassword: "❌ Incorrect password. Please try again."
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (t[key]) el.placeholder = t[key];
            });
        });

        function openCustomDeleteModal() {
            const m = document.getElementById('customDeleteModal');
            m.style.display = 'flex';
            setTimeout(() => document.getElementById('customPasswordInput').focus(), 100);
        }

        function closeCustomDeleteModal() {
            document.getElementById('customDeleteModal').style.display = 'none';
            document.getElementById('customPasswordInput').value = '';
        }

        function submitLaravelDeletion(e) {
            e.preventDefault();
            const password = document.getElementById('customPasswordInput').value;
            const realForm = document.getElementById('delete-user-form');
            if (realForm) {
                realForm.querySelector('input[name="password"]').value = password;
                realForm.submit();
            }
        }

        window.onclick = function(event) {
            const m = document.getElementById('customDeleteModal');
            if (event.target == m) closeCustomDeleteModal();
        }

        document.querySelectorAll('button[type="submit"]').forEach(btn => {
            if(!btn.classList.contains('bg-red-600')) btn.classList.add('btn-save-custom');
        });
    </script>
@endsection
