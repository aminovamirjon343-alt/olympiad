<?php

use App\Http\Controllers\DocumentCommentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentLogController;
use App\Http\Controllers\DocumentSignatureController;
use App\Http\Controllers\DocumentWorkflowController;
use App\Http\Controllers\DocumentVersionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

    /*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

/*
|--------------------------------------------------------------------------
| Resources
|--------------------------------------------------------------------------
*/

Route::resource('documents', DocumentController::class);
Route::resource('versions', DocumentVersionController::class);
Route::resource('users', UserController::class);
Route::resource('signatures', DocumentSignatureController::class);
Route::get('/documents/{id}', [DocumentController::class, 'show'])
    ->name('documents.show');
Route::post('/documents/{document}/sign', [DocumentSignatureController::class, 'store'])
    ->name('documents.sign');
Route::get('/login', [DocumentSignatureController::class, 'create'])->name('login');

/*
|--------------------------------------------------------------------------
| Workflow (100% БЕЗ БАГОВ)
|--------------------------------------------------------------------------
*/

Route::prefix('workflow')->group(function () {

    //  СНАЧАЛА document маршруты
    Route::get('/document/{documentId}', [DocumentWorkflowController::class, 'index'])
        ->name('workflow.index');

    Route::get('/document/{documentId}/create', [DocumentWorkflowController::class, 'create'])
        ->name('workflow.create');

    Route::post('/document/{documentId}', [DocumentWorkflowController::class, 'store'])
        ->name('workflow.store');

    // действия
    Route::post('/approve/{id}', [DocumentWorkflowController::class, 'approve'])
        ->name('workflow.approve');

    Route::post('/reject/{id}', [DocumentWorkflowController::class, 'reject'])
        ->name('workflow.reject');

    //  В САМОМ КОНЦЕ
    Route::get('/{workflow}/edit', [DocumentWorkflowController::class, 'edit'])
        ->name('workflow.edit');

    Route::put('/{workflow}', [DocumentWorkflowController::class, 'update'])
        ->name('workflow.update');

    Route::delete('/{workflow}', [DocumentWorkflowController::class, 'destroy'])
        ->name('workflow.destroy');
});
    Route::resource('logs', DocumentLogController::class);



Route::resource('notifications', NotificationController::class);

// Этот оставляем, так как он нестандартный
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

Route::get('/comments/{documentId}', [DocumentCommentController::class, 'index'])
    ->name('comments.index');
Route::get('/documents/{documentId}/comments', [DocumentCommentController::class, 'index'])->name('comments.index');

Route::get('/comments/create/{documentId}', [DocumentCommentController::class, 'create'])
    ->name('comments.create');
Route::post('/comments', [DocumentCommentController::class, 'store'])
    ->middleware('auth') // Только для залогиненных!
    ->name('comments.store');
Route::delete('/comments/{comment}', [DocumentCommentController::class, 'destroy'])->name('comments.destroy');
require __DIR__.'/auth.php';
