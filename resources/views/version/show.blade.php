@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Версия {{ $version->version }}</h2>

        <p>Документ: {{ $version->document->title }}</p>

        <a href="{{ asset('storage/' . $version->file_path) }}" target="_blank">
            Открыть файл
        </a>
    </div>
@endsection
