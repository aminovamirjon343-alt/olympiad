{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-6">--}}

{{--        --}}{{----}}{{----}}{{----}}{{-- Header --}}
{{--        <div class="flex items-center justify-between mb-6">--}}
{{--            <div>--}}
{{--                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Документы</h1>--}}
{{--                <p class="text-sm font-bold text-gray-500 mt-1 uppercase tracking-wider">Управление электронными документами системы</p>--}}
{{--            </div>--}}

{{--        </div>--}}

{{--        --}}{{----}}{{----}}{{----}}{{-- Alert --}}
{{--        @if(session('success'))--}}
{{--            <div class="mb-5 flex items-center gap-3 bg-green-50 border-2 border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-bold fade-in">--}}
{{--                <svg class="w-5 h-5 flex-shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>--}}
{{--                </svg>--}}
{{--                {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        --}}{{----}}{{----}}{{----}}{{-- Table Card --}}
{{--        <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">--}}
{{--            <div class="overflow-x-auto">--}}
{{--                <table class="w-full text-sm">--}}
{{--                    <thead>--}}
{{--                    <tr class="bg-gray-100 border-b-2 border-gray-200 text-gray-900">--}}
{{--                        <th class="text-left px-5 py-4 font-black uppercase tracking-tighter w-12">#</th>--}}
{{--                        <th class="text-left px-5 py-4 font-black uppercase tracking-tighter">Название</th>--}}
{{--                        <th class="text-left px-5 py-4 font-black uppercase tracking-tighter max-w-xs">Содержимое</th>--}}
{{--                        <th class="text-left px-5 py-4 font-black uppercase tracking-tighter w-36">Статус</th>--}}
{{--                        <th class="text-left px-5 py-4 font-black uppercase tracking-tighter w-32">Дедлайн</th>--}}
{{--                        <th class="text-left px-5 py-4 font-black uppercase tracking-tighter w-28 text-center">Файл</th>--}}
{{--                        <th class="text-right px-5 py-4 font-black uppercase tracking-tighter w-32">Действия</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="divide-y-2 divide-gray-100">--}}
{{--                    @forelse($documents as $index => $doc)--}}
{{--                        <tr class="hover:bg-blue-50/50 transition group">--}}
{{--                            <td class="px-5 py-5 text-gray-400 font-mono font-bold text-xs">{{ $index + 1 }}</td>--}}
{{--                            <td class="px-5 py-5 font-black text-gray-900 text-base max-w-xs truncate">{{ $doc->title }}</td>--}}
{{--                            <td class="px-5 py-5 text-gray-600 font-bold max-w-xs truncate">{{ Str::limit($doc->content, 50) }}</td>--}}
{{--                            <td class="px-5 py-5">--}}
{{--                                @php--}}
{{--                                    $st = match($doc->status) {--}}
{{--                                        'approved', 'Подписан', 'active' => 'bg-blue-600 text-white shadow-sm',--}}
{{--                                        'pending', 'На согласовании' => 'bg-amber-500 text-white shadow-sm',--}}
{{--                                        'rejected', 'Отклонён' => 'bg-red-600 text-white shadow-sm',--}}
{{--                                        'draft', 'Черновик' => 'bg-gray-500 text-white shadow-sm',--}}
{{--                                        default => 'bg-gray-400 text-white',--}}
{{--                                    };--}}
{{--                                @endphp--}}
{{--                                <span class="inline-block px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $st }}">--}}
{{--                                    {{ $doc->status }}--}}
{{--                                </span>--}}
{{--                            </td>--}}
{{--                            <td class="px-5 py-5 text-gray-900 font-black">--}}
{{--                                @if($doc->deadline)--}}
{{--                                    @php--}}
{{--                                        $isExpired = \Carbon\Carbon::parse($doc->deadline)->isPast() && !in_array($doc->status, ['Подписан','approved']);--}}
{{--                                    @endphp--}}
{{--                                    <span class="{{ $isExpired ? 'text-red-600' : '' }}">--}}
{{--                                        {{ \Carbon\Carbon::parse($doc->deadline)->format('d.m.Y') }}--}}
{{--                                    </span>--}}
{{--                                @else--}}
{{--                                    <span class="text-gray-300">—</span>--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            <td class="px-5 py-5 text-center">--}}
{{--                                @if($doc->file_path)--}}
{{--                                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank"--}}
{{--                                       class="bg-gray-100 text-blue-700 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase hover:bg-blue-600 hover:text-white transition">--}}
{{--                                        Файл--}}
{{--                                    </a>--}}
{{--                                @else--}}
{{--                                    <span class="text-gray-300 font-black">—</span>--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            <td class="px-5 py-5 text-right">--}}
{{--                                <div class="flex items-center justify-end gap-2">--}}
{{--                                    <a href="{{ route('documents.show', $doc->id) }}" class="p-2 rounded-xl bg-gray-50 text-gray-900 hover:bg-blue-100 transition">--}}
{{--                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>--}}
{{--                                    </a>--}}
{{--                                    <a href="{{ route('documents.edit', $doc->id) }}" class="p-2 rounded-xl bg-gray-50 text-amber-600 hover:bg-amber-100 transition">--}}
{{--                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>--}}
{{--                                    </a>--}}
{{--                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Удалить?')">--}}
{{--                                        @csrf @method('DELETE')--}}
{{--                                        <button type="submit" class="p-2 rounded-xl bg-gray-50 text-red-600 hover:bg-red-100 transition">--}}
{{--                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="7" class="px-5 py-16 text-center">--}}
{{--                                <p class="text-gray-400 font-black uppercase tracking-widest text-lg">Пусто</p>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{----}}{{----}}{{----}}{{-- Pagination --}}
{{--        @if($documents->hasPages())--}}
{{--            <div class="mt-8 flex items-center justify-between">--}}
{{--                <p class="text-sm font-black text-gray-500 uppercase tracking-tighter">--}}
{{--                    Показано {{ $documents->firstItem() }}-{{ $documents->lastItem() }} из {{ $documents->total() }}--}}
{{--                </p>--}}
{{--                <div class="font-black">--}}
{{--                    {{ $documents->links() }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--    </div>--}}

{{--    <style>--}}
{{--        .fade-in { animation: fadeIn .3s ease; }--}}
{{--        @keyframes fadeIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }--}}
{{--    </style>--}}
{{--@endsection--}}



{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8">--}}

{{--        --}}{{----}}{{-- Заголовок страницы --}}
{{--        <h1 class="text-3xl font-black text-gray-900 mb-8 tracking-tight">Документы</h1>--}}

{{--        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">--}}

{{--            --}}{{----}}{{-- Верхняя панель: Фильтры и Поиск (как на скриншоте) --}}
{{--            <div class="p-5 border-b border-gray-100 bg-white">--}}
{{--                <form action="{{ route('documents.index') }}" method="GET" class="flex flex-wrap items-center gap-4">--}}
{{--                    <div class="w-full md:w-48">--}}
{{--                        <select name="type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">--}}
{{--                            <option value="">Все типы</option>--}}
{{--                            <option value="Договор">Договор</option>--}}
{{--                            <option value="Приказ">Приказ</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="w-full md:w-48">--}}
{{--                        <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">--}}
{{--                            <option value="">Все статусы</option>--}}
{{--                            <option value="signed">Подписан</option>--}}
{{--                            <option value="pending">На согласовании</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow relative">--}}
{{--                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>--}}
{{--                        <input type="text" name="search" placeholder="Поиск..."--}}
{{--                               class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}

{{--            --}}{{----}}{{-- Таблица --}}
{{--            <div class="overflow-x-auto">--}}
{{--                <table class="w-full text-left">--}}
{{--                    <thead>--}}
{{--                    <tr class="bg-gray-50 border-b border-gray-100">--}}
{{--                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Номер</th>--}}
{{--                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Название</th>--}}
{{--                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Тип</th>--}}
{{--                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Автор</th>--}}
{{--                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Статус</th>--}}
{{--                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Дата</th>--}}
{{--                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Действия</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="divide-y divide-gray-100">--}}
{{--                    @forelse($documents as $doc)--}}
{{--                        <tr class="hover:bg-gray-50/80 transition-colors">--}}
{{--                            --}}{{----}}{{-- Номер (ссылка как на скриншоте) --}}
{{--                            <td class="px-6 py-5">--}}
{{--                                <a href="{{ route('documents.show', $doc->id) }}" class="text-[11px] font-bold text-blue-500 hover:underline tracking-tight">--}}
{{--                                    {{ $doc->number ?? 'ДОК-'.date('Y').'-'.str_pad($doc->id, 3, '0', STR_PAD_LEFT) }}--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            --}}{{----}}{{-- Название --}}
{{--                            <td class="px-6 py-5">--}}
{{--                                <span class="text-sm font-bold text-gray-900">{{ $doc->title }}</span>--}}
{{--                            </td>--}}
{{--                            --}}{{----}}{{-- Тип --}}
{{--                            <td class="px-6 py-5">--}}
{{--                                <span class="text-xs font-semibold text-gray-500 italic">{{ $doc->type ?? 'Документ' }}</span>--}}
{{--                            </td>--}}
{{--                            --}}{{----}}{{-- Автор --}}
{{--                            <td class="px-6 py-5">--}}
{{--                                <span class="text-xs font-bold text-gray-600">{{ $doc->user->name ?? 'Система' }}</span>--}}
{{--                            </td>--}}
{{--                            --}}{{----}}{{-- Статус (как на скриншоте) --}}
{{--                            <td class="px-6 py-5">--}}
{{--                                @php--}}
{{--                                    $statusClasses = match($doc->status) {--}}
{{--                                        'approved', 'Подписан', 'signed' => 'bg-blue-50 text-blue-600',--}}
{{--                                        'pending', 'На согласовании' => 'bg-amber-50 text-amber-600',--}}
{{--                                        'rejected', 'Отклонён' => 'bg-red-50 text-red-600',--}}
{{--                                        'draft', 'Черновик' => 'bg-gray-100 text-gray-500',--}}
{{--                                        default => 'bg-gray-100 text-gray-500',--}}
{{--                                    };--}}
{{--                                @endphp--}}
{{--                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $statusClasses }}">--}}
{{--                                    {{ $doc->status }}--}}
{{--                                </span>--}}
{{--                            </td>--}}
{{--                            --}}{{----}}{{-- Дата --}}
{{--                            <td class="px-6 py-5 text-center">--}}
{{--                                <span class="text-xs font-bold text-gray-400">{{ $doc->created_at->format('Y-m-d') }}</span>--}}
{{--                            </td>--}}
{{--                            --}}{{----}}{{-- Действия --}}
{{--                            <td class="px-6 py-5 text-right">--}}
{{--                                <div class="flex items-center justify-end gap-3 text-xs font-bold">--}}
{{--                                    <a href="{{ route('documents.show', $doc->id) }}" class="text-blue-500 hover:text-blue-700">Открыть</a>--}}
{{--                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Удалить?')">--}}
{{--                                        @csrf @method('DELETE')--}}
{{--                                        <button class="text-red-400 hover:text-red-600">Удалить</button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="7" class="py-20 text-center">--}}
{{--                                <div class="opacity-20 mb-4 text-5xl">📂</div>--}}
{{--                                <p class="text-gray-400 font-black uppercase tracking-widest">Документы не найдены</p>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

{{--            --}}{{----}}{{-- Нижняя панель: Пагинация --}}
{{--            <div class="p-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">--}}
{{--                <p class="text-xs font-bold text-gray-400 uppercase tracking-tighter">--}}
{{--                    Показано: {{ $documents->count() }}--}}
{{--                </p>--}}
{{--                <div>--}}
{{--                    {{ $documents->links('pagination::tailwind') }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@extends('layouts.admin')--}}

{{--@section('content')--}}

{{--    <div class="container mx-auto px-4 py-8">--}}
{{--        --}}{{----}}{{-- Шапка --}}
{{--        <div class="flex items-center justify-between mb-8">--}}
{{--            <div>--}}
{{--                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Документы</h1>--}}
{{--                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mt-1">Реестр электронных документов</p>--}}
{{--            </div>--}}

{{--            --}}{{----}}{{-- Кнопка создания --}}
{{--            <a href="{{ route('documents.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition shadow-sm hover:shadow-lg hover:shadow-blue-500/20 active:scale-[0.98]">--}}
{{--                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>--}}
{{--                </svg>--}}
{{--                Создать документ--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        --}}{{----}}{{-- Сообщения об успехе --}}
{{--        @if(session('success'))--}}
{{--            <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl text-xs font-bold flex items-center gap-3">--}}
{{--                <i class="fas fa-check-circle"></i> {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        --}}{{----}}{{-- ГЛАВНЫЙ БОКС С СИНИМ КОНТУРОМ --}}
{{--        <div class="bg-white rounded-2xl shadow-sm border border-blue-600 overflow-hidden mb-6">--}}

{{--            --}}{{----}}{{-- ПАНЕЛЬ ФИЛЬТРОВ --}}
{{--            <form action="{{ route('documents.index') }}" method="GET" class="p-4 flex flex-wrap items-center gap-3 border-b border-gray-100 bg-white">--}}
{{--                <div class="w-full md:w-64">--}}
{{--                    <select name="type" onchange="this.form.submit()"--}}
{{--                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-600 focus:ring-0 transition-all font-bold text-gray-700 text-[11px] uppercase tracking-widest outline-none cursor-pointer">--}}
{{--                        <option value="">Все типы документов</option>--}}

{{--                        <optgroup label="Финансовые и Налоговые">--}}
{{--                            <option value="УПД" {{ request('type') == 'УПД' ? 'selected' : '' }}>УПД</option>--}}
{{--                            <option value="Счёт" {{ request('type') == 'Счёт' ? 'selected' : '' }}>Счёт</option>--}}
{{--                            <option value="Счёт-фактура" {{ request('type') == 'Счёт-фактура' ? 'selected' : '' }}>Счёт-фактура</option>--}}
{{--                            <option value="Акт сверки" {{ request('type') == 'Акт сверки' ? 'selected' : '' }}>Акт сверки</option>--}}
{{--                        </optgroup>--}}

{{--                        <optgroup label="Коммерческие">--}}
{{--                            <option value="Договор" {{ request('type') == 'Договор' ? 'selected' : '' }}>Договор</option>--}}
{{--                            <option value="Доп. соглашение" {{ request('type') == 'Доп. соглашение' ? 'selected' : '' }}>Доп. соглашение</option>--}}
{{--                            <option value="Акт" {{ request('type') == 'Акт' ? 'selected' : '' }}>Акт выполненных работ</option>--}}
{{--                            <option value="Накладная" {{ request('type') == 'Накладная' ? 'selected' : '' }}>Накладная</option>--}}
{{--                        </optgroup>--}}

{{--                        <optgroup label="Кадровые и Внутренние">--}}
{{--                            <option value="Приказ" {{ request('type') == 'Приказ' ? 'selected' : '' }}>Приказ</option>--}}
{{--                            <option value="Заявление" {{ request('type') == 'Заявление' ? 'selected' : '' }}>Заявление</option>--}}
{{--                            <option value="Трудовой договор" {{ request('type') == 'Трудовой договор' ? 'selected' : '' }}>Трудовой договор</option>--}}
{{--                            <option value="Служебная записка" {{ request('type') == 'Служебная записка' ? 'selected' : '' }}>Служебная записка</option>--}}
{{--                        </optgroup>--}}

{{--                        <optgroup label="Прочие">--}}
{{--                            <option value="Доверенность" {{ request('type') == 'Доверенность' ? 'selected' : '' }}>Доверенность</option>--}}
{{--                            <option value="Информационное письмо" {{ request('type') == 'Информационное письмо' ? 'selected' : '' }}>Информационное письмо</option>--}}
{{--                        </optgroup>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                --}}{{----}}{{-- Сюда можно добавить поиск или кнопку сброса --}}
{{--            </form>--}}

{{--                <div class="w-full md:w-48">--}}
{{--                    <select name="status" onchange="this.form.submit()"--}}
{{--                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-600 focus:ring-0 transition-all font-bold text-gray-700 text-[11px] uppercase tracking-widest outline-none cursor-pointer">--}}
{{--                        <option value="">Все статусы</option>--}}
{{--                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Активный</option>--}}
{{--                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Подписан</option>--}}
{{--                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Отклонен</option>--}}
{{--                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновик</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                @if(request()->anyFilled(['search', 'type', 'status']))--}}
{{--                    <a href="{{ route('documents.index') }}" class="px-3 py-2 text-[10px] font-black text-gray-400 hover:text-red-600 uppercase transition-colors tracking-widest">--}}
{{--                        <i class="fas fa-times-circle mr-1"></i> Сбросить фильтры--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--            </form>--}}

{{--            --}}{{----}}{{-- Таблица --}}
{{--            <div class="overflow-x-auto">--}}
{{--                <table class="w-full text-left">--}}
{{--                    <thead>--}}
{{--                    <tr class="bg-gray-50 border-b border-gray-100">--}}
{{--                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest">Номер</th>--}}
{{--                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest">Документ</th>--}}
{{--                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest">Тип</th>--}}
{{--                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest">Статус</th>--}}
{{--                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Дата</th>--}}
{{--                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Действия</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="divide-y divide-gray-100 text-sm">--}}
{{--                    @forelse($documents as $doc)--}}
{{--                        <tr class="hover:bg-gray-50/50 transition-colors group">--}}
{{--                            <td class="px-6 py-5">--}}
{{--                                <a href="{{ route('documents.show', $doc->id) }}" class="text-[11px] font-black text-blue-600 hover:underline">--}}
{{--                                    #{{ str_pad($doc->id, 4, '0', STR_PAD_LEFT) }}--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-5">--}}
{{--                                <span class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $doc->title }}</span>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-5">--}}
{{--                                <span class="text-[10px] font-black uppercase text-gray-500">{{ $doc->type ?? 'Прочее' }}</span>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-5">--}}
{{--                                @php--}}
{{--                                    $statusData = match($doc->status) {--}}
{{--                                        'approved', 'signed', 'Подписан' => ['class' => 'bg-blue-50 text-blue-600', 'label' => 'Подписан'],--}}
{{--                                        'pending', 'active', 'На согласовании' => ['class' => 'bg-amber-50 text-amber-600', 'label' => 'В работе'],--}}
{{--                                        'rejected', 'Отклонён' => ['class' => 'bg-red-50 text-red-600', 'label' => 'Отклонён'],--}}
{{--                                        default => ['class' => 'bg-gray-100 text-gray-500', 'label' => $doc->status],--}}
{{--                                    };--}}
{{--                                @endphp--}}
{{--                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $statusData['class'] }}">--}}
{{--                                    {{ $statusData['label'] }}--}}
{{--                                </span>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-5 text-center text-[11px] font-bold text-gray-400">--}}
{{--                                {{ $doc->created_at->format('d.m.Y') }}--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-5 text-right">--}}
{{--                                <div class="flex items-center justify-end gap-2">--}}
{{--                                    --}}{{----}}{{-- Компактная кнопка Открыть в твоем стиле --}}
{{--                                    <a href="{{ route('documents.show', $doc->id) }}" class="px-3 py-1.5 border border-blue-600 text-blue-600 rounded-lg text-[10px] font-black uppercase hover:bg-red-600 hover:border-red-600 hover:text-white transition-all shadow-sm">--}}
{{--                                        Открыть--}}
{{--                                    </a>--}}
{{--                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Удалить?')">--}}
{{--                                        @csrf @method('DELETE')--}}
{{--                                        <button type="submit" class="p-1.5 text-gray-300 hover:text-red-600 transition">--}}
{{--                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="6" class="py-20 text-center text-gray-300 font-black uppercase tracking-widest text-xs">--}}
{{--                                Документы не найдены--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

{{--            @if($documents->hasPages())--}}
{{--                <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">--}}
{{--                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Всего: {{ $documents->total() }}</span>--}}
{{--                    <div>{{ $documents->links() }}</div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}


{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container-fluid px-4 py-6">--}}

{{--        --}}{{----}}{{-- Заголовок страницы --}}
{{--        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">--}}
{{--            <div>--}}
{{--                <h4 class="fw-bold mb-1">Документы</h4>--}}
{{--                <p class="text-muted mb-0" style="font-size:13px;">Реестр электронных документов</p>--}}
{{--            </div>--}}
{{--            <a href="{{ route('documents.create') }}" class="btn-primary-custom">--}}
{{--                <i class="bi bi-plus-lg me-1"></i> Создать документ--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        --}}{{----}}{{-- Сообщения об успехе --}}
{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4" role="alert" style="background:#dcfce7;color:#166534;border:1px solid #86efac;">--}}
{{--                <i class="bi bi-check-circle-fill"></i>--}}
{{--                <span class="fw-medium" style="font-size:13px;">{{ session('success') }}</span>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        --}}{{----}}{{-- Карточка с фильтрами и таблицей --}}
{{--        <div class="table-custom mb-4">--}}

{{--            --}}{{----}}{{-- Панель фильтров --}}
{{--            <form action="{{ route('documents.index') }}" method="GET" class="p-4 border-bottom d-flex flex-wrap gap-3 align-items-center">--}}

{{--                <div class="w-100 w-md-auto" style="min-width:200px;">--}}
{{--                    <label class="form-label text-muted mb-1" style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Тип документа</label>--}}
{{--                    <select name="type" onchange="this.form.submit()" class="form-select form-select-sm rounded-3" style="font-size:13px;font-weight:500;">--}}
{{--                        <option value="">Все типы</option>--}}
{{--                        <optgroup label="Финансовые">--}}
{{--                            <option value="УПД" {{ request('type')=='УПД'?'selected':'' }}>УПД</option>--}}
{{--                            <option value="Счёт" {{ request('type')=='Счёт'?'selected':'' }}>Счёт</option>--}}
{{--                            <option value="Счёт-фактура" {{ request('type')=='Счёт-фактура'?'selected':'' }}>Счёт-фактура</option>--}}
{{--                            <option value="Акт сверки" {{ request('type')=='Акт сверки'?'selected':'' }}>Акт сверки</option>--}}
{{--                        </optgroup>--}}
{{--                        <optgroup label="Коммерческие">--}}
{{--                            <option value="Договор" {{ request('type')=='Договор'?'selected':'' }}>Договор</option>--}}
{{--                            <option value="Доп. соглашение" {{ request('type')=='Доп. соглашение'?'selected':'' }}>Доп. соглашение</option>--}}
{{--                            <option value="Акт" {{ request('type')=='Акт'?'selected':'' }}>Акт выполненных работ</option>--}}
{{--                            <option value="Накладная" {{ request('type')=='Накладная'?'selected':'' }}>Накладная</option>--}}
{{--                        </optgroup>--}}
{{--                        <optgroup label="Кадровые">--}}
{{--                            <option value="Приказ" {{ request('type')=='Приказ'?'selected':'' }}>Приказ</option>--}}
{{--                            <option value="Заявление" {{ request('type')=='Заявление'?'selected':'' }}>Заявление</option>--}}
{{--                            <option value="Трудовой договор" {{ request('type')=='Трудовой договор'?'selected':'' }}>Трудовой договор</option>--}}
{{--                        </optgroup>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <div class="w-100 w-md-auto" style="min-width:180px;">--}}
{{--                    <label class="form-label text-muted mb-1" style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Статус</label>--}}
{{--                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm rounded-3" style="font-size:13px;font-weight:500;">--}}
{{--                        <option value="">Все статусы</option>--}}
{{--                        <option value="active" {{ request('status')=='active'?'selected':'' }}>Активный</option>--}}
{{--                        <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Подписан</option>--}}
{{--                        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Отклонен</option>--}}
{{--                        <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Черновик</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                @if(request()->anyFilled(['search','type','status']))--}}
{{--                    <div class="d-flex align-items-end pb-2">--}}
{{--                        <a href="{{ route('documents.index') }}" class="btn btn-sm btn-outline-danger rounded-3 d-flex align-items-center gap-1" style="font-size:11px;font-weight:600;">--}}
{{--                            <i class="bi bi-x-lg"></i> Сбросить--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </form>--}}

{{--            --}}{{----}}{{-- Таблица документов --}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table mb-0 table-custom">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th style="width:80px;">#</th>--}}
{{--                        <th>Документ</th>--}}
{{--                        <th style="width:140px;">Тип</th>--}}
{{--                        <th style="width:120px;">Статус</th>--}}
{{--                        <th style="width:110px;text-align:center;">Дата</th>--}}
{{--                        <th style="width:140px;text-align:right;">Действия</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @forelse($documents as $doc)--}}
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                <a href="{{ route('documents.show', $doc->id) }}" class="fw-semibold" style="color:var(--primary);font-size:13px;">--}}
{{--                                    #{{ str_pad($doc->id, 4, '0', STR_PAD_LEFT) }}--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <span class="fw-medium" style="font-size:14px;">{{ $doc->title }}</span>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <span class="text-muted" style="font-size:12px;">{{ $doc->type ?? '—' }}</span>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                @php--}}
{{--                                    $status = match($doc->status) {--}}
{{--                                        'approved','signed','Подписан' => ['class'=>'status-approved','label'=>'Подписан'],--}}
{{--                                        'pending','active','На согласовании' => ['class'=>'status-pending','label'=>'В работе'],--}}
{{--                                        'rejected','Отклонён' => ['class'=>'status-rejected','label'=>'Отклонён'],--}}
{{--                                        'draft','Черновик' => ['class'=>'status-draft','label'=>'Черновик'],--}}
{{--                                        default => ['class'=>'status-draft','label'=>$doc->status],--}}
{{--                                    };--}}
{{--                                @endphp--}}
{{--                                <span class="status-badge {{ $status['class'] }}">--}}
{{--                                {{ $status['label'] }}--}}
{{--                            </span>--}}
{{--                            </td>--}}
{{--                            <td class="text-center text-muted" style="font-size:13px;">--}}
{{--                                {{ $doc->created_at?->format('d.m.Y') ?? '—' }}--}}
{{--                            </td>--}}
{{--                            <td class="text-end">--}}
{{--                                <div class="d-flex justify-content-end gap-1">--}}
{{--                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-light rounded-3" title="Просмотр">--}}
{{--                                        <i class="bi bi-eye"></i>--}}
{{--                                    </a>--}}
{{--                                    <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-sm btn-light rounded-3" title="Редактировать">--}}
{{--                                        <i class="bi bi-pencil"></i>--}}
{{--                                    </a>--}}
{{--                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить документ?')">--}}
{{--                                        @csrf @method('DELETE')--}}
{{--                                        <button type="submit" class="btn btn-sm btn-light rounded-3 text-danger" title="Удалить">--}}
{{--                                            <i class="bi bi-trash"></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="6" class="text-center py-5">--}}
{{--                                <div class="text-muted" style="font-size:13px;">--}}
{{--                                    <i class="bi bi-folder-x d-block fs-4 mb-2"></i>--}}
{{--                                    Документы не найдены--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

{{--            --}}{{----}}{{-- Пагинация --}}
{{--            @if($documents->hasPages())--}}
{{--                <div class="p-3 border-top d-flex justify-content-between align-items-center" style="background:var(--bg-input);">--}}
{{--                    <span class="text-muted" style="font-size:12px;">Всего: <strong>{{ $documents->total() }}</strong></span>--}}
{{--                    <div class="pagination pagination-sm mb-0">--}}
{{--                        {{ $documents->withQueryString()->links() }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    --}}{{----}}{{-- Стили для пагинации под дизайн --}}
{{--    @push('styles')--}}
{{--        <style>--}}
{{--            .pagination .page-link {--}}
{{--                border-radius: 8px !important;--}}
{{--                margin: 0 2px;--}}
{{--                border: 1px solid var(--border-color) !important;--}}
{{--                color: var(--text-primary) !important;--}}
{{--                font-size: 12px;--}}
{{--                font-weight: 500;--}}
{{--                background: var(--bg-card) !important;--}}
{{--            }--}}
{{--            .pagination .page-item.active .page-link {--}}
{{--                background: var(--primary) !important;--}}
{{--                border-color: var(--primary) !important;--}}
{{--                color: white !important;--}}
{{--            }--}}
{{--            .pagination .page-link:hover {--}}
{{--                background: var(--hover-bg) !important;--}}
{{--                border-color: var(--primary) !important;--}}
{{--            }--}}
{{--            html.dark .pagination .page-link {--}}
{{--                background: var(--bg-card) !important;--}}
{{--                color: var(--text-primary) !important;--}}
{{--            }--}}
{{--        </style>--}}
{{--    @endpush--}}
{{--@endsection--}}


{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container-fluid px-4 py-6">--}}

{{--        --}}{{----}}{{-- Header --}}
{{--        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">--}}
{{--            <div>--}}
{{--                <h4 class="fw-bold mb-1" style="color: var(--text-primary);" data-i18n="documents">Документы</h4>--}}
{{--                <p class="text-muted mb-0" style="font-size:13px; color: var(--text-secondary);" data-i18n="docSubtitle">Реестр электронных документов</p>--}}
{{--            </div>--}}
{{--            <a href="{{ route('documents.create') }}" class="btn-primary-custom">--}}
{{--                <i class="bi bi-plus-lg me-1"></i> <span data-i18n="createDoc">Создать документ</span>--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        --}}{{----}}{{-- Success Alert --}}
{{--        @if(session('success'))--}}
{{--            <div class="alert-success-custom d-flex align-items-center gap-2 rounded-3 mb-4 p-3" role="alert">--}}
{{--                <i class="bi bi-check-circle-fill"></i>--}}
{{--                <span class="fw-medium" style="font-size:13px; color: inherit;">{{ session('success') }}</span>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        --}}{{----}}{{-- Main Card --}}
{{--        <div class="table-custom mb-4">--}}

{{--            --}}{{----}}{{-- Filters --}}
{{--            <form action="{{ route('documents.index') }}" method="GET" class="p-4 border-bottom d-flex flex-wrap gap-3 align-items-center">--}}
{{--                <div class="w-100 w-md-auto" style="min-width:200px;">--}}
{{--                    <label class="form-label mb-1" style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px; color: var(--text-secondary);" data-i18n="docType">Тип документа</label>--}}
{{--                    <select name="type" onchange="this.form.submit()" class="form-select form-select-sm rounded-3" style="font-size:13px;font-weight:500; background: var(--bg-input); border-color: var(--border-color); color: var(--text-primary);">--}}
{{--                        <option value="" data-i18n="allTypes">Все типы</option>--}}
{{--                        <optgroup label="Финансовые" data-i18n="catFinancial">--}}
{{--                            <option value="УПД" data-i18n="optUPD">УПД</option>--}}
{{--                            <option value="Счёт" data-i18n="optBill">Счёт</option>--}}
{{--                            <option value="Счёт-фактура" data-i18n="optInv">Счёт-фактура</option>--}}
{{--                            <option value="Акт сверки" data-i18n="optRecon">Акт сверки</option>--}}
{{--                        </optgroup>--}}
{{--                        <optgroup label="Коммерческие" data-i18n="catCommercial">--}}
{{--                            <option value="Договор" data-i18n="optContract">Договор</option>--}}
{{--                            <option value="Доп. соглашение" data-i18n="optAddendum">Доп. соглашение</option>--}}
{{--                            <option value="Акт" data-i18n="optAct">Акт выполненных работ</option>--}}
{{--                            <option value="Накладная" data-i18n="optWaybill">Накладная</option>--}}
{{--                        </optgroup>--}}
{{--                        <optgroup label="Кадровые" data-i18n="catHR">--}}
{{--                            <option value="Приказ" data-i18n="optOrder">Приказ</option>--}}
{{--                            <option value="Заявление" data-i18n="optRequest">Заявление</option>--}}
{{--                            <option value="Трудовой договор" data-i18n="optLabor">Трудовой договор</option>--}}
{{--                        </optgroup>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <div class="w-100 w-md-auto" style="min-width:180px;">--}}
{{--                    <label class="form-label mb-1" style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px; color: var(--text-secondary);" data-i18n="status">Статус</label>--}}
{{--                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm rounded-3" style="font-size:13px;font-weight:500; background: var(--bg-input); border-color: var(--border-color); color: var(--text-primary);">--}}
{{--                        <option value="" data-i18n="allStatuses">Все статусы</option>--}}
{{--                        <option value="active" data-i18n="optActive">Активный</option>--}}
{{--                        <option value="approved" data-i18n="optApproved">Подписан</option>--}}
{{--                        <option value="rejected" data-i18n="optRejected">Отклонен</option>--}}
{{--                        <option value="draft" data-i18n="optDraft">Черновик</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                @if(request()->anyFilled(['search','type','status']))--}}
{{--                    <div class="d-flex align-items-end pb-2">--}}
{{--                        <a href="{{ route('documents.index') }}" class="btn btn-sm btn-outline-danger rounded-3 d-flex align-items-center gap-1" style="font-size:11px;font-weight:600; border-color: var(--border-color); color: var(--danger);">--}}
{{--                            <i class="bi bi-x-lg"></i> <span data-i18n="resetFilters">Сбросить</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </form>--}}

{{--            --}}{{----}}{{-- Table --}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table mb-0">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th style="width:80px; background: var(--bg-input); color: var(--text-secondary); border-color: var(--border-color); padding: 14px 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">#</th>--}}
{{--                        <th style="background: var(--bg-input); color: var(--text-secondary); border-color: var(--border-color); padding: 14px 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;" data-i18n="colDocument">Документ</th>--}}
{{--                        <th style="width:140px; background: var(--bg-input); color: var(--text-secondary); border-color: var(--border-color); padding: 14px 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;" data-i18n="colType">Тип</th>--}}
{{--                        <th style="width:120px; background: var(--bg-input); color: var(--text-secondary); border-color: var(--border-color); padding: 14px 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;" data-i18n="colStatus">Статус</th>--}}
{{--                        <th style="width:110px;text-align:center; background: var(--bg-input); color: var(--text-secondary); border-color: var(--border-color); padding: 14px 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;" data-i18n="colDate">Дата</th>--}}
{{--                        <th style="width:140px;text-align:right; background: var(--bg-input); color: var(--text-secondary); border-color: var(--border-color); padding: 14px 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;" data-i18n="colActions">Действия</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @forelse($documents as $doc)--}}
{{--                        <tr>--}}
{{--                            <td style="border-color: var(--border-color); color: var(--text-primary); padding: 14px 20px; font-size: 13px; vertical-align: middle;">--}}
{{--                                <a href="{{ route('documents.show', $doc->id) }}" class="fw-semibold" style="color:var(--primary);text-decoration:none;">--}}
{{--                                    #{{ str_pad($doc->id, 4, '0', STR_PAD_LEFT) }}--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td style="border-color: var(--border-color); color: var(--text-primary); padding: 14px 20px; font-size: 14px; font-weight: 500; vertical-align: middle;">--}}
{{--                                {{ $doc->title }}--}}
{{--                            </td>--}}
{{--                            <td style="border-color: var(--border-color); color: var(--text-secondary); padding: 14px 20px; font-size: 12px; vertical-align: middle;">--}}
{{--                                {{ $doc->type ?? '—' }}--}}
{{--                            </td>--}}
{{--                            <td style="border-color: var(--border-color); padding: 14px 20px; vertical-align: middle;">--}}
{{--                                @php--}}
{{--                                    $status = match($doc->status) {--}}
{{--                                        'approved','signed','Подписан' => ['class'=>'status-approved','label'=>'optApproved'],--}}
{{--                                        'pending','active','На согласовании' => ['class'=>'status-pending','label'=>'optPending'],--}}
{{--                                        'rejected','Отклонён' => ['class'=>'status-rejected','label'=>'optRejected'],--}}
{{--                                        'draft','Черновик' => ['class'=>'status-draft','label'=>'optDraft'],--}}
{{--                                        default => ['class'=>'status-draft','label'=>'__custom'],--}}
{{--                                    };--}}
{{--                                @endphp--}}
{{--                                <span class="status-badge {{ $status['class'] }}" @if($status['label']=='__custom')>{{ $doc->status }}@else data-i18n="{{ $status['label'] }}"@endif>--}}
{{--                            </span>--}}
{{--                            </td>--}}
{{--                            <td class="text-center" style="border-color: var(--border-color); color: var(--text-secondary); font-size:13px; padding: 14px 20px; vertical-align: middle;">--}}
{{--                                {{ $doc->created_at?->format('d.m.Y') ?? '—' }}--}}
{{--                            </td>--}}
{{--                            <td class="text-end" style="border-color: var(--border-color); padding: 14px 20px; vertical-align: middle;">--}}
{{--                                <div class="d-flex justify-content-end gap-1">--}}
{{--                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-light rounded-3" title="Просмотр" style="background: var(--bg-input); border-color: var(--border-color); color: var(--text-primary);">--}}
{{--                                        <i class="bi bi-eye"></i>--}}
{{--                                    </a>--}}
{{--                                    <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-sm btn-light rounded-3" title="Редактировать" style="background: var(--bg-input); border-color: var(--border-color); color: var(--text-primary);">--}}
{{--                                        <i class="bi bi-pencil"></i>--}}
{{--                                    </a>--}}
{{--                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm(currentLang === 'tj' ? 'Ҳуҷҷатро нест мекунед?' : currentLang === 'ru' ? 'Удалить документ?' : 'Delete document?')">--}}
{{--                                        @csrf @method('DELETE')--}}
{{--                                        <button type="submit" class="btn btn-sm btn-light rounded-3 text-danger" title="Удалить" style="background: var(--bg-input); border-color: var(--border-color); color: var(--danger);">--}}
{{--                                            <i class="bi bi-trash"></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="6" class="text-center py-5" style="border-color: var(--border-color); color: var(--text-secondary); background: var(--bg-card);">--}}
{{--                                <div style="font-size:13px;">--}}
{{--                                    <i class="bi bi-folder-x d-block fs-4 mb-2"></i>--}}
{{--                                    <span data-i18n="noDocs">Документы не найдены</span>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

{{--            --}}{{----}}{{-- Pagination --}}
{{--            @if($documents->hasPages())--}}
{{--                <div class="p-3 border-top d-flex justify-content-between align-items-center" style="background: var(--bg-input); border-color: var(--border-color);">--}}
{{--                    <span class="text-muted" style="font-size:12px; color: var(--text-secondary);"><span data-i18n="total">Всего</span>: <strong style="color: var(--text-primary);">{{ $documents->total() }}</strong></span>--}}
{{--                    <div class="pagination pagination-sm mb-0">--}}
{{--                        {{ $documents->withQueryString()->links() }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@push('styles')--}}
{{--    <style>--}}
{{--        :root {--}}
{{--            --bg-main: #f1f5f9; --bg-card: #ffffff; --bg-input: #f8fafc;--}}
{{--            --border-color: #e2e8f0; --text-primary: #0f172a; --text-secondary: #64748b;--}}
{{--            --primary: #4f46e5; --primary-dark: #4338ca; --danger: #ef4444; --hover-bg: #f1f5f9;--}}
{{--        }--}}
{{--        html.dark {--}}
{{--            --bg-main: #0f172a; --bg-card: #1e293b; --bg-input: #334155;--}}
{{--            --border-color: #334155; --text-primary: #f1f5f9; --text-secondary: #94a3b8;--}}
{{--            --hover-bg: #334155;--}}
{{--        }--}}

{{--        body { background: var(--bg-main); color: var(--text-primary); transition: background 0.3s, color 0.3s; }--}}
{{--        .table-custom { background: var(--bg-card); border-radius: 16px; overflow: hidden; border: 1px solid var(--border-color); }--}}

{{--        .btn-primary-custom { background: var(--primary); color: #fff; border: none; padding: 8px 20px; border-radius: 10px; font-weight: 500; transition: all 0.2s; }--}}
{{--        .btn-primary-custom:hover { background: var(--primary-dark); color: #fff; }--}}

{{--        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; }--}}
{{--        .status-draft { background: #fef3c7; color: #92400e; }--}}
{{--        .status-pending { background: #dbeafe; color: #1e40af; }--}}
{{--        .status-approved { background: #dcfce7; color: #166534; }--}}
{{--        .status-rejected { background: #fee2e2; color: #991b1b; }--}}
{{--        .optPending { display: inline-block; } /* Fix for match label */--}}

{{--        html.dark .status-draft { background: #854d0e33; color: #fbbf24; }--}}
{{--        html.dark .status-pending { background: #1e3a5f33; color: #60a5fa; }--}}
{{--        html.dark .status-approved { background: #16653433; color: #4ade80; }--}}
{{--        html.dark .status-rejected { background: #7f1d1d33; color: #f87171; }--}}

{{--        .alert-success-custom { background: #dcfce7; color: #166534; border: 1px solid #86efac; }--}}
{{--        html.dark .alert-success-custom { background: #16653433; color: #4ade80; border-color: #16653466; }--}}

{{--        .pagination .page-link { border-radius: 8px !important; margin: 0 2px; border: 1px solid var(--border-color) !important; color: var(--text-primary) !important; font-size: 12px; font-weight: 500; background: var(--bg-card) !important; }--}}
{{--        .pagination .page-item.active .page-link { background: var(--primary) !important; border-color: var(--primary) !important; color: #fff !important; }--}}
{{--        .pagination .page-link:hover { background: var(--hover-bg) !important; border-color: var(--primary) !important; }--}}
{{--        html.dark .pagination .page-link { background: var(--bg-card) !important; color: var(--text-primary) !important; }--}}
{{--    </style>--}}
{{--@endpush--}}

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        // Extend translations from layout if present, or define fallback--}}
{{--        window.translations = window.translations || {};--}}
{{--        const addLangKeys = {--}}
{{--            ru: {--}}
{{--                documents: "Документы", docSubtitle: "Реестр электронных документов", createDoc: "Создать документ",--}}
{{--                docType: "Тип документа", allTypes: "Все типы", status: "Статус", allStatuses: "Все статусы",--}}
{{--                catFinancial: "Финансовые", optUPD: "УПД", optBill: "Счёт", optInv: "Счёт-фактура", optRecon: "Акт сверки",--}}
{{--                catCommercial: "Коммерческие", optContract: "Договор", optAddendum: "Доп. соглашение", optAct: "Акт выполненных работ", optWaybill: "Накладная",--}}
{{--                catHR: "Кадровые", optOrder: "Приказ", optRequest: "Заявление", optLabor: "Трудовой договор",--}}
{{--                optActive: "Активный", optApproved: "Подписан", optPending: "В работе", optRejected: "Отклонен", optDraft: "Черновик",--}}
{{--                resetFilters: "Сбросить", colDocument: "Документ", colType: "Тип", colStatus: "Статус", colDate: "Дата", colActions: "Действия",--}}
{{--                noDocs: "Документы не найдены", total: "Всего"--}}
{{--            },--}}
{{--            en: {--}}
{{--                documents: "Documents", docSubtitle: "Registry of electronic documents", createDoc: "Create Document",--}}
{{--                docType: "Document Type", allTypes: "All types", status: "Status", allStatuses: "All statuses",--}}
{{--                catFinancial: "Financial", optUPD: "UPD", optBill: "Bill", optInv: "Invoice", optRecon: "Reconciliation",--}}
{{--                catCommercial: "Commercial", optContract: "Contract", optAddendum: "Addendum", optAct: "Work Act", optWaybill: "Waybill",--}}
{{--                catHR: "HR", optOrder: "Order", optRequest: "Application", optLabor: "Labor Agreement",--}}
{{--                optActive: "Active", optApproved: "Approved", optPending: "Pending", optRejected: "Rejected", optDraft: "Draft",--}}
{{--                resetFilters: "Reset", colDocument: "Document", colType: "Type", colStatus: "Status", colDate: "Date", colActions: "Actions",--}}
{{--                noDocs: "No documents found", total: "Total"--}}
{{--            },--}}
{{--            tj: {--}}
{{--                documents: "Ҳуҷҷатҳо", docSubtitle: "Реестри ҳуҷҷатҳои электронӣ", createDoc: "Сохтани ҳуҷҷат",--}}
{{--                docType: "Намуди ҳуҷҷат", allTypes: "Ҳамаи намудҳо", status: "Ҳолат", allStatuses: "Ҳамаи ҳолатҳо",--}}
{{--                catFinancial: "Молиявӣ", optUPD: "УПД", optBill: "Счёт", optInv: "Счёт-фактура", optRecon: "Акт сверки",--}}
{{--                catCommercial: "Тиҷоратӣ", optContract: "Шартнома", optAddendum: "Илова", optAct: "Акт", optWaybill: "Накладная",--}}
{{--                catHR: "Кадрӣ", optOrder: "Фармон", optRequest: "Ариза", optLabor: "Шартномаи меҳнатӣ",--}}
{{--                optActive: "Фаъол", optApproved: "Тасдиқшуда", optPending: "Дар интизорӣ", optRejected: "Радшуда", optDraft: "Пешнавис",--}}
{{--                resetFilters: "Тоза кардан", colDocument: "Ҳуҷҷат", colType: "Намуд", colStatus: "Ҳолат", colDate: "Сана", colActions: "Амалҳо",--}}
{{--                noDocs: "Ҳуҷҷатҳо ёфт нашуданд", total: "Ҳамагӣ"--}}
{{--            }--}}
{{--        };--}}
{{--        Object.keys(addLangKeys).forEach(lang => {--}}
{{--            window.translations[lang] = { ...(window.translations[lang] || {}), ...addLangKeys[lang] };--}}
{{--        });--}}

{{--        // Apply translation immediately if currentLang exists, else default to ru--}}
{{--        function applyDocLang() {--}}
{{--            const lang = typeof currentLang !== 'undefined' ? currentLang : 'ru';--}}
{{--            const t = window.translations[lang] || window.translations['ru'];--}}
{{--            document.querySelectorAll('[data-i18n]').forEach(el => {--}}
{{--                const key = el.getAttribute('data-i18n');--}}
{{--                if (t[key]) {--}}
{{--                    if (el.tagName === 'OPTION' || el.tagName === 'OPTGROUP') {--}}
{{--                        el.textContent = t[key];--}}
{{--                    } else {--}}
{{--                        el.textContent = t[key];--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}
{{--        document.addEventListener('DOMContentLoaded', applyDocLang);--}}
{{--        // Observe language changes--}}
{{--        const observer = new MutationObserver(applyDocLang);--}}
{{--        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['lang'] });--}}
{{--    </script>--}}
{{--@endpush--}}





{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    --}}{{----}}{{-- Добавили класс bg-main-dark для серого фона вокруг таблицы --}}
{{--    <div class="container-fluid px-4 py-4 bg-main-dark min-vh-100">--}}

{{--        <div class="d-flex justify-content-between align-items-center mb-4">--}}
{{--            <div>--}}
{{--                <h2 class="fw-bold text-white mb-1" data-i18n="documents">Документы</h2>--}}
{{--                <p class="text-white opacity-50 mb-0" data-i18n="docSubtitle">Реестр электронных документов</p>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="table-custom-wrapper shadow-lg">--}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table mb-0">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>#</th>--}}
{{--                        <th data-i18n="colDocument">ДОКУМЕНТ</th>--}}
{{--                        <th data-i18n="colType">ТИП</th>--}}
{{--                        <th data-i18n="colStatus">СТАТУС</th>--}}
{{--                        <th class="text-center" data-i18n="colDate">ДАТА</th>--}}
{{--                        <th class="text-end" data-i18n="colActions">ДЕЙСТВИЯ</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @forelse($documents as $doc)--}}
{{--                        --}}{{----}}{{-- Добавили hover-row для эффекта при наведении --}}
{{--                        <tr class="align-middle hover-row {{ $doc->id == 16 ? 'row-active-black' : 'row-blue' }}">--}}
{{--                            <td class="fw-bold">--}}
{{--                                <a href="#" class="doc-id-link">#{{ str_pad($doc->id, 4, '0', STR_PAD_LEFT) }}</a>--}}
{{--                            </td>--}}
{{--                            <td class="fw-medium">{{ $doc->title }}</td>--}}
{{--                            <td><i class="bi bi-tag-fill me-1"></i> {{ $doc->type ?? '—' }}</td>--}}
{{--                            <td><span class="status-badge" data-i18n="status_{{ strtolower($doc->status) }}">{{ $doc->status }}</span></td>--}}
{{--                            <td class="text-center">{{ $doc->created_at?->format('d.m.Y') }}</td>--}}
{{--                            <td class="text-end">--}}
{{--                                <div class="d-flex justify-content-end gap-2">--}}
{{--                                    <i class="bi bi-eye btn-icon"></i>--}}
{{--                                    <i class="bi bi-pencil btn-icon"></i>--}}
{{--                                    <i class="bi bi-trash btn-icon text-danger-light"></i>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr><td colspan="6" class="text-center py-4 text-white" data-i18n="noData">Нет данных</td></tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@push('styles')--}}
{{--    <style>--}}
{{--        /* Серый фон для страницы (фон контента) */--}}
{{--        .bg-main-dark {--}}
{{--            background-color: #1a1d21 !important; /* Тёмно-серый оттенок */--}}
{{--        }--}}

{{--        .table-custom-wrapper {--}}
{{--            background-color: #0052cc !important;--}}
{{--            border-radius: 12px;--}}
{{--            overflow: hidden;--}}
{{--            border: 1px solid rgba(255, 255, 255, 0.05);--}}
{{--        }--}}

{{--        .table-custom-wrapper .table {--}}
{{--            --bs-table-bg: transparent !important;--}}
{{--            --bs-table-border-color: rgba(255, 255, 255, 0.1) !important;--}}
{{--            margin-bottom: 0;--}}
{{--        }--}}

{{--        /* Обычная синяя строка */--}}
{{--        .row-blue td {--}}
{{--            background-color: #0052cc !important;--}}
{{--            color: #ffffff !important;--}}
{{--            transition: background 0.2s ease;--}}
{{--        }--}}

{{--        /* ЭФФЕКТ HOVER (при наведении) */--}}
{{--        .hover-row:hover td {--}}
{{--            background-color: rgba(255, 255, 255, 0.1) !important; /* Легкое высветление */--}}
{{--            cursor: pointer;--}}
{{--        }--}}

{{--        /* Активная черная строка */--}}
{{--        .row-active-black td {--}}
{{--            background-color: #0f172a !important;--}}
{{--            color: #ffffff !important;--}}
{{--        }--}}

{{--        .table-custom-wrapper th {--}}
{{--            background-color: rgba(0, 0, 0, 0.3) !important;--}}
{{--            color: rgba(255, 255, 255, 0.7) !important;--}}
{{--            text-transform: uppercase;--}}
{{--            font-size: 11px;--}}
{{--            padding: 16px !important;--}}
{{--            border: none !important;--}}
{{--        }--}}

{{--        .doc-id-link { color: #ff9f43 !important; text-decoration: none; }--}}
{{--        .status-badge {--}}
{{--            border: 1px solid rgba(255, 255, 255, 0.3);--}}
{{--            padding: 2px 10px;--}}
{{--            border-radius: 20px;--}}
{{--            font-size: 12px;--}}
{{--        }--}}
{{--        .btn-icon { font-size: 1.1rem; opacity: 0.7; transition: 0.2s; cursor: pointer; }--}}
{{--        .btn-icon:hover { opacity: 1; transform: scale(1.1); }--}}
{{--        .text-danger-light { color: #ff6b6b !important; }--}}
{{--    </style>--}}
{{--@endpush--}}

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        /**--}}
{{--         * Функция для автоматического перевода элементов с атрибутом data-i18n--}}
{{--         */--}}
{{--        function syncTranslations() {--}}
{{--            // Берем язык из тега <html lang="...">--}}
{{--            const currentLang = document.documentElement.lang || 'ru';--}}

{{--            // Предполагаем, что переводы лежат в window.translations (стандарт для многих админок)--}}
{{--            // Если у тебя другой объект с переводами, замени window.translations на него--}}
{{--            const i18n = window.translations ? window.translations[currentLang] : null;--}}

{{--            if (i18n) {--}}
{{--                document.querySelectorAll('[data-i18n]').forEach(el => {--}}
{{--                    const key = el.getAttribute('data-i18n');--}}
{{--                    if (i18n[key]) {--}}
{{--                        el.innerText = i18n[key];--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--        }--}}

{{--        // Запускаем перевод при загрузке--}}
{{--        document.addEventListener('DOMContentLoaded', syncTranslations);--}}

{{--        // Следим за изменением языка (если он меняется без перезагрузки страницы)--}}
{{--        const observer = new MutationObserver((mutations) => {--}}
{{--            mutations.forEach((mutation) => {--}}
{{--                if (mutation.type === 'attributes' && mutation.attributeName === 'lang') {--}}
{{--                    syncTranslations();--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--        observer.observe(document.documentElement, { attributes: true });--}}
{{--    </script>--}}
{{--@endpush--}}

{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="doc-page-v2 min-h-[calc(100vh-64px)] py-8 px-4 md:px-8">--}}

{{--        <!-- Header & Controls -->--}}
{{--        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">--}}
{{--            <div>--}}
{{--                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1 drop-shadow-sm" data-i18n="documents">Documents</h1>--}}
{{--                <p class="text-blue-200/80 text-sm font-medium" data-i18n="docSubtitle">Manage all your documents in one place</p>--}}
{{--            </div>--}}

{{--            <form action="{{ route('documents.index') }}" method="GET" class="flex flex-wrap gap-3 items-center">--}}
{{--                <!-- Search -->--}}
{{--                <div class="relative group">--}}
{{--                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-300/70 group-focus-within:text-blue-100 transition-colors duration-200"></i>--}}
{{--                    <input type="text" name="search" value="{{ request('search') }}"--}}
{{--                           class="doc-input-search pl-10 pr-4 py-2.5 w-60 rounded-xl bg-blue-900/40 border border-blue-700/50 text-white placeholder-blue-300/60 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-blue-400 transition-all duration-200 backdrop-blur-sm"--}}
{{--                           placeholder="Search..." data-i18n-placeholder="searchPlaceholder">--}}
{{--                </div>--}}

{{--                <!-- Status Filter -->--}}
{{--                <select name="status" class="doc-input-select px-4 py-2.5 rounded-xl bg-blue-900/40 border border-blue-700/50 text-white focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition-all duration-200 backdrop-blur-sm cursor-pointer hover:border-blue-600" onchange="this.form.submit()">--}}
{{--                    <option value="">{{ __('All statuses') }}</option>--}}
{{--                    <option value="draft" {{ request('status')==='draft'?'selected':'' }} data-i18n="status_draft">Draft</option>--}}
{{--                    <option value="pending" {{ request('status')==='pending'?'selected':'' }} data-i18n="status_pending">Pending</option>--}}
{{--                    <option value="approved" {{ request('status')==='approved'?'selected':'' }} data-i18n="status_approved">Approved</option>--}}
{{--                    <option value="rejected" {{ request('status')==='rejected'?'selected':'' }} data-i18n="status_rejected">Rejected</option>--}}
{{--                </select>--}}

{{--                <!-- Create Button -->--}}
{{--                <a href="{{ route('documents.create') }}" class="doc-btn-create flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-400/40 transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0">--}}
{{--                    <i class="bi bi-plus-lg"></i> <span data-i18n="newDocument">New Document</span>--}}
{{--                </a>--}}
{{--            </form>--}}
{{--        </div>--}}

{{--        <!-- Table Container -->--}}
{{--        <div class="doc-table-container rounded-2xl overflow-hidden shadow-2xl shadow-black/30 border border-blue-700/40 bg-blue-900/60 backdrop-blur-md">--}}
{{--            <div class="overflow-x-auto">--}}
{{--                <table class="w-full text-left border-collapse">--}}
{{--                    <thead>--}}
{{--                    <tr class="bg-blue-950/70 text-blue-200 text-[11px] uppercase tracking-widest border-b border-blue-800/50">--}}
{{--                        <th class="px-6 py-4 font-bold w-24">#</th>--}}
{{--                        <th class="px-6 py-4 font-bold" data-i18n="colDocument">Document</th>--}}
{{--                        <th class="px-6 py-4 font-bold" data-i18n="colType">Type</th>--}}
{{--                        <th class="px-6 py-4 font-bold text-center" data-i18n="colStatus">Status</th>--}}
{{--                        <th class="px-6 py-4 font-bold text-center" data-i18n="colDate">Date</th>--}}
{{--                        <th class="px-6 py-4 font-bold text-right" data-i18n="colActions">Actions</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="divide-y divide-blue-800/30">--}}
{{--                    @forelse($documents as $doc)--}}
{{--                        <tr class="doc-row group transition-all duration-200 hover:bg-blue-700/25 cursor-pointer"--}}
{{--                            data-document-id="{{ $doc->id }}"--}}
{{--                            onclick="window.location.href='{{ route('documents.show', $doc->id) }}'">--}}

{{--                            <td class="px-6 py-4">--}}
{{--                                <span class="doc-id-link font-mono text-blue-300 group-hover:text-white transition-colors duration-200">#{{ str_pad($doc->id, 4, '0', STR_PAD_LEFT) }}</span>--}}
{{--                            </td>--}}

{{--                            <td class="px-6 py-4 font-medium text-white group-hover:text-blue-50 transition-colors duration-200">{{ $doc->title }}</td>--}}

{{--                            <td class="px-6 py-4">--}}
{{--                                <div class="flex items-center gap-2 text-blue-200/80 group-hover:text-blue-100 transition-colors">--}}
{{--                                    <i class="bi bi-tag-fill text-xs opacity-50"></i>--}}
{{--                                    <span>{{ $doc->type ?? '—' }}</span>--}}
{{--                                </div>--}}
{{--                            </td>--}}

{{--                            <td class="px-6 py-4 text-center">--}}
{{--                                @php--}}
{{--                                    $statusMap = [--}}
{{--                                        'draft' => 'bg-amber-500/20 text-amber-200 border-amber-500/40',--}}
{{--                                        'pending' => 'bg-blue-500/20 text-blue-200 border-blue-500/40',--}}
{{--                                        'approved' => 'bg-emerald-500/20 text-emerald-200 border-emerald-500/40',--}}
{{--                                        'rejected' => 'bg-rose-500/20 text-rose-200 border-rose-500/40',--}}
{{--                                    ];--}}
{{--                                    $statusClass = $statusMap[strtolower($doc->status)] ?? 'bg-slate-500/20 text-slate-200 border-slate-500/40';--}}
{{--                                @endphp--}}
{{--                                <span class="doc-status-badge inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold border backdrop-blur-sm {{ $statusClass }}" data-i18n="status_{{ strtolower($doc->status) }}">--}}
{{--                                {{ $doc->status }}--}}
{{--                            </span>--}}
{{--                            </td>--}}

{{--                            <td class="px-6 py-4 text-center text-blue-200/70 text-sm font-mono tracking-wide">{{ $doc->created_at?->format('d.m.Y') }}</td>--}}

{{--                            <td class="px-6 py-4 text-right">--}}
{{--                                <div class="flex items-center justify-end gap-2" onclick="event.stopPropagation()">--}}
{{--                                    <a href="{{ route('documents.show', $doc->id) }}"--}}
{{--                                       class="doc-action-btn w-9 h-9 flex items-center justify-center rounded-lg bg-blue-800/40 hover:bg-blue-600 text-blue-200 hover:text-white transition-all duration-200 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/20"--}}
{{--                                       title="View" data-i18n-title="view">--}}
{{--                                        <i class="bi bi-eye"></i>--}}
{{--                                    </a>--}}
{{--                                    <a href="{{ route('documents.edit', $doc->id) }}"--}}
{{--                                       class="doc-action-btn w-9 h-9 flex items-center justify-center rounded-lg bg-blue-800/40 hover:bg-blue-600 text-blue-200 hover:text-white transition-all duration-200 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/20"--}}
{{--                                       title="Edit" data-i18n-title="edit">--}}
{{--                                        <i class="bi bi-pencil"></i>--}}
{{--                                    </a>--}}
{{--                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">--}}
{{--                                        @csrf @method('DELETE')--}}
{{--                                        <button type="submit"--}}
{{--                                                class="doc-action-btn doc-btn-delete w-9 h-9 flex items-center justify-center rounded-lg bg-rose-900/30 hover:bg-rose-600 text-rose-300 hover:text-white transition-all duration-200 hover:scale-110 hover:shadow-lg hover:shadow-rose-500/20"--}}
{{--                                                title="Delete" data-i18n-title="delete">--}}
{{--                                            <i class="bi bi-trash"></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="6" class="text-center py-16 text-blue-200/60">--}}
{{--                                <div class="flex flex-col items-center gap-4">--}}
{{--                                    <div class="w-20 h-20 rounded-full bg-blue-800/30 flex items-center justify-center backdrop-blur-sm border border-blue-700/30">--}}
{{--                                        <i class="bi bi-folder-x text-4xl text-blue-300/50"></i>--}}
{{--                                    </div>--}}
{{--                                    <span data-i18n="noDocuments" class="text-lg font-semibold tracking-wide">No documents found</span>--}}
{{--                                    <p class="text-sm text-blue-300/40">Try adjusting your filters or create a new document</p>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Pagination -->--}}
{{--        @if($documents->hasPages())--}}
{{--            <div class="mt-8 flex justify-center doc-pagination-wrapper">--}}
{{--                {{ $documents->withQueryString()->links() }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--    </div>--}}
{{--@endsection--}}

{{--@push('styles')--}}
{{--    <style>--}}
{{--        /* 🔒 ГЛОБАЛЬНАЯ ИЗОЛЯЦИЯ И ФИКСАЦИЯ СИНЕЙ ТЕМЫ */--}}
{{--        .doc-page-v2 { background: linear-gradient(145deg, #0b1120 0%, #111827 30%, #1e3a8a 100%) !important; }--}}
{{--        .doc-page-v2 * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }--}}

{{--        /* Inputs Focus */--}}
{{--        .doc-input-search:focus, .doc-input-select:focus { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.35) !important; }--}}
{{--        .doc-input-search::placeholder { opacity: 0.5; }--}}

{{--        /* Buttons */--}}
{{--        .doc-btn-create:active { transform: translateY(0) !important; }--}}

{{--        /* Table Rows */--}}
{{--        .doc-row:last-child td { border-bottom: none !important; }--}}
{{--        .doc-row:active { background: rgba(30, 58, 138, 0.4) !important; }--}}

{{--        /* Status Badges */--}}
{{--        .doc-status-badge { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }--}}

{{--        /* Pagination Custom Styling (Override Bootstrap/Laravel default) */--}}
{{--        .doc-pagination-wrapper nav { display: flex !important; gap: 6px !important; align-items: center; padding: 0; margin: 0; }--}}
{{--        .doc-pagination-wrapper ul { list-style: none; padding: 0; margin: 0; display: flex; gap: 6px; }--}}
{{--        .doc-pagination-wrapper li { margin: 0 !important; }--}}
{{--        .doc-pagination-wrapper a, .doc-pagination-wrapper span {--}}
{{--            padding: 0.6rem 1rem; border-radius: 0.75rem;--}}
{{--            background: rgba(30, 58, 138, 0.4) !important; color: #93c5fd !important;--}}
{{--            border: 1px solid rgba(59, 130, 246, 0.25) !important;--}}
{{--            transition: all 0.2s ease; font-size: 0.875rem; font-weight: 500;--}}
{{--            text-decoration: none !important; display: inline-flex; align-items: center;--}}
{{--        }--}}
{{--        .doc-pagination-wrapper a:hover { background: rgba(59, 130, 246, 0.3) !important; color: #ffffff !important; transform: translateY(-1px); }--}}
{{--        .doc-pagination-wrapper .active span { background: #3b82f6 !important; color: #ffffff !important; border-color: #3b82f6 !important; font-weight: 600; box-shadow: 0 4px 12px rgba(59,130,246,0.3); }--}}
{{--        .doc-pagination-wrapper .disabled span { opacity: 0.4; cursor: not-allowed; background: transparent !important; border-color: transparent !important; }--}}
{{--        .doc-pagination-wrapper .page-link { padding: 0.6rem 1rem; }--}}

{{--        /* 🔥 ЖЁСТКАЯ БЛОКИРОВКА ТЁМНОЙ ТЕМЫ АДМИНКИ */--}}
{{--        html.dark .doc-page-v2 { background: linear-gradient(145deg, #0b1120 0%, #111827 30%, #1e3a8a 100%) !important; }--}}
{{--        html.dark .doc-table-container { background: rgba(30, 58, 138, 0.7) !important; border-color: rgba(59, 130, 246, 0.4) !important; }--}}
{{--        html.dark .doc-input-search, html.dark .doc-input-select { background: rgba(15, 23, 42, 0.6) !important; border-color: #1e3a8a !important; color: white !important; }--}}
{{--        html.dark .doc-btn-create { background: linear-gradient(to right, #3b82f6, #4f46e5) !important; }--}}
{{--        html.dark .doc-pagination-wrapper a, html.dark .doc-pagination-wrapper span { background: rgba(30, 58, 138, 0.5) !important; color: #93c5fd !important; }--}}
{{--        html.dark .doc-pagination-wrapper .active span { background: #3b82f6 !important; color: white !important; }--}}
{{--    </style>--}}
{{--@endpush--}}

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function() {--}}
{{--            function syncDocTranslations() {--}}
{{--                const lang = document.documentElement.lang || 'ru';--}}
{{--                const t = window.translations?.[lang] || window.translations?.ru || {};--}}
{{--                document.querySelectorAll('[data-i18n]').forEach(el => { if(t[el.dataset.i18n]) el.textContent = t[el.dataset.i18n]; });--}}
{{--                document.querySelectorAll('[data-i18n-placeholder]').forEach(el => { if(t[el.dataset.i18nPlaceholder]) el.placeholder = t[el.dataset.i18nPlaceholder]; });--}}
{{--                document.querySelectorAll('[data-i18n-title]').forEach(el => { if(t[el.dataset.i18nTitle]) el.title = t[el.dataset.i18nTitle]; });--}}
{{--            }--}}
{{--            syncDocTranslations();--}}
{{--            new MutationObserver(syncDocTranslations).observe(document.documentElement, { attributes: true, attributeFilter: ['lang'] });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}

@extends('layouts.admin')

@section('content')
    {{-- Главный контейнер --}}
    <div class="doc-page-v2 bg-blue-theme min-h-[calc(100vh-64px)] py-6 px-4 md:px-8 relative">

        <div class="relative z-10 max-w-7xl mx-auto">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                        DOCUMENTS
                    </h1>
                </div>

                <form action="{{ route('documents.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative flex items-center">
                        <input type="text"
                               name="search"
                               id="search-input"
                               list="documents-list"
                               value="{{ request('search') }}"
                               class="bg-white border border-slate-200 text-[10px] text-black placeholder-slate-400 rounded-lg pl-3 pr-8 py-1.5 w-40 focus:ring-1 focus:ring-blue-500 outline-none transition-all font-bold shadow-sm"
                               placeholder="Search..."
                               autocomplete="off">

                        <datalist id="documents-list">
                            @foreach($documents as $doc)
                                <option value="{{ $doc->title }}">
                            @endforeach
                        </datalist>

                        <button type="submit" class="absolute right-1 px-1.5 py-1 text-slate-500 hover:text-blue-600 transition-colors">
                            <i class="bi bi-arrow-right-short text-xl leading-none"></i>
                        </button>
                    </div>

                    <a href="{{route('documents.create')}}" class="btn-primary-custom" onclick="showPage('documents', null)"><i class="bi bi-plus-lg me-1"></i> <span data-i18n="newDocument">New Document</span></a>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse bg-white">
                    <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50">
                        <th class="px-4 py-2 text-[9px] font-medium text-black uppercase tracking-[0.2em]">ID</th>
                        <th class="px-4 py-2 text-[9px] font-medium text-black uppercase tracking-[0.2em]">Document Info</th>
                        <th class="px-4 py-2 text-center text-[9px] font-medium text-black uppercase tracking-[0.2em]">Deadline</th>
                        <th class="px-4 py-2 text-center text-[9px] font-medium text-black uppercase tracking-[0.2em]">Status</th>
                        <th class="px-4 py-2 text-right text-[9px] font-medium text-black uppercase tracking-[0.2em]">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $index=>$doc)
                        <tr class="group hover:bg-slate-50 transition-all">
                            <td class="px-4 py-2 text-[10px] text-black font-normal italic">#{{ ($documents->currentPage() - 1) * $documents->perPage() + $index + 1 }}</td>

                            <td class="px-4 py-2">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-medium text-black uppercase tracking-wider">
                                            {{ Str::limit($doc->title, 45) }}
                                        </span>
                                        <span class="text-[10px] font-bold text-blue-600 italic">
                                            {{ $doc->number ?? $doc->id }}
                                        </span>
                                    </div>

                                    {{-- Показываем автора только для Админа --}}
                                    @if(auth()->user()->is_admin)
                                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter">
                                            By: {{ $doc->createdBy->name ?? 'System' }}
                                        </span>
                                    @endif

                                    <span class="text-[9px] text-black font-normal opacity-80 mt-0.5">
                                        {{ Str::limit($doc->content, 40) ?: 'No description' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-2 text-center">
                                <span class="text-[10px] font-normal text-black italic">
                                    {{ $doc->deadline ? $doc->deadline->format('d.m.Y') : '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                @php
                                    $status = strtolower($doc->status);
                                    $colors = match($status) {
                                        'draft' => ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'],
                                        'active', 'approved' => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#93c5fd'],
                                        'rejected' => ['bg' => '#fef2f2', 'text' => '#dc2626', 'border' => '#fecaca'],
                                        default => ['bg' => '#fff7ed', 'text' => '#ea580c', 'border' => '#fdba74'],
                                    };
                                @endphp

                                <span style="display: inline-flex; align-items: center; justify-content: center; background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border: 1px solid {{ $colors['border'] }}; padding: 4px 12px; border-radius: 6px; font-weight: 800; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; min-width: 90px;">
                                    {{ $doc->status_label }} {{-- Используем аксессор из модели --}}
                                </span>
                            </td>

                            <td class="px-4 py-2 text-right">
                                <div class="flex justify-end gap-3 text-black opacity-40 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('documents.show', $doc->id) }}" title="View"><i class="bi bi-eye text-[11px]"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3" style="background-color: #f1f5f9; border: 1px solid #e2e8f0;">
                                        <i class="bi bi-search text-xl text-black opacity-30"></i>
                                    </div>
                                    <p class="text-[11px] font-bold uppercase tracking-widest text-black">Документ не найден</p>
                                    <p class="text-[9px] mt-1 mb-4 uppercase text-black opacity-70">Попробуйте изменить запрос</p>
                                    <a href="{{ route('documents.index') }}" class="px-3 py-1 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-600 text-[9px] font-bold uppercase rounded transition-all">
                                        Сбросить поиск
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
@endsection
