<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentVersionController extends Controller
{
    public function index()
    {
        $versions = DocumentVersion::with('document')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('version.index', compact('versions'));
    }

    public function create()
    {
        $documents = Document::all();
        return view('version.create', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'file_path' => 'required|file',
        ]);

        return DB::transaction(function () use ($request) {

            $file = $request->file('file_path');

            $filePath = $file->store('versions', 'public');

            // 🔥 берём последнюю версию ТОЛЬКО этого документа
            $lastVersion = DocumentVersion::where('document_id', $request->document_id)
                ->lockForUpdate()
                ->max('version');

            $nextVersion = $lastVersion ? $lastVersion + 1 : 1;

            $version = DocumentVersion::create([
                'document_id' => $request->document_id,
                'user_id' => auth()->id(),
                'version' => $nextVersion,
                'file_path' => $filePath,
                'original_name' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);

            return redirect()->route('versions.index')
                ->with('success', "Версия V{$version->version} добавлена");
        });
    }

    public function show(DocumentVersion $version)
    {
        $version->load('document');
        return view('version.show', compact('version'));
    }

    public function edit(DocumentVersion $version)
    {
        $documents = Document::all();
        return view('version.edit', compact('version', 'documents'));
    }

    public function update(Request $request, DocumentVersion $version)
    {
        $request->validate([
            'file_path' => 'nullable|file',
        ]);

        if ($request->hasFile('file_path')) {

            Storage::disk('public')->delete($version->file_path);

            $file = $request->file('file_path');

            $version->update([
                'file_path' => $file->store('versions', 'public'),
                'original_name' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->route('versions.index')
            ->with('success', 'Обновлено');
    }

    public function destroy(DocumentVersion $version)
    {
        Storage::disk('public')->delete($version->file_path);

        $version->delete();

        return redirect()->route('versions.index')
            ->with('success', 'Удалено');
    }
}
