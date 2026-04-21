@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать версию</h2>

        <form method="POST" action="{{ route('versions.update', $version->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="file" name="file_path" class="form-control mb-2">

            <button class="btn btn-primary">Обновить</button>
        </form>
    </div>
@endsection
