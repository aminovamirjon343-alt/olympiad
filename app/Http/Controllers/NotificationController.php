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
    public function readAll()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return back()->with('success', 'Все уведомления прочитаны');
    }
    public function index() {
        $notifications = Notification::where('user_id', auth()->id())->latest()->paginate(25);
        $unreadCount = Notification::where('user_id', auth()->id())->where('is_read', false)->count();
        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return back()->with('success', 'Прочитано');
    }

    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Удалено');
    }


    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'comment'     => 'required|string|max:1000'
        ]);

        $currentUser = Auth::user();

        $comment = DocumentComment::create([
            'document_id' => $request->document_id,
            'user_id'     => $currentUser->id,
            'comment'     => $request->comment,
        ]);

        $document = Document::findOrFail($request->document_id);
        $participantIds = DocumentComment::where('document_id', $document->id)
            ->pluck('user_id')
            ->push($document->created_by) // Добавляем автора документа
            ->unique()                    // Убираем дубликаты
            ->filter(fn($id) => $id != $currentUser->id); // Исключаем того, кто пишет сейчас

       foreach ($participantIds as $userId) {
            Notification::create([
                'user_id'         => $userId,
                'type'            => 'comment',
                'messages'         => ($userId == $document->created_by)
                    ? 'Новый ответ в вашем документе'
                    : 'Новый комментарий в обсуждении, где вы участвуете',
                'is_read'         => false,
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data' => [
                    'document_id'     => $document->id,
                    'type'            => 'comment',
                    'user_name'       => auth()->user()->name, // Оставили один, чистый ключ
                    'document_title'  => $document->title,
                    'comment_preview' => Str::limit($request->comment, 50),
                ],
            ]);
        }

        return back()->with('success', 'Комментарий добавлен, участники уведомлены!');
    }
    public function read($id)
    {
        return $this->markAsRead($id);
    }
}
