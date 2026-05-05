<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentSignature;
use App\Models\DocumentWorkflow;
use App\Models\Notification;
use App\Models\DocumentLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentSignatureController extends Controller
{
    /**
     * Показ всех подписей (Админ видит всё, пользователь — только свои)
     */
    public function index()
    {
        $user = Auth::user();

        $query = DocumentSignature::with(['document', 'user']);

        // Если не админ, фильтруем только по текущему пользователю
        if (!$user->is_admin) {
            $query->where('user_id', $user->id);
        }

        $signatures = $query->latest()->paginate(12);

        return view('signatures.index', compact('signatures'));
    }

    public function create()
    {
        $documents = Document::all();
        $users = User::all();
        return view('signatures.create', compact('documents', 'users'));
    }

    /**
     * ПРОЦЕСС СОЗДАНИЯ ПОДПИСИ
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'signature'   => 'required|string'
        ]);

        $document = Document::findOrFail($request->document_id);
        $signer = Auth::user();

        // 1. ПРОВЕРКА ОЧЕРЕДНОСТИ
        $currentWorkflow = DocumentWorkflow::where('document_id', $document->id)
            ->where('status', 'pending')
            ->orderBy('step_order')
            ->first();

        if ($currentWorkflow && (int)$signer->id !== (int)$currentWorkflow->user_id) {
            return back()->with('error', 'Сейчас очередь другого пользователя для подписи!');
        }

        // 2. ПРОВЕРКА НА ДУБЛИКАТ
        $alreadySigned = DocumentSignature::where('document_id', $document->id)
            ->where('user_id', $signer->id)
            ->exists();

        if ($alreadySigned) {
            return back()->with('error', 'Вы уже подписали этот документ.');
        }

        // 3. СОЗДАНИЕ ПОДПИСИ
        DocumentSignature::create([
            'document_id' => $document->id,
            'user_id'     => $signer->id,
            'signature'   => $request->signature,
            'signed_at'   => now(),
            'expires_at'  => $document->due_date ?? null,
        ]);

        // 4. ЛОГИРОВАНИЕ
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id'     => $signer->id,
            'action'      => 'signed',
            'description' => 'Документ подписан пользователем ' . $signer->name,
        ]);

        // 5. УВЕДОМЛЕНИЕ АВТОРУ
        if ($document->created_by) {
            Notification::create([
                'user_id'         => $document->created_by,
                'type'            => 'signed',
                'message'         => "Пользователь {$signer->name} подписал ваш документ",
                'is_read'         => false,
                'notifiable_type' => User::class,
                'notifiable_id'   => $document->created_by,
                'data' => [
                    'type'           => 'signed',
                    'user'           => $signer->name,
                    'document_title' => $document->title,
                ],
            ]);
        }

        // 6. ОБРАБОТКА ВОРКФЛОУ
        if ($currentWorkflow) {
            $currentWorkflow->update(['status' => 'approved']);

            $nextWorkflow = DocumentWorkflow::where('document_id', $document->id)
                ->where('step_order', '>', $currentWorkflow->step_order)
                ->orderBy('step_order')
                ->first();

            if ($nextWorkflow) {
                $nextWorkflow->update(['status' => 'pending']);

                Notification::create([
                    'user_id'         => $nextWorkflow->user_id,
                    'type'            => 'assigned',
                    'message'         => "Ваша очередь подписать документ",
                    'is_read'         => false,
                    'notifiable_type' => User::class,
                    'notifiable_id'   => $nextWorkflow->user_id,
                    'data' => [
                        'type'           => 'assigned',
                        'user'           => $signer->name,
                        'document_title' => $document->title,
                    ],
                ]);
            } else {
                $document->update(['status' => 'approved']);
            }
        }

        return redirect()->route('signatures.index')->with('success', 'Документ успешно подписан!');
    }

    /**
     * ОБНОВЛЕНИЕ ПОДПИСИ
     */
    public function update(Request $request, DocumentSignature $signature)
    {
        // Проверка прав доступа (Security Check)
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав на редактирование этой подписи.');
        }

        $request->validate(['signature' => 'required|string']);

        $signature->update([
            'signature' => $request->signature,
            'signed_at' => now(),
        ]);

        DocumentLog::create([
            'document_id' => $signature->document_id,
            'user_id'     => Auth::id(),
            'action'      => 'updated',
            'description' => 'Графическая подпись была обновлена',
        ]);

        return redirect()->route('signatures.index')->with('success', 'Подпись обновлена');
    }

    public function show(DocumentSignature $signature)
    {
        $signature->load(['document', 'user']);
        return view('signatures.show', compact('signature'));
    }

    public function edit(DocumentSignature $signature)
    {
        // Проверка прав доступа
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) {
            abort(403);
        }

        $documents = Document::all();
        return view('signatures.edit', compact('signature', 'documents'));
    }

    public function destroy(DocumentSignature $signature)
    {
        // Проверка прав доступа
        if (!Auth::user()->is_admin && $signature->user_id !== Auth::id()) {
            abort(403);
        }

        DocumentLog::create([
            'document_id' => $signature->document_id,
            'user_id'     => Auth::id(),
            'action'      => 'deleted',
            'description' => 'Запись о подписи удалена из системы',
        ]);

        $signature->delete();
        return back()->with('success', 'Запись удалена');
    }
}
