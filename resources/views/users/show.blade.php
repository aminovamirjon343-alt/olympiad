@extends('layouts.admin')

@section('content')
    {{-- Подключаем Inter для компактности и четкости --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <div class="min-h-screen bg-[#0f172a] py-12 users-page transition-colors duration-500">
        <div class="container mx-auto px-4">
            <style>
                .users-page {
                    font-family: 'Inter', sans-serif !important;
                    -webkit-font-smoothing: antialiased;
                }

                /* --- УМНЫЕ ЗАГОЛОВКИ (Адаптация под фон) --- */
                .dynamic-text-main {
                    color: #ffffff; /* Белый на темном */
                    font-size: 1.5rem !important;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: -0.01em;
                }
                .dynamic-text-sub {
                    color: rgba(255, 255, 255, 0.5);
                    font-size: 10px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                }

                /* Если админка ставит белый фон */
                .bg-white .dynamic-text-main { color: #0f172a !important; }
                .bg-white .dynamic-text-sub { color: #64748b !important; }

                /* --- КАРТОЧКИ --- */
                .profile-card {
                    background: #ffffff !important;
                    border-radius: 1.25rem;
                    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.2);
                    color: #000000 !important;
                }

                /* Маленькие метки (Email, ФИО и т.д.) */
                .info-label {
                    display: block;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    font-size: 0.65rem;
                    font-weight: 800;
                    color: #94a3b8 !important; /* Сделал мягче */
                    margin-bottom: 0.3rem;
                }

                .info-value {
                    color: #0f172a !important;
                    font-size: 0.95rem;
                    font-weight: 700;
                }

                /* СПЕЦИАЛЬНО ДЛЯ EMAIL ПОД АВАТАРОМ (чтобы влезало) */
                .email-compact {
                    font-size: 10px !important;
                    word-break: break-all; /* Перенос, если текст очень длинный */
                    max-width: 100%;
                    display: block;
                    line-height: 1.2;
                    color: #64748b !important;
                }

                .btn-primary-custom {
                    background-color: var(--primary, #f59e0b) !important;
                    color: #ffffff !important;
                    font-weight: 700;
                    text-transform: uppercase;
                    font-size: 0.75rem;
                    padding: 0.7rem 1.5rem !important;
                    border-radius: 0.75rem;
                }

                .avatar-sq {
                    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                    border-radius: 2rem;
                    box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.4);
                }
                .role-badge {
                    background-color: #000000 !important; /* Всегда черный фон */
                    color: #ffffff !important;           /* Всегда белый текст внутри */
                    padding: 0.5rem 1.5rem !important;
                    border-radius: 0.75rem;
                    font-size: 9px !important;
                    font-weight: 900;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    display: inline-block;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                }
                .avatar-sq {
                    background: var(--primary, #f59e0b) !important;
                    border-radius: 2rem;
                    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.2);
                    transition: background 0.3s ease; /* Плавная смена цвета */
                }
                .avatar-sq {
                    background: linear-gradient(135deg, var(--primary, #f59e0b) 0%, #000000 150%) !important;
                    border-radius: 2rem;
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                }
            </style>

            <div class="max-w-5xl mx-auto mb-8 flex items-end justify-between">
                <div>
                    <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase text-amber-500 mb-3 hover:opacity-70 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                        <span data-i18n="backBtn">Назад</span>
                    </a>
                </div>

                <a href="{{ route('users.edit', $user->id) }}" class="btn-primary-custom flex items-center gap-2 shadow-lg">
                    <span data-i18n="editBtn">Редактировать</span>
                </a>
            </div>

            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Левая колонка --}}
                <div class="lg:col-span-1">
                    <div class="profile-card p-8 text-center h-full flex flex-col justify-center">
                        <div class="w-24 h-24 avatar-sq mx-auto mb-6 flex items-center justify-center text-white text-5xl font-black">
                            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                        </div>
                        <h2 class="info-value text-lg mb-1">{{ $user->name }}</h2>

                        <div class="px-2 mb-8">
                            <span class="email-compact font-bold uppercase tracking-tight">
                                {{ $user->email }}
                            </span>
                        </div>

                        <div>
                            <div class="role-badge">
                                @if($user->role == 'admin') <span data-i18n="roleAdm">Администратор</span>
                                @elseif($user->role == 'director') <span data-i18n="roleDir">Директор</span>
                                @else <span data-i18n="roleEmp">Сотрудник</span> @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Правая колонка --}}
                <div class="lg:col-span-2">
                    <div class="profile-card h-full flex flex-col">
                        <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="info-label !mb-0" style="color: #6366f1 !important;" data-i18n="detailsTitle">Детальные данные</h3>
                        </div>

                        <div class="p-10 flex-grow">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-12">
                                <div>
                                    <label class="info-label" data-i18n="labelName">ФИО</label>
                                    <p class="info-value">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="info-label" data-i18n="labelEmail">Email</label>
                                    <p class="info-value">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="info-label" data-i18n="labelPhone">Телефон</label>
                                    <p class="info-value">{{ $user->phone ?? '---' }}</p>
                                </div>
                                <div>
                                    <label class="info-label" data-i18n="labelReg">Регистрация</label>
                                    <p class="info-value">{{ $user->created_at->format('d.m.Y — H:i') }}</p>
                                </div>
                            </div>

                            <div class="mt-12 pt-8 border-t border-slate-100">
                                <label class="info-label" data-i18n="labelStatus">Статус</label>
                                <div class="flex items-center gap-3">
                                    <span class="flex h-3 w-3 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.4)]"></span>
                                    <span class="text-[11px] font-black uppercase text-slate-700" data-i18n="statusActive">Активный доступ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    backBtn: "Назад",
                    editBtn: "Редактировать",
                    detailsTitle: "Детальные данные",
                    labelName: "ФИО",
                    labelEmail: "Email",
                    labelPhone: "Телефон",
                    labelReg: "Регистрация",
                    labelStatus: "Статус",
                    statusActive: "Активный доступ",
                    roleEmp: "Сотрудник",
                    roleDir: "Директор",
                    roleAdm: "Администратор"
                },
                tj: {
                    backBtn: "Бозгашт",
                    editBtn: "Таҳрир кардан",
                    detailsTitle: "Маълумоти муфассал",
                    labelName: "Номи пурра",
                    labelEmail: "Email",
                    labelPhone: "Телефон",
                    labelReg: "Бақайдгирӣ",
                    labelStatus: "Статус",
                    statusActive: "Дастрасии фаъол",
                    roleEmp: "Корманд",
                    roleDir: "Директор",
                    roleAdm: "Администратор"
                },
                en: {
                    backBtn: "Back",
                    editBtn: "Edit Profile",
                    detailsTitle: "Detailed Information",
                    labelName: "Full Name",
                    labelEmail: "Email",
                    labelPhone: "Phone",
                    labelReg: "Registration Date",
                    labelStatus: "Status",
                    statusActive: "Active Access",
                    roleEmp: "Employee",
                    roleDir: "Director",
                    roleAdm: "Administrator"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });
        });
    </script>
@endsection
