<?php
//
//
//use App\Http\Controllers\CompanyController;
//use App\Http\Controllers\DashboardController;
//use App\Http\Controllers\DocumentCommentController;
//use App\Http\Controllers\DocumentController;
//use App\Http\Controllers\DocumentLogController;
//use App\Http\Controllers\DocumentSignatureController;
//use App\Http\Controllers\DocumentWorkflowController;
//use App\Http\Controllers\DocumentVersionController;
//use App\Http\Controllers\MessageController;
//use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\SearchController;
//use App\Http\Controllers\SettingsController;
//use App\Http\Controllers\UserController;
//use App\Http\Controllers\NotificationController;
//use App\Http\Controllers\AnalysisController;
//use Illuminate\Support\Facades\Route;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
//
//
//Route::get('/', function () {
//    return view('layouts.site');
//})->name('site.home');
//
//Route::get('/site', function () {
//    return view('layouts.site');
//})->name('site.main');
//
//
//require __DIR__ . '/auth.php';
//
//if (app()->environment('local')) {
//    Route::post('/login-as', function (Request $request) {
//        Auth::loginUsingId($request->user_id);
//        return back()->with('success', 'Switched to users: ' . Auth::users()->name);
//    })->name('login.as');
//}
//
//
//Route::middleware(['auth'])->group(function () {
//
//
//    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//    Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis.index');
//
//
//
//    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
//    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//
//
//    Route::get('/setting', function () {
//        return view('settings.index');
//    })->name('settings');
//    Route::post('/settings/signature', [ProfileController::class, 'updateSignature'])->name('settings.signature.update');
//    Route::post('/settings/general', [ProfileController::class, 'updateGeneral'])->name('settings.general.update');
//    Route::put('/settings/edi', [SettingsController::class, 'update'])->name('settings.update');
//
//
//    Route::get('/documents/{id}/download-pdf', [DocumentController::class, 'downloadPdf'])->name('documents.downloadPdf');
//    Route::get('/documents/{id}/download-word', [DocumentController::class, 'downloadWord'])->name('documents.downloadWord');
//    Route::post('/documents/ai-process', [DocumentController::class, 'storeFromPdf'])->name('documents.ai-process');
//    Route::post('/documents/{id}/sign', [DocumentController::class, 'sign'])->name('documents.sign');
//    Route::post('/documents/{document}/sign', [DocumentSignatureController::class, 'store'])->name('documents.sign_signature');
//
//
//    Route::resource('documents', DocumentController::class);
//    Route::resource('users', UserController::class);
//    Route::resource('signatures', DocumentSignatureController::class);
//    Route::resource('versions', DocumentVersionController::class);
//    Route::resource('logs', DocumentLogController::class);
//    Route::resource('workflow', DocumentWorkflowController::class);
//
//
//    Route::post('/logs/clear', [DocumentLogController::class, 'clear'])->name('logs.clear');
//
//
//    Route::get('/search', [SearchController::class, 'index'])->name('search');
//    Route::get('/api/users/search', function (Request $request) {
//        $users = \App\Models\User::where('email', $request->email)->first();
//        return response()->json([
//            'exists' => !!$users,
//            'name'   => $users ? $users->name : null
//        ]);
//    })->name('users.search_api');
//
//
//    Route::post('/comments', [DocumentCommentController::class, 'store'])->name('comments.store');
//    Route::get('/documents/{documentId}/comments', [DocumentCommentController::class, 'index'])->name('comments.index');
//    Route::delete('/comments/{comment}', [DocumentCommentController::class, 'destroy'])->name('comments.destroy');
//
//    Route::any('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
//    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
//    Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.read_patch');
//    Route::post('/comments/store_notification', [NotificationController::class, 'store'])->name('comments.store_notification');
//
//
//    Route::prefix('notifications')->name('notifications.')->group(function () {
//        Route::get('/', [NotificationController::class, 'index'])->name('index');
//        Route::get('/create', [NotificationController::class, 'create'])->name('create');
//        Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('clearAll');
//
//        // Добавьте эту строку:
//        Route::post('/read-all', [NotificationController::class, 'readAll'])->name('readAll');
//    });
//Route::resource('messages', MessageController::class);
//});
//Route::get('/super-admin/dashboard', [SuperAdminController::class, 'index'])
//    ->middleware(['auth', 'superadmin'])
////    ->name('superadmin.dashboard');
//



use App\Http\Controllers\Admin\AvatarController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentCommentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentLogController;
use App\Http\Controllers\DocumentSignatureController;
use App\Http\Controllers\DocumentWorkflowController;
use App\Http\Controllers\DocumentVersionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SuperAdminController; // ← ТОЛЬКО ОДИН импорт
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AnalysisController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Публичные роуты
Route::get('/', function () {
    return view('layouts.site');
})->name('site.home');

Route::get('/site', function () {
    return view('layouts.site');
})->name('site.main');

