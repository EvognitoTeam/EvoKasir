@extends('layouts.app')

@section('title')
    Daftar User - {{ $mitra->mitra_name }}
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700">
        <div class="w-full max-w-md p-6 bg-gray-800 rounded-lg shadow-xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white">Daftar ke {{ $mitra->mitra_name }}</h1>
                <p class="text-gray-400 mt-2">Buat akun untuk menjadi member dan nikmati layanan kami</p>
            </div>

            <form method="POST" action="{{ route('user.register', ['slug' => $slug]) }}" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full px-4 py-2 bg-gray-900 text-white border border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full px-4 py-2 bg-gray-900 text-white border border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan email">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300">Nomor Telepon</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                        class="mt-1 block w-full px-4 py-2 bg-gray-900 text-white border border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan nomor telepon">
                    @error('phone')
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

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Konfirmasi
                        Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="mt-1 block w-full px-4 py-2 bg-gray-900 text-white border border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Konfirmasi password">
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition duration-300">
                    Daftar
                </button>
            </form>

            <p class="text-center text-sm text-gray-400 mt-6">
                Sudah punya akun? <a href="{{ route('user.login', ['slug' => $slug]) }}"
                    class="text-indigo-400 hover:text-indigo-300">Login di sini</a>
            </p>
        </div>
    </div>
@endsection
