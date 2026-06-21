<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserOnlineStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Обновляем last_seen_at напрямую через DB (быстрее и надёжнее)
            if (!$user->last_seen_at || now()->diffInMinutes($user->last_seen_at) >= 1) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['last_seen_at' => now()]);
            }
        }

        return $next($request);
    }
}