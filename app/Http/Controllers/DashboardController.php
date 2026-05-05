<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\User;
use App\Models\DocumentSignature; // Не забудь импортировать модель подписей!
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Общее количество документов и рост
        $totalDocs = Document::count();
        $prevTotalDocs = Document::where('created_at', '<', now()->startOfMonth())->count();
        $docsGrowth = $prevTotalDocs > 0
            ? round((($totalDocs - $prevTotalDocs) / $prevTotalDocs) * 100, 1)
            : ($totalDocs > 0 ? 100 : 0);

        // 2. ПОДПИСИ (Считаем из правильной таблицы document_signatures)
        // Здесь твои 4 подписи наконец-то найдутся
        $signedCount = DocumentSignature::count();

        $prevSigned = DocumentSignature::where('created_at', '<', now()->startOfMonth())->count();
        $signedGrowth = $prevSigned > 0
            ? round((($signedCount - $prevSigned) / $prevSigned) * 100, 1)
            : ($signedCount > 0 ? 100 : 0);

        // 3. Сбор статистики
        $stats = [
            'total'    => $totalDocs,
            'active'   => Document::whereIn('status', ['active', 'Active'])->count(),
            'signed'   => $signedCount, // Передаем реальное кол-во подписей
            'rejected' => Document::whereIn('status', ['rejected', 'Rejected'])->count(),
            'pending'  => Document::whereIn('status', ['pending', 'Pending'])->count(),
            'users'    => User::count(),
        ];

        // 4. Последние документы и логи
        $documents = Document::where('created_by', Auth::id())->latest()->take(5)->get();
        $activities = DocumentLog::where('user_id', Auth::id())->latest()->take(5)->get();

        return view('dashboard', compact(
            'stats',
            'documents',
            'totalDocs',
            'activities',
            'docsGrowth',
            'signedGrowth'
        ));
    }
}
