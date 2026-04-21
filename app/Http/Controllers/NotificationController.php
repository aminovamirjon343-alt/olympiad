<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Список уведомлений текущего пользователя
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    // Форма создания (для тестов или админа)
    public function create()
    {
        $users = User::all();
        return view('notifications.create', compact('users'));
    }

    // Сохранение нового уведомления
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type'    => 'required|string',
            'message' => 'required|string',
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'type'    => $request->type,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('notifications.index')->with('success', 'Уведомление отправлено!');
    }

    // Отметить как прочитанное
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->update(['is_read' => true]);

        return back()->with('success', 'Прочитано');
    }

    // Удаление
    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Удалено');
    }
}
