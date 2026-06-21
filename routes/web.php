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
//        return back()->with('success', 'Switched to user: ' . Auth::user()->name);
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
//        $user = \App\Models\User::where('email', $request->email)->first();
//        return response()->json([
//            'exists' => !!$user,
//            'name'   => $user ? $user->name : null
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
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\Admin\SuperAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Публичные роуты
Route::get('/', function () {
    return view('layouts.site');
})->name('site.home');

Route::get('/site', function () {
    return view('layouts.site');
})->name('site.main');

require __DIR__ . '/auth.php';

// Локальный роут для тестирования (только в local окружении)
if (app()->environment('local')) {
    Route::post('/login-as', function (Request $request) {
        Auth::loginUsingId($request->user_id);
        return back()->with('success', 'Switched to user: ' . Auth::user()->name);
    })->name('login.as');
}

// Роуты для всех авторизованных пользователей
Route::middleware(['auth'])->group(function () {

    // Дашборд (через контроллер)
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

    // Документы - дополнительные роуты
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

    // Логи
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

// Роуты ТОЛЬКО для супер-админа
// ✅ ГЛАВНАЯ ГРУППА: для всех авторизованных пользователей
Route::middleware(['auth', 'last.seen'])->group(function () {

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

    Route::resource('messages', MessageController::class);
});

// ✅ СПЕЦИАЛЬНАЯ ГРУППА: только для супер-админа (с дополнительным middleware)
Route::middleware(['auth', 'superadmin'])
    ->prefix('super-admin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');
        Route::get('/activity', [SuperAdminController::class, 'activityIndex'])->name('activity.index');
        Route::get('/user/{user}/activity', [SuperAdminController::class, 'userActivity'])->name('user.activity');

        Route::resource('users', SuperAdminController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['users' => 'user']);

        Route::post('/user/{user}/avatar', [AvatarController::class, 'update'])->name('user.avatar.update');
        Route::delete('/user/{user}/avatar', [AvatarController::class, 'destroy'])->name('user.avatar.destroy');
        Route::get('/users', [SuperAdminController::class, 'usersIndex'])->name('users.index');
    });