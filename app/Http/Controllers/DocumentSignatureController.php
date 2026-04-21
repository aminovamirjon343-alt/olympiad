<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentSignature;
use App\Models\DocumentWorkflow;
use App\Models\Notification;
use App\Models\DocumentLog;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentSignatureController extends Controller
{
    // 📄 список
    public function index()
    {
        $signatures = DocumentSignature::with(['document', 'user'])
            ->latest()
            ->paginate(10);

        return view('signatures.index', compact('signatures'));
    }

    // ✍️ форма
    public function create()
    {
        $documents = Document::all();
        $users = User::all();

        return view('signatures.create', compact('documents', 'users'));
    }

    // ✏️ редактирование
    public function edit(DocumentSignature $signature)
    {
        $documents = Document::all();
        return view('signatures.edit', compact('signature', 'documents'));
    }

    // 💾 СОЗДАНИЕ ПОДПИСИ
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'user_id' => 'required|exists:users,id',
            'signature' => 'required|string'
        ]);

        $document = Document::findOrFail($request->document_id);

        // 1. Ищем текущий активный этап
        $current = DocumentWorkflow::where('document_id', $request->document_id)
            ->where('status', 'pending')
            ->orderBy('step_order')
            ->first();

        // 2. Проверки Workflow
        if ($current) {
            if ((int)$request->user_id !== (int)$current->user_id) {
                return back()->with('error', 'Сейчас очередь другого пользователя');
            }
        }

        // 3. Проверка на дубликат
        $exists = DocumentSignature::where('document_id', $request->document_id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Вы уже подписали этот документ');
        }

        // 4. ✅ СОЗДАЕМ ПОДПИСЬ
        DocumentSignature::create([
            'document_id' => $request->document_id,
            'user_id' => $request->user_id,
            'signature' => $request->signature,
            'signed_at' => now(),
        ]);

        // 5. 🧾 ЛОГ
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => $request->user_id,
            'action' => 'signed',
            'description' => 'Документ подписан графической подписью',
        ]);

        // 🔔 6. УВЕДОМЛЕНИЕ (Вынесено сюда, чтобы работало всегда!)
        Notification::create([
            'user_id' => $request->user_id,
            'message' => 'Документ "' . $document->title . '" успешно подписан!',
            'type' => 'sign',
            'is_read' => false,
        ]);

        // 7. 🔥 ОБНОВЛЯЕМ WORKFLOW (если он есть)
        if ($current) {
            $current->update(['status' => 'approved']);

            $next = DocumentWorkflow::where('document_id', $request->document_id)
                ->where('step_order', '>', $current->step_order)
                ->orderBy('step_order')
                ->first();

            if ($next) {
                $next->update(['status' => 'pending']);

                Notification::create([
                    'user_id' => $next->user_id,
                    'message' => 'Вам необходимо подписать: ' . $document->title,
                    'type' => 'sign',
                ]);
            }
        }

        return redirect()->route('signatures.index')->with('success', 'Подписано и уведомление отправлено!');
    }

    // 🔄 обновление
    public function update(Request $request, DocumentSignature $signature)
    {
        $request->validate([
            'signature' => 'required|string'
        ]);

        $signature->update([
            'signature' => $request->signature,
        ]);

        // ❗ исправлено: берём user_id из самой подписи
        DocumentLog::create([
            'document_id' => $signature->document_id,
            'user_id' => $signature->user_id,
            'action' => 'updated',
            'description' => 'Подпись обновлена',
        ]);

        return redirect()->route('signatures.index')
            ->with('success', 'Подпись обновлена');
    }

    // 👁 просмотр
    public function show(DocumentSignature $signature)
    {
        $signature->load(['document', 'user']);
        return view('signatures.show', compact('signature'));
    }

    // 🗑 удаление
    public function destroy(DocumentSignature $signature)
    {
        DocumentLog::create([
            'document_id' => $signature->document_id,
            'user_id' => $signature->user_id,
            'action' => 'deleted',
            'description' => 'Подпись удалена',
        ]);

        $signature->delete();

        return back()->with('success', 'Удалено');
    }
}
