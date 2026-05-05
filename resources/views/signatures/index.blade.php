@extends('layouts.admin')

@section('content')
    @php
        // 1. Проверяем наличие просроченных (не подписаны и срок истек)
        $hasOverdue = $signatures->contains(fn($s) => !$s->signed_at && $s->expires_at && $s->expires_at->isPast());

        // 2. Проверяем, все ли подписаны
        $allSigned = $signatures->isNotEmpty() && $signatures->every(fn($s) => $s->signed_at);

        // 3. Выбираем цвет фона для всей страницы
        $mainBg = 'bg-slate-50'; // Стандарт
        if ($hasOverdue) {
            $mainBg = 'bg-red-50'; // Тревога
        } elseif ($allSigned) {
            $mainBg = 'bg-blue-50'; // Все ок
        }
    @endphp

    <div class="p-6 max-w-7xl mx-auto min-h-screen transition-colors duration-700 {{ $mainBg }}">
        <style>
            .sig-page {
                --primary-color: var(--primary, #6366f1);
            }

            .card-sig {
                background: #ffffff !important;
                border: 1px solid rgba(0, 0, 0, 0.08);
                border-radius: 1.5rem;
                overflow: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }

            .card-sig:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            }

            /* Стиль для просроченной карточки */
            .card-overdue {
                border: 2px solid #ef4444 !important;
                box-shadow: 0 0 15px rgba(239, 68, 68, 0.1);
            }

            .card-sig .text-black-forced { color: #1e293b !important; }
            .card-sig .text-muted-forced { color: #64748b !important; }

            .sig-area {
                min-height: 120px;
                background: #fcfcfd !important;
                display: flex;
                align-items: center;
                justify-content: center;
                border-top: 1px solid #f1f5f9;
                border-bottom: 1px solid #f1f5f9;
            }

            .btn-primary-custom {
                background-color: var(--primary-color);
                color: #fff !important;
                border-radius: 0.75rem;
                font-weight: 700;
                transition: all 0.2s;
            }

            .user-avatar {
                width: 40px; height: 40px; border-radius: 50%;
                background: #f1f5f9;
                display: flex; align-items: center; justify-content: center;
                font-weight: bold; color: var(--primary-color);
                border: 1px solid #e2e8f0;
            }

            .action-link {
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 0.05em;
            }
        </style>

        <div class="sig-page">
            <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Реестр подписей</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 rounded-full {{ $hasOverdue ? 'bg-red-500 animate-pulse' : ($allSigned ? 'bg-blue-500' : 'bg-slate-400') }}"></span>
                        <p class="text-sm opacity-70 font-medium uppercase tracking-wider text-slate-700">
                            {{ $hasOverdue ? 'Требуется срочное внимание' : ($allSigned ? 'Все документы оформлены' : 'Система мониторинга активна') }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('signatures.create') }}" class="btn-primary-custom px-6 py-3 flex items-center gap-2 shadow-lg hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
                    НОВАЯ ПОДПИСЬ
                </a>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($signatures as $index => $s)
                    @php
                        $isPast = !$s->signed_at && $s->expires_at && $s->expires_at->isPast();
                    @endphp

                    <div class="card-sig {{ $isPast ? 'card-overdue' : '' }}">
                        <div class="px-6 py-4 flex justify-between items-center bg-white">
                            <span class="text-[11px] font-black uppercase tracking-widest {{ $isPast ? 'text-red-500' : 'text-indigo-500' }}">
                                {{ $isPast ? '❗ СРОК ИСТЕК' : 'Документ #' . ($index + 1) }}
                            </span>
                            <span class="text-[11px] font-bold tracking-widest text-muted-forced">ID-{{ $s->id }}</span>
                        </div>

                        <div class="px-6 pb-4 bg-white">
                            <h3 class="text-2xl font-bold leading-tight truncate text-black-forced">
                                {{ $s->document->title ?? 'Без названия' }}
                            </h3>
                        </div>

                        <div class="sig-area">
                            @if($s->signature)
                                <img src="{{ $s->signature }}" class="h-20 w-auto object-contain" alt="Signature">
                            @else
                                <div class="text-center py-4">
                                    <div class="text-2xl mb-1">⏳</div>
                                    <span class="text-xs text-gray-400 font-medium italic">Ожидает подписи</span>
                                </div>
                            @endif
                        </div>

                        <div class="px-6 py-5 flex justify-between items-center bg-white">
                            <div class="flex items-center gap-3">
                                <div class="user-avatar text-xs shadow-sm">
                                    {{ mb_strtoupper(mb_substr($s->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase tracking-tighter text-muted-forced">Исполнитель</div>
                                    <div class="text-[15px] font-bold leading-none text-black-forced">{{ $s->user->name ?? 'Неизвестен' }}</div>
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-[10px] font-bold uppercase tracking-tighter text-muted-forced">
                                    {{ $s->signed_at ? 'Завершено' : 'Дедлайн' }}
                                </div>
                                <div class="text-[15px] font-bold leading-none {{ $isPast ? 'text-red-600' : 'text-black-forced' }}">
                                    {{ ($s->signed_at ?? $s->expires_at)?->format('d.m.Y') ?? '--' }}
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 border-t border-gray-100 flex justify-center gap-6 bg-gray-50/80">
                            {{-- Открыть доступно всем --}}
                            <a href="{{ route('signatures.show', $s->id) }}" class="text-indigo-500 hover:text-indigo-700 action-link">Открыть</a>

                            {{-- Правка и Удаление только для админа или владельца подписи --}}
                            @if(auth()->user()->is_admin || auth()->id() === $s->user_id)
                                <a href="{{ route('signatures.edit', $s->id) }}" class="text-orange-400 hover:text-orange-600 action-link">Правка</a>
                                <form action="{{ route('signatures.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить запись?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 action-link">Удалить</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center border-2 border-dashed border-slate-300 rounded-3xl bg-white/50">
                        <p class="text-xl font-bold text-slate-400">В реестре пока нет записей</p>
                    </div>
                @endforelse
            </div>

            @if($signatures->hasPages())
                <div class="mt-12 p-4 bg-white rounded-2xl shadow-sm">
                    {{ $signatures->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
