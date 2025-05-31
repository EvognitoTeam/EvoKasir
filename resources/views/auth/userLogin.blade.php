@extends('layouts.app')

@section('title')
    Login User - {{ $mitra->mitra_name }}
@endsection

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700 py-6 sm:py-8 relative overflow-hidden">
        <!-- Background Geometric Overlay -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"
                preserveAspectRatio="xMidYMid slice">
                <defs>
                    <pattern id="geo-pattern" patternUnits="userSpaceOnUse" width="30" height="30">
                        <path d="M0 30L15 0L30 30Z" fill="none" stroke="#34d399" stroke-width="1" />
                        <circle cx="15" cy="15" r="3" fill="#f87171" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#geo-pattern)" class="animate-subtle-pulse" />
            </svg>
        </div>
        <div
            class="w-full max-w-md sm:max-w-lg p-4 sm:p-6 bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl mx-4 sm:mx-6 relative z-10">
            <div class="text-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-coral-500 animate-text-reveal">
                    Login ke {{ $mitra->mitra_name }}
                </h1>
                <p class="text-gray-400 text-sm sm:text-base mt-2 animate-text-reveal" style="animation-delay: 0.2s;">
                    Masuk untuk mengelola pesanan
                </p>
            </div>

            <form method="POST" action="{{ route('user.login', ['slug' => $slug]) }}" class="space-y-4" id="login-form">
                @csrf
                <div>
                    <label for="email" class="block text-sm sm:text-base font-medium text-gray-300">Email atau
                        Username</label>
                    <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full px-4 py-2 bg-gray-900 text-gray-200 border border-gray-600 rounded-lg focus:ring-teal-400 focus:border-teal-400 transition-all duration-200 placeholder-gray-500 text-sm sm:text-base"
                        placeholder="Masukkan email atau username">
                    @error('email')
                        <p class="text-red-400 text-xs sm:text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="relative">
                    <label for="password" class="block text-sm sm:text-base font-medium text-gray-300">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-4 py-2 bg-gray-900 text-gray-200 border border-gray-600 rounded-lg focus:ring-teal-400 focus:border-teal-400 transition-all duration-200 placeholder-gray-500 text-sm sm:text-base"
                        placeholder="Masukkan password">
                    <button type="button" onclick="togglePassword('password')"
                        class="absolute right-3 top-8 text-gray-400 hover:text-teal-400">
                        <i id="password-icon" class="fas fa-eye"></i>
                    </button>
                    @error('password')
                        <p class="text-red-400 text-xs sm:text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember"
                        class="h-4 w-4 text-teal-500 focus:ring-teal-400 border-gray-600 rounded bg-gray-900">
                    <label for="remember" class="ml-2 block text-sm sm:text-base text-gray-300">Remember me</label>
                </div>

                <button type="submit" id="submit-btn"
                    class="w-full py-2 px-4 bg-teal-500 text-white font-semibold rounded-lg hover:bg-teal-600 transition-all duration-200 transform hover:scale-105 text-sm sm:text-base disabled:bg-teal-700 disabled:cursor-not-allowed">
                    Login
                </button>
            </form>

            <p class="text-center text-xs sm:text-sm text-gray-400 mt-4">
                Belum punya akun?
                <a href="{{ route('user.register', ['slug' => $slug]) }}"
                    class="text-teal-400 hover:text-teal-300 font-semibold transition-colors duration-200">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --coral-500: #f87171;
            --teal-400: #2dd4bf;
            --teal-500: #14b8a6;
            --teal-600: #0d9488;
        }

        @keyframes textReveal {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes subtlePulse {
            0% {
                opacity: 0.1;
            }

            50% {
                opacity: 0.15;
            }

            100% {
                opacity: 0.1;
            }
        }

        .animate-text-reveal {
            animation: textReveal 0.8s ease-out forwards;
        }

        .animate-subtle-pulse {
            animation: subtlePulse 4s ease-in-out infinite;
        }

        input:focus {
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.2);
        }

        @media (max-width: 640px) {
            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            button {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById(`${id}-icon`);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.getElementById('login-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerText = 'Logging in...';
        });
    </script>
@endpush
