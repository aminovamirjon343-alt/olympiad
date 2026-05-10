<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocSign — Система ЭДО</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/index.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/jetbrains-mono@5.0.16/index.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        doc: {
                            dark: '#020617',
                            deep: '#0a1628',
                            navy: '#0f1d3a',
                            blue: '#1e3a5f',
                            accent: '#3b82f6',
                            light: '#60a5fa',
                            glow: '#2563eb',
                            cyan: '#06b6d4',
                            purple: '#8b5cf6',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delay': 'float 6s ease-in-out 2s infinite',
                        'pulse-glow': 'pulseGlow 3s ease-in-out infinite',
                        'shimmer': 'shimmer 3s linear infinite',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                        'slide-down': 'slideDown 0.5s ease-out forwards',
                        'fade-in': 'fadeIn 1s ease-out forwards',
                        'scale-in': 'scaleIn 0.6s ease-out forwards',
                        'orbit': 'orbit 20s linear infinite',
                        'spin-slow': 'spin 30s linear infinite',
                        'gradient-shift': 'gradientShift 8s ease infinite',
                        'typewriter': 'typewriter 2s steps(20) forwards',
                        'bounce-gentle': 'bounceGentle 2s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(2deg)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(59, 130, 246, 0.3)' },
                            '50%': { boxShadow: '0 0 60px rgba(59, 130, 246, 0.6), 0 0 100px rgba(59, 130, 246, 0.3)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% center' },
                            '100%': { backgroundPosition: '200% center' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(60px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.8)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        orbit: {
                            '0%': { transform: 'rotate(0deg) translateX(150px) rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg) translateX(150px) rotate(-360deg)' },
                        },
                        gradientShift: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        },
                        bounceGentle: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/300,400,500,600,700,800,900.css');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #020617;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa, #06b6d4, #8b5cf6);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease infinite;
        }

        .gradient-text-warm {
            background: linear-gradient(135deg, #f59e0b, #ef4444, #ec4899);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease infinite;
        }

        .glass {
            background: rgba(15, 29, 58, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(59, 130, 246, 0.15);
        }

        .glass-strong {
            background: rgba(10, 22, 40, 0.85);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 60px rgba(59, 130, 246, 0.2);
            border-color: rgba(59, 130, 246, 0.4);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6, #06b6d4);
            background-size: 200% 200%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .btn-primary:hover::before {
            left: 100%;
        }
        .btn-primary:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid rgba(59, 130, 246, 0.5);
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            background: rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.2);
        }

        .line-glow {
            height: 1px;
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
        }

        .bg-grid {
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .noise-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            opacity: 0.03;
            pointer-events: none;
            z-index: 9999;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .nav-link:hover {
            color: #60a5fa;
        }

        .counter {
            font-variant-numeric: tabular-nums;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            pointer-events: none;
        }

        .code-block {
            background: rgba(2, 6, 23, 0.8);
            border: 1px solid rgba(59, 130, 246, 0.15);
            font-family: 'JetBrains Mono', monospace;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #020617;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e3a5f;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3b82f6;
        }

        .lang-btn.active {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border-color: #3b82f6;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem !important;
            }
        }

        .feature-icon {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(6, 182, 212, 0.1));
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .timeline-line {
            background: linear-gradient(180deg, #3b82f6, #06b6d4, #8b5cf6);
        }

        .shimmer-text {
            background: linear-gradient(90deg, #60a5fa, #ffffff, #60a5fa);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }

        .phone-input-wrapper {
            background: rgba(15, 29, 58, 0.6);
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }
        .phone-input-wrapper:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(15, 29, 58, 0.8), rgba(30, 58, 95, 0.4));
            border: 1px solid rgba(59, 130, 246, 0.15);
        }
    </style>
</head>
<body class="bg-grid">

<div class="noise-overlay"></div>

<!-- Navigation -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:shadow-blue-500/40 transition-all duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight">Doc<span class="gradient-text">Sign</span></span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="#features" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_features">Возможности</a>
                <a href="#technology" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_tech">Технологии</a>
                <a href="#security" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_security">Безопасность</a>
                <a href="#ai" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_ai">AI Анализ</a>
                <a href="#contact" class="nav-link text-sm font-medium text-slate-300" data-i18n="nav_contact">Контакты</a>
            </div>

            <!-- Language & CTA -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-1 glass rounded-lg p-1">
                    <button class="lang-btn active px-3 py-1 rounded-md text-xs font-medium transition-all duration-200 border border-transparent" data-lang="ru">RU</button>
                    <button class="lang-btn px-3 py-1 rounded-md text-xs font-medium transition-all duration-200 border border-transparent" data-lang="en">EN</button>
                    <button class="lang-btn px-3 py-1 rounded-md text-xs font-medium transition-all duration-200 border border-transparent" data-lang="tj">TJ</button>
                </div>
                <a href="{{route('login')}}" class="btn-primary px-5 py-2 rounded-lg text-sm font-semibold text-white shadow-lg">
                    <span data-i18n="nav_start">Начать</span>
                </a>
                <!-- Mobile menu button -->
                <button id="mobileMenuBtn" class="lg:hidden p-2 text-slate-300 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden lg:hidden glass-strong border-t border-slate-700/50">
        <div class="px-4 py-4 space-y-3">
            <a href="#features" class="block text-sm font-medium text-slate-300 hover:text-white py-2" data-i18n="nav_features">Возможности</a>
            <a href="#technology" class="block text-sm font-medium text-slate-300 hover:text-white py-2" data-i18n="nav_tech">Технологии</a>
            <a href="#security" class="block text-sm font-medium text-slate-300 hover:text-white py-2" data-i18n="nav_security">Безопасность</a>
            <a href="#ai" class="block text-sm font-medium text-slate-300 hover:text-white py-2" data-i18n="nav_ai">AI Анализ</a>
            <a href="#contact" class="block text-sm font-medium text-slate-300 hover:text-white py-2" data-i18n="nav_contact">Контакты</a>
            <div class="flex items-center gap-2 pt-3 border-t border-slate-700/50">
                <button class="lang-btn active px-3 py-1 rounded-md text-xs font-medium border border-transparent" data-lang="ru">RU</button>
                <button class="lang-btn px-3 py-1 rounded-md text-xs font-medium border border-transparent" data-lang="en">EN</button>
                <button class="lang-btn px-3 py-1 rounded-md text-xs font-medium border border-transparent" data-lang="tj">TJ</button>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
    <!-- Background Orbs -->
    <div class="orb w-[500px] h-[500px] bg-blue-600 top-1/4 -left-1/4 animate-float"></div>
    <div class="orb w-[400px] h-[400px] bg-cyan-500 bottom-1/4 -right-1/4 animate-float-delay"></div>
    <div class="orb w-[300px] h-[300px] bg-purple-600 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-20"></div>

    <!-- Grid Floor Effect -->
    <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-blue-900/20 to-transparent"></div>
    <div class="absolute inset-0" style="background: radial-gradient(ellipse at 50% 0%, rgba(59, 130, 246, 0.15) 0%, transparent 60%);"></div>

    <!-- Orbiting Elements -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div class="relative w-[600px] h-[600px] animate-spin-slow">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3 h-3 bg-blue-400 rounded-full shadow-lg shadow-blue-400/50"></div>
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-2 h-2 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-2 bg-purple-400 rounded-full shadow-lg shadow-purple-400/50"></div>
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 glass rounded-full px-5 py-2 mb-8 animate-slide-down">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            <span class="text-xs font-medium text-slate-300" data-i18n="hero_badge">Система ЭДО нового поколения</span>
        </div>

        <!-- Main Title -->
        <h1 class="hero-title text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black tracking-tight mb-6 leading-[0.95]">
            <span class="block text-white" data-i18n="hero_title_1">Документы.</span>
            <span class="block gradient-text" data-i18n="hero_title_2">Подписаны.</span>
            <span class="block text-white" data-i18n="hero_title_3">Мгновенно.</span>
        </h1>

        <!-- Subtitle -->
        <p class="max-w-2xl mx-auto text-lg sm:text-xl text-slate-400 mb-12 leading-relaxed animate-fade-in" style="animation-delay: 0.5s" data-i18n="hero_subtitle">
            DocSign — интеллектуальная платформа электронного документооборота с AI-аналитикой, цифровой подписью и абсолютной безопасностью. Создано для бизнеса Таджикистана.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16 animate-slide-up" style="animation-delay: 0.8s">
            <a href="#contact" class="btn-primary px-8 py-4 rounded-2xl text-base font-bold text-white shadow-2xl shadow-blue-500/25 flex items-center gap-3 w-full sm:w-auto justify-center">
                <span data-i18n="hero_cta_primary">Попробовать бесплатно</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="#features" class="btn-outline px-8 py-4 rounded-2xl text-base font-bold text-slate-300 flex items-center gap-3 w-full sm:w-auto justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span data-i18n="hero_cta_secondary">Смотреть демо</span>
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto animate-fade-in" style="animation-delay: 1.2s">
            <div class="stat-card rounded-2xl p-5">
                <div class="text-3xl md:text-4xl font-black gradient-text counter" data-target="99.9">0</div>
                <div class="text-xs text-slate-400 mt-1" data-i18n="stat_uptime">% Uptime</div>
            </div>
            <div class="stat-card rounded-2xl p-5">
                <div class="text-3xl md:text-4xl font-black gradient-text"><span class="counter" data-target="50">0</span>K+</div>
                <div class="text-xs text-slate-400 mt-1" data-i18n="stat_docs">Документов/день</div>
            </div>
            <div class="stat-card rounded-2xl p-5">
                <div class="text-3xl md:text-4xl font-black gradient-text"><span class="counter" data-target="256">0</span>-bit</div>
                <div class="text-xs text-slate-400 mt-1" data-i18n="stat_encryption">Шифрование</div>
            </div>
            <div class="stat-card rounded-2xl p-5">
                <div class="text-3xl md:text-4xl font-black gradient-text"><span class="counter" data-target="0">0</span>.<span class="counter" data-target="3">0</span>s</div>
                <div class="text-xs text-slate-400 mt-1" data-i18n="stat_response">Время ответа</div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce-gentle">
        <div class="w-6 h-10 rounded-full border-2 border-slate-500/50 flex justify-center pt-2">
            <div class="w-1 h-3 bg-blue-400 rounded-full animate-pulse"></div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="relative py-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-950/20 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-20 scroll-reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-blue-400 uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-blue-400"></span>
                <span data-i18n="features_label">Возможности</span>
                <span class="w-8 h-px bg-blue-400"></span>
            </span>
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-black text-white mb-6" data-i18n="features_title">
                Всё. Что вам нужно.
            </h2>
            <p class="max-w-2xl mx-auto text-lg text-slate-400" data-i18n="features_subtitle">
                Каждая деталь спроектирована для максимальной эффективности вашего документооборота
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Feature 1: PDF Signing -->
            <div class="scroll-reveal glass rounded-3xl p-8 card-hover group">
                <div class="feature-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3" data-i18n="f1_title">Электронная подпись</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4" data-i18n="f1_desc">
                    FPDI библиотека физически «вшивает» изображение подписи в оригинальный PDF. Каждая подпись привязана к конкретному файлу.
                </p>
                <div class="code-block rounded-xl p-4 text-xs font-mono">
                    <span class="text-purple-400">$pdf</span><span class="text-slate-500">-></span><span class="text-blue-400">injectSignature</span><span class="text-slate-500">(</span><span class="text-green-400">'sign.png'</span><span class="text-slate-500">);</span>
                </div>
            </div>

            <!-- Feature 2: Role Management -->
            <div class="scroll-reveal glass rounded-3xl p-8 card-hover group" style="transition-delay: 0.1s">
                <div class="feature-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3" data-i18n="f2_title">Управление ролями</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4" data-i18n="f2_desc">
                    Гибкая система аутентификации и авторизации с разделением ролей. Администраторы, менеджеры, пользователи — полный контроль доступа.
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">Admin</span>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">Manager</span>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-500/10 text-purple-400 border border-purple-500/20">User</span>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">Auditor</span>
                </div>
            </div>

            <!-- Feature 3: Database -->
            <div class="scroll-reveal glass rounded-3xl p-8 card-hover group" style="transition-delay: 0.2s">
                <div class="feature-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3" data-i18n="f3_title">MySQL Архитектура</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4" data-i18n="f3_desc">
                    Четкая структура связей (foreign keys) между пользователями, документами и логами. Миграции через php artisan.
                </p>
                <div class="code-block rounded-xl p-4 text-xs font-mono space-y-1">
                    <div><span class="text-purple-400">users</span> <span class="text-slate-500">→</span> <span class="text-blue-400">1:N</span> <span class="text-purple-400">→ documents</span></div>
                    <div><span class="text-purple-400">documents</span> <span class="text-slate-500">→</span> <span class="text-blue-400">1:N</span> <span class="text-purple-400">→ logs</span></div>
                    <div><span class="text-purple-400">signatures</span> <span class="text-slate-500">→</span> <span class="text-blue-400">1:1</span> <span class="text-purple-400">→ files</span></div>
                </div>
            </div>

            <!-- Feature 4: AI Analysis -->
            <div class="scroll-reveal glass rounded-3xl p-8 card-hover group">
                <div class="feature-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3" data-i18n="f4_title">AI Intelligent Analysis</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4" data-i18n="f4_desc">
                    Интеллектуальные алгоритмы анализируют данные, автоматизируют рутинные процессы и выводят информацию в удобном визуальном виде.
                </p>
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-2 bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full" style="width: 94%"></div>
                    </div>
                    <span class="text-xs font-mono text-amber-400">94%</span>
                </div>
                <div class="text-xs text-slate-500 mt-1" data-i18n="f4_accuracy">Точность анализа</div>
            </div>

            <!-- Feature 5: File Management -->
            <div class="scroll-reveal glass rounded-3xl p-8 card-hover group" style="transition-delay: 0.1s">
                <div class="feature-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3" data-i18n="f5_title">Управление файлами</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4" data-i18n="f5_desc">
                    Логика загрузки, хранения и вывода документов. Поддержка облачного хранения с перспективой масштабирования.
                </p>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>PDF, DOCX, XLSX, PNG</span>
                </div>
            </div>

            <!-- Feature 6: Dark Mode -->
            <div class="scroll-reveal glass rounded-3xl p-8 card-hover group" style="transition-delay: 0.2s">
                <div class="feature-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3" data-i18n="f6_title">Perfect Dark Mode</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4" data-i18n="f6_desc">
                    Глубокая настройка тёмной темы — таблицы, модальные окна и шрифты меняют цвета так, чтобы глаза не уставали.
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-800 border border-slate-700"></div>
                    <div class="w-8 h-8 rounded-lg bg-blue-900/50 border border-blue-700/50"></div>
                    <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800"></div>
                    <div class="w-8 h-8 rounded-lg bg-indigo-900/50 border border-indigo-700/50"></div>
                    <div class="w-8 h-8 rounded-lg bg-cyan-900/50 border border-cyan-700/50"></div>
                </div>
                <div class="text-xs text-slate-500 mt-1" data-i18n="f6_palette">Цветовая палитра</div>
            </div>
        </div>
    </div>
</section>

<!-- Technology Section -->
<section id="technology" class="relative py-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-950/10 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20 scroll-reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-cyan-400 uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-cyan-400"></span>
                <span data-i18n="tech_label">Технологии</span>
                <span class="w-8 h-px bg-cyan-400"></span>
            </span>
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-black text-white mb-6" data-i18n="tech_title">
                Под капотом
            </h2>
            <p class="max-w-2xl mx-auto text-lg text-slate-400" data-i18n="tech_subtitle">
                Мощный стек технологий, обеспечивающий скорость, надёжность и масштабируемость
            </p>
        </div>

        <!-- Tech Stack Visual -->
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <!-- Left: Code Block -->
            <div class="scroll-reveal">
                <div class="code-block rounded-2xl overflow-hidden shadow-2xl shadow-blue-500/10">
                    <!-- Terminal Header -->
                    <div class="flex items-center gap-2 px-4 py-3 bg-slate-800/50 border-b border-slate-700/50">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="ml-3 text-xs text-slate-500 font-mono">DocSign Architecture</span>
                    </div>
                    <div class="p-6 font-mono text-sm space-y-2 overflow-x-auto">
                        <div class="text-slate-500">// 🛠 Технологический стек</div>
                        <div><span class="text-purple-400">framework</span><span class="text-slate-500">:</span> <span class="text-green-400">'Laravel 11.x (PHP)'</span><span class="text-slate-500">,</span></div>
                        <div><span class="text-purple-400">database</span><span class="text-slate-500">:</span> <span class="text-green-400">'MySQL 8.0'</span><span class="text-slate-500">,</span></div>
                        <div><span class="text-purple-400">frontend</span><span class="text-slate-500">:</span> <span class="text-green-400">'TailwindCSS + Bootstrap'</span><span class="text-slate-500">,</span></div>
                        <div><span class="text-purple-400">pdf_engine</span><span class="text-slate-500">:</span> <span class="text-green-400">'FPDI / TCPDF'</span><span class="text-slate-500">,</span></div>
                        <div><span class="text-purple-400">auth</span><span class="text-slate-500">:</span> <span class="text-green-400">'Laravel Breeze + Roles'</span><span class="text-slate-500">,</span></div>
                        <div><span class="text-purple-400">ai_module</span><span class="text-slate-500">:</span> <span class="text-green-400">'Intelligent Analysis'</span><span class="text-slate-500">,</span></div>
                        <div><span class="text-purple-400">region</span><span class="text-slate-500">:</span> <span class="text-green-400">'🇹🇯 Таджикистан'</span><span class="text-slate-500">,</span></div>
                        <div><span class="text-purple-400">languages</span><span class="text-slate-500">:</span> <span class="text-slate-500">[</span><span class="text-green-400">'RU'</span><span class="text-slate-500">,</span> <span class="text-green-400">'EN'</span><span class="text-slate-500">,</span> <span class="text-green-400">'TJ'</span><span class="text-slate-500">]</span></div>
                        <div class="pt-4 text-slate-600">
                            <span class="text-green-500">✓</span> Все системы работают штатно
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Tech Cards -->
            <div class="space-y-4">
                <div class="scroll-reveal glass rounded-2xl p-6 card-hover flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/20 border border-purple-500/30 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">🐘</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-white mb-1">Laravel 11</h4>
                        <p class="text-sm text-slate-400" data-i18n="tech_laravel">Последняя версия PHP-фреймворка. Высокая скорость, безопасность и элегантный синтаксис.</p>
                    </div>
                </div>

                <div class="scroll-reveal glass rounded-2xl p-6 card-hover flex items-start gap-4" style="transition-delay: 0.1s">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">🗄️</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-white mb-1">MySQL 8.0</h4>
                        <p class="text-sm text-slate-400" data-i18n="tech_mysql">Надёжная СУБД с foreign keys, индексами и оптимизированными запросами для больших данных.</p>
                    </div>
                </div>

                <div class="scroll-reveal glass rounded-2xl p-6 card-hover flex items-start gap-4" style="transition-delay: 0.2s">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 border border-cyan-500/30 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">🎨</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-white mb-1">TailwindCSS + Bootstrap</h4>
                        <p class="text-sm text-slate-400" data-i18n="tech_ui">Гибридный дизайн: мощь Tailwind для верстки и компоненты Bootstrap для быстрой разработки.</p>
                    </div>
                </div>

                <div class="scroll-reveal glass rounded-2xl p-6 card-hover flex items-start gap-4" style="transition-delay: 0.3s">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-600/20 border border-amber-500/30 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">📄</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-white mb-1">FPDI Engine</h4>
                        <p class="text-sm text-slate-400" data-i18n="tech_pdf">Физическая вшивка подписи в PDF-файл. Цифровой след привязан к каждому документу.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Security Section -->
<section id="security" class="relative py-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-purple-950/10 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20 scroll-reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-green-400 uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-green-400"></span>
                <span data-i18n="security_label">Безопасность</span>
                <span class="w-8 h-px bg-green-400"></span>
            </span>
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-black text-white mb-6" data-i18n="security_title">
                Абсолютная защита
            </h2>
            <p class="max-w-2xl mx-auto text-lg text-slate-400" data-i18n="security_subtitle">
                Многоуровневая система безопасности для защиты ваших документов и данных
            </p>
        </div>

        <!-- Security Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="scroll-reveal glass rounded-2xl p-6 card-hover text-center">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500/20 to-emerald-500/20 border border-green-500/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-white mb-2" data-i18n="sec1_title">SSL/TLS</h4>
                <p class="text-sm text-slate-400" data-i18n="sec1_desc">Шифрование всех данных при передаче</p>
            </div>

            <div class="scroll-reveal glass rounded-2xl p-6 card-hover text-center" style="transition-delay: 0.1s">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-cyan-500/20 border border-blue-500/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-white mb-2" data-i18n="sec2_title">256-bit</h4>
                <p class="text-sm text-slate-400" data-i18n="sec2_desc">AES-256 шифрование данных</p>
            </div>

            <div class="scroll-reveal glass rounded-2xl p-6 card-hover text-center" style="transition-delay: 0.2s">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/20 to-pink-500/20 border border-purple-500/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-white mb-2" data-i18n="sec3_title">Hashing</h4>
                <p class="text-sm text-slate-400" data-i18n="sec3_desc">bcrypt хеширование паролей</p>
            </div>

            <div class="scroll-reveal glass rounded-2xl p-6 card-hover text-center" style="transition-delay: 0.3s">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500/20 to-orange-500/20 border border-amber-500/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-white mb-2" data-i18n="sec4_title">Audit Log</h4>
                <p class="text-sm text-slate-400" data-i18n="sec4_desc">Полный журнал действий пользователей</p>
            </div>
        </div>

        <!-- Security Detail Block -->
        <div class="scroll-reveal mt-16 glass-strong rounded-3xl p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-4" data-i18n="security_detail_title">
                        Защита на каждом уровне
                    </h3>
                    <p class="text-slate-400 mb-6" data-i18n="security_detail_desc">
                        Защищённая система аутентификации и авторизации с разделением ролей. Каждый документ проходит многоуровневую проверку.
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-sm text-slate-300" data-i18n="sec_check1">CSRF защита на всех формах</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-sm text-slate-300" data-i18n="sec_check2">XSS и SQL Injection защита</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-sm text-slate-300" data-i18n="sec_check3">Rate limiting и брутфорс защита</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-sm text-slate-300" data-i18n="sec_check4">Резервное копирование данных</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="code-block rounded-2xl p-6 text-sm font-mono">
                        <div class="text-slate-500 mb-2">// 🔐 Security Middleware</div>
                        <div><span class="text-purple-400">class</span> <span class="text-cyan-400">SecurityMiddleware</span></div>
                        <div><span class="text-slate-500">{</span></div>
                        <div class="pl-4"><span class="text-purple-400">public function</span> <span class="text-blue-400">handle</span><span class="text-slate-500">(</span><span class="text-orange-400">$request</span><span class="text-slate-500">,</span> <span class="text-orange-400">$next</span><span class="text-slate-500">)</span></div>
                        <div class="pl-4"><span class="text-slate-500">{</span></div>
                        <div class="pl-8"><span class="text-green-400">// Verify CSRF token</span></div>
                        <div class="pl-8"><span class="text-green-400">// Check rate limits</span></div>
                        <div class="pl-8"><span class="text-green-400">// Validate roles</span></div>
                        <div class="pl-8"><span class="text-purple-400">return</span> <span class="text-orange-400">$next</span><span class="text-slate-500">(</span><span class="text-orange-400">$request</span><span class="text-slate-500">);</span></div>
                        <div class="pl-4"><span class="text-slate-500">}</span></div>
                        <div><span class="text-slate-500">}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AI Section -->
<section id="ai" class="relative py-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-amber-950/10 to-transparent"></div>
    <div class="orb w-[400px] h-[400px] bg-amber-600/20 top-0 right-0 blur-[120px]"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20 scroll-reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-amber-400 uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-amber-400"></span>
                <span data-i18n="ai_label">AI Анализ</span>
                <span class="w-8 h-px bg-amber-400"></span>
            </span>
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-black text-white mb-6" data-i18n="ai_title">
                Intelligent Analysis
            </h2>
            <p class="max-w-2xl mx-auto text-lg text-slate-400" data-i18n="ai_subtitle">
                AI помогает анализировать данные, автоматизировать процессы и выводить информацию в удобном виде
            </p>
        </div>

        <!-- AI Dashboard Preview -->
        <div class="scroll-reveal glass-strong rounded-3xl overflow-hidden shadow-2xl shadow-blue-500/10">
            <!-- Dashboard Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-700/50">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-amber-400 animate-pulse"></div>
                    <span class="text-sm font-semibold text-white" data-i18n="ai_dashboard">Панель AI-анализа</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20" data-i18n="ai_active">Активен</span>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="p-6 md:p-8">
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-slate-800/50 rounded-2xl p-5 border border-slate-700/50">
                        <div class="text-xs text-slate-500 mb-2" data-i18n="ai_metric1">Обработано документов</div>
                        <div class="text-3xl font-black text-white">12,847</div>
                        <div class="flex items-center gap-1 mt-2">
                            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                            <span class="text-xs text-green-400 font-medium">+23.5%</span>
                        </div>
                    </div>
                    <div class="bg-slate-800/50 rounded-2xl p-5 border border-slate-700/50">
                        <div class="text-xs text-slate-500 mb-2" data-i18n="ai_metric2">Точность анализа</div>
                        <div class="text-3xl font-black gradient-text-warm">94.7%</div>
                        <div class="flex items-center gap-1 mt-2">
                            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                            <span class="text-xs text-green-400 font-medium">+2.1%</span>
                        </div>
                    </div>
                    <div class="bg-slate-800/50 rounded-2xl p-5 border border-slate-700/50">
                        <div class="text-xs text-slate-500 mb-2" data-i18n="ai_metric3">Время обработки</div>
                        <div class="text-3xl font-black text-white">0.3<span class="text-lg text-slate-400">s</span></div>
                        <div class="flex items-center gap-1 mt-2">
                            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                            <span class="text-xs text-green-400 font-medium">-15.2%</span>
                        </div>
                    </div>
                </div>

                <!-- Chart Visualization -->
                <div class="bg-slate-800/30 rounded-2xl p-6 border border-slate-700/50">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-sm font-semibold text-white" data-i18n="ai_chart_title">Аналитика за 7 дней</h4>
                        <div class="flex items-center gap-4 text-xs">
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-400"></span> <span data-i18n="ai_chart_docs">Документы</span></span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-400"></span> <span data-i18n="ai_chart_signs">Подписи</span></span>
                        </div>
                    </div>
                    <div class="flex items-end gap-2 h-40">
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full bg-blue-500/30 rounded-t-md relative" style="height: 60%">
                                <div class="absolute bottom-0 w-full bg-blue-500/60 rounded-t-md" style="height: 70%"></div>
                            </div>
                            <div class="w-full bg-amber-500/20 rounded-t-md" style="height: 40%"></div>
                            <span class="text-[10px] text-slate-500">Пн</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full bg-blue-500/30 rounded-t-md relative" style="height: 75%">
                                <div class="absolute bottom-0 w-full bg-blue-500/60 rounded-t-md" style="height: 65%"></div>
                            </div>
                            <div class="w-full bg-amber-500/20 rounded-t-md" style="height: 50%"></div>
                            <span class="text-[10px] text-slate-500">Вт</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full bg-blue-500/30 rounded-t-md relative" style="height: 85%">
                                <div class="absolute bottom-0 w-full bg-blue-500/60 rounded-t-md" style="height: 80%"></div>
                            </div>
                            <div class="w-full bg-amber-500/20 rounded-t-md" style="height: 60%"></div>
                            <span class="text-[10px] text-slate-500">Ср</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full bg-blue-500/30 rounded-t-md relative" style="height: 65%">
                                <div class="absolute bottom-0 w-full bg-blue-500/60 rounded-t-md" style="height: 55%"></div>
                            </div>
                            <div class="w-full bg-amber-500/20 rounded-t-md" style="height: 45%"></div>
                            <span class="text-[10px] text-slate-500">Чт</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full bg-blue-500/30 rounded-t-md relative" style="height: 95%">
                                <div class="absolute bottom-0 w-full bg-blue-500/60 rounded-t-md" style="height: 90%"></div>
                            </div>
                            <div class="w-full bg-amber-500/20 rounded-t-md" style="height: 70%"></div>
                            <span class="text-[10px] text-slate-500">Пт</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full bg-blue-500/30 rounded-t-md relative" style="height: 50%">
                                <div class="absolute bottom-0 w-full bg-blue-500/60 rounded-t-md" style="height: 40%"></div>
                            </div>
                            <div class="w-full bg-amber-500/20 rounded-t-md" style="height: 30%"></div>
                            <span class="text-[10px] text-slate-500">Сб</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full bg-blue-500/30 rounded-t-md relative" style="height: 40%">
                                <div class="absolute bottom-0 w-full bg-blue-500/60 rounded-t-md" style="height: 35%"></div>
                            </div>
                            <div class="w-full bg-amber-500/20 rounded-t-md" style="height: 25%"></div>
                            <span class="text-[10px] text-slate-500">Вс</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact / CTA Section -->
<section id="contact" class="relative py-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-950/20 to-transparent"></div>
    <div class="orb w-[500px] h-[500px] bg-blue-600/20 bottom-0 left-1/2 -translate-x-1/2 blur-[120px]"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-reveal">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-blue-400 uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-blue-400"></span>
                <span data-i18n="contact_label">Начать</span>
                <span class="w-8 h-px bg-blue-400"></span>
            </span>
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-black text-white mb-6" data-i18n="contact_title">
                Готовы начать?
            </h2>
            <p class="max-w-2xl mx-auto text-lg text-slate-400" data-i18n="contact_subtitle">
                Присоединяйтесь к тысячам компаний, которые уже используют DocSign
            </p>
        </div>

        <div class="max-w-lg mx-auto scroll-reveal">

    </div>
</section>

<!-- Footer -->
<footer class="relative border-t border-slate-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div class="md:col-span-2">
                <a href="#" class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Doc<span class="gradient-text">Sign</span></span>
                </a>
                <p class="text-sm text-slate-400 max-w-sm" data-i18n="footer_desc">
                    Интеллектуальная платформа электронного документооборота для бизнеса Таджикистана.
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <a href="#" class="w-10 h-10 rounded-xl glass flex items-center justify-center text-slate-400 hover:text-white hover:border-blue-500/30 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl glass flex items-center justify-center text-slate-400 hover:text-white hover:border-blue-500/30 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 2.614.102.781.209 1.494.328 2.037.328.544 0 1.256-.117 2.037-.328 1.606-.424 2.614-.102 2.614-.102.652 1.652.241 2.873.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl glass flex items-center justify-center text-slate-400 hover:text-white hover:border-blue-500/30 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white mb-4" data-i18n="footer_product">Продукт</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="#features" class="hover:text-blue-400 transition-colors" data-i18n="footer_features">Возможности</a></li>
                    <li><a href="#security" class="hover:text-blue-400 transition-colors" data-i18n="footer_security">Безопасность</a></li>
                    <li><a href="#ai" class="hover:text-blue-400 transition-colors" data-i18n="footer_ai">AI Анализ</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors" data-i18n="footer_pricing">Цены</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white mb-4" data-i18n="footer_company">Компания</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-blue-400 transition-colors" data-i18n="footer_about">О нас</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors" data-i18n="footer_careers">Карьера</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors" data-i18n="footer_blog">Блог</a></li>
                    <li><a href="#contact" class="hover:text-blue-400 transition-colors" data-i18n="footer_contact">Контакты</a></li>
                </ul>
            </div>
        </div>
        <div class="line-glow mb-8"></div>
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <span>© 2024 DocSign. <span data-i18n="footer_rights">Все права защищены.</span></span>
            <span class="flex items-center gap-2">
                <span class="text-base">🇹🇯</span>
                <span data-i18n="footer_made">Сделано в Таджикистане</span>
            </span>
        </div>
    </div>
</footer>

<!-- Back to Top -->
<button id="backToTop" class="fixed bottom-6 right-6 z-50 w-12 h-12 rounded-xl glass flex items-center justify-center text-slate-400 hover:text-white hover:border-blue-500/30 transition-all opacity-0 translate-y-4 pointer-events-none" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
</button>

<script>
    // Translations
    const translations = {
        ru: {
            nav_features: "Возможности",
            nav_tech: "Технологии",
            nav_security: "Безопасность",
            nav_ai: "AI Анализ",
            nav_contact: "Контакты",
            nav_start: "Начать",
            hero_badge: "Система ЭДО нового поколения",
            hero_title_1: "Документы.",
            hero_title_2: "Подписаны.",
            hero_title_3: "Мгновенно.",
            hero_subtitle: "DocSign — интеллектуальная платформа электронного документооборота с AI-аналитикой, цифровой подписью и абсолютной безопасностью. Создано для бизнеса Таджикистана.",
            hero_cta_primary: "Попробовать бесплатно",
            hero_cta_secondary: "Смотреть демо",
            stat_uptime: "% Uptime",
            stat_docs: "Документов/день",
            stat_encryption: "Шифрование",
            stat_response: "Время ответа",
            features_label: "Возможности",
            features_title: "Всё. Что вам нужно.",
            features_subtitle: "Каждая деталь спроектирована для максимальной эффективности вашего документооборота",
            f1_title: "Электронная подпись",
            f1_desc: "FPDI библиотека физически «вшивает» изображение подписи в оригинальный PDF. Каждая подпись привязана к конкретному файлу.",
            f2_title: "Управление ролями",
            f2_desc: "Гибкая система аутентификации и авторизации с разделением ролей. Администраторы, менеджеры, пользователи — полный контроль доступа.",
            f3_title: "MySQL Архитектура",
            f3_desc: "Четкая структура связей (foreign keys) между пользователями, документами и логами. Миграции через php artisan.",
            f4_title: "AI Intelligent Analysis",
            f4_desc: "Интеллектуальные алгоритмы анализируют данные, автоматизируют рутинные процессы и выводят информацию в удобном визуальном виде.",
            f4_accuracy: "Точность анализа",
            f5_title: "Управление файлами",
            f5_desc: "Логика загрузки, хранения и вывода документов. Поддержка облачного хранения с перспективой масштабирования.",
            f6_title: "Perfect Dark Mode",
            f6_desc: "Глубокая настройка тёмной темы — таблицы, модальные окна и шрифты меняют цвета так, чтобы глаза не уставали.",
            f6_palette: "Цветовая палитра",
            tech_label: "Технологии",
            tech_title: "Под капотом",
            tech_subtitle: "Мощный стек технологий, обеспечивающий скорость, надёжность и масштабируемость",
            tech_laravel: "Последняя версия PHP-фреймворка. Высокая скорость, безопасность и элегантный синтаксис.",
            tech_mysql: "Надёжная СУБД с foreign keys, индексами и оптимизированными запросами для больших данных.",
            tech_ui: "Гибридный дизайн: мощь Tailwind для верстки и компоненты Bootstrap для быстрой разработки.",
            tech_pdf: "Физическая вшивка подписи в PDF-файл. Цифровой след привязан к каждому документу.",
            security_label: "Безопасность",
            security_title: "Абсолютная защита",
            security_subtitle: "Многоуровневая система безопасности для защиты ваших документов и данных",
            sec1_title: "SSL/TLS",
            sec1_desc: "Шифрование всех данных при передаче",
            sec2_title: "256-bit",
            sec2_desc: "AES-256 шифрование данных",
            sec3_title: "Hashing",
            sec3_desc: "bcrypt хеширование паролей",
            sec4_title: "Audit Log",
            sec4_desc: "Полный журнал действий пользователей",
            security_detail_title: "Защита на каждом уровне",
            security_detail_desc: "Защищённая система аутентификации и авторизации с разделением ролей. Каждый документ проходит многоуровневую проверку.",
            sec_check1: "CSRF защита на всех формах",
            sec_check2: "XSS и SQL Injection защита",
            sec_check3: "Rate limiting и брутфорс защита",
            sec_check4: "Резервное копирование данных",
            ai_label: "AI Анализ",
            ai_title: "Intelligent Analysis",
            ai_subtitle: "AI помогает анализировать данные, автоматизировать процессы и выводить информацию в удобном виде",
            ai_dashboard: "Панель AI-анализа",
            ai_active: "Активен",
            ai_metric1: "Обработано документов",
            ai_metric2: "Точность анализа",
            ai_metric3: "Время обработки",
            ai_chart_title: "Аналитика за 7 дней",
            ai_chart_docs: "Документы",
            ai_chart_signs: "Подписи",
            contact_label: "Начать",
            contact_title: "Готовы начать?",
            contact_subtitle: "Присоединяйтесь к тысячам компаний, которые уже используют DocSign",
            form_name: "Имя",
            form_name_ph: "Ваше имя",
            form_email: "Email",
            form_phone: "Телефон",
            form_company: "Компания",
            form_company_ph: "Название компании",
            form_submit: "Отправить заявку",
            form_success_title: "Заявка отправлена!",
            form_success_desc: "Мы свяжемся с вами в ближайшее время",
            footer_desc: "Интеллектуальная платформа электронного документооборота для бизнеса Таджикистана.",
            footer_product: "Продукт",
            footer_features: "Возможности",
            footer_security: "Безопасность",
            footer_ai: "AI Анализ",
            footer_pricing: "Цены",
            footer_company: "Компания",
            footer_about: "О нас",
            footer_careers: "Карьера",
            footer_blog: "Блог",
            footer_contact: "Контакты",
            footer_rights: "Все права защищены.",
            footer_made: "Сделано в Таджикистане"
        },
        en: {
            nav_features: "Features",
            nav_tech: "Technology",
            nav_security: "Security",
            nav_ai: "AI Analysis",
            nav_contact: "Contact",
            nav_start: "Get Started",
            hero_badge: "Next-generation EDMS",
            hero_title_1: "Documents.",
            hero_title_2: "Signed.",
            hero_title_3: "Instantly.",
            hero_subtitle: "DocSign — an intelligent electronic document management platform with AI analytics, digital signatures, and absolute security. Built for Tajikistan businesses.",
            hero_cta_primary: "Try for Free",
            hero_cta_secondary: "Watch Demo",
            stat_uptime: "% Uptime",
            stat_docs: "Documents/day",
            stat_encryption: "Encryption",
            stat_response: "Response time",
            features_label: "Features",
            features_title: "Everything. You need.",
            features_subtitle: "Every detail is designed for maximum efficiency of your document workflow",
            f1_title: "Digital Signature",
            f1_desc: "FPDI library physically 'stitches' the signature image into the original PDF. Each signature is bound to a specific file.",
            f2_title: "Role Management",
            f2_desc: "Flexible authentication and authorization system with role separation. Administrators, managers, users — full access control.",
            f3_title: "MySQL Architecture",
            f3_desc: "Clear relationship structure (foreign keys) between users, documents and logs. Migrations via php artisan.",
            f4_title: "AI Intelligent Analysis",
            f4_desc: "Intelligent algorithms analyze data, automate routine processes and display information in a convenient visual format.",
            f4_accuracy: "Analysis accuracy",
            f5_title: "File Management",
            f5_desc: "Document upload, storage and display logic. Cloud storage support with scalability prospects.",
            f6_title: "Perfect Dark Mode",
            f6_desc: "Deep dark theme configuration — tables, modals and fonts change colors so your eyes don't get tired.",
            f6_palette: "Color palette",
            tech_label: "Technology",
            tech_title: "Under the Hood",
            tech_subtitle: "A powerful technology stack ensuring speed, reliability and scalability",
            tech_laravel: "Latest PHP framework version. High speed, security and elegant syntax.",
            tech_mysql: "Reliable DBMS with foreign keys, indexes and optimized queries for big data.",
            tech_ui: "Hybrid design: Tailwind power for layout and Bootstrap components for rapid development.",
            tech_pdf: "Physical signature injection into PDF files. Digital trace bound to every document.",
            security_label: "Security",
            security_title: "Absolute Protection",
            security_subtitle: "Multi-level security system to protect your documents and data",
            sec1_title: "SSL/TLS",
            sec1_desc: "All data encrypted in transit",
            sec2_title: "256-bit",
            sec2_desc: "AES-256 data encryption",
            sec3_title: "Hashing",
            sec3_desc: "bcrypt password hashing",
            sec4_title: "Audit Log",
            sec4_desc: "Complete user activity journal",
            security_detail_title: "Protection at Every Level",
            security_detail_desc: "Protected authentication and authorization system with role separation. Every document passes multi-level verification.",
            sec_check1: "CSRF protection on all forms",
            sec_check2: "XSS and SQL Injection protection",
            sec_check3: "Rate limiting and brute force protection",
            sec_check4: "Data backup",
            ai_label: "AI Analysis",
            ai_title: "Intelligent Analysis",
            ai_subtitle: "AI helps analyze data, automate processes and display information conveniently",
            ai_dashboard: "AI Analysis Panel",
            ai_active: "Active",
            ai_metric1: "Processed documents",
            ai_metric2: "Analysis accuracy",
            ai_metric3: "Processing time",
            ai_chart_title: "7-day analytics",
            ai_chart_docs: "Documents",
            ai_chart_signs: "Signatures",
            contact_label: "Get Started",
            contact_title: "Ready to Start?",
            contact_subtitle: "Join thousands of companies already using DocSign",
            form_name: "Name",
            form_name_ph: "Your name",
            form_email: "Email",
            form_phone: "Phone",
            form_company: "Company",
            form_company_ph: "Company name",
            form_submit: "Submit Request",
            form_success_title: "Request Sent!",
            form_success_desc: "We will contact you shortly",
            footer_desc: "Intelligent electronic document management platform for Tajikistan businesses.",
            footer_product: "Product",
            footer_features: "Features",
            footer_security: "Security",
            footer_ai: "AI Analysis",
            footer_pricing: "Pricing",
            footer_company: "Company",
            footer_about: "About Us",
            footer_careers: "Careers",
            footer_blog: "Blog",
            footer_contact: "Contact",
            footer_rights: "All rights reserved.",
            footer_made: "Made in Tajikistan"
        },
        tj: {
            nav_features: "Имкониятҳо",
            nav_tech: "Технологияҳо",
            nav_security: "Амният",
            nav_ai: "Таҳлили AI",
            nav_contact: "Тамос",
            nav_start: "Оғоз",
            hero_badge: "Системаи ЭДО-и насли нав",
            hero_title_1: "Ҳуҷҷатҳо.",
            hero_title_2: "Имзошуда.",
            hero_title_3: "Фавран.",
            hero_subtitle: "DocSign — платформаи интеллектуалии идоракунии электронии ҳуҷҷатҳо бо таҳлили AI, имзои рақамӣ ва амнияти мутлақ. Барои бизнеси Тоҷикистон сохта шудааст.",
            hero_cta_primary: "Ройгон санҷед",
            hero_cta_secondary: "Демо тамошо кунед",
            stat_uptime: "% Uptime",
            stat_docs: "Ҳуҷҷатҳо/рӯз",
            stat_encryption: "Рамзгузорӣ",
            stat_response: "Вақти ҷавоб",
            features_label: "Имкониятҳо",
            features_title: "Ҳама. Чӣ ки лозим.",
            features_subtitle: "Ҳар як тафсилот барои самаранокии максималии ҳуҷҷатгузории шумо тарҳрезӣ шудааст",
            f1_title: "Имзои электронӣ",
            f1_desc: "Китобхонаи FPDI тасвири имзоро физикан ба PDF-и аслӣ «медӯзад». Ҳар як имзо ба файли мушаххас вобаста аст.",
            f2_title: "Идоракунии нақшҳо",
            f2_desc: "Системаи чандири аутентификатсия ва авторизатсия бо ҷудокунии нақшҳо. Администраторҳо, менеджерҳо, корбарон — назорати пурраи дастрасӣ.",
            f3_title: "Архитектураи MySQL",
            f3_desc: "Сохтори равшани робитаҳо (foreign keys) байни корбарон, ҳуҷҷатҳо ва логҳо. Мигратсияҳо тавассути php artisan.",
            f4_title: "Таҳлили AI Intelligent",
            f4_desc: "Алгоритмҳои интеллектуалӣ маълумотро таҳлил мекунанд, равандҳои рутиниро автоматизатсия мекунанд ва маълумотро дар шакли визуалии қулай нишон медиҳанд.",
            f4_accuracy: "Дақиқии таҳлил",
            f5_title: "Идоракунии файлҳо",
            f5_desc: "Мантиқи боркунӣ, нигоҳдорӣ ва намоиши ҳуҷҷатҳо. Дастгирии нигоҳдории абрӣ бо имконияти миқёсгузорӣ.",
            f6_title: "Ҳолати торик",
            f6_desc: "Танзими амиқи мавзӯи торик — ҷадвалҳо, тирезаҳои модалӣ ва шрифтҳо рангҳоро иваз мекунанд, то чашмон хаста нашаванд.",
            f6_palette: "Палитраи рангҳо",
            tech_label: "Технологияҳо",
            tech_title: "Дар зери капот",
            tech_subtitle: "Стеки пурқуввати технологияҳо, ки суръат, эътимоднокӣ ва миқёсгузориро таъмин мекунад",
            tech_laravel: "Охирин версияи чаҳорчӯбаи PHP. Суръати баланд, амният ва синтаксиси элегантӣ.",
            tech_mysql: "СУБД-и боэътимод бо foreign keys, индексҳо ва дархостҳои оптимизатсияшуда барои маълумоти калон.",
            tech_ui: "Тарҳи гибридӣ: қудрати Tailwind барои верстка ва компонентҳои Bootstrap барои рушди тез.",
            tech_pdf: "Воридкунии физикии имзо ба файлҳои PDF. Редди рақамӣ ба ҳар як ҳуҷҷат вобаста аст.",
            security_label: "Амният",
            security_title: "Ҳимояи мутлақ",
            security_subtitle: "Системаи амнияти бисёрсатҳа барои ҳифзи ҳуҷҷатҳо ва маълумоти шумо",
            sec1_title: "SSL/TLS",
            sec1_desc: "Рамзгузории ҳамаи маълумотҳо ҳангоми интиқол",
            sec2_title: "256-bit",
            sec2_desc: "Рамзгузории маълумотҳо AES-256",
            sec3_title: "Hashing",
            sec3_desc: "Рамзгузории bcrypt барои паролҳо",
            sec4_title: "Audit Log",
            sec4_desc: "Журнали пурраи фаъолияти корбарон",
            security_detail_title: "Ҳимоя дар ҳар сатҳ",
            security_detail_desc: "Системаи ҳифзшудаи аутентификатсия ва авторизатсия бо ҷудокунии нақшҳо. Ҳар як ҳуҷҷат аз санҷиши бисёрсатҳа мегузарад.",
            sec_check1: "Ҳимояи CSRF дар ҳамаи формаҳо",
            sec_check2: "Ҳимояи XSS ва SQL Injection",
            sec_check3: "Rate limiting ва ҳимояи brute force",
            sec_check4: "Нусхабардории маълумотҳо",
            ai_label: "Таҳлили AI",
            ai_title: "Intelligent Analysis",
            ai_subtitle: "AI кӯмак мекунад, ки маълумотҳоро таҳлил кунед, равандҳоро автоматизатсия кунед ва маълумотро дар шакли қулай нишон диҳед",
            ai_dashboard: "Панели таҳлили AI",
            ai_active: "Фаъол",
            ai_metric1: "Ҳуҷҷатҳои коркардшуда",
            ai_metric2: "Дақиқии таҳлил",
            ai_metric3: "Вақти коркард",
            ai_chart_title: "Таҳлили 7 рӯз",
            ai_chart_docs: "Ҳуҷҷатҳо",
            ai_chart_signs: "Имзоҳо",
            contact_label: "Оғоз",
            contact_title: "Омодаед оғоз кунед?",
            contact_subtitle: "Ба ҳазорҳо ширкатҳо ҳамроҳ шавед, ки аллакай DocSign-ро истифода мебаранд",
            form_name: "Ном",
            form_name_ph: "Номи шумо",
            form_email: "Email",
            form_phone: "Телефон",
            form_company: "Ширкат",
            form_company_ph: "Номи ширкат",
            form_submit: "Фиристодани дархост",
            form_success_title: "Дархост фиристода шуд!",
            form_success_desc: "Мо бо шумо дар наздиктарин вақт тамос мегирем",
            footer_desc: "Платформаи интеллектуалии идоракунии электронии ҳуҷҷатҳо барои бизнеси Тоҷикистон.",
            footer_product: "Маҳсулот",
            footer_features: "Имкониятҳо",
            footer_security: "Амният",
            footer_ai: "Таҳлили AI",
            footer_pricing: "Нархҳо",
            footer_company: "Ширкат",
            footer_about: "Дар бораи мо",
            footer_careers: "Касб",
            footer_blog: "Блог",
            footer_contact: "Тамос",
            footer_rights: "Ҳамаи ҳуқуқҳо ҳифз шудаанд.",
            footer_made: "Дар Тоҷикистон сохта шудааст"
        }
    };

    // Language Switcher
    let currentLang = 'ru';

    function setLanguage(lang) {
        currentLang = lang;
        const t = translations[lang];

        // Update all elements with data-i18n
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key]) {
                el.textContent = t[key];
            }
        });

        // Update placeholders
        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (t[key]) {
                el.placeholder = t[key];
            }
        });

        // Update active button
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.lang === lang);
        });

        // Update HTML lang
        document.documentElement.lang = lang;
    }

    // Language button clicks
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            setLanguage(btn.dataset.lang);
        });
    });

    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('glass-strong', 'shadow-lg', 'shadow-black/20');
        } else {
            navbar.classList.remove('glass-strong', 'shadow-lg', 'shadow-black/20');
        }
    });

    // Mobile menu
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu on link click
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    });

    // Scroll Reveal
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });

    // Counter Animation
    function animateCounter(el, target, duration = 2000) {
        const start = 0;
        const startTime = performance.now();
        const isDecimal = String(target).includes('.');

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = start + (target - start) * easeOut;

            if (isDecimal) {
                el.textContent = current.toFixed(1);
            } else {
                el.textContent = Math.floor(current);
            }

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    // Observe counters
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseFloat(entry.target.dataset.target);
                if (!isNaN(target)) {
                    animateCounter(entry.target, target);
                }
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.counter').forEach(el => {
        counterObserver.observe(el);
    });

    // Back to Top Button
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 500) {
            backToTop.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
            backToTop.classList.add('opacity-100', 'translate-y-0');
        } else {
            backToTop.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
            backToTop.classList.remove('opacity-100', 'translate-y-0');
        }
    });

    // Phone Input Formatting
    const phoneInput = document.getElementById('phoneInput');
    phoneInput.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 9) value = value.slice(0, 9);

        let formatted = '';
        if (value.length > 0) {
            formatted = value.slice(0, 2);
        }
        if (value.length > 2) {
            formatted += ' ' + value.slice(2, 5);
        }
        if (value.length > 5) {
            formatted += ' ' + value.slice(5, 7);
        }
        if (value.length > 7) {
            formatted += ' ' + value.slice(7, 9);
        }

        e.target.value = formatted;
    });

    // Form Submit
    const contactForm = document.getElementById('contactForm');
    const successMsg = document.getElementById('successMsg');

    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Animate button
        const btn = contactForm.querySelector('button[type="submit"]');
        btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        btn.disabled = true;

        setTimeout(() => {
            contactForm.classList.add('hidden');
            successMsg.classList.remove('hidden');
        }, 1500);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Parallax effect on mouse move (hero section)
    const hero = document.getElementById('hero');
    hero.addEventListener('mousemove', (e) => {
        const orbs = hero.querySelectorAll('.orb');
        const x = (e.clientX / window.innerWidth - 0.5) * 2;
        const y = (e.clientY / window.innerHeight - 0.5) * 2;

        orbs.forEach((orb, i) => {
            const speed = (i + 1) * 10;
            orb.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
        });
    });

    // Typing effect for hero subtitle (optional enhancement)
    document.addEventListener('DOMContentLoaded', () => {
        // Initial load - set Russian as default
        setLanguage('ru');
    });
</script>

</body>
</html>

