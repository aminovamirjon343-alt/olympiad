@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="mb-3">Просмотр лога</h2>

        <div class="card">
            <div class="card-body">

                <p><strong>ID:</strong> {{ $log->id }}</p>

                <p><strong>Документ:</strong>
                    {{ $log->document->title ?? '—' }}
                </p>

                <p><strong>Пользователь:</strong>
                    {{ $log->user->name ?? 'Система' }}
                </p>

                <p><strong>Действие:</strong>
                    <span class="badge bg-info">
                    {{ $log->action }}
                </span>
                </p>

                <p><strong>Описание:</strong><br>
                    {{ $log->description ?? '—' }}
                </p>

                <p><strong>Создано:</strong>
                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                </p>

                <p><strong>Обновлено:</strong>
                    {{ $log->updated_at->format('Y-m-d H:i:s') }}
                </p>

            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('logs.index') }}" class="btn btn-secondary">
                ← Назад
            </a>

            <a href="{{ route('logs.edit', $log->id) }}" class="btn btn-warning">
                ✏️ Редактировать
            </a>

            <form action="{{ route('logs.destroy', $log->id) }}"
                  method="POST"
                  style="display:inline-block;">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger"
                        onclick="return confirm('Удалить лог?')">
                    🗑 Удалить
                </button>
            </form>
        </div>

    </div>
@endsection
