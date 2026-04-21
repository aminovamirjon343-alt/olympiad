
    <div class="container py-5">
        <div class="row mb-4 align-items-end">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark mb-1">Центр уведомлений</h2>
                <p class="text-muted mb-0">Управляйте вашими системными оповещениями и событиями ЭДО</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('notifications.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-1"></i> Создать уведомление
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="list-group list-group-flush">
                @forelse($notifications as $n)
                    <div class="list-group-item p-4 border-0 {{ !$n->is_read ? 'bg-light-blue' : '' }} border-bottom">
                        <div class="row">
                            <div class="col-auto">
                                <div class="icon-shape rounded-circle
                                @if($n->type == 'sign') bg-warning-soft text-warning
                                @elseif($n->type == 'document') bg-success-soft text-success
                                @elseif($n->type == 'reject') bg-danger-soft text-danger
                                @else bg-primary-soft text-primary @endif">
                                    <i class="fas
                                    @if($n->type == 'sign') fa-pen-nib
                                    @elseif($n->type == 'document') fa-file-alt
                                    @elseif($n->type == 'reject') fa-times-circle
                                    @else fa-info-circle @endif"></i>
                                </div>
                            </div>

                            <div class="col ms-2">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1 fw-bold {{ !$n->is_read ? 'text-primary' : 'text-dark' }}">
                                        {{ $n->message }}
                                    </h6>

                                    {{-- Кнопка "Прочитано" остается сверху справа, если не прочитано --}}
                                    @if(!$n->is_read)
                                        <form action="{{ route('notifications.read', $n->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-light border shadow-sm text-success" title="Отметить прочитанным">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="small text-muted mb-3">
                                    <i class="far fa-clock me-1"></i> {{ $n->created_at ? $n->created_at->diffForHumans() : 'Неизвестно' }}
                                </div>

                                <form action="{{ route('notifications.destroy', $n->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill"
                                            onclick="return confirm('Удалить это уведомление?')">
                                        <i class="fas fa-trash-alt me-1"></i> Удалить уведомление
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <h5 class="text-muted">Уведомлений нет</h5>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <style>
        .bg-light-blue { background-color: #f0f7ff; }
        .icon-shape { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
        .bg-primary-soft { background-color: #e7f1ff; }
        .bg-success-soft { background-color: #e6fcf5; }
        .bg-warning-soft { background-color: #fff9db; }
        .bg-danger-soft { background-color: #fff5f5; }
        .btn-outline-danger:hover { color: white; }
    </style>

