<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЭДО — Административная панель</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/fontsource-inter@4.0.0/400,500,600,700,800.css" rel="stylesheet">
    <script>
        tailwind.config={theme:{extend:{fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}
    </script>
    <style>
        [x-cloak]{display:none!important}
        .fade{animation:fu .25s ease forwards}
        @keyframes fu{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
        .side-link:hover,.side-link.active{background:rgba(255,255,255,.12);border-left:3px solid #60a5fa}
        input:focus,select:focus{box-shadow:0 0 0 3px rgba(59,130,246,.15)}
        ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}
    </style>
</head>
<body class="bg-slate-100 font-sans text-gray-800 antialiased">
<div id="app" class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-gradient-to-b from-slate-900 via-blue-900 to-blue-800 text-white flex flex-col transition-all duration-300">
        <div class="p-5 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-500 rounded-xl flex items-center justify-center font-extrabold text-lg shadow-lg shadow-blue-500/30">Э</div>
                <div><h1 class="font-extrabold text-base leading-tight">ЭДО Система</h1><p class="text-[10px] text-blue-300/70 uppercase tracking-widest">Администратор</p></div>
            </div>
        </div>
        <nav class="flex-1 py-3 overflow-y-auto">
            <p class="px-5 mb-1.5 text-[9px] uppercase tracking-[0.15em] text-blue-400/60">Главное</p>
            <a href="{{ route('dashboard') }}" id="nav-dashboard" class="side-link active flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>Дашборд</a>
            <a href="{{route('documents.index')}}" id="nav-documents" class="side-link flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>Документы</a>
            <a href="{{route('users.index')}}" id="nav-users" class="side-link flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>Пользователи</a>
            <a href="{{ route('signatures.index') }}" id="nav-signatures" class="side-link flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all"><svg class="w-5 h-5 flex-shrink-0 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg><span class="font-medium">Мои подписи</span>
                @if(isset($signaturesCount) && $signaturesCount > 0)<span class="ml-auto bg-rose-500 text-[9px] font-bold px-2 py-0.5 rounded-full text-white shadow-sm animate-pulse">{{ $signaturesCount }}</span>@endif</a>
            <a href="{{ route('logs.index') }}" id="nav-logs" class="side-link flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all hover:bg-white/5 group"><svg class="w-5 h-5 flex-shrink-0 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span class="font-medium">Логи системы</span></a>
            <a href="{{ route('versions.index') }}"
               id="nav-versions"
               class="side-link flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all hover:bg-white/5 group
   {{ request()->routeIs('versions.*') ? 'bg-white/5 border-indigo-500 text-white' : 'text-indigo-200 hover:text-white' }}">

                <svg class="w-5 h-5 flex-shrink-0 transition-colors
        {{ request()->routeIs('versions.*') ? 'text-white' : 'text-indigo-300 group-hover:text-white' }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>

                <span class="font-medium">Версии документов</span>
            </a>
            <a onclick="showPage('routes')" id="nav-routes" class="side-link flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Маршруты</a>
            <p class="px-5 mb-1.5 mt-4 text-[9px] uppercase tracking-[0.15em] text-blue-400/60">Аналитика</p>
            <a onclick="showPage('analytics')" id="nav-analytics" class="side-link flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>Отчёты</a>
            <a onclick="showPage('settings')" id="nav-settings" class="side-link flex items-center gap-3 px-5 py-2.5 cursor-pointer text-sm border-l-3 border-transparent transition-all"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>Настройки</a>
        </nav>
        <div class="p-4 border-t border-white/10 mt-auto bg-black/20">
            <div class="flex items-center gap-3 group">
                Ссылка теперь ведет на SHOW (просмотр)
                <a href="{{ route('profile.show') }}" class="flex items-center gap-3 flex-1 min-w-0 group/info">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-400 to-indigo-600 flex items-center justify-center text-xs font-black text-white shadow-lg shadow-blue-900/30 transition-all group-hover/info:scale-110 group-hover/info:shadow-blue-500/40">
                            {{ Str::upper(Str::substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-[#1a1c23] rounded-full"></span>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate tracking-tight group-hover/info:text-blue-400 transition-colors">
                            {{ auth()->user()->name ?? 'Администратор' }}
                        </p>
                        <p class="text-[9px] font-medium text-blue-300/60 truncate uppercase tracking-widest flex items-center gap-1">
                            Профиль
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                            </svg>
                        </p>
                    </div>
                </a>

                Кнопка Выхода
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="p-2 text-blue-300/40 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all" title="Выйти">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Topbar -->
        <header class="bg-white/80 backdrop-blur-lg border-b border-gray-200/50 flex items-center justify-between px-6 py-3 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="text-gray-500 hover:text-blue-600 lg:hidden p-1.5 rounded-lg hover:bg-gray-100 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button>
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="globalSeafrch" name="query" placeholder="Поиск документов, пользователей..." class="pl-9 pr-4 py-2 w-72 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all" onkeypress="handleSearch(event)">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-500 hover:text-blue-600 hover:bg-gray-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @php $count = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
                    @if($count > 0)<span id="notifBadge" class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center border-2 border-white animate-pulse">{{ $count > 9 ? '9+' : $count }}</span>@endif
                </a>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-5">
            @yield('content')

            <!-- DOCUMENTS -->

            <!-- USERS -->
            <div id="page-users" class="page hidden fade">
                <h2 class="text-xl font-extrabold mb-5 tracking-tight">Пользователи</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden p-4">
                    <div class="flex justify-between mb-4 gap-3">
                        <input type="text" id="userSearch" oninput="renderUsers()" placeholder="Поиск..." class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm w-64 focus:outline-none">
                        <button onclick="openCreateUser()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition whitespace-nowrap">+ Добавить</button>
                    </div>
                    <div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="text-left py-2.5 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Имя</th>
                                <th class="text-left py-2.5 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Email</th>
                                <th class="text-left py-2.5 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Отдел</th>
                                <th class="text-left py-2.5 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Роль</th>
                                <th class="text-left py-2.5 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Статус</th>
                                <th class="text-right py-2.5 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Действия</th>
                            </tr></thead><tbody id="usersTableBody" class="divide-y divide-gray-50"></tbody></table></div>
                </div>
            </div>

            <!-- ROUTES -->
            <div id="page-routes" class="page hidden fade">
                <h2 class="text-xl font-extrabold mb-5 tracking-tight">Маршруты согласования</h2>
                <div class="grid gap-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-5">
                        <div class="flex justify-between items-center mb-4"><div><h3 class="font-bold text-sm">Стандартный маршрут</h3><p class="text-xs text-gray-500 mt-0.5">Автор → Руководитель → Бухгалтерия</p></div><span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-bold">Активен</span></div>
                        <div class="flex items-center gap-2 text-xs"><span class="bg-blue-600 text-white px-3 py-1 rounded-lg font-medium">Автор</span><svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg><span class="bg-blue-500 text-white px-3 py-1 rounded-lg font-medium">Руководитель</span><svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg><span class="bg-green-500 text-white px-3 py-1 rounded-lg font-medium">Бухгалтерия</span></div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-5">
                        <div class="flex justify-between items-center mb-4"><div><h3 class="font-bold text-sm">Упрощённый маршрут</h3><p class="text-xs text-gray-500 mt-0.5">Автор → Руководитель</p></div><span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-bold">Активен</span></div>
                        <div class="flex items-center gap-2 text-xs"><span class="bg-blue-600 text-white px-3 py-1 rounded-lg font-medium">Автор</span><svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg><span class="bg-blue-500 text-white px-3 py-1 rounded-lg font-medium">Руководитель</span></div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-5 opacity-50">
                        <div class="flex justify-between items-center"><div><h3 class="font-bold text-sm">Архивный маршрут</h3><p class="text-xs text-gray-500 mt-0.5">Автор → Секретарь → Руководитель</p></div><span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-[10px] font-bold">Неактивен</span></div>
                    </div>
                </div>
            </div>

            <!-- ANALYTICS -->
            <div id="page-analytics" class="page hidden fade">
                <h2 class="text-xl font-extrabold mb-5 tracking-tight">Отчёты и аналитика</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-5">
                        <h3 class="font-bold text-sm mb-4">Документы по месяцам</h3>
                        <div id="chartBar" class="flex items-end gap-2 h-44"></div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-5">
                        <h3 class="font-bold text-sm mb-4">По типам документов</h3>
                        <div class="space-y-3">
                            <div><div class="flex justify-between text-xs mb-1"><span>Договоры</span><span class="font-bold">45%</span></div><div class="w-full bg-gray-100 rounded-full h-2.5"><div class="bg-blue-600 h-2.5 rounded-full transition-all" style="width:45%"></div></div></div>
                            <div><div class="flex justify-between text-xs mb-1"><span>Приказы</span><span class="font-bold">25%</span></div><div class="w-full bg-gray-100 rounded-full h-2.5"><div class="bg-blue-400 h-2.5 rounded-full transition-all" style="width:25%"></div></div></div>
                            <div><div class="flex justify-between text-xs mb-1"><span>Служебные записки</span><span class="font-bold">20%</span></div><div class="w-full bg-gray-100 rounded-full h-2.5"><div class="bg-red-500 h-2.5 rounded-full transition-all" style="width:20%"></div></div></div>
                            <div><div class="flex justify-between text-xs mb-1"><span>Счета</span><span class="font-bold">10%</span></div><div class="w-full bg-gray-100 rounded-full h-2.5"><div class="bg-red-400 h-2.5 rounded-full transition-all" style="width:10%"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-5">
                    <h3 class="font-bold text-sm mb-4">Статусы документов</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="text-center p-4 bg-blue-50 rounded-xl"><p class="text-xl font-black text-blue-700">8 210</p><p class="text-[10px] text-gray-500 font-medium mt-0.5">Подписано</p></div>
                        <div class="text-center p-4 bg-yellow-50 rounded-xl"><p class="text-xl font-black text-yellow-700">342</p><p class="text-[10px] text-gray-500 font-medium mt-0.5">На согласовании</p></div>
                        <div class="text-center p-4 bg-red-50 rounded-xl"><p class="text-xl font-black text-red-600">89</p><p class="text-[10px] text-gray-500 font-medium mt-0.5">Отклонено</p></div>
                        <div class="text-center p-4 bg-gray-50 rounded-xl"><p class="text-xl font-black text-gray-600">120</p><p class="text-[10px] text-gray-500 font-medium mt-0.5">Черновики</p></div>
                    </div>
                </div>
            </div>

            <!-- SETTINGS -->
            <div id="page-settings" class="page hidden fade">
                <h2 class="text-xl font-extrabold mb-5 tracking-tight">Настройки системы</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 max-w-xl">
                    <div class="space-y-5">
                        <div><label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Название организации</label><input type="text" value="ООО «ЭДО-Системы»" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none"></div>
                        <div><label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Срок согласования (дней)</label><input type="number" value="5" class="w-24 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none"></div>
                        <div class="flex items-center justify-between py-2"><div><p class="text-sm font-medium">Email-уведомления</p><p class="text-xs text-gray-500">Отправлять уведомления на почту</p></div><label class="relative inline-flex items-center cursor-pointer"><input type="checkbox" checked class="sr-only peer"><div class="w-10 h-5.5 bg-gray-300 peer-checked:bg-blue-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all"></div></label></div>
                        <div class="flex items-center justify-between py-2"><div><p class="text-sm font-medium">Двухфакторная аутентификация</p><p class="text-xs text-gray-500">Требовать 2FA для всех</p></div><label class="relative inline-flex items-center cursor-pointer"><input type="checkbox" class="sr-only peer"><div class="w-10 h-5.5 bg-gray-300 peer-checked:bg-blue-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all"></div></label></div>
                        <button onclick="showToast('Настройки сохранены!')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition">Сохранить</button>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- Modal: Create Doc -->

<!-- Modal: Create User -->
<div id="modalUser" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg fade">
        <div class="flex justify-between items-center p-5 border-b border-gray-100"><h3 class="text-base font-extrabold">Новый пользователь</h3><button onclick="closeModal('modalUser')" class="text-gray-400 hover:text-gray-600 p-1.5 hover:bg-gray-100 rounded-lg transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
        <div class="p-5 space-y-4">
            <input id="newUserName" type="text" placeholder="ФИО" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none">
            <input id="newUserEmail" type="email" placeholder="Email" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none">
            <div class="grid grid-cols-2 gap-3">
                <select id="newUserDept" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none"><option>IT-отдел</option><option>Бухгалтерия</option><option>Юридический</option><option>Управление</option><option>HR</option></select>
                <select id="newUserRole" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none"><option>Пользователь</option><option>Руководитель</option><option>Администратор</option></select>
            </div>
            <div class="flex justify-end gap-2 pt-2"><button onclick="closeModal('modalUser')" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Отмена</button><button onclick="createUser()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition">Создать</button></div>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast" class="hidden fixed bottom-5 right-5 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-xl text-sm z-[60] fade flex items-center gap-3">
    <div class="w-7 h-7 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
    <span id="toastMsg"></span>
</div>

<script>
    const docIdRef=100;
    const docsData=[
        {id:'ДОГ-2026-001',name:'Договор поставки №45',type:'Договор',author:'Петров А.С.',status:'Подписан',date:'2026-04-15'},
        {id:'ПРК-2026-012',name:'Приказ о командировке',type:'Приказ',author:'Сидорова Е.В.',status:'На согласовании',date:'2026-04-18'},
        {id:'СЗ-2026-034',name:'Записка о закупке оборудования',type:'Служебная записка',author:'Козлов Д.М.',status:'Черновик',date:'2026-04-19'},
        {id:'ДГ-2026-002',name:'Договор аренды офиса',type:'Договор',author:'Иванова Л.П.',status:'Подписан',date:'2026-04-10'},
        {id:'СЧ-2026-007',name:'Счёт за электроэнергию',type:'Счёт',author:'Новиков К.А.',status:'Отклонён',date:'2026-04-12'},
        {id:'ПРК-2026-013',name:'Приказ о премировании',type:'Приказ',author:'Админ Иванов',status:'На согласовании',date:'2026-04-20'},
        {id:'ДГ-2026-003',name:'Договор на техобслуживание',type:'Договор',author:'Петров А.С.',status:'На согласовании',date:'2026-04-21'},
        {id:'СЗ-2026-035',name:'Записка о ремонте серверной',type:'Служебная записка',author:'Козлов Д.М.',status:'Черновик',date:'2026-04-21'}
    ];
    const usersData=[
        {name:'Иванов Алексей',email:'admin@edo.ru',dept:'Управление',role:'Администратор',status:'Активен'},
        {name:'Петров Андрей',email:'petrov@edo.ru',dept:'IT-отдел',role:'Пользователь',status:'Активен'},
        {name:'Сидорова Елена',email:'sidorova@edo.ru',dept:'Бухгалтерия',role:'Руководитель',status:'Активен'},
        {name:'Козлов Дмитрий',email:'kozlov@edo.ru',dept:'Юридический',role:'Пользователь',status:'Активен'},
        {name:'Новикова Мария',email:'novikova@edo.ru',dept:'HR',role:'Пользователь',status:'Отключён'},
        {name:'Волков Сергей',email:'volkov@edo.ru',dept:'IT-отдел',role:'Руководитель',status:'Активен'}
    ];
    let docPage=0;const perPage=5;

    function sb(s){const m={'Подписан':'bg-blue-50 text-blue-700','На согласовании':'bg-amber-50 text-amber-700','Отклонён':'bg-red-50 text-red-700','Черновик':'bg-gray-100 text-gray-600','Активен':'bg-green-50 text-green-700','Отключён':'bg-gray-100 text-gray-500'};return `<span class="px-2.5 py-1 rounded-lg text-[10px] font-bold ${m[s]||'bg-gray-100'}">${s}</span>`}

    function showPage(id){document.querySelectorAll('.page').forEach(p=>p.classList.add('hidden'));const pg=document.getElementById('page-'+id);if(pg)pg.classList.remove('hidden');document.querySelectorAll('.side-link').forEach(l=>l.classList.remove('active'));const nv=document.getElementById('nav-'+id);if(nv)nv.classList.add('active');if(id==='analytics')renderChart()}

    function renderDocuments(){const t=document.getElementById('filterType').value,s=document.getElementById('filterStatus').value,q=document.getElementById('docSearch').value.toLowerCase();
        let f=docsData.filter(d=>{if(t&&d.type!==t)return false;if(s&&d.status!==s)return false;if(q&&!d.name.toLowerCase().includes(q)&&!d.id.toLowerCase().includes(q))return false;return true});
        document.getElementById('docsCount').textContent=`Показано: ${f.length}`;const st=docPage*perPage,pi=f.slice(st,st+perPage);const tb=document.getElementById('docsTableBody');
        if(!pi.length){tb.innerHTML='<tr><td colspan="7" class="py-10 text-center text-gray-400 text-sm">Нет документов</td></tr>';return}
        tb.innerHTML=pi.map(d=>`<tr class="hover:bg-gray-50/80 transition">
<td class="py-3 px-4 font-mono text-[11px] text-blue-600 font-medium">${d.id}</td>
<td class="py-3 px-4 font-medium text-sm">${d.name}</td>
<td class="py-3 px-4 text-gray-500 text-xs hidden md:table-cell">${d.type}</td>
<td class="py-3 px-4 text-gray-500 text-xs hidden sm:table-cell">${d.author}</td>
<td class="py-3 px-4">${sb(d.status)}</td>
<td class="py-3 px-4 text-gray-500 text-xs hidden lg:table-cell">${d.date}</td>
<td class="py-3 px-4 text-right space-x-2"><button onclick="showToast('Открыт: ${d.name}')" class="text-blue-600 hover:underline text-xs font-medium">Открыть</button><button onclick="deleteDoc('${d.id}')" class="text-red-500 hover:underline text-xs font-medium">Удалить</button></td></tr>`).join('')}

    function deleteDoc(id){const i=docsData.findIndex(d=>d.id===id);if(i!==-1){docsData.splice(i,1);renderDocuments();showToast('Документ удалён')}}
    function changeDocPage(d){docPage=Math.max(0,docPage+d);renderDocuments()}

    function renderUsers(){const q=document.getElementById('userSearch').value.toLowerCase();const f=usersData.filter(u=>u.name.toLowerCase().includes(q)||u.email.toLowerCase().includes(q));
        document.getElementById('usersTableBody').innerHTML=f.map((u,i)=>`<tr class="hover:bg-gray-50/80 transition">
<td class="py-2.5 px-3 font-medium">${u.name}</td><td class="py-2.5 px-3 text-gray-500 text-xs hidden sm:table-cell">${u.email}</td><td class="py-2.5 px-3 text-gray-500 text-xs hidden md:table-cell">${u.dept}</td><td class="py-2.5 px-3 text-xs">${u.role}</td><td class="py-2.5 px-3">${sb(u.status)}</td><td class="py-2.5 px-3 text-right space-x-2"><button onclick="showToast('Редактирование: ${u.name}')" class="text-blue-600 hover:underline text-xs font-medium">Изменить</button><button onclick="deleteUser(${i})" class="text-red-500 hover:underline text-xs font-medium">Удалить</button></td></tr>`).join('')}

    function deleteUser(i){usersData.splice(i,1);renderUsers();showToast('Пользователь удалён')}
    function openCreateDoc(){document.getElementById('modalDoc').classList.remove('hidden')}
    function openCreateUser(){document.getElementById('modalUser').classList.remove('hidden')}
    function closeModal(id){document.getElementById(id).classList.add('hidden')}

    function createDocument(){const n=document.getElementById('newDocName').value.trim();if(!n){showToast('Введите название!');return}
        docsData.unshift({id:'ДОГ-2026-'+String(docIdRef+docsData.length).padStart(3,'0'),name:n,type:document.getElementById('newDocType').value,author:'Админ Иванов',status:'Черновик',date:new Date().toISOString().slice(0,10)});
        closeModal('modalDoc');document.getElementById('newDocName').value='';document.getElementById('newDocDesc').value='';renderDocuments();showToast('Документ создан')}

    function createUser(){const n=document.getElementById('newUserName').value.trim(),e=document.getElementById('newUserEmail').value.trim();if(!n||!e){showToast('Заполните все поля!');return}
        usersData.push({name:n,email:e,dept:document.getElementById('newUserDept').value,role:document.getElementById('newUserRole').value,status:'Активен'});
        closeModal('modalUser');document.getElementById('newUserName').value='';document.getElementById('newUserEmail').value='';renderUsers();showToast('Пользователь создан')}

    function showToast(msg){const t=document.getElementById('toast');document.getElementById('toastMsg').textContent=msg;t.classList.remove('hidden');setTimeout(()=>t.classList.add('hidden'),2500)}

    function renderChart(){const m=['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],v=[120,95,140,180,160,200,175,210,190,230,195,240],mx=Math.max(...v);
        document.getElementById('chartBar').innerHTML=m.map((n,i)=>`<div class="flex-1 flex flex-col items-center gap-1"><div class="w-full bg-blue-600 rounded-t hover:bg-blue-500 transition cursor-pointer" style="height:${(v[i]/mx)*100}%" title="${n}: ${v[i]}"></div><span class="text-[9px] text-gray-400">${n}</span></div>`).join('')}

    function toggleSidebar(){document.getElementById('sidebar').classList.toggle('-translate-x-full')}

    function handleSearch(event){if(event.key==="Enter"){let q=event.target.value;if(q.trim()!=="")window.location.href="{{ route('search') }}?query="+encodeURIComponent(q)}}

    // Close modals on overlay
    document.querySelectorAll('[id^="modal"]').forEach(m=>{m.addEventListener('click',e=>{if(e.target===m)closeModal(m.id)})})

    // Init
    renderDocuments();renderUsers();renderChart();
</script>
</body>
</html>

