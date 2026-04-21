
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-secondary">История версий документов</h2>
            <a href="{{ route('versions.create') }}" class="btn btn-primary px-4 shadow-sm">
                <i class="fas fa-plus"></i> Добавить версию
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" border="1">
                        <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Документ</th>
                            <th class="text-center">№ Версии</th>
                            <th>Файл</th>
                            <th class="text-end pe-3">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($versions as $v)
                            <tr>
                                <td class="ps-3 text-muted">#{{ $v->id }}</td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $v->document->title }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark">v.{{ $v->version }}</span>
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $v->file_path) }}"
                                       target="_blank"
                                       class="btn btn-link btn-sm text-decoration-none">
                                        📄 Открыть файл
                                    </a>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('versions.show', $v->id) }}" class="btn btn-outline-info btn-sm">
                                            Смотреть
                                        </a>
                                        <a href="{{ route('versions.edit', $v->id) }}" class="btn btn-outline-warning btn-sm">
                                            Правка
                                        </a>
                                        <form action="{{ route('versions.destroy', $v->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Вы уверены? Это действие нельзя отменить.')">
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Версии пока не созданы. <a href="{{ route('versions.create') }}">Создать первую?</a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $versions->links() }}
        </div>
    </div>

