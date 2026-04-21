<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\Document;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Storage;
//use App\Models\DocumentLog;
//
//class DocumentController extends Controller
//{
////    public function __construct()
////    {
////        // 🔒 ОБЯЗАТЕЛЬНО
////        $this->middleware('auth');
////    }
//
//    public function index()
//    {
//        $documents = Document::with('user')->latest()->paginate(10);
//
//        return view('document.index', compact('documents'));
//    }
//
//    public function create()
//    {
//        return view('document.create');
//    }
//
//    public function store(Request $request)
//    {
//        // ✅ ВАЛИДАЦИЯ
//        $request->validate([
//            'title' => 'required|string|max:255',
//            'content' => 'nullable|string',
//            'file_path' => 'nullable|file|mimes:pdf,doc,docx|',
//            'status' => 'required|in:active,pending,approved,rejected',
//            'deadline' => 'nullable|date',
//        ]);
//
//        // 📎 файл
//        $filePath = null;
//        if ($request->hasFile('file_path')) {
//            $filePath = $request->file('file_path')->store('documents', 'public');
//        }
//
//        // 💾 СОЗДАНИЕ (ВАЖНО!)
//        Document::create([
//            'title' => $request->title,
//            'content' => $request->content,
//            'file_path' => $filePath,
//            'status' => $request->status,
//            'created_by' => 1, // 🔥 ПРАВИЛЬНО
//            'deadline' => $request->deadline,
//        ]);
//
//        return redirect()->route('documents.index')
//            ->with('success', 'Документ создан');
//    }
//
//    public function show(Document $document)
//    {
//        return view('document.show', compact('document'));
//    }
//
//    public function edit(Document $document)
//    {
//        return view('document.edit', compact('document'));
//    }
//
//    public function update(Request $request, Document $document)
//    {
//        $request->validate([
//            'title' => 'required|string|max:255',
//            'content' => 'nullable|string',
//            'file_path' => 'nullable|file|mimes:pdf,doc,docx|',
//            'status' => 'required|in:active,pending,approved,rejected',
//            'deadline' => 'nullable|date',
//        ]);
//
//        if ($request->hasFile('file_path')) {
//
//            if ($document->file_path) {
//                Storage::disk('public')->delete($document->file_path);
//            }
//
//            $document->file_path = $request->file('file_path')->store('documents', 'public');
//        }
//
//        $document->update([
//            'title' => $request->title,
//            'content' => $request->content,
//            'status' => $request->status,
//            'deadline' => $request->deadline,
//        ]);
//
//        return redirect()->route('documents.index')
//            ->with('success', 'Документ обновлён');
//    }
//
//    public function destroy(Document $document)
//    {
//        if ($document->file_path) {
//            Storage::disk('public')->delete($document->file_path);
//        }
//
//        $document->delete();
//
//        return redirect()->route('documents.index')
//            ->with('success', 'Документ удалён');
//    }
//}


namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentComment;
use App\Models\DocumentLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('user')->latest()->paginate(10);

        return view('document.index', compact('documents'));
    }

    public function create()
    {
        $users = User::all();
        return view('document.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|in:active,pending,approved,rejected',
            'user_id' => 'required|exists:users,id',
            'deadline' => 'nullable|date',
        ]);

        // 📎 файл
        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('documents', 'public');
        }

        // 💾 создаём документ
        $document = Document::create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $filePath,
            'status' => $request->status,
            'created_by' => $request->user_id, // ✅ ВАЖНО
            'deadline' => $request->deadline,
        ]);

        // 🔥 ЛОГ (ТОЖЕ ИСПРАВЛЕНО)
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => $request->user_id, // ❗ НЕ 1
            'action' => 'created',
            'description' => 'Документ создан',
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Документ создан');
    }
    public function show($id)
    {
        $document = Document::findOrFail($id);

        $comments = DocumentComment::with('user')
            ->where('document_id', $id)
            ->latest()
            ->get();

        return view('document.show', compact('document', 'comments'));
    }

    public function edit(Document $document)
    {
        return view('document.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|in:active,pending,approved,rejected',
            'deadline' => 'nullable|date',
        ]);

        if ($request->hasFile('file_path')) {

            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->file_path = $request->file('file_path')->store('documents', 'public');
        }

        $document->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'deadline' => $request->deadline,
        ]);

        // 🔥 ЛОГ
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => $request->user_id, // ❗ исправлено
            'action' => 'updated',
            'description' => 'Документ обновлён',
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Документ обновлён');
    }

    public function destroy(Document $document)
    {
        // 🔥 ЛОГ (до удаления!)
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => $request->user_id, // ❗ исправлено
            'action' => 'deleted',
            'description' => 'Документ удалён',
        ]);
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Документ удалён');
    }
}
