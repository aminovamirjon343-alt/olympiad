@extends('layouts.admin')

@section('content')
<div class="min-h-screen py-8 relative overflow-hidden" style="background: linear-gradient(135deg, #06070b 0%, #24243e 100%);">

    {{-- Ambient Lighting --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -left-40 w-[500px] h-[500px] rounded-full opacity-20 blur-[120px]" style="background: radial-gradient(circle, #4f8cff 0%, transparent 70%);"></div>
        <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] rounded-full opacity-15 blur-[140px]" style="background: radial-gradient(circle, #7c3aed 0%, transparent 70%);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full opacity-10 blur-[100px]" style="background: radial-gradient(circle, #4f8cff 0%, transparent 70%);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <style>

            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap');

            .logs-page {
                font-family: 'Inter', sans-serif;
            }

            .logs-page .mono {
                font-family: 'JetBrains Mono', monospace;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.035);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.06);
                border-radius: 1.25rem;
                box-shadow:
                    0 8px 32px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.05);
                overflow: hidden;
                position: relative;
            }

            .glass-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(79, 140, 255, 0.3), transparent);
                pointer-events: none;
            }

            .logs-table th {
                padding: 1rem 1.25rem;
                font-family: 'JetBrains Mono', monospace;
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: rgba(148, 163, 184, 0.7);
                background: rgba(255, 255, 255, 0.02);
                border-bottom: 1px solid rgba(255, 255, 255, 0.06);
                white-space: nowrap;
            }

            .logs-table td {
                padding: 1rem 1.25rem;
                font-size: 0.85rem;
                color: rgba(226, 232, 240, 0.9);
                vertical-align: middle;
                border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            }

            .tr-hover {
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .tr-hover:hover {
                background: rgba(79, 140, 255, 0.05);
                transform: translateX(2px);
            }

            .tr-hover:hover td {
                color: #fff;
            }

            .action-badge {
                padding: 0.35rem 0.75rem;
                font-family: 'JetBrains Mono', monospace;
                font-size: 0.65rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                border-radius: 999px;
                border: 1px solid;
                backdrop-filter: blur(10px);
                transition: all 0.2s ease;
            }

            .action-badge:hover {
                transform: scale(1.05);
                box-shadow: 0 0 20px currentColor;
            }

            .mini-avatar {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'JetBrains Mono', monospace;
                font-size: 0.8rem;
                font-weight: 800;
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
                transition: all 0.2s ease;
            }

            .tr-hover:hover .mini-avatar {
                transform: scale(1.1);
                box-shadow: 0 0 20px rgba(79, 140, 255, 0.4);
            }

            .delete-btn {
                width: 34px;
                height: 34px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                background: rgba(239, 68, 68, 0.1);
                border: 1px solid rgba(239, 68, 68, 0.2);
                color: #ef4444;
            }

            .delete-btn:hover {
                transform: scale(1.1) rotate(-5deg);
                background: rgba(239, 68, 68, 0.2);
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
                border-color: rgba(239, 68, 68, 0.4);
            }

            .custom-scroll::-webkit-scrollbar {
                height: 6px;
            }

            .custom-scroll::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.02);
            }

            .custom-scroll::-webkit-scrollbar-thumb {
                background: rgba(79, 140, 255, 0.3);
                border-radius: 20px;
            }

            .custom-scroll::-webkit-scrollbar-thumb:hover {
                background: rgba(79, 140, 255, 0.5);
            }

            .pulse-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #10b981;
                box-shadow: 0 0 12px #10b981;
                animation: pulse-glow 2s ease-in-out infinite;
            }

            @keyframes pulse-glow {
                0%, 100% { opacity: 1; box-shadow: 0 0 12px #10b981; }
                50% { opacity: 0.6; box-shadow: 0 0 20px #10b981; }
            }

            .glow-text {
                text-shadow: 0 0 30px rgba(79, 140, 255, 0.3);
            }

            /* ============================================ */
            /* === ПАГИНАЦИЯ — ТОЛЬКО PREV/NEXT === */
            /* ============================================ */
            .pagination-wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 12px;
                margin-top: 24px;
            }

            .pagination-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 140px;
                height: 44px;
                padding: 0 24px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 700;
                font-family: 'Inter', sans-serif;
                color: rgba(226, 232, 240, 0.9);
                background: rgba(255, 255, 255, 0.035);
                border: 1px solid rgba(255, 255, 255, 0.06);
                text-decoration: none;
                transition: all 0.25s ease;
                cursor: pointer;
                letter-spacing: 0.5px;
                backdrop-filter: blur(10px);
            }

            .pagination-btn:hover:not(.disabled) {
                color: #fff;
                border-color: rgba(79, 140, 255, 0.4);
                background: rgba(79, 140, 255, 0.1);
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(79, 140, 255, 0.3);
            }

            .pagination-btn.disabled {
                opacity: 0.3;
                cursor: not-allowed;
                pointer-events: none;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .pagination-btn {
                    min-width: 120px;
                    height: 40px;
                    padding: 0 18px;
                    font-size: 12px;
                }
            }
        </style>

        <div class="logs-page">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-8 gap-4">

                <div>
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white uppercase glow-text">
                        <span data-i18n="historyTitle">История событий</span>
                    </h1>

                    <p class="mono text-xs font-medium text-slate-400 uppercase tracking-[0.3em] mt-2">
                        <span data-i18n="systemArchive">System Log Archive</span>
                    </p>
                </div>

                <div class="glass-card px-4 py-2.5 flex items-center gap-3">
                    <div class="pulse-dot"></div>
                    <span class="mono text-xs font-bold text-slate-300 flex gap-2 items-center">
                            <span id="logsCountNumber" class="text-[#4f8cff]">{{ count($logs) }}</span>
                            <span data-i18n="logsText" class="text-slate-400">логов</span>
                        </span>
                </div>

            </div>

            {{-- TABLE --}}
            <div class="glass-card">

                <div class="overflow-x-auto custom-scroll">

                    <table class="w-full text-left logs-table border-collapse min-w-[900px]">

                        {{-- HEAD --}}
                        <thead>
                        <tr>
                            <th class="w-20 text-center" data-i18n="colId">ID</th>
                            <th data-i18n="colDoc">Документ</th>
                            <th data-i18n="colUser">Инициатор</th>
                            <th data-i18n="colAction">Тип действия</th>
                            <th class="hidden lg:table-cell" data-i18n="colMeta">Мета-данные</th>
                            <th data-i18n="colTime">Время</th>
                            <th class="text-right" data-i18n="colManage">Управление</th>
                        </tr>
                        </thead>

                        {{-- BODY --}}
                        <tbody>

                        @forelse($logs as $index => $log)

                        <tr class="tr-hover">

                            {{-- ID --}}
                            <td class="text-center mono font-bold text-slate-500 text-xs">
                                #{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            {{-- DOCUMENT --}}
                            <td>
                                        <span class="font-bold text-white truncate block max-w-[200px] text-sm">
                                            {{ $log->document->title ?? '—' }}
                                        </span>
                            </td>

                            {{-- USER --}}
                            <td>
                                <div class="flex items-center gap-3">

                                    @php
                                    $name = $log->user->name ?? 'System';
                                    $firstChar = mb_substr($name, 0, 1);

                                    $avatarStyle = match(strtoupper($firstChar)) {
                                    'A','R' => 'bg-gradient-to-br from-red-500/20 to-red-600/10 text-red-400 border-red-500/30',
                                    'B','D' => 'bg-gradient-to-br from-blue-500/20 to-blue-600/10 text-blue-400 border-blue-500/30',
                                    'S'     => 'bg-gradient-to-br from-slate-500/20 to-slate-600/10 text-slate-400 border-slate-500/30',
                                    default => 'bg-gradient-to-br from-indigo-500/20 to-indigo-600/10 text-indigo-400 border-indigo-500/30'
                                    };
                                    @endphp

                                    <div class="mini-avatar {{ $avatarStyle }}">
                                        {{ strtoupper($firstChar) }}
                                    </div>

                                    <span class="font-semibold text-slate-300 text-sm truncate max-w-[120px]">
                                                {{ $name }}
                                            </span>

                                </div>
                            </td>

                            {{-- ACTION --}}
                            <td>

                                @php
                                $action = strtolower($log->action);

                                $actionKey = match(true) {
                                str_contains($action, 'create') || str_contains($action, 'создание') => 'actionCreated',
                                str_contains($action, 'update') || str_contains($action, 'обновление') => 'actionUpdated',
                                str_contains($action, 'delete') || str_contains($action, 'удаление') => 'actionDeleted',
                                str_contains($action, 'sign') || str_contains($action, 'подпись') => 'actionSigned',
                                str_contains($action, 'status') || str_contains($action, 'статус') => 'actionStatus',
                                default => 'actionUnknown'
                                };

                                $actionColor = match($actionKey) {
                                'actionDeleted' => 'bg-red-500/10 text-red-400 border-red-500/30',
                                'actionCreated' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
                                'actionUpdated' => 'bg-blue-500/10 text-blue-400 border-blue-500/30',
                                'actionSigned'  => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/30',
                                default         => 'bg-slate-500/10 text-slate-400 border-slate-500/30'
                                };
                                @endphp

                                <span class="action-badge {{ $actionColor }}" data-i18n="{{ $actionKey }}">
                                            {{ $log->action }}
                                        </span>

                            </td>

                            {{-- META --}}
                            <td class="hidden lg:table-cell">
                                        <span class="text-slate-400 font-medium text-xs italic leading-relaxed block max-w-[220px] truncate">
                                            {{ $log->description }}
                                        </span>
                            </td>

                            {{-- TIME --}}
                            <td class="mono font-semibold text-slate-300 text-xs whitespace-nowrap">
                                {{ $log->created_at->format('d.m.y / H:i') }}
                            </td>

                            {{-- DELETE --}}
                            <td class="text-right">

                                <form action="{{ route('logs.destroy', $log->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" data-confirm-i18n="confirmDelete" class="delete-btn group">
                                        <i class="bi bi-trash3 text-sm transition-transform duration-300 group-hover:rotate-12"></i>
                                    </button>
                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-slate-500/10 flex items-center justify-center border border-slate-500/20">
                                        <i class="bi bi-inbox text-2xl text-slate-500"></i>
                                    </div>
                                    <span class="mono text-xs font-bold uppercase tracking-[0.3em] text-slate-500" data-i18n="noLogs">
                                                No logs found
                                            </span>
                                </div>
                            </td>
                        </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Pagination - только Previous и Next --}}
            @if($logs->hasPages())
            <div class="pagination-wrapper">
                @if($logs->onFirstPage())
                <span class="pagination-btn disabled">« Previous</span>
                @else
                <a href="{{ $logs->previousPageUrl() }}" class="pagination-btn">« Previous</a>
                @endif

                @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="pagination-btn">Next »</a>
                @else
                <span class="pagination-btn disabled">Next »</span>
                @endif
            </div>
            @endif

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ============================================================
        // ЛОКАЛЬНЫЙ СЛОВАРЬ СТРАНИЦЫ ИСТОРИИ СОБЫТИЙ
        // (дополняет глобальный TRANSLATIONS из layouts/admin.blade.php)
        // ============================================================
        const LOGS_TRANSLATIONS = {
            ru: {
                historyTitle: 'История событий',
                systemArchive: 'Архив системных логов',
                colId: 'ID',
                colDoc: 'Документ',
                colUser: 'Инициатор',
                colAction: 'Тип действия',
                colMeta: 'Мета-данные',
                colTime: 'Время',
                colManage: 'Управление',
                actionCreated: 'Создание',
                actionUpdated: 'Обновление',
                actionDeleted: 'Удаление',
                actionSigned: 'Подписание',
                actionStatus: 'Смена статуса',
                actionUnknown: 'Действие',
                noLogs: 'Записи не найдены',
                confirmDelete: 'Удалить запись?',
                logsText: 'логов'
            },
            tj: {
                historyTitle: 'Таърихи ҳодисаҳо',
                systemArchive: 'Архиви системаи логҳо',
                colId: 'ID',
                colDoc: 'Ҳуҷҷат',
                colUser: 'Ташаббускор',
                colAction: 'Навъи амал',
                colMeta: 'Мета-маълумот',
                colTime: 'Вақт',
                colManage: 'Идоракунӣ',
                actionCreated: 'Сохтан',
                actionUpdated: 'Навсозӣ',
                actionDeleted: 'Нест кардан',
                actionSigned: 'Имзо',
                actionStatus: 'Ивази статус',
                actionUnknown: 'Амал',
                noLogs: 'Сабтҳо ёфт нашуданд',
                confirmDelete: 'Сабт нест шавад?',
                logsText: 'логҳо'
            },
            en: {
                historyTitle: 'Event History',
                systemArchive: 'System Log Archive',
                colId: 'ID',
                colDoc: 'Document',
                colUser: 'Initiator',
                colAction: 'Action Type',
                colMeta: 'Meta Data',
                colTime: 'Time',
                colManage: 'Management',
                actionCreated: 'Creation',
                actionUpdated: 'Update',
                actionDeleted: 'Deletion',
                actionSigned: 'Signing',
                actionStatus: 'Status Change',
                actionUnknown: 'Action',
                noLogs: 'No logs found',
                confirmDelete: 'Delete this record?',
                logsText: 'logs'
            }
        };

        // ============================================================
        // ФУНКЦИЯ ПРИМЕНЕНИЯ ПЕРЕВОДОВ НА ЭТОЙ СТРАНИЦЕ
        // ============================================================
        function applyLogsTranslations(lang) {
            const dict = LOGS_TRANSLATIONS[lang] || LOGS_TRANSLATIONS.ru;

            // 1) Переводим все элементы с data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dict[key] !== undefined) el.textContent = dict[key];
            });

            // 2) Переводим placeholder
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (dict[key] !== undefined) el.setAttribute('placeholder', dict[key]);
            });

            // 3) Переводим title
            document.querySelectorAll('[data-i18n-title]').forEach(el => {
                const key = el.getAttribute('data-i18n-title');
                if (dict[key] !== undefined) el.setAttribute('title', dict[key]);
            });

            // 4) Обновляем обработчики confirm для кнопок удаления
            //    (важно: берём актуальный перевод при каждом клике)
            document.querySelectorAll('[data-confirm-i18n]').forEach(el => {
                const key = el.getAttribute('data-confirm-i18n');

                // Удаляем старый обработчик, чтобы не было дублей
                const newBtn = el.cloneNode(true);
                el.parentNode.replaceChild(newBtn, el);

                // Вешаем новый обработчик с актуальным переводом
                newBtn.addEventListener('click', function (e) {
                    const currentLang = localStorage.getItem('docsign_lang') || 'ru';
                    const currentDict = LOGS_TRANSLATIONS[currentLang] || LOGS_TRANSLATIONS.ru;
                    const message = currentDict[key] || 'Are you sure?';

                    if (!confirm(message)) {
                        e.preventDefault();
                    }
                });
            });
        }

        // ============================================================
        // 1. Применяем сразу при загрузке
        // ============================================================
        const initialLang = localStorage.getItem('docsign_lang') || 'ru';
        applyLogsTranslations(initialLang);

        // ============================================================
        // 2. Слушаем событие смены языка от layouts/admin.blade.php
        //    (когда юзер кликает на 🇷🇺/🇹🇯/🇬🇧 в админке)
        // ============================================================
        window.addEventListener('docsign:lang-changed', (e) => {
            const lang = e.detail?.lang || 'ru';
            applyLogsTranslations(lang);
        });

        // ============================================================
        // 3. Синхронизация между вкладками браузера
        // ============================================================
        window.addEventListener('storage', (e) => {
            if (e.key === 'docsign_lang' && e.newValue) {
                applyLogsTranslations(e.newValue);
            }
        });
    });
