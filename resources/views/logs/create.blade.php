
    <div class="container">

        <h2>Создать лог</h2>

        {{-- ошибки --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('logs.store') }}" method="POST">
            @csrf

            {{-- документ --}}
            <div class="mb-3">
                <label>Документ</label>
                <select name="document_id" class="form-control">
                    @foreach($documents as $document)
                        <option value="{{ $document->id }}">
                            {{ $document->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- пользователь --}}
            <div class="mb-3">
                <label>Пользователь</label>
                <select name="user_id" class="form-control">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- действие --}}
            <div class="mb-3">
                <label>Действие</label>
                <select name="action" class="form-control">
                    <option value="created">Создание</option>
                    <option value="updated">Обновление</option>
                    <option value="deleted">Удаление</option>
                    <option value="signed">Подписание</option>
                    <option value="status_changed">Смена статуса</option>
                </select>
            </div>

            {{-- описание --}}
            <div class="mb-3">
                <label>Описание</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Сохранить</button>
            <a href="{{ route('logs.index') }}" class="btn btn-secondary">Назад</a>

        </form>
    </div>

