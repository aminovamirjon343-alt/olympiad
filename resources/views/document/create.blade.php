
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
                            <div class="relative">
                                <input type="text"
                                       name="number"
                                       class="input"
                                       placeholder="№ 47-А"
                                       value="{{ old('number') }}">
                            </div>
                        </div>

                        {{-- ROW: Type & Deadline --}}
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">📌 Тип</label>
                                <select name="type" class="input" required>
                                    <option value="">Выберите</option>
                                    <option value="УПД">УПД</option>
                                    <option value="Договор">Договор</option>
                                </select>
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
                            {{-- Добавил text-black и немного увеличил отступ для иконки --}}
                            <label class="block text-[11px] font-[1000] uppercase mb-2 tracking-widest text-black flex items-center gap-1.5">
                                <span class="text-base">📧</span> Email получателя
                            </label>

                            <input type="email"
                                   id="receiver_email"
                                   name="receiver_email"
                                   {{-- Твой текущий стиль: жирные границы и жесткая тень --}}
                                   class="w-full bg-white border-[3px] border-black p-3 font-[1000] uppercase text-[13px] rounded-xl shadow-[5px_5px_0px_black] outline-none focus:translate-x-1 focus:translate-y-1 focus:shadow-none transition-all placeholder:text-slate-400 text-black"
                                   placeholder="user@email.com"
                                   required>

                            {{-- Контейнер для результата поиска --}}
                            <div id="user-info" class="text-[10px] mt-3 font-[1000] uppercase tracking-tighter h-4 text-black"></div>
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

