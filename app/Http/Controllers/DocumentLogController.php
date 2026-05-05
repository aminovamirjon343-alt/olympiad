<?php

namespace App\Http\Controllers;

use App\Models\{Document, DocumentLog, User};
use App\Http\Requests\DocumentLog\{StoreRequest, UpdateRequest};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentLogController extends Controller
{
    /**
     * Отображение списка логов с жадной загрузкой связей.
     */
    public function index()
    {
        $query = DocumentLog::with(['document', 'user']);

        // Если пользователь НЕ админ, показываем только его логи
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        $logs = $query->latest()->paginate(15);
        return view('logs.index', compact('logs'));
    }

    /**
     * Форма создания. Данные для списков берем компактно.
     */
    public function create(): View
    {
        // Используем pluck, чтобы не тянуть лишние данные из БД
        $documents = Document::pluck('title', 'id');
        $users = User::pluck('name', 'id');

        return view('logs.create', compact('documents', 'users'));
    }

    /**
     * Сохранение новой записи.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        DocumentLog::create($request->validated());

        return redirect()
            ->route('logs.index')
            ->with('success', 'Запись в журнале успешно создана');
    }

    /**
     * Просмотр конкретного лога.
     */
    public function show(DocumentLog $log): View
    {
        $log->load(['document', 'user']);

        return view('logs.show', compact('log'));
    }

    /**
     * Форма редактирования.
     */
    public function edit(DocumentLog $log): View
    {
        $documents = Document::pluck('title', 'id');
        $users = User::pluck('name', 'id');

        return view('logs.edit', compact('log', 'documents', 'users'));
    }

    /**
     * Обновление записи.
     */
    public function update(UpdateRequest $request, DocumentLog $log): RedirectResponse
    {
        $log->update($request->validated());

        return redirect()
            ->route('logs.index')
            ->with('success', 'Запись журнала обновлена');
    }

    /**
     * Удаление записи.
     */
    public function destroy(DocumentLog $log): RedirectResponse
    {
        $log->delete();

        return back()->with('success', 'Запись удалена');
    }

    /**
     * Логи конкретного документа через Route Model Binding.
     */
    public function documentLogs(Document $document): View
    {
        // Загружаем логи только для этого документа
        $logs = $document->logs()
            ->with('user:id,name')
            ->latest()
            ->paginate(15);

        return view('logs.document', compact('document', 'logs'));
    }
}
