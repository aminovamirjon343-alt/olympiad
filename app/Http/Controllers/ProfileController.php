<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
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
        $month = (int) $request->get('month', Carbon::now()->month);
        $year = (int) $request->get('year', Carbon::now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // 1. УПРОЩЕННЫЙ ЗАПРОС (без фильтра по дате для проверки)
        // Мы берем вообще ВСЕ даты документов этого юзера
        $allUserDocs = Document::where('user_id', $user->id)
            ->select(DB::raw('DATE(created_at) as date_only'))
            ->pluck('date_only')
            ->toArray();

        // 2. ОСНОВНОЙ ЗАПРОС (который должен работать)
        $dbData = Document::where('user_id', $user->id)
            ->whereDate('created_at', '>=', $startDate->toDateString())
            ->whereDate('created_at', '<=', $endDate->toDateString())
            ->select(DB::raw('DATE(created_at) as date_only'), DB::raw('count(*) as count'))
            ->groupBy('date_only')
            ->pluck('count', 'date_only')
            ->toArray();

        // ЕСЛИ ВСЁ ЕЩЕ ПУСТО, ДАВАЙ ПОСМОТРИМ ПОЧЕМУ
        if (empty($dbData)) {
            // Раскомментируй строку ниже, если хочешь увидеть, какие даты ВООБЩЕ есть в базе у этого юзера
            // dd(['ищем_диапазон' => $startDate->toDateString() . ' - ' . $endDate->toDateString(), 'реальные_даты_в_базе' => $allUserDocs]);
        }

        // 3. ФОРМИРУЕМ СЕТКУ
        $activityData = [];
        for ($day = 1; $day <= $startDate->daysInMonth; $day++) {
            $dateKey = $startDate->copy()->day($day)->format('Y-m-d');
            $activityData[$dateKey] = $dbData[$dateKey] ?? 0;
        }

        return view('profile.show', compact('user', 'activityData', 'startDate', 'endDate'));
    }

    /**
     * Форма редактирования (без изменений)
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Обновление данных (без изменений)
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Удаление аккаунта (без изменений)
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

        return Redirect::to('/');
    }
}
