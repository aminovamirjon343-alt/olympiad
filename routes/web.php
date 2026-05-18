<?php
//
//use App\Http\Controllers\DashboardController;
//use App\Http\Controllers\DocumentCommentController;
//use App\Http\Controllers\DocumentController;
//use App\Http\Controllers\DocumentLogController;
//use App\Http\Controllers\DocumentSignatureController;
//use App\Http\Controllers\DocumentWorkflowController;
//use App\Http\Controllers\DocumentVersionController;
//use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\SearchController;
//use App\Http\Controllers\UserController;
//use App\Http\Controllers\NotificationController;
//use Illuminate\Support\Facades\Route;
//
//
//Route::get('/', function () {
//    return redirect()->route('dashboard');
//});
//
//
//Route::get('/dashboard', [DashboardController::class, 'index'])
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
//
//
//    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//
//
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//Route::middleware(['auth'])->group(function () {
//
//    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
//
//
//    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//});
//
//
//Route::middleware(['auth'])->group(function () {
//    Route::resource('documents', DocumentController::class);
//    Route::resource('users', UserController::class);
//    Route::resource('signatures', DocumentSignatureController::class);
//    Route::resource('versions', DocumentVersionController::class);
//    Route::resource('logs', DocumentLogController::class);
//    Route::resource('notifications', NotificationController::class);
//    Route::post('/notifications/{id}/read', function ($id) {
//        $notification = auth()->user()->notifications()->find($id);
//
//        if ($notification) {
//            $notification->markAsRead();
//        }
//
//        return response()->json(['success' => true]);
//    });
//
//
//    Route::get('/search', [SearchController::class, 'index'])->name('search');
//
//
//    Route::post('/documents/{document}/sign', [DocumentSignatureController::class, 'store'])->name('documents.sign');
//
//
//    Route::prefix('workflow')->name('workflow.')->group(function () {
//        Route::get('/document/{documentId}', [DocumentWorkflowController::class, 'index'])->name('index');
//        Route::get('/document/{documentId}/create', [DocumentWorkflowController::class, 'create'])->name('create');
//        Route::post('/document/{documentId}', [DocumentWorkflowController::class, 'store'])->name('store');
//        Route::post('/approve/{id}', [DocumentWorkflowController::class, 'approve'])->name('approve');
//        Route::post('/reject/{id}', [DocumentWorkflowController::class, 'reject'])->name('reject');
//    });
//
//
//    Route::post('/comments', [DocumentCommentController::class, 'store'])->name('comments.store');
//    Route::get('/documents/{documentId}/comments', [DocumentCommentController::class, 'index'])->name('comments.index');
//    Route::delete('/comments/{comment}', [DocumentCommentController::class, 'destroy'])->name('comments.destroy');
//});
//Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
//
//
//Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
//
//Route::get('/notifications/read-all', function () {
//    \DB::table('notifications')
//        ->where('user_id', auth()->id())
//        ->update(['is_read' => true]);
//
//    return redirect()->route('notifications.index');
//})->name('notifications.read_all')->middleware('auth');
//Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAll'])
//    ->name('notifications.clearAll');
//Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
//require __DIR__.'/auth.php';
//Route::resource('/workflow',DocumentWorkflowController::class);




use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentCommentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentLogController;
use App\Http\Controllers\DocumentSignatureController;
use App\Http\Controllers\DocumentWorkflowController;
use App\Http\Controllers\DocumentVersionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AnalysisController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// ==========================================
// 1. ПУБЛИЧНЫЕ РОУТЫ (ДОСТУПНЫ ВСЕМ БЕЗ ЛОГИНА)
// ==========================================

// Главная страница сайта (открывается сразу)
Route::get('/', function () {
    return view('layouts.site');
})->name('site.home');

Route::get('/site', function () {
    return view('layouts.site');
})->name('site.main');


// ==========================================
// 2. АВТОРИЗАЦИЯ И ЛОКАЛЬНЫЙ ВХОД
// ==========================================
require __DIR__ . '/auth.php';

if (app()->environment('local')) {
    Route::post('/login-as', function (Request $request) {
        Auth::loginUsingId($request->user_id);
        return back()->with('success', 'Switched to user: ' . Auth::user()->name);
    })->name('login.as');
}


// ==========================================
// 3. ЗАКРЫТАЯ АДМИНКА (ТОЛЬКО ПОСЛЕ ЛОГИНА)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Главная панель (Админка)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis.index');


    // Профиль пользователя
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

    // Документы и AI
    Route::get('/documents/{id}/download-pdf', [DocumentController::class, 'downloadPdf'])->name('documents.downloadPdf');
    Route::get('/documents/{id}/download-word', [DocumentController::class, 'downloadWord'])->name('documents.downloadWord');
    Route::post('/documents/ai-process', [DocumentController::class, 'storeFromPdf'])->name('documents.ai-process');
    Route::post('/documents/{id}/sign', [DocumentController::class, 'sign'])->name('documents.sign');
    Route::post('/documents/{document}/sign', [DocumentSignatureController::class, 'store'])->name('documents.sign_signature');

    // Ресурсные контроллеры
    Route::resource('documents', DocumentController::class);
    Route::resource('users', UserController::class);
    Route::resource('signatures', DocumentSignatureController::class);
    Route::resource('versions', DocumentVersionController::class);
    Route::resource('logs', DocumentLogController::class);
    Route::resource('workflow', DocumentWorkflowController::class);

    // Очистка логов
    Route::post('/logs/clear', [DocumentLogController::class, 'clear'])->name('logs.clear');

    // Поиск
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/api/users/search', function (Request $request) {
        $user = \App\Models\User::where('email', $request->email)->first();
        return response()->json([
            'exists' => !!$user,
            'name'   => $user ? $user->name : null
        ]);
    })->name('users.search_api');

    // Комментарии
    Route::post('/comments', [DocumentCommentController::class, 'store'])->name('comments.store');
    Route::get('/documents/{documentId}/comments', [DocumentCommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [DocumentCommentController::class, 'destroy'])->name('comments.destroy');

    // ========================================================
    // УВЕДОМЛЕНИЯ (Чистая группа без конфликтов и дубликатов)
    // ========================================================

    // Универсальный роут для чтения конкретного уведомления
    Route::any('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.read_patch');
    Route::post('/comments/store_notification', [NotificationController::class, 'store'])->name('comments.store_notification');

    // Группа для списков, создания и массовых действий
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/create', [NotificationController::class, 'create'])->name('create');
        Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('clearAll');

        // Массовое прочтение через контроллер
        Route::post('/read-all', [NotificationController::class, 'readAll'])->name('readAll');
    });

});
