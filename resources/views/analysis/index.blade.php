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


        .apexcharts-tooltip {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2) !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
        }
        .dark .apexcharts-tooltip, .dark-mode .apexcharts-tooltip, [data-theme='dark'] .apexcharts-tooltip {
            background: #1e293b !important;
            color: #ffffff !important;
        }
        .dark .apexcharts-tooltip-title, .dark-mode .apexcharts-tooltip-title, [data-theme='dark'] .apexcharts-tooltip-title {
            background: rgba(255,255,255,0.05) !important;
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
            color: #ffffff !important;
        }
        .dark .apexcharts-tooltip-text, .dark .apexcharts-tooltip-y-group {
            color: #ffffff !important;
        }
    </style>

    <div class="container-fluid p-4 dash">

        <div class="section-title mb-4"><div class="accent"></div><span data-i18n="docAnalytics">Аналитика документооборота</span></div>

        <div class="row g-3">
            <div class="col-12">
                <div class="acard">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div><div class="slabel" data-i18n="systemStats">Статистика системы</div><h6 class="mb-0 fw-bold" style="color:var(--text)" data-i18n="incomingFlow">Поток входящих документов</h6></div>
                        <div class="badge-live"><i class="fas fa-sync-alt fa-spin"></i> Live</div>
                    </div>
                    <div id="mainChart"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard">
                    <div class="slabel" data-i18n="totalDocs">Всего документов</div>
                    <div class="bignum mt-2">{{ $totalDocuments ?? 0 }}</div>
                    <small style="color:var(--muted)" data-i18n="processedFiles">обработано файлов</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard">
                    <div class="slabel" data-i18n="signedRate">Доля подписанных</div>
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
                    <div class="slabel" style="color:#ef4444" data-i18n="rejectedTitle">Отказы (Rejected)</div>
                    <div class="bignum mt-2">{{ $statusData['rejected'] ?? 0 }}</div>
                    <small style="color:var(--muted)" data-i18n="requireAttention">требуют внимания</small>
                </div>
            </div>
        </div>

        {{-- Пользователи --}}
        <div class="section-title mt-5 mb-4">
            <div class="accent" style="background:#8b5cf6;box-shadow:0 0 12px #8b5cf680"></div><span data-i18n="userAnalytics">Аналитика пользователей</span>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="acard">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div><div class="slabel" data-i18n="baseActivity">Активность базы</div><h6 class="mb-0 fw-bold" style="color:var(--text)" data-i18n="audienceDynamics">Динамика прироста аудитории</h6></div>
                        <div class="d-flex gap-3">
                            <small class="d-flex align-items-center gap-1" style="color:#3b82f6"><span class="legend-dot" style="background:#3b82f6"></span><span data-i18n="registrations">Регистрации</span></small>
                            <small class="d-flex align-items-center gap-1" style="color:#ef4444"><span class="legend-dot" style="background:#ef4444"></span><span data-i18n="deletions">Удаления</span></small>
                        </div>
                    </div>
                    <div id="userChart"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard">
                    <div class="slabel" data-i18n="usersCount">Пользователи</div>
                    <div class="bignum mt-2">{{ $totalUsers ?? 0 }}</div>
                    <small style="color:var(--muted)" data-i18n="activeProfiles">активных профилей</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard">
                    <div class="slabel" data-i18n="new30Days">Новые (30 дней)</div>
                    <div class="bignum mt-2" style="color:#10b981">{{ $newThisMonth ?? 0 }}</div>
                    <div class="progbg">
                        @php $userRate = $totalUsers > 0 ? min(($newThisMonth / $totalUsers) * 100, 100) : 0; @endphp
                        <div class="fill" style="width:{{ $userRate }}%;background:#10b981"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="acard" style="border-top:3px solid #ef4444">
                    <div class="slabel" style="color:#ef4444" data-i18n="churnRate">Churn Rate</div>
                    <div class="bignum mt-2">{{ $churnRate ?? 0 }}%</div>
                    <small style="color:var(--muted)" data-i18n="churnDesc">коэффициент оттока</small>
                </div>
            </div>
        </div>


        <div class="row g-3 mt-2">
            <div class="col-12">
                <div class="acard">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="slabel" data-i18n="docStatuses">Статусы документов</div>
                            <h6 class="mb-0 fw-bold" style="color:var(--text)" data-i18n="distByCat">Распределение по категориям</h6>
                        </div>
                        <div style="background:var(--grid);padding:6px 16px;border-radius:12px">
                            <span class="slabel me-1" data-i18n="forMonth">За месяц:</span>
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


    <div class="row g-3 mt-3 px-4">
        <div class="col-md-3">
            <div class="acard" style="padding: 24px; border-top: 4px solid #3b82f6;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="slabel" style="font-size: 11px; margin-bottom: 8px;" data-i18n="incoming">Входящие</div>
                        <div class="bignum" style="font-size: 32px;">{{ $statusData['incoming'] ?? 0 }}</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: #3b82f615; color: #3b82f6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);" data-i18n="acceptedBySys">принято системой</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="acard" style="padding: 24px; border-top: 4px solid #8b5cf6;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="slabel" style="font-size: 11px; margin-bottom: 8px;" data-i18n="outgoing">Исходящие</div>
                        <div class="bignum" style="font-size: 32px;">{{ $statusData['outgoing'] ?? 0 }}</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: #8b5cf615; color: #8b5cf6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);" data-i18n="sentByYou">отправлено вами</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="acard" style="padding: 24px; border-top: 4px solid #10b981;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="slabel" style="font-size: 11px; margin-bottom: 8px;" data-i18n="signed">Подписанные</div>
                        <div class="bignum" style="font-size: 32px; color: #10b981;">{{ $statusData['signed'] ?? 0 }}</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: #10b98115; color: #10b981; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);" data-i18n="successDone">завершено успешно</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="acard" style="padding: 24px; border-top: 4px solid #f59e0b;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="slabel" style="font-size: 11px; margin-bottom: 8px;" data-i18n="pending">В очереди</div>
                        <div class="bignum" style="font-size: 32px;">{{ $statusData['pending'] ?? 0 }}</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: #f59e0b15; color: #f59e0b; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);" data-i18n="waitAction">ожидают действия</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const translations = {
                en: {
                    docAnalytics: "Document Analytics", systemStats: "System Statistics", incomingFlow: "Incoming Document Flow",
                    totalDocs: "Total Documents", processedFiles: "processed files", signedRate: "Signed Rate",
                    rejectedTitle: "Rejected", requireAttention: "require attention", userAnalytics: "User Analytics",
                    baseActivity: "Base Activity", audienceDynamics: "Audience Dynamics", registrations: "Registrations",
                    deletions: "Deletions", usersCount: "Users", activeProfiles: "active profiles",
                    new30Days: "New (30 days)", churnRate: "Churn Rate", churnDesc: "churn coefficient",
                    docStatuses: "Document Statuses", distByCat: "Distribution by category", forMonth: "For month:",
                    incoming: "Incoming", acceptedBySys: "accepted by system", outgoing: "Outgoing",
                    sentByYou: "sent by you", signed: "Signed", successDone: "successfully completed",
                    pending: "Pending", waitAction: "waiting for action", documents: "DOCUMENTS"
                },
                ru: {
                    docAnalytics: "Аналитика документооборота", systemStats: "Статистика системы", incomingFlow: "Поток входящих документов",
                    totalDocs: "Всего документов", processedFiles: "обработано файлов", signedRate: "Доля подписанных",
                    rejectedTitle: "Отказы (Rejected)", requireAttention: "требуют внимания", userAnalytics: "Аналитика пользователей",
                    baseActivity: "Активность базы", audienceDynamics: "Динамика прироста аудитории", registrations: "Регистрации",
                    deletions: "Удаления", usersCount: "Пользователи", activeProfiles: "активных профилей",
                    new30Days: "Новые (30 дней)", churnRate: "Churn Rate", churnDesc: "коэффициент оттока",
                    docStatuses: "Статусы документов", distByCat: "Распределение по категориям", forMonth: "За месяц:",
                    incoming: "Входящие", acceptedBySys: "принято системой", outgoing: "Исходящие",
                    sentByYou: "отправлено вами", signed: "Подписанные", successDone: "завершено успешно",
                    pending: "В очереди", waitAction: "ожидают действия", documents: "ДОКУМЕНТОВ"
                },
                tj: {
                    docAnalytics: "Таҳлили ҳуҷҷатҳо", systemStats: "Омори система", incomingFlow: "Ҷараёни ҳуҷҷатҳои воридотӣ",
                    totalDocs: "Ҳамаи ҳуҷҷатҳо", processedFiles: "файлҳо коркард шуданд", signedRate: "Ҳиссаи имзошуда",
                    rejectedTitle: "Радшуда", requireAttention: "диққатро талаб мекунад", userAnalytics: "Таҳлили корбарон",
                    baseActivity: "Фаъолияти база", audienceDynamics: "Динамикаи афзоиши аудитория", registrations: "Бақайдгириҳо",
                    deletions: "Ҳазфшудаҳо", usersCount: "Корбарон", activeProfiles: "профилҳои фаъол",
                    new30Days: "Нав (30 рӯз)", churnRate: "Churn Rate", churnDesc: "коэффисиенти хориҷшавӣ",
                    docStatuses: "Ҳолатҳои ҳуҷҷатҳо", distByCat: "Тақсимшавӣ аз рӯи категорияҳо", forMonth: "Дар моҳ:",
                    incoming: "Воридотӣ", acceptedBySys: "аз ҷониби система қабул шуд", outgoing: "Содиротӣ",
                    sentByYou: "аз ҷониби шумо фиристода шуд", signed: "Имзошуда", successDone: "бомуваффақият анҷом ёфт",
                    pending: "Дар навбат", waitAction: "интизори амал", documents: "ҲУҶҶАТҲО"
                }
            };

            function applyAnalyticsTranslations() {
                const lang = localStorage.getItem('app-lang') || 'ru';
                const t = translations[lang];
                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if (t[key]) el.textContent = t[key];
                });
                return t;
            }

            const t = applyAnalyticsTranslations();

            const dk = () => document.body.classList.contains('dark') ||
                document.documentElement.classList.contains('dark') ||
                (window.matchMedia && window.matchMedia('(prefers-color-scheme:dark)').matches);

            const isDark = dk();
            const fc = isDark ? '#94a3b8' : '#64748b';

            // Настройки ApexCharts
            const co = {
                chart: { type: 'area', height: 280, toolbar: { show: false }, zoom: { enabled: false }, foreColor: fc },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                markers: { size: 4, strokeWidth: 2, strokeColors: isDark ? '#151d30' : '#fff' },
                grid: { borderColor: isDark ? 'rgba(255,255,255,.05)' : '#f1f5f9', strokeDashArray: 4 },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    x: { show: true },
                    style: { fontSize: '12px' }
                },
                xaxis: { axisBorder: { show: false }, axisTicks: { show: false } }
            };

            new ApexCharts(document.querySelector('#mainChart'), {
                ...co,
                series: [{ name: t.incoming || 'Incoming', data: {!! json_encode($dailyActivity->pluck('count')) !!} }],
                colors: ['#3b82f6'],
                xaxis: { categories: {!! json_encode($dailyActivity->pluck('date')) !!} },
                fill: { type: 'gradient', gradient: { opacityFrom: .45, opacityTo: .06 } }
            }).render();

            new ApexCharts(document.querySelector('#userChart'), {
                ...co,
                series: [
                    { name: t.registrations || 'Registrations', data: {!! json_encode($userActivity->pluck('reg')) !!} },
                    { name: t.deletions || 'Deletions', data: {!! json_encode($userActivity->pluck('del')) !!} }
                ],
                colors: ['#3b82f6', '#ef4444'],
                xaxis: { categories: {!! json_encode($userActivity->pluck('date')) !!} },
                fill: { type: 'gradient', gradient: { opacityFrom: .35, opacityTo: 0 } }
            }).render();


            const centerText = {
                id: 'centerText',
                afterDraw(c) {
                    const { ctx, width, height } = c;
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';


                    const textColor = isDark ? '#ffffff' : '#0f172a';
                    const subTextColor = isDark ? '#94a3b8' : '#64748b';


                    ctx.font = '800 48px Inter, sans-serif';
                    ctx.fillStyle = textColor;
                    ctx.fillText('', width / 2, height / 2 - 10);


                    ctx.font = '800 11px Inter, sans-serif';
                    ctx.fillStyle = subTextColor;
                    ctx.fillText(t.documents || 'DOCUMENTS', width / 2, height / 2 + 25);
                    ctx.restore();
                }
            };

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: [t.incoming, t.outgoing, t.signed, t.pending],
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
