<?php

namespace App\Http\Controllers;

use App\Models\{Document, DocumentLog, User};
use App\Http\Requests\DocumentLog\{StoreRequest, UpdateRequest};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentLogController extends Controller
{
    /**
     * Отображение списка логов с автоматической защитой приватности.
     */
    public function index()
    {
        $query = DocumentLog::with(['document', 'user']);

        // Если пользователь НЕ админ, показываем логи только СВОИХ документов
        if (!auth()->user()->is_admin) {
            $query->whereHas('document', function ($q) {
                // Фильтр: только те документы, которые были созданы текущим пользователем
                $q->where('created_by', auth()->id());
            });
        }

        $logs = $query->latest()->paginate(15);
        return view('logs.index', compact('logs'));
    }

    /**
     * Форма создания. Данные для списков берем компактно.
     */
    public function create(): View
    {
        // Если это админ — даем все документы, если обычный юзер — только его личные
        if (auth()->user()->is_admin) {
            $documents = Document::pluck('title', 'id');
        } else {
            $documents = Document::where('created_by', auth()->id())->pluck('title', 'id');
        }

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
     * Просмотр конкретного лога с защитой от просмотра чужих данных.
     */
    public function show(DocumentLog $log): View
    {
        // Защита: не админ не может смотреть чужие логи через URL-адрес
        if (!auth()->user()->is_admin && $log->document->created_by !== auth()->id()) {
            abort(403, 'У вас нет доступа к этой истории.');
        }

        $log->load(['document', 'user']);

        return view('logs.show', compact('log'));
    }

    /**
     * Форма редактирования.
     */
    public function edit(DocumentLog $log): View
    {
        if (!auth()->user()->is_admin && $log->document->created_by !== auth()->id()) {
            abort(403);
        }

        if (auth()->user()->is_admin) {
            $documents = Document::pluck('title', 'id');
        } else {
            $documents = Document::where('created_by', auth()->id())->pluck('title', 'id');
        }

        $users = User::pluck('name', 'id');

        return view('logs.edit', compact('log', 'documents', 'users'));
    }

    /**
     * Обновление записи.
     */
    public function update(UpdateRequest $request, DocumentLog $log): RedirectResponse
    {
        if (!auth()->user()->is_admin && $log->document->created_by !== auth()->id()) {
            abort(403);
        }

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
        if (!auth()->user()->is_admin && $log->document->created_by !== auth()->id()) {
            abort(403);
        }

        $log->delete();

        return back()->with('success', 'Запись удалена');
    }

    /**
     * Логи конкретного документа через Route Model Binding.
     */
    public function documentLogs(Document $document): View
    {
        // Защита: обычный пользователь не может подсмотреть историю чужого документа
        if (!auth()->user()->is_admin && $document->created_by !== auth()->id()) {
            abort(403);
        }

        $logs = $document->logs()
            ->with('user:id,name')
            ->latest()
            ->paginate(15);

        return view('logs.document', compact('document', 'logs'));
    }
    /**
     * Очистить всю историю (доступно только админу).
     */
    public function clear(): \Illuminate\Http\RedirectResponse
    {
        // Безопасность: очищать логи может только администратор
        if (!auth()->user()->is_admin) {
            return back()->with('error', 'У вас нет прав на очистку журнала истории');
        }

        // Удаляем все записи из таблицы логов
        \App\Models\DocumentLog::truncate();

        return redirect()
            ->route('logs.index')
            ->with('success', 'Журнал истории успешно очищен');
    }
}
