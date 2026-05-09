<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DocSign — Восстановление пароля</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #818cf8;
            --accent: #06b6d4;
            --bg-dark: #0f172a;
            --bg-card: rgba(15, 23, 42, 0.6);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: rgba(148, 163, 184, 0.15);
            --glow: rgba(79, 70, 229, 0.4);
        }

        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-dark);
            overflow: hidden;
            position: relative;
        }

        .bg-animation {
            position: fixed; inset: 0; z-index: 0; overflow: hidden;
        }
        .bg-animation::before {
            content: ''; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(6, 182, 212, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            animation: bgShift 15s ease-in-out infinite alternate;
        }
        @keyframes bgShift {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-5%, -5%) rotate(3deg); }
        }

        .particles { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
        .particle {
            position: absolute; width: 3px; height: 3px;
            background: rgba(129, 140, 248, 0.5); border-radius: 50%;
            animation: float linear infinite;
        }
        @keyframes float {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; } 90% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        .grid-overlay {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 20s linear infinite;
        }
        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(60px, 60px); }
        }

        .container {
            position: relative; z-index: 10;
            width: 100%; max-width: 480px; padding: 20px;
        }

        .lang-switcher {
            position: fixed; top: 20px; right: 20px; z-index: 100;
            display: flex; background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px); border: 1px solid var(--border);
            border-radius: 12px; padding: 4px; gap: 2px;
        }
        .lang-btn {
            padding: 8px 14px; border: none; background: transparent;
            color: var(--text-secondary); font-family: 'Figtree', sans-serif;
            font-size: 13px; font-weight: 600; border-radius: 8px;
            cursor: pointer; transition: all 0.3s ease; letter-spacing: 0.5px;
        }
        .lang-btn:hover { color: var(--text-primary); background: rgba(79, 70, 229, 0.15); }
        .lang-btn.active { background: var(--primary); color: white; box-shadow: 0 2px 10px var(--glow); }

        .reset-card {
            background: var(--bg-card); backdrop-filter: blur(40px);
            border: 1px solid var(--border); border-radius: 24px;
            padding: 48px 40px; position: relative; overflow: hidden;
            animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            box-shadow: 0 0 0 1px rgba(148, 163, 184, 0.05), 0 25px 80px rgba(0, 0, 0, 0.4), 0 0 120px rgba(79, 70, 229, 0.08);
        }
        @keyframes cardAppear {
            0% { opacity: 0; transform: translateY(30px) scale(0.96); filter: blur(10px); }
            100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }
        .reset-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #f59e0b, var(--primary), var(--accent));
            background-size: 200% 100%; animation: shimmer 3s ease-in-out infinite;
        }
        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; }
        }
        .reset-card::after {
            content: ''; position: absolute; top: -1px; left: -1px; right: -1px; bottom: -1px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), transparent 40%, transparent 60%, rgba(79, 70, 229, 0.1));
            z-index: -1; pointer-events: none;
        }

        .logo-section { text-align: center; margin-bottom: 32px; animation: logoAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both; }
        @keyframes logoAppear { 0% { opacity: 0; transform: translateY(15px); } 100% { opacity: 1; transform: translateY(0); } }
        .logo-img {
            width: 80px; height: 80px; border-radius: 20px; margin: 0 auto 16px; display: block;
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.25); transition: transform 0.3s ease;
        }
        .logo-img:hover { transform: scale(1.05) rotate(2deg); }
        .logo-title { font-size: 28px; font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; margin-bottom: 4px; }
        .logo-title span { background: linear-gradient(135deg, #f59e0b, var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .logo-subtitle { font-size: 12px; font-weight: 500; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 2px; }

        .info-banner {
            display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px;
            background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.15);
            border-radius: 12px; margin-bottom: 24px; animation: formAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.25s both;
        }
        .info-banner svg { width: 18px; height: 18px; color: #f59e0b; flex-shrink: 0; margin-top: 1px; }
        .info-banner p { font-size: 13px; color: var(--text-secondary); line-height: 1.5; }

        .session-status {
            padding: 12px 16px; border-radius: 12px; margin-bottom: 20px;
            font-size: 13px; font-weight: 600; text-align: center;
            animation: formAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
        }
        .session-status.success { background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.25); color: #34d399; }

        .form-group { margin-bottom: 20px; animation: formAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .form-group:nth-child(1) { animation-delay: 0.35s; }
        @keyframes formAppear { 0% { opacity: 0; transform: translateX(-15px); } 100% { opacity: 1; transform: translateX(0); } }

        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 8px; letter-spacing: 0.3px; }
        .input-wrapper { position: relative; }
        .input-icon {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            width: 20px; height: 20px; color: var(--text-secondary);
            transition: color 0.3s ease; pointer-events: none; z-index: 2;
        }
        .form-input {
            width: 100%; padding: 14px 16px 14px 48px; background: rgba(30, 41, 59, 0.5);
            border: 1px solid var(--border); border-radius: 14px; color: var(--text-primary);
            font-family: 'Figtree', sans-serif; font-size: 15px; font-weight: 500;
            transition: all 0.3s ease; outline: none;
        }
        .form-input::placeholder { color: rgba(148, 163, 184, 0.4); }
        .form-input:focus {
            border-color: var(--accent); background: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.15), 0 0 20px rgba(6, 182, 212, 0.1);
        }
        .form-input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px rgba(30, 41, 59, 0.9) inset !important;
            -webkit-text-fill-color: var(--text-primary) !important; caret-color: var(--text-primary);
        }
        .form-input.error { border-color: #ef4444; box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15); }
        .error-message { font-size: 12px; color: #ef4444; margin-top: 6px; font-weight: 500; }

        .submit-btn {
            width: 100%; padding: 16px; background: linear-gradient(135deg, #f59e0b, var(--primary));
            border: none; border-radius: 14px; color: white; font-family: 'Figtree', sans-serif;
            font-size: 15px; font-weight: 700; cursor: pointer; position: relative;
            overflow: hidden; transition: all 0.3s ease; letter-spacing: 0.3px;
            animation: formAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.5s both;
        }
        .submit-btn::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, var(--accent), var(--primary-light));
            opacity: 0; transition: opacity 0.3s ease;
        }
        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(245, 158, 11, 0.25), 0 0 40px rgba(79, 70, 229, 0.15); }
        .submit-btn:hover::before { opacity: 1; }
        .submit-btn:active { transform: translateY(0); }
        .submit-btn .btn-text { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .submit-btn .btn-arrow { transition: transform 0.3s ease; }
        .submit-btn:hover .btn-arrow { transform: translateX(4px); }
        .submit-btn.loading .btn-text { opacity: 0; }
        .submit-btn.loading::after {
            content: ''; position: absolute; width: 24px; height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3); border-top-color: white;
            border-radius: 50%; animation: spin 0.8s linear infinite;
            top: 50%; left: 50%; margin: -12px 0 0 -12px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .back-link-section { text-align: center; margin-top: 24px; animation: formAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.6s both; }
        .back-link {
            font-size: 14px; color: var(--text-secondary); text-decoration: none;
            font-weight: 500; transition: all 0.2s ease; display: inline-flex;
            align-items: center; gap: 6px;
        }
        .back-link svg { width: 16px; height: 16px; transition: transform 0.3s ease; }
        .back-link:hover { color: var(--accent); }
        .back-link:hover svg { transform: translateX(-4px); }

        .footer-badges {
            display: flex; justify-content: center; gap: 24px; margin-top: 32px;
            animation: footerAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.8s both;
        }
        @keyframes footerAppear { 0% { opacity: 0; transform: translateY(10px); } 100% { opacity: 1; transform: translateY(0); } }
        .badge { display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; color: var(--text-secondary); opacity: 0.7; }
        .badge svg { width: 14px; height: 14px; color: #f59e0b; }
        .copyright { text-align: center; margin-top: 20px; font-size: 12px; color: rgba(148, 163, 184, 0.4); font-weight: 500; animation: footerAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.9s both; }

        .notification {
            position: fixed; top: 20px; left: 50%; transform: translateX(-50%) translateY(-100px);
            padding: 14px 24px; border-radius: 12px; font-size: 14px; font-weight: 600;
            z-index: 1000; transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            backdrop-filter: blur(20px);
        }
        .notification.show { transform: translateX(-50%) translateY(0); }
        .notification.success { background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; }
        .notification.error { background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; }

        @media (max-width: 520px) {
            .container { padding: 16px; }
            .reset-card { padding: 36px 24px; border-radius: 20px; }
            .logo-title { font-size: 24px; }
            .lang-switcher { top: 12px; right: 12px; }
            .lang-btn { padding: 6px 10px; font-size: 12px; }
        }
    </style>
</head>
<body>
<div class="bg-animation"></div>
<div class="grid-overlay"></div>
<div class="particles" id="particles"></div>
<div class="notification" id="notification"></div>

<div class="lang-switcher">
    <button type="button" class="lang-btn active" data-lang="ru" onclick="switchLang('ru')">🇺 РУ</button>
    <button type="button" class="lang-btn" data-lang="tj" onclick="switchLang('tj')">🇹🇯 TJ</button>
    <button type="button" class="lang-btn" data-lang="en" onclick="switchLang('en')">🇬🇧 EN</button>
</div>

<div class="container">
    <div class="reset-card">
        <div class="logo-section">
            <img src="https://image.qwenlm.ai/public_source/5fabf35d-788a-476d-8837-6431dd4fb2c8/1bb634345-5339-4471-924b-764b665ee39d.png" alt="DocSign Logo" class="logo-img">
            <div class="logo-title">Doc<span>Sign</span></div>
            <div class="logo-subtitle" data-i18n="subtitle">Восстановление пароля</div>
        </div>

        <div class="info-banner">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>
            </svg>
            <p data-i18n="infoBanner">Забыли пароль? Введите email и мы отправим ссылку для создания нового пароля.</p>
        </div>

        @if(session('status'))
            <div class="session-status success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" id="resetForm" onsubmit="return handleReset(event)">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email" data-i18n="emailLabel">Электронная почта</label>
                <div class="input-wrapper">
                    <input type="email" name="email" id="email" class="form-input @error('email') error @enderror"
                           value="{{ old('email') }}" data-i18n-placeholder="emailPlaceholder"
                           placeholder="name@company.com" required autofocus autocomplete="username">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </div>
                @error('email')<div class="error-message">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="submit-btn" id="submitBtn">
                    <span class="btn-text">
                        <span data-i18n="sendBtn">Отправить ссылку</span>
                        <svg class="btn-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><path d="M12 12h10"/>
                        </svg>
                    </span>
            </button>
        </form>

        <div class="back-link-section">
            <a href="{{ route('login') }}" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"/><path d="m12 19-7-7 7-7"/>
                </svg>
                <span data-i18n="backLink">Вернуться к входу</span>
            </a>
        </div>
    </div>

    <div class="footer-badges">
        <div class="badge"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg><span>SSL</span></div>
        <div class="badge"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg><span data-i18n="badgeSecurity">Защита</span></div>
        <div class="badge"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/></svg><span data-i18n="badgeSign">ЭЦП</span></div>
    </div>
    <p class="copyright">© {{ date('Y') }} DocSign Ecosystem. <span data-i18n="rights">Все права защищены.</span></p>
</div>

<script>
    function createParticles() {
        const c = document.getElementById('particles');
        for (let i = 0; i < 30; i++) {
            const p = document.createElement('div'); p.className = 'particle';
            p.style.left = Math.random() * 100 + '%';
            p.style.animationDuration = (Math.random() * 10 + 8) + 's';
            p.style.animationDelay = (Math.random() * 10) + 's';
            p.style.width = p.style.height = (Math.random() * 3 + 1) + 'px';
            p.style.opacity = Math.random() * 0.5 + 0.1; c.appendChild(p);
        }
    } createParticles();

    const translations = {
        ru: { subtitle: 'Восстановление пароля', infoBanner: 'Забыли пароль? Введите email и мы отправим ссылку для создания нового пароля.', emailLabel: 'Электронная почта', emailPlaceholder: 'name@company.com', sendBtn: 'Отправить ссылку', backLink: 'Вернуться к входу', badgeSecurity: 'Защита', badgeSign: 'ЭЦП', rights: 'Все права защищены.', invalidEmail: 'Неверный формат email', emptyEmail: 'Введите email', sent: 'Ссылка отправлена! Проверьте почту.' },
        tj: { subtitle: 'Барқарорсозии рамз', infoBanner: 'Рамзро фаромӯш кардед? Email-ро ворид кунед, мо пайванди барқарорсозиро мефиристем.', emailLabel: 'Почтаи электронӣ', emailPlaceholder: 'name@company.com', sendBtn: 'Фиристодани пайванд', backLink: 'Бозгашт ба вуруд', badgeSecurity: 'Ҳифз', badgeSign: 'ЭИИ', rights: 'Ҳуқуқҳо ҳифз шудаанд.', invalidEmail: 'Формати email нодуруст', emptyEmail: 'Email-ро ворид кунед', sent: 'Пайванд фиристода шуд! Почтаро санҷед.' },
        en: { subtitle: 'Reset Password', infoBanner: 'Forgot your password? Enter your email and we\'ll send you a reset link.', emailLabel: 'Email Address', emailPlaceholder: 'name@company.com', sendBtn: 'Send Reset Link', backLink: 'Back to Sign In', badgeSecurity: 'Security', badgeSign: 'EDS', rights: 'All rights reserved.', invalidEmail: 'Invalid email format', emptyEmail: 'Please enter email', sent: 'Link sent! Check your inbox.' }
    };
    let currentLang = 'ru';
    function switchLang(lang) {
        currentLang = lang;
        document.querySelectorAll('.lang-btn').forEach(b => b.classList.toggle('active', b.dataset.lang === lang));
        document.documentElement.lang = lang;
        const t = translations[lang];
        document.querySelectorAll('[data-i18n]').forEach(el => { if (t[el.dataset.i18n]) el.textContent = t[el.dataset.i18n]; });
        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => { if (t[el.dataset.i18nPlaceholder]) el.placeholder = t[el.dataset.i18nPlaceholder]; });
    }
    function showNotification(msg, type) {
        const n = document.getElementById('notification'); n.textContent = msg; n.className = `notification ${type} show`;
        setTimeout(() => n.classList.remove('show'), 3000);
    }
    function handleReset(e) {
        const email = document.getElementById('email'), btn = document.getElementById('submitBtn'), t = translations[currentLang];
        email.classList.remove('error');
        if (!email.value.trim()) { email.classList.add('error'); showNotification(t.emptyEmail, 'error'); return false; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) { email.classList.add('error'); showNotification(t.invalidEmail, 'error'); return false; }
        btn.classList.add('loading'); btn.disabled = true;
        setTimeout(() => { btn.classList.remove('loading'); btn.disabled = false; showNotification(t.sent, 'success'); }, 2000);
        return true;
    }
    document.getElementById('email')?.addEventListener('input', function() { this.classList.remove('error'); });
</script>
</body>
</html>
