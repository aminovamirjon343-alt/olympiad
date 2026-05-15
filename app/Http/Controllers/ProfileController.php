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
        $year = (int) $request->get('year', now()->year);

        // 1. Настройка дат и расчет недель для сетки
        $firstDayOfYear = Carbon::create($year, 1, 1);
        $startDate = $firstDayOfYear->copy()->startOfWeek(Carbon::MONDAY);
        $endDate = Carbon::create($year, 12, 31)->endOfWeek(Carbon::SUNDAY);

        // Вычисляем количество недель для сетки
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $weeksCount = (int) ceil($totalDays / 7);

        // 2. Получение активности (используем правильную колонку created_by)
        $activityData = Document::where('created_by', $user->id)
            ->whereYear('created_at', $year)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return view('profile.show', compact(
            'user',
            'activityData',
            'startDate',
            'year',
            'weeksCount'
        ));
    }
    public function updateGeneral(Request $request)
    {
        $user = auth()->user();

        // Валидация данных
        $data = $request->validate([
            'email_notifications' => 'nullable|string', // чекбоксы приходят как "on" или отсутствуют
            'tg_notifications'    => 'nullable|string',
            'language'            => 'required|string|in:ru,tg',
        ]);

        // Обновляем данные (преобразуем чекбоксы в boolean)
        $user->update([
            'email_notifications' => $request->has('email_notifications'),
            'tg_notifications'    => $request->has('tg_notifications'),
            'language'            => $data['language'],
        ]);

        return back()->with('success', 'Настройки успешно обновлены!');
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
