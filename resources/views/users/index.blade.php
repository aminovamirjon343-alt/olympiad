@extends('layouts.admin')

@section('content')
<div class="min-h-screen py-6 relative overflow-hidden" style="background: #fafaf9;">
    {{-- Фоновый SVG паттерн (точки) --}}
    <div class="fixed inset-0 pointer-events-none" style="z-index: 0; opacity: 0.5;">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dotPattern" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                    <circle cx="1" cy="1" r="0.8" fill="#a1a1aa" opacity="0.35"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dotPattern)"/>
        </svg>
    </div>

    {{-- Мягкие градиентные пятна на фоне --}}
    <div class="fixed top-0 left-0 w-[600px] h-[600px] rounded-full pointer-events-none" style="z-index: 0; background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%); filter: blur(60px);"></div>
    <div class="fixed bottom-0 right-0 w-[600px] h-[600px] rounded-full pointer-events-none" style="z-index: 0; background: radial-gradient(circle, rgba(168,85,247,0.07) 0%, transparent 70%); filter: blur(60px);"></div>
    <div class="fixed top-1/2 left-1/2 w-[500px] h-[500px] rounded-full pointer-events-none -translate-x-1/2 -translate-y-1/2" style="z-index: 0; background: radial-gradient(circle, rgba(236,72,153,0.05) 0%, transparent 70%); filter: blur(80px);"></div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * { font-family: 'Inter', system-ui, -apple-system, sans-serif !important; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(15px, -20px); }
        }

        .bg-blob-1 { animation: float 18s ease-in-out infinite; }
        .bg-blob-2 { animation: float 22s ease-in-out infinite reverse; }
        .bg-blob-3 { animation: float 26s ease-in-out infinite; }

        /* ===== ШАПКА ===== */
        .top-bar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(228, 228, 231, 0.6);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow:
                0 1px 2px rgba(0,0,0,0.04),
                0 4px 16px rgba(0,0,0,0.02);
            position: relative;
            z-index: 1;
        }
        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }
        .top-bar-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }
        .top-bar-icon svg { width: 20px; height: 20px; color: #ffffff; }
        .top-bar-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .top-bar-subtitle {
            font-size: 0.7rem;
            color: #71717a;
            font-weight: 500;
            margin-top: 1px;
        }

        /* Кнопка добавить */
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            background: #0f172a;
            color: #ffffff;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
            border: 1px solid #0f172a;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
        }
        .btn-add:hover {
            background: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.25);
        }
        .btn-add svg { width: 14px; height: 14px; }

        /* ===== СТАТИСТИКА ===== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.6rem;
            margin-top: 0.75rem;
            position: relative;
            z-index: 1;
        }
        @media (min-width: 768px) {
            .stats-row { grid-template-columns: repeat(4, 1fr); }
        }
        .stat-box {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(228, 228, 231, 0.6);
            border-radius: 10px;
            padding: 0.75rem 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            transition: all 0.25s ease;
            box-shadow:
                0 1px 2px rgba(0,0,0,0.04),
                0 4px 12px rgba(0,0,0,0.02);
        }
        .stat-box:hover {
            border-color: rgba(161, 161, 170, 0.4);
            transform: translateY(-2px);
            box-shadow:
                0 2px 4px rgba(0,0,0,0.04),
                0 12px 24px rgba(0,0,0,0.06);
        }
        .stat-box-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .stat-box-icon svg { width: 16px; height: 16px; }
        .stat-box-icon.users { background: #eff6ff; }
        .stat-box-icon.users svg { color: #2563eb; }
        .stat-box-icon.leaders { background: #f5f3ff; }
        .stat-box-icon.leaders svg { color: #7c3aed; }
        .stat-box-icon.levels { background: #ecfdf5; }
        .stat-box-icon.levels svg { color: #059669; }
        .stat-box-icon.online { background: #fef3c7; }
        .stat-box-icon.online svg { color: #d97706; }
        .stat-box-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1;
            letter-spacing: -0.02em;
        }
        .stat-box-label {
            font-size: 0.6rem;
            color: #a1a1aa;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
            margin-top: 2px;
        }

        /* ===== КОНТЕЙНЕР ДЕРЕВА ===== */
        .tree-wrap {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(228, 228, 231, 0.6);
            border-radius: 14px;
            padding: 1.75rem;
            margin-top: 0.75rem;
            box-shadow:
                0 1px 2px rgba(0,0,0,0.04),
                0 8px 24px rgba(0,0,0,0.04);
            position: relative;
            z-index: 1;
        }
        .tree-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }
        .tree-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }
        .tree-header p {
            font-size: 0.8rem;
            color: #71717a;
            font-weight: 400;
        }

        /* ===== УРОВЕНЬ ===== */
        .level-bar {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .level-bar .count {
            background: rgba(255,255,255,0.25);
            padding: 0.15rem 0.5rem;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 700;
        }
        .lvl-1 { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
        .lvl-2 { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); }
        .lvl-3 { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
        .lvl-4 { background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); }
        .lvl-5 { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
        .lvl-default { background: linear-gradient(135deg, #52525b 0%, #3f3f46 100%); }

        /* ===== КАРТОЧКА ПОЛЬЗОВАТЕЛЯ ===== */
        .user-card {
            background: #ffffff;
            border: 1px solid rgba(228, 228, 231, 0.8);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 260px;
            opacity: 0;
            animation: fadeIn 0.5s forwards;
            /* Многослойная тень как у Apple/Linear */
            box-shadow:
                0 1px 2px rgba(0,0,0,0.04),
                0 2px 4px rgba(0,0,0,0.03),
                0 4px 8px rgba(0,0,0,0.03),
                0 8px 16px rgba(0,0,0,0.04);
        }
        .user-card:nth-child(1) { animation-delay: 0.05s; }
        .user-card:nth-child(2) { animation-delay: 0.1s; }
        .user-card:nth-child(3) { animation-delay: 0.15s; }
        .user-card:nth-child(4) { animation-delay: 0.2s; }
        .user-card:nth-child(5) { animation-delay: 0.25s; }
        .user-card:nth-child(6) { animation-delay: 0.3s; }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .user-card:hover::before { opacity: 1; }

        .user-card:hover {
            border-color: rgba(161, 161, 170, 0.4);
            transform: translateY(-4px);
            box-shadow:
                0 4px 8px rgba(0,0,0,0.06),
                0 8px 16px rgba(0,0,0,0.06),
                0 16px 32px rgba(0,0,0,0.08),
                0 24px 48px rgba(0,0,0,0.06);
        }

        .user-photo {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
            background: #f4f4f5;
        }
        .user-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .user-card:hover .user-photo img { transform: scale(1.06); }

        .user-photo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            font-weight: 800;
            color: #71717a;
            background: linear-gradient(135deg, #f4f4f5 0%, #e4e4e7 100%);
        }

        .photo-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 0.6rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(0,0,0,0.08);
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .status-pill.online { color: #059669; }
        .status-pill.offline { color: #71717a; }
        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }
        .status-dot.active { animation: pulse-dot 2s infinite; }

        .level-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 700;
            background: rgba(15, 23, 42, 0.9);
            color: #ffffff;
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .level-pill svg { width: 10px; height: 10px; }

        .user-body { padding: 0.9rem; }
        .user-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            text-align: center;
            margin-bottom: 0.4rem;
            letter-spacing: -0.01em;
            line-height: 1.25;
        }
        .user-name a {
            color: inherit;
            transition: color 0.2s;
        }
        .user-name a:hover { color: #2563eb; }

        .user-role {
            display: block;
            text-align: center;
            padding: 0.35rem 0.7rem;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #52525b;
            background: #f4f4f5;
            border: 1px solid #e4e4e7;
            margin-bottom: 0.7rem;
        }

        .admin-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.55rem;
            border-radius: 5px;
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .contact-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.5rem;
            font-size: 0.7rem;
            color: #52525b;
            border-radius: 6px;
            transition: background 0.15s;
        }
        .contact-row:hover { background: #f4f4f5; }
        .contact-row svg {
            width: 12px;
            height: 12px;
            color: #a1a1aa;
            flex-shrink: 0;
        }
        .contact-row span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 500;
        }

        .creator-box {
            padding: 0.55rem 0.65rem;
            background: #fafafa;
            border-radius: 6px;
            margin: 0.6rem 0;
            border-left: 2px solid #0f172a;
        }
        .creator-box-label {
            font-size: 0.55rem;
            color: #a1a1aa;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
            margin-bottom: 0.15rem;
        }
        .creator-box-name {
            font-size: 0.75rem;
            font-weight: 600;
            color: #0f172a;
        }

        /* Кнопки действий */
        .action-row {
            display: flex;
            gap: 0.35rem;
            padding-top: 0.7rem;
            border-top: 1px solid #f4f4f5;
        }
        .act-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            padding: 0.45rem 0.4rem;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 600;
            transition: all 0.2s;
            border: 1px solid #e4e4e7;
            background: #ffffff;
            color: #52525b;
        }
        .act-btn svg { width: 11px; height: 11px; }
        .act-btn:hover { transform: translateY(-1px); }
        .act-btn.view:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15);
        }
        .act-btn.edit:hover {
            background: #fef3c7;
            border-color: #fde68a;
            color: #d97706;
            box-shadow: 0 4px 10px rgba(217, 119, 6, 0.15);
        }
        .act-btn.delete:hover {
            background: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.15);
        }

        /* Коннектор */
        .tree-connector {
            width: 2px;
            height: 2rem;
            margin: 0 auto;
            background: linear-gradient(180deg, #d4d4d8 0%, #a1a1aa 100%);
            position: relative;
        }
        .tree-connector::before,
        .tree-connector::after {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #a1a1aa;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .tree-connector::before { top: -4px; }
        .tree-connector::after { bottom: -4px; }

        /* Пустое состояние */
        .empty-wrap {
            text-align: center;
            padding: 3rem 1rem;
        }
        .empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            border: 1px solid #e4e4e7;
            box-shadow:
                0 1px 2px rgba(0,0,0,0.04),
                0 8px 20px rgba(0,0,0,0.06);
        }
        .empty-icon svg { width: 32px; height: 32px; color: #a1a1aa; }
        .empty-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }
        .empty-desc {
            font-size: 0.8rem;
            color: #71717a;
        }

        @media (max-width: 640px) {
            .user-card { width: 100%; max-width: 300px; }
            .tree-wrap { padding: 1.25rem; }
            .top-bar { padding: 0.85rem; }
        }
    </style>

    <div class="container mx-auto px-4 max-w-7xl relative" style="z-index: 1;">
        {{-- ВЕРХНЯЯ ПАНЕЛЬ --}}
        <div class="top-bar">
            <div class="top-bar-left">
                <div class="top-bar-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <div class="top-bar-title">{{ $companyName }}</div>
                    <div class="top-bar-subtitle" data-i18n="teamStructure">{{ __('users.team_structure') }}</div>
                </div>
            </div>

            @if($authUser->isAdmin())
            <a href="{{ route('users.create') }}" class="btn-add">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span data-i18n="addBtn">{{ __('users.add') }}</span>
            </a>
            @endif
        </div>

        {{-- СТАТИСТИКА --}}
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-box-icon users">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <div class="stat-box-value">{{ $users->count() }}</div>
                    <div class="stat-box-label" data-i18n="totalMembers">{{ __('users.total_members') }}</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-box-icon leaders">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <div class="stat-box-value">{{ $users->where('level', 1)->count() }}</div>
                    <div class="stat-box-label" data-i18n="leaders">{{ __('users.leaders') }}</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-box-icon levels">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </div>
                <div>
                    <div class="stat-box-value">{{ $groupedByLevel->count() }}</div>
                    <div class="stat-box-label" data-i18n="levels">{{ __('users.levels_count') }}</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-box-icon online">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div>
                    <div class="stat-box-value">{{ $users->filter(fn($u) => $u->isOnline())->count() }}</div>
                    <div class="stat-box-label" data-i18n="onlineNow">{{ __('users.online_now') }}</div>
                </div>
            </div>
        </div>

        {{-- ДЕРЕВО --}}
        <div class="tree-wrap">
            <div class="tree-header">
                <h2 data-i18n="hierarchyTitle">{{ __('users.hierarchy_title') }}</h2>
                <p data-i18n="hierarchySubtitle">{{ __('users.hierarchy_subtitle') }}</p>
            </div>

            @foreach($groupedByLevel as $level => $levelUsers)
            @php
            $lvlClass = match($level) {
            1 => 'lvl-1', 2 => 'lvl-2', 3 => 'lvl-3',
            4 => 'lvl-4', 5 => 'lvl-5', default => 'lvl-default',
            };
            $lvlIcon = match($level) {
            1 => '👑', 2 => '⭐', 3 => '◆', 4 => '◈', 5 => '▲', default => '●',
            };
            @endphp

            @if(!$loop->first)
            <div class="tree-connector my-5"></div>
            @endif

            <div class="text-center mb-6">
                <div class="level-bar {{ $lvlClass }}">
                    <span>{{ $lvlIcon }} {{ __('users.level') }} {{ $level }}</span>
                    <span class="count">{{ $levelUsers->count() }}</span>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-5 mb-8">
                @foreach($levelUsers as $user)
                @php
                $creator = ($user->created_by && $users->has($user->created_by)) ? $users->get($user->created_by) : null;
                $canEdit = $authUser->isAdmin() || ($user->id === $authUser->id);
                $canDelete = $authUser->isAdmin() && ($user->id !== $authUser->id);
                @endphp

                <div class="user-card" style="position: relative;">
                    <div class="user-photo">
                        @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                        @else
                        <div class="user-photo-placeholder">
                            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                        </div>
                        @endif

                        <div class="photo-top">
                            @if($user->isOnline())
                            <span class="status-pill online">
                                <span class="status-dot active"></span>
                                <span data-i18n="online">{{ __('users.online') }}</span>
                            </span>
                            @else
                            <span class="status-pill offline">
                                <span class="status-dot"></span>
                                <span data-i18n="offline">{{ __('users.offline') }}</span>
                            </span>
                            @endif

                            <span class="level-pill">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                L{{ $user->level }}
                            </span>
                        </div>
                    </div>

                    <div class="user-body">
                        <h3 class="user-name">
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                        </h3>

                        <span class="user-role">{{ $user->role }}</span>

                        @if($user->isAdmin())
                        <div class="text-center mb-2">
                            <span class="admin-tag">👑 Admin</span>
                        </div>
                        @endif

                        <div class="space-y-0.5">
                            <div class="contact-row">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span title="{{ $user->email }}">{{ $user->email }}</span>
                            </div>
                            <div class="contact-row">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>{{ $user->phone ?? '—' }}</span>
                            </div>
                        </div>

                        @if($creator)
                        <div class="creator-box">
                            <div class="creator-box-label" data-i18n="createdBy">{{ __('users.created_by') }}</div>
                            <div class="creator-box-name">{{ $creator->name }}</div>
                        </div>
                        @endif

                        <div class="action-row">
                            <a href="{{ route('users.show', $user->id) }}" class="act-btn view" title="{{ __('users.view') }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span data-i18n="view">{{ __('users.view') }}</span>
                            </a>

                            @if($canEdit)
                            <a href="{{ route('users.edit', $user->id) }}" class="act-btn edit" title="{{ __('users.edit') }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span data-i18n="edit">{{ __('users.edit') }}</span>
                            </a>
                            @endif

                            @if($canDelete)
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="flex-1" onsubmit="return confirm('{{ __('users.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="act-btn delete w-full" title="{{ __('users.delete') }}">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span data-i18n="delete">{{ __('users.delete') }}</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach

            @if($users->isEmpty())
            <div class="empty-wrap">
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="empty-title" data-i18n="noUsersTitle">{{ __('users.no_users_title') }}</div>
                <div class="empty-desc" data-i18n="noUsers">{{ __('users.no_users') }}</div>
                @if($authUser->isAdmin())
                <a href="{{ route('users.create') }}" class="btn-add mt-4 inline-flex">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span data-i18n="addFirst">{{ __('users.add_first') }}</span>
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const translations = {
            ru: {
                addBtn: 'Добавить', online: 'Онлайн', offline: 'Офлайн',
                view: 'Смотреть', edit: 'Изменить', delete: 'Удалить',
                createdBy: 'Создан пользователем', teamStructure: 'Структура команды',
                totalMembers: 'Всего участников', leaders: 'Лидеры',
                levels: 'Уровней', onlineNow: 'Сейчас онлайн',
                hierarchyTitle: 'Иерархическое дерево',
                hierarchySubtitle: 'Структура команды по уровням',
                noUsers: 'Пока нет участников', noUsersTitle: 'Команда пуста',
                addFirst: 'Добавить первого'
            },
            en: {
                addBtn: 'Add', online: 'Online', offline: 'Offline',
                view: 'View', edit: 'Edit', delete: 'Delete',
                createdBy: 'Created by', teamStructure: 'Team Structure',
                totalMembers: 'Total Members', leaders: 'Leaders',
                levels: 'Levels', onlineNow: 'Online Now',
                hierarchyTitle: 'Hierarchy Tree',
                hierarchySubtitle: 'Team structure by levels',
                noUsers: 'No participants yet', noUsersTitle: 'Team is empty',
                addFirst: 'Add first'
            },
            tg: {
                addBtn: 'Илова кардан', online: 'Онлайн', offline: 'Офлайн',
                view: 'Дидан', edit: 'Таҳрир', delete: 'Нест кардан',
                createdBy: 'Аз ҷониби', teamStructure: 'Сохтори даста',
                totalMembers: 'Ҳамагӣ аъзоён', leaders: 'Пешвоён',
                levels: 'Сатҳҳо', onlineNow: 'Ҳозир онлайн',
                hierarchyTitle: 'Дарахти иерархия',
                hierarchySubtitle: 'Сохтори даста аз рӯи сатҳҳо',
                noUsers: 'Ҳоло иштирокчиён нестанд', noUsersTitle: 'Даста холӣ аст',
                addFirst: 'Аввалинро илова кунед'
            }
        };

        function getCurrentLang() {
            const htmlLang = document.documentElement.lang;
            if (htmlLang && translations[htmlLang]) return htmlLang;
            const stored = localStorage.getItem('admin_lang');
            if (stored && translations[stored]) return stored;
            return 'ru';
        }

        function applyLanguage(lang) {
            const dict = translations[lang];
            if (!dict) return;
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dict[key]) el.textContent = dict[key];
            });
        }

        applyLanguage(getCurrentLang());

        const observer = new MutationObserver(() => applyLanguage(getCurrentLang()));
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['lang'] });

        // Параллакс для фоновых пятен при движении мыши
        const blobs = document.querySelectorAll('.fixed.rounded-full');
        document.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth - 0.5) * 20;
            const y = (e.clientY / window.innerHeight - 0.5) * 20;
            blobs.forEach((blob, i) => {
                const factor = (i + 1) * 0.3;
                blob.style.transform = `translate(${x * factor}px, ${y * factor}px)`;
            });
        });
    });
</script>
@endsection