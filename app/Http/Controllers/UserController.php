<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();

        // Находим админа компании (level = 1)
        $admin = User::where('level', 1)
            ->where('company_id', $authUser->company_id)
            ->first();

        // Если админ не найден, ищем любого админа
        if (!$admin) {
            $admin = User::where('level', 1)->first();
        }

        // Название компании берём от админа
        $companyName = $admin ? $admin->company : ($authUser->company ?? __('users.my_team'));

        // Получаем пользователей компании
        if ($authUser->company_id) {
            $users = User::where('company_id', $authUser->company_id)->get()->keyBy('id');
        } else {
            $users = User::all()->keyBy('id');
        }

        $groupedByLevel = $users->groupBy('level')->sortKeys();

        return view('users.index', compact('users', 'groupedByLevel', 'authUser', 'companyName'));
    }
    public function create()
    {
        $authUser = auth()->user();

        // Только админ (level 1) может добавлять пользователей
        if (!$authUser->isAdmin()) {
            return redirect()->route('users.index')->with('error', __('users.only_admin_can_add'));
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        // Только админ может добавлять
        if (!$authUser->isAdmin()) {
            return redirect()->route('users.index')->with('error', __('users.only_admin_can_add'));
        }

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string',
            'role'     => 'required|string|max:50',
            'level'    => 'required|integer|min:2|max:20',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Получаем компанию админа
        $companyId = $authUser->company_id;
        $companyName = $authUser->company;

        // Если у админа нет company_id, но есть название компании
        if (!$companyId && $companyName) {
            $company = Company::where('name', $companyName)->first();

            if (!$company) {
                $company = Company::create([
                    'name' => $companyName,
                    'owner_id' => $authUser->id,
                ]);
            }

            $companyId = $company->id;

            $authUser->update([
                'company_id' => $companyId,
            ]);
        }

        // Хешируем пароль
        $data['password'] = Hash::make($data['password']);

        // Работник автоматически получает компанию админа
        $data['created_by'] = $authUser->id;
        $data['company_id'] = $companyId;
        $data['company'] = $companyName;

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', __('users.created_success'));
    }
    public function show(User $user)
    {
        $authUser = auth()->user();

        // Проверка: пользователь должен быть из той же компании
        if ($authUser->company_id && $user->company_id !== $authUser->company_id) {
            abort(403);
        }

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
        $authUser = auth()->user();

        // Проверка компании
        if ($authUser->company_id && $user->company_id !== $authUser->company_id) {
            return redirect()->route('users.index')->with('error', __('users.not_in_team'));
        }

        // Админ может редактировать всех, обычный пользователь только себя
        $canEdit = $authUser->isAdmin() || ($user->id === $authUser->id);

        if ($canEdit) {
            return view('users.edit', compact('user'));
        }

        return redirect()->route('users.index')->with('error', __('users.cannot_edit'));
    }

    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();

        // Проверка компании
        if ($authUser->company_id && $user->company_id !== $authUser->company_id) {
            return redirect()->route('users.index')->with('error', __('users.not_in_team'));
        }

        // Админ может редактировать всех, обычный пользователь только себя
        $canEdit = $authUser->isAdmin() || ($user->id === $authUser->id);

        if (!$canEdit) {
            return redirect()->route('users.index')->with('error', __('users.cannot_edit'));
        }

        $rules = [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'nullable|string',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_avatar' => 'nullable|string|in:0,1',
        ];

        // Только админ может менять роль и уровень
        if ($authUser->isAdmin()) {
            $rules['role'] = 'required|string|max:50';
            $rules['level'] = 'required|integer|min:1|max:20';
        }

        $data = $request->validate($rules);

        // Если не админ, сохраняем старые значения роли и уровня
        if (!$authUser->isAdmin()) {
            $data['role'] = $user->role;
            $data['level'] = $user->level;
        }

        if ($request->input('remove_avatar') === '1') {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', __('users.updated_success'));
    }

    public function destroy(User $user)
    {
        $authUser = auth()->user();

        // Проверка компании
        if ($authUser->company_id && $user->company_id !== $authUser->company_id) {
            return back()->with('error', __('users.not_in_team'));
        }

        // Нельзя удалить себя
        if ($user->id === $authUser->id) {
            return back()->with('error', __('users.cannot_delete_self'));
        }

        // Только админ может удалять
        if (!$authUser->isAdmin()) {
            return back()->with('error', __('users.only_admin_can_delete'));
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', __('users.deleted_success'));
    }
}