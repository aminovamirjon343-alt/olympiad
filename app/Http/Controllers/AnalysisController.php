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
        /*
        |--------------------------------------------------------------------------
        | Месяц и год
        |--------------------------------------------------------------------------
        */
        $month = (int) $request->get('month', Carbon::now()->month);
        $year  = (int) $request->get('year', Carbon::now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate   = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | Активность документов по дням (График)
        |--------------------------------------------------------------------------
        */
        $rawDocs = Document::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        /*
        |--------------------------------------------------------------------------
        | Статистика документов (за выбранный период)
        |--------------------------------------------------------------------------
        */
        $statusData = [
            'signed' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'active')
                ->whereHas('signatures', function ($query) {
                    $query->whereNotNull('signature')
                        ->where('signature', '!=', '');
                })
                ->count(),

            'pending' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'active')
                ->whereDoesntHave('signatures', function ($query) {
                    $query->whereNotNull('signature')
                        ->where('signature', '!=', '');
                })
                ->count(),

            'incoming' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('receiver_id')
                ->count(),

            'outgoing' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('created_by')
                ->count(),

            'rejected' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'rejected')
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Активность пользователей (График)
        |--------------------------------------------------------------------------
        */
        $registrations = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        $deletions = User::onlyTrashed()
            ->select(
                DB::raw('DATE(deleted_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('deleted_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        /*
        |--------------------------------------------------------------------------
        | Генерация данных для графиков по дням месяца
        |--------------------------------------------------------------------------
        */
        $dailyActivity = collect();
        $userActivity  = collect();
        $daysInMonth = $startDate->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $currentDate = Carbon::createFromDate($year, $month, $i)->format('Y-m-d');
            $displayDate = Carbon::parse($currentDate)->format('d.m');

            $dailyActivity->push([
                'date'  => $displayDate,
                'count' => $rawDocs->get($currentDate, 0),
            ]);

            $userActivity->push([
                'date' => $displayDate,
                'reg'  => $registrations->get($currentDate, 0),
                'del'  => $deletions->get($currentDate, 0),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Общая статистика (Глобальные цифры)
        |--------------------------------------------------------------------------
        */
        // 1. Считаем ВООБЩЕ ВСЕ документы в базе (без фильтра по дате)
        $totalDocuments = Document::count();

        // 2. Считаем ВСЕХ пользователей
        $totalUsers = User::count();

        // Статистика за текущий выбранный месяц
        $newThisMonth = User::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

        $deletedThisMonth = User::onlyTrashed()
            ->whereMonth('deleted_at', $month)
            ->whereYear('deleted_at', $year)
            ->count();

        $churnRate = $totalUsers > 0
            ? round(($deletedThisMonth / $totalUsers) * 100, 1)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Возврат View
        |--------------------------------------------------------------------------
        */
        return view('analysis.index', compact(
            'dailyActivity',
            'statusData',
            'userActivity',
            'totalUsers',
            'totalDocuments', // <-- Передаем исправленную переменную
            'newThisMonth',
            'deletedThisMonth',
            'churnRate',
            'month',
            'year'
        ));
    }
}
