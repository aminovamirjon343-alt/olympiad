@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">

    @php
        $hasOverdue = $signatures->contains(fn($s) => !$s->signed_at && $s->expires_at && $s->expires_at->isPast());
        $allSigned = $signatures->isNotEmpty() && $signatures->every(fn($s) => $s->signed_at);

        $statusOverlay = '';
        if ($hasOverdue) {
            $statusOverlay = 'bg-red-500/5';
        } elseif ($allSigned) {
            $statusOverlay = 'bg-blue-500/5';
        }
    @endphp

    <div class="p-6 max-w-7xl mx-auto min-h-screen transition-colors duration-700 {{ $statusOverlay }}">
        <style>
            .sig-page {
                --primary-color: #6366f1;
                font-family: 'Inter', sans-serif !important;
            }
            .navbar-style-text, h1, h3, label, span, p, a, button, div {
                font-family: 'Inter', sans-serif !important;
            }
            .card-sig {
                background: rgba(255, 255, 255, 1) !important;
                backdrop-filter: blur(8px);
                border: 1.5px solid rgba(0, 0, 0, 0.12);
                border-radius: 2rem;
                overflow: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.5), 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .dark .card-sig { background: rgba(30, 41, 59, 1) !important; border-color: rgba(255, 255, 255, 0.2); }
            .dark .signature-img { filter: invert(1) brightness(2); }
            .card-sig:hover { transform: translateY(-6px); border-color: var(--primary-color); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
            .card-overdue { border: 2px solid #f43f5e !important; }
            .sig-area {
                min-height: 120px;
                background: rgba(0, 0, 0, 0.03) !important;
                display: flex;
                align-items: center;
                justify-content: center;
                border-top: 1px solid rgba(0, 0, 0, 0.08);
                border-bottom: 1px solid rgba(0, 0, 0, 0.08);
                position: relative;
            }
            .btn-primary-custom {
                background-color: var(--primary-color);
                color: #fff !important;
                border-radius: 1rem;
                font-weight: 900;
                letter-spacing: 0.02em;
                text-transform: uppercase;
                transition: all 0.2s;
            }
            .user-avatar {
                width: 38px; height: 38px; border-radius: 12px;
                background: rgba(99, 102, 241, 0.1);
                display: flex; align-items: center; justify-content: center;
                font-weight: 900; color: var(--primary-color);
            }
            .action-link { font-weight: 800; text-transform: uppercase; font-size: 10px; letter-spacing: 0.1em; }
            .label-micro { font-size: 8px !important; font-weight: 900 !important; text-transform: uppercase !important; letter-spacing: 0.15em !important; opacity: 0.4; }

            /* Индикатор формата */
            .format-badge {
                position: absolute;
                top: 8px;
                right: 8px;
                padding: 2px 6px;
                border-radius: 6px;
                font-size: 8px;
                font-weight: 900;
                color: white;
                text-transform: uppercase;
            }
        </style>

        <div class="sig-page">
            <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-black tracking-tighter text-slate-900 dark:text-white" data-i18n="pageTitle">Реестр подписей</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 rounded-full {{ $hasOverdue ? 'bg-rose-500 animate-pulse' : ($allSigned ? 'bg-emerald-500' : 'bg-slate-400') }}"></span>
                        <p class="label-micro !opacity-60 dark:text-slate-400" data-i18n="{{ $hasOverdue ? 'sysUrgent' : ($allSigned ? 'sysComplete' : 'sysActive') }}">
                            {{ $hasOverdue ? 'Требуется срочное внимание' : ($allSigned ? 'Все документы оформлены' : 'Система мониторинга активна') }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('signatures.create') }}" class="btn-primary-custom px-7 py-3.5 text-xs flex items-center gap-2 shadow-xl shadow-indigo-500/20 hover:scale-105 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
                    <span data-i18n="btnNew">Новая запись</span>
                </a>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($signatures as $index => $s)
                    @php
                        $isPast = !$s->signed_at && $s->expires_at && $s->expires_at->isPast();
                        $extension = $s->document && $s->document->file_path ? strtolower(pathinfo($s->document->file_path, PATHINFO_EXTENSION)) : null;
                        $isWord = in_array($extension, ['doc', 'docx']);
                    @endphp

                    <div class="card-sig {{ $isPast ? 'card-overdue' : '' }}">
                        <div class="px-6 py-4 flex justify-between items-center">
                            <span class="label-micro !opacity-100 {{ $isPast ? 'text-rose-500' : 'text-indigo-500' }}">
                                @if($isPast)
                                    <span data-i18n="overdueLabel">❗ СРОК ИСТЕК</span>
                                @else
                                    <span data-i18n="docLabel">Документ</span> #{{ ($signatures->currentPage() - 1) * $signatures->perPage() + $index + 1 }}
                                @endif
                            </span>
                            <span class="label-micro">ID-{{ $s->id }}</span>
                        </div>

                        <div class="px-6 pb-5">
                            <div class="flex items-center gap-2 mb-1">
                                @if($isWord)
                                    <i class="bi bi-file-earmark-word-fill text-blue-500 text-sm"></i>
                                @elseif($extension == 'pdf')
                                    <i class="bi bi-file-earmark-pdf-fill text-red-500 text-sm"></i>
                                @endif
                                <h3 class="text-xl font-bold leading-tight truncate text-slate-800 dark:text-slate-100 tracking-tight">
                                    {{ $s->document->title ?? 'Без названия' }}
                                </h3>
                            </div>
                        </div>

                        <div class="sig-area">
                            @if($extension)
                                <div class="format-badge {{ $isWord ? 'bg-blue-600' : 'bg-red-600' }}">
                                    {{ $extension }}
                                </div>
                            @endif

                            @if($s->signature)
                                <img src="{{ $s->signature }}" class="signature-img h-16 w-auto object-contain" alt="Signature">
                            @else
                                <div class="text-center py-4">
                                    <span class="label-micro !opacity-30 italic" data-i18n="waitingSig">Ожидает подписи</span>
                                </div>
                            @endif
                        </div>

                        <div class="px-6 py-5 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="user-avatar text-[10px] shadow-sm">
                                    {{ mb_strtoupper(mb_substr($s->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="label-micro dark:text-white" data-i18n="labelExecutor">Исполнитель</div>
                                    <div class="text-[14px] font-bold leading-none text-slate-800 dark:text-slate-200 tracking-tight">{{ Str::limit($s->user->name ?? 'Неизвестен', 12) }}</div>
                                </div>
                            </div>

                            @php
                                $docDeadline = $s->document->deadline ?? null;
                                $isPastDate = !$s->signed_at && $docDeadline && \Carbon\Carbon::parse($docDeadline)->isPast();
                            @endphp

                            <div class="text-right">
                                <div class="label-micro dark:text-white" data-i18n="{{ $s->signed_at ? 'labelDone' : 'labelDeadline' }}">
                                    {{ $s->signed_at ? 'Завершено' : 'Дедлайн' }}
                                </div>
                                <div class="text-[14px] font-bold leading-none {{ $isPastDate ? 'text-rose-600' : 'text-slate-800 dark:text-slate-200' }}">
                                    {{ $docDeadline ? \Carbon\Carbon::parse($docDeadline)->format('d.m.Y') : '--' }}
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 border-t border-black/5 dark:border-white/5 flex justify-center gap-6 bg-black/[0.02] dark:bg-white/[0.02]">
                            <a href="{{ route('signatures.show', $s->id) }}" class="text-indigo-500 hover:text-indigo-700 action-link" data-i18n="linkOpen">Открыть</a>
                            @if(auth()->user()->is_admin || auth()->id() === $s->user_id)
                                <a href="{{ route('signatures.edit', $s->id) }}" class="text-amber-500 hover:text-amber-600 action-link" data-i18n="linkEdit">Правка</a>
                                <form action="{{ route('signatures.destroy', $s->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 action-link" data-i18n="linkDelete" onclick="return confirm('Удалить?')">Удалить</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-[2rem]">
                        <p class="text-sm font-bold text-slate-400 label-micro" data-i18n="emptyRegistry">В реестре пока нет записей</p>
                    </div>
                @endforelse
            </div>

            @if($signatures->hasPages())
                <div class="mt-12">
                    {{ $signatures->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const translations = {
                ru: {
                    pageTitle: "Реестр подписей",
                    sysUrgent: "Требуется срочное внимание",
                    sysComplete: "Все документы оформлены",
                    sysActive: "Система мониторинга активна",
                    btnNew: "Новая запись",
                    overdueLabel: "❗ СРОК ИСТЕК",
                    docLabel: "Документ",
                    waitingSig: "Ожидает подписи",
                    labelExecutor: "Исполнитель",
                    labelDone: "Завершено",
                    labelDeadline: "Дедлайн",
                    linkOpen: "Открыть",
                    linkEdit: "Правка",
                    linkDelete: "Удалить",
                    emptyRegistry: "В реестре пока нет записей"
                },
                tj: {
                    pageTitle: "Феҳристи имзоҳо",
                    sysUrgent: "Таваҷҷӯҳи фаврӣ лозим аст",
                    sysComplete: "Ҳамаи ҳуҷҷатҳо ба расмият дароварда шудаанд",
                    sysActive: "Системаи мониторинг фаъол аст",
                    btnNew: "Сабти нав",
                    overdueLabel: "❗ МУҲЛАТ ГУЗАШТ",
                    docLabel: "Ҳуҷҷат",
                    waitingSig: "Мунтазири имзо",
                    labelExecutor: "Иҷрокунанда",
                    labelDone: "Анҷом ёфт",
                    labelDeadline: "Муҳлат",
                    linkOpen: "Кушодан",
                    linkEdit: "Таҳрир",
                    linkDelete: "Нест кардан",
                    emptyRegistry: "Дар феҳрист ҳоло ягон сабт нест"
                },
                en: {
                    pageTitle: "Signature Registry",
                    sysUrgent: "Urgent attention required",
                    sysComplete: "All documents processed",
                    sysActive: "Monitoring system active",
                    btnNew: "New Entry",
                    overdueLabel: "❗ OVERDUE",
                    docLabel: "Document",
                    waitingSig: "Awaiting signature",
                    labelExecutor: "Executor",
                    labelDone: "Completed",
                    labelDeadline: "Deadline",
                    linkOpen: "Open",
                    linkEdit: "Edit",
                    linkDelete: "Delete",
                    emptyRegistry: "No entries in the registry yet"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });
        });
    </script>
@endsection
