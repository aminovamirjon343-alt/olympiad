<?php

namespace App\Providers;

use App\Models\Document;
use App\Observers\DocumentObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

        Document::observe(DocumentObserver::class);
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $userId = \Illuminate\Support\Facades\Auth::id();

                // Загружаем уведомления напрямую из твоей модели
                $notifications = \App\Models\Notification::where('user_id', $userId)
                    ->latest()
                    ->take(10)
                    ->get();

                $unreadCount = \App\Models\Notification::where('user_id', $userId)
                    ->where('is_read', false)
                    ->count();

                $view->with([
                    'notifications' => $notifications,
                    'unreadCount' => $unreadCount
                ]);

            }
        });

    }
}
