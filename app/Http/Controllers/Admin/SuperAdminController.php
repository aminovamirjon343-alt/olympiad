<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use App\Models\ActivityLog;
use App\Models\DocumentSignature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $totalSuperAdmins = User::where('is_super_admin', true)->count();
        $totalDocuments = Document::count();
        $totalSignedDocuments = DocumentSignature::count();

        // Статистика удалений
        $totalDeletedUsers = ActivityLog::where('action', 'user_deleted')->count();
        $totalDeletedDocuments = ActivityLog::where('action', 'document_deleted')->count();

        // Статистика за сегодня
        $todayLogins = ActivityLog::where('action', 'login')
            ->whereDate('created_at', today())->count();
        $todayDocuments = Document::whereDate('created_at', today())->count();
        $todaySignatures = DocumentSignature::whereDate('created_at', today())->count();

        // Статистика за неделю
        $weekLogins = ActivityLog::where('action', 'login')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        // Последние входы
        $latestLogins = ActivityLog::where('action', 'login')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Последние действия
        $recentActivities = ActivityLog::with(['user'])
            ->latest()
            ->take(20)
            ->get();

        // ✅ РЕАЛЬНЫЕ активные пользователи (за последние 5 минут)
        $activeUsers = User::where('last_seen_at', '>=', now()->subMinutes(5))->count();

        // Все пользователи
        $allUsers = User::latest()->get();

        // Последние пользователи
        $latestUsers = User::latest()->take(5)->get();

        // Документы по статусам
        $documentsByStatus = Document::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return view('admin.superadmin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalSuperAdmins',
            'totalDocuments',
            'totalSignedDocuments',
            'totalDeletedUsers',
            'totalDeletedDocuments',
            'todayLogins',
            'todayDocuments',
            'todaySignatures',
            'weekLogins',
            'latestLogins',
            'recentActivities',
            'activeUsers',
            'allUsers',
            'latestUsers',
            'documentsByStatus'
        ));
    }

    public function userActivity(User $user)
    {
        // Получаем все действия этого пользователя
        $activities = ActivityLog::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->paginate(50);

        // Статистика по действиям
        $stats = ActivityLog::where('user_id', $user->id)
            ->selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->pluck('count', 'action');

        // Последний вход
        $lastLogin = ActivityLog::where('user_id', $user->id)
            ->where('action', 'login')
            ->latest()
            ->first();

        // ✅ ИСПРАВЛЕНО: используем created_by вместо user_id
        $documentsCount = Document::where('created_by', $user->id)->count();

        return view('admin.superadmin.user-activity', compact(
            'user',
            'activities',
            'stats',
            'lastLogin',
            'documentsCount'
        ));
    }
    public function usersIndex()
    {
        $users = User::where('id', '!=', auth()->id())->paginate(15);
        return view('admin.superadmin.index', compact('users'));
    }

    public function create()
    {
        return view('admin.superadmin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'is_super_admin' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->boolean('is_admin'),
            'is_super_admin' => $request->boolean('is_super_admin'),
        ]);

        // Логируем создание пользователя
        \App\Services\ActivityLogger::userCreated($user);

        return redirect()->route('superadmin.users.index')->with('success', 'Пользователь успешно создан.');
    }

    public function edit(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('superadmin.users.index')->with('error', 'Вы не можете редактировать свой собственный аккаунт.');
        }
        return view('admin.superadmin.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('superadmin.users.index')->with('error', 'Вы не можете редактировать свой собственный аккаунт.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'is_super_admin' => 'boolean',
        ]);

        $changes = [];

        if ($user->name !== $request->name) {
            $changes['name'] = [$user->name, $request->name];
        }
        if ($user->email !== $request->email) {
            $changes['email'] = [$user->email, $request->email];
        }
        if ($request->filled('password')) {
            $changes['password'] = ['***', '***'];
        }
        if ($user->is_admin !== $request->boolean('is_admin')) {
            $changes['is_admin'] = [$user->is_admin, $request->boolean('is_admin')];
        }
        if ($user->is_super_admin !== $request->boolean('is_super_admin')) {
            $changes['is_super_admin'] = [$user->is_super_admin, $request->boolean('is_super_admin')];
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->is_admin = $request->boolean('is_admin');
        $user->is_super_admin = $request->boolean('is_super_admin');
        $user->save();

        // Логируем изменения
        \App\Services\ActivityLogger::log(
            'user_updated',
            $user,
            "Обновлены данные пользователя: {$user->email}",
            ['changes' => $changes]
        );

        return redirect()->route('superadmin.users.index')->with('success', 'Пользователь успешно обновлен.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('superadmin.users.index')->with('error', 'Вы не можете удалить свой собственный аккаунт.');
        }

        $userName = $user->name;
        $user->delete();

        // Логируем удаление
        \App\Services\ActivityLogger::log(
            'user_deleted',
            null,
            "Удален пользователь: {$userName}",
            ['deleted_user_id' => $user->id]
        );

        return redirect()->route('superadmin.users.index')->with('success', 'Пользователь успешно удален.');
    }
    public function activityIndex(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Фильтрация по действию
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Фильтрация по пользователю
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Фильтрация по дате
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(50);
        $users = User::all();

        return view('admin.superadmin.activity', compact('activities', 'users'));
    }
}