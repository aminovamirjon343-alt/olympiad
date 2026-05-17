@extends('layouts.admin')

@section('content')
    {{-- Подключаем Inter для компактности и четкости --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Блок всплывающих уведомлений --}}
    @if(session('error') || session('success'))
        <div class="fixed top-4 left-1/2 -translate-x-1/2 w-full max-w-md flex justify-center z-[100] px-4 animate-fade-in-down">
            <div class="{{ session('error') ? 'bg-red-600' : 'bg-emerald-600' }} text-white p-4 rounded-2xl shadow-lg flex items-center gap-3 border border-white/10 w-full">

                @if(session('error'))
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif

                <div class="flex-grow">
                    <p class="text-[11px] font-black uppercase tracking-widest leading-tight">
                        {{ session('error') ?? session('success') }}
                    </p>
                </div>

                <button onclick="this.closest('.fixed').remove()" class="opacity-50 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="min-h-screen bg-[#0f172a] py-12 users-page transition-colors duration-500 font-inter">
        <div class="container mx-auto px-4">
            <style>
                .font-inter { font-family: 'Inter', sans-serif !important; }

                /* Анимация уведомления */
                @keyframes fade-in-down {
                    0% { opacity: 0; transform: translate(-50%, -20px); }
                    100% { opacity: 1; transform: translate(-50%, 0); }
                }
                .animate-fade-in-down {
                    animation: fade-in-down 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                }

                /* --- КАРТОЧКИ --- */
                .profile-card {
                    background: #ffffff !important;
                    border-radius: 1.25rem;
                    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.2);
                    color: #000000 !important;
                }

                .info-label {
                    display: block;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    font-size: 0.65rem;
                    font-weight: 800;
                    color: #94a3b8 !important;
                    margin-bottom: 0.3rem;
                }

                .info-value {
                    color: #0f172a !important;
                    font-size: 0.95rem;
                    font-weight: 700;
                }

                .email-compact {
                    font-size: 10px !important;
                    word-break: break-all;
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
                    transition: all 0.2s ease;
                }

                .btn-primary-custom:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.4);
                }

                .avatar-sq {
                    background: linear-gradient(135deg, var(--primary, #f59e0b) 0%, #000000 150%) !important;
                    border-radius: 2rem;
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                }

                .role-badge {
                    background-color: #000000 !important;
                    color: #ffffff !important;
                    padding: 0.5rem 1.5rem !important;
                    border-radius: 0.75rem;
                    font-size: 9px !important;
                    font-weight: 900;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    display: inline-block;
                }
            </style>

            <div class="max-w-5xl mx-auto mb-8 flex items-end justify-between">
                <div>
                    <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase text-amber-500 mb-3 hover:opacity-70 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                        <span data-i18n="backBtn">Назад</span>
                    </a>
                </div>

                @if(Auth::id() === $user->id || (Auth::user()->role == 'admin' && $user->role !== 'admin'))
                    <a href="{{ route('users.edit', $user->id) }}" class="btn-primary-custom flex items-center gap-2 shadow-lg">
                        <span data-i18n="editBtn">Редактировать</span>
                    </a>
                @endif
            </div>

            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                {{-- Левая колонка --}}
                <div class="lg:col-span-1">
                    <div class="profile-card p-8 text-center h-full flex flex-col justify-center">
                        <div class="w-24 h-24 avatar-sq mx-auto mb-6 flex items-center justify-center text-white text-5xl font-black">
                            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                        </div>
                        <h2 class="info-value text-lg mb-1">{{ $user->name }}</h2>
                        <div class="px-2 mb-8">
                            <span class="email-compact font-bold uppercase tracking-tight">{{ $user->email }}</span>
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
                    <div class="profile-card h-full flex flex-col overflow-hidden">
                        <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="info-label !mb-0" style="color: #6366f1 !important;" data-i18n="detailsTitle">Детальные данные</h3>
                        </div>
                        <div class="p-10 flex-grow text-black">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-12">
                                <div><label class="info-label" data-i18n="labelName">ФИО</label><p class="info-value">{{ $user->name }}</p></div>
                                <div><label class="info-label" data-i18n="labelEmail">Email</label><p class="info-value">{{ $user->email }}</p></div>
                                <div><label class="info-label" data-i18n="labelPhone">Телефон</label><p class="info-value">{{ $user->phone ?? '---' }}</p></div>
                                <div><label class="info-label" data-i18n="labelCompany">Компания</label><p class="info-value">{{ $user->company ?? '---' }}</p></div>
                                <div><label class="info-label" data-i18n="labelReg">Регистрация</label><p class="info-value">{{ $user->created_at->format('d.m.Y — H:i') }}</p></div>
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

            {{-- ACTIVITY GRID --}}
            @php
                use Carbon\Carbon;
                $year = $year ?? now()->year;
                $firstDayOfYear = Carbon::create($year, 1, 1);
                $startDate = $firstDayOfYear->copy()->startOfWeek(Carbon::MONDAY);
                $lastDayOfYear = Carbon::create($year, 12, 31);
                $endDate = $lastDayOfYear->copy()->endOfWeek(Carbon::SUNDAY);
                $totalDays = $startDate->diffInDays($endDate) + 1;
                $weeksCount = ceil($totalDays / 7);
            @endphp

            <div class="activity-card bg-white p-6 rounded-xl border border-slate-200 shadow-sm mx-auto max-w-fit">
                <style>
                    .gh-wrapper { overflow-x: auto; scrollbar-width: none; position: relative; }
                    .gh-wrapper::-webkit-scrollbar { display: none; }
                    .gh-grid { display: inline-grid; grid-template-areas: ". months" "days squares"; grid-template-columns: 45px 1fr; gap: 4px 8px; }
                    .gh-months { grid-area: months; display: grid; grid-template-columns: repeat({{ $weeksCount }}, 11px); gap: 3px; font-size: 10px; color: #000; height: 18px; position: relative; }
                    .gh-days { grid-area: days; display: grid; grid-template-rows: repeat(7, 11px); gap: 3px; font-size: 9px; color: #000; user-select: none; }
                    .gh-day-label { display: flex; align-items: center; height: 11px; line-height: 1; }
                    .gh-squares { grid-area: squares; display: grid; grid-template-rows: repeat(7, 11px); grid-auto-flow: column; grid-auto-columns: 11px; gap: 3px; }
                    .sq { width: 11px; height: 11px; border-radius: 2px; background-color: #ffffff; border: 1px solid #d1d5db; box-sizing: border-box; cursor: pointer; }
                    .l1 { background-color: #9be9a8 !important; border: none; }
                    .l2 { background-color: #40c463 !important; border: none; }
                    .l3 { background-color: #30a14e !important; border: none; }
                    .l4 { background-color: #216e39 !important; border: none; }
                </style>

                <div class="mb-4 font-bold text-sm text-black uppercase tracking-tight">
                    {{ isset($activityData) ? array_sum($activityData) : 0 }} <span data-i18n="activitySummary">вкладов в</span> {{ $year }}
                </div>

                <div class="gh-wrapper">
                    <div class="gh-grid">
                        <div class="gh-months select-none">
                            @php $lastMonth = -1; @endphp
                            @for($w = 0; $w < $weeksCount; $w++)
                                @php
                                    $dateInWeek = $startDate->copy()->addWeeks($w);
                                    $month = $dateInWeek->month;
                                @endphp
                                <div style="grid-column: {{ $w + 1 }}; position: relative;">
                                    @if($month != $lastMonth && $dateInWeek->year == $year)
                                        {{-- Используем data-month для динамической локализации сервером или фронтендом --}}
                                        <span class="month-label" data-month="{{ $month }}" style="position: absolute; left: 0; bottom: 0; white-space: nowrap; color: #000; font-weight: 700; text-transform: uppercase; font-size: 9px;">
                                            {{ $dateInWeek->translatedFormat('M') }}
                                        </span>
                                        @php $lastMonth = $month; @endphp
                                    @endif
                                </div>
                            @endfor
                        </div>

                        <div class="gh-days select-none">
                            <div class="gh-day-label" data-i18n="dayMon">Пн</div>
                            <div class="gh-day-label" data-i18n="dayWed">Ср</div>
                            <div class="gh-day-label" data-i18n="dayFri">Пт</div>
                        </div>

                        <div class="gh-squares">
                            @for($i = 0; $i < ($weeksCount * 7); $i++)
                                @php
                                    $day = $startDate->copy()->addDays($i);
                                    $isCurrentYear = $day->year == $year;
                                    $key = $day->format('Y-m-d');
                                    $count = $activityData[$key] ?? 0;
                                    $level = $count > 10 ? 4 : ($count > 5 ? 3 : ($count > 2 ? 2 : ($count > 0 ? 1 : 0)));
                                @endphp
                                @if($isCurrentYear)
                                    <div class="sq {{ $level ? 'l'.$level : '' }}"
                                         data-count="{{ $count }}"
                                         data-date="{{ $day->format('Y-m-d') }}"
                                         data-day="{{ $day->day }}"
                                         data-month="{{ $day->month }}"
                                         data-year="{{ $day->year }}">
                                    </div>
                                @else
                                    <div class="sq opacity-0 pointer-events-none" style="background: transparent; border: none;"></div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-4 text-[10px] font-bold text-black uppercase tracking-widest">
                    <span data-i18n="activityLegend">Как мы считаем вклады</span>
                    <div class="flex items-center gap-1.5">
                        <span data-i18n="legendLess">Меньше</span>
                        <div class="sq" style="width: 10px; height: 10px;"></div>
                        <div class="sq l1" style="width: 10px; height: 10px;"></div>
                        <div class="sq l2" style="width: 10px; height: 10px;"></div>
                        <div class="sq l3" style="width: 10px; height: 10px;"></div>
                        <div class="sq l4" style="width: 10px; height: 10px;"></div>
                        <span data-i18n="legendMore">Больше</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tippy.js для тултипов --}}
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    backBtn: "Назад", editBtn: "Редактировать", detailsTitle: "Детальные данные",
                    labelName: "ФИО", labelEmail: "Email", labelPhone: "Телефон", labelCompany: "Компания", labelReg: "Регистрация",
                    labelStatus: "Статус", statusActive: "Активный доступ", roleEmp: "Сотрудник",
                    roleDir: "Директор", roleAdm: "Администратор",
                    activitySummary: "вкладов в", activityLegend: "Как мы считаем вклады",
                    legendLess: "Меньше", legendMore: "Больше",
                    dayMon: "Пн", dayWed: "Ср", dayFri: "Пт",
                    noContributions: "Нет вкладов",
                    contributions: "вкладов",
                    onText: "от",
                    months: ["", "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"]
                },
                tj: {
                    backBtn: "Бозгашт", editBtn: "Таҳрир", detailsTitle: "Маълумоти муфассал",
                    labelName: "Номи пурра", labelEmail: "Email", labelPhone: "Телефон", labelCompany: "Ширкат", labelReg: "Бақайдгирӣ",
                    labelStatus: "Статус", statusActive: "Дастрасии фаъол", roleEmp: "Корманд",
                    roleDir: "Директор", roleAdm: "Администратор",
                    activitySummary: "саҳмҳо дар соли", activityLegend: "Чӣ тавр мо саҳмҳоро ҳисоб мекунем",
                    legendLess: "Камтар", legendMore: "Бештар",
                    dayMon: "Дш", dayWed: "Чш", dayFri: "Ҷм",
                    noContributions: "Саҳмҳо нест",
                    contributions: "саҳм",
                    onText: "дар тарихи",
                    months: ["", "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"]
                },
                en: {
                    backBtn: "Back", editBtn: "Edit Profile", detailsTitle: "Detailed Information",
                    labelName: "Full Name", labelEmail: "Email", labelPhone: "Phone", labelCompany: "Company", labelReg: "Registration",
                    labelStatus: "Status", statusActive: "Active Access", roleEmp: "Employee",
                    roleDir: "Director", roleAdm: "Administrator",
                    activitySummary: "contributions in", activityLegend: "Contribution history rules",
                    legendLess: "Less", legendMore: "More",
                    dayMon: "Mon", dayWed: "Wed", dayFri: "Fri",
                    noContributions: "No contributions",
                    contributions: "contributions",
                    onText: "on",
                    months: ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang] || translations['ru'];

            // 1. Обычные статические переводы текстовых узлов
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // 2. Динамический перевод названий месяцев над сеткой
            document.querySelectorAll('.month-label').forEach(el => {
                const mIndex = parseInt(el.getAttribute('data-month'), 10);
                if (t.months && t.months[mIndex]) {
                    el.textContent = t.months[mIndex];
                }
            });

            // 3. Формирование интерактивных тултипов (Tippy.js) с учетом языка
            document.querySelectorAll('.sq[data-count]').forEach(el => {
                const count = parseInt(el.getAttribute('data-count'), 10);
                const day = el.getAttribute('data-day');
                const mIndex = parseInt(el.getAttribute('data-month'), 10);
                const year = el.getAttribute('data-year');

                const monthName = (t.months && t.months[mIndex]) ? t.months[mIndex] : '';

                let tooltipText = '';
                if (count === 0) {
                    tooltipText = `${t.noContributions} ${t.onText} ${day} ${monthName}, ${year}`;
                } else {
                    tooltipText = `${count} ${t.contributions} ${t.onText} ${day} ${monthName}, ${year}`;
                }

                el.setAttribute('data-tippy-content', tooltipText);
            });

            // Инициализация Tippy
            tippy('[data-tippy-content]', {
                theme: 'light',
                animation: 'fade',
            });
        });
    </script>
@endsection
