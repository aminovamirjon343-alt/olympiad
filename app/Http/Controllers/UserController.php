<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document; // Импортируем модель документов
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Импортируем фасад DB для сырых запросов
use Illuminate\Support\Facades\Hash; // Рекомендуется для работы с паролями

class UserController extends Controller
{
    /**
     * Список всех пользователей
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Форма создания пользователя
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Сохранение нового пользователя
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string',
            'role'     => 'required|in:admin,employee,director,user',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created 👤');
    }

    /**
     * Просмотр профиля пользователя и его активности
     */
    public function show(User $user)
    {
        // Собираем данные об активности пользователя (созданные документы) за текущий год
        $activityData = Document::where('created_by', $user->id)
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return view('users.show', compact('user', 'activityData'));
    }

    /**
     * Форма редактирования
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Обновление данных пользователя
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'role'  => 'required|in:admin,employee,director,user',
        ]);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Updated');
    }

    /**
     * Удаление пользователя
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted');
    }
}
