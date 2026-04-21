<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // список
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // форма создания
    public function create()
    {
        return view('users.create');
    }

    // сохранить
    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role ?? 'user',
        ]);

        return redirect()->route('users.index')->with('success', 'User created');
    }

    // показать
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // форма редактирования
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // обновить
    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Updated');
    }

    // удалить
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
