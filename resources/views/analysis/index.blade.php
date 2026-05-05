@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: var(--primary);">Интеллектуальный анализ</h2>
            <div class="px-3 py-1 rounded-pill" style="background: rgba(59, 130, 246, 0.1); border: 1px solid #3b82f6; color: #3b82f6; font-size: 12px;">
                AI Powered
            </div>
        </div>

        <div class="row g-4">
            <!-- Статусы документов (Donut) -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100" style="background: #1e293b; border-radius: 20px;">
                    <h6 class="text-white opacity-50 mb-4 text-uppercase small fw-bold">Статусы документов</h6>
                    <div id="statusDonutChart"></div>
                </div>
            </div>

            <!-- Динамика по дням (Тонкие столбики) -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm p-4 h-100" style="background: #1e293b; border-radius: 20px;">
                    <h6 class="text-white opacity-50 mb-4 text-uppercase small fw-bold">Активность по дням</h6>
                    <div id="dailyBarChart"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Настройка Donut
            var donutOptions = {
                series: [
                    {{ $statusData['signed'] ?? 0 }},
                    {{ $statusData['pending'] ?? 0 }},
                    {{ $statusData['rejected'] ?? 0 }}
                ],
                chart: { type: 'donut', height: 320 },
                labels: ['Подписано', 'В процессе', 'Отклонено'],
                colors: ['#f3a007', '#3b82f6', '#ef4444'],
                stroke: { show: false },
                legend: { position: 'bottom', labels: { colors: '#94a3b8' } },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Всего',
                                    color: '#94a3b8',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false }
            };
            new ApexCharts(document.querySelector("#statusDonutChart"), donutOptions).render();

            // 2. Настройка Bar Chart (ПО ДНЯМ)
            var dailyData = {!! json_encode($dailyActivity->pluck('count')->toArray()) !!};
            var dailyLabels = {!! json_encode($dailyActivity->pluck('date')->toArray()) !!};

            var barOptions = {
                series: [{
                    name: 'Документы',
                    data: dailyData
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false },
                    foreColor: '#94a3b8'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 3,
                        columnWidth: '15%', // Еще тоньше, так как дней много
                        dataLabels: { position: 'top' },
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -20,
                    style: { fontSize: '10px', colors: ["#fff"] }
                },
                colors: ['#3b82f6'],
                xaxis: {
                    categories: dailyLabels,
                    labels: {
                        rotate: -45, // Наклон, чтобы даты не слипались
                        style: { fontSize: '10px' }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { show: true }
                },
                grid: {
                    borderColor: '#334155',
                    strokeDashArray: 4
                },
                tooltip: { theme: 'dark' }
            };

            new ApexCharts(document.querySelector("#dailyBarChart"), barOptions).render();
        });
    </script>
@endsection
