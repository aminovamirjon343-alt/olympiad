<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Document;
use App\Models\DocumentComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Список всех уведомлений текущего пользователя
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Пометка уведомления как прочитанного
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);

        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return back()->with('success', 'Прочитано');
    }

    /**
     * Удаление уведомления
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Удалено');
    }

    /**
     * Создание комментария и уведомления автору
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'comment'     => 'required|string|max:1000'
        ]);

        // 1. Создаем сам комментарий в базе
        $comment = DocumentComment::create([
            'document_id' => $request->document_id,
            'user_id'     => Auth::id(),
            'comment'     => $request->comment,
        ]);

        $document = Document::findOrFail($request->document_id);

        // 2. Отправляем уведомление автору документа (если это не сам автор пишет коммент)
        if ($document->created_by && $document->created_by !== Auth::id()) {
            Notification::create([
                'user_id'         => $document->created_by,
                'type'            => 'comment', // Для иконки 💬
                'message'         => 'Новый комментарий к вашему документу',
                'is_read'         => false,
                'notifiable_type' => User::class,
                'notifiable_id'   => $document->created_by,
                // Передаем массив напрямую (casts в модели сам превратит его в JSON)
                'data' => [
                    'type'           => 'comment',
                    'user'           => Auth::user()->name,
                    'document_title' => $document->title,
                    'comment_text'   => Str::limit($request->comment, 50),
                ],
            ]);
        }

        return back()->with('success', 'Комментарий успешно добавлен!');
    }
}
