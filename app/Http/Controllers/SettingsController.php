<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings'); // путь к твоему blade файлу
    }

    public function updateGeneral(Request $request)
    {
        $user = auth()->user();

        // Обновляем поля (убедись, что они есть в $fillable модели User)
        $user->update([
            'email_notifications' => $request->has('email_notifications'),
            'tg_notifications' => $request->has('tg_notifications'),
            'language' => $request->language,
        ]);

        return back()->with('success', 'Настройки успешно сохранены!');
    }

    public function updateSignature(Request $request)
    {
        $request->validate([
            'signature' => 'required|image|mimes:png|max:2048', // только PNG для прозрачности
        ]);

        $user = auth()->user();

        if ($request->hasFile('signature')) {
            // Удаляем старую подпись, если она есть
            if ($user->signature_path) {
                Storage::disk('public')->delete($user->signature_path);
            }

            // Сохраняем новую
            $path = $request->file('signature')->store('signatures', 'public');
            $user->update(['signature_path' => $path]);
        }

        return back()->with('success', 'Подпись обновлена!');
    }
}
