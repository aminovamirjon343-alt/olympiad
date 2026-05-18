@php
    // Отметка активности пользователя в кэше
    if(auth()->check()) {
        \Illuminate\Support\Facades\Cache::put('user-is-online-' . auth()->id(), true, now()->addMinutes(5));
    }
@endphp

@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#f1f5f9] py-8">
        <div class="container mx-auto px-4">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700;900&family=Inter:wght@400;600;800&display=swap');

                .users-page {
                    font-family: 'Inter', sans-serif !important;
                }

                .users-page h1 {
                    font-family: 'Inter Tight', sans-serif !important;
                }

                .table-card {
                    background: #f8fafc !important;
                    border-radius: 1.25rem;
                    border: 1px solid rgba(15, 23, 42, 0.08);
                    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
                    overflow: hidden;
                }

                .table-header-primary {
                    background: linear-gradient(90deg, var(--primary, #2563eb) 0%, #3b82f6 100%);
                }

                .users-table td {
                    padding: 0.85rem 1.25rem;
                    font-size: 0.8rem;
                    color: #334155 !important;
                    vertical-align: middle;
                    border-bottom: 1px solid #f1f5f9;
                }

                .tr-hover:hover {
                    background-color: #ffffff !important;
                    transition: background 0.2s ease;
                }

                .btn-primary-system {
                    background-color: var(--primary, #4f46e5) !important;
                    transition: all 0.2s ease;
                }
            </style>

            <div class="users-page">
                {{-- Header --}}
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                            <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                            <span data-i18n="pageTitle">Пользователи</span>
                        </h1>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1 " data-i18n="pageSubtitle">Управление командой и доступом</p>
                    </div>

                    {{-- Кнопка добавить видна админам или ID 10 --}}
                    @if(auth()->id() === 10 || strtolower(auth()->user()->role) === 'admin')
                        <a href="{{ route('users.create') }}" class="btn-primary-system text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                                <path d="M12 4v16m8-8H4"/>
                            </svg>
                            <span data-i18n="addBtn">Добавить</span>
                        </a>
                    @endif
                </div>

                {{-- Таблица --}}
                <div class="max-w-6xl">
                    <div class="table-card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left users-table border-collapse">
                                <thead class="table-header-primary">
                                <tr>
                                    <th class="w-12 text-center py-2.5 px-3 text-[9px] font-black text-white/90 uppercase tracking-widest rounded-tl-xl">ID</th>
                                    <th class="py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest" data-i18n="thEmployee">Сотрудник</th>
                                    <th class="py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest" data-i18n="thEmail">Email / Контакты</th>
                                    <th class="py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest" data-i18n="thPhone">Телефон</th>
                                    <th class="text-center py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest" data-i18n="thRole">Роль</th>
                                    <th class="text-right py-2.5 px-3 text-[9px] font-black text-white uppercase tracking-widest rounded-tr-xl" data-i18n="thActions">Управление</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $index => $user)
                                    <tr class="group tr-hover border-b border-slate-50 last:border-0 transition-colors duration-150">
                                        <td class="text-center font-black text-slate-300 text-[9px] py-2 px-3">
                                            #{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
                                        </td>

                                        <td class="py-2 px-3">
                                            <div class="flex items-center gap-2">
                                                <div class="relative">
                                                    @php
                                                        $colors = [
                                                            ['bg' => '#e0f2fe', 'text' => '#0369a1'],
                                                            ['bg' => '#dcfce7', 'text' => '#15803d'],
                                                            ['bg' => '#fef3c7', 'text' => '#b45309'],
                                                            ['bg' => '#f3e8ff', 'text' => '#7e22ce'],
                                                            ['bg' => '#fee2e2', 'text' => '#b91c1c'],
                                                        ];
                                                        $colorIndex = $user->id % count($colors);
                                                        $currentColor = $colors[$colorIndex];
                                                    @endphp

                                                    <div class="w-6 h-6 rounded flex items-center justify-center text-[9px] font-black shadow-sm border border-black/5 transition-all group-hover:scale-110"
                                                         style="background-color: {{ $currentColor['bg'] }}; color: {{ $currentColor['text'] }};">
                                                        {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                                    </div>

                                                    @if($user->isOnline())
                                                        <span class="absolute -bottom-0.5 -right-0.5 flex h-2.5 w-2.5">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500 border-2 border-white"></span>
                                                        </span>
                                                    @else
                                                        <span class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full bg-slate-300 border-2 border-white"></span>
                                                    @endif
                                                </div>

                                                <div class="flex flex-col">
                                                    <div class="font-bold text-slate-800 tracking-tight text-[11px] leading-none group-hover:text-blue-600 transition-colors">{{ $user->name }}</div>
                                                    <span class="text-[7px] font-black uppercase tracking-widest mt-0.5 {{ $user->isOnline() ? 'text-green-600' : 'text-slate-400' }}"
                                                          data-i18n="{{ $user->isOnline() ? 'statusOnline' : 'statusOffline' }}">
                                                        {{ $user->isOnline() ? 'Онлайн' : 'Офлайн' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="font-medium text-slate-500 text-[10px] py-2 px-3">
                                            {{ $user->email }}
                                        </td>

                                        <td class="py-2 px-3">
                                            <div class="inline-flex items-center gap-1 py-0.5 px-1.5 bg-white rounded border border-slate-100 shadow-sm transition-all group-hover:border-blue-100">
                                                <span class="font-black text-[8px] uppercase" style="color: var(--primary)">TJ</span>
                                                <span class="font-black text-slate-700 text-[9px] tracking-tight">
                                                    {{ $user->phone ?? '00 000 0000' }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="text-center py-2 px-3">
                                            @php
                                                $cleanRole = strtolower(trim($user->role));

                                                $roleLangKey = 'roleUser';
                                                if (in_array($cleanRole, ['admin', 'админ', 'администратор'])) {
                                                    $roleLangKey = 'roleAdmin';
                                                } elseif (in_array($cleanRole, ['director', 'директор'])) {
                                                    $roleLangKey = 'roleDirector';
                                                } elseif (in_array($cleanRole, ['employee', 'сотрудник'])) {
                                                    $roleLangKey = 'roleEmployee';
                                                }

                                                $isAdminStyle = ($roleLangKey === 'roleAdmin');
                                            @endphp
                                            <span class="role-badge inline-block px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-tighter border shadow-sm {{ $isAdminStyle ? 'text-white' : 'bg-white text-slate-500 border-slate-200' }}"
                                                  style="{{ $isAdminStyle ? 'background-color: var(--primary); border-color: var(--primary);' : '' }}"
                                                  data-role-key="{{ $roleLangKey }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>

                                        <td class="text-right py-2 px-3">
                                            <div class="flex items-center justify-end gap-1">
                                                @php
                                                    $authUser = auth()->user();
                                                    $authId = (int)auth()->id();
                                                    $myRole = strtolower(trim($authUser->role ?? ''));

                                                    // Приводим роли к нижнему регистру для точной проверки
                                                    $targetRole = strtolower(trim($user->role ?? ''));
                                                    $isMe = ($user->id === $authId);

                                                    // Главный суперадмин (Создатель системы)
                                                    $isMainSuperAdmin = ($authId === 10);
                                                    $isAnyAdmin = ($myRole === 'admin');

                                                    // Проверяем, является ли цель обычным клиентом (user / корбар)
                                                    $isTargetClient = in_array($targetRole, ['user', 'корбар']);

                                                    if ($isTargetClient) {
                                                        // Обычных пользователей (клиентов) никто не может трогать, кроме Суперадмина (ID 10)
                                                        $canEdit = $isMainSuperAdmin;
                                                        $canDelete = $isMainSuperAdmin;
                                                    } else {
                                                        // Для сотрудников (employee, director, admin):
                                                        // Редактировать: если это я сам, если я Главный админ (ID 10), или если я админ, который САМ создал эту запись
                                                        $canEdit = $isMe || $isMainSuperAdmin || ($isAnyAdmin && (int)$user->created_by === $authId);

                                                        // Удалить: себя нельзя, создателя (ID 10) нельзя. Можно Главному админу или админу-создателю этой записи
                                                        $canDelete = !$isMe && $user->id !== 10 && ($isMainSuperAdmin || ($isAnyAdmin && (int)$user->created_by === $authId));
                                                    }
                                                @endphp

                                                {{-- Просмотр --}}
                                                <a href="{{ route('users.show', $user->id) }}" class="p-1.5 bg-white border border-slate-100 text-slate-400 hover:text-blue-600 rounded-md shadow-sm transition-all hover:border-blue-200">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>

                                                {{-- Редактирование (Карандаш) --}}
                                                @if($canEdit)
                                                    <a href="{{ route('users.edit', $user->id) }}" class="p-1.5 bg-white border border-slate-100 text-slate-400 hover:text-amber-500 rounded-md shadow-sm transition-all hover:border-amber-200">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </a>
                                                @endif

                                                {{-- Удаление --}}
                                                @if($canDelete)
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-1.5 bg-white border border-slate-100 text-slate-400 hover:text-red-600 rounded-md shadow-sm transition-all hover:border-red-200">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    pageTitle: "Пользователи",
                    pageSubtitle: "Управление командой и доступом",
                    addBtn: "Добавить",
                    thEmployee: "Сотрудник",
                    thEmail: "Email / Контакты",
                    thPhone: "Телефон",
                    thRole: "Роль",
                    thActions: "Управление",
                    statusOnline: "Онлайн",
                    statusOffline: "Офлайн",
                    confirmDelete: "Вы уверены, что хотите удалить этого пользователя?",
                    roleAdmin: "Админ",
                    roleDirector: "Директор",
                    roleEmployee: "Сотрудник",
                    roleUser: "Пользователь"
                },
                tj: {
                    pageTitle: "Корбарон",
                    pageSubtitle: "Идоракунии даста ва дастрасӣ",
                    addBtn: "Илова кардан",
                    thEmployee: "Корманд",
                    thEmail: "Email / Тамос",
                    thPhone: "Телефон",
                    thRole: "Нақш",
                    thActions: "Идоракунӣ",
                    statusOnline: "Онлайн",
                    statusOffline: "Офлайн",
                    confirmDelete: "Шумо мутмаин ҳастед, ки ин корбарро нест кардан мехоҳед?",
                    roleAdmin: "Админ",
                    roleDirector: "Директор",
                    roleEmployee: "Корманд",
                    roleUser: "Корбар"
                },
                en: {
                    pageTitle: "Users",
                    pageSubtitle: "Team and access management",
                    addBtn: "Add New",
                    thEmployee: "Employee",
                    thEmail: "Email / Contacts",
                    thPhone: "Phone",
                    thRole: "Role",
                    thActions: "Actions",
                    statusOnline: "Online",
                    statusOffline: "Offline",
                    confirmDelete: "Are you sure you want to delete this user?",
                    roleAdmin: "Admin",
                    roleDirector: "Director",
                    roleEmployee: "Employee",
                    roleUser: "User"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang] || translations['ru'];

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            document.querySelectorAll('[data-role-key]').forEach(el => {
                const roleKey = el.getAttribute('data-role-key');
                if (t[roleKey]) el.textContent = t[roleKey];
            });

            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    if (!confirm(t.confirmDelete)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
