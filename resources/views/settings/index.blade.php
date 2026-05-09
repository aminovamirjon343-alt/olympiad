@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Настройки профиля и ЭДО</h1>
                <p class="text-sm text-gray-500">Управление личными данными и параметрами документооборота</p>
            </div>
            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full uppercase">ID: {{ auth()->id() }}</span>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">

            {{-- Блок 1: Электронная подпись --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="p-2.5 bg-amber-50 dark:bg-amber-900/20 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Электронная графическая подпись</h2>
                        <p class="text-xs text-gray-400">Используется для вшивания в PDF-файлы</p>
                    </div>
                </div>

                <form action="{{ route('settings.signature.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="flex flex-wrap items-center gap-6 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <div class="shrink-0 group relative">
                            @if(auth()->user()->signature_path)
                                <img class="h-20 w-40 object-contain border rounded-lg p-2 bg-white shadow-sm transition group-hover:opacity-75"
                                     src="{{ asset('storage/' . auth()->user()->signature_path) }}" alt="Signature">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    <span class="text-[10px] bg-black/50 text-white px-2 py-1 rounded">Текущая</span>
                                </div>
                            @else
                                <div class="h-20 w-40 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center text-gray-400 bg-white">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                                    <span class="text-[10px] uppercase font-bold">Нет файла</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Загрузить новый PNG (прозрачный)</label>
                            <input type="file" name="signature" accept="image/png" required
                                   class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:bg-gray-800 transition cursor-pointer"/>
                            @error('signature') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-amber-200 dark:shadow-none uppercase text-[10px] tracking-widest">
                            Обновить подпись
                        </button>
                    </div>
                </form>
            </div>

            {{-- Блок 2: Уведомления и Безопасность --}}
            <form action="{{ route('settings.general.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Уведомления --}}
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold mb-4 flex items-center text-blue-600">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span> Уведомления
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">Email-отчеты</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="email_notifications" class="sr-only peer" {{ auth()->user()->email_notifications ? 'checked' : '' }}>
                                    <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">Telegram Bot</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="tg_notifications" class="sr-only peer" {{ auth()->user()->tg_notifications ? 'checked' : '' }}>
                                    <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Региональные настройки --}}
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold mb-4 flex items-center text-green-600">
                            <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span> Локализация
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Язык системы</label>
                                <select name="language" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                                    <option value="ru" {{ auth()->user()->language == 'ru' ? 'selected' : '' }}>Русский</option>
                                    <option value="tg" {{ auth()->user()->language == 'tg' ? 'selected' : '' }}>Тоҷикӣ</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Кнопка сохранения общих настроек --}}
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="w-full md:w-auto bg-black dark:bg-white dark:text-black text-white px-10 py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow-xl text-xs tracking-widest uppercase">
                        Сохранить все изменения
                    </button>
                </div>
            </form>

            {{-- Блок 3: Данные аккаунта (Только чтение) --}}
            <div class="bg-gray-100 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-200 dark:border-gray-800">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm">
                            <span class="text-amber-600 font-bold">TJ</span>
                        </div>
                        <div>
                            <p class="text-gray-400 text-[10px] uppercase font-bold tracking-tight">Телефон привязки</p>
                            <p class="font-mono font-semibold">+992 {{ auth()->user()->phone }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-gray-400 text-[10px] uppercase font-bold tracking-tight">Роль в системе</p>
                            <p class="font-semibold text-gray-700 dark:text-gray-300">{{ auth()->user()->role ?? 'Пользователь' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
