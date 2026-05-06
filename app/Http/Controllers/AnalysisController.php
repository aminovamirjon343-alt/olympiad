<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // 1. Данные для графика (остаются без изменений)
        $rawDocs = Document::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        // 2. Сбор данных по реальным статусам из вашей БД (active, draft)
        $statuses = Document::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Приводим ключи к нижнему регистру на всякий случай
        $statuses = array_change_key_case($statuses, CASE_LOWER);

        // МАППИНГ: привязываем ваши статусы к ключам фронтенда
        $statusData = [
            'signed'   => $statuses['active'] ?? 0,   // Ваши 'active' стали 'signed'
            'pending'  => $statuses['draft'] ?? 0,    // Ваши 'draft' стали 'pending'
            'rejected' => $statuses['rejected'] ?? 0, // На будущее
        ];

        // 3. Блок пользователей
        $registrations = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        $deletions = User::onlyTrashed()
            ->select(DB::raw('DATE(deleted_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('deleted_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        // 4. Генерация активности по дням
        $dailyActivity = collect();
        $userActivity = collect();
        $daysInMonth = $startDate->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $currentDate = Carbon::createFromDate($year, $month, $i)->format('Y-m-d');
            $displayDate = Carbon::parse($currentDate)->format('d.m');

            $dailyActivity->push([
                'date' => $displayDate,
                'count' => $rawDocs->get($currentDate, 0)
            ]);

            $userActivity->push([
                'date' => $displayDate,
                'reg' => $registrations->get($currentDate, 0),
                'del' => $deletions->get($currentDate, 0),
            ]);
        }

        // Итоговые цифры для карточек пользователей
        $totalUsers = User::count();
        $newThisMonth = User::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        $deletedThisMonth = User::onlyTrashed()->whereMonth('deleted_at', $month)->whereYear('deleted_at', $year)->count();
        $churnRate = $totalUsers > 0 ? round(($deletedThisMonth / $totalUsers) * 100, 1) : 0;

        return view('analysis.index', compact(
            'dailyActivity', 'statusData', 'userActivity',
            'totalUsers', 'newThisMonth', 'churnRate', 'month', 'year'
        ));
    }
}
