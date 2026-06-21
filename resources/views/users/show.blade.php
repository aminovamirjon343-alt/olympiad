{{-- ===== SHOW (users/show.blade.php) ===== --}}
@extends('layouts.admin')

@section('content')
@if(session('error') || session('success'))
<div class="fixed top-4 left-1/2 -translate-x-1/2 w-full max-w-md flex justify-center z-[100] px-4 animate-fade-in-down">
    <div class="{{ session('error') ? 'bg-red-600' : 'bg-emerald-600' }} text-white p-4 rounded-2xl shadow-lg flex items-center gap-3 border border-white/10 w-full">
        @if(session('error'))
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @endif
        <div class="flex-grow">
            <p class="text-[11px] font-black uppercase tracking-widest leading-tight">
                {{ session('error') ?? session('success') }}
            </p>
        </div>
        <button onclick="this.closest('.fixed').remove()" class="opacity-50 hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </div>
</div>
@endif

<div class="min-h-screen py-6 relative overflow-hidden" style="background: #fafaf9;">
    <div class="fixed inset-0 pointer-events-none" style="z-index: 0; opacity: 0.5;">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dotPatternShow" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                    <circle cx="1" cy="1" r="0.8" fill="#a1a1aa" opacity="0.35"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dotPatternShow)"/>
        </svg>
    </div>
    <div class="fixed top-0 left-0 w-[600px] h-[600px] rounded-full pointer-events-none" style="z-index: 0; background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%); filter: blur(60px);"></div>
    <div class="fixed bottom-0 right-0 w-[600px] h-[600px] rounded-full pointer-events-none" style="z-index: 0; background: radial-gradient(circle, rgba(168,85,247,0.07) 0%, transparent 70%); filter: blur(60px);"></div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif !important; }
        .page-wrap { position: relative; z-index: 1; }

        @keyframes fade-in-down {
            0% { opacity: 0; transform: translate(-50%, -20px); }
            100% { opacity: 1; transform: translate(-50%, 0); }
        }
        .animate-fade-in-down { animation: fade-in-down 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        .top-bar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(228, 228, 231, 0.6);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
        }
        .top-bar-left { display: flex; align-items: center; gap: 0.85rem; }
        .top-bar-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }
        .top-bar-icon svg { width: 20px; height: 20px; color: #ffffff; }
        .top-bar-title { font-size: 1.05rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; line-height: 1.2; }
        .top-bar-subtitle { font-size: 0.7rem; color: #71717a; font-weight: 500; margin-top: 1px; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.45rem 0.9rem;
            background: #ffffff;
            color: #52525b;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.2s;
            border: 1px solid #e4e4e7;
        }
        .btn-back:hover {
            border-color: #a1a1aa;
            color: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }
        .btn-back svg { width: 12px; height: 12px; }

        .btn-edit {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.5rem 1rem;
            background: #0f172a;
            color: #ffffff;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
            border: 1px solid #0f172a;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
        }
        .btn-edit:hover {
            background: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.3);
        }
        .btn-edit svg { width: 14px; height: 14px; }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
            margin-top: 0.75rem;
        }
        @media (min-width: 1024px) {
            .profile-grid { grid-template-columns: 1fr 2fr; }
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(228, 228, 231, 0.6);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .profile-left {
            padding: 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .avatar-sq {
            width: 96px; height: 96px;
            border-radius: 18px;
            background: linear-gradient(135deg, #e4e4e7 0%, #d4d4d8 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; font-weight: 800; color: #71717a;
            overflow: hidden;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .avatar-sq img { width: 100%; height: 100%; object-fit: cover; }

        .profile-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.35rem;
            letter-spacing: -0.01em;
        }
        .profile-email {
            font-size: 0.75rem;
            color: #71717a;
            font-weight: 500;
            margin-bottom: 1.25rem;
            word-break: break-all;
        }

        .role-badge {
            background: #0f172a;
            color: #ffffff;
            padding: 0.45rem 1.25rem;
            border-radius: 8px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            display: inline-block;
        }

        .profile-right {
            display: flex;
            flex-direction: column;
        }
        .profile-right-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f4f4f5;
            background: #fafafa;
        }
        .profile-right-header h3 {
            font-size: 0.7rem;
            font-weight: 700;
            color: #52525b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 0;
        }
        .profile-right-body {
            padding: 1.75rem;
            flex-grow: 1;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem 2rem;
        }
        @media (min-width: 768px) {
            .info-grid { grid-template-columns: 1fr 1fr; }
        }
        .info-label {
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.6rem;
            font-weight: 700;
            color: #a1a1aa;
            margin-bottom: 0.3rem;
        }
        .info-value {
            color: #0f172a;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .status-section {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f4f4f5;
        }
        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .status-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        .status-text {
            font-size: 0.7rem;
            font-weight: 700;
            color: #059669;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Activity */
        .activity-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(228, 228, 231, 0.6);
            border-radius: 14px;
            padding: 1.5rem;
            margin-top: 0.75rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
            display: inline-block;
        }
        .activity-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }
        .gh-wrapper { overflow-x: auto; scrollbar-width: none; position: relative; }
        .gh-wrapper::-webkit-scrollbar { display: none; }
        .gh-grid { display: inline-grid; grid-template-areas: ". months" "days squares"; grid-template-columns: 45px 1fr; gap: 4px 8px; }
        .gh-months { grid-area: months; display: grid; grid-template-columns: repeat({{ $weeksCount }}, 11px); gap: 3px; font-size: 10px; color: #0f172a; height: 18px; position: relative; }
        .gh-days { grid-area: days; display: grid; grid-template-rows: repeat(7, 11px); gap: 3px; font-size: 9px; color: #71717a; user-select: none; }
        .gh-day-label { display: flex; align-items: center; height: 11px; line-height: 1; font-weight: 600; }
        .gh-squares { grid-area: squares; display: grid; grid-template-rows: repeat(7, 11px); grid-auto-flow: column; grid-auto-columns: 11px; gap: 3px; }
        .sq { width: 11px; height: 11px; border-radius: 2px; background-color: #ffffff; border: 1px solid #e4e4e7; box-sizing: border-box; cursor: pointer; }
        .l1 { background-color: #bbf7d0 !important; border: none; }
        .l2 { background-color: #86efac !important; border: none; }
        .l3 { background-color: #4ade80 !important; border: none; }
        .l4 { background-color: #22c55e !important; border: none; }

        .activity-legend {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            font-size: 0.6rem;
            font-weight: 700;
            color: #71717a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .legend-items { display: flex; align-items: center; gap: 0.25rem; }
    </style>

    <div class="container mx-auto px-4 max-w-5xl page-wrap">
        {{-- Верхняя панель --}}
        <div class="top-bar">
            <div class="top-bar-left">
                <div class="top-bar-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="top-bar-title">{{ $user->name }}</div>
                    <div class="top-bar-subtitle">
                        ID: #{{ $user->id }} · {{ $user->role }}
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                @if(Auth::id() === $user->id || (Auth::user()->role == 'admin' && $user->role !== 'admin'))
                <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span data-i18n="editBtn">Редактировать</span>
                </a>
                @endif
                <a href="{{ route('users.index') }}" class="btn-back">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    <span data-i18n="backBtn">Назад</span>
                </a>
            </div>
        </div>

        {{-- Профиль --}}
        <div class="profile-grid">
            <div class="profile-card profile-left">
                <div class="avatar-sq">
                    @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                    @else
                    {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <h2 class="profile-name">{{ $user->name }}</h2>
                <div class="profile-email">{{ $user->email }}</div>
                <div>
                    <span class="role-badge">
                        @if($user->role == 'admin') <span data-i18n="roleAdm">Администратор</span>
                        @elseif($user->role == 'director') <span data-i18n="roleDir">Директор</span>
                        @else <span data-i18n="roleEmp">Сотрудник</span> @endif
                    </span>
                </div>
            </div>

            <div class="profile-card profile-right">
                <div class="profile-right-header">
                    <h3 data-i18n="detailsTitle">Детальные данные</h3>
                </div>
                <div class="profile-right-body">
                    <div class="info-grid">
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
                            <label class="info-label" data-i18n="labelCompany">Компания</label>
                            <p class="info-value">{{ $user->company ?? '---' }}</p>
                        </div>
                        <div>
                            <label class="info-label" data-i18n="labelReg">Регистрация</label>
                            <p class="info-value">{{ $user->created_at->format('d.m.Y — H:i') }}</p>
                        </div>
                    </div>
                    <div class="status-section">
                        <label class="info-label" data-i18n="labelStatus">Статус</label>
                        <div class="status-indicator">
                            <span class="status-dot"></span>
                            <span class="status-text" data-i18n="statusActive">Активный доступ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Activity Grid --}}
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

        <div class="activity-card">
            <div class="activity-title">
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
                            <span class="month-label" data-month="{{ $month }}" style="position: absolute; left: 0; bottom: 0; white-space: nowrap; color: #71717a; font-weight: 700; text-transform: uppercase; font-size: 9px;">
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

            <div class="activity-legend">
                <span data-i18n="activityLegend">Как мы считаем вклады</span>
                <div class="legend-items">
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

        const lang = localStorage.getItem('admin_lang') || document.documentElement.lang || 'ru';
        const t = translations[lang] || translations['ru'];

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key]) el.textContent = t[key];
        });

        document.querySelectorAll('.month-label').forEach(el => {
            const mIndex = parseInt(el.getAttribute('data-month'), 10);
            if (t.months && t.months[mIndex]) {
                el.textContent = t.months[mIndex];
            }
        });

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

        tippy('[data-tippy-content]', { theme: 'light', animation: 'fade' });

        const observer = new MutationObserver(() => {
            const newLang = localStorage.getItem('admin_lang') || document.documentElement.lang || 'ru';
            const newT = translations[newLang] || translations['ru'];
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (newT[key]) el.textContent = newT[key];
            });
            document.querySelectorAll('.month-label').forEach(el => {
                const mIndex = parseInt(el.getAttribute('data-month'), 10);
                if (newT.months && newT.months[mIndex]) el.textContent = newT.months[mIndex];
            });
        });
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['lang'] });
    });
</script>
@endsection