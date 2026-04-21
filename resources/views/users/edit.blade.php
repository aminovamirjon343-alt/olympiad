@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit User</h2>

        <form method="POST" action="{{ route('users.update',$user->id) }}">
            @csrf
            @method('PUT')

            <input name="name" value="{{ $user->name }}" class="form-control mb-2"><br>
            <input name="email" value="{{ $user->email }}" class="form-control mb-2"><br>
            <input name="phone" value="{{ $user->phone }}" class="form-control mb-2"><br>

            <select name="role" class="form-control mb-2"><br>
                <option value="viewer" {{ $user->role=='viewer' ? 'selected' : '' }}>Наблюдатель</option>
                <option value="employee" {{ $user->role=='employee' ? 'selected' : '' }}>Сотрудник</option>
                <option value="director" {{ $user->role=='director' ? 'selected' : '' }}>Директор</option>
                <option value="admin" {{ $user->role=='admin' ? 'selected' : '' }}>Администратор</option>
            </select><br>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
