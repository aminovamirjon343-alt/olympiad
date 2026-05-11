{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <style>--}}
{{--        /* Основной контейнер карточки - фиксируем высоту для однообразия */--}}
{{--        .ana-card {--}}
{{--            background: #ffffff;--}}
{{--            padding: 20px;--}}
{{--            border-radius: 12px;--}}
{{--            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);--}}
{{--            border: 1px solid #e2e8f0;--}}
{{--            height: 100%; /* Занимает всю высоту колонки */--}}
{{--            display: flex;--}}
{{--            flex-direction: column;--}}
{{--            justify-content: space-between;--}}
{{--        }--}}

{{--        .stat-label {--}}
{{--            color: #64748b;--}}
{{--            font-size: 11px;--}}
{{--            text-transform: uppercase;--}}
{{--            font-weight: 800;--}}
{{--            letter-spacing: 0.8px;--}}
{{--        }--}}

{{--        .big-num {--}}
{{--            font-size: 24px;--}}
{{--            font-weight: 700;--}}
{{--            color: #1e293b;--}}
{{--            line-height: 1.2;--}}
{{--        }--}}

{{--        /* Ограничиваем максимальную высоту контейнеров графиков */--}}
{{--        #mainActivityChart, #userActivityChart {--}}
{{--            max-height: 300px;--}}
{{--            width: 100%;--}}
{{--        }--}}

{{--        .progress-custom {--}}
{{--            height: 6px;--}}
{{--            background: #f1f5f9;--}}
{{--            border-radius: 10px;--}}
{{--            margin-top: 10px;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <div class="container-fluid p-4">--}}
{{--        <div class="row g-3">--}}
{{--            <!-- ГРАФИК АКТИВНОСТИ ДОКУМЕНТОВ -->--}}
{{--            <div class="col-12">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="d-flex justify-content-between align-items-center mb-3">--}}
{{--                        <div>--}}
{{--                            <div class="stat-label">Анализ активности</div>--}}
{{--                            <h5 class="m-0 fw-bold" style="color: #1e293b;">Поток документов за 30 дней</h5>--}}
{{--                        </div>--}}
{{--                        <div class="px-3 py-1 rounded-pill" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 11px; border: 1px solid rgba(59, 130, 246, 0.2);">--}}
{{--                            <i class="fas fa-sync-alt fa-spin me-1"></i> Обновление Live--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div id="mainActivityChart"></div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- КАРТОЧКИ KPI ДОКУМЕНТОВ -->--}}
{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="stat-label">Всего документов</div>--}}
{{--                    <div class="big-num mt-2" id="totalDocs">{{ array_sum($statusData) }}</div>--}}
{{--                    <div class="small text-muted mt-1">загружено в систему</div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="stat-label">Доля подписанных</div>--}}
{{--                    @php--}}
{{--                        $total = array_sum($statusData);--}}
{{--                        $rate = $total > 0 ? round(($statusData['signed'] / $total) * 100) : 0;--}}
{{--                    @endphp--}}
{{--                    <div class="big-num mt-2 text-primary" id="effRate">{{ $rate }}%</div>--}}
{{--                    <div class="progress-custom">--}}
{{--                        <div id="effBar" class="progress-bar bg-primary" style="width: {{ $rate }}%"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card" style="border-top: 4px solid #ef4444;">--}}
{{--                    <div class="stat-label text-danger">Отказы (Rejected)</div>--}}
{{--                    <div class="big-num mt-2" id="rejectedCount">{{ $statusData['rejected'] ?? 0 }}</div>--}}
{{--                    <div class="small text-muted mt-1">требуют корректировки</div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- ГРАФИК ПОЛЬЗОВАТЕЛЕЙ -->--}}
{{--            <div class="col-12 mt-3">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="d-flex justify-content-between align-items-center mb-3">--}}
{{--                        <div>--}}
{{--                            <div class="stat-label">Анализ пользователей</div>--}}
{{--                            <h5 class="m-0 fw-bold" style="color: #1e293b;">Динамика аудитории</h5>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex gap-3">--}}
{{--                            <div class="small" style="color: #3b82f6;"><i class="fas fa-circle me-1"></i> Регистрации</div>--}}
{{--                            <div class="small" style="color: #ef4444;"><i class="fas fa-circle me-1"></i> Удаления</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div id="userActivityChart"></div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- КАРТОЧКИ KPI ПОЛЬЗОВАТЕЛЕЙ -->--}}
{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="stat-label">Всего пользователей</div>--}}
{{--                    <div class="big-num mt-2">{{ $totalUsers ?? 0 }}</div>--}}
{{--                    <div class="small text-muted mt-1">активных аккаунтов</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="stat-label">Новых за месяц</div>--}}
{{--                    <div class="big-num mt-2 text-primary">{{ $newThisMonth ?? 0 }}</div>--}}
{{--                    <div class="progress-custom">--}}
{{--                        <div class="progress-bar bg-primary" style="width: 70%"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card" style="border-top: 4px solid #ef4444;">--}}
{{--                    <div class="stat-label text-danger">Churn Rate (Отток)</div>--}}
{{--                    <div class="big-num mt-2">{{ $churnRate ?? 0 }}%</div>--}}
{{--                    <div class="small text-muted mt-1">коэффициент ухода</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>--}}

{{--    <script>--}}
{{--        document.addEventListener("DOMContentLoaded", function() {--}}
{{--            // Данные--}}
{{--            const dailyCounts = {!! json_encode($dailyActivity->pluck('count')->toArray()) !!};--}}
{{--            const dailyLabels = {!! json_encode($dailyActivity->pluck('date')->toArray()) !!};--}}
{{--            const regData = {!! json_encode($userActivity->pluck('reg')->toArray()) !!};--}}
{{--            const delData = {!! json_encode($userActivity->pluck('del')->toArray()) !!};--}}
{{--            const userLabels = {!! json_encode($userActivity->pluck('date')->toArray()) !!};--}}

{{--            // Общий конфиг для графиков (стиль как на фото)--}}
{{--            const commonOptions = {--}}
{{--                chart: {--}}
{{--                    type: 'area',--}}
{{--                    height: 280, // Фиксированная высота--}}
{{--                    toolbar: { show: false },--}}
{{--                    zoom: { enabled: false }--}}
{{--                },--}}
{{--                dataLabels: {--}}
{{--                    enabled: true,--}}
{{--                    offsetY: -10,--}}
{{--                    style: { fontSize: '12px', colors: ["#304758"] },--}}
{{--                    background: { enabled: true, foreColor: '#fff', padding: 4, borderRadius: 4, borderWidth: 0, opacity: 0.9 }--}}
{{--                },--}}
{{--                stroke: { curve: 'smooth', width: 3 },--}}
{{--                markers: { size: 4, strokeWidth: 2, strokeColors: '#fff' },--}}
{{--                grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },--}}
{{--                xaxis: {--}}
{{--                    labels: { style: { colors: '#64748b' } }--}}
{{--                },--}}
{{--                tooltip: { theme: 'light' }--}}
{{--            };--}}

{{--            // Рендер 1--}}
{{--            new ApexCharts(document.querySelector("#mainActivityChart"), {--}}
{{--                ...commonOptions,--}}
{{--                series: [{ name: 'Объем', data: dailyCounts }],--}}
{{--                colors: ['#3b82f6'],--}}
{{--                xaxis: { ...commonOptions.xaxis, categories: dailyLabels },--}}
{{--                fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.05 } }--}}
{{--            }).render();--}}

{{--            // Рендер 2--}}
{{--            new ApexCharts(document.querySelector("#userActivityChart"), {--}}
{{--                ...commonOptions,--}}
{{--                series: [--}}
{{--                    { name: 'Регистрации', data: regData },--}}
{{--                    { name: 'Удаления', data: delData }--}}
{{--                ],--}}
{{--                colors: ['#3b82f6', '#ef4444'],--}}
{{--                xaxis: { ...commonOptions.xaxis, categories: userLabels },--}}
{{--                fill: { type: 'gradient', gradient: { opacityFrom: 0.3, opacityTo: 0 } }--}}
{{--            }).render();--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}



{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <style>--}}
{{--        /* Базовые переменные (Светлая тема) */--}}
{{--        :root {--}}
{{--            --card-bg: #ffffff;--}}
{{--            --text-main: #1e293b;--}}
{{--            --text-muted: #64748b;--}}
{{--            --border-color: #e2e8f0;--}}
{{--            --grid-color: #f1f5f9;--}}
{{--            --page-bg: #f8fafc;--}}
{{--        }--}}

{{--        /* ТЕМНАЯ ТЕМА: Если в админке выбран черный фон (добавляется класс .dark или через системные настройки) */--}}
{{--        /* Добавляем селектор .dark, чтобы принудительно менять цвета, если админка вешает этот класс */--}}
{{--        .dark, .dark-mode, [data-theme='dark'] {--}}
{{--            --card-bg: #1e293b;--}}
{{--            --text-main: #f8fafc;--}}
{{--            --text-muted: #94a3b8;--}}
{{--            --border-color: rgba(255, 255, 255, 0.1);--}}
{{--            --grid-color: rgba(255, 255, 255, 0.05);--}}
{{--            --page-bg: #0f172a;--}}
{{--        }--}}

{{--        /* Автоматическая системная темная тема */--}}
{{--        @media (prefers-color-scheme: dark) {--}}
{{--            :root {--}}
{{--                --card-bg: #1e293b;--}}
{{--                --text-main: #f8fafc;--}}
{{--                --text-muted: #94a3b8;--}}
{{--                --border-color: rgba(255, 255, 255, 0.1);--}}
{{--                --grid-color: rgba(255, 255, 255, 0.05);--}}
{{--                --page-bg: #0f172a;--}}
{{--            }--}}
{{--        }--}}

{{--        /* Применяем переменные ко всем элементам */--}}
{{--        .analytics-container {--}}
{{--            background-color: var(--page-bg);--}}
{{--            transition: background-color 0.3s ease;--}}
{{--        }--}}

{{--        .ana-card {--}}
{{--            background: var(--card-bg);--}}
{{--            padding: 20px;--}}
{{--            border-radius: 12px;--}}
{{--            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);--}}
{{--            border: 1px solid var(--border-color);--}}
{{--            height: 100%;--}}
{{--            display: flex;--}}
{{--            flex-direction: column;--}}
{{--            justify-content: space-between;--}}
{{--            transition: all 0.3s ease;--}}
{{--        }--}}

{{--        .doc-main-title {--}}
{{--            color: var(--text-main) !important;--}}
{{--        }--}}

{{--        .section-divider {--}}
{{--            border-left: 4px solid #3b82f6;--}}
{{--            padding-left: 15px;--}}
{{--            margin: 30px 0 20px 0;--}}
{{--            color: var(--text-main);--}}
{{--            font-weight: 800;--}}
{{--            text-transform: uppercase;--}}
{{--            letter-spacing: 1px;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            gap: 10px;--}}
{{--        }--}}

{{--        .stat-label {--}}
{{--            color: var(--text-muted);--}}
{{--            font-size: 11px;--}}
{{--            text-transform: uppercase;--}}
{{--            font-weight: 800;--}}
{{--            letter-spacing: 0.8px;--}}
{{--        }--}}

{{--        .big-num {--}}
{{--            font-size: 24px;--}}
{{--            font-weight: 700;--}}
{{--            color: var(--text-main);--}}
{{--            line-height: 1.2;--}}
{{--        }--}}

{{--        .small.text-muted {--}}
{{--            color: var(--text-muted) !important;--}}
{{--        }--}}

{{--        .progress-custom {--}}
{{--            height: 6px;--}}
{{--            background: var(--grid-color);--}}
{{--            border-radius: 10px;--}}
{{--            margin-top: 10px;--}}
{{--        }--}}

{{--        #mainActivityChart, #userActivityChart {--}}
{{--            max-height: 300px;--}}
{{--            width: 100%;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <div class="analytics-container container-fluid p-4">--}}
{{--        --}}{{-- Заголовок 1 --}}
{{--        <div class="py-4 px-2">--}}
{{--            <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">--}}
{{--                <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>--}}
{{--                Аналитика документооборота--}}
{{--            </h1>--}}
{{--        </div>--}}

{{--        <div class="row g-3">--}}
{{--            <div class="col-12">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="d-flex justify-content-between align-items-center mb-3">--}}
{{--                        <div>--}}
{{--                            <div class="stat-label">Статистика системы</div>--}}
{{--                            <h5 class="m-0 fw-bold" style="color: var(--text-main);">Поток входящих документов</h5>--}}
{{--                        </div>--}}
{{--                        <div class="px-3 py-1 rounded-pill" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 11px; border: 1px solid rgba(59, 130, 246, 0.2);">--}}
{{--                            <i class="fas fa-sync-alt fa-spin me-1"></i> Live--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div id="mainActivityChart"></div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="stat-label">Всего документов</div>--}}
{{--                    <div class="big-num mt-2">{{ array_sum($statusData) }}</div>--}}
{{--                    <div class="small text-muted mt-1">обработано файлов</div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="stat-label">Доля подписанных</div>--}}
{{--                    @php--}}
{{--                        $total = array_sum($statusData);--}}
{{--                        $rate = $total > 0 ? round(($statusData['signed'] / $total) * 100) : 0;--}}
{{--                    @endphp--}}
{{--                    <div class="big-num mt-2 text-primary">{{ $rate }}%</div>--}}
{{--                    <div class="progress-custom">--}}
{{--                        <div class="progress-bar bg-primary" style="width: {{ $rate }}%"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card" style="border-top: 4px solid #ef4444;">--}}
{{--                    <div class="stat-label text-danger">Отказы (Rejected)</div>--}}
{{--                    <div class="big-num mt-2">{{ $statusData['rejected'] ?? 0 }}</div>--}}
{{--                    <div class="small text-muted mt-1">требуют внимания</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- Заголовок 2 --}}
{{--        <div class="py-6 px-2">--}}
{{--            <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-3">--}}
{{--                <span class="w-1.5 h-7 bg-blue-500 rounded-full shadow-[0_0_12px_rgba(59,130,246,0.6)]"></span>--}}
{{--                Аналитика пользователей--}}
{{--            </h1>--}}
{{--        </div>--}}

{{--        <div class="row g-3">--}}
{{--            <div class="col-12">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="d-flex justify-content-between align-items-center mb-3">--}}
{{--                        <div>--}}
{{--                            <div class="stat-label">Активность базы</div>--}}
{{--                            <h5 class="m-0 fw-bold" style="color: var(--text-main);">Динамика прироста аудитории</h5>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex gap-3">--}}
{{--                            <div class="small" style="color: #3b82f6;"><i class="fas fa-circle me-1"></i> Регистрации</div>--}}
{{--                            <div class="small" style="color: #ef4444;"><i class="fas fa-circle me-1"></i> Удаления</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div id="userActivityChart"></div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="stat-label">Пользователи</div>--}}
{{--                    <div class="big-num mt-2">{{ $totalUsers ?? 0 }}</div>--}}
{{--                    <div class="small text-muted mt-1">активных профилей</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card">--}}
{{--                    <div class="stat-label">Новые (30 дней)</div>--}}
{{--                    <div class="big-num mt-2 text-success">{{ $newThisMonth ?? 0 }}</div>--}}
{{--                    <div class="progress-custom">--}}
{{--                        <div class="progress-bar bg-success" style="width: 70%"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-4">--}}
{{--                <div class="ana-card" style="border-top: 4px solid #ef4444;">--}}
{{--                    <div class="stat-label text-danger">Churn Rate</div>--}}
{{--                    <div class="big-num mt-2">{{ $churnRate ?? 0 }}%</div>--}}
{{--                    <div class="small text-muted mt-1">коэффициент оттока</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>--}}

{{--    <script>--}}
{{--        document.addEventListener("DOMContentLoaded", function() {--}}
{{--            // Функция определения темной темы для ApexCharts--}}
{{--            const checkDarkMode = () => {--}}
{{--                return document.body.classList.contains('dark') ||--}}
{{--                    document.documentElement.classList.contains('dark') ||--}}
{{--                    (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);--}}
{{--            };--}}

{{--            const isDark = checkDarkMode();--}}
{{--            const themeColor = isDark ? '#94a3b8' : '#64748b';--}}
{{--            const tooltipTheme = isDark ? 'dark' : 'light';--}}

{{--            const commonOptions = {--}}
{{--                chart: {--}}
{{--                    type: 'area',--}}
{{--                    height: 280,--}}
{{--                    toolbar: { show: false },--}}
{{--                    zoom: { enabled: false },--}}
{{--                    foreColor: themeColor--}}
{{--                },--}}
{{--                dataLabels: {--}}
{{--                    enabled: true,--}}
{{--                    offsetY: -10,--}}
{{--                    style: { fontSize: '11px', colors: [isDark ? '#f8fafc' : "#304758"] },--}}
{{--                    background: {--}}
{{--                        enabled: true,--}}
{{--                        foreColor: isDark ? '#1e293b' : '#fff',--}}
{{--                        padding: 4,--}}
{{--                        borderRadius: 4,--}}
{{--                        borderWidth: 0,--}}
{{--                        opacity: 0.9--}}
{{--                    }--}}
{{--                },--}}
{{--                stroke: { curve: 'smooth', width: 3 },--}}
{{--                markers: { size: 4, strokeWidth: 2, strokeColors: isDark ? '#1e293b' : '#fff' },--}}
{{--                grid: { borderColor: isDark ? 'rgba(255,255,255,0.05)' : '#f1f5f9', strokeDashArray: 4 },--}}
{{--                tooltip: { theme: tooltipTheme }--}}
{{--            };--}}

{{--            new ApexCharts(document.querySelector("#mainActivityChart"), {--}}
{{--                ...commonOptions,--}}
{{--                series: [{ name: 'Документы', data: {!! json_encode($dailyActivity->pluck('count')) !!} }],--}}
{{--                colors: ['#3b82f6'],--}}
{{--                xaxis: { categories: {!! json_encode($dailyActivity->pluck('date')) !!} },--}}
{{--                fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.05 } }--}}
{{--            }).render();--}}

{{--            new ApexCharts(document.querySelector("#userActivityChart"), {--}}
{{--                ...commonOptions,--}}
{{--                series: [--}}
{{--                    { name: 'Регистрации', data: {!! json_encode($userActivity->pluck('reg')) !!} },--}}
{{--                    { name: 'Удаления', data: {!! json_encode($userActivity->pluck('del')) !!} }--}}
{{--                ],--}}
{{--                colors: ['#3b82f6', '#ef4444'],--}}
{{--                xaxis: { categories: {!! json_encode($userActivity->pluck('date')) !!} },--}}
{{--                fill: { type: 'gradient', gradient: { opacityFrom: 0.3, opacityTo: 0 } }--}}
{{--            }).render();--}}
{{--        });--}}
{{--    </script>--}}



{{--    <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 shadow-2xl border border-slate-200 dark:border-slate-800">--}}
{{--        <div class="flex items-center justify-between mb-6">--}}
{{--            <div>--}}
{{--                <h2 class="text-2xl font-[1000] text-slate-800 dark:text-white uppercase tracking-tight">--}}
{{--                    📊 Аналитика ЭДО--}}
{{--                </h2>--}}
{{--                <p class="text-slate-500 text-sm mt-1 font-bold">--}}
{{--                    Статусы документов системы--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <div class="bg-slate-100 dark:bg-slate-800 px-4 py-2 rounded-2xl border border-black/5">--}}
{{--                <span class="text-slate-400 text-xs font-black uppercase">Всего:</span>--}}
{{--                <span class="text-slate-800 dark:text-white font-black ml-1">{{ array_sum($statusData) }}</span>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="h-[420px] relative">--}}
{{--            <canvas id="statusChart"></canvas>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}

{{--    <script>--}}
{{--        const statusCtx = document.getElementById('statusChart').getContext('2d');--}}

{{--        const totalDocs = {{ array_sum($statusData) }};--}}

{{--        // Плагин для добавления тени под сектора (эффект объема/3D)--}}
{{--        const shadowPlugin = {--}}
{{--            beforeDatasetsDraw(chart) {--}}
{{--                const {ctx} = chart;--}}
{{--                ctx.save();--}}
{{--                ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';--}}
{{--                ctx.shadowBlur = 15;--}}
{{--                ctx.shadowOffsetX = 5;--}}
{{--                ctx.shadowOffsetY = 8;--}}
{{--            },--}}
{{--            afterDatasetsDraw(chart) {--}}
{{--                chart.ctx.restore();--}}
{{--            }--}}
{{--        };--}}

{{--        new Chart(statusCtx, {--}}
{{--            type: 'doughnut',--}}
{{--            data: {--}}
{{--                labels: ['📥 Входящие', '📤 Исходящие', '✅ Подписанные', '⏳ Ожидание'],--}}
{{--                datasets: [{--}}
{{--                    data: [--}}
{{--                        {{ $statusData['incoming'] }},--}}
{{--                        {{ $statusData['outgoing'] }},--}}
{{--                        {{ $statusData['signed'] }},--}}
{{--                        {{ $statusData['pending'] }}--}}
{{--                    ],--}}
{{--                    backgroundColor: ['#3B82F6', '#8B5CF6', '#10B981', '#F59E0B'],--}}
{{--                    borderWidth: 0,--}}
{{--                    hoverOffset: 20, // Увеличил отскок для динамики--}}
{{--                    borderRadius: 15, // Более круглые края секторов--}}
{{--                    spacing: 5 // Небольшой зазор между секторами--}}
{{--                }]--}}
{{--            },--}}
{{--            plugins: [shadowPlugin, {--}}
{{--                // Отрисовка текста в центре--}}
{{--                id: 'centerText',--}}
{{--                afterDraw: (chart) => {--}}
{{--                    const { width, height, ctx } = chart;--}}
{{--                    ctx.save();--}}

{{--                    // Настройка числа--}}
{{--                    ctx.font = "bolder 50px sans-serif";--}}
{{--                    ctx.fillStyle = "#1e293b"; // Темный цвет для светлой темы--}}
{{--                    if (document.documentElement.classList.contains('dark')) ctx.fillStyle = "#ffffff";--}}
{{--                    ctx.textAlign = "center";--}}
{{--                    ctx.textBaseline = "middle";--}}
{{--                    ctx.fillText(totalDocs, width / 2, height / 2 - 10);--}}

{{--                    // Настройка подписи под числом--}}
{{--                    ctx.font = "800 12px sans-serif";--}}
{{--                    ctx.fillStyle = "#64748b";--}}
{{--                    ctx.fillText("ДОКУМЕНТОВ", width / 2, height / 2 + 25);--}}

{{--                    ctx.restore();--}}
{{--                }--}}
{{--            }],--}}
{{--            options: {--}}
{{--                responsive: true,--}}
{{--                maintainAspectRatio: false,--}}
{{--                cutout: '70%',--}}
{{--                plugins: {--}}
{{--                    legend: {--}}
{{--                        position: 'bottom',--}}
{{--                        labels: {--}}
{{--                            padding: 30,--}}
{{--                            usePointStyle: true, // Точки вместо квадратов в легенде--}}
{{--                            pointStyle: 'circle',--}}
{{--                            color: '#64748B',--}}
{{--                            font: { size: 13, weight: '800' }--}}
{{--                        }--}}
{{--                    }--}}
{{--                },--}}
{{--                animation: {--}}
{{--                    animateScale: true, // Анимация увеличения при загрузке--}}
{{--                    animateRotate: true,--}}
{{--                    duration: 1500--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}



@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --bg: #f8fafc; --card: #ffffff; --text: #0f172a; --muted: #94a3b8;
            --border: #e2e8f0; --grid: #f1f5f9; --card-hover: #f8fafc;
        }
        .dark, .dark-mode, [data-theme='dark'] {
            --bg: #0b1120; --card: #151d30; --text: #f1f5f9; --muted: #64748b;
            --border: rgba(255,255,255,.08); --grid: rgba(255,255,255,.04); --card-hover: #1a2540;
        }
        @media(prefers-color-scheme:dark){
            :root{--bg:#0b1120;--card:#151d30;--text:#f1f5f9;--muted:#64748b;--border:rgba(255,255,255,.08);--grid:rgba(255,255,255,.04)}
        }
        body{background:var(--bg);color:var(--text)}
        .dash{font-family:'Inter',sans-serif}
        .acard{
            background:var(--card);border:1px solid var(--border);border-radius:16px;
            padding:24px;transition:all .3s ease;position:relative;overflow:hidden;
        }
        .acard:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(0,0,0,.08);border-color:#3b82f640}
        .acard::before{
            content:'';position:absolute;top:0;left:0;right:0;height:3px;
            background:linear-gradient(90deg,#3b82f6,#8b5cf6,#3b82f6);opacity:0;transition:opacity .3s;
        }
        .acard:hover::before{opacity:1}
        .slabel{font-size:11px;text-transform:uppercase;letter-spacing:1.2px;color:var(--muted);font-weight:800}
        .bignum{font-size:28px;font-weight:800;color:var(--text);line-height:1.1}
        .section-title{
            font-size:20px;font-weight:900;color:var(--text);letter-spacing:-.5px;
            display:flex;align-items:center;gap:12px;
        }
        .section-title .accent{width:4px;height:28px;background:#3b82f6;border-radius:4px;box-shadow:0 0 12px #3b82f680}
        .progbg{height:6px;background:var(--grid);border-radius:99px;margin-top:8px;overflow:hidden}
        .progbg .fill{height:100%;border-radius:99px;transition:width 1s ease}
        #mainChart,#userChart{width:100%;max-height:280px}
        #statusChart{width:100%;max-height:360px}
        .badge-live{
            display:inline-flex;align-items:center;gap:6px;padding:4px 14px;border-radius:99px;
            background:#3b82f618;color:#3b82f6;font-size:11px;font-weight:700;border:1px solid #3b82f630;
        }
        .badge-live i{font-size:10px}
        .legend-dot{width:10px;height:10px;border-radius:50%;display:inline-block}
    </style>

    <div class="container-fluid p-4 dash">
        {{-- Документы --}}
        <div class="section-title mb-4"><div class="accent"></div>Аналитика документооборота</div>

        <div class="row g-3">
            <div class="col-12">
                <div class="acard">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div><div class="slabel">Статистика системы</div><h6 class="mb-0 fw-bold" style="color:var(--text)">Поток входящих документов</h6></div>
                        <div class="badge-live"><i class="fas fa-sync-alt fa-spin"></i> Live</div>
                    </div>
                    <div id="mainChart"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard">
                    <div class="slabel">Всего документов</div>
                    <div class="bignum mt-2">{{ $totalDocuments ?? 0 }}</div>
                    <small style="color:var(--muted)">обработано файлов</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard">
                    <div class="slabel">Доля подписанных</div>
                    @php
                        $totalMonth = array_sum($statusData);
                        $rate = $totalMonth > 0 ? round(($statusData['signed'] / $totalMonth) * 100) : 0;
                    @endphp
                    <div class="bignum mt-2" style="color:#3b82f6">{{ $rate }}%</div>
                    <div class="progbg"><div class="fill bg-primary" style="width:{{ $rate }}%"></div></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard" style="border-top:3px solid #ef4444">
                    <div class="slabel" style="color:#ef4444">Отказы (Rejected)</div>
                    <div class="bignum mt-2">{{ $statusData['rejected'] ?? 0 }}</div>
                    <small style="color:var(--muted)">требуют внимания</small>
                </div>
            </div>
        </div>

        {{-- Пользователи --}}
        <div class="section-title mt-5 mb-4">
            <div class="accent" style="background:#8b5cf6;box-shadow:0 0 12px #8b5cf680"></div>Аналитика пользователей
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="acard">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div><div class="slabel">Активность базы</div><h6 class="mb-0 fw-bold" style="color:var(--text)">Динамика прироста аудитории</h6></div>
                        <div class="d-flex gap-3">
                            <small class="d-flex align-items-center gap-1" style="color:#3b82f6"><span class="legend-dot" style="background:#3b82f6"></span>Регистрации</small>
                            <small class="d-flex align-items-center gap-1" style="color:#ef4444"><span class="legend-dot" style="background:#ef4444"></span>Удаления</small>
                        </div>
                    </div>
                    <div id="userChart"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard">
                    <div class="slabel">Пользователи</div>
                    <div class="bignum mt-2">{{ $totalUsers ?? 0 }}</div>
                    <small style="color:var(--muted)">активных профилей</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard">
                    <div class="slabel">Новые (30 дней)</div>
                    <div class="bignum mt-2" style="color:#10b981">{{ $newThisMonth ?? 0 }}</div>
                    <div class="progbg">
                        @php $userRate = $totalUsers > 0 ? min(($newThisMonth / $totalUsers) * 100, 100) : 0; @endphp
                        <div class="fill" style="width:{{ $userRate }}%;background:#10b981"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard" style="border-top:3px solid #ef4444">
                    <div class="slabel" style="color:#ef4444">Churn Rate</div>
                    <div class="bignum mt-2">{{ $churnRate ?? 0 }}%</div>
                    <small style="color:var(--muted)">коэффициент оттока</small>
                </div>
            </div>
        </div>

        {{-- Статусы — Doughnut --}}
        <div class="row g-3 mt-2">
            <div class="col-12">
                <div class="acard">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="slabel">Статусы документов</div>
                            <h6 class="mb-0 fw-bold" style="color:var(--text)">Распределение по категориям</h6>
                        </div>
                        <div style="background:var(--grid);padding:6px 16px;border-radius:12px">
                            <span class="slabel me-1">За месяц:</span>
                            <span class="fw-bold" style="color:var(--text);font-size:16px">{{ array_sum($statusData) }}</span>
                        </div>
                    </div>
                    <div style="height:380px;position:relative">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Карточки под диаграммой (Увеличенные) --}}
    <div class="row g-3 mt-3">
        {{-- Входящие --}}
        <div class="col-md-3">
            <div class="acard" style="padding: 24px; border-top: 4px solid #3b82f6;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="slabel" style="font-size: 11px; margin-bottom: 8px;">Входящие</div>
                        <div class="bignum" style="font-size: 32px;">{{ $statusData['incoming'] ?? 0 }}</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: #3b82f615; color: #3b82f6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">принято системой</div>
            </div>
        </div>

        {{-- Исходящие --}}
        <div class="col-md-3">
            <div class="acard" style="padding: 24px; border-top: 4px solid #8b5cf6;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="slabel" style="font-size: 11px; margin-bottom: 8px;">Исходящие</div>
                        <div class="bignum" style="font-size: 32px;">{{ $statusData['outgoing'] ?? 0 }}</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: #8b5cf615; color: #8b5cf6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">отправлено вами</div>
            </div>
        </div>

        {{-- Подписанные --}}
        <div class="col-md-3">
            <div class="acard" style="padding: 24px; border-top: 4px solid #10b981;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="slabel" style="font-size: 11px; margin-bottom: 8px;">Подписанные</div>
                        <div class="bignum" style="font-size: 32px; color: #10b981;">{{ $statusData['signed'] ?? 0 }}</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: #10b98115; color: #10b981; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">завершено успешно</div>
            </div>
        </div>

        {{-- В очереди --}}
        <div class="col-md-3">
            <div class="acard" style="padding: 24px; border-top: 4px solid #f59e0b;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="slabel" style="font-size: 11px; margin-bottom: 8px;">В очереди</div>
                        <div class="bignum" style="font-size: 32px;">{{ $statusData['pending'] ?? 0 }}</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: #f59e0b15; color: #f59e0b; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">ожидают действия</div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Определение темы (темная или светлая)
            const dk = () => document.body.classList.contains('dark') ||
                document.documentElement.classList.contains('dark') ||
                (window.matchMedia && window.matchMedia('(prefers-color-scheme:dark)').matches);

            const isDark = dk();
            const fc = isDark ? '#94a3b8' : '#64748b'; // Цвет шрифта для легенды и осей
            const tTheme = isDark ? 'dark' : 'light'; // Тема для тултипов

            // 2. Общие настройки для ApexCharts
            const co = {
                chart: { type: 'area', height: 280, toolbar: { show: false }, zoom: { enabled: false }, foreColor: fc },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                markers: { size: 4, strokeWidth: 2, strokeColors: isDark ? '#151d30' : '#fff' },
                grid: { borderColor: isDark ? 'rgba(255,255,255,.05)' : '#f1f5f9', strokeDashArray: 4 },
                tooltip: { theme: tTheme },
                xaxis: { axisBorder: { show: false }, axisTicks: { show: false } }
            };

            // 3. График потока документов (ApexCharts)
            new ApexCharts(document.querySelector('#mainChart'), {
                ...co,
                series: [{ name: 'Документы', data: {!! json_encode($dailyActivity->pluck('count')) !!} }],
                colors: ['#3b82f6'],
                xaxis: { categories: {!! json_encode($dailyActivity->pluck('date')) !!} },
                fill: { type: 'gradient', gradient: { opacityFrom: .45, opacityTo: .06 } }
            }).render();

            // 4. График активности пользователей (ApexCharts)
            new ApexCharts(document.querySelector('#userChart'), {
                ...co,
                series: [
                    { name: 'Регистрации', data: {!! json_encode($userActivity->pluck('reg')) !!} },
                    { name: 'Удаления', data: {!! json_encode($userActivity->pluck('del')) !!} }
                ],
                colors: ['#3b82f6', '#ef4444'],
                xaxis: { categories: {!! json_encode($userActivity->pluck('date')) !!} },
                fill: { type: 'gradient', gradient: { opacityFrom: .35, opacityTo: 0 } }
            }).render();

            // 5. Плагин для текста в центре Doughnut Chart (Chart.js)
            const centerText = {
                id: 'centerText',
                afterDraw(c) {
                    const { ctx, width, height } = c;
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    // Автоматический выбор цвета текста в зависимости от фона
                    const textColor = isDark ? '#ffffff' : '#0f172a'; // Белый на черном, Темный на белом
                    const subTextColor = isDark ? '#94a3b8' : '#64748b';

                    // Отрисовка центрального числа
                    ctx.font = '800 48px Inter, sans-serif';
                    ctx.fillStyle = textColor;

                    // Отрисовка слова "ДОКУМЕНТОВ"
                    ctx.font = '800 11px Inter, sans-serif';
                    ctx.fillStyle = subTextColor;
                    ctx.fillText('ДОКУМЕНТОВ', width / 2, height / 2 + 25);

                    ctx.restore();
                }
            };

            // 6. Круговой график статусов (Chart.js)
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Входящие', 'Исходящие', 'Подписанные', 'Ожидание'],
                    datasets: [{
                        data: [
                            {{ $statusData['incoming'] ?? 0 }},
                            {{ $statusData['outgoing'] ?? 0 }},
                            {{ $statusData['signed'] ?? 0 }},
                            {{ $statusData['pending'] ?? 0 }}
                        ],
                        borderWidth: 0,
                        hoverOffset: 18,
                        borderRadius: 14,
                        spacing: 6,
                        backgroundColor: ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b']
                    }]
                },
                plugins: [centerText],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 24,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                color: fc,
                                font: { size: 12, weight: '700' }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        });
    </script>
@endsection
