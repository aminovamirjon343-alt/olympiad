@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        .force-black-text *,
        .force-black-text input,
        .force-black-text select,
        .force-black-text textarea {
            color: #000000 !important;
        }

        .force-black-text input {
            background-color: #f8fafc !important;
            border: 2px solid #cbd5e1 !important;
        }

        /* ===== ПОЛНЫЕ BORDER ДЛЯ ВСЕХ ТАБЛИЦ ===== */
        .force-black-text table {
            width: 100% !important;
            border-collapse: collapse !important;
            border: 2px solid #cbd5e1 !important;
            border-radius: 18px !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }

        .force-black-text table thead {
            background: #f1f5f9 !important;
        }

        .force-black-text table th {
            border: 2px solid #cbd5e1 !important;
            padding: 16px !important;
            font-size: 12px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
            background: #f8fafc !important;
            color: #0f172a !important;
        }

        .force-black-text table td {
            border: 2px solid #e2e8f0 !important;
            padding: 16px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            background: #ffffff !important;
            color: #0f172a !important;
        }

        .force-black-text table tr:hover td {
            background: #f8fafc !important;
            transition: 0.2s ease;
        }

        /* INPUT / SELECT / TEXTAREA */
        .force-black-text input,
        .force-black-text select,
        .force-black-text textarea {
            border-radius: 14px !important;
            padding: 14px 16px !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            transition: all 0.2s ease !important;
        }

        .force-black-text input:focus,
        .force-black-text select:focus,
        .force-black-text textarea:focus {
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15) !important;
            background: #ffffff !important;
        }

        /* LABEL */
        .force-black-text label {
            font-size: 12px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
            color: #334155 !important;
            margin-bottom: 8px !important;
            display: block !important;
        }

        /* КНОПКИ */
        .btn-save-custom {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            padding: 14px 26px !important;
            border-radius: 14px !important;
            transition: all 0.2s ease !important;
            border: 2px solid #0f172a !important;
            letter-spacing: 0.08em !important;
        }

        .btn-save-custom:hover {
            background-color: #f59e0b !important;
            border-color: #f59e0b !important;
            transform: translateY(-1px);
        }

        /* FORM BLOCKS */
        .force-black-text section {
            border: 2px solid #e2e8f0 !important;
            border-radius: 24px !important;
            padding: 28px !important;
            background: #ffffff !important;
        }

        .force-black-text .max-w-xl,
        .force-black-text .max-w-lg,
        .force-black-text .max-w-md {
            max-width: 100% !important;
        }

        /* ERROR */
        .force-black-text .text-red-600 {
            font-weight: 800 !important;
        }
    </style>

    <div class="min-h-screen bg-[#0f172a] py-12 font-['Inter'] tracking-tight">
        <div class="container mx-auto px-4 max-w-3xl">

            <div class="mb-10 flex flex-col">
                <a href="{{ route('profile.show') }}"
                   class="group inline-flex items-center gap-2 text-[11px] font-black uppercase text-amber-500 mb-4 transition-all hover:text-amber-400">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24"
                         stroke-width="4">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>

                    <span data-i18n="btnBack">Назад</span>
                </a>
            </div>

            <div class="space-y-10">

                <!-- PROFILE -->
                <div class="bg-white rounded-[2rem] shadow-2xl shadow-black/50 overflow-hidden force-black-text border-2 border-slate-200">
                    <div class="bg-slate-100 px-8 py-5 border-b-2 border-slate-300 flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>

                        <span class="text-[12px] font-black uppercase text-slate-500 tracking-[0.15em]"
                              data-i18n="tabProfile">
                            Профиль
                        </span>
                    </div>

                    <div class="p-8 md:p-12 [&_h2]:hidden">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- SECURITY -->
                <div class="bg-white rounded-[2rem] shadow-2xl shadow-black/50 overflow-hidden force-black-text border-2 border-slate-200">
                    <div class="bg-slate-100 px-8 py-5 border-b-2 border-slate-300 flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-indigo-500"></div>

                        <span class="text-[12px] font-black uppercase text-slate-500 tracking-[0.15em]"
                              data-i18n="tabSecurity">
                            Безопасность
                        </span>
                    </div>

                    <div class="p-8 md:p-12 [&_h2]:hidden">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- DANGER ZONE -->
                <section class="space-y-6">
                    <div style="display: none;">
                        <form id="delete-user-form"
                              method="post"
                              action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')

                            <input type="password" name="password">
                        </form>
                    </div>

                    @if($errors->userDeletion->has('password'))
                        <div class="max-w-4xl mx-auto mb-4 p-5 bg-red-50 border-2 border-red-200 text-red-600 rounded-2xl text-center font-black animate-pulse"
                             data-i18n="errorPassword">
                            ❌ Неверный пароль. Попробуйте еще раз.
                        </div>
                    @endif

                    <div class="relative group overflow-hidden max-w-4xl mx-auto my-12"
                         style="isolation: isolate;">

                        <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-orange-600 rounded-[2.5rem] blur opacity-20 transition duration-500"></div>

                        <div class="relative bg-white rounded-[2rem] border-2 border-red-200 shadow-2xl overflow-hidden">
                            <div class="flex flex-col md:flex-row items-center justify-between gap-8 p-10">

                                <div class="flex flex-col items-center md:items-start gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex h-4 w-4">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600"></span>
                                        </div>

                                        <h3 class="text-red-600 text-[13px] font-black uppercase tracking-[0.2em]">
                                            Danger Zone
                                        </h3>
                                    </div>

                                    <p class="text-black text-[15px] font-bold leading-relaxed m-0 opacity-80"
                                       data-i18n="deleteWarning">
                                        Удаление аккаунта сотрет все данные безвозвратно.
                                    </p>
                                </div>

                                <div class="flex-shrink-0">
                                    <button type="button"
                                            onclick="openCustomDeleteModal()"
                                            class="bg-red-50 text-red-600 border-2 border-red-200 font-bold uppercase text-[10px] tracking-wider px-4 py-2 rounded-xl transition-all duration-300 hover:bg-red-600 hover:text-white hover:border-red-600 active:scale-95"
                                            data-i18n="btnDeleteAccount">
                                        Удалить аккаунт
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- MODAL -->
                    <div id="customDeleteModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 bg-black/80 backdrop-blur-md" style="display: none;">
                        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl p-10 border border-red-100">
                            <div class="text-center">
                                <h2 class="text-2xl font-black text-gray-900 uppercase mb-4" data-i18n="confirmPassTitle">Подтвердите пароль</h2>
                                <p class="text-gray-500 text-base mb-8" data-i18n="confirmPassDesc">Это действие необратимо. Введите пароль для удаления.</p>
                                <form onsubmit="submitLaravelDeletion(event)">
                                    <input type="password" id="customPasswordInput" data-i18n-placeholder="placeholderPass" placeholder="Ваш пароль" required class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-red-500 outline-none mb-4 text-center text-sm text-black">

                                    <div class="flex gap-2 justify-center">
                                        <button type="button" onclick="closeCustomDeleteModal()" class="px-4 py-1.5 bg-gray-100 text-gray-600 font-bold rounded-lg uppercase text-[9px] tracking-wider" data-i18n="btnCancel">
                                            Отмена
                                        </button>
                                        <button type="submit" class="px-4 py-1.5 bg-red-600 text-white font-bold rounded-lg uppercase text-[9px] tracking-wider" data-i18n="btnConfirmDelete">
                                            Удалить
                                        </button>
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

            // Основной перевод текста
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // Перевод плейсхолдеров
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (t[key]) el.placeholder = t[key];
            });

            // Применяем кастомные стили к кнопкам Laravel форм, если они не являются кнопками удаления
            document.querySelectorAll('button[type="submit"]').forEach(btn => {
                if (!btn.classList.contains('bg-red-600')) {
                    btn.classList.add('btn-save-custom');
                }
            });
        });

        function openCustomDeleteModal() {
            const m = document.getElementById('customDeleteModal');
            m.style.display = 'flex';
            setTimeout(() => { document.getElementById('customPasswordInput').focus(); }, 100);
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
    </script>
@endsection
