
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>📄 Документы</h2>
            <a href="{{ route('documents.create') }}" class="btn btn-primary">➕ Добавить</a>
        </div>

        {{-- Сообщение --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped" border="1">
            <thead>
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>Content</th>
                <th>Статус</th>
                <th>Дедлайн</th>
                <th>Файл</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($documents as $index=> $doc)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $doc->title }}</td>
                    <td>{{$doc->content}}</td>
                    <td>{{ $doc->status }}</td>
                    <td>{{ $doc->deadline }}</td>
                    <td>
                        @if($doc->file_path)
                            <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank">
                                📂 Открыть
                            </a>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-info btn-sm">👁</a>
                        <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-warning btn-sm">✏️</a>

                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Удалить?')" class="btn btn-danger btn-sm">🗑</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Нет документов</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Пагинация --}}
        <div class="mt-3">
            {{ $documents->links() }}
        </div>

    </div>

