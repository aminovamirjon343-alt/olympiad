@extends('layouts.admin')

@section('content')
<div class="min-h-[calc(100vh-64px)] bg-slate-50 py-10 px-4 md:px-8 font-inter text-slate-900">
    <div class="max-w-5xl mx-auto">

        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('documents.index') }}"
               class="w-11 h-11 flex items-center justify-center rounded-xl bg-white border border-slate-200 shadow-sm hover:bg-black hover:text-white transition">
                <i class="bi bi-arrow-left text-base"></i>
            </a>
            <div class="text-sm font-medium tracking-widest text-slate-600 uppercase">Назад</div>
        </div>

        @if($errors->any())
        <div class="max-w-5xl mx-auto mb-4">
            <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-triangle-fill text-red-600 text-xl"></i>
                    <div>
                        <p class="text-sm font-bold text-red-800">Ошибка при создании документа</p>
                        <ul class="text-xs text-red-700 mt-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="p-9 md:p-11">

                <div class="text-center mb-10">
                    <div class="w-16 h-16 mx-auto bg-black text-white rounded-2xl flex items-center justify-center text-2xl mb-4">📄</div>
                    <h1 class="text-3xl font-semibold text-black tracking-tight">Новый документ</h1>
                    <p class="text-sm font-medium text-black tracking-widest uppercase mt-2 opacity-70">Панель управления</p>
                </div>

                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="documentForm">
                    @csrf

                    <div>
                        <label class="label">Номер документа</label>
                        <input type="text" id="doc_number" name="number"
                               value="{{ old('number', '№ ') }}"
                               class="input font-[1000] !text-black" required>
                    </div>

                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="label">Тип документа</label>
                            <input type="text" name="type" class="input"
                                   placeholder="Например: Договор"
                                   value="{{ old('type') }}" required>
                        </div>
                        <div>
                            <label class="label">Дедлайн</label>
                            <input type="date" name="deadline" class="input" value="{{ old('deadline') }}">
                        </div>
                    </div>

                    <div>
                        <label class="label">Заголовок</label>
                        <input type="text" name="title" class="input"
                               placeholder="Введите название..."
                               value="{{ old('title') }}" required>
                    </div>

                    <div>
                        <label class="label">Описание</label>
                        <textarea name="content" rows="5" class="input"
                                  placeholder="Добавьте описание...">{{ old('content') }}</textarea>
                    </div>

                    {{-- ТРИ КНОПКИ ВЫБОРА ПОЛУЧАТЕЛЕЙ --}}
                    <div>
                        <label class="label">Способ отправки <span class="text-red-500">*</span></label>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                            <button type="button" data-mode="all_team"
                                    class="mode-btn group relative overflow-hidden rounded-2xl border-2 border-slate-200 bg-white p-5 text-left transition hover:border-blue-500 hover:shadow-lg">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-people-fill text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-black text-black uppercase tracking-wide">Всей команде</p>
                                        <p class="text-[10px] text-slate-500 mt-1">Отправить всем участникам вашей компании</p>
                                    </div>
                                </div>
                                <div class="mode-check absolute top-2 right-2 w-5 h-5 rounded-full border-2 border-slate-300 group-hover:border-blue-500"></div>
                            </button>

                            <button type="button" data-mode="select_team"
                                    class="mode-btn group relative overflow-hidden rounded-2xl border-2 border-slate-200 bg-white p-5 text-left transition hover:border-emerald-500 hover:shadow-lg">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-person-check-fill text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-black text-black uppercase tracking-wide">Выбрать из команды</p>
                                        <p class="text-[10px] text-slate-500 mt-1">Выберите конкретных людей (до 5)</p>
                                    </div>
                                </div>
                                <div class="mode-check absolute top-2 right-2 w-5 h-5 rounded-full border-2 border-slate-300 group-hover:border-emerald-500"></div>
                            </button>

                            <button type="button" data-mode="other_company"
                                    class="mode-btn group relative overflow-hidden rounded-2xl border-2 border-slate-200 bg-white p-5 text-left transition hover:border-purple-500 hover:shadow-lg">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-building text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-black text-black uppercase tracking-wide">Из другой команды</p>
                                        <p class="text-[10px] text-slate-500 mt-1">Отправить в другую компанию</p>
                                    </div>
                                </div>
                                <div class="mode-check absolute top-2 right-2 w-5 h-5 rounded-full border-2 border-slate-300 group-hover:border-purple-500"></div>
                            </button>
                        </div>

                        {{-- Скрытое поле для режима --}}
                        <input type="hidden" name="receiver_mode" id="receiver_mode" value="">

                        {{-- БЛОК 1: ВСЕЙ КОМАНДЕ (просто инфо) --}}
                        <div id="mode-all_team" class="hidden rounded-2xl border-2 border-blue-200 bg-blue-50 p-5">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-info-circle-fill text-blue-600 text-xl"></i>
                                <div>
                                    <p class="text-sm font-bold text-blue-900">Документ будет отправлен всем участникам команды</p>
                                    <p class="text-xs text-blue-700 mt-1">
                                        Получателей: <strong>{{ $teamUsers->count() }}</strong> чел.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- БЛОК 2: ВЫБОР ИЗ КОМАНДЫ --}}
                        <div id="mode-select_team" class="hidden">
                            <label class="label">Выберите получателей из команды (до 5 человек)</label>
                            <input type="text" id="team-search" class="input"
                                   placeholder="Начните вводить имя или email..."
                                   autocomplete="off">

                            <div id="team-selected" class="flex flex-wrap gap-2 mt-3 min-h-[40px] p-3 bg-slate-50 rounded-2xl border border-slate-200">
                                <span class="text-xs text-slate-400" id="team-placeholder">Выбранные пользователи появятся здесь...</span>
                            </div>

                            <div id="team-list" class="hidden mt-2 bg-white border border-slate-200 rounded-2xl shadow-lg overflow-hidden max-h-60 overflow-y-auto"></div>

                            <input type="hidden" name="team_receivers" id="team_receivers" value="">

                            <p id="team-error" class="text-xs text-red-600 mt-2 font-bold hidden">Выберите хотя бы одного получателя</p>
                        </div>

                        {{-- БЛОК 3: ИЗ ДРУГОЙ КОМАНДЫ --}}
                        <div id="mode-other_company" class="hidden">
                            <label class="label">Выберите получателя из другой команды</label>
                            <input type="text" id="other-search" class="input"
                                   placeholder="Начните вводить имя или email..."
                                   autocomplete="off">

                            <div id="other-selected" class="hidden mt-3 p-3 bg-purple-50 border border-purple-200 rounded-2xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-purple-600 text-white flex items-center justify-center">
                                        <i class="bi bi-person-fill text-sm"></i>
                                    </div>
                                    <div>
                                        <p id="other-name" class="text-[12px] font-bold text-purple-900"></p>
                                        <p id="other-email" class="text-[10px] text-purple-700"></p>
                                        <p id="other-company" class="text-[10px] text-purple-600 mt-0.5"></p>
                                    </div>
                                </div>
                                <button type="button" onclick="clearOtherReceiver()" class="text-purple-600 hover:text-purple-900">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            <div id="other-list" class="hidden mt-2 bg-white border border-slate-200 rounded-2xl shadow-lg overflow-hidden max-h-60 overflow-y-auto"></div>

                            <input type="hidden" name="other_receiver_id" id="other_receiver_id" value="">

                            <p id="other-error" class="text-xs text-red-600 mt-2 font-bold hidden">Выберите получателя из списка</p>
                        </div>

                        @error('receiver_mode')
                        <p class="text-xs text-red-600 mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="label">Статус</label>
                            <select name="status" class="input">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
                                <option value="active" {{ old('status') !== 'draft' ? 'selected' : '' }}>Активен</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Файл (PDF, DOCX, XLSX, RTF) <span class="text-red-500">*</span></label>
                            <input type="file" name="file_path" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.rtf" class="hidden" required>
                            <label for="file" class="flex items-center justify-between px-6 h-12 border border-slate-200 rounded-2xl bg-white cursor-pointer shadow-sm hover:border-black transition">
                                <span id="file-name" class="text-[10px] font-[1000] uppercase tracking-[0.2em] text-black truncate pr-2">Выберите файл</span>
                                <span class="text-xl">📂</span>
                            </label>
                            <p class="text-xs text-slate-500 mt-2">Максимальный размер: 10 МБ</p>
                            @error('file_path')
                            <p class="text-xs text-red-600 mt-2 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-center w-full pt-8">
                        <button type="submit" id="submitBtn" class="w-80 h-14 bg-black rounded-full font-[1000] uppercase text-[14px] tracking-[0.25em] text-white hover:opacity-90 active:scale-95 transition-all flex items-center justify-center gap-3">
                            <span>Отправить</span>
                            <span class="text-xl">🚀</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('documentForm');
        const submitBtn = document.getElementById('submitBtn');
        const modeInput = document.getElementById('receiver_mode');
        const modeButtons = document.querySelectorAll('.mode-btn');

        let currentMode = null;
        let selectedTeamUsers = [];

        // Данные пользователей
        const teamUsers = @json($teamUsersArray);
