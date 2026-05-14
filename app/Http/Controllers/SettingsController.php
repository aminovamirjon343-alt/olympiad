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
    public function update(Request $request)
    {
        $validated = $request->validate([
            'edi_enabled' => 'nullable|boolean',
            'api_key' => 'required|string|max:255',
            'api_url' => 'required|url',
            'certificate' => 'nullable|file|mimes:p12,pem,cer|max:2048',
            'webhook_url' => 'nullable|url',
        ]);

        // Сохранение настроек в БД (пример через модель Setting)
        foreach ($validated as $key => $value) {
            if ($key === 'certificate' && $request->hasFile('certificate')) {
                // Сохранение файла
                $path = $request->file('certificate')->store('edi/certificates', 'private');
                \App\Models\Setting::updateOrCreate(['key' => 'certificate_path'], ['value' => $path]);
            } else {
                \App\Models\Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_bool($value) ? (int)$value : $value]
                );
            }
        }

        return back()->with('success', 'Настройки ЭДО обновлены.');
    }
}
