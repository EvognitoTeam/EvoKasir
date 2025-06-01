<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Mitra;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Menampilkan daftar user berdasarkan mitra_id
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $users = User::where('mitra_id', $mitra->id)->get();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.auth.user', compact('users', 'mitra', 'slug', 'notifSound'));
    }

    // Menampilkan form untuk menambah user baru
    public function create($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.auth.create_user', compact('slug', 'mitra', 'notifSound'));
    }

    public function edit($slug, $id)
    {
        $mitra = Auth::user()->mitra;
        // dd($mitra);

        if ($mitra->mitra_slug !== $slug) {
            abort(403, 'Unauthorized');
        }

        $user = User::where('id', $id)->where('mitra_id', $mitra->id)->firstOrFail();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.auth.edit_user', compact('user', 'mitra', 'slug', 'notifSound'));
    }

    // Menyimpan user baru
    public function store(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        $user = new User();
        $user->mitra_id = $mitra->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index', ['slug' => $slug])
            ->with('success', 'User berhasil ditambahkan.');
    }
    public function update(Request $request, $slug, $id)
    {
        $mitra = Auth::user()->mitra;
        if ($mitra->mitra_slug !== $slug) {
            abort(403, 'Unauthorized');
        }

        $user = User::where('id', $id)->where('mitra_id', $mitra->id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index', ['slug' => $slug])
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($slug, $id)
    {
        $mitra = Auth::user()->mitra;
        if ($mitra->mitra_slug !== $slug) {
            abort(403, 'Unauthorized');
        }

        $user = User::where('id', $id)->where('mitra_id', $mitra->id)->firstOrFail();

        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index', ['slug' => $slug])
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index', ['slug' => $slug])
            ->with('success', 'User berhasil dihapus.');
    }

    public function showLoginForm($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        return view('admin.auth.login', compact('slug', 'mitra'));
    }

    public function login(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Login berhasil, redirect ke halaman admin
            if (Auth::check()) {
                $updateUser = User::where('id', Auth::id())
                    ->update([
                        'is_login' => 1,
                        'login_at' => now(),
                    ]);
            }
            return redirect()->route('admin.index', ['slug' => $slug]); // Ganti sesuai dengan mitra_id yang sesuai
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid',
        ]);
    }

    public function logout(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        ActivityHelper::createActivity(
            description: 'Logout Admin',
            activityType: 'logout',
            mitraId: $mitra->id,
            userId: Auth::check() ? Auth::id() : null,
            request: $request
        );

        $updateUser = User::where('id', Auth::id())
            ->update([
                'is_login' => 0,
                'login_at' => now(),
            ]);
        Auth::logout();
        return redirect()->route('admin.login', compact('slug'));
    }
}