{{--@extends('layouts.admin')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8">--}}

{{--        --}}{{-- Навигация назад --}}
{{--        <div class="mb-6">--}}
{{--            <a href="{{ route('documents.index') }}" class="inline-flex items-center text-[10px] font-black text-gray-400 hover:text-blue-600 transition uppercase tracking-[0.2em]">--}}
{{--                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>--}}
{{--                </svg>--}}
{{--                Вернуться в реестр--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">--}}

{{--            --}}{{-- ОСНОВНАЯ ФОРМА (8 колонок) --}}
{{--            <div class="lg:col-span-8">--}}
{{--                <div class="bg-white rounded-[2.5rem] border border-blue-900 overflow-hidden shadow-sm">--}}
{{--                    <div class="p-8 md:p-12">--}}

{{--                        <div class="mb-10 border-s-4 border-blue-600 ps-6">--}}
{{--                            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Регистрация документа</h2>--}}
{{--                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-1">Система электронного документооборота</p>--}}
{{--                        </div>--}}

{{--                        @if ($errors->any())--}}
{{--                            <div class="mb-8 p-5 bg-red-50 border border-blue-900 rounded-2xl">--}}
{{--                                <p class="text-xs font-black text-red-800 uppercase mb-2 italic">Внимание, ошибки:</p>--}}
{{--                                <ul class="text-[11px] text-red-700 font-bold list-disc list-inside space-y-1">--}}
{{--                                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">--}}
{{--                            @csrf--}}

{{--                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">--}}
{{--                                --}}{{-- Тип документа --}}
{{--                                <div>--}}
{{--                                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Категория</label>--}}
{{--                                    <select id="doc_type" name="type" class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white focus:border-red-600 focus:ring-0 transition-all font-bold text-gray-900 outline-none text-sm appearance-none cursor-pointer">--}}
{{--                                        <optgroup label="Финансовые">--}}
{{--                                            <option value="УПД">УПД</option>--}}
{{--                                            <option value="Счёт">Счёт на оплату</option>--}}
{{--                                            <option value="Акт">Акт выполненных работ</option>--}}
{{--                                        </optgroup>--}}
{{--                                        <optgroup label="Административные">--}}
{{--                                            <option value="Договор">Договор</option>--}}
{{--                                            <option value="Приказ">Приказ</option>--}}
{{--                                            <option value="Служебная записка">Служебная записка</option>--}}
{{--                                        </optgroup>--}}
{{--                                    </select>--}}
{{--                                </div>--}}

{{--                                --}}{{-- Название --}}
{{--                                <div>--}}
{{--                                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Название документа</label>--}}
{{--                                    <input type="text" id="doc_title" name="title" value="{{ old('title') }}" required--}}
{{--                                           class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white focus:border-red-600 focus:ring-0 transition-all font-bold text-gray-900 outline-none text-sm"--}}
{{--                                           placeholder="Напр: Поставка оборудования #12">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Содержимое --}}
{{--                            <div>--}}
{{--                                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Текстовая часть</label>--}}
{{--                                <textarea id="doc_content" name="content" rows="10"--}}
{{--                                          class="w-full px-6 py-5 rounded-[2rem] border border-blue-900 bg-white focus:border-red-600 focus:ring-0 transition-all font-medium text-gray-700 outline-none leading-relaxed"--}}
{{--                                          placeholder="Введите текст или используйте AI..."></textarea>--}}
{{--                            </div>--}}

{{--                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">--}}
{{--                                --}}{{-- Статус --}}
{{--                                <div>--}}
{{--                                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Статус при создании</label>--}}
{{--                                    <select name="status" class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white font-bold text-sm outline-none focus:border-red-600">--}}
{{--                                        <option value="draft">Черновик</option>--}}
{{--                                        <option value="active">Активный / В работе</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                --}}{{-- Срок --}}
{{--                                <div>--}}
{{--                                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Дедлайн (если есть)</label>--}}
{{--                                    <input type="date" name="deadline" class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white font-bold text-sm outline-none focus:border-red-600 transition-all">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Загрузка файла --}}
{{--                            <div class="relative group">--}}
{{--                                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 text-center">Электронный образ (PDF, JPG, DOCX)</label>--}}
{{--                                <div class="relative flex flex-col items-center justify-center p-10 border-2 border-dashed border-blue-900 rounded-[2rem] bg-blue-50/30 group-hover:bg-red-50/30 group-hover:border-red-600 transition-all cursor-pointer">--}}
{{--                                    <input type="file" name="file_path" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">--}}
{{--                                    <div class="text-center pointer-events-none">--}}
{{--                                        <div class="w-16 h-16 bg-white border border-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-red-600 group-hover:border-red-600 transition-all">--}}
{{--                                            <i class="fas fa-file-upload text-xl text-blue-900 group-hover:text-white transition-colors"></i>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-[10px] font-black uppercase tracking-widest text-blue-900">Перетащите файл сюда</p>--}}
{{--                                        <p class="text-[9px] font-bold text-gray-400 uppercase mt-1">или нажмите для выбора</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Ответственный --}}
{{--                            <div>--}}
{{--                                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Ответственное лицо</label>--}}
{{--                                <select name="user_id" required class="w-full px-5 py-4 rounded-2xl border border-blue-900 bg-white focus:border-red-600 font-bold text-sm outline-none transition-all">--}}
{{--                                    <option value="" disabled selected>Выберите из списка...</option>--}}
{{--                                    @foreach($users as $user)--}}
{{--                                        <option value="{{ $user->id }}">👤 {{ $user->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Кнопки действий --}}
{{--                            <div class="pt-10 flex items-center justify-between border-t border-gray-100">--}}
{{--                                <a href="{{ route('documents.index') }}" class="text-[11px] font-black text-gray-400 hover:text-blue-900 transition uppercase tracking-[0.2em]">Отменить</a>--}}
{{--                                <button type="submit" class="bg-white border border-blue-900 text-blue-900 hover:bg-red-600 hover:border-red-600 hover:text-white px-12 py-5 rounded-2xl font-black transition-all uppercase text-[11px] tracking-[0.2em] shadow-sm active:scale-95">--}}
{{--                                    Создать и отправить--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            --}}{{-- AI ASSISTANT (4 колонки) --}}
{{--            <div class="lg:col-span-4 lg:sticky lg:top-8 h-fit">--}}
{{--                <div class="bg-white border border-blue-900 rounded-[2rem] p-8 shadow-sm">--}}
{{--                    <div class="flex items-center gap-4 mb-8">--}}
{{--                        <div class="w-12 h-12 bg-blue-900 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-900/10">--}}
{{--                            <i class="fas fa-bolt text-white text-xl animate-pulse"></i>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <h4 class="text-sm font-black uppercase tracking-tight text-blue-900">AI Конструктор</h4>--}}
{{--                            <div class="flex items-center gap-1.5 mt-1">--}}
{{--                                <span class="w-2 h-2 bg-green-500 rounded-full animate-ping"></span>--}}
{{--                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Ассистент готов</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="space-y-6">--}}
{{--                        <div class="p-5 bg-blue-900 rounded-2xl">--}}
{{--                            <p class="text-[10px] font-bold text-blue-50 leading-relaxed uppercase">--}}
{{--                                Напишите тему документа, и я создам профессиональный текст за несколько секунд.--}}
{{--                            </p>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label class="block text-[9px] font-black text-gray-500 uppercase mb-2 tracking-widest">Тема запроса</label>--}}
{{--                            <textarea id="ai_prompt" rows="4"--}}
{{--                                      class="w-full p-4 border border-blue-900 rounded-2xl text-xs font-bold focus:border-red-600 outline-none bg-blue-50/30 focus:bg-white transition-all"--}}
{{--                                      placeholder="Напр: Смена реквизитов компании..."></textarea>--}}
{{--                        </div>--}}

{{--                        <button type="button" onclick="generateAI()" id="ai_btn"--}}
{{--                                class="w-full bg-white border border-blue-900 text-blue-900 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.25em] hover:bg-red-600 hover:border-red-600 hover:text-white transition-all group">--}}
{{--                            <i class="fas fa-wand-magic-sparkles me-2 group-hover:rotate-12 transition-transform"></i> Сгенерировать--}}
{{--                        </button>--}}

{{--                        <div id="ai_loader" class="hidden text-center py-6">--}}
{{--                            <div class="inline-block animate-spin rounded-full h-6 w-6 border-2 border-blue-900 border-t-red-600"></div>--}}
{{--                            <p class="text-[10px] font-black uppercase mt-3 tracking-widest text-red-600">Нейросеть пишет...</p>--}}
{{--                        </div>--}}

{{--                        <div class="pt-6 border-t border-gray-100">--}}
{{--                            <p class="text-[9px] font-black text-gray-400 uppercase mb-4 tracking-tighter">Популярные сценарии:</p>--}}
{{--                            <div class="grid grid-cols-1 gap-2">--}}
{{--                                <button onclick="useTemplate('Объяснительная записка об опоздании')" class="text-left text-[9px] font-black uppercase p-3 border border-blue-50 rounded-xl hover:border-blue-900 hover:bg-blue-50 transition-all text-blue-900">🚩 Опоздание</button>--}}
{{--                                <button onclick="useTemplate('Запрос на предоставление отпуска')" class="text-left text-[9px] font-black uppercase p-3 border border-blue-50 rounded-xl hover:border-blue-900 hover:bg-blue-50 transition-all text-blue-900">🏖 Заявление на отпуск</button>--}}
{{--                                <button onclick="useTemplate('Акт приема-передачи ключей')" class="text-left text-[9px] font-black uppercase p-3 border border-blue-50 rounded-xl hover:border-blue-900 hover:bg-blue-50 transition-all text-blue-900">🔑 Акт приема-передачи</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        function useTemplate(text) {--}}
{{--            document.getElementById('ai_prompt').value = text;--}}
{{--        }--}}

{{--        async function generateAI() {--}}
{{--            const prompt = document.getElementById('ai_prompt').value;--}}
{{--            const btn = document.getElementById('ai_btn');--}}
{{--            const loader = document.getElementById('ai_loader');--}}
{{--            const textarea = document.getElementById('doc_content');--}}

{{--            if(!prompt) return alert('О чем должен быть документ?');--}}

{{--            btn.classList.add('hidden');--}}
{{--            loader.classList.remove('hidden');--}}

{{--            try {--}}
{{--                const response = await fetch('/admin/ai-generate', {--}}
{{--                    method: 'POST',--}}
{{--                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },--}}
{{--                    body: JSON.stringify({ prompt: prompt, type: document.getElementById('doc_type').value })--}}
{{--                });--}}

{{--                const data = await response.json();--}}

{{--                textarea.value = "";--}}
{{--                let i = 0;--}}
{{--                function type() {--}}
{{--                    if (i < data.text.length) {--}}
{{--                        textarea.value += data.text.charAt(i);--}}
{{--                        i++;--}}
{{--                        setTimeout(type, 10);--}}
{{--                    }--}}
{{--                }--}}
{{--                type();--}}
{{--            } catch (e) {--}}
{{--                alert('Ошибка соединения с AI');--}}
{{--            } finally {--}}
{{--                btn.classList.remove('hidden');--}}
{{--                loader.classList.add('hidden');--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
