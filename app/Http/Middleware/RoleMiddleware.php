<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah role user ada dalam parameter yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak berhak, kembalikan response 403 Forbidden atau redirect ke dashboard dengan error
        return abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}
