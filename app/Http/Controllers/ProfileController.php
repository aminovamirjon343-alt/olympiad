<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();
        $year = (int) $request->get('year', now()->year);

        $firstDayOfYear = Carbon::create($year, 1, 1);
        $startDate = $firstDayOfYear->copy()->startOfWeek(Carbon::MONDAY);
        $endDate = Carbon::create($year, 12, 31)->endOfWeek(Carbon::SUNDAY);

        $totalDays = $startDate->diffInDays($endDate) + 1;
        $weeksCount = (int) ceil($totalDays / 7);

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

        $data = $request->validate([
            'email_notifications' => 'nullable|string',
            'tg_notifications'    => 'nullable|string',
            'language'            => 'required|string|in:ru,tg',
        ]);

        $user->update([
            'email_notifications' => $request->has('email_notifications'),
            'tg_notifications'    => $request->has('tg_notifications'),
            'language'            => $data['language'],
        ]);

        return back()->with('success', 'Настройки успешно обновлены!');
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'users' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'company'       => ['nullable', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'         => ['nullable', 'string', 'max:20'],
            'avatar'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_avatar' => ['nullable', 'string', 'in:0,1'],
        ]);

        // ===== ОБРАБОТКА УДАЛЕНИЯ АВАТАРА =====
        if ($request->input('remove_avatar') === '1') {
            // Удаляем старый файл с диска
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Обнуляем поле в БД
            $user->avatar = null;
        }

        // ===== ОБРАБОТКА ЗАГРУЗКИ НОВОГО АВАТАРА =====
        if ($request->hasFile('avatar')) {
            // Удаляем старый аватар если есть
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Сохраняем новый
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Обновляем остальные поля
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->company = $validated['company'] ?? null;
        $user->phone = $validated['phone'] ?? null;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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