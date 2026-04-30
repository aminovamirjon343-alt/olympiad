@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-4xl">

        {{-- Шапка --}}
        <div class="mb-10">
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase italic leading-none">
                Мой профиль
            </h1>
            <p class="text-[12px] font-black text-gray-400 uppercase tracking-[0.3em] mt-3 flex items-center gap-2">
                <span class="w-8 h-[2px] bg-indigo-600"></span>
                Публичная информация аккаунта
            </p>
        </div>

        <div class="bg-white rounded-[3rem] shadow-2xl shadow-gray-200/60 border border-gray-100 overflow-hidden">
            {{-- Верхняя часть с градиентом --}}
            <div class="h-32 bg-gradient-to-r from-gray-900 to-indigo-950"></div>

            <div class="px-10 pb-10">
                <div class="relative flex flex-wrap items-end justify-between -mt-16 mb-10 gap-6">
                    {{-- Аватарка --}}
                    <div class="w-32 h-32 rounded-[2.5rem] bg-white p-2 shadow-xl">
                        <div class="w-full h-full rounded-[2rem] bg-gray-900 flex items-center justify-center text-4xl font-black text-white uppercase italic">
                            {{ Str::substr(auth()->user()->name, 0, 2) }}
                        </div>
                    </div>

                    {{-- Кнопка Редактировать --}}
                    <a href="{{ route('profile.edit') }}"
                       class="bg-gray-900 hover:bg-indigo-600 text-white px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] transition-all shadow-xl active:scale-95 flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        Редактировать профиль
                    </a>
                </div>

                {{-- Данные пользователя --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-2">
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Полное имя</p>
                        <p class="text-2xl font-black text-gray-900 uppercase italic tracking-tight">{{ auth()->user()->name }}</p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Электронная почта</p>
                        <p class="text-xl font-bold text-gray-700 tracking-tight">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="space-y-2 pt-6 border-t border-gray-50">
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Дата регистрации</p>
                        <p class="text-lg font-bold text-gray-900">{{ auth()->user()->created_at->format('d.m.Y') }}</p>
                    </div>

                    <div class="space-y-2 pt-6 border-t border-gray-50">
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Роль в системе</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                            <p class="text-[12px] font-black text-gray-900 uppercase">Администратор</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