</script>
<style>
    /* Контейнер кнопок */
.action-btns {
display: flex;
gap: 8px;
align-items: center;
justify-content: flex-end;
}

/* Базовые стили кнопок */
.action-btn {
display: inline-flex;
align-items: center;
justify-content: center;
width: 36px;
height: 36px;
border-radius: 8px;
border: 1px solid rgba(255, 255, 255, 0.1);
background: rgba(255, 255, 255, 0.05);
cursor: pointer;
transition: all 0.2s ease;
text-decoration: none;
}

.action-btn i {
font-size: 16px;
color: #fff;
}

/* Кнопка редактирования */
.action-btn-edit {
background: rgba(79, 140, 255, 0.15);
border-color: rgba(79, 140, 255, 0.3);
}

.action-btn-edit:hover {
background: rgba(79, 140, 255, 0.3);
border-color: #4f8cff;
transform: translateY(-2px);
box-shadow: 0 4px 12px rgba(79, 140, 255, 0.3);
}

.action-btn-edit i {
color: #4f8cff;
}

/* Кнопка удаления */
.action-btn-delete {
background: rgba(255, 107, 107, 0.15);
border-color: rgba(255, 107, 107, 0.3);
}

.action-btn-delete:hover {
background: rgba(255, 107, 107, 0.3);
border-color: #ff6b6b;
transform: translateY(-2px);
box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
}