const otherUsers = @json($otherUsersArray);



        // Переключение режимов
        modeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const mode = this.dataset.mode;
                currentMode = mode;
                modeInput.value = mode;

                // Сбрасываем стили всех кнопок
                modeButtons.forEach(b => {
                    b.classList.remove('border-blue-500', 'border-emerald-500', 'border-purple-500', 'bg-blue-50', 'bg-emerald-50', 'bg-purple-50');
                    b.querySelector('.mode-check').innerHTML = '';
                    b.querySelector('.mode-check').classList.remove('bg-blue-500', 'bg-emerald-500', 'bg-purple-500', 'border-blue-500', 'border-emerald-500', 'border-purple-500');
                });

                // Скрываем все блоки
                document.getElementById('mode-all_team').classList.add('hidden');
                document.getElementById('mode-select_team').classList.add('hidden');
                document.getElementById('mode-other_company').classList.add('hidden');

                // Показываем нужный блок и подсвечиваем кнопку
                if (mode === 'all_team') {
                    this.classList.add('border-blue-500', 'bg-blue-50');
                    const check = this.querySelector('.mode-check');
                    check.classList.add('bg-blue-500', 'border-blue-500');
                    check.innerHTML = '<i class="bi bi-check text-white text-xs"></i>';
                    document.getElementById('mode-all_team').classList.remove('hidden');
                } else if (mode === 'select_team') {
                    this.classList.add('border-emerald-500', 'bg-emerald-50');
                    const check = this.querySelector('.mode-check');
                    check.classList.add('bg-emerald-500', 'border-emerald-500');
                    check.innerHTML = '<i class="bi bi-check text-white text-xs"></i>';
                    document.getElementById('mode-select_team').classList.remove('hidden');
                } else if (mode === 'other_company') {
                    this.classList.add('border-purple-500', 'bg-purple-50');
                    const check = this.querySelector('.mode-check');
                    check.classList.add('bg-purple-500', 'border-purple-500');
                    check.innerHTML = '<i class="bi bi-check text-white text-xs"></i>';
                    document.getElementById('mode-other_company').classList.remove('hidden');
                }
            });
        });

        // Поиск по команде
        const teamSearch = document.getElementById('team-search');
        const teamList = document.getElementById('team-list');

        if (teamSearch) {
            teamSearch.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                teamList.innerHTML = '';

                if (query.length < 1) {
                    teamList.classList.add('hidden');
                    return;
                }

                const filtered = teamUsers.filter(u =>
                    u.name.toLowerCase().includes(query) || u.email.toLowerCase().includes(query)
                ).filter(u => !selectedTeamUsers.find(s => s.id === u.id));

                if (filtered.length === 0) {
                    teamList.innerHTML = '<div class="p-3 text-xs text-slate-500">Пользователь не найден</div>';
                    teamList.classList.remove('hidden');
                    return;
                }

                filtered.forEach(u => {
                    const item = document.createElement('div');
                    item.className = 'p-3 hover:bg-emerald-50 cursor-pointer border-b border-slate-100 last:border-0 flex items-center justify-between';
                    item.innerHTML = `
                        <div>
                            <p class="text-[12px] font-bold text-black">${u.name}</p>
                            <p class="text-[10px] text-slate-500">${u.email} — ${u.role || 'user'}</p>
                        </div>
                        <i class="bi bi-plus-circle text-emerald-600 text-lg"></i>
                    `;
                    item.addEventListener('click', function() {
                        if (selectedTeamUsers.length >= 5) {
                            alert('Можно выбрать максимум 5 человек');
                            return;
                        }
                        selectedTeamUsers.push(u);
                        renderSelectedTeam();
                        teamSearch.value = '';
                        teamList.classList.add('hidden');
                    });
                    teamList.appendChild(item);
                });

                teamList.classList.remove('hidden');
            });
        }

        function renderSelectedTeam() {
            const container = document.getElementById('team-selected');
            const placeholder = document.getElementById('team-placeholder');

            container.innerHTML = '';

            if (selectedTeamUsers.length === 0) {
                container.appendChild(placeholder);
                document.getElementById('team_receivers').value = '';
                return;
            }

            selectedTeamUsers.forEach((u, idx) => {
                const chip = document.createElement('div');
                chip.className = 'inline-flex items-center gap-2 bg-emerald-100 text-emerald-900 px-3 py-1.5 rounded-full text-xs font-bold';
                chip.innerHTML = `
                    <span>${u.name}</span>
                    <button type="button" onclick="removeTeamUser(${idx})" class="hover:text-red-600">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                container.appendChild(chip);
            });

            document.getElementById('team_receivers').value = selectedTeamUsers.map(u => u.id).join(',');
        }

        window.removeTeamUser = function(idx) {
            selectedTeamUsers.splice(idx, 1);
            renderSelectedTeam();
        };

        // Поиск по другой команде
        const otherSearch = document.getElementById('other-search');
        const otherList = document.getElementById('other-list');

        if (otherSearch) {
            otherSearch.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                otherList.innerHTML = '';

                if (query.length < 1) {
                    otherList.classList.add('hidden');
                    return;
                }

                const filtered = otherUsers.filter(u =>
                    u.name.toLowerCase().includes(query) || u.email.toLowerCase().includes(query)
                );

                if (filtered.length === 0) {
                    otherList.innerHTML = '<div class="p-3 text-xs text-slate-500">Пользователь не найден</div>';
                    otherList.classList.remove('hidden');
                    return;
                }

                filtered.forEach(u => {
                    const item = document.createElement('div');
                    item.className = 'p-3 hover:bg-purple-50 cursor-pointer border-b border-slate-100 last:border-0 flex items-center justify-between';
                    item.innerHTML = `
                        <div>
                            <p class="text-[12px] font-bold text-black">${u.name}</p>
                            <p class="text-[10px] text-slate-500">${u.email} — ${u.role || 'user'}</p>
                            <p class="text-[10px] text-purple-600 mt-0.5">🏢 ${u.company || 'Без компании'}</p>
                        </div>
                        <i class="bi bi-check-circle text-purple-600"></i>
                    `;
                    item.addEventListener('click', function() {
                        document.getElementById('other_receiver_id').value = u.id;
                        document.getElementById('other-name').textContent = u.name;
                        document.getElementById('other-email').textContent = u.email;
                        document.getElementById('other-company').textContent = '🏢 ' + (u.company || 'Без компании');
                        document.getElementById('other-selected').classList.remove('hidden');
                        otherList.classList.add('hidden');
                        otherSearch.value = '';
                        document.getElementById('other-error').classList.add('hidden');
                    });
                    otherList.appendChild(item);
                });

                otherList.classList.remove('hidden');
            });
        }

        window.clearOtherReceiver = function() {
            document.getElementById('other_receiver_id').value = '';
            document.getElementById('other-selected').classList.add('hidden');
        };

        // Валидация формы
        form.addEventListener('submit', function(e) {
            if (!currentMode) {
                e.preventDefault();
                alert('Пожалуйста, выберите способ отправки');
                return false;
            }

            if (currentMode === 'select_team') {
                if (selectedTeamUsers.length === 0) {
                    e.preventDefault();
                    document.getElementById('team-error').classList.remove('hidden');
                    return false;
                }
            }

            if (currentMode === 'other_company') {
                if (!document.getElementById('other_receiver_id').value) {
                    e.preventDefault();
                    document.getElementById('other-error').classList.remove('hidden');
                    return false;
                }
            }

            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
            submitBtn.innerHTML = '<span>Отправка...</span>';
        });

        // Номер документа
        const numInput = document.getElementById('doc_number');
        numInput.addEventListener('input', function() {
            if (!this.value.startsWith('№ ')) {
                this.value = '№ ' + this.value.replace(/^№?\s?/, '');
            }
        });

        // Файл
        document.getElementById('file').addEventListener('change', function() {
            if (this.files[0]) {
                document.getElementById('file-name').textContent = this.files[0].name.toUpperCase();
            } else {
                document.getElementById('file-name').textContent = 'Выберите файл';
            }
        });
    });
</script>

<style>
    .label { font-size: 12px; font-weight: 500; letter-spacing: .18em; text-transform: uppercase; display:block; margin-bottom:7px; color:#334155; }
    .input { width:100%; height:54px; border-radius:16px; border:1px solid #e2e8f0; padding:0 16px; font-weight:500; font-size:14px; outline:none; transition:.2s; color:#0f172a; background:#fff; }
    .input:focus { border-color:#000; box-shadow:0 6px 0 #000; transform:translateY(-2px); }
    textarea.input { min-height:140px; padding-top:14px; }
</style>
@endsection