<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Memeriksa apakah pengguna yang login memiliki role yang diizinkan.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Jika belum login, arahkan ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Pastikan akun masih aktif
        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan.',
            ]);
        }

        // 3. Jika role tidak cocok dengan halaman yang diakses, blokir akses (403)
        if ($user->role !== $role) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}