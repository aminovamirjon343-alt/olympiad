@extends('layouts.app')

@section('content')
    <div class="container">

        <h2>Редактировать лог</h2>

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

        <form action="{{ route('logs.update', $log->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- документ --}}
            <div class="mb-3">
                <label>Документ</label>
                <select name="document_id" class="form-control">
                    @foreach($documents as $document)
                        <option value="{{ $document->id }}"
                            {{ $log->document_id == $document->id ? 'selected' : '' }}>
                            {{ $document->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- пользователь --}}
            <div class="mb-3">
                <label>Пользователь</label>
                <select name="user_id" class="form-control">
                    <option value="">Система</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ $log->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- действие --}}
            <div class="mb-3">
                <label>Действие</label>
                <select name="action" class="form-control">
                    <option value="created" {{ $log->action == 'created' ? 'selected' : '' }}>Создание</option>
                    <option value="updated" {{ $log->action == 'updated' ? 'selected' : '' }}>Обновление</option>
                    <option value="deleted" {{ $log->action == 'deleted' ? 'selected' : '' }}>Удаление</option>
                    <option value="signed" {{ $log->action == 'signed' ? 'selected' : '' }}>Подписание</option>
                    <option value="status_changed" {{ $log->action == 'status_changed' ? 'selected' : '' }}>Смена статуса</option>
                </select>
            </div>

            {{-- описание --}}
            <div class="mb-3">
                <label>Описание</label>
                <textarea name="description" class="form-control">{{ $log->description }}</textarea>
            </div>

            <button class="btn btn-primary">Обновить</button>
            <a href="{{ route('logs.index') }}" class="btn btn-secondary">Назад</a>

        </form>

    </div>
@endsection
