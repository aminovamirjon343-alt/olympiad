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


        $comment = DocumentComment::create([
            'document_id' => $request->document_id,
            'user_id' => auth()->id(), // Берем реальный ID из сессии
            'comment' => $request->comment,
        ]);


        $document = Document::find($request->document_id);

        // Проверяем, есть ли автор и не сам ли автор пишет комментарий
        if ($document && $document->created_by && $document->created_by !== auth()->id()) {
            Notification::create([
                'user_id' => $document->created_by,
                'message' => 'Новый комментарий к вашему документу: "' . $document->title . '"',
                'type' => 'comment', // Добавь тип, если он есть в модели
                'is_read' => false,
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
