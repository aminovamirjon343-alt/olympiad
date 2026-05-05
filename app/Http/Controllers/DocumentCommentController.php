<?php

namespace App\Http\Controllers;

use App\Models\DocumentComment;
use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentCommentController extends Controller
{
    public function index($documentId)
    {
        $document = Document::findOrFail($documentId);

        $comments = DocumentComment::with('user')
            ->where('document_id', $documentId)
            ->latest()
            ->get();

        return view('comment.index', compact('document', 'comments'));
    }

    public function create($documentId)
    {
        $document = \App\Models\Document::findOrFail($documentId);
        $users = \App\Models\User::all();

        return view('comment.create', compact('document', 'users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'comment' => 'required|string|max:1000'
        ]);

        if (!auth()->check()) {
            return back()->with('error', 'Вы должны войти в систему, чтобы оставить комментарий');
        }

        // 1. Сохраняем комментарий
        $comment = DocumentComment::create([
            'document_id' => $request->document_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        $document = Document::find($request->document_id);

        // 2. Исправленное создание уведомления
        if ($document && $document->created_by && $document->created_by !== auth()->id()) {
            Notification::create([
                // Генерируем UUID вручную, так как в миграции это первичный ключ
                'id' => (string) \Illuminate\Support\Str::uuid(),

                'user_id' => $document->created_by,
                'message' => 'Новый комментарий к вашему документу: "' . $document->title . '"',
                'type' => 'comment',
                'is_read' => false,

                // ОБЯЗАТЕЛЬНЫЕ ПОЛЯ для morphs('notifiable') из твоей миграции:
                'notifiable_type' => \App\Models\User::class, // К какому классу относится уведомление
                'notifiable_id' => $document->created_by,     // К какому ID пользователя привязано

                // Если в миграции есть поле data (текстовое), лучше передать пустой массив или null
                'data' => json_encode(['comment_id' => $comment->id]),
            ]);
        }

        return back()->with('success', 'Комментарий успешно добавлен!');
    }

    public function destroy($id)
    {
        $comment = DocumentComment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Комментарий удалён');
    }
}
