
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="mb-0">Добавить новую версию документа</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('versions.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="document_id" class="form-label">Выберите документ</label>
                        <select name="document_id" id="document_id" class="form-select @error('document_id') is-invalid @enderror">
                            @foreach($documents as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->title }}</option>
                            @endforeach
                        </select>
                        @error('document_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file_path" class="form-label">Файл версии (PDF, DOCX)</label>
                        <input type="file" name="file_path" id="file_path" class="form-control @error('file_path') is-invalid @enderror" required>
                        @error('file_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('versions.index') }}" class="btn btn-secondary">Назад к списку</a>
                        <button type="submit" class="btn btn-success">Загрузить и сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

