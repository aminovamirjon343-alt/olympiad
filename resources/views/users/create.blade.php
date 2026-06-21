{{-- ===== CREATE (users/create.blade.php) ===== --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen py-6 relative overflow-hidden" style="background: #fafaf9;">
    {{-- Фоновый SVG паттерн --}}
    <div class="fixed inset-0 pointer-events-none" style="z-index: 0; opacity: 0.5;">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dotPatternCreate" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                    <circle cx="1" cy="1" r="0.8" fill="#a1a1aa" opacity="0.35"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dotPatternCreate)"/>
        </svg>
    </div>
    <div class="fixed top-0 left-0 w-[600px] h-[600px] rounded-full pointer-events-none" style="z-index: 0; background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%); filter: blur(60px);"></div>
    <div class="fixed bottom-0 right-0 w-[600px] h-[600px] rounded-full pointer-events-none" style="z-index: 0; background: radial-gradient(circle, rgba(168,85,247,0.07) 0%, transparent 70%); filter: blur(60px);"></div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif !important; }

        .page-wrap { position: relative; z-index: 1; }

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
            box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
        }
        .top-bar-left { display: flex; align-items: center; gap: 0.85rem; }
        .top-bar-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }
        .top-bar-icon svg { width: 20px; height: 20px; color: #ffffff; }
        .top-bar-title { font-size: 1.05rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; line-height: 1.2; }
        .top-bar-subtitle { font-size: 0.7rem; color: #71717a; font-weight: 500; margin-top: 1px; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.45rem 0.9rem;
            background: #ffffff;
            color: #52525b;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.2s;
            border: 1px solid #e4e4e7;
        }
        .btn-back:hover {
            border-color: #a1a1aa;
            color: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }
        .btn-back svg { width: 12px; height: 12px; }

        .form-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(228, 228, 231, 0.6);
            border-radius: 14px;
            padding: 2rem;
            margin-top: 0.75rem;
            box-shadow:
                0 1px 2px rgba(0,0,0,0.04),
                0 8px 24px rgba(0,0,0,0.04);
        }

        .field-label {
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.65rem;
            font-weight: 700;
            color: #52525b;
            margin-bottom: 0.4rem;
        }
        .input-custom {
            background-color: #ffffff !important;
            border: 1px solid #e4e4e7 !important;
            color: #0f172a !important;
            font-size: 0.9rem !important;
            padding: 0.75rem 0.9rem !important;
            border-radius: 8px !important;
            transition: all 0.2s ease;
            width: 100%;
        }
        .input-custom:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
            outline: none;
        }
        .input-custom::placeholder { color: #a1a1aa !important; }

        .avatar-block {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: #fafafa;
            border-radius: 12px;
            border: 1px solid #e4e4e7;
        }
        .avatar-preview-box {
            width: 96px; height: 96px; border-radius: 14px;
            background: linear-gradient(135deg, #e4e4e7 0%, #d4d4d8 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; font-weight: 800; color: #71717a;
            overflow: hidden; position: relative; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        .avatar-preview-box img {
            width: 100%; height: 100%; object-fit: cover;
            position: absolute; inset: 0;
        }
        .avatar-upload-btn {
            position: absolute; bottom: -6px; right: -6px;
            width: 30px; height: 30px;
            background: #0f172a;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.3);
            transition: all 0.2s;
        }
        .avatar-upload-btn:hover { background: #1e293b; transform: scale(1.05); }
        .avatar-upload-btn svg { width: 14px; height: 14px; color: #ffffff; }

        .avatar-info h3 { font-size: 0.85rem; font-weight: 700; color: #0f172a; margin-bottom: 0.2rem; }
        .avatar-info p { font-size: 0.7rem; color: #71717a; }
        .avatar-file-name { font-size: 0.7rem; color: #2563eb; margin-top: 0.3rem; font-weight: 600; }

        .btn-save {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            background: #0f172a;
            color: #ffffff;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            transition: all 0.2s;
            border: 1px solid #0f172a;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
        }
        .btn-save:hover {
            background: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.3);
        }
        .btn-save svg { width: 16px; height: 16px; }

        .info-banner {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 0.85rem 1rem;
            display: flex; align-items: flex-start; gap: 0.7rem;
            font-size: 0.75rem;
            color: #1e40af;
        }
        .info-banner svg { width: 18px; height: 18px; color: #2563eb; flex-shrink: 0; margin-top: 1px; }
        .info-banner strong { color: #0f172a; }

        .note-text { font-size: 0.65rem; color: #a1a1aa; margin-top: 0.3rem; }

        @media (max-width: 640px) {
            .form-card { padding: 1.25rem; }
            .avatar-block { flex-direction: column; text-align: center; }
        }
    </style>

    <div class="container mx-auto px-4 max-w-3xl page-wrap">
        {{-- Верхняя панель --}}
        <div class="top-bar">
            <div class="top-bar-left">
                <div class="top-bar-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <div class="top-bar-title" data-i18n="newUser">{{ __('users.new_user') }}</div>
                    <div class="top-bar-subtitle">
                        <span data-i18n="companyLabel">{{ __('users.company') }}</span>:
                        <strong style="color: #2563eb;">{{ auth()->user()->company ?? '—' }}</strong>
                    </div>
                </div>
            </div>
            <a href="{{ route('users.index') }}" class="btn-back">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                <span data-i18n="backToList">{{ __('users.back_to_list') }}</span>
            </a>
        </div>

        {{-- Форма --}}
        <div class="form-card">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- АВАТАР --}}
                <div class="avatar-block">
                    <div class="relative">
                        <div class="avatar-preview-box">
                            <span id="avatarLetter">?</span>
                            <img id="avatarPreview" src="" class="hidden">
                        </div>
                        <label for="avatarInput" class="avatar-upload-btn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </label>
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                    </div>
                    <div class="flex-1">
                        <h3 class="avatar-info-h3" style="font-size: 0.85rem; font-weight: 700; color: #0f172a; margin-bottom: 0.2rem;" data-i18n="photo">{{ __('users.photo') }}</h3>
                        <p style="font-size: 0.7rem; color: #71717a;" data-i18n="photoDesc">{{ __('users.photo_desc') }}</p>
                        <p id="fileNameDisplay" class="avatar-file-name"></p>
                    </div>
                </div>

                {{-- ИМЯ --}}
                <div>
                    <label class="field-label" data-i18n="fullName">{{ __('users.full_name') }}</label>
                    <input name="name" type="text" required class="input-custom" placeholder="Иван Иванов" id="nameInput">
                </div>

                {{-- EMAIL + ТЕЛЕФОН --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="field-label" data-i18n="email">{{ __('users.email') }}</label>
                        <input name="email" type="email" required class="input-custom" placeholder="mail@example.com">
                    </div>
                    <div>
                        <label class="field-label" data-i18n="phone">{{ __('users.phone') }}</label>
                        <input name="phone" type="text" id="phone" required class="input-custom" placeholder="+992 00 000 0000">
                    </div>
                </div>

                {{-- РОЛЬ --}}
                <div>
                    <label class="field-label" data-i18n="role">{{ __('users.role') }}</label>
                    <input name="role" type="text" required class="input-custom" placeholder="{{ __('users.role_placeholder') }}">
                </div>

                {{-- УРОВЕНЬ --}}
                <div>
                    <label class="field-label"><span data-i18n="level">{{ __('users.level') }}</span> (2-20)</label>
                    <select name="level" required class="input-custom">
                        @for($i = 2; $i <= 20; $i++)
                        <option value="{{ $i }}">{{ __('users.level') }} {{ $i }}</option>
                        @endfor
                    </select>
                    <p class="note-text">️ <span data-i18n="levelNote">{{ __('users.level_note') }}</span></p>
                </div>

                {{-- ПАРОЛЬ --}}
                <div>
                    <label class="field-label" data-i18n="password">{{ __('users.password') }}</label>
                    <div class="relative">
                        <input name="password" type="password" id="password" required class="input-custom pr-12" placeholder="{{ __('users.password_placeholder') }}">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-blue-600">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- ИНФО О КОМПАНИИ --}}
                <div class="info-banner">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <strong data-i18n="autoCompany">{{ __('users.auto_company') }}:</strong>
                        <strong>{{ auth()->user()->company ?? '—' }}</strong>
                    </div>
                </div>

                {{-- КНОПКА --}}
                <div class="pt-3 flex justify-center">
                    <button type="submit" class="btn-save">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span data-i18n="createUser">{{ __('users.create_user') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('{{ __('users.file_too_large') }}');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
                document.getElementById('avatarPreview').classList.remove('hidden');
                document.getElementById('avatarLetter').classList.add('hidden');
                document.getElementById('fileNameDisplay').textContent = '📎 ' + file.name;
            }
            reader.readAsDataURL(file);
        }
    }

    const phoneInput = document.getElementById('phone');
    const prefix = '+992 ';
    phoneInput.addEventListener('input', function(e) {
        if (!e.target.value.startsWith(prefix)) e.target.value = prefix;
        let digits = e.target.value.substring(prefix.length).replace(/\D/g, '').substring(0, 9);
        let formatted = '';
        if (digits.length > 0) formatted += digits.substring(0, 2);
        if (digits.length >= 3) formatted += ' ' + digits.substring(2, 5);
        if (digits.length >= 6) formatted += ' ' + digits.substring(5, 7);
        if (digits.length >= 8) formatted += ' ' + digits.substring(7, 9);
        e.target.value = prefix + formatted;
    });

    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }

    document.getElementById('nameInput').addEventListener('input', function(e) {
        const letter = e.target.value.trim().charAt(0).toUpperCase();
        document.getElementById('avatarLetter').textContent = letter || '?';
    });

    // Переводы
    document.addEventListener('DOMContentLoaded', function() {
        const translations = {
            ru: {
                newUser: 'Новый пользователь', companyLabel: 'Компания', backToList: 'Назад к списку',
                photo: 'Фото', photoDesc: 'JPG, PNG до 2MB', fullName: 'Полное имя',
                email: 'Email', phone: 'Телефон', role: 'Роль',
                level: 'Уровень', levelNote: 'Уровень 1 зарезервирован для администратора',
                password: 'Пароль', autoCompany: 'Компания назначается автоматически',
                createUser: 'Создать пользователя'
            },
            en: {
                newUser: 'New User', companyLabel: 'Company', backToList: 'Back to list',
                photo: 'Photo', photoDesc: 'JPG, PNG up to 2MB', fullName: 'Full Name',
                email: 'Email', phone: 'Phone', role: 'Role',
                level: 'Level', levelNote: 'Level 1 is reserved for admin',
                password: 'Password', autoCompany: 'Company is assigned automatically',
                createUser: 'Create User'
            },
            tg: {
                newUser: 'Корбари нав', companyLabel: 'Ширкат', backToList: 'Бозгашт ба рӯйхат',
                photo: 'Сурат', photoDesc: 'JPG, PNG то 2MB', fullName: 'Номи пурра',
                email: 'Email', phone: 'Телефон', role: 'Вазифа',
                level: 'Сатҳ', levelNote: 'Сатҳи 1 барои администратор аст',
                password: 'Рамз', autoCompany: 'Ширкат автоматикӣ таъин мешавад',
                createUser: 'Эҷоди корбар'
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
    });
</script>
@endsection