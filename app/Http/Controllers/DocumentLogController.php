<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentLogController extends Controller
{
    // 📄 список логов
    public function index()
    {
        $logs = DocumentLog::with(['document', 'user'])
            ->latest()
            ->paginate(15);

        return view('logs.index', compact('logs'));
    }

    // ➕ форма создания (опционально)
    public function create()
    {
        $documents = Document::all();
        $users = User::all();

        return view('logs.create', compact('documents', 'users'));
    }

    // 💾 сохранение (опционально)
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'user_id' => 'nullable|exists:users,id',
            'action' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DocumentLog::create([
            'document_id' => $request->document_id,
            'user_id' => $request->user_id,
            'action' => $request->action,
            'description' => $request->description,
        ]);

        return redirect()->route('logs.index')
            ->with('success', 'Лог создан');
    }

    // 👁 просмотр одного лога
    public function show(DocumentLog $log)
    {
        $log->load(['document', 'user']);

        return view('logs.show', compact('log'));
    }

    // ✏️ редактирование (опционально)
    public function edit(DocumentLog $log)
    {
        $documents = Document::all();
        $users = User::all();

        return view('logs.edit', compact('log', 'documents', 'users'));
    }

    // 🔄 обновление
    public function update(Request $request, DocumentLog $log)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'user_id' => 'nullable|exists:users,id',
            'action' => 'required|string|max:255',
            'description' => 'nullable',
        ]);

        $log->update([
            'document_id' => $request->document_id,
            'user_id' => $request->user_id,
            'action' => $request->action,
            'description' => $request->description,
        ]);

        return redirect()->route('logs.index')
            ->with('success', 'Лог обновлен');
    }

    // 🗑 удаление
    public function destroy(DocumentLog $log)
    {
        $log->delete();

        return back()->with('success', 'Лог удален');
    }

    // 📄 история конкретного документа
    public function documentLogs($documentId)
    {
        $document = Document::with(['logs.user'])
            ->findOrFail($documentId);

        return view('logs.document', compact('document'));
    }
}
