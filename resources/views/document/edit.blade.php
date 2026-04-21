@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Редактировать документ</h2>

        {{-- Ошибки --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title', $document->title) }}" required>
            </div>

            {{-- Content --}}
            <div class="mb-3">
                <label class="form-label">Содержимое</label>
                <textarea name="content" class="form-control" rows="5">{{ old('content', $document->content) }}</textarea>
            </div>

            {{-- File --}}
            <div class="mb-3">
                <label class="form-label">Файл</label>
                <input type="file" name="file_path" class="form-control">

                @if ($document->file_path)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">
                            📎 Текущий файл
                        </a>
                    </div>
                @endif
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Статус</label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ old('status', $document->status) == 'draft' ? 'selected' : '' }}>
                        Черновик
                    </option>
                    <option value="active" {{ old('status', $document->status) == 'active' ? 'selected' : '' }}>
                        Активный
                    </option>
                </select>
            </div>

            {{-- Deadline --}}
            <div class="mb-3">
                <label class="form-label">Дедлайн</label>
                <input type="date" name="deadline" class="form-control"
                       value="{{ old('deadline', $document->deadline) }}">
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Обновить</button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
