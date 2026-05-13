<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocSign</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fontsource-inter@5.1.1/index.css" rel="stylesheet">
    <style>

        .search-box {
            position: relative;
        }
        .search-box i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
        }
        .search-box input {
            padding-left: 35px !important; /* Отступ для иконки */
            border-radius: 20px !important;
        }
        /* Синий текст для поиска */
        .search-box input.blue-text-fixed {
            color: var(--table-text) !important;
        }
        .search-box input::placeholder {
            color: var(--table-text);
            opacity: 0.5;
        }
    </style>
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --bg-dark: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-main: #f1f5f9;
            --text-light: #cbd5e1;
            --text-white: #f8fafc;
            --accent: #6366f1;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-card: #ffffff;
            --bg-input: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --hover-bg: #f1f5f9;
        }

        html.dark {
            --bg-main: #0f172a;
            --bg-card: #1e293b;
            --bg-input: #334155;
            --border-color: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --hover-bg: #334155;
        }

        html.dark body { background: var(--bg-main); color: var(--text-primary); }
        html.dark .topbar { background: var(--bg-card); border-color: var(--border-color); }
        html.dark .stat-card { background: var(--bg-card); border-color: var(--border-color); }
        html.dark .stat-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.3); }
        html.dark .table-custom { background: var(--bg-card); border-color: var(--border-color); }
        html.dark .table-custom th { background: #1a2332; color: var(--text-secondary); border-color: var(--border-color); }
        html.dark .table-custom td { border-color: var(--border-color); color: var(--text-primary); }
        html.dark .table-custom tr:hover td { background: var(--hover-bg); }
        html.dark .search-box input { background: var(--bg-input); border-color: var(--border-color); color: var(--text-primary); }
        html.dark .search-box input:focus { background: var(--bg-card); }
        html.dark .notification-dropdown { background: var(--bg-card); border-color: var(--border-color); }
        html.dark .notification-item { border-color: var(--border-color); }
        html.dark .notification-item:hover { background: var(--hover-bg); }
        html.dark .notification-item.unread { background: #1a2332; }
        html.dark .status-draft { background: #854d0e33; color: #fbbf24; }
        html.dark .status-pending { background: #1e3a5f33; color: #60a5fa; }
        html.dark .status-approved { background: #16653433; color: #4ade80; }
        html.dark .status-rejected { background: #7f1d1d33; color: #f87171; }
        html.dark .mobile-toggle { color: var(--text-primary); }
        html.dark .dropdown-menu { background: var(--bg-card); border-color: var(--border-color); }
        html.dark .dropdown-item { color: var(--text-primary); }
        html.dark .dropdown-item:hover { background: var(--hover-bg); }
        html.dark .dropdown-divider { border-color: var(--border-color); }
        html.dark .card { background: var(--bg-card); border-color: var(--border-color); }
        html.dark .form-control { background: var(--bg-input); border-color: var(--border-color); color: var(--text-primary); }
        html.dark .form-control:focus { background: var(--bg-card); color: var(--text-primary); }
        html.dark .form-label { color: var(--text-secondary); }
        html.dark .input-group-text { background: var(--bg-card); border-color: var(--border-color); }
        html.dark .comment-box { background: var(--bg-input); border-color: var(--border-color); }
        html.dark .btn-light { background: var(--bg-input); border-color: var(--border-color); color: var(--text-primary); }
        html.dark .btn-light:hover { background: var(--hover-bg); }
        html.dark .btn-outline-secondary { border-color: var(--border-color); color: var(--text-secondary); }
        html.dark .text-muted { color: var(--text-secondary) !important; }
        html.dark .fw-semibold { color: var(--text-primary); }
        html.dark .fw-bold { color: var(--text-primary); }
        html.dark .step-dot.pending { background: #475569; }
        html.dark .badge { color: inherit; }
        html.dark .step-dot { color: #fff; }
        html.dark .stat-icon { opacity: 0.9; }
        html.dark a:not(.nav-link):not(.btn) { color: var(--accent); }
        html.dark .nav-link { color: var(--text-light); }
        html.dark .nav-link:hover, html.dark .nav-link.active { color: #fff; }
        html.dark .dropdown .btn { background: var(--bg-input); }
        html.dark .dropdown .btn span { color: var(--text-primary); }
        html.dark .dropdown .btn small { color: var(--text-secondary); }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); overflow-x: hidden; transition: background 0.3s, color 0.3s; }

        .sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-width);
            height: 100vh; background: var(--bg-dark); color: var(--text-white);
            transition: transform 0.3s ease; z-index: 1050; overflow-y: auto;
            scrollbar-width: thin; scrollbar-color: #334155 transparent;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        .sidebar .logo { padding: 20px; border-bottom: 1px solid #334155; display: flex; align-items: center; gap: 12px; }
        .sidebar .logo-icon { width: 42px; height: 42px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .sidebar .nav-section { padding: 12px 16px 6px; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #64748b; font-weight: 600; }
        .sidebar .nav-link {
            display: flex; align-items: center; gap: 12px; padding: 10px 20px;
            color: var(--text-light); text-decoration: none; transition: all 0.2s;
            border-radius: 8px; margin: 2px 10px; font-size: 14px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: var(--primary); color: white; }
        .sidebar .nav-link i { font-size: 18px; width: 24px; text-align: center; }
        .sidebar .nav-link .badge { margin-left: auto; font-size: 10px; }

        .topbar {
            position: fixed; top: 0; left: var(--sidebar-width); right: 0;
            height: 64px; background: white; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px; z-index: 1040; transition: left 0.3s ease, background 0.3s, border 0.3s;
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .main-content {
            margin-left: var(--sidebar-width); margin-top: 64px;
            padding: 24px; min-height: calc(100vh - 64px); transition: margin-left 0.3s ease;
        }

        .stat-card { background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; transition: all 0.3s; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.08); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }

        .page-section { display: none; }
        .page-section.active { display: block; animation: fadeSlide 0.3s ease; }
        @keyframes fadeSlide { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .lang-btn { padding: 6px 14px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.2s; }
        .lang-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
        .lang-btn:hover:not(.active) { background: #f1f5f9; }

        .profile-avatar { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; font-size: 32px; color: white; font-weight: 600; }
        .profile-avatar-sm { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; font-size: 14px; color: white; font-weight: 600; }

        .notification-dropdown { position: absolute; top: 50px; right: 0; width: 360px; background: white; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); border: 1px solid #e2e8f0; display: none; z-index: 1060; }
        .notification-dropdown.show { display: block; animation: fadeSlide 0.2s ease; }
        .notification-item { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; cursor: pointer; transition: background 0.2s; }
        .notification-item:hover { background: #f8fafc; }
        .notification-item.unread { border-left: 3px solid var(--primary); background: #faf5ff; }

        .table-custom { background: white; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; }
        .table-custom th { background: #f8fafc; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 14px 20px; border-bottom: 1px solid #e2e8f0; }
        .table-custom td { padding: 14px 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px; vertical-align: middle; }
        .table-custom tr:hover td { background: #faf5ff; }

        .workflow-step { display: flex; align-items: center; gap: 8px; padding: 8px 0; }
        .step-dot { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; color: white; font-weight: 600; }
        .step-dot.done { background: var(--success); }
        .step-dot.current { background: var(--primary); animation: pulse 2s infinite; }
        .step-dot.pending { background: #cbd5e1; }
        @keyframes pulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(79,70,229,0.4); } 50% { box-shadow: 0 0 0 8px rgba(79,70,229,0); } }

        .btn-primary-custom { background: var(--primary); color: white; border: none; padding: 8px 20px; border-radius: 10px; font-weight: 500; transition: all 0.2s; }
        .btn-primary-custom:hover { background: var(--primary-dark); color: white; transform: translateY(-1px); }

        .search-box { position: relative; }
        .search-box input { padding-left: 40px; border-radius: 10px; border: 1px solid #e2e8f0; background: #f8fafc; }
        .search-box input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,0.1); background: white; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; }

        .mobile-toggle { display: none; background: none; border: none; font-size: 24px; color: #334155; cursor: pointer; }
        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1045; }

        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .status-draft { background: #fef3c7; color: #92400e; }
        .status-pending { background: #dbeafe; color: #1e40af; }
        .status-approved { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }

        .comment-box { background: #f8fafc; border-radius: 12px; padding: 16px; margin-bottom: 12px; border: 1px solid #e2e8f0; }

        /* Theme toggle buttons */
        .theme-btn {
            width: 40px; height: 40px; border-radius: 12px;
            border: 2px solid #e2e8f0; background: white;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.25s ease; font-size: 18px;
            color: #475569;
        }
        .theme-btn:hover {
            border-color: var(--primary); color: var(--primary);
            background: #f8fafc; transform: translateY(-1px);
        }
        .theme-btn:active { transform: scale(0.95); }
        .theme-btn.active { background: var(--primary); border-color: var(--primary); color: white; }

        .palette-btn {
            width: 34px; height: 34px; border-radius: 50%;
            border: 2px solid #e2e8f0; background: white;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.25s ease; font-size: 15px;
            color: #475569;
        }
        .palette-btn:hover {
            border-color: var(--primary); color: var(--primary);
            background: #f8fafc; transform: translateY(-1px);
        }
        .palette-btn:active { transform: scale(0.95); }

        html.dark .theme-btn { border-color: #334155; background: #1e293b; color: #cbd5e1; }
        html.dark .theme-btn:hover { border-color: var(--accent); color: var(--accent); background: #334155; }
        html.dark .palette-btn { border-color: #334155; background: #1e293b; color: #cbd5e1; }
        html.dark .palette-btn:hover { border-color: var(--accent); color: var(--accent); background: #334155; }

        /* Color palette dropdown */
        .palette-dropdown {
            position: absolute; top: 50px; right: 0;
            width: 220px; background: white; border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); border: 1px solid #e2e8f0;
            display: none; z-index: 1070; padding: 16px;
        }
        html.dark .palette-dropdown { background: #1e293b; border-color: #334155; }
        .palette-dropdown.show { display: block; animation: fadeSlide 0.2s ease; }
        .palette-dropdown h6 { font-size: 12px; font-weight: 600; color: #94a3b8; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .color-options { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; }
        .color-swatch {
            width: 32px; height: 32px; border-radius: 10px; cursor: pointer;
            border: 2px solid transparent; transition: all 0.2s;
        }
        .color-swatch:hover { transform: scale(1.15); border-color: #334155; }
        .color-swatch.active { border-color: var(--primary); box-shadow: 0 0 0 2px rgba(79,70,229,0.3); }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: block; }
            .overlay.show { display: block; }
        }
    </style>
</head>

<body>
{{-- resources/views/layouts/admin.blade.php --}}
{{--<div id="edo-loader">--}}
{{--    <div class="loader-wrapper">--}}
{{--        <div class="animation-zone">--}}
{{--            <div class="document-item">--}}
{{--                <div class="doc-body">--}}
{{--                    <div class="doc-line"></div>--}}
{{--                    <div class="doc-line short"></div>--}}
{{--                    <div class="doc-stamp"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="plane-v4">--}}
{{--                <svg viewBox="0 0 100 100">--}}
{{--                    <path d="M15 50 L85 20 L55 55 L55 75 L70 65 L85 20 L35 65 L15 50 Z" fill="#3498db" stroke="#fff" stroke-width="1.5"/>--}}
{{--                </svg>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <h2 class="status-text">Загрузка данных...</h2>--}}
{{--       <div class="progress-bar"></div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<style>--}}
{{--    /* Прячем скролл, пока идет загрузка */--}}
{{--    body.loading { overflow: hidden; }--}}

{{--    #edo-loader {--}}
{{--        position: fixed; inset: 0;--}}
{{--        background: #ffffff;--}}
{{--        display: flex; flex-direction: column; justify-content: center; align-items: center;--}}
{{--        z-index: 999999; font-family: 'Inter', system-ui, -apple-system, sans-serif;--}}
{{--        opacity: 1; visibility: visible;--}}
{{--        transition: opacity 0.5s ease;--}}
{{--    }--}}

{{--    .animation-zone { position: relative; width: 300px; height: 180px; }--}}

{{--    .document-item {--}}
{{--        position: absolute; top: 50%; left: 50%;--}}
{{--        width: 50px; height: 65px;--}}
{{--        background: #fff; border: 2px solid #3498db; border-radius: 4px;--}}
{{--        transform: translate(-50%, -50%);--}}
{{--        box-shadow: 0 15px 35px rgba(52, 152, 219, 0.15);--}}
{{--        animation: docState 2.8s infinite ease-in-out;--}}
{{--    }--}}

{{--    .doc-body { padding: 8px; }--}}
{{--    .doc-line { height: 3px; background: #ebf5fb; margin-bottom: 6px; border-radius: 2px; }--}}
{{--    .doc-line.short { width: 60%; }--}}
{{--    .doc-stamp { position: absolute; bottom: 8px; right: 8px; width: 10px; height: 10px; border: 1px solid #3498db; border-radius: 50%; }--}}

{{--    .plane-v4 {--}}
{{--        position: absolute; width: 65px; height: 65px;--}}
{{--        top: 50%; left: 50%;--}}
{{--        filter: drop-shadow(0 5px 15px rgba(52, 152, 219, 0.3));--}}
{{--        animation: strikeCatch 2.8s infinite cubic-bezier(0.5, 0, 0.5, 1);--}}
{{--    }--}}

{{--    @keyframes docState {--}}
{{--        0% { transform: translate(-50%, 40px); opacity: 0; }--}}
{{--        20%, 45% { transform: translate(-50%, -50%); opacity: 1; }--}}
{{--        60%, 100% { transform: translate(400px, -500px) rotate(30deg); opacity: 0; }--}}
{{--    }--}}

{{--    @keyframes strikeCatch {--}}
{{--        0% { transform: translate(-350px, 200px) rotate(-10deg); opacity: 0; }--}}
{{--        20% { opacity: 1; }--}}
{{--        45% { transform: translate(-15px, -15px) rotate(0deg) scale(1.1); }--}}
{{--        65%, 100% { transform: translate(500px, -600px) rotate(-20deg); opacity: 1; }--}}
{{--    }--}}

{{--    .status-text { margin-top: 20px; color: #2c3e50; text-align: center; font-size: 1.4rem; font-weight: 600; letter-spacing: -0.02em; }--}}

{{--    .progress-bar {--}}
{{--        width: 130px; height: 4px; background: #ebf5fb;--}}
{{--        margin: 15px auto; border-radius: 10px; position: relative; overflow: hidden;--}}
{{--    }--}}
{{--    .progress-bar::after {--}}
{{--        content: ''; position: absolute; left: -100%; width: 100%; height: 100%;--}}
{{--        background: #3498db; animation: lineLoad 2.8s infinite;--}}
{{--    }--}}
{{--    @keyframes lineLoad { 0% { left: -100%; } 50%, 100% { left: 100%; } }--}}

{{--    .loader-hidden { opacity: 0 !important; visibility: hidden !important; }--}}
{{--</style>--}}

{{--<script>--}}
{{--    document.body.classList.add('loading');--}}

{{--    window.onbeforeunload = function() {--}}
{{--        document.getElementById('edo-loader').classList.remove('loader-hidden');--}}
{{--    };--}}

{{--    window.addEventListener("load", function() {--}}
{{--        const loader = document.getElementById('edo-loader');--}}
{{--        setTimeout(() => {--}}
{{--            loader.classList.add('loader-hidden');--}}
{{--            document.body.classList.remove('loading');--}}
{{--        }, 1200);--}}
{{--    });--}}
{{--</script>--}}
{{--<div id="edo-loader">--}}
{{--    <div class="loader-wrapper">--}}
{{--        <div class="animation-zone">--}}
{{--            <div class="document-item">--}}
{{--                <div class="doc-body">--}}
{{--                    <div class="doc-line"></div>--}}
{{--                    <div class="doc-line short"></div>--}}
{{--                    <div class="doc-stamp"></div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="plane-v4">--}}
{{--                <svg viewBox="0 0 100 100">--}}
{{--                    <path d="M15 50 L85 20 L55 55 L55 75 L70 65 L85 20 L35 65 L15 50 Z" fill="#3498db" stroke="#fff" stroke-width="1.5"/>--}}
{{--                </svg>--}}
{{--                <div class="speed-spark"></div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <h2 class="status-text">Захват крылом...</h2>--}}
{{--        <p style="color: #3498db; margin-top: -10px; font-size: 0.9rem;">Мгновенная доставка в реестр</p>--}}
{{--        <div class="progress-bar"></div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<style>--}}
{{--    /* Лоадер виден СРАЗУ, без задержек */--}}
{{--    #edo-loader {--}}
{{--        position: fixed;--}}
{{--        inset: 0;--}}
{{--        background: #ffffff;--}}
{{--        display: flex;--}}
{{--        flex-direction: column;--}}
{{--        justify-content: center;--}}
{{--        align-items: center;--}}
{{--        z-index: 999999;--}}
{{--        font-family: 'Inter', system-ui, sans-serif;--}}
{{--        overflow: hidden;--}}
{{--        opacity: 1;--}}
{{--        visibility: visible;--}}
{{--    }--}}

{{--    .animation-zone { position: relative; width: 300px; height: 300px; }--}}

{{--    .document-item {--}}
{{--        position: absolute; top: 50%; left: 50%;--}}
{{--        width: 50px; height: 65px;--}}
{{--        background: #fff; border: 2px solid #3498db; border-radius: 4px;--}}
{{--        transform: translate(-50%, -50%);--}}
{{--        box-shadow: 0 15px 35px rgba(52, 152, 219, 0.15);--}}
{{--        z-index: 5;--}}
{{--        animation: docState 2.8s infinite ease-in-out;--}}
{{--    }--}}

{{--    .doc-body { padding: 8px; }--}}
{{--    .doc-line { height: 3px; background: #ebf5fb; margin-bottom: 6px; border-radius: 2px; }--}}
{{--    .doc-line.short { width: 60%; }--}}
{{--    .doc-stamp { position: absolute; bottom: 8px; right: 8px; width: 12px; height: 12px; border: 1px solid #3498db; border-radius: 50%; }--}}

{{--    .plane-v4 {--}}
{{--        position: absolute; width: 65px; height: 65px;--}}
{{--        top: 50%; left: 50%;--}}
{{--        z-index: 10;--}}
{{--        filter: drop-shadow(0 5px 15px rgba(52, 152, 219, 0.3));--}}
{{--        animation: strikeCatch 2.8s infinite cubic-bezier(0.5, 0, 0.5, 1);--}}
{{--    }--}}

{{--    @keyframes docState {--}}
{{--        0% { transform: translate(-50%, 50px) scale(0.8); opacity: 0; }--}}
{{--        20% { transform: translate(-50%, -50%) scale(1); opacity: 1; }--}}
{{--        45% { transform: translate(-50%, -50%); }--}}
{{--        55% { transform: translate(450px, -550px) rotate(30deg); opacity: 0; }--}}
{{--        100% { transform: translate(450px, -550px); opacity: 0; }--}}
{{--    }--}}

{{--    @keyframes strikeCatch {--}}
{{--        0% { transform: translate(-350px, 250px) rotate(-10deg); opacity: 0; }--}}
{{--        20% { opacity: 1; }--}}
{{--        45% { transform: translate(-15px, -15px) rotate(0deg) scale(1.1); }--}}
{{--        60% { transform: translate(500px, -600px) rotate(-15deg); opacity: 1; }--}}
{{--        100% { transform: translate(600px, -700px); opacity: 0; }--}}
{{--    }--}}

{{--    .status-text { margin-top: 20px; color: #2c3e50; text-align: center; font-size: 1.4rem; font-weight: 600; }--}}

{{--    .progress-bar {--}}
{{--        width: 130px; height: 4px; background: #ebf5fb;--}}
{{--        margin: 15px auto; border-radius: 10px; position: relative; overflow: hidden;--}}
{{--    }--}}
{{--    .progress-bar::after {--}}
{{--        content: ''; position: absolute; left: -100%; width: 100%; height: 100%;--}}
{{--        background: #3498db; animation: lineLoad 2.8s infinite;--}}
{{--    }--}}
{{--    @keyframes lineLoad { 0% { left: -100%; } 50%, 100% { left: 100%; } }--}}

{{--    /* Класс скрытия для плавного выхода */--}}
{{--    .loader-hidden {--}}
{{--        opacity: 0 !important;--}}
{{--        visibility: hidden !important;--}}
{{--        transition: opacity 0.4s ease, visibility 0.4s;--}}
{{--    }--}}
{{--</style>--}}

{{--<script>--}}
{{--    // 1. Показываем лоадер ПЕРЕД тем как страница начнет обновляться (уходить на сервер)--}}
{{--    window.addEventListener('beforeunload', function() {--}}
{{--        document.getElementById('edo-loader').style.display = 'flex';--}}
{{--    });--}}

{{--    // 2. Скрываем лоадер только когда ПОЛНОСТЬЮ всё загрузилось (Google завершил обновление)--}}
{{--    window.addEventListener("load", function() {--}}
{{--        const loader = document.getElementById('edo-loader');--}}

{{--        // Минимальное время показа 1.5 сек, чтобы не было мерцания на быстрых ПК--}}
{{--        setTimeout(() => {--}}
{{--            loader.classList.add('loader-hidden');--}}
{{--        }, 1500);--}}
{{--    });--}}
{{--</script>--}}


<nav class="flex items-center justify-between p-4 bg-black text-white">
    <div class="flex items-center gap-4">
        <span class="font-[1000] uppercase tracking-widest text-sm">Olympiad Admin</span>

        {{-- Вставляем переключатель здесь --}}
        @if(app()->environment('local')) {{-- Показываем только на локалке --}}
        <form action="{{ route('login.as') }}" method="POST" class="ml-4">
            @csrf
            <select name="user_id" onchange="this.form.submit()"
                    class="bg-white text-black text-[10px] font-[1000] uppercase px-2 py-1 rounded border-2 border-blue-500 cursor-pointer shadow-[3px_3px_0px_rgba(59,130,246,1)] hover:scale-105 transition-all outline-none">
                <option value="" disabled selected>👤 Switch User</option>
                @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}" {{ auth()->id() == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </form>
        @endif
    </div>

    <div class="flex items-center gap-2">
        <span class="text-[10px] font-bold opacity-70 uppercase">Active: {{ auth()->user()->name }}</span>
    </div>
</nav>




<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="logo">
        <div class="logo-icon"><i class="bi bi-file-earmark-text"></i></div>
        <div>
            <div style="font-weight:700;font-size:16px;">DocSign</div>
            <div style="font-size:11px;color:#94a3b8;" data-i18n="systemName">Document System</div>
        </div>
    </div>

    <div class="nav-section" data-i18n="mainMenu">Main</div>
    <a href="/dashboard" class="nav-link active" data-page="dashboard" onclick="showPage('dashboard', this)">
        <i class="bi bi-grid-1x2"></i> <span data-i18n="dashboard">Dashboard</span>
    </a>

    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center"
           data-bs-toggle="collapse"
           href="#documentsMenu"
           role="button"
           aria-expanded="false"
           aria-controls="documentsMenu"
           onclick="showPage('documents', this)">

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-folder2"></i>
                <span data-i18n="documents">Documents</span>
            </div>

            <i class="bi bi-chevron-down small"></i>
        </a>

        {{-- SUB MENU --}}

        <div class="collapse ps-4 mt-1 space-y-1" id="documentsMenu">
            <div class="my-1 border-t border-slate-100 mx-2"></div>

            {{-- Потоки --}}
            {{-- Все документы --}}
            <a href="{{ route('documents.index') }}" class="nav-link" onclick="showPage('documents', this)">
                <i class="bi bi-file-earmark-text"></i>
                <span class="tracking-widest uppercase text-[10px] font-bold">All Docs</span>
            </a>

            <div class="my-1 border-t border-slate-100 mx-2"></div>

            {{-- Потоки --}}
            <a href="{{ route('documents.index', ['type' => 'incoming']) }}" class="nav-link" onclick="showPage('incoming', this)">
                <i class="bi bi-download"></i>
                <span class="tracking-widest uppercase text-[10px]">Incoming</span>
            </a>

            <a href="{{ route('documents.index', ['type' => 'outgoing']) }}" class="nav-link" onclick="showPage('outgoing', this)">
                <i class="bi bi-upload"></i>
                <span class="tracking-widest uppercase text-[10px]">Outgoing</span>
            </a>

            <div class="my-1 border-t border-slate-100 mx-2"></div>

            {{-- Статусы --}}
            <a href="{{ route('documents.index', ['status' => 'waiting']) }}" class="nav-link text-orange-600" onclick="showPage('waiting', this)">
                <i class="bi bi-clock-history"></i>
                <span class="tracking-widest uppercase text-[10px]">Waiting</span>
            </a>

            <a href="{{ route('documents.index', ['status' => 'signed']) }}" class="nav-link text-green-600" onclick="showPage('signed', this)">
                <i class="bi bi-check-circle"></i>
                <span class="tracking-widest uppercase text-[10px]">Signed</span>
            </a>

            <a href="{{ route('documents.index', ['status' => 'draft']) }}" class="nav-link text-slate-400" onclick="showPage('drafts', this)">
                <i class="bi bi-pencil-square"></i>
                <span class="tracking-widest uppercase text-[10px]">Drafts</span>
            </a>
        </div>
    </li>


    <div class="nav-section" data-i18n="management">Management</div>

    <a href="/signatures" class="nav-link" data-page="signatures" onclick="showPage('signatures', this)">
        <i class="bi bi-pen"></i> <span data-i18n="signatures">Signatures</span>
    </a>
    <a href="/versions" class="nav-link" data-page="versions" onclick="showPage('versions', this)">
        <i class="bi bi-clock-history"></i> <span data-i18n="versions">Versions</span>
    </a>
    <a href="/logs" class="nav-link" data-page="logs" onclick="showPage('logs', this)">
        <i class="bi bi-journal-text"></i> <span data-i18n="logs">Logs</span>
    </a>
    <a href="/analysis" class="nav-link" data-page="analysis" onclick="showPage('analysis', this)">
        <i class="bi bi-bar-chart-line"></i> <span data-i18n="analysis">Analysis</span>
    </a>
    <div class="nav-section" data-i18n="admin">Admin</div>
    <a href="/users" class="nav-link" data-page="users" onclick="showPage('users', this)">
        <i class="bi bi-people"></i> <span data-i18n="users">Users</span>
    </a>
    <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}" data-page="notifications">
        <i class="bi bi-bell"></i>
        <span data-i18n="notifications">Уведомления</span>

        {{-- Проверяем, есть ли непрочитанные уведомления --}}
        @if(isset($unreadCount) && $unreadCount > 0)
            <span class="badge bg-danger">{{ $unreadCount }}</span>
        @endif
    </a>

    <div class="nav-section" data-i18n="account">Account</div>
    <a href="/profile" class="nav-link" data-page="profile" onclick="showPage('profile', this)">
        <i class="bi bi-person-circle"></i> <span data-i18n="profile">Profile</span>
    </a>
    <a href="/setting" class="nav-link" data-page="profile-edit" onclick="showPage('profile-edit', this)">
        <i class="bi bi-gear"></i> <span data-i18n="settings">Settings</span>
    </a>
    </a>
    <a href="#" class="nav-link" onclick="event.preventDefault(); handleLogout()">
        <i class="bi bi-box-arrow-left"></i> <span data-i18n="logout">Logout</span>
    </a>
</aside>

<!-- Topbar -->
<header class="topbar">
    <div class="topbar-left">
        <button class="mobile-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
        <div class="search-box d-none d-md-block">
            <style>
                .search-container {
                    position: relative;
                    width: 280px; /* Фиксированная ширина как на фото */
                    display: flex;
                    align-items: center;
                }

                .search-input-custom {
                    width: 100%;
                    background: #f8fafc; /* Светлый фон как в админке */
                    border: 1px solid #ced4da;
                    border-radius: 20px; /* Овальная форма */
                    padding-left: 35px !important; /* Отступ под лупу */
                    padding-right: 35px !important; /* Отступ под стрелку */
                    font-size: 0.85rem;
                    transition: all 0.3s ease;
                }

                .search-input-custom:focus {
                    border-color: #86b7fe !important;
                    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
                    background-color: #fff;
                }

                /* Иконка лупы слева */
                .search-icon-left {
                    position: absolute;
                    left: 12px;
                    color: #94a3b8;
                    pointer-events: none;
                    z-index: 5;
                }

                /* Кнопка-стрелка справа внутри */
                .search-submit-btn {
                    position: absolute;
                    right: 8px;
                    background: none;
                    border: none;
                    padding: 0;
                    color: #86b7fe;
                    display: none; /* Скрыта если пусто */
                    cursor: pointer;
                    transition: all 0.2s;
                    z-index: 5;
                }

                .search-submit-btn:hover {
                    color: #0d6efd;
                    transform: scale(1.1);
                }

                /* Магия CSS: показываем стрелку при вводе текста */
                .search-input-custom:not(:placeholder-shown) + .search-submit-btn {
                    display: block;
                }
            </style>

            <form action="{{ route('search') }}" method="GET" class="search-container">
                {{-- Иконка поиска слева --}}
                <i class="bi bi-search search-icon-left"></i>

                <input
                    type="text"
                    name="query"
                    id="searchInput"
                    value="{{ request('query') }}"
                    class="form-control form-control-sm search-input-custom"
                    placeholder="Поиск по сайту..."
                    autocomplete="off"
                >

                {{-- Кнопка-стрелка справа --}}
                <button type="submit" class="search-submit-btn" id="searchArrow" style="
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background-color: #2563eb; /* Синий фон */
    color: white;             /* Белый текст */
    border: none;
    border-radius: 20px;      /* Скругление */
    padding: 2px 12px;        /* Отступы по бокам для текста Ок */
    height: 30px;             /* Фиксированная высота */
    font-size: 12px;
    font-weight: bold;
    display: none;            /* Управляется вашим JS */
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s;
">
                    Ок
                </button>
            </form>
        </div>

        <script>
            // JS для мгновенной реакции на ввод/удаление
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('searchInput');
                const arrow = document.getElementById('searchArrow');

                const toggleArrow = () => {
                    arrow.style.display = input.value.trim().length > 0 ? 'block' : 'none';
                };

                input.addEventListener('input', toggleArrow);
                toggleArrow(); // Проверка при загрузке страницы
            });
        </script>
    </div>

    <div class="topbar-right">

        <!-- Theme Toggle & Palette Buttons -->
        <button id="themeToggleBtn" class="theme-btn-circle" onclick="toggleTheme()" title="Toggle Dark Mode">
            <i id="themeIcon" class="bi bi-moon-stars"></i>
        </button>

        <style>
            .theme-btn-circle {
                /* Делаем круг */
                width: 38px;
                height: 38px;
                border-radius: 50%;

                /* Центрируем иконку */
                display: flex;
                align-items: center;
                justify-content: center;

                /* Стили под твой дизайн */
                border: 1px solid rgba(var(--primary-rgb), 0.2);
                background: var(--card-bg, #fff);
                color: var(--heading-color, #64748b);

                /* Эффекты */
                cursor: pointer;
                transition: all 0.2s ease;
                padding: 0;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .theme-btn-circle:hover {
                background: rgba(var(--primary-rgb), 0.1);
                color: var(--primary-color);
                transform: scale(1.05); /* Легкое увеличение при наведении */
            }

            /* Адаптация иконки под темную тему */
            [data-theme='dark'] .theme-btn-circle {
                background: rgba(255, 255, 255, 0.05);
                border-color: rgba(255, 255, 255, 0.1);
                color: #fff;
            }
        </style>
        <div class="position-relative">
            <button class="palette-btn" onclick="togglePalette()" title="Theme Colors">
                <i class="bi bi-palette"></i>
            </button>
            <div class="palette-dropdown" id="paletteDropdown">
                <h6>Primary Color</h6>
                <div class="color-options" id="colorOptions">
                    <div class="color-swatch active" style="background:#4f46e5" onclick="setColor('#4f46e5','#4338ca','#6366f1',this)"></div>
                    <div class="color-swatch" style="background:#0ea5e9" onclick="setColor('#0ea5e9','#0284c7','#38bdf8',this)"></div>
                    <div class="color-swatch" style="background:#22c55e" onclick="setColor('#22c55e','#16a34a','#4ade80',this)"></div>
                    <div class="color-swatch" style="background:#f59e0b" onclick="setColor('#f59e0b','#d97706','#fbbf24',this)"></div>
                    <div class="color-swatch" style="background:#ef4444" onclick="setColor('#ef4444','#dc2626','#f87171',this)"></div>
                    <div class="color-swatch" style="background:#8b5cf6" onclick="setColor('#8b5cf6','#7c3aed','#a78bfa',this)"></div>
                    <div class="color-swatch" style="background:#ec4899" onclick="setColor('#ec4899','#db2777','#f472b6',this)"></div>
                    <div class="color-swatch" style="background:#14b8a6" onclick="setColor('#14b8a6','#0d9488','#2dd4bf',this)"></div>
                    <div class="color-swatch" style="background:#f97316" onclick="setColor('#f97316','#ea580c','#fb923c',this)"></div>
                    <div class="color-swatch" style="background:#6366f1" onclick="setColor('#6366f1','#4f46e5','#818cf8',this)"></div>
                </div>
            </div>
        </div>

        <!-- Language Selector -->
        <div class="d-flex align-items-center gap-1">
            <div class="relative" id="custom-lang-selector">
                <button type="button" onclick="document.getElementById('lang-options').classList.toggle('hidden')"
                        class="flex items-center group transition-all outline-none">
                    <div class="p-1 hover:bg-gray-100 rounded-full transition-colors">
                        <img id="current-flag" src="https://flagcdn.com/w20/us.png" class="w-5 h-auto rounded-sm shadow-sm">
                    </div>
                </button>
                <div id="lang-options" class="hidden absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-gray-50 z-50 overflow-hidden py-1">
                    <button onclick="changeLangUI('en', 'https://flagcdn.com/w20/us.png', this)" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-gray-50 transition-colors">
                        <img src="https://flagcdn.com/w20/us.png" class="w-4 h-auto rounded-[1px]">
                        <span class="text-[11px] font-bold text-gray-600">English</span>
                    </button>
                    <button onclick="changeLangUI('ru', 'https://flagcdn.com/w20/ru.png', this)" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-gray-50 transition-colors">
                        <img src="https://flagcdn.com/w20/ru.png" class="w-4 h-auto rounded-[1px]">
                        <span class="text-[11px] font-bold text-gray-600">Russian</span>
                    </button>
                    <button onclick="changeLangUI('tj', 'https://flagcdn.com/w20/tj.png', this)" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-gray-50 transition-colors">
                        <img src="https://flagcdn.com/w20/tj.png" class="w-4 h-auto rounded-[1px]">
                        <span class="text-[11px] font-bold text-gray-600">Tajikistan</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications -->
{{--        <div class="position-relative">--}}
{{--            <div class="position-relative">--}}
{{--                <button class="btn-action-circle position-relative hover-scale"--}}
{{--                        onclick="toggleNotifications()"--}}
{{--                        style="width:38px; height:38px; border-radius: 50%; display:flex; align-items:center; justify-content:center; border:1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); padding:0; color: inherit;">--}}

{{--                    <i class="bi bi-bell" style="font-size: 1.1rem;"></i>--}}

{{--                    <span class="position-absolute badge rounded-pill bg-danger border border-dark"--}}
{{--                          style="top: -2px; right: -2px; font-size: 9px; padding: 3px 5px; min-width: 18px;">--}}
{{--            3--}}
{{--        </span>--}}
{{--                </button>--}}
{{--            </div>--}}

{{--            <div class="notification-dropdown" id="notifDropdown">--}}
{{--                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">--}}
{{--                    <strong data-i18n="notifications">Notifications</strong>--}}
{{--                    <a href="/notifications/clear-all" class="btn btn-sm btn-outline-danger" onclick="event.preventDefault(); clearNotifications()" data-i18n="clearAll">Clear All</a>--}}
{{--                </div>--}}
{{--                <div class="notification-item unread">--}}
{{--                    <div class="d-flex align-items-center gap-2">--}}
{{--                        <div class="step-dot current" style="width:32px;height:32px;font-size:14px;"><i class="bi bi-file-earmark-check"></i></div>--}}
{{--                        <div>--}}
{{--                            <div style="font-size:13px;font-weight:500;" data-i18n="notifDocApproved">Document #1042 approved</div>--}}
{{--                            <div style="font-size:11px;color:#94a3b8;">2 min ago</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="notification-item unread">--}}
{{--                    <div class="d-flex align-items-center gap-2">--}}
{{--                        <div class="step-dot done" style="width:32px;height:32px;font-size:14px;"><i class="bi bi-pen"></i></div>--}}
{{--                        <div>--}}
{{--                            <div style="font-size:13px;font-weight:500;" data-i18n="notifSignReq">Signature requested</div>--}}
{{--                            <div style="font-size:11px;color:#94a3b8;">1 hour ago</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="notification-item unread">--}}
{{--                    <div class="d-flex align-items-center gap-2">--}}
{{--                        <div class="step-dot pending" style="width:32px;height:32px;font-size:14px;"><i class="bi bi-person-plus"></i></div>--}}
{{--                        <div>--}}
{{--                            <div style="font-size:13px;font-weight:500;" data-i18n="notifNewUser">New user registered</div>--}}
{{--                            <div style="font-size:11px;color:#94a3b8;">3 hours ago</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <a href="/notifications" class="d-block text-center p-3" style="color:var(--primary);font-size:13px;font-weight:500;text-decoration:none;" data-i18n="viewAll">View All</a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Profile Dropdown -->--}}

        @php
            $user = auth()->user();
            $notifications = $user ? $user->notifications()->latest()->take(5)->get() : collect();
            $unreadCount = $user ? $user->unreadNotifications->count() : 0;
        @endphp

        <div class="position-relative">

            {{-- 🔔 BUTTON --}}
            <div class="position-relative">

                <button class="btn-action-circle position-relative hover-scale"
                        onclick="toggleNotifications()"
                        style="width:38px; height:38px; border-radius: 50%; display:flex; align-items:center; justify-content:center; border:1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); padding:0; color: inherit;">

                    <i class="bi bi-bell" style="font-size: 1.1rem;"></i>

                    {{-- 🔴 REAL COUNT --}}
                    @if($unreadCount > 0)
                        <span class="position-absolute badge rounded-pill bg-danger border border-dark"
                              style="top: -2px; right: -2px; font-size: 9px; padding: 3px 5px; min-width: 18px;">
                    {{ $unreadCount }}
                </span>
                    @endif

                </button>
            </div>

            {{-- 📩 DROPDOWN --}}
            <div class="notification-dropdown" id="notifDropdown">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <strong>Notifications</strong>

                    <a href="{{ route('notifications.clearAll') }}"
                       class="btn btn-sm btn-outline-danger"
                       onclick="event.preventDefault(); document.getElementById('clear-all').submit();">
                        Clear All
                    </a>

                    <form id="clear-all" method="POST" action="{{ route('notifications.clearAll') }}" style="display:none;">
                        @csrf
                    </form>
                </div>

                {{-- LIST --}}
                <div style="max-height:300px; overflow-y:auto;">

                    @forelse($notifications as $notification)
                        <a href="{{ $notification->data['url'] ?? route('notifications.index') }}"
                           class="text-decoration-none d-block mb-2" style="color: inherit;">

                            <div class="notification-card"
                                 style="background: #f8faff; border-radius: 18px; padding: 12px 16px; display: flex; align-items: center; gap: 12px; transition: 0.3s; border: 1px solid rgba(226, 232, 240, 0.6);">

                                @php
                                    // Собираем текст динамически, если в data есть поля sender_name и document_name
                                    $sender = $notification->data['sender_name'] ?? 'Система';
                                    $docName = $notification->data['document_name'] ?? ($notification->data['title'] ?? 'Документ');
                                    $message = $notification->data['message'] ?? '';

                                    // Определяем действие (назначил или прокомментировал)
                                    $isComment = str_contains(strtolower($message), 'коммент') || str_contains(strtolower($message), 'оставил');
                                    $action = $isComment ? 'оставил комментарий к' : 'назначил вам документ';

                                    $iconBg = $isComment ? '#f0fff4' : '#fff5eb';
                                    $iconClass = $isComment ? 'bi-chat-left-text' : 'bi-pin-angle-fill';
                                    $iconColor = $isComment ? '#22c55e' : '#f97316';
                                @endphp

                                {{-- Левая часть: Иконка --}}
                                <div style="width: 42px; height: 42px; background: {{ $iconBg }}; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi {{ $iconClass }}" style="color: {{ $iconColor }}; font-size: 1.1rem;"></i>
                                </div>

                                {{-- Центральная часть: Текст --}}
                                <div style="flex-grow: 1;">
                                    <div style="font-size: 13px; color: #1e293b; line-height: 1.4;">
                                        {{-- Amir Aminov (жирным) --}}
                                        <strong style="font-weight: 700;">{{ $sender }}</strong>
                                        {{-- действие --}}
                                        {{ $action }}
                                        {{-- «Название» (синим) --}}
                                        <span style="color: #4f46e5; font-weight: 700;">«{{ $docName }}»</span>
                                    </div>

                                    {{-- Время --}}
                                    <div style="margin-top: 4px;">
                    <span style="font-size: 10px; color: #4f46e5; background: #edf2ff; padding: 2px 10px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="bi bi-clock" style="font-size: 10px;"></i>
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                                    </div>
                                </div>

                                {{-- Правая часть: Точка --}}
                                @if(!$notification->read_at)
                                    <div style="width: 8px; height: 8px; background: #4f46e5; border-radius: 50%; flex-shrink: 0;"></div>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div style="padding:30px; text-align:center; color:#94a3b8; font-size: 13px;">
                            <i class="bi bi-bell-slash d-block mb-2" style="font-size: 20px; opacity: 0.5;"></i>
                            Нет новых уведомлений
                        </div>
                    @endforelse

                    <style>
                        .notification-card:hover {
                            background: #ffffff !important;
                            transform: translateY(-1px);
                            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
                            border-color: #4f46e5 !important;
                        }
                    </style>

                </div>

                {{-- FOOTER (ADMIN LINK) --}}
                <a href="{{ route('notifications.index') }}"
                   class="d-block text-center p-3"
                   style="color:var(--primary);font-size:13px;font-weight:500;text-decoration:none;">
                    View All
                </a>

            </div>
        </div>




        <div class="dropdown">
            <button class="btn d-flex align-items-center gap-2 dropdown-toggle profile-container-link shadow-sm"
                    data-bs-toggle="dropdown"
                    style="border: 1px solid rgba(var(--primary-rgb), 0.2); background: rgba(var(--primary-rgb), 0.1); border-radius:12px; padding:4px 12px 4px 4px;">

                <div class="profile-avatar-sm" style="background-color: var(--primary-color) !important; color: #fff !important; font-weight: bold; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                    {{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}{{ Str::upper(Str::substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                </div>

                <div class="d-none d-md-block text-start">
                    <div class="text-muted" style="font-size:13px; font-weight:600; line-height: 1.2;">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="text-muted" style="font-size:11px; opacity: 0.8;">
                        {{ auth()->user()->email }}
                    </div>
                </div>
            </button>

            <ul class="dropdown-menu dropdown-menu-end p-2 shadow border-0" style="border-radius:12px; min-width: 200px; background: var(--card-bg, #fff);">
                <li>
                    <a class="dropdown-item rounded-2 py-2" href="{{ route('profile.show') }}">
                        <i class="bi bi-person me-2"></i><span>Профиль</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider opacity-50"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a class="dropdown-item text-danger rounded-2 py-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left me-2"></i><span>Выйти</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>

        <style>
            /* Убираем принудительный черный цвет */
            .profile-container-link {
                color: inherit !important;
            }

            /* Гарантируем, что в темной теме всё будет светлым */
            [data-theme='dark'] .text-muted {
                color: rgba(255, 255, 255, 0.7) !important;
            }
        </style>
    </div>
</header>

<!-- Main Content -->
<main class="main-content" id="mainContent">

    <!-- Dashboard Page -->
    @yield('content')
    <!-- Documents Page -->

    <!-- Search Page -->
    <section class="page-section" id="page-search">
        <h4 class="fw-bold mb-4" data-i18n="search">Search</h4>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="input-group input-group-lg mb-4">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search documents, users, comments..." data-i18n-placeholder="searchPlaceholder">
                    <button class="btn-primary-custom" data-i18n="search">Search</button>
                </div>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <p class="text-muted text-center mb-0" data-i18n="searchHint">Type to search across documents, users, and comments</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Page -->


    <!-- Signatures Page -->

    <!-- Versions Page -->


    <!-- Logs Page -->


    <!-- Users Page -->


    <!-- Notifications Page -->


    <!-- Profile Page -->


    <!-- Profile Edit Page -->


</main>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1100">
    <div class="toast align-items-center text-bg-success border-0" id="toastSuccess" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMsg">Saved successfully!</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const translations = {
        en: {
            systemName: "Document System", mainMenu: "Main", dashboard: "Dashboard", documents: "Documents",
            search: "Search", management: "Management", workflow: "Workflow", signatures: "Signatures",
            versions: "Versions", logs: "Logs", admin: "Admin", users: "Users", notifications: "Notifications",
            account: "Account", profile: "Profile", settings: "Settings", logout: "Logout",
            welcomeBack: "Welcdome back {{ strtok(auth()->user()->name, ' ') }} !", dashSubtitle: "Here's what's happening with your documents today.",
            newDocument: "New Document", totalDocs: "Total Documents", pendingReview: "Pending Review",
            signed: "Signed", activeUsers: "Active Users", recentDocuments: "Recent Documents", viewAll: "View All",
            document: "Document", author: "Author", status: "Status", date: "Date", actions: "Actions",
            approved: "Approved", pending: "Pending", draft: "Draft", rejected: "Rejected",
            quickActions: "Quick Actions", createDocument: "Create Document", reviewWorkflow: "Review analysis",
            manageSignatures: "Manage Signatures", checkNotifications: "Check Notifications",
            activityLog: "Activity Log", workflowSubtitle: "Document approval workflow",
            newWorkflow: "New Workflow", wfCreated: "Created", wfReviewed: "Reviewed by Manager",
            wfApproval: "Approval", wfSigned: "Signed", approve: "Approve", reject: "Reject",
            signer: "Signer", addUser: "Add User", name: "Name", role: "Role",
            roleAdmin: "Administrator", personalInfo: "Personal Information", fullName: "Full Name",
            phone: "Phone", department: "Department", bio: "Bio", saveChanges: "Save Changes",
            cancel: "Cancel", changePassword: "Change Password", currentPassword: "Current Password",
            newPassword: "New Password", confirmPassword: "Confirm Password", updatePassword: "Update Password",
            dangerZone: "Danger Zone", deleteAccount: "Delete Account", editProfile: "Edit Profile",
            activity: "Activity", docsCreated: "Docs Created", docsSigned: "Docs Signed", comments: "Comments",
            searchPlaceholder: "Search documents, users, comments...", documentsSubtitle: "Manage all your documents",
            category: "Category", user: "User", action: "Action", ip: "IP",
            notifDocApproved: "Document #1042 approved", notifSignReq: "Signature requested",
            notifNewUser: "New user registered", newNotification: "New Notification",
            markRead: "Mark Read", clearAll: "Clear All", myProfile: "My Profile",
            searchHint: "Type to search across documents, users, and comments",
            sign: "Sign", profileSaved: "Profile saved successfully!", profileDeleted: "Account deleted!",
            loggedOut: "Logged out successfully!"
        },
        ru: {
            systemName: "Система Документов", mainMenu: "Главное", dashboard: "Панель", documents: "Документы",
            search: "Поиск", management: "Управление", workflow: "Процессы", signatures: "Подписи",
            versions: "Версии", logs: "Журналы", admin: "Админ", users: "Пользователи", notifications: "Уведомления",
            account: "Аккаунт", profile: "Профиль", settings: "Настройки", logout: "Выйти",
            welcomeBack: "Добро пожаловать, {{ strtok(auth()->user()->name, ' ') }} ! ", dashSubtitle: "Вот что происходит с вашими документами сегодня.",
            newDocument: "Новый документ", totalDocs: "Всего документов", pendingReview: "На рассмотрении",
            signed: "Подписано", activeUsers: "Активных пользователей", recentDocuments: "Последние документы", viewAll: "Все",
            document: "Документ", author: "Автор", status: "Статус", date: "Дата", actions: "Действия",
            approved: "Утверждён", pending: "Ожидает", draft: "Черновик", rejected: "Отклонён",
            quickActions: "Быстрые действия", createDocument: "Создать документ", reviewWorkflow: "Проверить анализы",
            manageSignatures: "Управление подписями", checkNotifications: "Проверить уведомления",
            activityLog: "Журнал активности", workflowSubtitle: "Процесс утверждения документов",
            newWorkflow: "Новый процесс", wfCreated: "Создан", wfReviewed: "Проверен менеджером",
            wfApproval: "Утверждение", wfSigned: "Подписан", approve: "Утвердить", reject: "Отклонить",
            signer: "Подписант", addUser: "Добавить пользователя", name: "Имя", role: "Роль",
            roleAdmin: "Администратор", personalInfo: "Личная информация", fullName: "Полное имя",
            phone: "Телефон", department: "Отдел", bio: "О себе", saveChanges: "Сохранить",
            cancel: "Отмена", changePassword: "Изменить пароль", currentPassword: "Текущий пароль",
            newPassword: "Новый пароль", confirmPassword: "Подтвердить пароль", updatePassword: "Обновить пароль",
            dangerZone: "Опасная зона", deleteAccount: "Удалить аккаунт", editProfile: "Редактировать профиль",
            activity: "Активность", docsCreated: "Создано документов", docsSigned: "Подписано документов", comments: "Комментарии",
            searchPlaceholder: "Поиск документов, пользователей, комментариев...", documentsSubtitle: "Управляйте всеми документами",
            category: "Категория", user: "Пользователь", action: "Действие", ip: "IP",
            notifDocApproved: "Документ #1042 утверждён", notifSignReq: "Запрошена подпись",
            notifNewUser: "Новый пользователь зарегистрирован", newNotification: "Новое уведомление",
            markRead: "Отметить прочитанным", clearAll: "Очистить все", myProfile: "Мой профиль",
            searchHint: "Введите текст для поиска по документам, пользователям и комментариям",
            sign: "Подписать", profileSaved: "Профиль сохранён!", profileDeleted: "Аккаунт удалён!",
            loggedOut: "Вы вышли из системы!"
        },
        tj: {
            systemName: "Системаи Ҳуҷҷатҳо", mainMenu: "Асосӣ", dashboard: "Панел", documents: "Ҳуҷҷатҳо",
            search: "Ҷустуҷӯ", management: "Идоракунӣ", workflow: "Равандҳо", signatures: "Имзоҳо",
            versions: "Версияҳо", logs: "Журналҳо", admin: "Админ", users: "Корбарон", notifications: "Огоҳиҳо",
            account: "Аккаунт", profile: "Профил", settings: "Танзимот", logout: "Баромадан",
            welcomeBack: "Хуш омадед, {{ strtok(auth()->user()->name, ' ') }} ! ", dashSubtitle: "Инҷо вазъи ҳуҷҷатҳои шумо имрӯз.",
            newDocument: "Ҳуҷҷати нав", totalDocs: "Ҳамаи ҳуҷҷатҳо", pendingReview: "Дар интизорӣ",
            signed: "Имзошуда", activeUsers: "Корбарони фаъол", recentDocuments: "Ҳуҷҷатҳои охирин", viewAll: "Ҳама",
            document: "Ҳуҷҷат", author: "Муаллиф", status: "Ҳолат", date: "Сана", actions: "Амалҳо",
            approved: "Тасдиқшуда", pending: "Дар интизорӣ", draft: "Пешнавис", rejected: "Радшуда",
            quickActions: "Амалҳои зуд", createDocument: "Сохтани ҳуҷҷат", reviewWorkflow: "Таҳлил",
            manageSignatures: "Идоракунии имзоҳо", checkNotifications: "Санҷиши огоҳиҳо",
            activityLog: "Журнали фаъолият", workflowSubtitle: "Раванди тасдиқи ҳуҷҷатҳо",
            newWorkflow: "Раванди нав", wfCreated: "Сохта шуд", wfReviewed: "Аз ҷониби менеҷер баррасӣ шуд",
            wfApproval: "Тасдиқ", wfSigned: "Имзо шуд", approve: "Тасдиқ кардан", reject: "Рад кардан",
            signer: "Имзокунанда", addUser: "Иловаи корбар", name: "Ном", role: "Нақш",
            roleAdmin: "Администратор", personalInfo: "Маълумоти шахсӣ", fullName: "Номи пурра",
            phone: "Телефон", department: "Шӯъба", bio: "Дар бораи худ", saveChanges: "Захира кардан",
            cancel: "Бекор кардан", changePassword: "Тағйири парол", currentPassword: "Пароли ҷорӣ",
            newPassword: "Пароли нав", confirmPassword: "Тасдиқи парол", updatePassword: "Навсозии парол",
            dangerZone: "Минтақаи хатарнок", deleteAccount: "Нест кардани аккаунт", editProfile: "Таҳрири профил",
            activity: "Фаъолият", docsCreated: "Ҳуҷҷатҳои сохташуда", docsSigned: "Ҳуҷҷатҳои имзошуда", comments: "Шарҳҳо",
            searchPlaceholder: "Ҷустуҷӯи ҳуҷҷатҳо, корбарон, шарҳҳо...", documentsSubtitle: "Ҳамаи ҳуҷҷатҳоро идора кунед",
            category: "Категория", user: "Корбар", action: "Амал", ip: "IP",
            notifDocApproved: "Ҳуҷҷати #1042 тасдиқ шуд", notifSignReq: "Имзо дархост шуд",
            notifNewUser: "Корбари нав ба қайд гирифта шуд", newNotification: "Огоҳии нав",
            markRead: "Хондашуда ишора кардан", clearAll: "Тоза кардани ҳама", myProfile: "Профили ман",
            searchHint: "Барои ҷустуҷӯ дар ҳуҷҷатҳо, корбарон ва шарҳҳо нависед",
            sign: "Имзо кардан", profileSaved: "Профил захира шуд!", profileDeleted: "Аккаунт нест карда шуд!",
            loggedOut: "Шумо аз система баромадед!"
        },





    };

    // 1. Инициализация языка: берем из памяти или ставим 'ru' по умолчанию
    let currentLang = localStorage.getItem('app-lang') || 'ru';

    function setLang(lang, btn) {
        currentLang = lang;
        // Сохраняем выбор пользователя
        localStorage.setItem('app-lang', lang);

        document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        const t = translations[lang];
        if (!t) return;

        // Перевод текста
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key]) el.textContent = t[key];
        });

        // Перевод плейсхолдеров
        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (t[key]) el.placeholder = t[key];
        });

        document.documentElement.lang = lang;

        // Обновляем флаг в селекторе (если он есть на странице)
        const currentFlagImg = document.getElementById('current-flag');
        if (currentFlagImg) {
            const flagMap = {
                'en': 'https://flagcdn.com/w20/us.png',
                'ru': 'https://flagcdn.com/w20/ru.png',
                'tj': 'https://flagcdn.com/w20/tj.png'
            };
            currentFlagImg.src = flagMap[lang];
        }
    }

    // 2. Функция для селектора (которую ты вызываешь из HTML)
    function changeLangUI(lang, flagUrl, element) {
        setLang(lang, element);
        document.getElementById('lang-options').classList.add('hidden');
    }

    // 3. Запуск при загрузке страницы
    document.addEventListener('DOMContentLoaded', () => {
        // Устанавливаем язык, который был сохранен
        setLang(currentLang);

        // Инициализация темы и цветов (твой существующий код...)
        initThemeAndColors();
    });

    // --- Остальные твои функции без изменений (showPage, toggleTheme и т.д.) ---

    function initThemeAndColors() {
        // Тема
        const savedTheme = localStorage.getItem('color-theme');
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            if(document.getElementById('themeIcon')) document.getElementById('themeIcon').className = 'bi bi-sun';
        }

        // Цвета
        const savedPrimary = localStorage.getItem('theme-primary');
        if (savedPrimary) {
            document.documentElement.style.setProperty('--primary', savedPrimary);
            document.documentElement.style.setProperty('--primary-dark', localStorage.getItem('theme-primary-dark'));
            document.documentElement.style.setProperty('--accent', localStorage.getItem('theme-accent'));
        }
    }
    function showPage(pageId, clickedLink) {
        document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
        const target = document.getElementById('page-' + pageId);
        if (target) target.classList.add('active');

        if (clickedLink) {
            document.querySelectorAll('.sidebar .nav-link').forEach(l => l.classList.remove('active'));
            clickedLink.classList.add('active');
        }
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.remove('show');
            document.getElementById('overlay').classList.remove('show');
        }
    }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('overlay').classList.toggle('show');
    }

    function toggleNotifications() {
        document.getElementById('notifDropdown').classList.toggle('show');
    }

    function clearNotifications() {
        document.getElementById('notifDropdown').classList.remove('show');
        showToast(translations[currentLang].profileSaved);
    }

    function markRead(btn) {
        const item = btn.closest('.notification-item');
        if (item) item.classList.remove('unread');
        showToast(translations[currentLang].profileSaved);
    }

    function saveProfile() {
        showToast(translations[currentLang].profileSaved);
    }

    function deleteProfile() {
        if (confirm(currentLang === 'tj' ? 'Шумо мутмаин ҳастед?' : currentLang === 'ru' ? 'Вы уверены?' : 'Are you sure?')) {
            showToast(translations[currentLang].profileDeleted);
        }
    }

    function handleLogout() {
        showToast(translations[currentLang].loggedOut);
        setTimeout(() => window.location.href = '/', 1000);
    }

    function showToast(msg) {
        document.getElementById('toastMsg').textContent = msg;
        const toast = new bootstrap.Toast(document.getElementById('toastSuccess'));
        toast.show();
    }

    // Theme Toggle
    function toggleTheme() {
        document.documentElement.classList.toggle('dark');
        const icon = document.getElementById('themeIcon');
        if (document.documentElement.classList.contains('dark')) {
            icon.className = 'bi bi-sun';
            localStorage.setItem('color-theme', 'dark');
        } else {
            icon.className = 'bi bi-moon-stars';
            localStorage.setItem('color-theme', 'light');
        }
    }

    // Init theme
    (function() {
        const saved = localStorage.getItem('color-theme');
        if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.getElementById('themeIcon').className = 'bi bi-sun';
        } else {
            document.getElementById('themeIcon').className = 'bi bi-moon-stars';
        }
    })();

    // Palette
    function togglePalette() {
        document.getElementById('paletteDropdown').classList.toggle('show');
    }

    function setColor(primary, primaryDark, accent, el) {
        document.documentElement.style.setProperty('--primary', primary);
        document.documentElement.style.setProperty('--primary-dark', primaryDark);
        document.documentElement.style.setProperty('--accent', accent);
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
        el.classList.add('active');
        localStorage.setItem('theme-primary', primary);
        localStorage.setItem('theme-primary-dark', primaryDark);
        localStorage.setItem('theme-accent', accent);
    }

    // Load saved color
    (function() {
        const savedPrimary = localStorage.getItem('theme-primary');
        if (savedPrimary) {
            document.documentElement.style.setProperty('--primary', savedPrimary);
            document.documentElement.style.setProperty('--primary-dark', localStorage.getItem('theme-primary-dark'));
            document.documentElement.style.setProperty('--accent', localStorage.getItem('theme-accent'));
        }
    })();

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        const dd = document.getElementById('notifDropdown');
        if (dd && dd.classList.contains('show') && !e.target.closest('.position-relative') && !e.target.closest('.hover-scale')) {
            dd.classList.remove('show');
        }
        const pd = document.getElementById('paletteDropdown');
        if (pd && pd.classList.contains('show') && !e.target.closest('.position-relative') && !e.target.closest('.palette-btn')) {
            pd.classList.remove('show');
        }
        const langSel = document.getElementById('custom-lang-selector');
        if (langSel && !langSel.contains(e.target)) {
            document.getElementById('lang-options').classList.add('hidden');
        }
    });

    // Language selector
    function changeLangUI(lang, flagUrl, element) {
        document.getElementById('current-flag').src = flagUrl;
        if (typeof setLang === "function") {
            setLang(lang, element);
        }
        document.getElementById('lang-options').classList.add('hidden');
    }
    // Добавь это в docLangKeys внутри <script>
    const docLangKeys = {
        ru: {
            // ... другие ключи
            searchPlaceholder: "Поиск документов...",
        },
        en: {
            searchPlaceholder: "Search documents...",
        },
        tj: {
            searchPlaceholder: "Ҷустуҷӯи ҳуҷҷатҳо...",
        }
    };

    // И обнови функцию applyDocLang, чтобы она переводила placeholder
    function applyDocLang() {
        const lang = document.documentElement.lang || 'ru';
        const t = window.translations[lang] || window.translations['ru'];

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key]) el.textContent = t[key];
        });

        // ПЕРЕВОД ПЛЕЙСХОЛДЕРА
        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (t[key]) el.setAttribute('placeholder', t[key]);
        });
    }

</script>

</body>
</html>

