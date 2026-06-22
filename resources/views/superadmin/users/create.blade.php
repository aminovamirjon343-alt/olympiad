@extends('layouts.superadmin')

@section('title', 'Создание пользователя')
@section('page-title', '✨ Создание нового пользователя')
@section('page-subtitle', 'Добавление нового участника в систему')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Левая колонка - Превью --}}
    <div class="lg:col-span-1">
        <div class="card sticky top-6">
            <div class="text-center mb-6">
                {{-- Аватар превью --}}
                <div class="relative inline-block">
                    <div id="avatarPreview" class="w-32 h-32 rounded-full overflow-hidden border-4 border-red-500/30 shadow-2xl shadow-red-500/20 mx-auto bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center">
                        <svg id="avatarPlaceholder" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-16 h-16 text-white/50">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <img id="avatarImage" src="" alt="" class="w-full h-full object-cover hidden">
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 border-4 border-black flex items-center justify-center shadow-lg">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </div>

                <h2 id="previewName" class="text-xl font-bold text-white mt-4 mb-1">Новый пользователь</h2>
                <p id="previewEmail" class="text-sm text-zinc-400">email@example.com</p>
            </div>

            {{-- Информация --}}
            <div class="space-y-3">
                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <div class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Роль</div>
                    <div id="previewRole" class="text-sm font-semibold text-white flex items-center gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4 text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Сотрудник</span>
                    </div>
                </div>

                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <div class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Компания</div>
                    <div id="previewCompany" class="text-sm font-semibold text-white">Не указана</div>
                </div>

                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <div class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Телефон</div>
                    <div id="previewPhone" class="text-sm font-semibold text-white">—</div>
                </div>

                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <div class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Уровень</div>
                    <div class="flex items-center gap-2">
                        <span id="previewLevel" class="badge badge-admin">L1</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-white/10">
                <a href="{{ route('superadmin.users.index') }}" class="btn-ghost w-full text-center block">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4 inline">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Назад к списку
                </a>
            </div>
        </div>
    </div>

    {{-- Правая колонка - Форма --}}
    <div class="lg:col-span-2">
        <div class="card">
            <form action="{{ route('superadmin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Основная информация --}}
                <div class="mb-6">
                    <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5 text-red-400">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Основная информация
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Имя *</label>
                            <input type="text" name="name" id="inputName"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500/50"
                                   value="{{ old('name') }}" placeholder="Иван Иванов" required>
                            @error('name')<div class="text-red-400 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Email *</label>
                            <input type="email" name="email" id="inputEmail"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500/50"
                                   value="{{ old('email') }}" placeholder="user@example.com" required>
                            @error('email')<div class="text-red-400 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Безопасность --}}
                <div class="mb-6 pt-6 border-t border-white/5">
                    <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5 text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Безопасность
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Пароль *</label>
                            <input type="password" name="password"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500/50"
                                   placeholder="Минимум 6 символов" required>
                            @error('password')<div class="text-red-400 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Подтверждение пароля *</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500/50"
                                   placeholder="Повторите пароль" required>
                        </div>
                    </div>
                </div>

                {{-- Роль и компания --}}
                <div class="mb-6 pt-6 border-t border-white/5">
                    <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5 text-purple-400">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Роль и компания
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Роль *</label>
                            <select name="role" id="inputRole"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-red-500/50" required>
                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Сотрудник</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Админ</option>
                                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Супер Админ</option>
                            </select>
                            @error('role')<div class="text-red-400 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Уровень</label>
                            <input type="number" name="level" id="inputLevel" min="1" max="20"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-red-500/50"
                                   value="{{ old('level', 1) }}">
                            @error('level')<div class="text-red-400 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Компания</label>
                            <select name="company_id" id="inputCompany"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-red-500/50">
                                <option value="">Без компании</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('company_id')<div class="text-red-400 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="flex items-center gap-3 p-3 rounded-lg bg-white/5 border border-white/5 cursor-pointer hover:bg-white/10 transition">
                            <input type="checkbox" name="is_admin" value="1"
                                   {{ old('is_admin') ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-white/20 bg-white/5 text-red-500 focus:ring-red-500/20">
                            <div>
                                <div class="text-sm font-semibold text-white">Администратор компании</div>
                                <div class="text-xs text-zinc-500">Пользователь сможет управлять другими сотрудниками</div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Контакты --}}
                <div class="mb-6 pt-6 border-t border-white/5">
                    <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5 text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Контакты
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Телефон</label>
                            <input type="text" name="phone" id="inputPhone"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-red-500/50"
                                   value="{{ old('phone') }}" placeholder="+992 XXX XX XX XX">
                            @error('phone')<div class="text-red-400 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Аватар</label>
                            <input type="file" name="avatar" id="inputAvatar" accept="image/*"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-red-500/20 file:text-red-400 hover:file:bg-red-500/30">
                            @error('avatar')<div class="text-red-400 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Кнопки --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-white/10">
                    <a href="{{ route('superadmin.users.index') }}" class="btn-ghost">
                        Отмена
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Создать пользователя
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Живое превью
    document.addEventListener('DOMContentLoaded', function() {
        const inputName = document.getElementById('inputName');
        const inputEmail = document.getElementById('inputEmail');
        const inputRole = document.getElementById('inputRole');
        const inputCompany = document.getElementById('inputCompany');
        const inputPhone = document.getElementById('inputPhone');
        const inputLevel = document.getElementById('inputLevel');
        const inputAvatar = document.getElementById('inputAvatar');

        const previewName = document.getElementById('previewName');
        const previewEmail = document.getElementById('previewEmail');
        const previewRole = document.getElementById('previewRole');
        const previewCompany = document.getElementById('previewCompany');
        const previewPhone = document.getElementById('previewPhone');
        const previewLevel = document.getElementById('previewLevel');
        const avatarImage = document.getElementById('avatarImage');
        const avatarPlaceholder = document.getElementById('avatarPlaceholder');

        const roleNames = {
            'employee': 'Сотрудник',
            'admin': 'Админ',
            'super_admin': 'Супер Админ'
        };

        const roleIcons = {
            'employee': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
            'admin': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            'super_admin': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>'
        };

        const roleColors = {
            'employee': 'text-blue-400',
            'admin': 'text-orange-400',
            'super_admin': 'text-red-400'
        };

        inputName?.addEventListener('input', (e) => {
            previewName.textContent = e.target.value || 'Новый пользователь';
        });

        inputEmail?.addEventListener('input', (e) => {
            previewEmail.textContent = e.target.value || 'email@example.com';
        });

        inputRole?.addEventListener('change', (e) => {
            const role = e.target.value;
            previewRole.innerHTML = `
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4 ${roleColors[role]}">
                    ${roleIcons[role]}
                </svg>
                <span>${roleNames[role]}</span>
            `;
        });

        inputCompany?.addEventListener('change', (e) => {
            const selected = e.target.options[e.target.selectedIndex];
            previewCompany.textContent = selected.text === 'Без компании' ? 'Не указана' : selected.text;
        });

        inputPhone?.addEventListener('input', (e) => {
            previewPhone.textContent = e.target.value || '—';
        });

        inputLevel?.addEventListener('input', (e) => {
            previewLevel.textContent = 'L' + (e.target.value || '1');
        });

        inputAvatar?.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    avatarImage.src = event.target.result;
                    avatarImage.classList.remove('hidden');
                    avatarPlaceholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection