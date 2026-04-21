<div class="container">
    <h2 class="mb-4">Просмотр документа</h2>

    <div class="card">
        <div class="card-body">

            {{-- Title --}}
            <h4>{{ $document->title }}</h4>
            <hr>

            {{-- Content --}}
            <p>
                <strong>Содержимое:</strong><br>
                {{ $document->content ?? '—' }}
            </p>

            {{-- File --}}
            <p>
                <strong>Файл:</strong><br>
                @if ($document->file_path)
                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">
                        📎 Открыть файл
                    </a>
                @else
                    —
                @endif
            </p>

            {{-- Status --}}
            <p>
                <strong>Статус:</strong>
                <span class="badge bg-primary">
                    {{ ucfirst($document->status) }}
                </span>
            </p>

            {{-- Author --}}
            <p>
                <strong>Автор:</strong>
                {{ $document->user->name ?? 'Неизвестно' }}
            </p>

            {{-- Deadline --}}
            <p>
                <strong>Дедлайн:</strong>
                {{ $document->deadline ?? '—' }}
            </p>

            {{-- Dates --}}
            <p>
                <strong>Создан:</strong>
                {{ $document->created_at }}
            </p>

            <p>
                <strong>Обновлён:</strong>
                {{ $document->updated_at }}
            </p>

        </div>
    </div>

    {{-- 💬 COMMENTS SECTION --}}
    <div class="card mt-4">
        <div class="card-body">

            <h5 class="mb-3">💬 Комментарии</h5>

            {{-- form --}}
            <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                @csrf

                <input type="hidden" name="document_id" value="{{ $document->id }}">

                <textarea name="comment" class="form-control mb-2" placeholder="Напишите комментарий..." required></textarea>

                <button class="btn btn-primary" type="submit">
                    Отправить
                </button>
            </form>

            {{-- list --}}
            @forelse($comments as $comment)
                <div class="border rounded p-2 mb-2">

                    <strong>
                        👤 {{ $comment->user->name ?? 'User' }}
                    </strong>

                    <p class="mb-1">
                        {{ $comment->comment }}
                    </p>

                    <small class="text-muted">
                        {{ optional($comment->created_at)->format('Y-m-d H:i') }}
                    </small>

                </div>
            @empty
                <div class="alert alert-info">
                    Нет комментариев
                </div>
            @endforelse

        </div>
    </div>

    {{-- Buttons --}}
    <div class="mt-3">
        <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning">
            Редактировать
        </a>

        <form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Удалить документ?')">
                Удалить
            </button>
        </form>

        <a href="{{ route('documents.index') }}" class="btn btn-secondary">
            Назад
        </a>
    </div>
</div>
