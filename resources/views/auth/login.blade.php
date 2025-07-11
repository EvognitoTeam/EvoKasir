@extends('layouts.main')

@section('title', 'Login ke Akun Anda')

@section('content')
    <section class="min-h-screen flex items-center justify-center p-4">
        <div
            class="absolute inset-0 bg-gradient-to-br from-gray-900 via-indigo-900 to-teal-800 bg-[length:200%_200%] animate-background-pan z-0">
        </div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff22_1px,transparent_1px)] [background-size:32px_32px]"></div>

        <div
            class="relative w-full max-w-md bg-white/90 backdrop-blur-lg p-6 sm:p-8 rounded-2xl shadow-xl animate-fade-in-up">

            <div class="text-center mb-8">
                <a href="/" class="inline-block mb-4">
                    <img src="/storage/logo/6814f4b762b42.png" alt="EvoKasir Logo" class="w-12 h-12 mx-auto">
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Selamat Datang Kembali</h2>
                <p class="text-gray-600 mt-1">Masuk untuk melanjutkan ke dasbor Anda.</p>
            </div>

            <form action="/login" method="POST" class="space-y-6" id="login-form">
                @csrf

                <div class="relative">
                    <input type="email" name="email" id="email"
                        class="peer w-full p-3 pt-5 bg-transparent border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                        placeholder="email@example.com" required value="{{ old('email') }}">
                    <label for="email"
                        class="absolute left-3 top-2 text-gray-500 text-xs transition-all 
                                  peer-placeholder-shown:text-base peer-placeholder-shown:top-3.5 
                                  peer-focus:top-2 peer-focus:text-xs peer-focus:text-indigo-600">
                        Alamat Email
                    </label>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="peer w-full p-3 pt-5 bg-transparent border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                        placeholder="Kata Sandi" required>
                    <label for="password"
                        class="absolute left-3 top-2 text-gray-500 text-xs transition-all 
                                  peer-placeholder-shown:text-base peer-placeholder-shown:top-3.5 
                                  peer-focus:top-2 peer-focus:text-xs peer-focus:text-indigo-600">
                        Kata Sandi
                    </label>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Lupa kata sandi?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105 disabled:bg-indigo-400 disabled:cursor-not-allowed">
                        <span id="button-text">Masuk</span>
                        <svg id="loading-spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.getElementById('login-form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('loading-spinner');

            // Menonaktifkan tombol untuk mencegah submit ganda
            button.disabled = true;

            // Menampilkan spinner dan menyembunyikan teks
            buttonText.classList.add('hidden');
            spinner.classList.remove('hidden');
        });
    </script>
@endpush