require __DIR__ . '/auth.php';

// Локальный роут для тестирования
if (app()->environment('local')) {
    Route::post('/login-as', function (Request $request) {
        Auth::loginUsingId($request->user_id);
        return back()->with('success', 'Switched to users: ' . Auth::user()->name);
    })->name('login.as');
}

// ✅ ОДНА ГРУППА для всех авторизованных пользователей (с last.seen)
Route::middleware(['auth', 'last.seen'])->group(function () {

    // Дашборд
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis.index');

    // Профиль
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Настройки
    Route::get('/setting', function () {
        return view('settings.index');
    })->name('settings');
    Route::post('/settings/signature', [ProfileController::class, 'updateSignature'])->name('settings.signature.update');
    Route::post('/settings/general', [ProfileController::class, 'updateGeneral'])->name('settings.general.update');
    Route::put('/settings/edi', [SettingsController::class, 'update'])->name('settings.update');

    // Документы
    Route::get('/documents/{id}/download-pdf', [DocumentController::class, 'downloadPdf'])->name('documents.downloadPdf');
    Route::get('/documents/{id}/download-word', [DocumentController::class, 'downloadWord'])->name('documents.downloadWord');
    Route::post('/documents/ai-process', [DocumentController::class, 'storeFromPdf'])->name('documents.ai-process');
    Route::post('/documents/{id}/sign', [DocumentController::class, 'sign'])->name('documents.sign');
    Route::post('/documents/{document}/sign', [DocumentSignatureController::class, 'store'])->name('documents.sign_signature');

    // Ресурсные роуты
    Route::resource('documents', DocumentController::class);
    Route::resource('users', UserController::class);
    Route::resource('signatures', DocumentSignatureController::class);
    Route::resource('versions', DocumentVersionController::class);
    Route::resource('logs', DocumentLogController::class);
    Route::resource('workflow', DocumentWorkflowController::class);

    Route::post('/logs/clear', [DocumentLogController::class, 'clear'])->name('logs.clear');

    // Поиск
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/api/users/search', function (Request $request) {
        $user = \App\Models\User::where('email', $request->email)->first();
        return response()->json([
            'exists' => !!$user,
            'name' => $user ? $user->name : null
        ]);
    })->name('users.search_api');

    // Комментарии
    Route::post('/comments', [DocumentCommentController::class, 'store'])->name('comments.store');
    Route::get('/documents/{documentId}/comments', [DocumentCommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [DocumentCommentController::class, 'destroy'])->name('comments.destroy');

    // Уведомления
    Route::any('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.read_patch');
    Route::post('/comments/store_notification', [NotificationController::class, 'store'])->name('comments.store_notification');

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/create', [NotificationController::class, 'create'])->name('create');
        Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('clearAll');
        Route::post('/read-all', [NotificationController::class, 'readAll'])->name('readAll');
    });

    // Сообщения
    Route::resource('messages', MessageController::class);
});

// ✅ СПЕЦИАЛЬНАЯ ГРУППА: только для супер-админа
// ✅ СПЕЦИАЛЬНАЯ ГРУППА: только для супер-админа
Route::middleware(['auth', 'superadmin', 'last.seen'])
    ->prefix('super-admin')
    ->name('superadmin.')
    ->group(function () {
        // Дашборд
        Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');

        // Пользователи
        Route::get('/users', [SuperAdminController::class, 'usersIndex'])->name('users.index');
        Route::get('/users/create', [SuperAdminController::class, 'create'])->name('users.create');
        Route::post('/users', [SuperAdminController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [SuperAdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [SuperAdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [SuperAdminController::class, 'destroy'])->name('users.destroy');

        // Компании - ВАЖНО: порядок маршрутов!
        Route::get('/companies', [SuperAdminController::class, 'companiesIndex'])->name('companies.index');
        Route::get('/companies/create', [SuperAdminController::class, 'createCompany'])->name('companies.create');
        Route::post('/companies', [SuperAdminController::class, 'storeCompany'])->name('companies.store');
        Route::get('/companies/{company}', [SuperAdminController::class, 'showCompany'])->name('companies.show'); // ← РАСКОММЕНТИРОВАНО!
        Route::get('/companies/{company}/edit', [SuperAdminController::class, 'editCompany'])->name('companies.edit');
        Route::put('/companies/{company}', [SuperAdminController::class, 'updateCompany'])->name('companies.update');
        Route::delete('/companies/{company}', [SuperAdminController::class, 'destroyCompany'])->name('companies.destroy');

        // Профиль
        Route::get('/profile', [SuperAdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [SuperAdminController::class, 'updateProfile'])->name('profile.update');

        // Активность
        Route::get('/activity', [SuperAdminController::class, 'activityIndex'])->name('activity.index');
        Route::get('/user/{user}/activity', [SuperAdminController::class, 'userActivity'])->name('user.activity');
    });