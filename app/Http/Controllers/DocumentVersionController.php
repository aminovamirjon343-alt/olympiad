<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentVersionController extends Controller
{
    public function index()
    {
        $versions = DocumentVersion::with('document')->latest()->paginate(10);
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
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $request->file('file_path')->store('versions', 'public');

        $lastVersion = DocumentVersion::where('document_id', $request->document_id)->max('version');

        DocumentVersion::create([
            'document_id' => $request->document_id,
            'version' => $lastVersion ? $lastVersion + 1 : 1,
            'file_path' => $filePath,
        ]);

        return redirect()->route('versions.index')->with('success', 'Версия добавлена');
    }

    public function show(DocumentVersion $version)
    {
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
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            if ($version->file_path) {
                Storage::disk('public')->delete($version->file_path);
            }

            $version->file_path = $request->file('file_path')->store('versions', 'public');
        }

        $version->save();

        return redirect()->route('versions.index')->with('success', 'Обновлено');
    }

    public function destroy(DocumentVersion $version)
    {
        if ($version->file_path) {
            Storage::disk('public')->delete($version->file_path);
        }

        $version->delete();

        return redirect()->route('versions.index')->with('success', 'Удалено');
    }
}
