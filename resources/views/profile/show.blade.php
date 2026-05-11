@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        .font-inter { font-family: 'Inter', sans-serif; }

        /* ГЛАВНОЕ ПРАВИЛО: всё внутри карточек принудительно черное */
        .force-black-text * {
            color: #000000 !important;
        }
        .badge-black {
            background: #000000 !important;
            color: #ffffff !important;
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .force-black-text .no-black,
        .force-black-text .no-black * {
            color: inherit !important;
        }

        .glass-profile-card {
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .avatar-box {
            background: #10b981;
            border-radius: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-label {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            opacity: 0.5;
            margin-bottom: 0.25rem;
            display: block;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 700;
        }
    </style>

    <div class="min-h-screen bg-[#0f172a] py-12 font-inter tracking-tight">
        <div class="container mx-auto px-6">

            <div class="max-w-5xl mx-auto mb-10 flex justify-between items-end">
                <div>
                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2 text-white">
                        <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                        <span data-i18n="profileTitle">Профиль</span>
                    </h1>
                </div>
            </div>

            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="glass-profile-card p-10 text-center flex flex-col items-center force-black-text">
                        <div class="w-32 h-32 avatar-box mb-6 no-black">
                            <span class="text-white text-6xl font-black italic">
                                {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                            </span>
                        </div>

                        <h2 class="text-2xl font-black mb-1 leading-tight">{{ $user->name }}</h2>
                        <p class="text-[8px] font-bold uppercase opacity-60 mb-8 break-all">
                            {{ $user->email }}
                        </p>

                        <div class="badge-black no-black flex items-center justify-center min-w-[120px]"
                             style="color: #ffffff !important;">
                            {{ $user->role ?? 'Employee' }}
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="glass-profile-card overflow-hidden h-full force-black-text">
                        <div class="px-10 py-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                            <span class="text-[10px] font-black uppercase tracking-widest opacity-40" data-i18n="mainInfo">Основная информация</span>
                            <div class="flex items-center gap-2 no-black">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[9px] font-black uppercase text-emerald-600" data-i18n="statusActive">Active</span>
                            </div>
                        </div>

                        <div class="p-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div>
                                    <label class="info-label" data-i18n="labelFullName">Полное имя</label>
                                    <p class="info-value">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="info-label" data-i18n="labelEmail">Почтовый индекс</label>
                                    <p class="info-value">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="info-label" data-i18n="labelPhone">Контактный телефон</label>
                                    <p class="info-value">{{ $user->phone ?? '+992 000 00 00' }}</p>
                                </div>
                                <div>
                                    <label class="info-label" data-i18n="labelCreatedAt">Дата создания</label>
                                    <p class="info-value">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="mt-12 pt-8 border-t border-slate-100">
                                <label class="info-label" data-i18n="labelAccess">Уровень доступа</label>
                                <p class="text-[13px] font-black uppercase leading-tight" data-i18n="accessFull">Полный административный контроль</p>
                            </div>
                            <div class="flex justify-end">
                                <a href="{{ route('profile.edit', $user->id) }}"
                                   class="inline-flex items-center gap-2 bg-gradient-to-tr from-blue-600 to-blue-400 text-black font-black uppercase text-[8px] tracking-[0.1em] px-4 py-2 rounded-lg border border-blue-400/30 hover:from-white hover:to-white transition-all duration-300 active:scale-95 shadow-[0_4px_15px_rgba(59,130,246,0.3)]">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                    </svg>
                                    <span data-i18n="btnEdit">Изменить</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @php
        use Carbon\Carbon;
        $year = now()->year;
        $startDate = Carbon::create($year, 1, 1)->startOfWeek(Carbon::MONDAY);
        $endDate = Carbon::create($year, 12, 31)->endOfWeek(Carbon::SUNDAY);
        $totalDays = $startDate->diffInDays($endDate);
        $weeks = intval($totalDays / 7) + 1;
    @endphp

    <div class="activity-card bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl mt-8 mx-auto max-w-5xl">
        <style>
            .gh-wrapper { overflow-x: auto; scrollbar-width: none; padding-bottom: 4px; }
            .gh-wrapper::-webkit-scrollbar { display: none; }
            .gh-grid { display: inline-grid; grid-template-areas: ". months" "days squares"; grid-template-columns: 32px 1fr; gap: 6px 10px; min-width: max-content; }
            .gh-months { grid-area: months; display: grid; grid-template-columns: repeat({{ $weeks }}, 11px); gap: 3px; font-size: 10px; color: #94a3b8; font-weight: 800; }
            .gh-days { grid-area: days; display: flex; flex-direction: column; justify-content: space-between; height: calc((11px * 7) + (3px * 6)); font-size: 9px; color: #cbd5e1; font-weight: 800; }
            .gh-squares { grid-area: squares; display: grid; grid-template-rows: repeat(7, 11px); grid-auto-flow: column; grid-auto-columns: 11px; gap: 3px; }
            .sq { width: 11px; height: 11px; border-radius: 2px; background-color: #ebedf0; transition: all .15s ease; cursor: pointer; }
            .dark .sq { background-color: #1e293b; }
            .sq:hover { transform: scale(1.2); }
            .l1 { background-color: #9be9a8 !important; }
            .l2 { background-color: #40c463 !important; }
            .l3 { background-color: #30a14e !important; }
            .l4 { background-color: #216e39 !important; }
        </style>

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-800 dark:text-white">
                    <span data-i18n="activityLabel">Активность</span> {{ $year }}
                </h2>
                <p class="text-xs text-slate-400 font-bold mt-1" data-i18n="activityPeriod">Январь → Декабрь</p>
            </div>
        </div>

        <div class="gh-wrapper">
            <div class="gh-grid">
                <div class="gh-months">
                    @for($week = 0; $week < $weeks; $week++)
                        @php $date = $startDate->copy()->addWeeks($week); @endphp
                        <div>@if($week == 0 || $date->day <= 7) {{ $date->format('M') }} @endif</div>
                    @endfor
                </div>
                <div class="gh-days">
                    <span data-i18n="dayMon">Пн</span>
                    <span data-i18n="dayWed">Ср</span>
                    <span data-i18n="dayFri">Пт</span>
                </div>
                <div class="gh-squares">
                    @for($week = 0; $week < $weeks; $week++)
                        @for($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++)
                            @php
                                $day = $startDate->copy()->addDays($week * 7 + $dayOfWeek);
                                if ($day->year != $year) continue;
                                $key = $day->format('Y-m-d');
                                $count = $activityData[$key] ?? 0;
                                $level = $count > 10 ? 4 : ($count > 5 ? 3 : ($count > 2 ? 2 : ($count > 0 ? 1 : 0)));
                            @endphp
                            <div class="sq {{ $level ? 'l'.$level : '' }}"
                                 data-date="{{ $day->format('d.m.Y') }}"
                                 data-count="{{ $count }}"></div>
                        @endfor
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const translations = {
                ru: {
                    profileTitle: "Профиль",
                    mainInfo: "Основная информация",
                    statusActive: "Active",
                    labelFullName: "Полное имя",
                    labelEmail: "Почтовый индекс",
                    labelPhone: "Контактный телефон",
                    labelCreatedAt: "Дата создания",
                    labelAccess: "Уровень доступа",
                    accessFull: "Полный административный контроль",
                    btnEdit: "Изменить",
                    activityLabel: "Активность",
                    activityPeriod: "Январь → Декабрь",
                    dayMon: "Пн", dayWed: "Ср", dayFri: "Пт",
                    actions: "действий"
                },
                tj: {
                    profileTitle: "Профил",
                    mainInfo: "Маълумоти асосӣ",
                    statusActive: "Фаъол",
                    labelFullName: "Номи пурра",
                    labelEmail: "Индекси почта",
                    labelPhone: "Телефони тамос",
                    labelCreatedAt: "Санаи эҷод",
                    labelAccess: "Сатҳи дастрасӣ",
                    accessFull: "Назорати пурраи маъмурӣ",
                    btnEdit: "Тағйир додан",
                    activityLabel: "Фаъолият",
                    activityPeriod: "Январ → Декабр",
                    dayMon: "Дш", dayWed: "Чш", dayFri: "Ҷм",
                    actions: "амалҳо"
                },
                en: {
                    profileTitle: "Profile",
                    mainInfo: "Main Information",
                    statusActive: "Active",
                    labelFullName: "Full Name",
                    labelEmail: "Postal Index",
                    labelPhone: "Contact Phone",
                    labelCreatedAt: "Created At",
                    labelAccess: "Access Level",
                    accessFull: "Full Administrative Control",
                    btnEdit: "Edit",
                    activityLabel: "Activity",
                    activityPeriod: "January → December",
                    dayMon: "Mon", dayWed: "Wed", dayFri: "Fri",
                    actions: "actions"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            // Текстовые переводы
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // Тултипы для графика
            document.querySelectorAll('.sq').forEach(sq => {
                const date = sq.getAttribute('data-date');
                const count = sq.getAttribute('data-count');
                sq.title = `${date} — ${count} ${t.actions || 'actions'}`;
            });
        });
    </script>
@endsection
