<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna yang sudah login memiliki akses admin
        if ($request->user() && $request->user()->hasAdminAccess()) {
            return $next($request);
        }

        // Jika tidak punya akses, bisa pilih salah satu:
        return redirect()->route('home')
                         ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman admin.');
    }
}
