@extends('layouts.admin')

@section('content')
    <section class="page-section active" id="page-dashboard">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" data-i18n="welcomeBack">
                    Welcome back, {{ strtok(auth()->user()->name, ' ') }} !
                </h4>
                <p class="text-muted mb-0" data-i18n="dashSubtitle">Here's what's happening with your documents today.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">

            <div class="col-6 col-lg-3">

                <div class="stat-card" style="border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon" style="background:#ede9fe;color:var(--primary);">
                            <i class="bi bi-folder2"></i>
                        </div>
                        <span class="badge {{ $docsGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                    {{ $docsGrowth >= 0 ? '+' : '' }}{{ $docsGrowth }}%
                </span>
                    </div>

                    <div class="fw-bold fs-4">
                        {{ number_format($totalDocs) }}
                    </div>

                    <div class="text-muted" style="font-size:13px;">
                        Total Documents
                    </div>
                </div>

            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card" style="border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">

                    <div class="d-flex justify-content-between align-items-start mb-3">

                        <div class="stat-icon" style="background:#dcfce7;color:#16a34a;">
                            <i class="bi bi-pen"></i>
                        </div>
                        <span class="badge {{ $signedGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                    {{ $signedGrowth >= 0 ? '+' : '' }}{{ $signedGrowth }}%
                </span>
                    </div>

                    <div class="fw-bold fs-4">
                        {{ $stats['signed'] }}
                    </div>

                    <div class="text-muted" style="font-size:13px;">
                        Signed
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">

                <div class="stat-card" style="border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon" style="background:#dbeafe;color:#2563eb;">
                            <i class="bi bi-people"></i>
                        </div>
                        <span class="badge bg-info-subtle text-info">Users</span>
                    </div>

                    <div class="fw-bold fs-4">
                        {{ $stats['users'] }}
                    </div>

                    <div class="text-muted" style="font-size:13px;">
                        Active Users
                    </div>

                </div>

            </div>
            <div class="col-6 col-lg-3">

                    <div class="stat-card ai-promo-card"
                         style="border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 12px; padding: 15px; background: linear-gradient(145deg, #6366f1, #8b5cf6); position: relative; overflow: hidden; height: 100%; transition: 0.3s;">

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            {{-- Иконка чуть компактнее --}}
                            <div class="stat-icon" style="background: rgba(255,255,255,0.2); color: #ffffff; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 9px;">
                                <i class="bi bi-stars" style="font-size: 1rem;"></i>
                            </div>
                            {{-- Бейдж меньше --}}
                            <span class="badge" style="background: #ffffff; color: #6366f1; font-size: 8px; font-weight: 800; border-radius: 5px; padding: 3px 6px;">AI SMART</span>
                        </div>

                        {{-- Основной текст стал меньше (был fs-4, стал 18px) --}}
                        <div class="fw-bold" style="color: #ffffff; font-size: 18px; line-height: 1.2; margin-bottom: 2px;">
                            AI Анализ
                        </div>

                        {{-- Подзаголовок стал 11px вместо 13px --}}
                        <div style="color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 400;">
                            Мгновенный разбор
                        </div>

                        <div class="shimmer-effect"></div>
                    </div>

            </div>

            <style>
                .ai-promo-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.2);
                    filter: brightness(1.05);
                }

                .shimmer-effect {
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 50%;
                    height: 100%;
                    background: linear-gradient(to right, transparent, rgba(255,255,255,0.15), transparent);
                    transform: skewX(-25deg);
                    animation: shimmer 5s infinite;
                }

                @keyframes shimmer {
                    0% { left: -100%; }
                    20% { left: 150%; }
                    100% { left: 150%; }
                }
            </style>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="table-custom">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h6 class="fw-bold mb-0" data-i18n="recentDocuments">Recent Documents</h6>
                        <a href="{{route('documents.index')}}" class="btn btn-sm btn-outline-primary" onclick="showPage('documents', null)" data-i18n="viewAll">View All</a>
                    </div>
                    <table class="table table-custom mb-0">


                        <table class="table table-custom align-middle table-hover mb-0">
                            <div class="table-responsive">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Document</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    <style>
                                        /* Общие стили для всех режимов */
                                        .table-custom thead th {
                                            text-transform: uppercase;
                                            font-size: 12px;
                                            letter-spacing: 0.5px;
                                            padding: 14px 12px !important;
                                            border: none !important;
                                        }

                                        /* --- СВЕТЛАЯ ТЕМА --- */
                                        [data-bs-theme="light"] .table-custom thead tr {
                                            background-color: #ffffff !important; /* Белый фон */
                                        }
                                        [data-bs-theme="light"] .table-custom thead th {
                                            color: #000000 !important; /* Черный текст */
                                        }

                                        /* --- ТЕМНАЯ ТЕМА --- */
                                        [data-bs-theme="dark"] .table-custom thead tr {
                                            background-color: #111111 !important; /* Черный фон */
                                        }
                                        [data-bs-theme="dark"] .table-custom thead th {
                                            color: #ffffff !important; /* Белый текст */
                                        }

                                        /* --- ТЕЛО ТАБЛИЦЫ (Всегда светлое, как на твоих скринах) --- */
                                        .table-custom tbody tr {
                                            background-color: #ffffff !important;
                                            border-bottom: 1px solid #eee !important;
                                        }
                                        .table-custom tbody td,
                                        .table-custom tbody td span,
                                        .table-custom tbody td div {
                                            color: #000000 !important; /* Всегда черный текст в строках */
                                        }
                                    </style>
                            </thead>

                            <tbody>
                            @foreach($documents as $index =>$doc)
                                <tr style="font-size:14px; background-color: #fff !important;">
                                    <td style="padding:14px 12px;">
                                        <span class="fw-semibold">#{{ $index + 1 }}</span>
                                    </td>

                                    <td style="padding:14px 12px;">
                                        <div class="fw-semibold" style="font-size:14px;">
                                            {{ $doc->title }}
                                        </div>
                                        @if($doc->file_path)
                                            <small class="text-muted">
                                                {{ strtoupper(pathinfo($doc->file_path, PATHINFO_EXTENSION)) }}
                                                • {{ $doc->file_size ?? 'N/A' }}
                                            </small>
                                        @endif
                                    </td>

                                    <td style="padding:14px 12px;">
                <span class="status-badge status-{{ $doc->status }}">
                    {{ ucfirst($doc->status) }}
                </span>
                                    </td>

                                    <td style="padding:14px 12px;">
                                        {{ $doc->deadline ? $doc->deadline->format('Y-m-d') : '---' }}
                                    </td>

                                    <td style="padding:14px 12px;">
                                        {{ $doc->created_at->format('Y-m-d') }}
                                    </td>

                                    <td style="padding:14px 12px;">
                                        <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-light me-1 border">
                                            <i class="bi bi-eye" style="color: #000 !important;"></i>
                                        </a>
                                        <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-sm btn-light border">
                                            <i class="bi bi-pencil" style="color: #000 !important;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="stat-card mb-3">
                    <h6 class="fw-bold mb-3" data-i18n="quickActions">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{route('documents.create')}}" class="btn btn-outline-primary btn-sm rounded-3" onclick="showPage('documents', null)"><i class="bi bi-plus-lg me-2"></i><span data-i18n="createDocument">Create Document</span></a>
                        <a href="{{route('analysis.index')}}" class="btn btn-outline-warning btn-sm rounded-3" onclick="showPage('analysis', null)"><i class="bi bi-arrow-repeat me-2"></i><span data-i18n="reviewWorkflow">Analysis</span></a>
                        <a href="{{route('signatures.create')}}" class="btn btn-outline-success btn-sm rounded-3" onclick="showPage('signatures', null)"><i class="bi bi-pen me-2"></i><span data-i18n="manageSignatures">Manage Signatures</span></a>
                        <a href="{{route('notifications.index')}}" class="btn btn-outline-info btn-sm rounded-3" onclick="showPage('notifications', null)"><i class="bi bi-bell me-2"></i><span data-i18n="checkNotifications">Check Notifications</span></a>
                    </div>
                </div>
                <div class="stat-card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0" data-i18n="activityLog">
                            Activity Log
                        </h6>
                        <span class="badge bg-light text-dark border">Live</span>
                    </div>

                    <div style="max-height:280px; overflow-y:auto; padding-right:5px;">
                        @forelse($activities as $log)
                            <div class="d-flex align-items-start gap-3 mb-3 activity-item">

                                {{-- ИКОНКА (Индикатор типа действия) --}}
                                <div class="activity-icon rounded-circle d-flex align-items-center justify-content-center text-white"
                                     style="width: 35px; height: 35px; flex-shrink: 0;
                     background-color: @if($log->status == 'approved') #198754 @elseif($log->status == 'pending') #0d6efd @else #6c757d @endif !important;">

                                    @if($log->status == 'approved')
                                        <i class="bi bi-vector-pen"></i> {{-- Иконка подписи --}}
                                    @elseif($log->status == 'pending')
                                        <i class="bi bi-send-check"></i> {{-- Иконка отправки --}}
                                    @else
                                        <i class="bi bi-file-earmark-plus"></i> {{-- Иконка создания --}}
                                    @endif
                                </div>

                                {{-- ТЕКСТ СОБЫТИЯ --}}
                                <div class="flex-grow-1">
                                    <div style="font-size:13px; line-height: 1.4;">
                                        {{-- Имя пользователя (если есть связь в модели) --}}
                                        <span class="font-bold mix-blend-difference text-white">
    {{ $log->user->name ?? 'Система' }}:
