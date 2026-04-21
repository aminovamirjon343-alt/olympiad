@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-paper-plane"></i> Отправить уведомление</h4>
                    </div>

                    <div class="card-body p-4">
                        {{-- Вывод ошибок --}}
                        @if ($errors->any())
                            <div class="alert alert-danger shadow-sm">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('notifications.store') }}" method="POST">
                            @csrf

                            {{-- Пользователь --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Получатель</label>
                                <select name="user_id" class="form-select form-select-lg shadow-sm" required>
                                    <option value="" disabled selected>-- Выберите пользователя --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} (ID: {{ $user->id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Тип --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Категория</label>
                                <div class="row px-2">
                                    <div class="col-md-4">
                                        <div class="form-check custom-option">
                                            <input class="form-check-input" type="radio" name="type" id="type_doc" value="document" {{ old('type', 'document') == 'document' ? 'checked' : '' }}>
                                            <label class="form-check-label text-success fw-bold" for="type_doc">
                                                <i class="fas fa-file-alt"></i> Документ
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check custom-option">
                                            <input class="form-check-input" type="radio" name="type" id="type_sign" value="sign" {{ old('type') == 'sign' ? 'checked' : '' }}>
                                            <label class="form-check-label text-warning fw-bold" for="type_sign">
                                                <i class="fas fa-pen-nib"></i> Подпись
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check custom-option">
                                            <input class="form-check-input" type="radio" name="type" id="type_reject" value="reject" {{ old('type') == 'reject' ? 'checked' : '' }}>
                                            <label class="form-check-label text-danger fw-bold" for="type_reject">
                                                <i class="fas fa-times-circle"></i> Отклонение
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Сообщение --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Текст уведомления</label>
                                <textarea name="message" class="form-control shadow-sm" rows="4" placeholder="Введите текст сообщения..." required>{{ old('message') }}</textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end border-top pt-3">
                                <a href="{{ route('notifications.index') }}" class="btn btn-light px-4">Отмена</a>
                                <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                    <i class="fas fa-save me-1"></i> Отправить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-select-lg { font-size: 1rem; }
        .custom-option {
            padding: 10px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .custom-option:hover { background: #f8f9fa; }
    </style>
@endsection
