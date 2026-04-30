<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentComment;
use App\Models\DocumentLog;
use App\Models\DocumentSignature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DocumentAssigned;
use App\Notifications\DocumentStatusChanged;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['createdBy', 'receiver']);

        // 🔍 УМНЫЙ ПОИСК
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            })
                /**
                 * Сортировка по релевантности:
                 * 1. Сначала те, у кого заголовок начинается на запрос (Ам -> Амир)
                 * 2. Потом те, где запрос есть в середине заголовка
                 * 3. Потом всё остальное
                 */
                ->orderByRaw("CASE
            WHEN title LIKE ? THEN 1
            WHEN title LIKE ? THEN 2
            ELSE 3
            END", ["{$search}%", "%{$search}%"]);
        } else {
            // Если поиска нет, показываем последние документы
            $query->latest();
        }

        // 📥 Incoming (Входящие)
        if ($request->type === 'incoming') {
            $query->where('receiver_id', auth()->id());
        }

        // 📤 Outgoing (Исходящие)
        if ($request->type === 'outgoing') {
            $query->where('created_by', auth()->id());
        }

        // ✍️ Signed (Подписанные)
        if ($request->type === 'signed') {
            $query->where('status', 'signed');
        }

        // Пагинация с сохранением всех фильтров и поиска в ссылках
        $documents = $query->paginate(10)->withQueryString();

        return view('document.index', compact('documents'));
    }

    public function create()
    {
        return view('document.create', [
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'content'        => 'nullable|string',
            'type'           => 'required|string',
            'status'         => 'required|in:active,pending,approved,rejected,draft',
            'deadline'       => 'nullable|date',
            'receiver_email' => 'required|email',
            'file_path'      => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // 🔥 НАЙТИ ПОЛУЧАТЕЛЯ
        $receiver = User::where('email', $request->receiver_email)->first();

        if (!$receiver) {
            return back()->withErrors([
                'receiver_email' => 'Пользователь не найден'
            ]);
        }

        // 📁 файл
        $filePath = $request->file('file_path')
            ? $request->file('file_path')->store('documents', 'public')
            : null;

        // 📄 СОЗДАНИЕ ДОКУМЕНТА
        $document = Document::create([
            'title'       => $request->title,
            'content'     => $request->content,
            'type'        => $request->type,
            'status'      => $request->status,
            'file_path'   => $filePath,

            // 🔥 ВАЖНО
            'created_by'  => Auth::id(),
            'receiver_id' => $receiver->id,

            'deadline'    => $request->deadline,
        ]);

        // 🧾 LOG
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id'     => Auth::id(),
            'action'      => 'created',
            'description' => 'Документ отправлен',
        ]);
        DocumentSignature::create([
            'document_id' => $document->id,
            'user_id'     => $receiver->id,
            'status'      => 'pending',

            'signature'   => null,
        ]);

        // 🔔 NOTIFICATION
        $receiver->notify(new DocumentAssigned($document));

        return redirect()->route('documents.index')
            ->with('success', 'Документ успешно отправлен');
    }

    public function show($id)
    {
        $document = Document::with(['createdBy', 'receiver'])->findOrFail($id);

        $comments = DocumentComment::with('user')
            ->where('document_id', $id)
            ->latest()
            ->get();

        return view('document.show', compact('document', 'comments'));
    }

    public function edit(Document $document)
    {
        return view('document.edit', [
            'document' => $document,
            'users' => User::all()
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'status' => 'required',
        ]);

        $oldStatus = $document->status;

        // 🔥 сохраняем старый файл (для версии)
        $oldFile = $document->file_path;

        if ($request->hasFile('file_path')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->file_path = $request->file('file_path')
                ->store('documents', 'public');
        }

        $document->update($request->only([
            'title',
            'content',
            'status',
            'deadline'
        ]));

        // 🔥 1. создаём версию (ВАЖНО)
        $lastVersion = \App\Models\DocumentVersion::where('document_id', $document->id)
            ->max('version');

        \App\Models\DocumentVersion::create([
            'document_id'    => $document->id,
            'user_id'        => auth()->id(),
            'version'        => $lastVersion ? $lastVersion + 1 : 1,
            'file_path'      => $document->file_path ?? $oldFile,
            'original_name'  => $request->file('file_path')
                ? $request->file('file_path')->getClientOriginalName()
                : null,
            'extension'      => $request->file('file_path')
                ? $request->file('file_path')->getClientOriginalExtension()
                : null,
            'file_size'      => $request->file('file_path')
                ? $request->file('file_path')->getSize()
                : null,
            'change_summary' => "Документ обновлён (title/status/content)",
        ]);

        // 🔥 лог
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id'     => Auth::id(),
            'action'      => 'updated',
            'description' => "Статус изменён на {$request->status}",
        ]);

        // уведомление
        if ($oldStatus !== $request->status) {
            $document->receiver?->notify(
                new DocumentStatusChanged($document, $request->status)
            );
        }

        return redirect()->route('documents.index')
            ->with('success', 'Документ обновлён');
    }

    public function destroy(Document $document)
    {
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id'     => Auth::id(),
            'action'      => 'deleted',
            'description' => 'Документ удалён',
        ]);

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Документ удалён');
    }
}
