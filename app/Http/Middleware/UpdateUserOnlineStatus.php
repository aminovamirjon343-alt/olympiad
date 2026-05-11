<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class UpdateUserOnlineStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Кэшируем статус на 5 минут
            Cache::put('user-is-online-' . Auth::id(), true, now()->addMinutes(5));
        }

        return $next($request);
    }
}
