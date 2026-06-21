@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Создать нового пользователя</h1>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Упс!</strong>
        <span class="block sm:inline">Возникли проблемы с вашим вводом.</span>
        <ul class="mt-3 list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('superadmin.users.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Имя:</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
            @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
            @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Пароль:</label>
            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" required>
            @error('password') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Подтверждение пароля:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        {{-- ⚠️ ИСПРАВЛЕНИЕ: Добавлен hidden input для корректной работы old() при снятой галочке --}}
        <div class="mb-4 flex items-center">
            <input type="hidden" name="is_admin" value="0">
            <input type="checkbox" name="is_admin" id="is_admin" value="1" class="mr-2 leading-tight" {{ old('is_admin') ? 'checked' : '' }}>
            <label for="is_admin" class="text-sm text-gray-700">Сделать администратором</label>
        </div>

        <div class="mb-6 flex items-center">
            <input type="hidden" name="is_super_admin" value="0">
            <input type="checkbox" name="is_super_admin" id="is_super_admin" value="1" class="mr-2 leading-tight" {{ old('is_super_admin') ? 'checked' : '' }}>
            <label for="is_super_admin" class="text-sm text-gray-700">Сделать супер администратором</label>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Создать</button>
            <a href="{{ route('superadmin.users.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Отмена</a>
        </div>
    </form>
</div>
@endsection