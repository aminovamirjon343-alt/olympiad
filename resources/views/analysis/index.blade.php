    @extends('layouts.admin')

    @section('content')
        <style>
                    .ana-card {
                        background: #1e293b;
                        border-radius: 16px;
                        border: 1px solid rgba(255,255,255,0.05);
                        padding: 20px;
                        height: 100%;
                        transition: transform 0.2s;
                    }
                    .ana-card:hover {
                        border-color: rgba(59, 130, 246, 0.3);
                    }
                    .stat-label {
                        color: #94a3b8;
                        font-size: 11px;
                        text-transform: uppercase;
                        font-weight: 800;
                        letter-spacing: 0.8px;
                    }
                    .big-num {
                        font-size: 28px;
                        font-weight: 700;
                        color: #f8fafc;
                        line-height: 1.2;
                    }
                    .progress { background: #0f172a; border-radius: 10px; }
                </style>

                <div class="container-fluid p-4">
                    <div class="row g-3">
                        <!-- ГРАФИК АКТИВНОСТИ НА 30 ДНЕЙ -->
                        <div class="col-12">
                            <div class="ana-card">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <div class="stat-label mb-1">Анализ активности</div>
                                        <h5 class="text-white m-0 fw-bold">Поток документов за 30 дней</h5>
                                    </div>
                                    <div class="px-3 py-1 rounded-pill" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 11px; border: 1px solid rgba(59, 130, 246, 0.2);">
                                        <i class="fas fa-sync-alt fa-spin me-1"></i> Обновление Live
                                    </div>
                                </div>
                                <div id="mainActivityChart" style="min-height: 280px;"></div>
                            </div>
                        </div>
                        <!-- КАРТОЧКИ KPI ДОКУМЕНТОВ -->
                        <div class="col-md-4 mt-3">
                            <div class="ana-card">
                                <div class="stat-label">Всего документов</div>
                                <div class="big-num mt-2" id="totalDocs">
                                    {{ array_sum($statusData) }}
                                </div>
                                <div class="small text-muted mt-1">загружено в систему</div>
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="ana-card">
                                <div class="stat-label">Доля подписанных</div>
                                @php
                                    $total = array_sum($statusData);
                                    $rate = $total > 0 ? round(($statusData['signed'] / $total) * 100) : 0;
                                @endphp
                                <div class="big-num mt-2 text-primary-custom" id="effRate">
                                    {{ $rate }}%
                                </div>
                                <div class="progress-custom mt-2">
                                    <div id="effBar" class="progress-bar bg-primary" style="width: {{ $rate }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="ana-card" style="border-top: 4px solid #ef4444;">
                                <div class="stat-label text-danger-custom">Отказы (Rejected)</div>
                                <div class="big-num mt-2" id="rejectedCount">
                                    {{ $statusData['rejected'] ?? 0 }}
                                </div>
                                <div class="small text-muted mt-1">требуют корректировки</div>
                            </div>
                        </div>
                        <!-- НИЖНЯЯ ПАНЕЛЬ СТАТИСТИКИ -->

                <!-- ApexCharts -->
                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
            /* Добавим стили для карточек, чтобы они выделялись на светлом фоне */
            .ana-card {
                background: #ffffff;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                border: 1px solid #e2e8f0;
            }
            .stat-label { color: #64748b; font-size: 0.875rem; }
            .big-num { font-size: 1.5rem; font-weight: 700; color: #1e293b; }
        </style>

        <div class="container-fluid">
            <div class="row">
                <!-- ГРАФИК ПОЛЬЗОВАТЕЛЕЙ -->
                <div class="col-12 mt-3">
                    <div class="ana-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <div class="stat-label mb-1">Анализ пользователей</div>
                                <!-- Убрали text-white, чтобы текст был виден -->
                                <h5 class="m-0 fw-bold" style="color: #1e293b;">Динамика аудитории</h5>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="small" style="color: #3b82f6;"><i class="fas fa-circle me-1"></i> Регистрации</div>
                                <div class="small" style="color: #ef4444;"><i class="fas fa-circle me-1"></i> Удаления</div>
                            </div>
                        </div>
                        <div id="userActivityChart"></div>
                    </div>
                </div>

                <!-- КАРТОЧКИ KPI -->
                <div class="col-md-4 mt-3">
                    <div class="ana-card">
                        <div class="stat-label">Всего пользователей</div>
                        <div class="big-num mt-2">{{ $totalUsers ?? 0 }}</div>
                        <div class="small text-muted mt-1">активных аккаунтов</div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="ana-card">
                        <div class="stat-label">Новых за месяц</div>
                        <div class="big-num mt-2 text-primary">{{ $newThisMonth ?? 0 }}</div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="ana-card" style="border-top: 4px solid #ef4444;">
                        <div class="stat-label text-danger">Churn Rate (Отток)</div>
                        <div class="big-num mt-2">{{ $churnRate ?? 0 }}%</div>
                        <div class="small text-muted mt-1">коэффициент ухода</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Подключаем библиотеку, если её нет в layout -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // --- 1. ПОЛУЧЕНИЕ ДАННЫХ (Blade -> JS) ---
                                const dailyCounts = {!! json_encode($dailyActivity->pluck('count')->toArray()) !!};
                                const dailyLabels = {!! json_encode($dailyActivity->pluck('date')->toArray()) !!};

                                const regData = {!! json_encode($userActivity->pluck('reg')->toArray()) !!};
                                const delData = {!! json_encode($userActivity->pluck('del')->toArray()) !!};
                                const userLabels = {!! json_encode($userActivity->pluck('date')->toArray()) !!};

                                const sData = [
                                    {{ $statusData['signed'] ?? 0 }},
                                    {{ $statusData['pending'] ?? 0 }},
                                    {{ $statusData['rejected'] ?? 0 }}
                                ];

                                // --- 2. ВЫЧИСЛЕНИЯ ДЛЯ КАРТОЧЕК (Должны быть ВНУТРИ этой функции) ---
                                const totalDocs = sData.reduce((a, b) => a + b, 0);
                                const signedDocs = sData[0];
                                const rejectedDocs = sData[2];
                                const successRate = totalDocs > 0 ? Math.round((signedDocs / totalDocs) * 100) : 0;

                                // Обновляем HTML элементы (проверь, чтобы ID в HTML совпадали!)
                                if (document.getElementById('totalDocs')) document.getElementById('totalDocs').innerText = totalDocs;
                                if (document.getElementById('effRate')) document.getElementById('effRate').innerText = successRate + '%';
                                if (document.getElementById('effBar')) document.getElementById('effBar').style.width = successRate + '%';
                                if (document.getElementById('rejectedCount')) document.getElementById('rejectedCount').innerText = rejectedDocs;

                                // Прогноз (среднее за неделю)
                                const recent = dailyCounts.slice(-7);
                                const avg = recent.length > 0 ? Math.round(recent.reduce((a, b) => a + b, 0) / recent.length) : 0;
                                if (document.getElementById('predictVal')) document.getElementById('predictVal').innerText = avg + 2;

                                // --- 3. ГРАФИК ПОТОКА ДОКУМЕНТОВ ---
                                new ApexCharts(document.querySelector("#mainActivityChart"), {
                                    series: [{ name: 'Объем', data: dailyCounts }],
                                    chart: {
                                        type: 'area',
                                        height: 280,
                                        toolbar: { show: false },
                                        foreColor: '#64748b'
                                    },
                                    colors: ['#3b82f6'],
                                    stroke: { curve: 'smooth', width: 4 },
                                    fill: {
                                        type: 'gradient',
                                        gradient: { opacityFrom: 0.45, opacityTo: 0.05 }
                                    },
                                    xaxis: { categories: dailyLabels },
                                    grid: { borderColor: 'rgba(255, 255, 255, 0.05)', strokeDashArray: 4 },
                                    tooltip: { theme: 'dark' }
                                }).render();

                                // --- 4. МИНИ-ДОНАТ СТАТУСОВ ---
                                if (document.querySelector("#miniDonut")) {
                                    new ApexCharts(document.querySelector("#miniDonut"), {
                                        series: sData,
                                        chart: { type: 'donut', height: 140 },
                                        colors: ['#10b981', '#3b82f6', '#ef4444'],
                                        labels: ['Signed', 'Pending', 'Rejected'],
                                        dataLabels: { enabled: false },
                                        legend: { show: false },
                                        tooltip: { theme: 'dark' }
                                    }).render();
                                }

                                // --- 5. ГРАФИК ПОЛЬЗОВАТЕЛЕЙ ---
                                if (document.querySelector("#userActivityChart")) {
                                    new ApexCharts(document.querySelector("#userActivityChart"), {
                                        series: [
                                            { name: 'Регистрации', data: regData },
                                            { name: 'Удаления', data: delData }
                                        ],
                                        chart: {
                                            type: 'area',
                                            height: 300,
                                            toolbar: { show: false }
                                        },
                                        colors: ['#3b82f6', '#ef4444'],
                                        stroke: { curve: 'smooth', width: 2 },
                                        xaxis: {
                                            categories: userLabels,
                                            labels: { style: { colors: '#94a3b8' } }
                                        },
                                        grid: { borderColor: '#f1f5f9' },
                                        tooltip: { theme: 'light' }
                                    }).render();
                                }
                            });
                        </script>
    @endsection

