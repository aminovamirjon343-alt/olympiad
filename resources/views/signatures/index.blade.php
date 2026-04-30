{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8">--}}

{{--        --}}{{----}}{{----}}{{----}}{{-- Header / Заголовок --}}
{{--        <div class="flex items-center justify-between mb-8">--}}
{{--            <div>--}}
{{--                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Журнал подписей</h1>--}}
{{--                <p class="text-sm font-medium text-gray-500 mt-1 uppercase tracking-wider">История и управление цифровыми подписями</p>--}}
{{--            </div>--}}
{{--            <a href="{{ route('signatures.create') }}" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition transform active:scale-95 flex items-center gap-2">--}}
{{--                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>--}}
{{--                Создать подпись--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        --}}{{----}}{{----}}{{----}}{{-- Alerts / Сообщения --}}
{{--        @if(session('success'))--}}
{{--            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-3 rounded-xl fade-in">--}}
{{--                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>--}}
{{--                <span class="font-bold text-sm">{{ session('success') }}</span>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        --}}{{----}}{{----}}{{----}}{{-- Table Card --}}
{{--        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">--}}
{{--            <div class="overflow-x-auto">--}}
{{--                <table class="w-full text-left">--}}
{{--                    <thead>--}}
{{--                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-400">--}}
{{--                        <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-widest w-16 text-center">ID</th>--}}
{{--                        <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-widest">Документ</th>--}}
{{--                        <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-widest">Сотрудник</th>--}}
{{--                        <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-widest text-center">Визуальная подпись</th>--}}
{{--                        <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-widest">Дата</th>--}}
{{--                        <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-widest text-right">Действия</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="divide-y divide-gray-50">--}}
{{--                    @forelse($signatures as $s)--}}
{{--                        <tr class="hover:bg-indigo-50/20 transition-all duration-200 group">--}}
{{--                            <td class="px-6 py-5 text-center text-gray-400 font-mono text-xs">#{{ $s->id }}</td>--}}

{{--                            <td class="px-6 py-5">--}}
{{--                                <div class="font-bold text-gray-800 text-sm tracking-tight truncate max-w-[200px]">--}}
{{--                                    {{ $s->document->title ?? '—' }}--}}
{{--                                </div>--}}
{{--                            </td>--}}

{{--                            <td class="px-6 py-5">--}}
{{--                                <div class="flex items-center gap-2">--}}
{{--                                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-500 uppercase">--}}
{{--                                        {{ Str::substr($s->user->name ?? '?', 0, 1) }}--}}
{{--                                    </div>--}}
{{--                                    <span class="text-sm font-semibold text-gray-600">{{ $s->user->name ?? '—' }}</span>--}}
{{--                                </div>--}}
{{--                            </td>--}}

{{--                            <td class="px-6 py-5">--}}
{{--                                <div class="flex justify-center">--}}
{{--                                    @if($s->signature)--}}
{{--                                        <div class="bg-white p-1 border border-gray-100 rounded-lg shadow-sm group-hover:scale-110 transition-transform">--}}
{{--                                            <img src="{{ $s->signature }}" class="h-10 w-auto object-contain" alt="Signature">--}}
{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        <span class="text-gray-300 italic text-xs">Нет подписи</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </td>--}}

{{--                            <td class="px-6 py-5">--}}
{{--                                <span class="text-xs font-bold text-gray-500 tracking-tighter">--}}
{{--                                    {{ $s->signed_at ? \Carbon\Carbon::parse($s->signed_at)->format('d.m.Y H:i') : '—' }}--}}
{{--                                </span>--}}
{{--                            </td>--}}

{{--                            <td class="px-6 py-5 text-right">--}}
{{--                                <div class="flex items-center justify-end gap-1">--}}
{{--                                    <a href="{{ route('signatures.show', $s->id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View">--}}
{{--                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>--}}
{{--                                    </a>--}}

{{--                                    <a href="{{ route('signatures.edit', $s->id) }}" class="p-2 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Edit">--}}
{{--                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>--}}
{{--                                    </a>--}}

{{--                                    <form action="{{ route('signatures.destroy', $s->id) }}" method="POST" class="inline">--}}
{{--                                        @csrf @method('DELETE')--}}
{{--                                        <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all" onclick="return confirm('Удалить подпись?')">--}}
{{--                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="6" class="px-6 py-12 text-center">--}}
{{--                                <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Подписи не найдены</p>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

{{--            --}}{{----}}{{----}}{{----}}{{-- Пагинация --}}
{{--            @if($signatures->hasPages())--}}
{{--                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">--}}
{{--                    {{ $signatures->links() }}--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <style>--}}
{{--        .fade-in { animation: fadeIn .3s ease-out; }--}}
{{--        @keyframes fadeIn { from { opacity:0; transform:scale(0.98); } to { opacity:1; transform:scale(1); } }--}}
{{--    </style>--}}
{{--@endsection--}}




{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    --}}{{----}}{{-- Добавляем класс theme-page-bg для правильного фона --}}
{{--    <div class="container mx-auto px-4 py-8 min-h-screen">--}}

{{--        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">--}}
{{--            <div>--}}
{{--                --}}{{----}}{{-- style="color: var(--heading-color)" — это главный секрет. Он сам станет белым в темной теме --}}
{{--                <h1 class="text-3xl font-bold tracking-tight" style="color: var(--heading-color);">Реестр подписей</h1>--}}
{{--                <p class="text-sm font-medium mt-1 uppercase tracking-wider opacity-60" style="color: var(--heading-color);">--}}
{{--                    Все цифровые подтверждения в одном месте--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <a href="{{ route('signatures.create') }}"--}}
{{--               class="inline-flex items-center justify-center text-white px-6 py-3 rounded-2xl font-bold shadow-lg transition transform active:scale-95 gap-2"--}}
{{--               style="background-color: var(--primary-color);">--}}
{{--                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>--}}
{{--                НОВАЯ ПОДПИСЬ--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">--}}
{{--            @forelse($signatures as $s)--}}
{{--                <div class="rounded-[2rem] border overflow-hidden group transition-all shadow-lg"--}}
{{--                     style="background: var(--card-bg); border-color: var(--border-color);">--}}

{{--                    <div class="p-6 pb-4 border-b" style="border-color: var(--border-color); background: rgba(var(--primary-rgb), 0.05);">--}}
{{--                        <div class="flex items-start justify-between">--}}
{{--                            <div class="flex-1">--}}
{{--                                <span class="text-[10px] font-bold uppercase tracking-widest" style="color: var(--primary-color);">Документ #{{ $s->document->id ?? '0' }}</span>--}}
{{--                                <h3 class="font-bold text-lg leading-tight mt-1 truncate" style="color: var(--heading-color);">--}}
{{--                                    {{ $s->document->title ?? 'Без названия' }}--}}
{{--                                </h3>--}}
{{--                            </div>--}}
{{--                            <span class="px-3 py-1 rounded-lg text-[10px] font-mono font-bold border opacity-50"--}}
{{--                                  style="color: var(--heading-color); border-color: var(--border-color);">--}}
{{--                            ID-{{ $s->id }}--}}
{{--                        </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="p-8 flex flex-col items-center justify-center relative bg-white">--}}
{{--                        --}}{{----}}{{-- Здесь фон белый, чтобы подпись (чернила) всегда была видна --}}
{{--                        @if($s->signature)--}}
{{--                            <img src="{{ $s->signature }}" class="h-24 w-auto object-contain" alt="Signature">--}}
{{--                        @else--}}
{{--                            <div class="h-20 flex items-center justify-center text-gray-300 italic text-sm">Подпись отсутствует</div>--}}
{{--                        @endif--}}
{{--                    </div>--}}

{{--                    <div class="p-6 border-t flex items-center justify-between" style="border-color: var(--border-color);">--}}
{{--                        <div class="flex items-center gap-3">--}}
{{--                            <div class="w-10 h-10 rounded-full flex items-center justify-center border" style="border-color: var(--primary-color);">--}}
{{--                                <span class="text-xs font-bold" style="color: var(--primary-color);">{{ Str::substr($s->user->name ?? '?', 0, 1) }}</span>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <p class="text-[10px] font-bold opacity-40 uppercase" style="color: var(--heading-color);">Сотрудник</p>--}}
{{--                                <p class="text-sm font-bold" style="color: var(--heading-color);">{{ $s->user->name ?? 'Неизвестен' }}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="text-right">--}}
{{--                            <p class="text-[10px] font-bold opacity-40 uppercase" style="color: var(--heading-color);">Дата</p>--}}
{{--                            <p class="text-[11px] font-bold" style="color: var(--heading-color);">{{ $s->signed_at ? \Carbon\Carbon::parse($s->signed_at)->format('d.m.Y') : '—' }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="px-6 py-4 flex items-center justify-center gap-4 border-t opacity-0 group-hover:opacity-100 transition-opacity"--}}
{{--                         style="border-color: var(--border-color); background: rgba(var(--primary-rgb), 0.02);">--}}
{{--                        <a href="{{ route('signatures.show', $s->id) }}" class="text-xs font-bold hover:opacity-70 uppercase tracking-widest transition" style="color: var(--primary-color);">Просмотр</a>--}}
{{--                        <a href="{{ route('signatures.edit', $s->id) }}" class="text-xs font-bold text-amber-500 hover:opacity-70 uppercase tracking-widest transition">Правка</a>--}}
{{--                        <form action="{{ route('signatures.destroy', $s->id) }}" method="POST" class="inline">--}}
{{--                            @csrf @method('DELETE')--}}
{{--                            <button type="submit" class="text-xs font-bold text-rose-500 hover:opacity-70 uppercase tracking-widest transition" onclick="return confirm('Удалить?')">Удалить</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @empty--}}
{{--                <div class="col-span-full py-20 rounded-[2rem] border-2 border-dashed flex flex-col items-center justify-center" style="border-color: var(--border-color); opacity: 0.5;">--}}
{{--                    <p class="font-bold uppercase tracking-[0.2em] text-sm" style="color: var(--heading-color);">Подписей пока нет</p>--}}
{{--                </div>--}}
{{--            @endforelse--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <style>--}}
{{--        /* Это гарантирует, что если выбрана темная тема, страница примет нужные цвета */--}}
{{--        [data-theme='dark'] .container {--}}
{{--            --heading-color: #ffffff;--}}
{{--            --card-bg: #1e293b;--}}
{{--            --border-color: rgba(255, 255, 255, 0.1);--}}
{{--        }--}}

{{--        [data-theme='light'] .container {--}}
{{--            --heading-color: #1e293b;--}}
{{--            --card-bg: #ffffff;--}}
{{--            --border-color: #f1f5f9;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endsection--}}


{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <!DOCTYPE html>--}}
{{--<html lang="ru" data-theme="light">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Реестр подписей</title>--}}
{{--    <script src="https://cdn.tailwindcss.com"></script>--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.20/index.min.css" rel="stylesheet">--}}
{{--    <style>--}}
{{--        :root { --bg: #f8fafc; --card: #fff; --text: #0f172a; --muted: #64748b; --border: #e2e8f0; --primary: #6366f1; }--}}
{{--        [data-theme="dark"] { --bg: #0f172a; --card: #1e293b; --text: #f1f5f9; --muted: #94a3b8; --border: rgba(255,255,255,0.1); --primary: #818cf8; }--}}
{{--        body { background: var(--bg); color: var(--text); font-family: 'Inter', system-ui, sans-serif; transition: background 0.3s, color 0.3s; }--}}
{{--        .card { background: var(--card); border: 1px solid var(--border); border-radius: 1rem; overflow: hidden; transition: all 0.2s; }--}}
{{--        .card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.08); }--}}
{{--        .sig-area { min-height: 80px; background: linear-gradient(135deg, var(--bg) 0%, var(--card) 100%); display: flex; align-items: center; justify-content: center; }--}}
{{--        .btn-primary { background: var(--primary); color: #fff; transition: opacity 0.2s; }--}}
{{--        .btn-primary:hover { opacity: 0.9; }--}}
{{--        .action-btn { transition: opacity 0.2s; }--}}
{{--        .action-btn:hover { opacity: 0.7; }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body class="p-6 max-w-7xl mx-auto min-h-screen">--}}
{{--<header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">--}}
{{--    <div>--}}
{{--        <h1 class="text-3xl font-bold tracking-tight">Реестр подписей</h1>--}}
{{--        <p class="text-sm text-[var(--muted)] mt-1 font-medium">Все цифровые подтверждения в одном месте</p>--}}
{{--    </div>--}}
{{--    <a href="{{route('signatures.create')}}" class="btn-primary px-5 py-3 rounded-xl font-bold text-sm flex items-center gap-2 shadow-lg">--}}
{{--        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>--}}
{{--        НОВАЯ ПОДПИСЬ--}}
{{--    </a>--}}
{{--</header>--}}

{{--<div class="flex flex-col sm:flex-row gap-3 mb-6">--}}
{{--    <input type="text" id="search" placeholder="Поиск по документу или сотруднику..." class="flex-1 px-4 py-3 rounded-xl border border-[var(--border)] bg-[var(--card)] text-[var(--text)] focus:outline-none focus:ring-2 focus:ring-[var(--primary)] transition-all">--}}
{{--    <button id="themeBtn" class="px-4 py-3 rounded-xl border border-[var(--border)] bg-[var(--card)] text-[var(--muted)] hover:text-[var(--text)] flex items-center justify-center gap-2 font-medium">--}}
{{--        <span id="themeIcon">🌙</span> Тема--}}
{{--    </button>--}}
{{--</div>--}}

{{--<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="grid"></div>--}}

{{--<script>--}}
{{--    const sigs = [--}}
{{--        { id: 1, doc: 'Договор оказания услуг №45-А', user: 'Алексей Иванов', date: '26.04.2026', path: 'M10 40 Q30 5 50 35 T90 25 T130 38 T170 18 T190 30' },--}}
{{--        { id: 2, doc: 'Акт выполненных работ за март 2026', user: 'Мария Смирнова', date: '24.04.2026', path: 'M15 35 Q25 10 40 30 Q55 50 75 20 Q90 5 110 35 Q125 55 145 25 T180 30' },--}}
{{--        { id: 3, doc: 'Соглашение о конфиденциальности NDA-7', user: 'Дмитрий Козлов', date: '20.04.2026', path: null },--}}
{{--        { id: 4, doc: 'Приказ о назначении ответственного', user: 'Елена Петрова', date: '18.04.2026', path: 'M10 30 C20 10, 35 50, 50 25 C65 5, 80 45, 95 30 C110 15, 125 40, 140 20 C155 5, 170 35, 185 28' },--}}
{{--        { id: 5, doc: 'Дополнительное соглашение к договору', user: 'Виктор Новиков', date: '15.04.2026', path: 'M20 35 L40 15 L60 40 L80 20 L100 38 L120 18 L140 35 L160 22 L180 30' },--}}
{{--        { id: 6, doc: 'Заявление на отпуск', user: 'Ольга Тихонова', date: '10.04.2026', path: null }--}}
{{--    ];--}}

{{--    const render = (q = '') => {--}}
{{--        document.getElementById('grid').innerHTML = sigs--}}
{{--            .filter(s => s.doc.toLowerCase().includes(q) || s.user.toLowerCase().includes(q))--}}
{{--            .map(s => `--}}
{{--                <div class="card" id="card-${s.id}">--}}
{{--                    <div class="px-5 py-4 border-b border-[var(--border)] flex justify-between items-center bg-[var(--primary)]/5">--}}
{{--                        <span class="text-[10px] font-bold uppercase tracking-widest text-[var(--primary)]">Документ #${s.id}</span>--}}
{{--                        <span class="text-[10px] font-mono font-bold text-[var(--muted)] opacity-40">ID-${s.id}</span>--}}
{{--                    </div>--}}
{{--                    <div class="px-5 pb-3 pt-4 font-bold text-lg leading-tight truncate">${s.doc}</div>--}}
{{--                    <div class="sig-area px-4 pb-4">--}}
{{--                        ${s.path--}}
{{--                ? `<svg viewBox="0 0 200 60" class="h-16 w-auto drop-shadow-sm"><path d="${s.path}" stroke="var(--primary)" fill="none" stroke-width="2.5" stroke-linecap="round"/></svg>`--}}
{{--                : `<span class="text-xs italic text-[var(--muted)] opacity-50">Подпись отсутствует</span>`}--}}
{{--                    </div>--}}
{{--                    <div class="px-5 py-3 border-t border-[var(--border)] flex justify-between items-center">--}}
{{--                        <div class="flex items-center gap-3">--}}
{{--                            <div class="w-9 h-9 rounded-full bg-[var(--primary)]/10 text-[var(--primary)] flex items-center justify-center text-xs font-bold border border-[var(--primary)]/20">${s.user.split(' ').map(w=>w[0]).join('')}</div>--}}
{{--                            <div>--}}
{{--                                <div class="text-[10px] font-bold opacity-40 uppercase">Сотрудник</div>--}}
{{--                                <div class="text-sm font-bold">${s.user}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="text-right">--}}
{{--                            <div class="text-[10px] font-bold opacity-40 uppercase">Дата</div>--}}
{{--                            <div class="text-xs font-bold">${s.date}</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="px-5 py-3 border-t border-[var(--border)] flex justify-center gap-6 text-xs font-bold uppercase tracking-wider">--}}
{{--                        <a href="#" class="text-[var(--primary)] action-btn">Просмотр</a>--}}
{{--                        <a href="#" class="text-amber-500 action-btn">Правка</a>--}}
{{--                        <button onclick="del(${s.id})" class="text-rose-500 action-btn">Удалить</button>--}}
{{--                    </div>--}}
{{--                </div>`).join('');--}}
{{--    };--}}

{{--    document.getElementById('search').addEventListener('input', e => render(e.target.value.toLowerCase()));--}}

{{--    document.getElementById('themeBtn').addEventListener('click', () => {--}}
{{--        const html = document.documentElement;--}}
{{--        const dark = html.getAttribute('data-theme') === 'dark';--}}
{{--        html.setAttribute('data-theme', dark ? 'light' : 'dark');--}}
{{--        document.getElementById('themeIcon').textContent = dark ? '🌙' : '☀️';--}}
{{--    });--}}

{{--    const del = id => {--}}
{{--        if(confirm('Удалить?')) {--}}
{{--            const el = document.getElementById(`card-${id}`);--}}
{{--            el.style.transition = 'all 0.3s ease';--}}
{{--            el.style.opacity = '0'; el.style.transform = 'scale(0.96) translateY(10px)';--}}
{{--            setTimeout(() => { el.remove(); render(document.getElementById('search').value.toLowerCase()); }, 300);--}}
{{--        }--}}
{{--    };--}}

{{--    render();--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}


{{--@endsection--}}


{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="p-6 max-w-7xl mx-auto min-h-screen">--}}
{{--         Твои стили без изменений --}}
{{--        <style>--}}
{{--            :root { --bg: #f8fafc; --card: #fff; --text: #0f172a; --muted: #64748b; --border: #e2e8f0; --primary: #6366f1; }--}}
{{--            [data-theme="dark"] { --bg: #0f172a; --card: #1e293b; --text: #f1f5f9; --muted: #94a3b8; --border: rgba(255,255,255,0.1); --primary: #818cf8; }--}}

{{--            /* Привязка к фону админки */--}}
{{--            .page-content-wrapper { background: var(--bg); color: var(--text); font-family: 'Inter', system-ui, sans-serif; transition: background 0.3s, color 0.3s; }--}}

{{--            .card-sig { background: var(--card); border: 1px solid var(--border); border-radius: 1rem; overflow: hidden; transition: all 0.2s; }--}}
{{--            .card-sig:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.08); }--}}
{{--            .sig-area { min-height: 80px; background: linear-gradient(135deg, var(--bg) 0%, var(--card) 100%); display: flex; align-items: center; justify-content: center; }--}}
{{--            .btn-primary-sig { background: var(--primary); color: #fff; transition: opacity 0.2s; border-radius: 0.75rem; font-weight: 700; font-size: 0.875rem; }--}}
{{--            .btn-primary-sig:hover { opacity: 0.9; }--}}
{{--            .action-btn-sig { transition: opacity 0.2s; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }--}}
{{--            .action-btn-sig:hover { opacity: 0.7; }--}}
{{--        </style>--}}

{{--        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">--}}
{{--            <div>--}}
{{--                <h1 class="text-3xl font-bold tracking-tight">Реестр подписей</h1>--}}
{{--                <p class="text-sm text-[var(--muted)] mt-1 font-medium">Все цифровые подтверждения в одном месте</p>--}}
{{--            </div>--}}
{{--            <a href="{{ route('signatures.create') }}" class="btn-primary-sig px-5 py-3 flex items-center gap-2 shadow-lg shadow-indigo-500/20">--}}
{{--                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>--}}
{{--                НОВАЯ ПОДПИСЬ--}}
{{--            </a>--}}
{{--        </header>--}}

{{--         Сетка карточек через Forelse --}}
{{--        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">--}}
{{--            @forelse($signatures as $s)--}}
{{--                <div class="card-sig">--}}
{{--                    <div class="px-5 py-4 border-b border-[var(--border)] flex justify-between items-center bg-[var(--primary)]/5">--}}
{{--                        <span class="text-[10px] font-bold uppercase tracking-widest text-[var(--primary)]">Документ #{{ $s->document->id ?? '0' }}</span>--}}
{{--                        <span class="text-[10px] font-mono font-bold text-[var(--muted)] opacity-40">ID-{{ $s->id }}</span>--}}
{{--                    </div>--}}

{{--                    <div class="px-5 pb-3 pt-4 font-bold text-lg leading-tight truncate">--}}
{{--                        {{ $s->document->title ?? 'Без названия' }}--}}
{{--                    </div>--}}

{{--                    <div class="sig-area px-4 pb-4">--}}
{{--                        @if($s->signature)--}}
{{--                            <img src="{{ $s->signature }}" class="h-16 w-auto drop-shadow-sm filter contrast-125" alt="Signature">--}}
{{--                        @else--}}
{{--                            <span class="text-xs italic text-[var(--muted)] opacity-50">Подпись отсутствует</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}

{{--                    <div class="px-5 py-3 border-t border-[var(--border)] flex justify-between items-center">--}}
{{--                        <div class="flex items-center gap-3">--}}
{{--                            <div class="w-9 h-9 rounded-full bg-[var(--primary)]/10 text-[var(--primary)] flex items-center justify-center text-xs font-bold border border-[var(--primary)]/20">--}}
{{--                                {{ Str::substr($s->user->name ?? '?', 0, 1) }}--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <div class="text-[10px] font-bold opacity-40 uppercase leading-none">Сотрудник</div>--}}
{{--                                <div class="text-sm font-bold truncate w-24">{{ $s->user->name ?? 'Неизвестен' }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="text-right">--}}
{{--                            <div class="text-[10px] font-bold opacity-40 uppercase leading-none">Дата</div>--}}
{{--                            <div class="text-xs font-bold">{{ $s->signed_at ? \Carbon\Carbon::parse($s->signed_at)->format('d.m.Y') : '--' }}</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="px-5 py-3 border-t border-[var(--border)] flex justify-center gap-6">--}}
{{--                        <a href="{{ route('signatures.show', $s->id) }}" class="text-[var(--primary)] action-btn-sig">Просмотр</a>--}}
{{--                        <a href="{{ route('signatures.edit', $s->id) }}" class="text-amber-500 action-btn-sig">Правка</a>--}}

{{--                        <form action="{{ route('signatures.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить?')">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" class="text-rose-500 action-btn-sig">Удалить</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @empty--}}
{{--                <div class="col-span-full py-12 text-center bg-[var(--card)] rounded-2xl border border-dashed border-[var(--border)]">--}}
{{--                    <p class="text-[var(--muted)] font-medium">Записи не найдены</p>--}}
{{--                </div>--}}
{{--            @endforelse--}}
{{--        </div>--}}

{{--         Пагинация --}}
{{--        <div class="mt-8">--}}
{{--            {{ $signatures->links() }}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}



{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="p-6 max-w-7xl mx-auto min-h-screen">--}}
{{--        <style>--}}
{{--            :root { --bg: #f8fafc; --card: #fff; --text: #0f172a; --muted: #64748b; --border: #e2e8f0; --primary: #6366f1; }--}}
{{--            [data-theme="dark"] { --bg: #0f172a; --card: #1e293b; --text: #f1f5f9; --muted: #94a3b8; --border: rgba(255,255,255,0.1); --primary: #818cf8; }--}}

{{--            .card-sig { background: var(--card); border: 1px solid var(--border); border-radius: 1.5rem; overflow: hidden; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }--}}
{{--            .card-sig:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }--}}

{{--            .sig-area { min-height: 120px; background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(255, 255, 255, 1) 100%); display: flex; align-items: center; justify-content: center; }--}}
{{--            [data-theme="dark"] .sig-area { background: linear-gradient(135deg, rgba(15, 23, 42, 0.5) 0%, rgba(30, 41, 59, 1) 100%); }--}}

{{--            .btn-primary-sig { background: var(--primary); color: #fff; transition: all 0.2s; border-radius: 0.75rem; font-weight: 700; }--}}
{{--            .btn-primary-sig:hover { opacity: 0.9; transform: scale(1.02); }--}}

{{--            .action-btn-sig { transition: all 0.2s; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.8rem; }--}}
{{--            .action-btn-sig:hover { transform: scale(1.1); }--}}

{{--            /* Стили для аватара как на скрине */--}}
{{--            .user-avatar { width: 42px; height: 42px; border-radius: 50%; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #6366f1; font-weight: bold; }--}}
{{--            [data-theme="dark"] .user-avatar { background: #334155; border-color: #475569; }--}}
{{--        </style>--}}

{{--        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">--}}
{{--            <div>--}}
{{--                <h1 class="text-4xl font-bold tracking-tight" style="color: var(--text);">Реестр подписей</h1>--}}
{{--                <p class="text-sm text-[var(--muted)] mt-1 font-medium uppercase tracking-wider">Все цифровые подтверждения в одном месте</p>--}}
{{--            </div>--}}
{{--            <a href="{{ route('signatures.create') }}" class="btn-primary-sig px-6 py-3.5 flex items-center gap-2 shadow-lg shadow-indigo-500/25">--}}
{{--                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>--}}
{{--                НОВАЯ ПОДПИСЬ--}}
{{--            </a>--}}
{{--        </header>--}}

{{--        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">--}}
{{--            @forelse($signatures as $s)--}}
{{--                <div class="card-sig">--}}
{{--                    --}}{{----}}{{-- Шапка карточки: Документ # и ID --}}
{{--                    <div class="px-6 py-4 flex justify-between items-center">--}}
{{--                        <span class="text-[11px] font-bold uppercase tracking-[0.15em] text-indigo-500">Документ #{{ $loop->iteration }}</span>--}}
{{--                        <span class="text-[11px] font-bold text-gray-300 tracking-widest">ID-{{ $s->id }}</span>--}}
{{--                    </div>--}}

{{--                    --}}{{----}}{{-- Название документа --}}
{{--                    <div class="px-6 pb-4">--}}
{{--                        <h3 class="text-2xl font-bold leading-tight truncate" style="color: var(--text);">--}}
{{--                            {{ $s->document->title ?? 'Без названия' }}--}}
{{--                        </h3>--}}
{{--                    </div>--}}

{{--                    --}}{{----}}{{-- Область самой подписи --}}
{{--                    <div class="sig-area border-t border-b border-gray-50 dark:border-gray-800/50">--}}
{{--                        @if($s->signature)--}}
{{--                            <img src="{{ $s->signature }}" class="h-20 w-auto object-contain mix-blend-multiply dark:mix-blend-lighten" alt="Signature">--}}
{{--                        @else--}}
{{--                            <span class="text-sm font-medium text-[var(--muted)] opacity-40 italic">Подпись отсутствует</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}

{{--                    --}}{{----}}{{-- Инфо о сотруднике и дате --}}
{{--                    <div class="px-6 py-5 flex justify-between items-center">--}}
{{--                        <div class="flex items-center gap-4">--}}
{{--                            <div class="user-avatar text-sm">--}}
{{--                                {{ mb_strtoupper(mb_substr($s->user->name ?? '?', 0, 1)) }}{{ mb_strtoupper(mb_substr(explode(' ', $s->user->name ?? ' ')[1] ?? '', 0, 1)) }}--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Сотрудник</div>--}}
{{--                                <div class="text-[15px] font-bold" style="color: var(--text);">{{ $s->user->name ?? 'Неизвестен' }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="text-right">--}}
{{--                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Дата</div>--}}
{{--                            <div class="text-[15px] font-bold" style="color: var(--text);">{{ $s->signed_at ? \Carbon\Carbon::parse($s->signed_at)->format('d.m.Y') : '--' }}</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    --}}{{----}}{{-- Кнопки действий снизу как на скрине --}}
{{--                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 flex justify-center gap-10 bg-gray-50/30 dark:bg-black/10">--}}
{{--                        <a href="{{ route('signatures.show', $s->id) }}" class="text-indigo-500 action-btn-sig">Просмотр</a>--}}
{{--                        <a href="{{ route('signatures.edit', $s->id) }}" class="text-orange-400 action-btn-sig">Правка</a>--}}

{{--                        <form action="{{ route('signatures.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить?')">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" class="text-red-500 action-btn-sig">Удалить</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @empty--}}
{{--                <div class="col-span-full py-20 text-center bg-[var(--card)] rounded-[2rem] border-2 border-dashed border-[var(--border)]">--}}
{{--                    <div class="inline-flex p-4 rounded-full bg-gray-50 dark:bg-gray-800 mb-4">--}}
{{--                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>--}}
{{--                    </div>--}}
{{--                    <p class="text-[var(--muted)] text-lg font-bold">Подписей пока нет</p>--}}
{{--                    <p class="text-sm text-gray-400">Создайте первую цифровую подпись прямо сейчас</p>--}}
{{--                </div>--}}
{{--            @endforelse--}}
{{--        </div>--}}

{{--        @if($signatures->hasPages())--}}
{{--            <div class="mt-12">--}}
{{--                {{ $signatures->links() }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endsection--}}


{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="p-6 max-w-7xl mx-auto min-h-screen">--}}
{{--        <style>--}}
{{--            /* Используем переменные твоей системы, чтобы они менялись вместе с фоном админки */--}}
{{--            .sig-page {--}}
{{--                --text-main: currentColor; /* Берет цвет текста из родителя (белый на черном, черный на белом) */--}}
{{--                --card-bg: var(--card-background, #ffffff); /* Если в админке есть переменная фона карты */--}}
{{--            }--}}

{{--            .card-sig {--}}
{{--                background: var(--card-bg);--}}
{{--                border: 1px solid rgba(128, 128, 128, 0.2);--}}
{{--                border-radius: 1.5rem;--}}
{{--                overflow: hidden;--}}
{{--                transition: all 0.2s;--}}
{{--            }--}}

{{--            /* Белая область для самой подписи, чтобы её всегда было видно */--}}
{{--            .sig-area {--}}
{{--                min-height: 120px;--}}
{{--                background: #ffffff !important;--}}
{{--                display: flex;--}}
{{--                align-items: center;--}}
{{--                justify-content: center;--}}
{{--                border-top: 1px solid rgba(128, 128, 128, 0.1);--}}
{{--                border-bottom: 1px solid rgba(128, 128, 128, 0.1);--}}
{{--            }--}}

{{--            /* Кнопка теперь привязана к цвету primary твоей админки */--}}
{{--            .btn-primary-custom {--}}
{{--                background-color: var(--primary, #6366f1);--}}
{{--                color: #fff !important;--}}
{{--                border-radius: 0.75rem;--}}
{{--                font-weight: 700;--}}
{{--                transition: opacity 0.2s;--}}
{{--            }--}}
{{--            .btn-primary-custom:hover { opacity: 0.9; }--}}

{{--            .user-avatar {--}}
{{--                width: 40px; height: 40px; border-radius: 50%;--}}
{{--                background: rgba(128, 128, 128, 0.1);--}}
{{--                display: flex; align-items: center; justify-content: center;--}}
{{--                font-weight: bold; color: var(--primary);--}}
{{--            }--}}

{{--            /* Цвета для кнопок действий */--}}
{{--            .action-link { font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }--}}
{{--        </style>--}}

{{--        <div class="sig-page">--}}
{{--            <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">--}}
{{--                <div>--}}
{{--                    <h1 class="text-3xl font-bold tracking-tight">Реестр подписей</h1>--}}
{{--                    <p class="text-sm opacity-60 mt-1 font-medium uppercase tracking-wider">Все цифровые подтверждения в одном месте</p>--}}
{{--                </div>--}}
{{--                --}}{{-- Кнопка Primary --}}
{{--                <a href="{{ route('signatures.create') }}" class="btn-primary-custom px-6 py-3 flex items-center gap-2 shadow-lg">--}}
{{--                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>--}}
{{--                    НОВАЯ ПОДПИСЬ--}}
{{--                </a>--}}
{{--            </header>--}}

{{--            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">--}}
{{--                @forelse($signatures as $s)--}}
{{--                    <div class="card-sig">--}}
{{--                        --}}{{-- Шапка --}}
{{--                        <div class="px-6 py-4 flex justify-between items-center opacity-80">--}}
{{--                            <span class="text-[11px] font-bold uppercase tracking-widest text-indigo-500">Документ #{{ $loop->iteration }}</span>--}}
{{--                            <span class="text-[11px] font-bold tracking-widest">ID-{{ $s->id }}</span>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Название: цвет адаптируется сам (currentColor) --}}
{{--                        <div class="px-6 pb-4">--}}
{{--                            <h3 class="text-2xl font-bold leading-tight truncate">--}}
{{--                                {{ $s->document->title ?? 'Без названия' }}--}}
{{--                            </h3>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Зона подписи (всегда белая для четкости рисунка) --}}
{{--                        <div class="sig-area">--}}
{{--                            @if($s->signature)--}}
{{--                                <img src="{{ $s->signature }}" class="h-20 w-auto object-contain" alt="Signature">--}}
{{--                            @else--}}
{{--                                <span class="text-xs text-gray-400 italic">Подпись отсутствует</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                        --}}{{-- Инфо блок --}}
{{--                        <div class="px-6 py-5 flex justify-between items-center">--}}
{{--                            <div class="flex items-center gap-3">--}}
{{--                                <div class="user-avatar text-xs">--}}
{{--                                    {{ mb_strtoupper(mb_substr($s->user->name ?? '?', 0, 1)) }}--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <div class="text-[10px] font-bold opacity-50 uppercase tracking-tighter">Сотрудник</div>--}}
{{--                                    <div class="text-[15px] font-bold leading-none">{{ $s->user->name ?? 'Неизвестен' }}</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="text-right">--}}
{{--                                <div class="text-[10px] font-bold opacity-50 uppercase tracking-tighter">Дата</div>--}}
{{--                                <div class="text-[15px] font-bold leading-none">{{ $s->signed_at ? \Carbon\Carbon::parse($s->signed_at)->format('d.m.Y') : '--' }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Подвал с кнопками --}}
{{--                        <div class="px-6 py-4 border-t border-black/5 dark:border-white/5 flex justify-center gap-8">--}}
{{--                            <a href="{{ route('signatures.show', $s->id) }}" class="text-indigo-500 action-link">Просмотр</a>--}}
{{--                            <a href="{{ route('signatures.edit', $s->id) }}" class="text-orange-400 action-link">Правка</a>--}}

{{--                            <form action="{{ route('signatures.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить?')">--}}
{{--                                @csrf @method('DELETE')--}}
{{--                                <button type="submit" class="text-red-500 action-link">Удалить</button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @empty--}}
{{--                    <div class="col-span-full py-20 text-center opacity-50 border-2 border-dashed border-gray-500/20 rounded-3xl">--}}
{{--                        <p class="text-xl font-bold">Записи не найдены</p>--}}
{{--                    </div>--}}
{{--                @endforelse--}}
{{--            </div>--}}

{{--            <div class="mt-12">--}}
{{--                {{ $signatures->links() }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}


    @extends('layouts.admin')

    @section('content')
        <div class="p-6 max-w-7xl mx-auto min-h-screen">
            <style>
                .sig-page {
                    --primary-color: var(--primary, #6366f1);
                }

                /* Сама карточка всегда с белым фоном, чтобы черный текст был виден */
                .card-sig {
                    background: #ffffff !important;
                    border: 1px solid rgba(0, 0, 0, 0.1);
                    border-radius: 1.5rem;
                    overflow: hidden;
                    transition: all 0.2s;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                }

                /* Текст внутри карточки ВСЕГДА черный */
                .card-sig .text-black-forced {
                    color: #1e293b !important;
                }

                /* Светло-серый текст для подписей типа "Сотрудник" или "ID" */
                .card-sig .text-muted-forced {
                    color: #64748b !important;
                }

                .sig-area {
                    min-height: 120px;
                    background: #ffffff !important;
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
                    transition: opacity 0.2s;
                }

                .user-avatar {
                    width: 40px; height: 40px; border-radius: 50%;
                    background: #f1f5f9;
                    display: flex; align-items: center; justify-content: center;
                    font-weight: bold; color: var(--primary-color);
                    border: 1px solid #e2e8f0;
                }

                .action-link { font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
            </style>

            <div class="sig-page">
                <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
                    <div>
                        {{-- Заголовок страницы подстраивается под тему (белый на черном) --}}
                        <h1 class="text-3xl font-bold tracking-tight" style="color: var(--text-main, currentColor)">Реестр подписей</h1>
                        <p class="text-sm opacity-60 mt-1 font-medium uppercase tracking-wider" style="color: var(--text-main, currentColor)">Все цифровые подтверждения в одном месте</p>
                    </div>
                    <a href="{{ route('signatures.create') }}" class="btn-primary-custom px-6 py-3 flex items-center gap-2 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
                        НОВАЯ ПОДПИСЬ
                    </a>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($signatures as $index => $s)
                        <div class="card-sig">
                            {{-- Шапка --}}
                            <div class="px-6 py-4 flex justify-between items-center">
                                <span class="text-[11px] font-bold uppercase tracking-widest text-indigo-500">Документ #{{ $index + 1 }}</span>
                                {{-- ID всегда серый --}}
                                <span class="text-[11px] font-bold tracking-widest text-muted-forced">ID-{{ $s->id }}</span>
                            </div>

                            {{-- Название: всегда черное --}}
                            <div class="px-6 pb-4">
                                <h3 class="text-2xl font-bold leading-tight truncate text-black-forced">
                                    {{ $s->document->title ?? 'Без названия' }}
                                </h3>
                            </div>

                            {{-- Зона подписи --}}
                            <div class="sig-area">
                                @if($s->signature)
                                    <img src="{{ $s->signature }}" class="h-20 w-auto object-contain" alt="Signature">
                                @else
                                    <span class="text-xs text-gray-400 italic">Подпись отсутствует</span>
                                @endif
                            </div>

                            {{-- Инфо блок --}}
                            <div class="px-6 py-5 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="user-avatar text-xs">
                                        {{ mb_strtoupper(mb_substr($s->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase tracking-tighter text-muted-forced">Сотрудник</div>
                                        {{-- Имя всегда черное --}}
                                        <div class="text-[15px] font-bold leading-none text-black-forced">{{ $s->user->name ?? 'Неизвестен' }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] font-bold uppercase tracking-tighter text-muted-forced">Дата</div>
                                    {{-- Дата всегда черная --}}
                                    <div class="text-[15px] font-bold leading-none text-black-forced">{{ $s->signed_at?->format('d.m.Y') ?? '--' }}</div>
                                </div>
                            </div>

                            {{-- Подвал с кнопками (Цветные) --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex justify-center gap-8 bg-gray-50/50">
                                <a href="{{ route('signatures.show', $s->id) }}" class="text-indigo-500 action-link">Просмотр</a>
                                <a href="{{ route('signatures.edit', $s->id) }}" class="text-orange-400 action-link">Правка</a>

                                <form action="{{ route('signatures.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 action-link">Удалить</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center opacity-50 border-2 border-dashed border-gray-500/20 rounded-3xl">
                            <p class="text-xl font-bold" style="color: var(--text-main, currentColor)">Записи не найдены</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $signatures->links() }}
                </div>
            </div>
        </div>
    @endsection

