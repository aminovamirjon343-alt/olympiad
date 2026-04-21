
    <div class="container">

        <h2 class="mb-3">Логи</h2>
        <div class="mb-3">
            <a href="{{ route('logs.create') }}" class="btn btn-success">
                + Добавить лог
            </a>
        </div>
        {{-- сообщение --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- таблица --}}
        <table border="1">
            <thead>
            <tr>
                <th>ID</th>
                <th>Документ</th>
                <th>Пользователь</th>
                <th>Действие</th>
                <th>Описание</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
            </thead>

            <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>

                    <td>
                        {{ $log->document->title ?? '—' }}
                    </td>

                    <td>
                        {{ $log->user->name ?? 'Система' }}
                    </td>

                    <td>
                    <span class="badge bg-info">
                        {{ $log->action }}
                    </span>
                    </td>

                    <td>
                        {{ $log->description}}
                    </td>

                    <td>
                        {{ $log->created_at->format('Y-m-d H:i') }}
                    </td>

                    <td>
                        {{-- просмотр --}}
                        <a href="{{ route('logs.show', $log->id) }}"
                           class="btn btn-sm btn-primary">
                            👁
                        </a>

                        {{-- редактировать --}}
                        <a href="{{ route('logs.edit', $log->id) }}"
                           class="btn btn-sm btn-warning">
                            ✏️
                        </a>

                        {{-- удалить --}}
                        <form action="{{ route('logs.destroy', $log->id) }}"
                              method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Удалить лог?')">
                                🗑
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Нет логов
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- пагинация --}}
        <div class="mt-3">
            {{ $logs->links() }}
        </div>

    </div>

