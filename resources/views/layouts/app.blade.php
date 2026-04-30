<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DocManager Admin</title>

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-50 dark:bg-dark-900 text-gray-900 dark:text-gray-100 antialiased transition-colors duration-300">

<div class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-white dark:bg-dark-800 border-r dark:border-gray-700 hidden md:flex flex-col">
        <div class="p-6 flex items-center gap-3 border-b dark:border-gray-700">
            <i class="bi bi-file-earmark-text-fill text-blue-600 text-2xl"></i>
            <span class="font-bold text-lg tracking-tight">DocManager</span>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="#" class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-medium">
                <i class="bi bi-grid-fill"></i> Панель
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                <i class="bi bi-file-earmark-text"></i> Документы
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="h-16 bg-white dark:bg-dark-800 border-b dark:border-gray-700 flex items-center justify-between px-8">
            <div class="text-sm font-medium text-gray-500" data-i18n="pageTitle">Панель управления</div>

            <div class="flex items-center gap-4">
                <button id="theme-toggle" class="w-10 h-10 flex items-center justify-center rounded-full border dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                    <i id="theme-icon" class="bi bi-moon text-gray-600 dark:text-gray-300"></i>
                </button>

                <div class="flex items-center gap-3 border-l dark:border-gray-700 pl-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-gray-500">Administrator</p>
                    </div>
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">AD</div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</div>

<script>
    const btn = document.getElementById('theme-toggle');
    const icon = document.getElementById('theme-icon');
    const html = document.documentElement;

    function updateIcon() {
        if (html.classList.contains('dark')) {
            icon.classList.replace('bi-moon', 'bi-sun');
        } else {
            icon.classList.replace('bi-sun', 'bi-moon');
        }
    }

    updateIcon();

    btn.addEventListener('click', () => {
        html.classList.toggle('dark');
        const isDark = html.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateIcon();
    });
</script>
</body>
</html>
