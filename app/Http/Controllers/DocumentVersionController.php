<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentVersionController extends Controller
{
    /**
     * Выводит список версий ТОЛЬКО для документов текущего пользователя.
     */
    public function index()
    {
        $versions = DocumentVersion::with('document')
            ->whereHas('document', function ($query) {
                // Фильтруем документы: только те, где владелец — текущий юзер
                $query->where('created_by', auth()->id());
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('version.index', compact('versions'));
    }

    /**
     * Показывает форму создания. В выпадающем списке будут ТОЛЬКО свои документы.
     */
    public function create()
    {
        // Показываем только документы текущего пользователя
        $documents = Document::where('created_by', auth()->id())->get();

        return view('version.create', compact('documents'));
    }

    /**
     * Сохранение новой версии.
     */
    public function store(Request $request)
    {
        // Проверяем, что документ существует И принадлежит именно текущему пользователю
        $request->validate([
            'document_id' => [
                'required',
                'exists:documents,id,created_by,' . auth()->id()
            ],
            'file_path' => 'required|file',
        ]);

        return DB::transaction(function () use ($request) {
            $file = $request->file('file_path');
            $filePath = $file->store('versions', 'public');

            // Берём последнюю версию ТОЛЬКО этого документа
            $lastVersion = DocumentVersion::where('document_id', $request->document_id)
                ->lockForUpdate()
                ->max('version');

            $nextVersion = $lastVersion ? $lastVersion + 1 : 1;

            $version = DocumentVersion::create([
                'document_id'   => $request->document_id,
                'user_id'       => auth()->id(),
                'version'       => $nextVersion,
                'file_path'     => $filePath,
                'original_name' => $file->getClientOriginalName(),
                'extension'     => $file->getClientOriginalExtension(),
                'file_size'     => $file->getSize(),
            ]);

            return redirect()->route('versions.index')
                ->with('success', "Версия V{$version->version} добавлена");
        });
    }

    /**
     * Просмотр конкретной версии (с защитой от чужих глаз).
     */
    public function show(DocumentVersion $version)
    {
        // Защита: если документ не принадлежит текущему юзеру — обрываем доступ (403)
        if ($version->document->created_by !== auth()->id()) {
            abort(403, 'У вас нет доступа к этой версии.');
        }

        $version->load('document');
        return view('version.show', compact('version'));
    }

    /**
     * Форма редактирования (с защитой).
     */
    public function edit(DocumentVersion $version)
    {
        // Защита от ручного ввода чужого ID в адресную строку
        if ($version->document->created_by !== auth()->id()) {
            abort(403, 'У вас нет доступа к этой версии.');
        }

        // Показываем только свои документы для выбора
        $documents = Document::where('created_by', auth()->id())->get();

        return view('version.edit', compact('version', 'documents'));
    }

    /**
     * Обновление: создаёт новую запись (V2, V3...) для своего документа.
     */
    public function update(Request $request, DocumentVersion $version)
    {
        // Защита: проверяем, что это наш документ
        if ($version->document->created_by !== auth()->id()) {
            abort(403, 'Действие запрещено.');
        }

        $request->validate([
            'file_path' => 'required|file',
        ]);

        if ($request->hasFile('file_path')) {

            return DB::transaction(function () use ($request, $version) {
                $file = $request->file('file_path');
                $filePath = $file->store('versions', 'public');

                // Ищем максимальную версию для этого документа
                $lastVersion = DocumentVersion::where('document_id', $version->document_id)
                    ->lockForUpdate()
                    ->max('version');

                $nextVersion = $lastVersion ? $lastVersion + 1 : 1;

                // Создаем НОВУЮ запись в базе, повышая версию
                $newVersion = DocumentVersion::create([
                    'document_id'   => $version->document_id,
                    'user_id'       => auth()->id(),
                    'version'       => $nextVersion,
                    'file_path'     => $filePath,
                    'original_name' => $file->getClientOriginalName(),
                    'extension'     => $file->getClientOriginalExtension(),
                    'file_size'     => $file->getSize(),
                ]);

                return redirect()->route('versions.index')
                    ->with('success', "Создана новая версия V{$newVersion->version}");
            });
        }

        return redirect()->back()->with('error', 'Файл не был загружен');
    }

    /**
     * Удаление версии (с защитой).
     */
    public function destroy(DocumentVersion $version)
    {
        // Защита: удалять можно только свои версии
        if ($version->document->created_by !== auth()->id()) {
            abort(403, 'Действие запрещено.');
        }

        // Удаляем физический файл с диска
        Storage::disk('public')->delete($version->file_path);

        // Удаляем запись из БД
        $version->delete();

        return redirect()->route('versions.index')
            ->with('success', 'Удалено');
    }
}
