<?php
//
//namespace App\Http\Controllers;
//
//use Carbon\Carbon;
//use Illuminate\Http\Request;
//use App\Models\Document;
//use App\Models\User;
//use Illuminate\Support\Facades\DB;
//
//class AnalysisController extends Controller
//{
//    /**
//     * Отображение аналитики документооборота и пользователей.
//     */
//    public function index(Request $request)
//    {
//        // 1. Настройка временного периода (фильтрация)
//        $month = (int) $request->get('month', Carbon::now()->month);
//        $year  = (int) $request->get('year', Carbon::now()->year);
//
//        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
//        $endDate   = Carbon::createFromDate($year, $month, 1)->endOfMonth();
//
//        // 2. Оптимизированный сбор активности документов по дням
//        $rawDocs = Document::select(
//            DB::raw('DATE(created_at) as date'),
//            DB::raw('COUNT(*) as count')
//        )
//            ->whereBetween('created_at', [$startDate, $endDate])
//            ->groupBy('date')
//            ->pluck('count', 'date');
//
//        // 3. Статистика статусов (Реальные данные за период)
//        // Используем один базовый запрос для оптимизации, если это возможно,
//        // но здесь оставлены фильтры согласно вашей бизнес-логике.
//        $statusData = [
//            'signed' => Document::whereBetween('created_at', [$startDate, $endDate])
//                ->where('status', 'active')
//                ->whereHas('signatures', function ($query) {
//                    $query->whereNotNull('signature')
//                        ->where('signature', '!=', '');
//                })->count(),
//
//            'pending' => Document::whereBetween('created_at', [$startDate, $endDate])
//                ->where('status', 'active')
//                ->whereDoesntHave('signatures', function ($query) {
//                    $query->whereNotNull('signature')
//                        ->where('signature', '!=', '');
//                })->count(),
//
//            'incoming' => Document::whereBetween('created_at', [$startDate, $endDate])
//                ->whereNotNull('receiver_id')->count(),
//
//            'outgoing' => Document::whereBetween('created_at', [$startDate, $endDate])
//                ->whereNotNull('created_by')->count(),
//
//            'rejected' => Document::whereBetween('created_at', [$startDate, $endDate])
//                ->where('status', 'rejected')->count(),
//        ];
//
//        // 4. Активность пользователей (Регистрации и Удаления)
//        $registrations = User::select(
//            DB::raw('DATE(created_at) as date'),
//            DB::raw('COUNT(*) as count')
//        )
//            ->whereBetween('created_at', [$startDate, $endDate])
//            ->groupBy('date')
//            ->pluck('count', 'date');
//
//        $deletions = User::onlyTrashed()
//            ->select(
//                DB::raw('DATE(deleted_at) as date'),
//                DB::raw('COUNT(*) as count')
//            )
//            ->whereBetween('deleted_at', [$startDate, $endDate])
//            ->groupBy('date')
//            ->pluck('count', 'date');
//
//        // 5. Подготовка данных для графиков (заполнение пустых дней нулями)
//        $dailyActivity = collect();
//        $userActivity  = collect();
//        $daysInMonth   = $startDate->daysInMonth;
//
//        for ($i = 1; $i <= $daysInMonth; $i++) {
//            $dateInstance = Carbon::createFromDate($year, $month, $i);
//            $currentDate  = $dateInstance->format('Y-m-d');
//            $displayDate  = $dateInstance->format('d.m');
//
//            $dailyActivity->push([
//                'date'  => $displayDate,
//                'count' => $rawDocs->get($currentDate, 0),
//            ]);
//
//            $userActivity->push([
//                'date' => $displayDate,
//                'reg'  => $registrations->get($currentDate, 0),
//                'del'  => $deletions->get($currentDate, 0),
//            ]);
//        }
//
//        // 6. Глобальные показатели (Всего в системе)
//        $totalDocuments = Document::count();
//        $totalUsers     = User::count();
//
//        // 7. Показатели за выбранный месяц (для расчета Churn Rate)
//        $newThisMonth = User::whereBetween('created_at', [$startDate, $endDate])->count();
//        $deletedThisMonth = User::onlyTrashed()
//            ->whereBetween('deleted_at', [$startDate, $endDate])->count();
//
//        // Расчет коэффициента оттока (предотвращение деления на ноль)
//        $churnRate = $totalUsers > 0
//            ? round(($deletedThisMonth / $totalUsers) * 100, 1)
//            : 0;
//
//        $viewName = $request->is('analysis*') ? 'analysis.index' : 'site';
//
//        return view($viewName, [
//            'dailyActivity'    => $dailyActivity,
//            'statusData'       => $statusData,
//            'userActivity'     => $userActivity,
//            'totalUsers'       => $totalUsers,
//            'totalDocuments'   => $totalDocuments,
//            'newThisMonth'     => $newThisMonth,
//            'deletedThisMonth' => $deletedThisMonth,
//            'churnRate'        => $churnRate,
//            'month'            => $month,
//            'year'             => $year,
//        ]);
//
//    }
//}


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
        $month = (int)$request->get('month', Carbon::now()->month);
        $year = (int)$request->get('year', Carbon::now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $rawDocs = Document::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');


        $statusData = [
            'signed' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'active')
                ->whereHas('signatures', function ($query) {
                    $query->whereNotNull('signature')->where('signature', '!=', '');
                })->count(),
            'pending' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'active')
                ->whereDoesntHave('signatures', function ($query) {
                    $query->whereNotNull('signature')->where('signature', '!=', '');
                })->count(),
            'incoming' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('receiver_id')->count(),
            'outgoing' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('created_by')->count(),
            'rejected' => Document::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'rejected')->count(),
        ];


        $registrations = User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')->pluck('count', 'date');

        $deletions = User::onlyTrashed()->select(DB::raw('DATE(deleted_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereBetween('deleted_at', [$startDate, $endDate])
            ->groupBy('date')->pluck('count', 'date');

        $dailyActivity = collect();
        $userActivity = collect();
        $daysInMonth = $startDate->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dateInstance = Carbon::createFromDate($year, $month, $i);
            $currentDate = $dateInstance->format('Y-m-d');
            $displayDate = $dateInstance->format('d.m');

            $dailyActivity->push([
                'date' => $displayDate,
                'count' => $rawDocs->get($currentDate, 0),
            ]);

            $userActivity->push([
                'date' => $displayDate,
                'reg' => $registrations->get($currentDate, 0),
                'del' => $deletions->get($currentDate, 0),
            ]);
        }


        $totalDocuments = Document::count();
        $totalUsers = User::count();
        $newThisMonth = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $deletedThisMonth = User::onlyTrashed()->whereBetween('deleted_at', [$startDate, $endDate])->count();

        $churnRate = $totalUsers > 0 ? round(($deletedThisMonth / $totalUsers) * 100, 1) : 0;
       $viewName = $request->is('analysis*') ? 'analysis.index' : 'layouts.site';

        return view($viewName, compact(
            'dailyActivity', 'statusData', 'userActivity', 'totalUsers',
            'totalDocuments', 'newThisMonth', 'deletedThisMonth', 'churnRate', 'month', 'year'
        ));
    }
}
