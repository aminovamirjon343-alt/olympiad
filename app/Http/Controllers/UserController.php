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

        $data['password'] = Hash::make($data['password']);

        $data['created_by'] = auth()->id();

        User::create($data);

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
        $myRole = strtolower(trim($authUser->role ?? ''));
        $targetRole = strtolower(trim($user->role));

       if ($targetRole === 'user') {
            return redirect()->route('users.index')->with('error', 'Пользователи с ролью USER неприкасаемы.');
        }

        // Защита создателя системы (ID 10)
        if ($user->id === 10 && $authId !== 10) {
            return redirect()->route('users.index')->with('error', 'Вы не можете редактировать Создателя системы.');
        }

        $isMe = ($user->id === $authId);
        $isMainAdmin = ($authId === 10);
        $isCreator = ((int)$user->created_by === $authId);

        // Разрешено, если это мой профиль, я Главный админ, или я админ, который создал этого юзера
        if ($isMe || $isMainAdmin || ($myRole === 'admin' && $isCreator)) {
            return view('users.edit', compact('user'));
        }

        return redirect()->route('users.index')->with('error', 'Вы можете редактировать только тех, кого добавили сами.');
    }

    public function update(Request $request, User $user)
    {
        $authId = (int)Auth::id();
        $authUser = Auth::user();
        $myRole = strtolower(trim($authUser->role ?? ''));
        $targetRole = strtolower(trim($user->role));

        // 🛑 ЗАЩИТА РОЛИ USER на сохранение
        if ($targetRole === 'user') {
            return redirect()->route('users.index')->with('error', 'Изменение пользователей с ролью USER запрещено.');
        }

        if ($user->id === 10 && $authId !== 10) {
            return redirect()->route('users.index')->with('error', 'Изменение данных Создателя системы запрещено.');
        }

        $isMe = ($user->id === $authId);
        $isMainAdmin = ($authId === 10);
        $isCreator = ((int)$user->created_by === $authId);

        if (!$isMe && !$isMainAdmin && !($myRole === 'admin' && $isCreator)) {
            return redirect()->route('users.index')->with('error', 'У вас нет прав на обновление этого профиля.');
        }

        $rules = [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ];

        // Менять роль могут только авторы записи или главный админ
        if (($isMainAdmin || $isCreator) && !$isMe) {
            $rules['role'] = 'required|in:admin,employee,director,user';
        }

        $data = $request->validate($rules);

        if ($isMe || (!$isMainAdmin && !$isCreator)) {
            $data['role'] = $user->role;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Данные обновлены ✅');
    }

    public function destroy(User $user)
    {
        $authId = (int)Auth::id();
        $authUser = Auth::user();
        $myRole = strtolower(trim($authUser->role ?? ''));
        $targetRole = strtolower(trim($user->role ?? ''));

        // Защита клиентов системы от удаления обычными админами
        if (in_array($targetRole, ['user', 'корбар']) && $authId !== 10) {
            return back()->with('error', 'Вы не можете удалять зарегистрированных клиентов.');
        }

        if ($user->id === $authId) {
            return back()->with('error', 'Вы не можете удалить самого себя.');
        }

        if ($user->id === 10) {
            return back()->with('error', 'Этот аккаунт защищен от удаления.');
        }

        $isMainAdmin = ($authId === 10);
        $isCreator = ((int)$user->created_by === $authId);

        if ($isMainAdmin || ($myRole === 'admin' && $isCreator)) {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Пользователь успешно удален.');
        }

        return back()->with('error', 'Вы можете удалять только тех сотрудников, которых добавили сами.');
    }
}
