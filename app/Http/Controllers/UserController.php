<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class UserController extends Controller
{
    use Notifiable;
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function documents()
    {
        // Указываем 'created_by' в качестве внешнего ключа
        return $this->hasMany(\App\Models\Document::class, 'created_by');
    }

    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string',
            'role'     => 'required|in:admin,employee,director,user',
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created 👤');
    }


    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


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


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

}
