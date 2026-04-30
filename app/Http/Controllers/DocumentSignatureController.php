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

    public function index()
    {
        $signatures = DocumentSignature::with('document', 'user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('signatures.index', compact('signatures'));
    }


    public function create()
    {
        $documents = Document::all();
        $users = User::all();
        return view('signatures.create', compact('documents', 'users'));
    }
    public function edit(DocumentSignature $signature)
    {
       $documents = Document::all();

        return view('signatures.edit', compact('signature', 'documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'signature' => 'required|string'
        ]);

        $document = Document::findOrFail($request->document_id);
        $signer = Auth::user();


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


        DocumentSignature::create([
            'document_id' => $document->id,
            'user_id' => $signer->id,
            'signature' => $request->signature,
            'signed_at' => now(),
        ]);


        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => $signer->id,
            'action' => 'signed',
            'description' => 'Документ подписан пользователем ' . $signer->name,
        ]);


        if ($document->created_by) {
            Notification::create([
                'user_id' => $document->created_by,
                'message' => "Пользователь {$signer->name} подписал ваш документ: \"{$document->title}\"",
                'type' => 'sign', // Наша иконка "перо"
                'is_read' => false,
            ]);
        }


        if ($currentWorkflow) {
            $currentWorkflow->update(['status' => 'approved']);

            $nextWorkflow = DocumentWorkflow::where('document_id', $document->id)
                ->where('step_order', '>', $currentWorkflow->step_order)
                ->orderBy('step_order')
                ->first();

            if ($nextWorkflow) {

                $nextWorkflow->update(['status' => 'pending']);


                Notification::create([
                    'user_id' => $nextWorkflow->user_id,
                    'message' => "Ваша очередь подписать документ: \"{$document->title}\"",
                    'type' => 'document',
                    'is_read' => false,
                ]);
            } else {

                $document->update(['status' => 'approved']);
            }
        }

        return redirect()->route('signatures.index')->with('success', 'Документ подписан, уведомления отправлены!');
    }


    public function update(Request $request, DocumentSignature $signature)
    {
        $request->validate(['signature' => 'required|string']);

        $signature->update(['signature' => $request->signature]);

        DocumentLog::create([
            'document_id' => $signature->document_id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Графическая подпись была обновлена',
        ]);

        return redirect()->route('signatures.index')->with('success', 'Подпись обновлена');
    }


    public function show(DocumentSignature $signature)
    {
        $signature->load(['document', 'user']);
        return view('signatures.show', compact('signature'));
    }


    public function destroy(DocumentSignature $signature)
    {
        DocumentLog::create([
            'document_id' => $signature->document_id,
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Подпись удалена из системы',
        ]);

        $signature->delete();
        return back()->with('success', 'Запись о подписи удалена');
    }
}
