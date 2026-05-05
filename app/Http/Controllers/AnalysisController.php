<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document; // Импортируй свою модель документов
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function index()
    {
        // Данные для круговой диаграммы остаются теми же
        // Пример: если в базе статус хранится как 'completed', а не 'signed'
        $statusData = [
            'signed' => Document::where('status', 'signed')->count(), // Проверь это слово!
            'pending' => Document::where('status', 'pending')->count(),
            'rejected' => Document::where('status', 'rejected')->count(),
        ];

        // Группируем документы ПО ДНЯМ за последний месяц
        $dailyActivity = Document::select(
            DB::raw('COUNT(*) as count'),
            DB::raw("DATE_FORMAT(created_at, '%d.%m') as date")
        )
            ->where('created_at', '>=', now()->subDays(30)) // Берем последние 30 дней
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('analysis.index', compact('statusData', 'dailyActivity'));
    }
}
