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

                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
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

        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
        <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

        <div class="activity-card bg-white dark:bg-[#0d1117] p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm mt-8 mx-auto max-w-fit">
            <style>
                .gh-wrapper { overflow-x: auto; scrollbar-width: none; position: relative; }
                .gh-wrapper::-webkit-scrollbar { display: none; }

                .gh-grid {
                    display: inline-grid;
                    grid-template-areas: ". months" "days squares";
                    grid-template-columns: 45px 1fr;
                    gap: 4px 8px;
                }

                .gh-months {
                    grid-area: months;
                    display: grid;
                    grid-template-columns: repeat({{ $weeksCount }}, 11px);
                    gap: 3px;
                    font-size: 10px;
                    color: #7d8590;
                    height: 18px;
                    position: relative;
                }

                .gh-days {
                    grid-area: days;
                    display: grid;
                    grid-template-rows: repeat(7, 11px);
                    gap: 3px;
                    font-size: 9px;
                    color: #7d8590;
                    user-select: none;
                }

                .gh-day-label {
                    display: flex;
                    align-items: center;
                    height: 11px;
                    line-height: 1;
                }

                .gh-squares {
                    grid-area: squares;
                    display: grid;
                    grid-template-rows: repeat(7, 11px);
                    grid-auto-flow: column;
                    grid-auto-columns: 11px;
                    gap: 3px;
                }

                .sq {
                    width: 11px;
                    height: 11px;
                    border-radius: 2px;
                    background-color: #ebedf0;
                    outline: 1px solid rgba(27, 31, 35, 0.06);
                    outline-offset: -1px;
                    cursor: pointer;
                }
                .dark .sq { background-color: #161b22; outline: 1px solid rgba(255, 255, 255, 0.03); }

                .l1 { background-color: #9be9a8 !important; } .l2 { background-color: #40c463 !important; }
                .l3 { background-color: #30a14e !important; } .l4 { background-color: #216e39 !important; }

                .dark .l1 { background-color: #0e4429 !important; } .dark .l2 { background-color: #006d32 !important; }
                .dark .l3 { background-color: #26a641 !important; } .dark .l4 { background-color: #39d353 !important; }

                .sq:hover { outline: 1px solid #24292f; z-index: 10; }
                .dark .sq:hover { outline: 1px solid #adbac7; }

                /* Стили для Tippy (всплывающего окна) */
                .tippy-box[data-theme~='github'] {
                    background-color: #24292f;
                    color: white;
                    font-size: 12px;
                    border-radius: 6px;
                    padding: 2px;
                }
                .dark .tippy-box[data-theme~='github'] {
                    background-color: #6e7681;
                    color: #ffffff;
                }
            </style>

            <div class="mb-4">
                <h3 class="text-[14px] font-semibold text-slate-900 dark:text-slate-100">
                    {{ $activityData ? array_sum($activityData) : 0 }} contributions in {{ $year }}
                </h3>
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
                                    <span style="position: absolute; left: 0; bottom: 0; white-space: nowrap;">
                                {{ $dateInWeek->translatedFormat('M') }}
                            </span>
                                    @php $lastMonth = $month; @endphp
                                @endif
                            </div>
                        @endfor
                    </div>

                    <div class="gh-days select-none">
                        <div class="gh-day-label">Пн</div>
                        <div class="gh-day-label">Вт</div>
                        <div class="gh-day-label">Ср</div>
                        <div class="gh-day-label">Чт</div>
                        <div class="gh-day-label">Пт</div>
                        <div class="gh-day-label">Сб</div>
                        <div class="gh-day-label">Вс</div>
                    </div>

                    <div class="gh-squares">
                        @for($i = 0; $i < ($weeksCount * 7); $i++)
                            @php
                                $day = $startDate->copy()->addDays($i);
                                $isCurrentYear = $day->year == $year;
                                $key = $day->format('Y-m-d');
                                $count = $activityData[$key] ?? 0;
                                $level = $count > 10 ? 4 : ($count > 5 ? 3 : ($count > 2 ? 2 : ($count > 0 ? 1 : 0)));

                                // Формируем текст для подсказки
                                $tooltipText = ($count > 0 ? $count : 'No') . ' contributions on ' . $day->translatedFormat('F j, Y');
                            @endphp

                            @if($isCurrentYear)
                                <div class="sq {{ $level ? 'l'.$level : '' }}"
                                     data-tippy-content="{{ $tooltipText }}">
                                </div>
                            @else
                                <div class="sq opacity-0 pointer-events-none" style="background: transparent; outline: none;"></div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-4 text-[11px] text-[#7d8590]">
                <span>Learn how we count contributions</span>
                <div class="flex items-center gap-1.5">
                    <span>Less</span>
                    <div class="sq" style="width: 10px; height: 10px;"></div>
                    <div class="sq l1" style="width: 10px; height: 10px;"></div>
                    <div class="sq l2" style="width: 10px; height: 10px;"></div>
                    <div class="sq l3" style="width: 10px; height: 10px;"></div>
                    <div class="sq l4" style="width: 10px; height: 10px;"></div>
                    <span>More</span>
                </div>
            </div>
        </div>

        <script>
            // Инициализация подсказок
            tippy('[data-tippy-content]', {
                theme: 'github',
                animation: 'fade',
                duration: [200, 50],
                offset: [0, 10],
            });
        </script>

@endsection

