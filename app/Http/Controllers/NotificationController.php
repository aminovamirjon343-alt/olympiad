<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        // Laravel сам поймет, какие уведомления принадлежат юзеру через morphs
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }
    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return back();
    }

    public function create()
    {
        $users = User::all();
        return view('notifications.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        // Вместо Notification::create используем метод notify
        $user->notify(new \App\Notifications\DocumentAssigned($request->message));

        return redirect()->route('notifications.index')->with('success', 'Уведомление отправлено!');
    }




    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Удалено');
    }
}