</span>
<style>.log-username {
        color: #000000; /* Черный текст по умолчанию */
    }

    @media (prefers-color-scheme: dark) {
        .log-username {
            color: #ffffff; /* Белый текст, если у юзера темная тема в системе */
        }
    }</style>
                                        @if($log->status == 'approved')
                                            <span class="text-success">подписал(а) документ</span>
                                        @elseif($log->status == 'pending')
                                            <span class="text-primary">отправил(а) на согласование</span>
                                        @else
                                            <span class="text-muted">создал(а) новый документ</span>
                                        @endif

                                        <div class="fw-semibold mt-1" style="color: #444;">
                                            <i class="bi bi-file-earmark-text text-secondary"></i> {{ $log->title }}
                                        </div>
                                    </div>

                                    {{-- Краткое содержание или комментарий --}}
                                    @if($log->content)
                                        <div class="p-2 mt-2 bg-light rounded border-start border-3 border-secondary" style="font-size:11px; font-style: italic;">
                                            "{{ Str::limit($log->content, 60) }}"
                                        </div>
                                    @endif

                                    <div class="text-muted mt-2 d-flex align-items-center" style="font-size:10px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $log->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox d-block mb-2" style="font-size: 24px;"></i>
                                <span style="font-size:13px;">История активности пуста</span>
                            </div>
                        @endforelse
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .activity-item {
            padding: 8px;
            border-radius: 10px;
            transition: 0.2s;
        }

        .activity-item:hover {
            background: #f8fafc;
            transform: translateX(3px);
        }

        .activity-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            flex-shrink: 0;
            .table-custom {
                border-collapse: separate;
                border-spacing: 0 10px;
            }

            .table-custom tbody tr {
                background: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.06);
                border-radius: 10px;
                transition: 0.2s;
            }

            .table-custom tbody tr:hover {
                transform: scale(1.01);
                box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            }

            .table-custom td {
                border: none !important;
            }
        }</style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    welcomeBack: "С возвращением",
                    dashSubtitle: "Вот что происходит с вашими документами сегодня.",
                    totalDocs: "Всего документов",
                    signed: "Подписано",
                    badgeUsers: "Пользователи",
                    activeUsers: "Активные пользователи",
                    aiTitle: "AI Анализ",
                    aiSub: "Мгновенный разбор",
                    recentDocuments: "Последние документы",
                    viewAll: "Смотреть все",
                    thDoc: "Документ", thStatus: "Статус", thDeadline: "Срок", thDate: "Дата", thActions: "Действия",
                    quickActions: "Быстрые действия",
                    createDocument: "Создать документ",
                    reviewWorkflow: "Анализ",
                    manageSignatures: "Управление подписями",
                    checkNotifications: "Уведомления",
                    activityLog: "Журнал активности",
                    live: "Live",
                    actSigned: "подписал(а) документ",
                    actReview: "отправил(а) на согласование",
                    actCreated: "создал(а) новый документ",
                    emptyLog: "История активности пуста"
                },
                tj: {
                    welcomeBack: "Хуш омадед",
                    dashSubtitle: "Инҷо вазъи ҳуҷҷатҳои шумо имрӯз.",
                    totalDocs: "Ҳамаи ҳуҷҷатҳо",
                    signed: "Имзошуда",
                    badgeUsers: "Корбарон",
                    activeUsers: "Корбарони фаъол",
                    aiTitle: "Таҳлили AI",
                    aiSub: "Таҳлили фаврӣ",
                    recentDocuments: "Ҳуҷҷатҳои охирин",
                    viewAll: "Ҳамааш",
                    thDoc: "Ҳуҷҷат", thStatus: "Статус", thDeadline: "Мӯҳлат", thDate: "Сана", thActions: "Амалҳо",
                    quickActions: "Амалҳои фаврӣ",
                    createDocument: "Эҷоди ҳуҷҷат",
                    reviewWorkflow: "Таҳлил",
                    manageSignatures: "Имзоҳо",
                    checkNotifications: "Огоҳиномаҳо",
                    activityLog: "Журнали фаъолият",
                    live: "Зинда",
                    actSigned: "ҳуҷҷатро имзо кард",
                    actReview: "барои тасдиқ фиристод",
                    actCreated: "ҳуҷҷати нав сохт",
                    emptyLog: "Таърихи фаъолият холӣ аст"
                }
            };

            // Функция для применения перевода
            function applyTranslations() {
                const lang = localStorage.getItem('app-lang') || 'tj'; // По умолчанию TJ, как на скриншоте
                const t = translations[lang] || translations['ru'];

                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if (t[key]) {
                        // Если внутри есть теги (например, <span>), используем innerHTML, иначе textContent
                        if (el.children.length > 0) {
                            // Находим текстовый узел и меняем только его, не трогая теги
                            el.childNodes.forEach(node => {
                                if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== "") {
                                    node.textContent = t[key];
                                }
                            });
                        } else {
                            el.textContent = t[key];
                        }
                    }
                });
            }

            // Запускаем сразу
            applyTranslations();

            // Если у тебя есть переключатель языка, повесь на него событие вызова applyTranslations()
        });
    </script>
@endsection



