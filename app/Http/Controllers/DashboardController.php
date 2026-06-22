<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentSignature;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Общая статистика
        $totalDocs = Document::count();
        $stats = [
            'signed' => Document::where('status', 'signed')->count(),
            'users' => User::count(),
        ];

        // Рост документов за последний месяц
        $lastMonthDocs = Document::where('created_at', '>=', now()->subMonth())->count();
        $previousMonthDocs = Document::whereBetween('created_at', [
            now()->subMonths(2),
            now()->subMonth()
        ])->count();

        $docsGrowth = $previousMonthDocs > 0
            ? round((($lastMonthDocs - $previousMonthDocs) / $previousMonthDocs) * 100)
            : 0;

        // Рост подписей за последний месяц
        $lastMonthSigned = DocumentSignature::where('created_at', '>=', now()->subMonth())->count();
        $previousMonthSigned = DocumentSignature::whereBetween('created_at', [
            now()->subMonths(2),
            now()->subMonth()
        ])->count();

        $signedGrowth = $previousMonthSigned > 0
            ? round((($lastMonthSigned - $previousMonthSigned) / $previousMonthSigned) * 100)
            : 0;

        // Последние документы
        $documents = Document::with('users')->latest()->take(5)->get();

        // Активность (используем документы как активность)
        $activities = Document::with('users')->latest()->take(10)->get()->map(function($doc) {
            $doc->status = 'created';
            $doc->title = $doc->title;
            $doc->content = $doc->description ?? '';
            return $doc;
        });

        return view('dashboard', compact(
            'totalDocs',
            'docsGrowth',
            'signedGrowth',
            'stats',
            'documents',
            'activities'
        ));
    }
}