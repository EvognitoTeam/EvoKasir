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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ambil slug dari route parameter
        $slug = $request->route('slug');

        // Jika belum login
        if (!Auth::check()) {
            return redirect()
                ->route('user.login', ['slug' => $slug])
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        // Ambil role user
        $userRole = Auth::user()->role;

        // Cek apakah role user termasuk role yang diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
