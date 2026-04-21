@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Подпись</h2>

        <div class="card">
            <div class="card-body">

                <p><strong>Документ:</strong> {{ $signature->document->title }}</p>

                <p><strong>Пользователь:</strong> {{ $signature->user->name }}</p>

                <p><strong>Дата:</strong> {{ $signature->signed_at }}</p>

                <p><strong>Подпись:</strong></p>
                <img src="{{ $signature->signature }}" width="300">

            </div>
        </div>

        <a href="{{ route('signatures.index') }}" class="btn btn-secondary mt-3">Назад</a>
    </div>
@endsection
