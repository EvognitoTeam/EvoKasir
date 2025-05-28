@extends('layouts.app')

@section('title')
    Login User - {{ $mitra->mitra_name }}
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700">
        <div class="w-full max-w-md p-6 bg-gray-800 rounded-lg shadow-xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white">Login ke {{ $mitra->mitra_name }}</h1>
                <p class="text-gray-400 mt-2">Masuk untuk mengelola pesanan Anda</p>
            </div>

            <form method="POST" action="{{ route('user.login', ['slug' => $slug]) }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email atau Username</label>
                    <input id="email" type="text" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full px-4 py-2 bg-gray-900 text-white border border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan email atau username">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-4 py-2 bg-gray-900 text-white border border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan password">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-600 rounded bg-gray-900">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition duration-300">
                    Login
                </button>
            </form>

            <p class="text-center text-sm text-gray-400 mt-6">
                Belum punya akun? <a href="{{ route('user.register', ['slug' => $slug]) }}"
                    class="text-indigo-400 hover:text-indigo-300">Daftar di sini</a>
            </p>
        </div>
    </div>
@endsection
