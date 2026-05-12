<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password; // ИСПРАВЛЕНО: правильный класс для defaults()
use Illuminate\View\View;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Отображение профиля с активностью за месяц
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        $startDate = now()
            ->startOfWeek(Carbon::MONDAY)
            ->subWeeks(52);

        $activityData = \App\Models\Document::where('created_by', $user->id)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date_only, COUNT(*) as count')
            ->groupBy('date_only')
            ->pluck('count', 'date_only')
            ->toArray();

        return view('profile.show', compact(
            'user',
            'activityData',
            'startDate',

        ));
    }
//    public function show(Request $request): View
//    {
//        $user = $request->user();
//        $month = (int) $request->get('month', Carbon::now()->month);
//        $year = (int) $request->get('year', Carbon::now()->year);
//        $activityData = Document::where('user_id', $user->id)
//            ->where('created_at', '>=', now()->subYear())
//            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
//            ->groupBy('date')
//            ->pluck('count', 'date');
//        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
//        $endDate = $startDate->copy()->endOfMonth();
//
//        $dbData = Document::where('user_id', $user->id)
//            ->whereDate('created_at', '>=', $startDate->toDateString())
//            ->whereDate('created_at', '<=', $endDate->toDateString())
//            ->select(DB::raw('DATE(created_at) as date_only'), DB::raw('count(*) as count'))
//            ->groupBy('date_only')
//            ->pluck('count', 'date_only')
//            ->toArray();
//
//        $activityData = [];
//        for ($day = 1; $day <= $startDate->daysInMonth; $day++) {
//            $dateKey = $startDate->copy()->day($day)->format('Y-m-d');
//            $activityData[$dateKey] = $dbData[$dateKey] ?? 0;
//        }
//
//        return view('profile.show', compact('user', 'activityData', 'startDate', 'endDate'));
//    }

    /**
     * Форма редактирования
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Обновление данных профиля (Имя, Email)
     */
    /**
     * Обновление данных профиля (Имя, Email, Телефон)
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Добавляем 'phone' в валидацию
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'], // Добавили проверку для телефона
        ]);

        // 2. Заполняем модель валидированными данными
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 3. Сохраняем (phone запишется автоматически, если он в $fillable модели User)
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Обновление пароля (Отдельный метод)
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Удаление аккаунта
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'profile-deleted');
    }
}
