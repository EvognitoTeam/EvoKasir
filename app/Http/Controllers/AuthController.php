<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mitra;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $mitra = Mitra::where('id', Auth::user()->mitra_id)->first();
            // Login berhasil, redirect ke halaman admin
            // dd($mitra);
            ActivityHelper::createActivity(
                description: 'Login Mitra',
                activityType: 'login',
                mitraId: $mitra->id,
                userId: Auth::check() ? Auth::id() : null,
                request: $request,
            );
            return redirect()->route('admin.index', ['slug' => $mitra->mitra_slug]); // Ganti sesuai dengan mitra_id yang sesuai
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_address' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Simpan data mitra
        $mitra = Mitra::create([
            'mitra_name' => $request->business_name,
            'mitra_address' => $request->business_address,
            'mitra_slug' => Str::slug($request->business_name, '_'),
        ]);

        // dd($mitra);
        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mitra_id' => $mitra->id,
            'role' => 'Owner',
        ]);

        ActivityHelper::createActivity(
            description: 'Register Mitra',
            activityType: 'register',
            mitraId: $mitra->id,
            userId: Auth::check() ? Auth::id() : null,
            request: $request,
        );

        // Login otomatis
        Auth::login($user);

        return redirect()->route('admin.index', ['slug' => $mitra->mitra_slug]);
    }
}
