
    <div>

        <h2>Создать документ</h2>

        {{-- Ошибки --}}
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <p>
                Название:<br>
                <input type="text" name="title" value="{{ old('title') }}">
            </p>

            <p>
                Описание:<br>
                <textarea name="content">{{ old('content') }}</textarea>
            </p>

            <p>
                Файл:<br>
                <input type="file" name="file_path">
            </p>

            <p>
                Статус:<br>
                <select name="status">
                    <option value="draft">Черновик</option>
                    <option value="active">Активный</option>
                </select>
            </p>

            <select name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            <p>
                Дедлайн:<br>
                <input type="date" name="deadline" value="{{ old('deadline') }}">
            </p>

            <button type="submit">Сохранить</button>
            <a href="{{ route('documents.index') }}">Назад</a>

        </form>

    </div>