.action-btn-delete i {
color: #ff6b6b;
}

/* Модальное окно */
.modal-overlay {
position: fixed;
top: 0;
left: 0;
right: 0;
bottom: 0;
background: rgba(0, 0, 0, 0.7);
backdrop-filter: blur(4px);
display: flex;
align-items: center;
justify-content: center;
z-index: 1000;
}

.modal-box {
background: #1a1f2e;
border: 1px solid rgba(255, 255, 255, 0.1);
border-radius: 16px;
padding: 24px;
max-width: 400px;
width: 90%;
box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.modal-title {
display: flex;
align-items: center;
gap: 12px;
font-size: 18px;
font-weight: 600;
color: #fff;
margin: 0 0 12px 0;
}

.modal-title i {
color: #ff6b6b;
font-size: 24px;
}

.modal-desc {
font-size: 14px;
color: #8892a6;
margin: 0 0 24px 0;
line-height: 1.5;
}

.modal-actions {
display: flex;
gap: 12px;
justify-content: flex-end;
}

.modal-btn {
padding: 10px 20px;
border-radius: 8px;
border: none;
font-size: 14px;
font-weight: 600;
cursor: pointer;
transition: all 0.2s ease;
}

.modal-btn-cancel {
background: rgba(255, 255, 255, 0.1);
color: #fff;
}

.modal-btn-cancel:hover {
background: rgba(255, 255, 255, 0.2);
}

.modal-btn-delete {
background: #ff6b6b;
color: #fff;
}

.modal-btn-delete:hover {
background: #ff5252;
transform: translateY(-1px);
box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
}

/* Alpine.js x-cloak */
[x-cloak] {
display: none !important;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@endsection