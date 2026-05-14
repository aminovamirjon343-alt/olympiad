<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
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

        $user = new User($data);
        $user->password = Hash::make($request->password);
        $user->created_by = Auth::id();
        $user->save();

        return redirect()->route('users.index')->with('success', 'Пользователь создан!');
    }

    public function show(User $user)
    {
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

    public function edit(User $user)
    {
        $authId = (int)auth()->id();
        $creatorId = $user->created_by;

        // 1. Вместо abort — перенаправляем назад в профиль с ошибкой
        if (strtolower($user->role) === 'user') {
            return redirect()->route('users.show', $user->id)
                ->with('error', 'Роль USER неприкасаема');
        }

        // 2. РАЗРЕШАЕМ РЕДАКТИРОВАНИЕ
        if (
            $user->id === $authId ||
            (int)$creatorId === $authId ||
            ($authId === 10 && is_null($creatorId))
        ) {
            return view('users.edit', compact('user'));
        }

        // Вместо abort для всех остальных случаев
        return redirect()->route('users.show', $user->id)
            ->with('error', "Вы не можете редактировать этого пользователя. Создатель ID: " . ($creatorId ?? 'не указан'));
    }

    public function update(Request $request, User $user)
    {
        $authId = (int)Auth::id();

        // Защита: роль 'user'
        if (strtolower($user->role) === 'user') {
            return redirect()->route('users.show', $user->id)
                ->with('error', 'Этого пользователя нельзя изменять');
        }

        $isOwner = (int)$user->created_by === $authId;
        $isSelf = $user->id === $authId;
        $isSuperAdminFix = ($authId === 10 && is_null($user->created_by));

        if (!$isOwner && !$isSuperAdminFix && !$isSelf) {
            return redirect()->route('users.show', $user->id)
                ->with('error', 'У вас нет прав на обновление этого профиля');
        }

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'role'  => 'required|in:admin,employee,director,user',
        ]);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Данные обновлены ✅');
    }

    public function destroy(User $user)
    {
        $authUser = Auth::user();

        if ($user->id === $authUser->id) {
            return back()->with('error', 'Вы не можете удалить самого себя');
        }

        if (strtolower($user->role) === 'user') {
            return back()->with('error', 'Этого пользователя нельзя трогать, он независим');
        }

        if ((int)$user->created_by !== (int)$authUser->id && (int)$authUser->id !== 10) {
            return back()->with('error', 'Вы можете удалять только тех, кого добавили сами');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Сотрудник удален');
    }
}
