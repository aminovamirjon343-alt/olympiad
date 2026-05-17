<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            'company'  => 'nullable|string|max:255',
            'role'     => 'required|in:admin,employee,director,user',
        ]);

        $user = new User($data);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Пользователь создан!');
    }

    public function show(User $user)
    {
        $year = now()->year;
        $firstDayOfYear = Carbon::create($year, 1, 1);
        $startDate = $firstDayOfYear->copy()->startOfWeek(Carbon::MONDAY);
        $lastDayOfYear = Carbon::create($year, 12, 31);
        $endDate = $lastDayOfYear->copy()->endOfWeek(Carbon::SUNDAY);
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $weeksCount = (int)ceil($totalDays / 7);

        $activityData = Document::where('created_by', $user->id)
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return view('users.show', compact('user', 'activityData', 'year', 'startDate', 'weeksCount'));
    }

    public function edit(User $user)
    {
        $authId = (int)auth()->id();
        $authUser = auth()->user();

        // 1. Защита: роль USER неприкасаема
        if (strtolower($user->role) === 'user') {
            return redirect()->route('users.show', $user->id)
                ->with('error', 'Роль USER неприкасаема');
        }

        // 2. Разрешаем редактирование (Опечатка исправлена здесь)
        if ($user->id === $authId || $authId === 10 || ($authUser && $authUser->role === 'admin')) {
            return view('users.edit', compact('user'));
        }

        return redirect()->route('users.show', $user->id)
            ->with('error', 'Вы не можете редактировать этого пользователя.');
    }

    public function update(Request $request, User $user)
    {
        $authId = (int)Auth::id();
        $authUser = Auth::user();

        if (strtolower($user->role) === 'user') {
            return redirect()->route('users.show', $user->id)
                ->with('error', 'Этого пользователя нельзя изменять');
        }

        $isSelf = $user->id === $authId;
        $isAdmin = ($authId === 10 || ($authUser && $authUser->role === 'admin'));

        if (!$isSelf && !$isAdmin) {
            return redirect()->route('users.show', $user->id)
                ->with('error', 'У вас нет прав на обновление этого профиля');
        }

        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'role'    => 'required|in:admin,employee,director,user',
        ]);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Данные обновлены ✅');
    }

    public function destroy(User $user)
    {
        $authUser = Auth::user();
        $authId = (int)Auth::id();

        if ($user->id === $authUser->id) {
            return back()->with('error', 'Вы не можете удалить самого себя');
        }

        if (strtolower($user->role) === 'user') {
            return back()->with('error', 'Этого пользователя нельзя трогать, он независим');
        }

        if ($authId !== 10 && $authUser->role !== 'admin') {
            return back()->with('error', 'У вас нет прав на удаление сотрудников');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Сотрудник удален');
    }
}
