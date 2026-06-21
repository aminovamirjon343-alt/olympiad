{{-- ===== EDIT (users/edit.blade.php) ===== --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen py-6 relative overflow-hidden" style="background: #fafaf9;">
    <div class="fixed inset-0 pointer-events-none" style="z-index: 0; opacity: 0.5;">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dotPatternEdit" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                    <circle cx="1" cy="1" r="0.8" fill="#a1a1aa" opacity="0.35"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dotPatternEdit)"/>
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
            box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
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

        .avatar-block {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: #fafafa;
            border-radius: 12px;
            border: 1px solid #e4e4e7;
        }
        .avatar-box {
            width: 128px; height: 128px; border-radius: 14px;
            overflow: hidden;
            border: 2px solid #e4e4e7;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            background: linear-gradient(135deg, #e4e4e7 0%, #d4d4d8 100%);
            display: flex; align-items: center; justify-content: center;
            position: relative; flex-shrink: 0;
        }
        .avatar-box img { width: 100%; height: 100%; object-fit: cover; }
        .avatar-box .avatar-letter { font-size: 3rem; font-weight: 800; color: #71717a; }
        .avatar-overlay {
            position: absolute; inset: 0;
            background: rgba(15, 23, 42, 0.7);
            opacity: 0; transition: opacity 0.2s ease;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; backdrop-filter: blur(2px);
        }
        .avatar-box:hover .avatar-overlay { opacity: 1; }
        .avatar-overlay svg { width: 28px; height: 28px; color: #ffffff; }
        .avatar-overlay span {
            color: #ffffff; font-size: 0.55rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 0.08em;
            margin-top: 0.2rem;
        }

        .avatar-info h3 { font-size: 0.85rem; font-weight: 700; color: #0f172a; margin-bottom: 0.2rem; }
        .avatar-info p { font-size: 0.7rem; color: #71717a; }

        .btn-upload {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.4rem 0.75rem;
            background: #0f172a;
            color: #ffffff;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-upload:hover { background: #1e293b; transform: translateY(-1px); }
        .btn-upload svg { width: 12px; height: 12px; }

        .btn-remove {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.4rem 0.75rem;
            background: #ffffff;
            color: #dc2626;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid #fecaca;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-remove:hover { background: #fef2f2; }
        .btn-remove svg { width: 12px; height: 12px; }

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

        .btn-delete {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: #ffffff;
            color: #dc2626;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid #fecaca;
            transition: all 0.2s;
        }
        .btn-delete:hover {
            background: #fef2f2;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.15);
        }
        .btn-delete svg { width: 16px; height: 16px; }

        .readonly-box {
            background: #fafafa;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            padding: 0.85rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #0f172a;
        }

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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <div class="top-bar-title">
                        <span data-i18n="editUser">Редактировать</span>: {{ $user->name }}
                    </div>
                    <div class="top-bar-subtitle">
                        ID: #{{ $user->id }} · <span data-i18n="level">Уровень</span> {{ $user->level }} · {{ $user->role }}
                    </div>
                </div>
            </div>
            <a href="{{ route('users.index') }}" class="btn-back">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                <span data-i18n="backBtn">Назад</span>
            </a>
        </div>

        {{-- Форма --}}
        <div class="form-card">
            <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- АВАТАР --}}
                <div class="avatar-block">
                    <div class="avatar-box">
                        @if($user->avatar)
                        <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}">
                        <span id="avatarLetter" class="avatar-letter hidden">{{ Str::upper(Str::substr($user->name, 0, 1)) }}</span>
                        @else
                        <img id="avatarPreview" src="" class="hidden">
                        <span id="avatarLetter" class="avatar-letter">{{ Str::upper(Str::substr($user->name, 0, 1)) }}</span>
                        @endif
                        <label for="avatarInput" class="avatar-overlay">
                            <div class="text-center">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span data-i18n="change">Изменить</span>
                            </div>
                        </label>
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                        <input type="hidden" id="removeAvatarFlag" name="remove_avatar" value="0">
                    </div>
                    <div class="flex-1">
                        <h3 style="font-size: 0.85rem; font-weight: 700; color: #0f172a; margin-bottom: 0.2rem;" data-i18n="photo">Фото</h3>
                        <p style="font-size: 0.7rem; color: #71717a;" data-i18n="photoDesc">JPG, PNG до 2MB</p>
                        <div class="flex gap-2 mt-3 flex-wrap">
                            <label for="avatarInput" class="btn-upload">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span data-i18n="upload">Загрузить</span>
                            </label>
                            <button type="button" id="removeBtn" onclick="removeAvatar()" class="btn-remove {{ !$user->avatar ? 'hidden' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span data-i18n="remove">Удалить</span>
                            </button>
                        </div>
                        <p id="fileNameDisplay" style="font-size: 0.7rem; color: #71717a; margin-top: 0.5rem; font-weight: 500;"></p>
                    </div>
                </div>

                {{-- ИМЯ --}}
                <div>
                    <label class="field-label" data-i18n="fullName">Полное имя</label>
                    <input name="name" type="text" required class="input-custom" value="{{ $user->name }}">
                </div>

                {{-- EMAIL + ТЕЛЕФОН --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="field-label" data-i18n="email">Email</label>
                        <input name="email" type="email" required class="input-custom" value="{{ $user->email }}">
                    </div>
                    <div>
                        <label class="field-label" data-i18n="phone">Телефон</label>
                        <input name="phone" type="text" id="phone" required class="input-custom" value="{{ $user->phone ?? '+992 ' }}">
                    </div>
                </div>

                {{-- РОЛЬ И УРОВЕНЬ --}}
                @if((int)$user->created_by === auth()->id())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="field-label" data-i18n="role">Роль</label>
                        <input name="role" type="text" required class="input-custom" value="{{ $user->role }}">
                    </div>
                    <div>
                        <label class="field-label"><span data-i18n="level">Уровень</span> (1-20)</label>
                        <select name="level" required class="input-custom">
                            @for($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}" {{ $user->level == $i ? 'selected' : '' }}>{{ __('users.level') }} {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                @else
                <input type="hidden" name="role" value="{{ $user->role }}">
                <input type="hidden" name="level" value="{{ $user->level }}">
                <div class="readonly-box">
                    <span data-i18n="role">Роль</span>: {{ $user->role }} · <span data-i18n="level">Уровень</span>: {{ $user->level }}
                </div>
                @endif

                {{-- ПАРОЛЬ --}}
                <div>
                    <label class="field-label">
                        <span data-i18n="newPassword">Новый пароль</span>
                        <span style="color: #a1a1aa; text-transform: none; font-weight: 500;">(<span data-i18n="leaveEmpty">оставьте пустым, чтобы не менять</span>)</span>
                    </label>
                    <div class="relative">
                        <input name="password" type="password" id="password" class="input-custom pr-12" placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-blue-600">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- КНОПКИ --}}
                <div class="pt-3 flex gap-3 justify-center flex-wrap">
                    <button type="submit" class="btn-save">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span data-i18n="save">Сохранить</span>
                    </button>

                    @if((int)$user->created_by === auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('{{ __('users.confirm_delete') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span data-i18n="delete">Удалить</span>
                        </button>
                    </form>
                    @endif
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
                document.getElementById('removeAvatarFlag').value = '0';
                document.getElementById('removeBtn').classList.remove('hidden');
                document.getElementById('fileNameDisplay').textContent = '📎 ' + file.name;
            }
            reader.readAsDataURL(file);
        }
    }

    function removeAvatar() {
        if (confirm('{{ __('users.confirm_remove_photo') }}')) {
            document.getElementById('avatarPreview').src = '';
            document.getElementById('avatarPreview').classList.add('hidden');
            document.getElementById('avatarLetter').classList.remove('hidden');
            document.getElementById('avatarInput').value = '';
            document.getElementById('removeAvatarFlag').value = '1';
            document.getElementById('removeBtn').classList.add('hidden');
            document.getElementById('fileNameDisplay').textContent = '';
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

    document.addEventListener('DOMContentLoaded', function() {
        const translations = {
            ru: {
                editUser: 'Редактировать', level: 'Уровень', backBtn: 'Назад',
                photo: 'Фото', photoDesc: 'JPG, PNG до 2MB', change: 'Изменить',
                upload: 'Загрузить', remove: 'Удалить', fullName: 'Полное имя',
                email: 'Email', phone: 'Телефон', role: 'Роль',
                newPassword: 'Новый пароль', leaveEmpty: 'оставьте пустым, чтобы не менять',
                save: 'Сохранить', delete: 'Удалить'
            },
            en: {
                editUser: 'Edit', level: 'Level', backBtn: 'Back',
                photo: 'Photo', photoDesc: 'JPG, PNG up to 2MB', change: 'Change',
                upload: 'Upload', remove: 'Remove', fullName: 'Full Name',
                email: 'Email', phone: 'Phone', role: 'Role',
                newPassword: 'New Password', leaveEmpty: 'leave empty to keep current',
                save: 'Save', delete: 'Delete'
            },
            tg: {
                editUser: 'Таҳрир', level: 'Сатҳ', backBtn: 'Бозгашт',
                photo: 'Сурат', photoDesc: 'JPG, PNG то 2MB', change: 'Иваз кардан',
                upload: 'Боркунӣ', remove: 'Нест кардан', fullName: 'Номи пурра',
                email: 'Email', phone: 'Телефон', role: 'Вазифа',
                newPassword: 'Рамзи нав', leaveEmpty: 'холӣ гузоред',
                save: 'Нигоҳ доштан', delete: 'Нест кардан'
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