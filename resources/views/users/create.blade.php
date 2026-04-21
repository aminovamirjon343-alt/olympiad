@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create User</h2>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <input name="name" placeholder="Name" class="form-control mb-2"><br>
            <input name="email" placeholder="Email" class="form-control mb-2"><br>
            <input name="password" type="password" placeholder="Password" class="form-control mb-2"><br>
            <input name="phone" placeholder="Phone" class="form-control mb-2"><br>

            <select name="role" class="form-control mb-2"><br>
                <option value="viewer">Наблюдатель</option>
                <option value="employee">Сотрудник</option>
                <option value="director">Директор</option>
                <option value="admin">Администратор</option>
            </select><br>

            <button class="btn btn-success">Save</button>
        </form>
    </div>
@endsection
