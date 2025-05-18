<?php

namespace App\Http\Middleware;

use App\Models\Mitra;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil slug dari URL saat ini
        $slug = $request->route('slug');
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        // Periksa apakah pengguna yang login adalah admin
        if (Auth::check() && Auth::user()->mitra_id == $mitra->id) {
            return $next($request);
        }

        Auth::logout();

        // Jika bukan admin, alihkan ke halaman login admin
        return redirect()->route('admin.login', ['slug' => $slug])->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
