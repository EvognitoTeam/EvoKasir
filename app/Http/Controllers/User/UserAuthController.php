<?php

namespace App\Http\Controllers\User;

use App\Helpers\ActivityHelper;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\LoyaltyPoints;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLoginForm($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        return view('auth.userLogin', ['slug' => $slug, 'mitra' => $mitra]);
    }
    public function showRegisterForm($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        return view('auth.userRegister', ['slug' => $slug, 'mitra' => $mitra]);
    }
    public function userProfile($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $loyalty = LoyaltyPoints::where('user_id', Auth::id())
            ->where('mitra_id', $mitra->id)
            ->first();
        $loyaltyPoints = $loyalty->points ?? 0;
        $loyaltyId = $loyalty->loyalty_id ?? 'Tidak tersedia';
        $activities = Activities::where('user_id', Auth::id())
            ->where('mitra_id', $mitra->id)
            ->latest()
            ->take(10)
            ->get();
        // dd($loyaltyId);
        return view('main.user.profile', compact('mitra', 'slug', 'loyaltyPoints', 'loyaltyId', 'activities'));
    }
    public function userLogin(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        // Logika autentikasi
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            ActivityHelper::createActivity(
                description: 'Login pengguna',
                activityType: 'login',
                mitraId: $mitra->id,
                userId: Auth::id(),
                request: $request
            );
            return redirect()->route('user.profile', ['slug' => $slug]);
        }
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function userRegister(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'mitra_id' => $mitra->id, // Asosiasi dengan mitra
        ]);

        // Generate loyalty_id (contoh: CDM-U123-M456-2025)
        $initials = collect(explode(' ', $mitra->mitra_name))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->implode('');
        $loyaltyId = "{$initials}-U{$user->id}-M{$mitra->id}-" . now()->year;

        // Tambah entri loyalty_points dengan poin 0
        LoyaltyPoints::create([
            'user_id' => $user->id,
            'mitra_id' => $mitra->id,
            'loyalty_id' => $loyaltyId,
            'points' => 0,
        ]);

        // Catat aktivitas registrasi
        ActivityHelper::createActivity(
            description: 'Pengguna memperbarui profil',
            activityType: 'profile_update',
            mitraId: $mitra->id,
            userId: $user->id,
            request: $request
        );

        Auth::login($user);
        return redirect()->route('user.profile', ['slug' => $slug]);
    }
    public function userLogout(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        ActivityHelper::createActivity(
            description: 'Logout pengguna',
            activityType: 'logout',
            mitraId: $mitra->id,
            userId: Auth::id(),
            request: $request
        );

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.index', ['slug' => $slug]);
    }
}
