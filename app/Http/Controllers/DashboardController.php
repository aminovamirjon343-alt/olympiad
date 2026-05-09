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
        $user = Auth::user();

        // 1. Общее количество документов (только доступных пользователю)
        $totalDocs = Document::visibleToAuth()->count();

        $prevTotalDocs = Document::visibleToAuth()
            ->where('created_at', '<', now()->startOfMonth())
            ->count();

        $docsGrowth = $prevTotalDocs > 0
            ? round((($totalDocs - $prevTotalDocs) / $prevTotalDocs) * 100, 1)
            : ($totalDocs > 0 ? 100 : 0);

        // 2. ПОДПИСИ (Только те, что относятся к доступным документам)
        // Используем whereHas, чтобы считать подписи только в документах, которые видит юзер
        $signedCount = DocumentSignature::whereHas('document', function($q) {
            $q->visibleToAuth();
        })->count();

        $prevSigned = DocumentSignature::whereHas('document', function($q) {
            $q->visibleToAuth();
        })->where('created_at', '<', now()->startOfMonth())->count();

        $signedGrowth = $prevSigned > 0
            ? round((($signedCount - $prevSigned) / $prevSigned) * 100, 1)
            : ($signedCount > 0 ? 100 : 0);

        // 3. Сбор статистики (с учетом прав доступа)
        $stats = [
            'total'    => $totalDocs,
            'active'   => Document::visibleToAuth()->whereIn('status', ['active', 'Active'])->count(),
            'signed'   => $signedCount,
            'rejected' => Document::visibleToAuth()->whereIn('status', ['rejected', 'Rejected'])->count(),
            'pending'  => Document::visibleToAuth()->whereIn('status', ['pending', 'Pending'])->count(),
            'users'    => User::count(), // Пользователей обычно видят все, либо тоже фильтруй
        ];

        // 4. Последние документы (только свои/входящие)
        $documents = Document::visibleToAuth()->latest()->take(6)->get();

        // Логи действий (у тебя уже было правильно - по Auth::id())
        $activities = DocumentLog::where('user_id', $user->id)->latest()->take(5)->get();

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
