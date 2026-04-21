<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentWorkflow;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentWorkflowController extends Controller
{
    // 📋 список этапов
    public function index($documentId)
    {
        $document = Document::findOrFail($documentId);

        $workflows = DocumentWorkflow::where('document_id', $documentId)->get();

        return view('workflow.index', compact('workflows', 'documentId', 'document'));
    }

    // ➕ форма создания
    public function create($documentId)
    {
        Document::findOrFail($documentId);

        $users = User::all();

        return view('workflow.create', compact('users', 'documentId'));
    }

    // 💾 создание этапа
    public function store(Request $request, $documentId)
    {
        Document::findOrFail($documentId);

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // 🔥 запрет дубликата пользователя
        $exists = DocumentWorkflow::where('document_id', $documentId)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['user_id' => 'Этот пользователь уже добавлен'])->withInput();
        }

        // 🔥 авто порядок
        $max = DocumentWorkflow::where('document_id', $documentId)->max('step_order');
        $stepOrder = $max ? $max + 1 : 1;

        // 🔥 только первый этап активный
        $status = $stepOrder === 1 ? 'pending' : 'waiting';

        DocumentWorkflow::create([
            'document_id' => $documentId,
            'user_id' => $request->user_id,
            'step_order' => $stepOrder,
            'status' => $status,
        ]);
        Notification::create([
            'user_id' => $request->user_id,
            'message' => 'Вам назначен документ на подпись',
            'type' => 'sign',
            'is_read' => false,
        ]);

        return redirect()->route('workflow.index', $documentId)
            ->with('success', 'Этап добавлен');
    }

    // ✅ approve
    public function approve($id)
    {
        $step = DocumentWorkflow::findOrFail($id);

        if ($step->status !== 'pending') {
            return back()->with('error', 'Уже обработано');
        }

        if ($step->user_id != Auth::id()) {
            return back()->with('error', 'Это не ваш этап');
        }

        // одобряем
        $step->update(['status' => 'approved']);

        // следующий этап
        $next = DocumentWorkflow::where('document_id', $step->document_id)
            ->where('step_order', '>', $step->step_order)
            ->orderBy('step_order')
            ->first();

        if ($next) {
            $next->update(['status' => 'pending']);
        }

        return back()->with('success', 'Одобрено');
    }

    // ❌ reject
    public function reject($id)
    {
        $step = DocumentWorkflow::findOrFail($id);

        if ($step->status !== 'pending') {
            return back()->with('error', 'Уже обработано');
        }

        if ($step->user_id != Auth::id()) {
            return back()->with('error', 'Это не ваш этап');
        }

        // отклоняем текущий
        $step->update(['status' => 'rejected']);

        // отклоняем все остальные
        DocumentWorkflow::where('document_id', $step->document_id)
            ->where('status', 'waiting')
            ->update(['status' => 'rejected']);

        return back()->with('error', 'Документ отклонён');
    }

    // ✏️ редактирование
    public function edit(DocumentWorkflow $workflow)
    {
        return view('workflow.edit', compact('workflow'));
    }

    // 🔄 обновление порядка
    public function update(Request $request, DocumentWorkflow $workflow)
    {
        $request->validate([
            'step_order' => 'required|integer|min:1',
        ]);

        $workflow->update([
            'step_order' => $request->step_order,
        ]);

        // 🔥 пересортировка
        DocumentWorkflow::where('document_id', $workflow->document_id)
            ->orderBy('step_order')
            ->get()
            ->values()
            ->each(function ($item, $index) {
                $item->update(['step_order' => $index + 1]);
            });

        return redirect()->route('workflow.index', $workflow->document_id)
            ->with('success', 'Порядок обновлён');
    }

    // 🗑 удаление
    public function destroy(DocumentWorkflow $workflow)
    {
        $documentId = $workflow->document_id;

        $workflow->delete();

        // пересортировка после удаления
        DocumentWorkflow::where('document_id', $documentId)
            ->orderBy('step_order')
            ->get()
            ->values()
            ->each(function ($item, $index) {
                $item->update(['step_order' => $index + 1]);
            });

        return redirect()->route('workflow.index', $documentId)
            ->with('success', 'Этап удалён');
    }

    // 🔍 текущий этап (API)
    public function current($documentId)
    {
        $current = DocumentWorkflow::where('document_id', $documentId)
            ->where('status', 'pending')
            ->orderBy('step_order')
            ->first();

        return response()->json($current);
    }
}
