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
        // Ambil slug dari URL
        $slug = $request->route('slug');
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        // Jika tidak ditemukan mitra, bisa langsung abort
        if (!$mitra) {
            abort(404, 'Mitra tidak ditemukan.');
        }

        // Jika user login dan mitra_id cocok, lanjutkan
        if (Auth::check() && Auth::user()->mitra_id == $mitra->id && (Auth::user()->role == 'Owner' || Auth::user()->role == 'Cashier')) {
            return $next($request);
        }

        // Jika user sudah login tapi tidak cocok, tampilkan 403 Forbidden
        if (Auth::check()) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Jika belum login, redirect ke login admin
        return redirect()->route('admin.login', ['slug' => $slug])->with('error', 'Silakan login terlebih dahulu.');
    }
}
