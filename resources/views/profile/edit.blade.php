@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* РАДИКАЛЬНЫЙ ЧЕРНЫЙ ТЕКСТ ДЛЯ ВСЕХ ЭЛЕМЕНТОВ ВНУТРИ КАРТОЧЕК */
        .force-black-text *,
        .force-black-text input,
        .force-black-text select,
        .force-black-text textarea {
            color: #000000 !important;
        }

        /* Дополнительная четкость для инпутов */
        .force-black-text input {
            background-color: #f1f5f9 !important; /* Светло-серый фон для контраста */
            border: 1px solid #cbd5e1 !important;
        }

        /* Стили для кнопок, чтобы они не стали черными вместе с текстом */
        .btn-save-custom {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            font-size: 10px !important;
            padding: 10px 20px !important;
            border-radius: 10px !important;
            transition: all 0.2s ease !important;
            border: none !important;
        }
        .btn-save-custom:hover {
            background-color: #f59e0b !important;
        }
    </style>

    <div class="min-h-screen bg-[#0f172a] py-8 font-['Inter'] tracking-tight">

        <div class="container mx-auto px-4 max-w-2xl">

            <!-- ШАПКА -->
            <div class="mb-6 flex flex-col">
                <a href="{{ route('profile.show') }}" class="group inline-flex items-center gap-2 text-[10px] font-black uppercase text-amber-500 mb-2 transition-all hover:text-amber-400">
                    <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                    Назад
                </a>
                <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                    Настройка
                </h1> </div>

            <div class="space-y-6">

                <!-- БЛОК 1: ДАННЫЕ -->
                <div class="bg-white rounded-2xl shadow-2xl shadow-black/40 overflow-hidden force-black-text">
                    <div class="bg-slate-100 px-6 py-3 border-b border-slate-200 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-widest">Профиль</span>
                    </div>
                    <div class="p-6 md:p-8 [&_h2]:hidden">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- БЛОК 2: ПАРОЛЬ -->
                <div class="bg-white rounded-2xl shadow-2xl shadow-black/40 overflow-hidden force-black-text">
                    <div class="bg-slate-100 px-6 py-3 border-b border-slate-200 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-widest">Безопасность</span>
                    </div>
                    <div class="p-6 md:p-8 [&_h2]:hidden">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- БЛОК 3: УДАЛЕНИЕ -->
                <div class="relative group overflow-hidden">
                    <!-- Фоновое свечение (Glow) при наведении -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-orange-600 rounded-[2rem] blur opacity-0 group-hover:opacity-10 transition duration-500"></div>

                    <div class="relative bg-white rounded-2xl border border-red-200/50 shadow-xl overflow-hidden">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-6 p-6">

                            <div class="flex flex-col items-center md:items-start gap-2">
                                <!-- Индикатор статуса -->
                                <div class="flex items-center gap-2.5">
                                    <div class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                                    </div>
                                    <h3 class="text-red-600 text-[11px] font-black uppercase tracking-[0.2em]">Danger Zone</h3>
                                </div>

                                <!-- Описание (всегда черное) -->
                                <p class="text-black text-[13px] font-bold leading-tight m-0 opacity-80">
                                    Удаление аккаунта сотрет все данные безвозвратно.
                                </p>
                            </div>

                            <!-- Стилизация кнопки удаления внутри partial -->
                            <div class="w-full md:w-auto [&_button]:w-full [&_button]:md:w-auto
                [&_button]:bg-red-50 [&_button]:text-red-600 [&_button]:border-2 [&_button]:border-red-600/20
                [&_button]:font-black [&_button]:uppercase [&_button]:text-[10px] [&_button]:tracking-widest
                [&_button]:px-8 [&_button]:py-3.5 [&_button]:rounded-xl
                [&_button]:transition-all [&_button]:duration-300
                [&_button]:hover:bg-red-600 [&_button]:hover:text-white [&_button]:hover:border-red-600
                [&_button]:hover:shadow-[0_0_20px_rgba(220,38,38,0.4)] [&_button]:active:scale-95">
                                @include('profile.partials.delete-user-form')
                            </div>

                        </div>

                        <!-- Декоративная полоса снизу -->
                        <div class="h-1 w-full bg-gradient-to-r from-transparent via-red-500/20 to-transparent"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Небольшой костыль, чтобы кнопки сохранения всегда выглядели красиво,
        // так как CSS иногда конфликтует с селектором * { color: black }
        document.querySelectorAll('button[type="submit"]').forEach(btn => {
            if(!btn.classList.contains('bg-red-600')) {
                btn.classList.add('btn-save-custom');
            }
        });
    </script>
@endsection
