@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-5xl">

        {{-- Шапка --}}
        <div class="mb-10 flex flex-wrap items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase italic leading-none">
                    Настройки профиля
                </h1>
                <p class="text-[12px] font-black text-gray-400 uppercase tracking-[0.3em] mt-3 flex items-center gap-2">
                    <span class="w-8 h-[2px] bg-indigo-600"></span>
                    Управление безопасностью и данными
                </p>
            </div>
            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 text-[11px] font-black text-gray-400 hover:text-indigo-600 uppercase tracking-widest transition-all group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Вернуться в профиль
            </a>
        </div>

        <div class="grid grid-cols-1 gap-10">

            {{-- Блок 1: Основная информация --}}
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-gray-200/60 border border-gray-100 overflow-hidden transition-all hover:border-indigo-100">
                <div class="p-10 md:p-14">
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-2 h-10 bg-indigo-600 rounded-full shadow-lg shadow-indigo-200"></div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 uppercase italic tracking-tight">Личные данные</h3>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mt-1">Имя пользователя и Email</p>
                        </div>
                    </div>

                    <div class="max-w-2xl prose-inputs">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Блок 2: Смена пароля --}}
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-gray-200/60 border border-gray-100 overflow-hidden transition-all hover:border-amber-100">
                <div class="p-10 md:p-14">
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-2 h-10 bg-amber-500 rounded-full shadow-lg shadow-amber-200"></div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 uppercase italic tracking-tight">Безопасность</h3>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mt-1">Обновление пароля доступа</p>
                        </div>
                    </div>

                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Блок 3: Удаление (Опасно) --}}
            <div class="bg-red-50/30 rounded-[3rem] border-2 border-dashed border-red-100 overflow-hidden transition-all hover:bg-red-50/50 group">
                <div class="p-10 md:p-14">
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-2 h-10 bg-red-600 rounded-full shadow-lg shadow-red-200"></div>
                        <div>
                            <h3 class="text-2xl font-black text-red-600 uppercase italic tracking-tight">Зона риска</h3>
                            <p class="text-[11px] font-bold text-red-400/60 uppercase tracking-widest mt-1">Безвозвратное удаление аккаунта</p>
                        </div>
                    </div>

                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Стили для того, чтобы стандартные формы Breeze выглядели как в ЭДО */
        .prose-inputs input {
            @apply w-full px-5 py-4 rounded-2xl border-gray-100 bg-gray-50 font-bold text-gray-700 transition-all focus:bg-white focus:border-indigo-500 focus:ring-0 shadow-sm !important;
        }
        .prose-inputs label {
            @apply text-[11px] font-black uppercase text-gray-400 tracking-widest mb-2 block !important;
        }
        .prose-inputs button, button[type="submit"] {
            @apply bg-gray-900 hover:bg-indigo-600 text-white px-10 py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] transition-all shadow-xl active:scale-95 !important;
        }
        .prose-inputs h2 {
            @apply hidden !important; /* Прячем стандартные заголовки Breeze */
        }
        .prose-inputs p {
            @apply text-sm text-gray-500 font-medium mb-6 !important;
        }
    </style>
@endsection
