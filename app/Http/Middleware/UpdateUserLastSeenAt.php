<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class UpdateUserLastSeenAt
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada pengguna yang login
        if (Auth::check()) {
            $user = Auth::user();

            // Optimasi: Hanya update jika aktivitas terakhir lebih dari 1 menit yang lalu
            // Ini untuk mengurangi beban database write pada setiap request
            $lastSeen = session('last_seen_at');

            if (!$lastSeen || Carbon::parse($lastSeen)->diffInMinutes(now()) >= 1) {
                $user->update(['last_seen_at' => now()]);
                session(['last_seen_at' => now()->toDateTimeString()]);
            }
        }

        return $next($request);
    }
}
