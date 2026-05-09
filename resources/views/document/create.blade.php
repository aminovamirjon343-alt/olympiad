
@extends('layouts.admin')

@section('content')
    <div class="min-h-[calc(100vh-64px)] bg-slate-50 py-10 px-4 md:px-8 font-inter text-slate-900">

        <div class="max-w-2xl mx-auto">

            {{-- BACK --}}
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('documents.index') }}"
                   class="w-11 h-11 flex items-center justify-center rounded-xl bg-white border border-slate-200 shadow-sm hover:bg-black hover:text-white transition">
                    <i class="bi bi-arrow-left text-base"></i>
                </a>

                <div class="text-sm font-medium tracking-widest text-slate-600 uppercase">
                    Назад
                </div>
            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">

                <div class="p-9 md:p-11">

                    {{-- HEADER --}}
                    <div class="text-center mb-10">
                        <div class="w-16 h-16 mx-auto bg-black text-white rounded-2xl flex items-center justify-center text-2xl mb-4">
                            📄
                        </div>
                        <h1 class="text-3xl font-semibold text-black tracking-tight">
                            Новый документ
                        </h1>
                        <p class="text-sm font-medium text-black tracking-widest uppercase mt-2 opacity-70">
                            Панель управления
                        </p>
                    </div>

                    {{-- ERRORS --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-2xl border border-red-200 bg-red-50">
                            <div class="text-sm font-semibold uppercase mb-2 text-red-700">
                                Ошибки
                            </div>
                            @foreach($errors->all() as $error)
                                <div class="text-sm text-red-600">• {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Number --}}
                        <div>
                            <label class="label">🔢 Номер документа</label>
                            <div class="relative flex items-center">
                                <input type="text"
                                       id="doc_number"
                                       name="number"
                                       {{-- Используем PHP, чтобы сразу подставить № при загрузке --}}
                                       value="{{ old('number', $document->number ?? '№ ') }}"
                                       class="input font-[1000] !text-black"
                                       placeholder="№ 47-А"
                                       required>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const input = document.getElementById('doc_number');

                                // Проверяем при вводе
                                input.addEventListener('input', function() {
                                    // Если пользователь стер "№ ", возвращаем его на место
                                    if (!this.value.startsWith('№ ')) {
                                        this.value = '№ ' + this.value.replace(/^№?\s?/, '');
                                    }
                                });

                                // Запрещаем ставить курсор перед "№ "
                                input.addEventListener('click', function() {
                                    if (this.selectionStart < 2) {
                                        this.setSelectionRange(2, 2);
                                    }
                                });

                                input.addEventListener('keydown', function(e) {
                                    // Запрещаем Backspace, если курсор сразу после "№ "
                                    if (e.key === 'Backspace' && this.selectionStart <= 2) {
                                        e.preventDefault();
                                    }
                                });
                            });
                        </script>

                        {{-- ROW: Type & Deadline --}}
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">📌 Тип документа</label>
                                <input type="text"
                                       name="type"
                                       class="input"
                                       placeholder="Например:Договор"
                                       value="{{ old('type') }}"
                                       required>
                            </div>
                            <div>
                                <label class="label">📅 Дедлайн</label>
                                <input type="date" name="deadline" class="input">
                            </div>
                        </div>

                        {{-- Title --}}
                        <div>
                            <label class="label">✏️ Заголовок</label>
                            <input type="text" name="title" class="input" placeholder="Введите название..." required>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="label">💬 Описание</label>
                            <textarea name="content" rows="5" class="input" placeholder="Добавьте описание..."></textarea>
                        </div>

                        {{-- Recipient --}}
                        <div>
                            <label class="label">📧 Email получателя</label>
                            <div class="relative flex items-center">
                                <input type="email"
                                       name="receiver_email"
                                       {{-- Используем твой стандартный класс .input --}}
                                       class="input font-bold"
                                       {{-- Подтягиваем старое значение или значение из базы --}}
                                       value="{{ old('receiver_email', $document->receiver->email ?? '') }}"
                                       placeholder="user@email.com"
                                       required>
                            </div>
                        </div>

                        {{-- ROW: Status & File --}}
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">⚙️ Статус</label>
                                <select name="status" class="input">
                                    {{-- Изменено: убран pending, добавлен active --}}
                                    <option value="draft">Черновик</option>
                                    <option value="active" selected>Активен (Подписан)</option>
                                </select>
                            </div>
                            <div>
                                <label class="label">📎 Файл</label>
                                <input type="file" name="file_path" id="file" class="hidden">
                                <label for="file" class="flex items-center justify-between px-6 h-12 border border-slate-200 rounded-2xl bg-white cursor-pointer shadow-sm hover:border-black transition">
                                    <span id="file-name" class="text-[10px] font-[1000] uppercase tracking-[0.2em] text-black truncate pr-2">
                                        Выберите файл
                                    </span>
                                    <span class="text-xl">📂</span>
                                </label>
                            </div>
                        </div>

                        {{-- CENTERED BUTTON --}}
                        <div class="flex justify-center w-full pt-8">
                            <button type="submit"
                                    class="w-80 h-14 bg-black rounded-full font-[1000] uppercase text-[14px] tracking-[0.25em] text-white hover:opacity-90 active:scale-95 transition-all flex items-center justify-center gap-3">
                                <span>Отправить</span>
                                <span class="text-xl">🚀</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- STYLE --}}
    <style>
        .label{
            font-size: 12px;
            font-weight: 500;
            letter-spacing: .18em;
            text-transform: uppercase;
            display:block;
            margin-bottom:7px;
            color:#334155;
        }

        .input{
            width:100%;
            height:54px;
            border-radius:16px;
            border:1px solid #e2e8f0;
            padding:0 16px;
            font-weight:500;
            font-size:14px;
            outline:none;
            transition:.2s;
            color:#0f172a;
            background:#fff;
        }

        .input:focus{
            border-color:#000;
            box-shadow:0 6px 0 #000;
            transform:translateY(-2px);
        }

        textarea.input{
            min-height:140px;
            padding-top:14px;
            padding-bottom:14px;
        }
    </style>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('file');
            const fileNameDisplay = document.getElementById('file-name');
            const emailInput = document.getElementById('receiver_email');
            const infoDiv = document.getElementById('user-info');

            // Обработка выбора файла
            fileInput.addEventListener('change', () => {
                fileNameDisplay.textContent = fileInput.files[0]
                    ? fileInput.files[0].name.toUpperCase()
                    : "ВЫБЕРИТЕ ФАЙЛ";
            });

            // Поиск пользователя по Email (живой поиск)
            emailInput.addEventListener('input', async function() {
                let email = this.value;

                if (email.length > 3) {
                    try {
                        const res = await fetch(`/admin/users/search?email=${email}`);
                        const data = await res.json();

                        if (data.exists) {
                            infoDiv.innerText = `✅ ПОДТВЕРЖДЕНО: ${data.name.toUpperCase()}`;
                            infoDiv.style.color = '#16a34a';
                        } else {
                            infoDiv.innerText = '❌ ПОЛЬЗОВАТЕЛЬ НЕ НАЙДЕН';
                            infoDiv.style.color = '#dc2626';
                        }
                    } catch (error) {
                        console.error('Ошибка поиска:', error);
                    }
                } else {
                    infoDiv.innerText = '';
                }
            });
        });
    </script>
@endsection

