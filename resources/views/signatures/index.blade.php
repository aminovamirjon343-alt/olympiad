
    <div class="container">
        <h2 class="mb-3">Подписи</h2>

        {{-- 🔥 КНОПКА ДОБАВЛЕНИЯ --}}
        <a href="{{ route('signatures.create') }}" class="btn btn-primary mb-3">
            + Добавить подпись
        </a>

        {{-- сообщения --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table  border="1">
            <thead>
            <tr>
                <th>ID</th>
                <th>Документ</th>
                <th>Пользователь</th>
                <th>Подпись</th>
                <th>Дата</th>
                <th width="200">Действия</th>
            </tr>
            </thead>

            <tbody>
            @forelse($signatures as $s)
                <tr>
                    <td>{{ $s->id }}</td>

                    {{-- ✅ безопасно --}}
                    <td>{{ $s->document->title ?? '—' }}</td>

                    <td>{{ $s->user->name ?? '—' }}</td>

                    <td>
                        @if($s->signature)
                            <img src="{{ $s->signature }}" width="120">
                        @else
                            —
                        @endif
                    </td>

                    <td>
                        {{ $s->signed_at
                            ? \Carbon\Carbon::parse($s->signed_at)->format('d.m.Y H:i')
                            : '—' }}
                    </td>

                    <td>
                        <a href="{{ route('signatures.show', $s->id) }}"
                           class="btn btn-info btn-sm">
                            View
                        </a>

                        <a href="{{ route('signatures.edit', $s->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('signatures.destroy', $s->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Удалить подпись?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Нет подписей
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $signatures->links() }}
    </div>

