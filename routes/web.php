<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentCommentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentLogController;
use App\Http\Controllers\DocumentSignatureController;
use App\Http\Controllers\DocumentWorkflowController;
use App\Http\Controllers\DocumentVersionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');


    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');


    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');


    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('documents', DocumentController::class);
    Route::resource('users', UserController::class);
    Route::resource('signatures', DocumentSignatureController::class);
    Route::resource('versions', DocumentVersionController::class);
    Route::resource('logs', DocumentLogController::class);
    Route::resource('notifications', NotificationController::class);
    Route::post('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    });


    Route::get('/search', [SearchController::class, 'index'])->name('search');


    Route::post('/documents/{document}/sign', [DocumentSignatureController::class, 'store'])->name('documents.sign');


    Route::prefix('workflow')->name('workflow.')->group(function () {
        Route::get('/document/{documentId}', [DocumentWorkflowController::class, 'index'])->name('index');
        Route::get('/document/{documentId}/create', [DocumentWorkflowController::class, 'create'])->name('create');
        Route::post('/document/{documentId}', [DocumentWorkflowController::class, 'store'])->name('store');
        Route::post('/approve/{id}', [DocumentWorkflowController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [DocumentWorkflowController::class, 'reject'])->name('reject');
    });


    Route::post('/comments', [DocumentCommentController::class, 'store'])->name('comments.store');
    Route::get('/documents/{documentId}/comments', [DocumentCommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [DocumentCommentController::class, 'destroy'])->name('comments.destroy');
});
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');


Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');

Route::get('/notifications/read-all', function () {
    \DB::table('notifications')
        ->where('user_id', auth()->id())
        ->update(['is_read' => true]);

    return redirect()->route('notifications.index');
})->name('notifications.read_all')->middleware('auth');
Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAll'])
    ->name('notifications.clearAll');
Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
require __DIR__.'/auth.php';
