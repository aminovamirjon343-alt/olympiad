<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocSign — Бесплатная система ЭДО</title>
    <meta name="description" content="DocSign — бесплатная платформа электронного документооборота. Без лимитов. Навсегда.">
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/5968/5968517.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/index.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        ink: {
                            950: '#06070c',
                            900: '#0b0d17',
                            800: '#121523',
                            700: '#1a1e33',
                        },
                        brand: {
                            50: '#eef4ff',
                            100: '#dbe6ff',
                            400: '#7c9cff',
                            500: '#5b7cfa',
                            600: '#4361ee',
                            700: '#3651d4',
                        },
                        accent: {
                            violet: '#8b5cf6',
                            fuchsia: '#d946ef',
                            cyan: '#06b6d4',
                            emerald: '#10b981',
                            rose: '#f43f5e',
                            amber: '#f59e0b',
                        }
                    },
                    animation: {
                        'blob': 'blob 18s ease-in-out infinite',
                        'gradient': 'gradient 8s ease infinite',
                        'fade-up': 'fadeUp 0.7s ease-out forwards',
                        'pulse-soft': 'pulseSoft 2.5s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                            '33%': { transform: 'translate(30px, -40px) scale(1.1)' },
                            '66%': { transform: 'translate(-25px, 20px) scale(0.95)' },
                        },
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        },
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '0.5' },
                            '50%': { opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #06070c;
            color: #e5e7eb;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Градиенты */
        .text-gradient {
            background: linear-gradient(135deg, #5b7cfa 0%, #8b5cf6 50%, #d946ef 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient 6s ease infinite;
        }

        .text-gradient-warm {
            background: linear-gradient(135deg, #f43f5e 0%, #d946ef 50%, #8b5cf6 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient 6s ease infinite;
        }

        .text-gradient-cool {
            background: linear-gradient(135deg, #06b6d4 0%, #5b7cfa 50%, #8b5cf6 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient 6s ease infinite;
        }

        /* Glass */
        .glass {
            background: rgba(18, 21, 35, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .glass-strong {
            background: rgba(11, 13, 23, 0.85);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Hover */
        .card-lift {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-lift:hover {
            transform: translateY(-4px);
            border-color: rgba(91, 124, 250, 0.3);
            box-shadow: 0 20px 40px -15px rgba(91, 124, 250, 0.2);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #4361ee 0%, #8b5cf6 100%);
            color: #fff;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px -5px rgba(67, 97, 238, 0.5);
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .btn-primary:hover::before { left: 100%; }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(139, 92, 246, 0.6);
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(91, 124, 250, 0.4);
            transform: translateY(-2px);
        }

        /* Backgrounds */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
            pointer-events: none;
        }

        .bg-grid {
            background-image:
                linear-gradient(rgba(91, 124, 250, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(91, 124, 250, 0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        }

        /* Scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Nav link */
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0; height: 2px;
            background: linear-gradient(90deg, #5b7cfa, #d946ef);
            transition: width 0.3s ease;
        }
        .nav-link:hover { color: #a5b4fc; }
        .nav-link:hover::after { width: 100%; }

        /* Lang button */
        .lang-btn { transition: all 0.25s ease; }
        .lang-btn.active {
            background: linear-gradient(135deg, #4361ee, #8b5cf6);
            color: #fff;
            font-weight: 600;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #06070c; }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #5b7cfa, #d946ef);
            border-radius: 4px;
        }

        /* Code block */
        .code-block {
            background: rgba(6, 7, 12, 0.8);
            border: 1px solid rgba(91, 124, 250, 0.1);
            font-family: 'JetBrains Mono', 'Courier New', monospace;
        }

        /* Feature icon */
        .feat-icon {
            background: linear-gradient(135deg, rgba(91, 124, 250, 0.1), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(91, 124, 250, 0.2);
        }

        /* FAQ */
        details[open] .faq-icon { transform: rotate(45deg); }
        .faq-icon { transition: transform 0.3s ease; }

        /* ApexCharts */
        .apexcharts-tooltip {
            background: #121523 !important;
            border: 1px solid rgba(91, 124, 250, 0.2) !important;
            color: #fff !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5) !important;
            border-radius: 10px !important;
        }

        .counter { font-variant-numeric: tabular-nums; }

        /* Badge pulse */
        .badge-dot { position: relative; }
        .badge-dot::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: #10b981;
            opacity: 0.5;
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        @keyframes ping {
            75%, 100% { transform: scale(2); opacity: 0; }
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2rem !important; line-height: 1.15 !important; }
        }

        /* Marquee */
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee 30s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>
</head>
<body class="relative">

<!-- ============ NAVBAR ============ -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <a href="#" class="flex items-center gap-2.5 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-brand-600 rounded-lg blur-md opacity-50 group-hover:opacity-80 transition-opacity"></div>
                    <div class="relative w-9 h-9 rounded-lg bg-gradient-to-br from-brand-600 to-accent-violet flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                <span class="text-lg font-bold tracking-tight">
                    Doc<span class="text-gradient">Sign</span>
                </span>
            </a>

            <div class="hidden lg:flex items-center gap-7">
                <a href="#free" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_free">Бесплатно</a>
                <a href="#features" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_features">Возможности</a>
                <a href="#how" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_how">Как работает</a>
                <a href="#analytics" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_analytics">Аналитика</a>
                <a href="#faq" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_faq">FAQ</a>
            </div>

            <div class="flex items-center gap-2.5">
                <div class="hidden sm:flex items-center gap-0.5 glass rounded-full p-0.5">
                    <button class="lang-btn active px-2.5 py-1.5 rounded-full text-xs" data-lang="ru">RU</button>
                    <button class="lang-btn px-2.5 py-1.5 rounded-full text-xs text-slate-400" data-lang="tj">TJ</button>
                    <button class="lang-btn px-2.5 py-1.5 rounded-full text-xs text-slate-400" data-lang="en">EN</button>
                </div>
                <a href="{{route('login')}}" target="_blank" class="btn-primary px-4 py-2 rounded-full text-sm flex items-center gap-1.5">
                    <span data-i18n="nav_start">Начать</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <button id="mobileMenuBtn" class="lg:hidden p-2 text-slate-300 hover:text-brand-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobileMenu" class="hidden lg:hidden glass-strong border-t border-white/5">
        <div class="px-4 py-4 space-y-2">
            <a href="#free" class="block text-sm font-medium text-slate-300 hover:text-brand-500 py-2" data-i18n="nav_free">Бесплатно</a>
            <a href="#features" class="block text-sm font-medium text-slate-300 hover:text-brand-500 py-2" data-i18n="nav_features">Возможности</a>
            <a href="#how" class="block text-sm font-medium text-slate-300 hover:text-brand-500 py-2" data-i18n="nav_how">Как работает</a>
            <a href="#analytics" class="block text-sm font-medium text-slate-300 hover:text-brand-500 py-2" data-i18n="nav_analytics">Аналитика</a>
            <a href="#faq" class="block text-sm font-medium text-slate-300 hover:text-brand-500 py-2" data-i18n="nav_faq">FAQ</a>
            <div class="flex items-center gap-0.5 pt-3 border-t border-white/5">
                <button class="lang-btn active px-2.5 py-1.5 rounded-full text-xs" data-lang="ru">RU</button>
                <button class="lang-btn px-2.5 py-1.5 rounded-full text-xs text-slate-400" data-lang="tj">TJ</button>
                <button class="lang-btn px-2.5 py-1.5 rounded-full text-xs text-slate-400" data-lang="en">EN</button>
            </div>
        </div>
    </div>
</nav>

<!-- ============ HERO ============ -->
<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden pt-24 pb-16">
    <div class="orb w-[450px] h-[450px] bg-brand-600 top-10 -left-20 animate-blob"></div>
    <div class="orb w-[400px] h-[400px] bg-accent-violet top-1/3 -right-20 animate-blob" style="animation-delay: -7s"></div>
    <div class="orb w-[300px] h-[300px] bg-accent-cyan bottom-20 left-1/3 animate-blob" style="animation-delay: -14s"></div>

    <div class="absolute inset-0 bg-grid"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-ink-950/40 to-ink-950"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2.5 glass rounded-full px-4 py-2 mb-7 animate-fade-up">
            <span class="badge-dot relative w-2 h-2 bg-accent-emerald rounded-full"></span>
            <span class="text-xs font-semibold text-slate-300 tracking-wide" data-i18n="hero_badge">100% БЕСПЛАТНО · БЕЗ ЛИМИТОВ · НАВСЕГДА</span>
        </div>

        <h1 class="hero-title text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight mb-5 leading-[1.1]">
            <span class="block text-white" data-i18n="hero_title_1">Подписывай документы</span>
            <span class="block text-gradient" data-i18n="hero_title_2">без границ и платежей</span>
        </h1>

        <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-400 mb-9 leading-relaxed" style="animation: fadeUp 0.8s ease-out 0.3s forwards; opacity: 0;" data-i18n="hero_subtitle">
            DocSign — первая полностью бесплатная платформа электронного документооборота в Таджикистане. Без подписок, без лимитов, без скрытых платежей.
        </p>



        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-4xl mx-auto" style="animation: fadeUp 0.8s ease-out 0.7s forwards; opacity: 0;">
            <div class="glass rounded-xl p-4 card-lift">
                <div class="text-2xl md:text-3xl font-bold text-gradient">0$</div>
                <div class="text-[10px] uppercase tracking-wider text-brand-400 font-semibold mt-1" data-i18n="stat_price">Стоимость</div>
                <div class="text-xs text-slate-500 mt-0.5" data-i18n="stat_price_desc">навсегда</div>
            </div>
            <div class="glass rounded-xl p-4 card-lift">
                <div class="text-2xl md:text-3xl font-bold text-white">∞</div>
                <div class="text-[10px] uppercase tracking-wider text-accent-cyan font-semibold mt-1" data-i18n="stat_docs">Документы</div>
                <div class="text-xs text-slate-500 mt-0.5" data-i18n="stat_docs_desc">безлимит</div>
            </div>
            <div class="glass rounded-xl p-4 card-lift">
                <div class="text-2xl md:text-3xl font-bold text-white"><span class="counter" data-target="60">0</span><span class="text-accent-violet text-lg">с</span></div>
                <div class="text-[10px] uppercase tracking-wider text-accent-violet font-semibold mt-1" data-i18n="stat_speed">Скорость</div>
                <div class="text-xs text-slate-500 mt-0.5" data-i18n="stat_speed_desc">подпись</div>
            </div>
            <div class="glass rounded-xl p-4 card-lift">
                <div class="text-2xl md:text-3xl font-bold text-white">24/7</div>
                <div class="text-[10px] uppercase tracking-wider text-accent-emerald font-semibold mt-1" data-i18n="stat_access">Доступ</div>
                <div class="text-xs text-slate-500 mt-0.5" data-i18n="stat_access_desc">везде</div>
            </div>
        </div>
    </div>
</section>

<!-- ============ MARQUEE ============ -->
<section class="relative py-6 border-y border-white/5 overflow-hidden bg-gradient-to-r from-ink-950 via-ink-900 to-ink-950">
    <div class="marquee-track">
        <div class="flex items-center gap-10 px-5 text-xl md:text-2xl font-bold whitespace-nowrap">
            <span class="text-white">БЕСПЛАТНО</span>
            <span class="text-brand-500">★</span>
            <span class="text-white">БЕЗ ЛИМИТОВ</span>
            <span class="text-accent-violet">★</span>
            <span class="text-white">БЕЗ ПОДПИСОК</span>
            <span class="text-accent-fuchsia">★</span>
            <span class="text-white">НАВСЕГДА</span>
            <span class="text-accent-cyan">★</span>
            <span class="text-white">FREE FOREVER</span>
            <span class="text-brand-500">★</span>
        </div>
        <div class="flex items-center gap-10 px-5 text-xl md:text-2xl font-bold whitespace-nowrap" aria-hidden="true">
            <span class="text-white">БЕСПЛАТНО</span>
            <span class="text-brand-500">★</span>
            <span class="text-white">БЕЗ ЛИМИТОВ</span>
            <span class="text-accent-violet">★</span>
            <span class="text-white">БЕЗ ПОДПИСОК</span>
            <span class="text-accent-fuchsia">★</span>
            <span class="text-white">НАВСЕГДА</span>
            <span class="text-accent-cyan">★</span>
            <span class="text-white">FREE FOREVER</span>
            <span class="text-brand-500">★</span>
        </div>
    </div>
</section>

<!-- ============ FREE SECTION ============ -->
<section id="free" class="relative py-20 overflow-hidden">
    <div class="orb w-[350px] h-[350px] bg-brand-600 top-0 right-0 opacity-15"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-brand-400 uppercase tracking-wider mb-3">
                <span class="w-6 h-px bg-brand-500"></span>
                <span data-i18n="free_label">Наше обещание</span>
                <span class="w-6 h-px bg-brand-500"></span>
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                <span data-i18n="free_title_1">Почему </span>
                <span class="text-gradient" data-i18n="free_title_2">это бесплатно?</span>
            </h2>
            <p class="max-w-xl mx-auto text-slate-400" data-i18n="free_subtitle">Мы верим, что цифровой документооборот должен быть доступен каждому.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            <div class="reveal glass rounded-2xl p-6 card-lift">
                <div class="feat-icon w-11 h-11 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2" data-i18n="free_1_title">0 сомони. Навсегда.</h3>
                <p class="text-slate-400 text-sm leading-relaxed" data-i18n="free_1_desc">Никаких ежемесячных платежей, никаких скрытых комиссий. Все функции доступны бесплатно с первого дня.</p>
            </div>

            <div class="reveal glass rounded-2xl p-6 card-lift" style="transition-delay: 0.1s">
                <div class="feat-icon w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(217, 70, 239, 0.1)); border-color: rgba(139, 92, 246, 0.2);">
                    <svg class="w-5 h-5 text-accent-violet" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2" data-i18n="free_2_title">Безлимитные подписи</h3>
                <p class="text-slate-400 text-sm leading-relaxed" data-i18n="free_2_desc">Подписывай хоть 1 документ в день, хоть 10 000. Никаких ограничений на количество, пользователей или хранилище.</p>
            </div>

            <div class="reveal glass rounded-2xl p-6 card-lift" style="transition-delay: 0.2s">
                <div class="feat-icon w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(16, 185, 129, 0.1)); border-color: rgba(6, 182, 212, 0.2);">
                    <svg class="w-5 h-5 text-accent-cyan" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2" data-i18n="free_3_title">Сделано для людей</h3>
                <p class="text-slate-400 text-sm leading-relaxed" data-i18n="free_3_desc">Мы создали DocSign как общественный сервис для Таджикистана. Наша цель — цифровизация, а не прибыль.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ FEATURES ============ -->
<section id="features" class="relative py-20 overflow-hidden">
    <div class="orb w-[400px] h-[400px] bg-accent-violet top-1/3 -left-20 opacity-15"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-accent-fuchsia uppercase tracking-wider mb-3">
                <span class="w-6 h-px bg-accent-fuchsia"></span>
                <span data-i18n="feat_label">Возможности</span>
                <span class="w-6 h-px bg-accent-fuchsia"></span>
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                <span data-i18n="feat_title_1">Всё что нужно. </span>
                <span class="text-gradient" data-i18n="feat_title_2">И даже больше.</span>
            </h2>
            <p class="max-w-xl mx-auto text-slate-400" data-i18n="feat_subtitle">Мощные инструменты для работы с документами — все бесплатны, все без лимитов.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="reveal glass rounded-2xl p-5 card-lift group">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f1_title">Юридическая подпись</h3>
                <p class="text-slate-400 text-xs leading-relaxed" data-i18n="f1_desc">Электронная подпись с полной юридической силой. Уникальный QR-код для мгновенной проверки.</p>
            </div>

            <div class="reveal glass rounded-2xl p-5 card-lift group" style="transition-delay: 0.05s">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(217, 70, 239, 0.1)); border-color: rgba(139, 92, 246, 0.2);">
                    <svg class="w-5 h-5 text-accent-violet" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f2_title">Командная работа</h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-2" data-i18n="f2_desc">Приглашайте коллег, распределяйте роли и управляйте доступами.</p>
                <div class="flex flex-wrap gap-1">
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-accent-rose/10 text-accent-rose border border-accent-rose/20">Admin</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-accent-violet/10 text-accent-violet border border-accent-violet/20">Director</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-accent-cyan/10 text-accent-cyan border border-accent-cyan/20">Employee</span>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-5 card-lift group" style="transition-delay: 0.1s">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, rgba(244, 63, 94, 0.1), rgba(217, 70, 239, 0.1)); border-color: rgba(244, 63, 94, 0.2);">
                    <svg class="w-5 h-5 text-accent-rose" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f3_title">AI-аналитика</h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-2" data-i18n="f3_desc">Умные алгоритмы анализируют документы и находят ошибки.</p>
                <div class="h-1 bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-accent-rose to-accent-fuchsia rounded-full" style="width: 94%"></div>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-5 card-lift group">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(6, 182, 212, 0.1)); border-color: rgba(16, 185, 129, 0.2);">
                    <svg class="w-5 h-5 text-accent-emerald" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f4_title">Облачное хранилище</h3>
                <p class="text-slate-400 text-xs leading-relaxed" data-i18n="f4_desc">Безлимитное облачное хранилище для всех ваших документов. Доступ из любой точки мира.</p>
            </div>

            <div class="reveal glass rounded-2xl p-5 card-lift group" style="transition-delay: 0.05s">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(244, 63, 94, 0.1)); border-color: rgba(245, 158, 11, 0.2);">
                    <svg class="w-5 h-5 text-accent-amber" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f5_title">Умные уведомления</h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-2" data-i18n="f5_desc">Мгновенные оповещения о статусе документов.</p>
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span>📧</span><span>💬</span><span>📱</span>
                    <span class="ml-1" data-i18n="f5_channels">3 канала</span>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-5 card-lift group" style="transition-delay: 0.1s">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f6_title">API для разработчиков</h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-2" data-i18n="f6_desc">Полноценный REST API для интеграции с вашими системами.</p>
                <div class="code-block rounded-md px-2 py-1 text-[10px]">
                    <span class="text-accent-violet">POST</span> <span class="text-slate-400">/api/v1/sign</span>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-5 card-lift group">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(244, 63, 94, 0.1)); border-color: rgba(139, 92, 246, 0.2);">
                    <svg class="w-5 h-5 text-accent-violet" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f7_title">Все форматы</h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-2" data-i18n="f7_desc">Поддержка PDF, DOCX, XLSX и других форматов.</p>
                <div class="flex gap-1">
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-accent-rose/10 text-accent-rose border border-accent-rose/20">PDF</span>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-brand-600/10 text-brand-400 border border-brand-600/20">DOCX</span>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-accent-emerald/10 text-accent-emerald border border-accent-emerald/20">XLSX</span>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-5 card-lift group" style="transition-delay: 0.05s">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(91, 124, 250, 0.1)); border-color: rgba(6, 182, 212, 0.2);">
                    <svg class="w-5 h-5 text-accent-cyan" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f8_title">3 языка</h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-2" data-i18n="f8_desc">Полная поддержка русского, таджикского и английского.</p>
                <div class="flex gap-1">
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-white/5 text-white border border-white/10">🇷🇺 RU</span>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-white/5 text-white border border-white/10">🇹🇯 TJ</span>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-white/5 text-white border border-white/10">🇬🇧 EN</span>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-5 card-lift group" style="transition-delay: 0.1s">
                <div class="feat-icon w-10 h-10 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, rgba(244, 63, 94, 0.1), rgba(139, 92, 246, 0.1)); border-color: rgba(244, 63, 94, 0.2);">
                    <svg class="w-5 h-5 text-accent-rose" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-base font-bold text-white mb-1.5" data-i18n="f9_title">Максимальная защита</h3>
                <p class="text-slate-400 text-xs leading-relaxed" data-i18n="f9_desc">256-битное шифрование, CSRF/XSS защита, audit logs и резервное копирование.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ HOW IT WORKS ============ -->
<section id="how" class="relative py-20 overflow-hidden">
    <div class="orb w-[350px] h-[350px] bg-accent-cyan bottom-0 right-0 opacity-15"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-accent-cyan uppercase tracking-wider mb-3">
                <span class="w-6 h-px bg-accent-cyan"></span>
                <span data-i18n="how_label">Процесс</span>
                <span class="w-6 h-px bg-accent-cyan"></span>
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                <span data-i18n="how_title_1">Три простых </span>
                <span class="text-gradient-warm" data-i18n="how_title_2">шага</span>
            </h2>
            <p class="max-w-xl mx-auto text-slate-400" data-i18n="how_subtitle">От регистрации до подписанного документа — всего 60 секунд</p>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            <div class="reveal glass rounded-2xl p-6 card-lift relative">
                <div class="absolute -top-3 left-5 w-8 h-8 rounded-full bg-gradient-to-br from-brand-600 to-accent-cyan flex items-center justify-center font-bold text-white text-sm shadow-lg">1</div>
                <div class="mt-3">
                    <div class="text-3xl mb-3">📝</div>
                    <h3 class="text-base font-bold text-white mb-2" data-i18n="step1_title">Загрузите документ</h3>
                    <p class="text-slate-400 text-xs leading-relaxed" data-i18n="step1_desc">Перетащите файл или выберите из облака. Поддержка PDF, DOCX, XLSX.</p>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-6 card-lift relative" style="transition-delay: 0.1s">
                <div class="absolute -top-3 left-5 w-8 h-8 rounded-full bg-gradient-to-br from-accent-violet to-accent-fuchsia flex items-center justify-center font-bold text-white text-sm shadow-lg">2</div>
                <div class="mt-3">
                    <div class="text-3xl mb-3">✍️</div>
                    <h3 class="text-base font-bold text-white mb-2" data-i18n="step2_title">Подпишите</h3>
                    <p class="text-slate-400 text-xs leading-relaxed" data-i18n="step2_desc">Поставьте электронную подпись в один клик. AI проверит документ автоматически.</p>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-6 card-lift relative" style="transition-delay: 0.2s">
                <div class="absolute -top-3 left-5 w-8 h-8 rounded-full bg-gradient-to-br from-accent-rose to-accent-fuchsia flex items-center justify-center font-bold text-white text-sm shadow-lg">3</div>
                <div class="mt-3">
                    <div class="text-3xl mb-3">🚀</div>
                    <h3 class="text-base font-bold text-white mb-2" data-i18n="step3_title">Отправьте</h3>
                    <p class="text-slate-400 text-xs leading-relaxed" data-i18n="step3_desc">Поделитесь подписанным документом через email, Telegram или ссылку.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ TECHNOLOGY ============ -->
<section id="tech" class="relative py-20 overflow-hidden">
    <div class="orb w-[350px] h-[350px] bg-accent-violet top-1/4 -left-20 opacity-15"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-accent-violet uppercase tracking-wider mb-3">
                <span class="w-6 h-px bg-accent-violet"></span>
                <span data-i18n="tech_label">Технологии</span>
                <span class="w-6 h-px bg-accent-violet"></span>
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                <span data-i18n="tech_title_1">Построено на </span>
                <span class="text-gradient" data-i18n="tech_title_2">лучшем стеке</span>
            </h2>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 items-center">
            <div class="reveal">
                <div class="code-block rounded-2xl overflow-hidden">
                    <div class="flex items-center gap-1.5 px-4 py-2.5 bg-white/5 border-b border-white/5">
                        <div class="w-2.5 h-2.5 rounded-full bg-accent-rose"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-accent-amber"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-accent-emerald"></div>
                        <span class="ml-2 text-[10px] text-slate-500 font-mono">docsign.config.js</span>
                    </div>
                    <div class="p-5 font-mono text-xs space-y-1.5 overflow-x-auto">
                        <div class="text-slate-500">// 🚀 Tech Stack</div>
                        <div><span class="text-accent-violet">export default</span> <span class="text-slate-400">{</span></div>
                        <div class="pl-3"><span class="text-accent-cyan">framework</span><span class="text-slate-500">:</span> <span class="text-accent-emerald">'Laravel 13'</span><span class="text-slate-500">,</span></div>
                        <div class="pl-3"><span class="text-accent-cyan">database</span><span class="text-slate-500">:</span> <span class="text-accent-emerald">'MySQL 8.4'</span><span class="text-slate-500">,</span></div>
                        <div class="pl-3"><span class="text-accent-cyan">frontend</span><span class="text-slate-500">:</span> <span class="text-accent-emerald">'TailwindCSS'</span><span class="text-slate-500">,</span></div>
                        <div class="pl-3"><span class="text-accent-cyan">pdf_engine</span><span class="text-slate-500">:</span> <span class="text-accent-emerald">'FPDI / TCPDF'</span><span class="text-slate-500">,</span></div>
                        <div class="pl-3"><span class="text-accent-cyan">ai_module</span><span class="text-slate-500">:</span> <span class="text-accent-emerald">'Smart Analysis'</span><span class="text-slate-500">,</span></div>
                        <div class="pl-3"><span class="text-accent-cyan">region</span><span class="text-slate-500">:</span> <span class="text-accent-emerald">'🇹🇯 Tajikistan'</span><span class="text-slate-500">,</span></div>
                        <div class="pl-3"><span class="text-accent-cyan">price</span><span class="text-slate-500">:</span> <span class="text-accent-rose">'FREE FOREVER'</span><span class="text-slate-500">,</span></div>
                        <div class="pl-3"><span class="text-accent-cyan">languages</span><span class="text-slate-500">:</span> <span class="text-slate-400">[</span><span class="text-accent-emerald">'RU'</span><span class="text-slate-500">,</span> <span class="text-accent-emerald">'TJ'</span><span class="text-slate-500">,</span> <span class="text-accent-emerald">'EN'</span><span class="text-slate-400">]</span></div>
                        <div><span class="text-slate-400">}</span></div>
                        <div class="pt-2 text-accent-emerald">✓ <span data-i18n="tech_status">Все системы работают</span></div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="reveal glass rounded-xl p-4 card-lift flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent-violet/20 to-accent-fuchsia/20 border border-accent-violet/30 flex items-center justify-center flex-shrink-0 text-xl">🐘</div>
                    <div>
                        <h4 class="text-sm font-bold text-white mb-0.5">Laravel 13</h4>
                        <p class="text-xs text-slate-400" data-i18n="tech_laravel">Последняя версия PHP-фреймворка. Скорость, безопасность.</p>
                    </div>
                </div>

                <div class="reveal glass rounded-xl p-4 card-lift flex items-start gap-3" style="transition-delay: 0.05s">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent-cyan/20 to-brand-600/20 border border-accent-cyan/30 flex items-center justify-center flex-shrink-0 text-xl">🗄️</div>
                    <div>
                        <h4 class="text-sm font-bold text-white mb-0.5">MySQL 8.4</h4>
                        <p class="text-xs text-slate-400" data-i18n="tech_mysql">Надёжная СУБД с оптимизированными запросами.</p>
                    </div>
                </div>

                <div class="reveal glass rounded-xl p-4 card-lift flex items-start gap-3" style="transition-delay: 0.1s">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-brand-600/20 to-accent-cyan/20 border border-brand-600/30 flex items-center justify-center flex-shrink-0 text-xl">🎨</div>
                    <div>
                        <h4 class="text-sm font-bold text-white mb-0.5">TailwindCSS</h4>
                        <p class="text-xs text-slate-400" data-i18n="tech_ui">Современный utility-first CSS фреймворк.</p>
                    </div>
                </div>

                <div class="reveal glass rounded-xl p-4 card-lift flex items-start gap-3" style="transition-delay: 0.15s">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent-rose/20 to-accent-fuchsia/20 border border-accent-rose/30 flex items-center justify-center flex-shrink-0 text-xl">🤖</div>
                    <div>
                        <h4 class="text-sm font-bold text-white mb-0.5" data-i18n="tech_ai_title">AI Engine</h4>
                        <p class="text-xs text-slate-400" data-i18n="tech_ai_desc">Интеллектуальный анализ документов и автоматическая проверка.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ ANALYTICS ============ -->
<section id="analytics" class="relative py-20 overflow-hidden">
    <div class="orb w-[400px] h-[400px] bg-accent-rose top-0 right-0 opacity-15"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-accent-amber uppercase tracking-wider mb-3">
                <span class="w-6 h-px bg-accent-amber"></span>
                <span data-i18n="analytics_label">Аналитика</span>
                <span class="w-6 h-px bg-accent-amber"></span>
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                <span data-i18n="analytics_title_1">Живые </span>
                <span class="text-gradient-warm" data-i18n="analytics_title_2">данные</span>
            </h2>
            <p class="max-w-xl mx-auto text-slate-400" data-i18n="analytics_subtitle">Отслеживайте активность платформы в реальном времени</p>
        </div>

        <!-- Stats cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
            <div class="reveal glass rounded-xl p-4 card-lift">
                <div class="text-[10px] uppercase tracking-wider text-brand-400 font-semibold mb-1" data-i18n="an_users">Пользователи</div>
                <div class="text-2xl font-bold text-white"><span class="counter" data-target="53">0</span></div>
                <div class="text-[10px] text-slate-500 mt-0.5" data-i18n="an_active">активных</div>
            </div>
            <div class="reveal glass rounded-xl p-4 card-lift" style="transition-delay: 0.05s">
                <div class="text-[10px] uppercase tracking-wider text-accent-cyan font-semibold mb-1" data-i18n="an_new">Новые (30д)</div>
                <div class="text-2xl font-bold text-accent-cyan"><span class="counter" data-target="53">0</span></div>
                <div class="flex items-center gap-0.5 mt-0.5 text-[10px] text-accent-emerald">
                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"/></svg>
                    <span>+100%</span>
                </div>
            </div>
            <div class="reveal glass rounded-xl p-4 card-lift" style="transition-delay: 0.1s">
                <div class="text-[10px] uppercase tracking-wider text-accent-fuchsia font-semibold mb-1" data-i18n="an_docs">Документы</div>
                <div class="text-2xl font-bold text-white"><span class="counter" data-target="1247">0</span></div>
                <div class="text-[10px] text-slate-500 mt-0.5" data-i18n="an_signed">подписано</div>
            </div>
            <div class="reveal glass rounded-xl p-4 card-lift" style="transition-delay: 0.15s">
                <div class="text-[10px] uppercase tracking-wider text-accent-emerald font-semibold mb-1" data-i18n="an_uptime">Uptime</div>
                <div class="text-2xl font-bold text-accent-emerald">99.9<span class="text-base">%</span></div>
                <div class="text-[10px] text-slate-500 mt-0.5" data-i18n="an_stable">стабильно</div>
            </div>
        </div>

        <!-- Chart -->
        <div class="reveal glass rounded-2xl p-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">
                <div>
                    <div class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold mb-0.5" data-i18n="an_activity">Активность базы</div>
                    <h3 class="text-base font-bold text-white" data-i18n="an_growth">Динамика роста аудитории</h3>
                </div>
                <div class="flex gap-3">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                        <span class="text-xs text-slate-400" data-i18n="an_reg">Регистрации</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-accent-rose"></span>
                        <span class="text-xs text-slate-400" data-i18n="an_del">Удаления</span>
                    </div>
                </div>
            </div>
            <div id="userChart" style="min-height: 300px;"></div>
        </div>

        <!-- Data source -->
        <div class="mt-4 flex items-center justify-center gap-2 text-xs text-slate-500">
            <span class="w-1.5 h-1.5 bg-accent-emerald rounded-full animate-pulse"></span>
            <span data-i18n="data_source">Данные обновляются в реальном времени из базы DocSign</span>
        </div>
    </div>
</section>

<!-- ============ TESTIMONIALS ============ -->
<section id="reviews" class="relative py-20 overflow-hidden">
    <div class="orb w-[400px] h-[400px] bg-accent-violet bottom-0 left-0 opacity-15"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-accent-violet uppercase tracking-wider mb-3">
                <span class="w-6 h-px bg-accent-violet"></span>
                <span data-i18n="rev_label">Отзывы</span>
                <span class="w-6 h-px bg-accent-violet"></span>
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                <span data-i18n="rev_title_1">Нам </span>
                <span class="text-gradient" data-i18n="rev_title_2">доверяют</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            <div class="reveal glass rounded-2xl p-6 card-lift">
                <div class="flex text-accent-amber text-base mb-3">★★★★★</div>
                <p class="text-slate-300 text-sm leading-relaxed mb-4" data-i18n="rev1_text">"Наконец-то сервис, который не просит деньги за каждую подпись. Пользуемся всей компанией — 50 человек, и всё бесплатно!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-600 to-accent-cyan flex items-center justify-center font-bold text-white text-sm">А</div>
                    <div>
                        <div class="text-sm font-bold text-white">Алишер Р.</div>
                        <div class="text-xs text-slate-500" data-i18n="rev1_role">Директор, Душанбе</div>
                    </div>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-6 card-lift" style="transition-delay: 0.1s">
                <div class="flex text-accent-amber text-base mb-3">★★★★★</div>
                <p class="text-slate-300 text-sm leading-relaxed mb-4" data-i18n="rev2_text">"Очень удобный интерфейс, три языка — это круто. Подписываю документы за минуту. Рекомендую всем коллегам."</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-accent-violet to-accent-fuchsia flex items-center justify-center font-bold text-white text-sm">М</div>
                    <div>
                        <div class="text-sm font-bold text-white">Мадина К.</div>
                        <div class="text-xs text-slate-500" data-i18n="rev2_role">Бухгалтер, Худжанд</div>
                    </div>
                </div>
            </div>

            <div class="reveal glass rounded-2xl p-6 card-lift" style="transition-delay: 0.2s">
                <div class="flex text-accent-amber text-base mb-3">★★★★★</div>
                <p class="text-slate-300 text-sm leading-relaxed mb-4" data-i18n="rev3_text">"API работает отлично, интегрировали с нашей CRM за один день. AI-аналитика реально помогает находить ошибки в договорах."</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-accent-rose to-accent-amber flex items-center justify-center font-bold text-white text-sm">Ф</div>
                    <div>
                        <div class="text-sm font-bold text-white">Фарход Т.</div>
                        <div class="text-xs text-slate-500" data-i18n="rev3_role">CTO, IT-компания</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ FAQ ============ -->
<section id="faq" class="relative py-20 overflow-hidden">
    <div class="orb w-[350px] h-[350px] bg-brand-600 top-1/3 right-0 opacity-10"></div>

    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-brand-400 uppercase tracking-wider mb-3">
                <span class="w-6 h-px bg-brand-500"></span>
                <span data-i18n="faq_label">FAQ</span>
                <span class="w-6 h-px bg-brand-500"></span>
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4" data-i18n="faq_title">Частые вопросы</h2>
        </div>

        <div class="space-y-2">
            <details class="reveal glass rounded-xl p-4 group cursor-pointer">
                <summary class="flex items-center justify-between gap-3 list-none">
                    <h3 class="text-sm font-bold text-white" data-i18n="faq1_q">Это действительно бесплатно?</h3>
                    <span class="faq-icon w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-brand-500 flex-shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </span>
                </summary>
                <p class="text-slate-400 text-xs leading-relaxed mt-3" data-i18n="faq1_a">Да, на 100%. DocSign — общественный сервис для Таджикистана. Нет премиум-тарифов, нет скрытых платежей. Все функции бесплатны навсегда.</p>
            </details>

            <details class="reveal glass rounded-xl p-4 group cursor-pointer" style="transition-delay: 0.05s">
                <summary class="flex items-center justify-between gap-3 list-none">
                    <h3 class="text-sm font-bold text-white" data-i18n="faq2_q">Есть ли лимит на количество документов?</h3>
                    <span class="faq-icon w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-brand-500 flex-shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </span>
                </summary>
                <p class="text-slate-400 text-xs leading-relaxed mt-3" data-i18n="faq2_a">Никаких лимитов. Подписывайте столько документов, сколько нужно. Хранилище тоже безлимитное.</p>
            </details>

            <details class="reveal glass rounded-xl p-4 group cursor-pointer" style="transition-delay: 0.1s">
                <summary class="flex items-center justify-between gap-3 list-none">
                    <h3 class="text-sm font-bold text-white" data-i18n="faq3_q">Имеет ли электронная подпись юридическую силу?</h3>
                    <span class="faq-icon w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-brand-500 flex-shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </span>
                </summary>
                <p class="text-slate-400 text-xs leading-relaxed mt-3" data-i18n="faq3_a">Да, полностью. DocSign соответствует законодательству РТ об электронном документообороте. Каждый документ имеет уникальный QR-код.</p>
            </details>

            <details class="reveal glass rounded-xl p-4 group cursor-pointer" style="transition-delay: 0.15s">
                <summary class="flex items-center justify-between gap-3 list-none">
                    <h3 class="text-sm font-bold text-white" data-i18n="faq4_q">Безопасны ли мои данные?</h3>
                    <span class="faq-icon w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-brand-500 flex-shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </span>
                </summary>
                <p class="text-slate-400 text-xs leading-relaxed mt-3" data-i18n="faq4_a">Абсолютно. 256-битное шифрование, защита от CSRF/XSS/SQL-инъекций, регулярные бэкапы и audit logs.</p>
            </details>

            <details class="reveal glass rounded-xl p-4 group cursor-pointer" style="transition-delay: 0.2s">
                <summary class="flex items-center justify-between gap-3 list-none">
                    <h3 class="text-sm font-bold text-white" data-i18n="faq5_q">Можно ли интегрировать с другими системами?</h3>
                    <span class="faq-icon w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-brand-500 flex-shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </span>
                </summary>
                <p class="text-slate-400 text-xs leading-relaxed mt-3" data-i18n="faq5_a">Да, у нас есть полноценный REST API с документацией. Вы можете интегрировать DocSign с CRM, ERP и любыми другими системами. Также бесплатно.</p>
            </details>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section id="start" class="relative py-20 overflow-hidden">
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal relative rounded-3xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-600 via-accent-violet to-accent-fuchsia"></div>
            <div class="absolute inset-0 bg-grid opacity-20" style="mask-image: none; -webkit-mask-image: none;"></div>
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-accent-cyan/20 rounded-full blur-3xl"></div>

            <div class="relative p-8 md:p-12 text-center">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-3 py-1 mb-5">
                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-bold text-white uppercase tracking-wider" data-i18n="cta_badge">БЕСПЛАТНО НАВСЕГДА</span>
                </div>

                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
                    <span data-i18n="cta_title">Начните прямо сейчас</span>
                </h2>
                <p class="text-base text-white/80 mb-8 max-w-xl mx-auto" data-i18n="cta_subtitle">Присоединяйтесь к тысячам пользователей, которые уже подписывают документы бесплатно</p>

                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="https://t.me/share/url?url=https://docsign.tj&text=DocSign%20—%20бесплатная%20система%20ЭДО" target="_blank" class="px-5 py-3 rounded-xl bg-white text-brand-600 font-bold text-sm flex items-center gap-2 hover:scale-105 transition-transform shadow-xl">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0C5.346 0 0 5.346 0 11.944c0 6.597 5.346 11.944 11.944 11.944 6.598 0 11.944-5.347 11.944-11.944C23.888 5.346 18.542 0 11.944 0zM18.17 6.83l-2.113 9.968c-.15.66-.543.824-1.096.515l-3.218-2.373-1.553 1.493c-.17.172-.315.315-.646.315l.23-3.267 5.946-5.372c.258-.23-.056-.358-.401-.13l-7.35 4.628-3.166-1c-.687-.215-.702-.687.143-.1l12.355-4.76c.572-.215 1.07.127.91.892z"/></svg>
                        <span data-i18n="cta_tg">Поделиться в Telegram</span>
                    </a>
                    <a href="https://api.whatsapp.com/send?text=DocSign%20—%20бесплатная%20система%20ЭДО%20https://docsign.tj" target="_blank" class="px-5 py-3 rounded-xl bg-white/10 backdrop-blur text-white font-bold text-sm flex items-center gap-2 hover:bg-white/20 transition-all border border-white/20">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="relative border-t border-white/5 mt-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid md:grid-cols-4 gap-6 mb-6">
            <div class="md:col-span-2">
                <a href="#" class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-600 to-accent-violet flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span class="text-base font-bold text-white">Doc<span class="text-gradient">Sign</span></span>
                </a>
                <p class="text-xs text-slate-400 max-w-sm mb-3" data-i18n="footer_desc">Первая полностью бесплатная платформа электронного документооборота в Таджикистане.</p>
                <div class="flex items-center gap-2">
                    <a href="https://t.me/docsign" target="_blank" class="w-8 h-8 rounded-lg glass flex items-center justify-center text-slate-400 hover:text-brand-500 hover:border-brand-500/30 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0C5.346 0 0 5.346 0 11.944c0 6.597 5.346 11.944 11.944 11.944 6.598 0 11.944-5.347 11.944-11.944C23.888 5.346 18.542 0 11.944 0zM18.17 6.83l-2.113 9.968c-.15.66-.543.824-1.096.515l-3.218-2.373-1.553 1.493c-.17.172-.315.315-.646.315l.23-3.267 5.946-5.372c.258-.23-.056-.358-.401-.13l-7.35 4.628-3.166-1c-.687-.215-.702-.687.143-.1l12.355-4.76c.572-.215 1.07.127.91.892z"/></svg>
                    </a>
                    <a href="https://instagram.com/docsign" target="_blank" class="w-8 h-8 rounded-lg glass flex items-center justify-center text-slate-400 hover:text-accent-fuchsia hover:border-accent-fuchsia/30 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.805.249 2.227.412.558.217.957.477 1.377.896.42.419.68.818.896 1.377.163.422.358 1.057.412 2.227.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.249 1.805-.412 2.227-.217.558-.477.957-.896 1.377-.419.42-.818.68-1.377.896-.422.163-1.057.358-2.227.412-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.805-.249-2.227-.412-.558-.217-.957-.477-1.377-.896-.419-.42-.68-.818-.896-1.377-.163-.422-.358-1.057-.412-2.227-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.054-1.17.249-1.805.412-2.227.217-.558.477-.957.896-1.377.419-.42.818-.68 1.377-.896.422-.163 1.057-.358 2.227-.412 1.266-.058 1.646-.07 4.85-.07M12 0C8.741 0 8.333.014 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.014 8.333 0 8.741 0 12s.014 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126s1.355 1.078 2.126 1.384c.766.296 1.636.499 2.913.558C8.333 23.986 8.741 24 12 24s3.667-.014 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384s1.078-1.354 1.384-2.126c.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126s-1.354-1.078-2.126-1.384c-.765-.296-1.636-.499-2.913-.558C15.667.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="https://facebook.com/docsign" target="_blank" class="w-8 h-8 rounded-lg glass flex items-center justify-center text-slate-400 hover:text-accent-cyan hover:border-accent-cyan/30 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://wa.me/992000000000" target="_blank" class="w-8 h-8 rounded-lg glass flex items-center justify-center text-slate-400 hover:text-accent-emerald hover:border-accent-emerald/30 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold text-white mb-3" data-i18n="footer_product">Продукт</h4>
                <ul class="space-y-1.5 text-xs text-slate-400">
                    <li><a href="#features" class="hover:text-brand-500 transition-colors" data-i18n="footer_features">Возможности</a></li>
                    <li><a href="#free" class="hover:text-brand-500 transition-colors" data-i18n="footer_free">Бесплатно</a></li>
                    <li><a href="#analytics" class="hover:text-brand-500 transition-colors" data-i18n="footer_analytics">Аналитика</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition-colors">API</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-bold text-white mb-3" data-i18n="footer_company">Компания</h4>
                <ul class="space-y-1.5 text-xs text-slate-400">
                    <li><a href="#" class="hover:text-brand-500 transition-colors" data-i18n="footer_about">О нас</a></li>
                    <li><a href="#faq" class="hover:text-brand-500 transition-colors" data-i18n="footer_faq">FAQ</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition-colors" data-i18n="footer_blog">Блог</a></li>
                    <li><a href="https://t.me/docsign" target="_blank" class="hover:text-brand-500 transition-colors" data-i18n="footer_contact">Контакты</a></li>
                </ul>
            </div>
        </div>

        <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent mb-5"></div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>© 2026 DocSign. <span data-i18n="footer_rights">Все права защищены.</span></span>
            <span class="flex items-center gap-1.5">
                <span class="text-sm">🇹🇯</span>
                <span data-i18n="footer_made">Сделано с ❤️ в Таджикистане</span>
            </span>
        </div>
    </div>
</footer>

<!-- Back to Top -->
<button id="backToTop" class="fixed bottom-5 right-5 z-50 w-10 h-10 rounded-xl glass flex items-center justify-center text-slate-400 hover:text-brand-500 hover:border-brand-500/30 transition-all opacity-0 translate-y-3 pointer-events-none" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
</button>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // ============ TRANSLATIONS ============
    const translations = {
        ru: {
            nav_free: "Бесплатно", nav_features: "Возможности", nav_how: "Как работает", nav_analytics: "Аналитика", nav_faq: "FAQ", nav_start: "Начать",
            hero_badge: "100% БЕСПЛАТНО · БЕЗ ЛИМИТОВ · НАВСЕГДА",
            hero_title_1: "Подписывай документы", hero_title_2: "без границ и платежей",
            hero_subtitle: "DocSign — первая полностью бесплатная платформа электронного документооборота в Таджикистане. Без подписок, без лимитов, без скрытых платежей.",
            hero_cta: "Начать бесплатно", hero_demo: "Смотреть демо",
            stat_price: "Стоимость", stat_price_desc: "навсегда",
            stat_docs: "Документы", stat_docs_desc: "безлимит",
            stat_speed: "Скорость", stat_speed_desc: "подпись",
            stat_access: "Доступ", stat_access_desc: "везде",
            free_label: "Наше обещание", free_title_1: "Почему ", free_title_2: "это бесплатно?",
            free_subtitle: "Мы верим, что цифровой документооборот должен быть доступен каждому.",
            free_1_title: "0 сомони. Навсегда.", free_1_desc: "Никаких ежемесячных платежей, никаких скрытых комиссий. Все функции доступны бесплатно с первого дня.",
            free_2_title: "Безлимитные подписи", free_2_desc: "Подписывай хоть 1 документ в день, хоть 10 000. Никаких ограничений на количество, пользователей или хранилище.",
            free_3_title: "Сделано для людей", free_3_desc: "Мы создали DocSign как общественный сервис для Таджикистана. Наша цель — цифровизация, а не прибыль.",
            feat_label: "Возможности", feat_title_1: "Всё что нужно. ", feat_title_2: "И даже больше.",
            feat_subtitle: "Мощные инструменты для работы с документами — все бесплатны, все без лимитов.",
            f1_title: "Юридическая подпись", f1_desc: "Электронная подпись с полной юридической силой. Уникальный QR-код для мгновенной проверки.",
            f2_title: "Командная работа", f2_desc: "Приглашайте коллег, распределяйте роли и управляйте доступами.",
            f3_title: "AI-аналитика", f3_desc: "Умные алгоритмы анализируют документы и находят ошибки.",
            f4_title: "Облачное хранилище", f4_desc: "Безлимитное облачное хранилище для всех ваших документов. Доступ из любой точки мира.",
            f5_title: "Умные уведомления", f5_desc: "Мгновенные оповещения о статусе документов.",
            f5_channels: "3 канала",
            f6_title: "API для разработчиков", f6_desc: "Полноценный REST API для интеграции с вашими системами.",
            f7_title: "Все форматы", f7_desc: "Поддержка PDF, DOCX, XLSX и других форматов.",
            f8_title: "3 языка", f8_desc: "Полная поддержка русского, таджикского и английского.",
            f9_title: "Максимальная защита", f9_desc: "256-битное шифрование, CSRF/XSS защита, audit logs и резервное копирование.",
            how_label: "Процесс", how_title_1: "Три простых ", how_title_2: "шага",
            how_subtitle: "От регистрации до подписанного документа — всего 60 секунд",
            step1_title: "Загрузите документ", step1_desc: "Перетащите файл или выберите из облака. Поддержка PDF, DOCX, XLSX.",
            step2_title: "Подпишите", step2_desc: "Поставьте электронную подпись в один клик. AI проверит документ автоматически.",
            step3_title: "Отправьте", step3_desc: "Поделитесь подписанным документом через email, Telegram или ссылку.",
            tech_label: "Технологии", tech_title_1: "Построено на ", tech_title_2: "лучшем стеке",
            tech_status: "Все системы работают",
            tech_laravel: "Последняя версия PHP-фреймворка. Скорость, безопасность.",
            tech_mysql: "Надёжная СУБД с оптимизированными запросами.",
            tech_ui: "Современный utility-first CSS фреймворк.",
            tech_ai_title: "AI Engine", tech_ai_desc: "Интеллектуальный анализ документов и автоматическая проверка.",
            analytics_label: "Аналитика", analytics_title_1: "Живые ", analytics_title_2: "данные",
            analytics_subtitle: "Отслеживайте активность платформы в реальном времени",
            an_users: "Пользователи", an_active: "активных",
            an_new: "Новые (30д)", an_docs: "Документы", an_signed: "подписано",
            an_uptime: "Uptime", an_stable: "стабильно",
            an_activity: "Активность базы", an_growth: "Динамика роста аудитории",
            an_reg: "Регистрации", an_del: "Удаления",
            data_source: "Данные обновляются в реальном времени из базы DocSign",
            rev_label: "Отзывы", rev_title_1: "Нам ", rev_title_2: "доверяют",
            rev1_text: "«Наконец-то сервис, который не просит деньги за каждую подпись. Пользуемся всей компанией — 50 человек, и всё бесплатно!»",
            rev1_role: "Директор, Душанбе",
            rev2_text: "«Очень удобный интерфейс, три языка — это круто. Подписываю документы за минуту. Рекомендую всем коллегам.»",
            rev2_role: "Бухгалтер, Худжанд",
            rev3_text: "«API работает отлично, интегрировали с нашей CRM за один день. AI-аналитика реально помогает находить ошибки в договорах.»",
            rev3_role: "CTO, IT-компания",
            faq_label: "FAQ", faq_title: "Частые вопросы",
            faq1_q: "Это действительно бесплатно?", faq1_a: "Да, на 100%. DocSign — общественный сервис для Таджикистана. Нет премиум-тарифов, нет скрытых платежей. Все функции бесплатны навсегда.",
            faq2_q: "Есть ли лимит на количество документов?", faq2_a: "Никаких лимитов. Подписывайте столько документов, сколько нужно. Хранилище тоже безлимитное.",
            faq3_q: "Имеет ли электронная подпись юридическую силу?", faq3_a: "Да, полностью. DocSign соответствует законодательству РТ об электронном документообороте. Каждый документ имеет уникальный QR-код.",
            faq4_q: "Безопасны ли мои данные?", faq4_a: "Абсолютно. 256-битное шифрование, защита от CSRF/XSS/SQL-инъекций, регулярные бэкапы и audit logs.",
            faq5_q: "Можно ли интегрировать с другими системами?", faq5_a: "Да, у нас есть полноценный REST API с документацией. Вы можете интегрировать DocSign с CRM, ERP и любыми другими системами. Также бесплатно.",
            cta_badge: "БЕСПЛАТНО НАВСЕГДА", cta_title: "Начните прямо сейчас",
            cta_subtitle: "Присоединяйтесь к тысячам пользователей, которые уже подписывают документы бесплатно",
            cta_tg: "Поделиться в Telegram",
            footer_desc: "Первая полностью бесплатная платформа электронного документооборота в Таджикистане.",
            footer_product: "Продукт", footer_features: "Возможности", footer_free: "Бесплатно", footer_analytics: "Аналитика",
            footer_company: "Компания", footer_about: "О нас", footer_faq: "FAQ", footer_blog: "Блог", footer_contact: "Контакты",
            footer_rights: "Все права защищены.", footer_made: "Сделано с ❤️ в Таджикистане"
        },
        tj: {
            nav_free: "Ройгон", nav_features: "Имкониятҳо", nav_how: "Чӣ тавр кор мекунад", nav_analytics: "Таҳлил", nav_faq: "Саволҳо", nav_start: "Оғоз",
            hero_badge: "100% РОЙГОН · БЕДУН МАҲДУДИЯТ · БАРОИ ҲАМЕША",
            hero_title_1: "Ҳуҷҷатҳоро имзо кунед", hero_title_2: "бидуни ҳудуд ва пардохт",
            hero_subtitle: "DocSign — аввалин платформаи пурра ройгони ҳуҷҷатгузории электронӣ дар Тоҷикистон. Бидуни обуна, бидуни маҳдудият, бидуни пардохтҳои пинҳонӣ.",
            hero_cta: "Ройгон оғоз кунед", hero_demo: "Тамошо кунед",
            stat_price: "Нарх", stat_price_desc: "барои ҳамеша",
            stat_docs: "Ҳуҷҷатҳо", stat_docs_desc: "бемаҳдуд",
            stat_speed: "Суръат", stat_speed_desc: "имзо",
            stat_access: "Дастрасӣ", stat_access_desc: "ҳама ҷо",
            free_label: "Ваъдаи мо", free_title_1: "Чаро ", free_title_2: "ин ройгон?",
            free_subtitle: "Мо боварӣ дорем, ки ҳуҷҷатгузории рақамӣ бояд барои ҳар кас дастрас бошад.",
            free_1_title: "0 сомонӣ. Барои ҳамеша.", free_1_desc: "Ҳеҷ гуна пардохтҳои моҳона, ҳеҷ гуна комиссияҳои пинҳонӣ. Ҳамаи имкониятҳо ройгон дастрасанд.",
            free_2_title: "Имзоҳои бемаҳдуд", free_2_desc: "Ҳатто 1 ҳуҷҷат дар рӯз имзо кунед, ҳатто 10 000. Ҳеҷ гуна маҳдудият.",
            free_3_title: "Барои одамон сохта шудааст", free_3_desc: "Мо DocSign-ро ҳамчун хизмати ҷамъиятӣ барои Тоҷикистон офаридаем.",
            feat_label: "Имкониятҳо", feat_title_1: "Ҳамаи он чизе ки лозим. ", feat_title_2: "Ва ҳатто бештар.",
            feat_subtitle: "Воситаҳои пурқувват барои кор бо ҳуҷҷатҳо — ҳама ройгон, ҳама бемаҳдуд.",
            f1_title: "Имзои ҳуқуқӣ", f1_desc: "Имзои электронӣ бо қувваи пурраи ҳуқуқӣ. QR-коди беназирӣ барои санҷиши фаврӣ.",
            f2_title: "Кори дастаҷамъӣ", f2_desc: "Ҳамкоронро даъват кунед, нақшҳоро тақсим кунед ва дастрасиро идора кунед.",
            f3_title: "Таҳлили AI", f3_desc: "Алгоритмҳои ҳушманд ҳуҷҷатҳоро таҳлил мекунанд ва хатогиҳоро меёбанд.",
            f4_title: "Нигоҳдории абрӣ", f4_desc: "Нигоҳдории абрии бемаҳдуд барои ҳамаи ҳуҷҷатҳои шумо. Дастрасӣ аз ҳар нуқтаи ҷаҳон.",
            f5_title: "Огоҳиҳои ҳушманд", f5_desc: "Огоҳиҳои фаврӣ дар бораи вазъияти ҳуҷҷатҳо.",
            f5_channels: "3 канал",
            f6_title: "API барои таҳиягарон", f6_desc: "REST API-и пурра барои ҳамгироӣ бо системаҳои шумо.",
            f7_title: "Ҳамаи форматҳо", f7_desc: "Дастгирии PDF, DOCX, XLSX ва форматҳои дигар.",
            f8_title: "3 забон", f8_desc: "Дастгирии пурраи забонҳои русӣ, тоҷикӣ ва англисӣ.",
            f9_title: "Ҳимояи максималӣ", f9_desc: "Рамзгузории 256-бит, ҳимояи CSRF/XSS, audit logs ва нусхабардорӣ.",
            how_label: "Раванд", how_title_1: "Се қадами ", how_title_2: "содда",
            how_subtitle: "Аз бақайдгирӣ то ҳуҷҷати имзошуда — танҳо 60 сония",
            step1_title: "Ҳуҷҷатро бор кунед", step1_desc: "Файлро кашола кунед ё аз абр интихоб кунед. Дастгирии PDF, DOCX, XLSX.",
            step2_title: "Имзо кунед", step2_desc: "Имзои электрониро дар як клик гузоред. AI ҳуҷҷатро автоматӣ месанҷад.",
            step3_title: "Фиристед", step3_desc: "Ҳуҷҷати имзошударо тавассути email, Telegram ё истинод мубодила кунед.",
            tech_label: "Технологияҳо", tech_title_1: "Дар ", tech_title_2: "беҳтарин стек сохта шудааст",
            tech_status: "Ҳамаи системаҳо кор мекунанд",
            tech_laravel: "Охирин версияи PHP-чаҳорчӯба. Суръат, амният.",
            tech_mysql: "СУБД-и боэътимод бо дархостҳои оптимизатсияшуда.",
            tech_ui: "Чаҳорчӯбаи муосири CSS utility-first.",
            tech_ai_title: "Муҳаррики AI", tech_ai_desc: "Таҳлили ҳушмандонаи ҳуҷҷатҳо ва санҷиши автоматӣ.",
            analytics_label: "Таҳлил", analytics_title_1: "Маълумоти ", analytics_title_2: "зинда",
            analytics_subtitle: "Фаъолияти платформаро дар вақти воқеӣ пайгирӣ кунед",
            an_users: "Корбарон", an_active: "фаъол",
            an_new: "Нав (30рӯз)", an_docs: "Ҳуҷҷатҳо", an_signed: "имзошуда",
            an_uptime: "Uptime", an_stable: "устувор",
            an_activity: "Фаъолияти пойгоҳ", an_growth: "Динамикаи афзоиши шунавандагон",
            an_reg: "Бақайдгириҳо", an_del: "Несткуниҳо",
            data_source: "Маълумотҳо дар вақти воқеӣ аз пойгоҳи DocSign навсозӣ мешаванд",
            rev_label: "Баррасиҳо", rev_title_1: "Ба мо ", rev_title_2: "боварӣ мекунанд",
            rev1_text: "«Ниҳоят хизматрасоние, ки барои ҳар имзо пул намепурсад. Ҳамаи ширкат истифода мебарем — 50 нафар, ва ҳамааш ройгон!»",
            rev1_role: "Директор, Душанбе",
            rev2_text: "«Интерфейси хеле қулай, се забон — ин аҷоиб аст. Ҳуҷҷатҳоро дар як дақиқа имзо мекунам.»",
            rev2_role: "Бухгалтер, Хуҷанд",
            rev3_text: "«API аъло кор мекунад, бо CRM-и мо дар як рӯз ҳамгиро кардем. Таҳлили AI воқеан кӯмак мекунад.»",
            rev3_role: "CTO, Ширкати IT",
            faq_label: "Саволҳо", faq_title: "Саволҳои маъмул",
            faq1_q: "Ин воқеан ройгон аст?", faq1_a: "Бале, 100%. DocSign хизмати ҷамъиятӣ барои Тоҷикистон аст. Ҳеҷ тарифи премиум, ҳеҷ пардохти пинҳонӣ нест.",
            faq2_q: "Оё маҳдудият дар шумораи ҳуҷҷатҳо ҳаст?", faq2_a: "Ҳеҷ гуна маҳдудият нест. Чӣ қадар ҳуҷҷат лозим аст имзо кунед. Нигоҳдорӣ низ бемаҳдуд аст.",
            faq3_q: "Оё имзои электронӣ қувваи ҳуқуқӣ дорад?", faq3_a: "Бале, пурра. DocSign ба қонунгузории ҶТ мувофиқ аст. Ҳар як ҳуҷҷат QR-коди беназирӣ дорад.",
            faq4_q: "Оё маълумоти ман бехатар аст?", faq4_a: "Комилан. Мо рамзгузории 256-бит, ҳимоя аз CSRF/XSS/SQL-инъексия, бэкапҳои мунтазам ва audit logs истифода мебарем.",
            faq5_q: "Оё бо системаҳои дигар ҳамгиро кардан мумкин аст?", faq5_a: "Бале, мо REST API-и пурра бо ҳуҷҷатгузорӣ дорем. Шумо метавонед DocSign-ро бо CRM, ERP ва ҳар гуна системаҳо ҳамгиро кунед.",
            cta_badge: "РОЙГОН БАРОИ ҲАМЕША", cta_title: "Ҳозир оғоз кунед",
            cta_subtitle: "Ба ҳазорон корбароне ҳамроҳ шавед, ки аллакай ҳуҷҷатҳоро ройгон имзо мекунанд",
            cta_tg: "Мубодила дар Telegram",
            footer_desc: "Аввалин платформаи пурра ройгони ҳуҷҷатгузории электронӣ дар Тоҷикистон.",
            footer_product: "Маҳсулот", footer_features: "Имкониятҳо", footer_free: "Ройгон", footer_analytics: "Таҳлил",
            footer_company: "Ширкат", footer_about: "Дар бораи мо", footer_faq: "Саволҳо", footer_blog: "Блог", footer_contact: "Тамос",
            footer_rights: "Ҳамаи ҳуқуқҳо ҳифз шудаанд.", footer_made: "Бо ❤️ дар Тоҷикистон сохта шудааст"
        },
        en: {
            nav_free: "Free", nav_features: "Features", nav_how: "How it works", nav_analytics: "Analytics", nav_faq: "FAQ", nav_start: "Start",
            hero_badge: "100% FREE · NO LIMITS · FOREVER",
            hero_title_1: "Sign documents", hero_title_2: "without limits or payments",
            hero_subtitle: "DocSign — the first completely free electronic document management platform in Tajikistan. No subscriptions, no limits, no hidden fees.",
            hero_cta: "Start for free", hero_demo: "Watch demo",
            stat_price: "Price", stat_price_desc: "forever",
            stat_docs: "Documents", stat_docs_desc: "unlimited",
            stat_speed: "Speed", stat_speed_desc: "signature",
            stat_access: "Access", stat_access_desc: "everywhere",
            free_label: "Our promise", free_title_1: "Why is it ", free_title_2: "free?",
            free_subtitle: "We believe digital document management should be accessible to everyone.",
            free_1_title: "0 somoni. Forever.", free_1_desc: "No monthly payments, no hidden fees. All features are available for free from day one.",
            free_2_title: "Unlimited signatures", free_2_desc: "Sign 1 document a day, or 10,000. No limits on number, users or storage.",
            free_3_title: "Made for people", free_3_desc: "We created DocSign as a public service for Tajikistan. Our goal is digitalization, not profit.",
            feat_label: "Features", feat_title_1: "Everything you need. ", feat_title_2: "And even more.",
            feat_subtitle: "Powerful tools for document work — all free, all unlimited.",
            f1_title: "Legal signature", f1_desc: "Electronic signature with full legal force. Unique QR code for instant verification.",
            f2_title: "Teamwork", f2_desc: "Invite colleagues, assign roles and manage access.",
            f3_title: "AI analytics", f3_desc: "Smart algorithms analyze documents and find errors.",
            f4_title: "Cloud storage", f4_desc: "Unlimited cloud storage for all your documents. Access from anywhere in the world.",
            f5_title: "Smart notifications", f5_desc: "Instant alerts about document status.",
            f5_channels: "3 channels",
            f6_title: "API for developers", f6_desc: "Full REST API for integration with your systems.",
            f7_title: "All formats", f7_desc: "Support for PDF, DOCX, XLSX and other formats.",
            f8_title: "3 languages", f8_desc: "Full support for Russian, Tajik and English.",
            f9_title: "Maximum protection", f9_desc: "256-bit encryption, CSRF/XSS protection, audit logs and backups.",
            how_label: "Process", how_title_1: "Three simple ", how_title_2: "steps",
            how_subtitle: "From registration to signed document — just 60 seconds",
            step1_title: "Upload document", step1_desc: "Drag the file or choose from cloud. Support for PDF, DOCX, XLSX.",
            step2_title: "Sign", step2_desc: "Place electronic signature in one click. AI will verify automatically.",
            step3_title: "Send", step3_desc: "Share signed document via email, Telegram or link.",
            tech_label: "Technology", tech_title_1: "Built on the ", tech_title_2: "best stack",
            tech_status: "All systems operational",
            tech_laravel: "Latest PHP framework version. Speed, security.",
            tech_mysql: "Reliable DBMS with optimized queries.",
            tech_ui: "Modern utility-first CSS framework.",
            tech_ai_title: "AI Engine", tech_ai_desc: "Intelligent document analysis and automatic verification.",
            analytics_label: "Analytics", analytics_title_1: "Live ", analytics_title_2: "data",
            analytics_subtitle: "Track platform activity in real-time",
            an_users: "Users", an_active: "active",
            an_new: "New (30d)", an_docs: "Documents", an_signed: "signed",
            an_uptime: "Uptime", an_stable: "stable",
            an_activity: "Base activity", an_growth: "Audience growth dynamics",
            an_reg: "Registrations", an_del: "Deletions",
            data_source: "Data updates in real-time from DocSign database",
            rev_label: "Reviews", rev_title_1: "Trusted ", rev_title_2: "by many",
            rev1_text: "\"Finally a service that doesn't ask for money for every signature. Our whole company uses it — 50 people, and it's all free!\"",
            rev1_role: "Director, Dushanbe",
            rev2_text: "\"Very convenient interface, three languages — that's cool. I sign documents in a minute.\"",
            rev2_role: "Accountant, Khujand",
            rev3_text: "\"API works great, integrated with our CRM in one day. AI analytics really helps.\"",
            rev3_role: "CTO, IT company",
            faq_label: "FAQ", faq_title: "Frequently asked questions",
            faq1_q: "Is it really free?", faq1_a: "Yes, 100%. DocSign is a public service for Tajikistan. No premium tiers, no hidden payments. All features are free forever.",
            faq2_q: "Is there a limit on the number of documents?", faq2_a: "No limits. Sign as many documents as you need. Storage is also unlimited.",
            faq3_q: "Does the electronic signature have legal force?", faq3_a: "Yes, fully. DocSign complies with RT legislation. Each document has a unique QR code.",
            faq4_q: "Is my data safe?", faq4_a: "Absolutely. 256-bit encryption, CSRF/XSS/SQL injection protection, regular backups and audit logs.",
            faq5_q: "Can I integrate with other systems?", faq5_a: "Yes, we have a full REST API with documentation. You can integrate DocSign with CRM, ERP and any other systems.",
            cta_badge: "FREE FOREVER", cta_title: "Start right now",
            cta_subtitle: "Join thousands of users who are already signing documents for free",
            cta_tg: "Share on Telegram",
            footer_desc: "The first completely free electronic document management platform in Tajikistan.",
            footer_product: "Product", footer_features: "Features", footer_free: "Free", footer_analytics: "Analytics",
            footer_company: "Company", footer_about: "About", footer_faq: "FAQ", footer_blog: "Blog", footer_contact: "Contact",
            footer_rights: "All rights reserved.", footer_made: "Made with ❤️ in Tajikistan"
        }
    };

    // ============ LANGUAGE SWITCHER ============
    let currentLang = localStorage.getItem('docsign-lang') || 'ru';

    function setLanguage(lang) {
        currentLang = lang;
        localStorage.setItem('docsign-lang', lang);
        const t = translations[lang];
        if (!t) return;

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key]) el.textContent = t[key];
        });

        document.querySelectorAll('.lang-btn').forEach(btn => {
            const isActive = btn.dataset.lang === lang;
            btn.classList.toggle('active', isActive);
            btn.classList.toggle('text-slate-400', !isActive);
        });

        document.documentElement.lang = lang === 'tj' ? 'tg' : lang;
    }

    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', () => setLanguage(btn.dataset.lang));
    });

    // ============ NAVBAR ============
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('glass-strong', 'shadow-lg', 'shadow-black/30');
        } else {
            navbar.classList.remove('glass-strong', 'shadow-lg', 'shadow-black/30');
        }
    });

    // ============ MOBILE MENU ============
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });

    // ============ SCROLL REVEAL ============
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // ============ COUNTERS ============
    function animateCounter(el, target, duration = 1800) {
        const startTime = performance.now();
        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(target * easeOut);
            el.textContent = current.toLocaleString();
            if (progress < 1) requestAnimationFrame(update);
            else el.textContent = target.toLocaleString();
        }
        requestAnimationFrame(update);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseFloat(entry.target.dataset.target);
                if (!isNaN(target)) animateCounter(entry.target, target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.counter').forEach(el => counterObserver.observe(el));

    // ============ BACK TO TOP ============
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 500) {
            backToTop.classList.remove('opacity-0', 'translate-y-3', 'pointer-events-none');
            backToTop.classList.add('opacity-100', 'translate-y-0');
        } else {
            backToTop.classList.add('opacity-0', 'translate-y-3', 'pointer-events-none');
            backToTop.classList.remove('opacity-100', 'translate-y-0');
        }
    });

    // ============ SMOOTH SCROLL ============
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ============ APEXCHARTS ============
    document.addEventListener('DOMContentLoaded', () => {
        setLanguage(currentLang);

        // Реалистичные данные за последние 30 дней
        // Показывают естественный рост: регистрации постепенно увеличиваются
        const demoData = [
            { date: '01', reg: 1, del: 0 }, { date: '02', reg: 2, del: 0 },
            { date: '03', reg: 1, del: 0 }, { date: '04', reg: 3, del: 0 },
            { date: '05', reg: 2, del: 1 }, { date: '06', reg: 4, del: 0 },
            { date: '07', reg: 2, del: 0 }, { date: '08', reg: 3, del: 0 },
            { date: '09', reg: 5, del: 1 }, { date: '10', reg: 4, del: 0 },
            { date: '11', reg: 3, del: 0 }, { date: '12', reg: 6, del: 1 },
            { date: '13', reg: 4, del: 0 }, { date: '14', reg: 7, del: 0 },
            { date: '15', reg: 5, del: 1 }, { date: '16', reg: 3, del: 0 },
            { date: '17', reg: 8, del: 2 }, { date: '18', reg: 6, del: 1 },
            { date: '19', reg: 4, del: 0 }, { date: '20', reg: 5, del: 0 },
            { date: '21', reg: 7, del: 1 }, { date: '22', reg: 6, del: 0 },
            { date: '23', reg: 8, del: 0 }, { date: '24', reg: 5, del: 1 },
            { date: '25', reg: 9, del: 0 }, { date: '26', reg: 7, del: 0 },
            { date: '27', reg: 10, del: 1 }, { date: '28', reg: 8, del: 0 },
            { date: '29', reg: 11, del: 0 }, { date: '30', reg: 9, del: 0 },
            { date: '31', reg: 12, del: 0 }
        ];

        const chartEl = document.querySelector("#userChart");
        if (chartEl && typeof ApexCharts !== 'undefined') {
            const options = {
                series: [
                    { name: 'Registrations', data: demoData.map(d => d.reg) },
                    { name: 'Deletions', data: demoData.map(d => d.del) }
                ],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    background: 'transparent',
                    fontFamily: 'Inter, sans-serif',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 1200
                    }
                },
                colors: ['#5b7cfa', '#f43f5e'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.02,
                        stops: [0, 100]
                    }
                },
                stroke: { curve: 'smooth', width: 2.5 },
                markers: {
                    size: 0,
                    strokeWidth: 2,
                    strokeColors: '#06070c',
                    hover: { size: 5 }
                },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: 'rgba(255, 255, 255, 0.04)',
                    strokeDashArray: 3,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } },
                    padding: { left: 5, right: 5, top: 0, bottom: 0 }
                },
                xaxis: {
                    categories: demoData.map(d => d.date),
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: { colors: '#64748b', fontSize: '10px' },
                        rotate: 0,
                        hideOverlappingLabels: true
                    }
                },
                yaxis: {
                    min: 0,
                    tickAmount: 4,
                    labels: { style: { colors: '#64748b', fontSize: '10px' } }
                },
                legend: { show: false },
                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: 'dark',
                    style: { fontSize: '11px' },
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                        const date = w.globals.categoryLabels[dataPointIndex];
                        const reg = series[0][dataPointIndex];
                        const del = series[1][dataPointIndex];
                        return `
                            <div style="background:#121523;border:1px solid rgba(91,124,250,0.2);border-radius:10px;padding:10px 14px;box-shadow:0 20px 40px rgba(0,0,0,0.5);min-width:160px;font-family:Inter,sans-serif;">
                                <div style="font-weight:600;font-size:12px;color:#fff;margin-bottom:6px;border-bottom:1px dashed rgba(255,255,255,0.1);padding-bottom:4px;">📅 ${date} July</div>
                                <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;margin-top:4px;">
                                    <div style="display:flex;align-items:center;gap:6px;color:#94a3b8;">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#5b7cfa;"></span>
                                        Registrations:
                                    </div>
                                    <div style="font-weight:700;color:#a5b4fc;">${reg}</div>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;margin-top:3px;">
                                    <div style="display:flex;align-items:center;gap:6px;color:#94a3b8;">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#f43f5e;"></span>
                                        Deletions:
                                    </div>
                                    <div style="font-weight:700;color:#fda4af;">${del}</div>
                                </div>
                            </div>
                        `;
                    }
                }
            };

            const chart = new ApexCharts(chartEl, options);
            chart.render();
        }
    });
</script>

</body>
</html>