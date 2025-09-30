<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Impor Auth

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah ada pengguna yang sedang login
        // 2. DAN cek apakah pengguna tersebut adalah instance dari model Admin
        if (Auth::check() && Auth::user() instanceof \App\Models\Admin) {
            // Jika ya, izinkan request untuk melanjutkan ke controller
            return $next($request);
        }

        // Jika tidak, tolak request dengan pesan error 403 (Forbidden)
        return response()->json([
            'message' => 'Akses ditolak. Hanya Admin yang diizinkan.'
        ], 403);
    }
}