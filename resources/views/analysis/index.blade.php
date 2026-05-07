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



@extends('layouts.admin')

@section('content')
    <style>
        /* Переменные для автоматической смены цветов */
        :root {
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --grid-color: #f1f5f9;
        }

        /* Если у тебя в layouts/admin для body или главного контейнера
           добавляется класс .dark-mode или подобный, стили изменятся сами */
        @media (prefers-color-scheme: dark) {
            .ana-card {
                --card-bg: #1e293b;
                --text-main: #f8fafc;
                --text-muted: #94a3b8;
                --border-color: rgba(255,255,255,0.05);
                --grid-color: rgba(255,255,255,0.05);
            }
        }

        .ana-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .section-divider {
            border-left: 4px solid #3b82f6;
            padding-left: 15px;
            margin: 30px 0 20px 0;
            color: var(--text-main);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.8px;
        }

        .big-num {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.2;
        }

        .small.text-muted {
            color: var(--text-muted) !important;
        }

        #mainActivityChart, #userActivityChart {
            max-height: 300px;
            width: 100%;
        }

        .progress-custom {
            height: 6px;
            background: var(--grid-color);
            border-radius: 10px;
            margin-top: 10px;
        }
    </style>

    <div class="container-fluid p-4">

        <div class="py-4 px-2">
            <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                Аналитика документооборота
            </h1>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="ana-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="stat-label">Статистика системы</div>
                            <h5 class="m-0 fw-bold" style="color: var(--text-main);">Поток входящих документов</h5>
                        </div>
                        <div class="px-3 py-1 rounded-pill" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 11px; border: 1px solid rgba(59, 130, 246, 0.2);">
                            <i class="fas fa-sync-alt fa-spin me-1"></i> Live
                        </div>
                    </div>
                    <div id="mainActivityChart"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ana-card">
                    <div class="stat-label">Всего документов</div>
                    <div class="big-num mt-2">{{ array_sum($statusData) }}</div>
                    <div class="small text-muted mt-1">обработано файлов</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ana-card">
                    <div class="stat-label">Доля подписанных</div>
                    @php
                        $total = array_sum($statusData);
                        $rate = $total > 0 ? round(($statusData['signed'] / $total) * 100) : 0;
                    @endphp
                    <div class="big-num mt-2 text-primary">{{ $rate }}%</div>
                    <div class="progress-custom">
                        <div class="progress-bar bg-primary" style="width: {{ $rate }}%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ana-card" style="border-top: 4px solid #ef4444;">
                    <div class="stat-label text-danger">Отказы (Rejected)</div>
                    <div class="big-num mt-2">{{ $statusData['rejected'] ?? 0 }}</div>
                    <div class="small text-muted mt-1">требуют внимания</div>
                </div>
            </div>
        </div>
        <div class="py-6 px-2"> <!-- Увеличил py-4 до py-6 для лучшего отступа -->
            <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-3">
                <!-- Вот твоя полоска | -->
                <span class="w-1.5 h-7 bg-blue-500 rounded-full shadow-[0_0_12px_rgba(59,130,246,0.6)]"></span>

                Аналитика пользователей
            </h1>
        </div>


        <div class="row g-3">
            <div class="col-12">
                <div class="ana-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="stat-label">Активность базы</div>
                            <h5 class="m-0 fw-bold" style="color: var(--text-main);">Динамика прироста аудитории</h5>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="small" style="color: #3b82f6;"><i class="fas fa-circle me-1"></i> Регистрации</div>
                            <div class="small" style="color: #ef4444;"><i class="fas fa-circle me-1"></i> Удаления</div>
                        </div>
                    </div>
                    <div id="userActivityChart"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ana-card">
                    <div class="stat-label">Пользователи</div>
                    <div class="big-num mt-2">{{ $totalUsers ?? 0 }}</div>
                    <div class="small text-muted mt-1">активных профилей</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ana-card">
                    <div class="stat-label">Новые (30 дней)</div>
                    <div class="big-num mt-2 text-success">{{ $newThisMonth ?? 0 }}</div>
                    <div class="progress-custom">
                        <div class="progress-bar bg-success" style="width: 70%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ana-card" style="border-top: 4px solid #ef4444;">
                    <div class="stat-label text-danger">Churn Rate</div>
                    <div class="big-num mt-2">{{ $churnRate ?? 0 }}%</div>
                    <div class="small text-muted mt-1">коэффициент оттока</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Проверяем, темная ли тема сейчас (системная или через класс)
            const isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const themeColor = isDark ? '#94a3b8' : '#64748b';
            const tooltipTheme = isDark ? 'dark' : 'light';

            const commonOptions = {
                chart: {
                    type: 'area',
                    height: 280,
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    foreColor: themeColor // Цвет текста на осях графика
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -10,
                    style: { fontSize: '11px', colors: [isDark ? '#f8fafc' : "#304758"] },
                    background: {
                        enabled: true,
                        foreColor: isDark ? '#1e293b' : '#fff',
                        padding: 4,
                        borderRadius: 4,
                        borderWidth: 0,
                        opacity: 0.9
                    }
                },
                stroke: { curve: 'smooth', width: 3 },
                markers: { size: 4, strokeWidth: 2, strokeColors: isDark ? '#1e293b' : '#fff' },
                grid: { borderColor: isDark ? 'rgba(255,255,255,0.05)' : '#f1f5f9', strokeDashArray: 4 },
                tooltip: { theme: tooltipTheme }
            };

            new ApexCharts(document.querySelector("#mainActivityChart"), {
                ...commonOptions,
                series: [{ name: 'Документы', data: {!! json_encode($dailyActivity->pluck('count')) !!} }],
                colors: ['#3b82f6'],
                xaxis: { categories: {!! json_encode($dailyActivity->pluck('date')) !!} },
                fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.05 } }
            }).render();

            new ApexCharts(document.querySelector("#userActivityChart"), {
                ...commonOptions,
                series: [
                    { name: 'Регистрации', data: {!! json_encode($userActivity->pluck('reg')) !!} },
                    { name: 'Удаления', data: {!! json_encode($userActivity->pluck('del')) !!} }
                ],
                colors: ['#3b82f6', '#ef4444'],
                xaxis: { categories: {!! json_encode($userActivity->pluck('date')) !!} },
                fill: { type: 'gradient', gradient: { opacityFrom: 0.3, opacityTo: 0 } }
            }).render();
        });
    </script>
@endsection
