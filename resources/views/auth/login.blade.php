@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 via-blue-500 to-teal-400 overflow-hidden">
        <!-- Background Decorative Elements -->
        <div class="absolute inset-0 opacity-20">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
                <defs>
                    <pattern id="bg-pattern" patternUnits="userSpaceOnUse" width="20" height="20">
                        <circle cx="10" cy="10" r="2" fill="white" />
                        <line x1="0" y1="20" x2="20" y2="0" stroke="white" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#bg-pattern)" class="animate-subtle-move" />
            </svg>
        </div>
        <div class="relative w-full max-w-md mx-4 bg-white/95 backdrop-blur-lg p-8 rounded-2xl shadow-2xl transform transition-all duration-500 animate-slide-in hover:shadow-[0_0_20px_rgba(59,130,246,0.5)]">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Masuk ke EvoKasir</h2>
            <form action="/login" method="POST" class="space-y-5" id="login-form">
                @csrf
                <div class="relative">
                    <label for="email" class="block text-sm font-semibold text-gray-700 transition-all duration-200">Email</label>
                    <input type="email" name="email" id="email" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50/50 transition-all duration-200 transform hover:scale-[1.01]" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative">
                    <label for="password" class="block text-sm font-semibold text-gray-700 transition-all duration-200">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50/50 transition-all duration-200 transform hover:scale-[1.01]" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-teal-400 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-teal-500 transform hover:scale-105 transition-all duration-300 flex items-center justify-center relative group">
                    <span class="group-hover:opacity-0 transition-opacity duration-200">Masuk</span>
                    <span class="absolute opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <svg class="w-5 h-5 animate-spin hidden" id="loading-spinner" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>
            <div class="text-center text-sm text-gray-600 mt-5 space-y-2">
                <p>
                    Belum punya akun? <a href="/register" class="text-blue-600 font-semibold hover:underline transition-colors duration-200">Daftar sekarang</a>.
                </p>
                <p>
                    <a href="/password/reset" class="text-blue-600 font-semibold hover:underline transition-colors duration-200">Lupa kata sandi?</a>
                </p>
            </div>
        </div>
        <!-- Decorative Floating Elements -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-teal-300 rounded-full opacity-20 animate-float"></div>
        <div class="absolute bottom-10 right-10 w-48 h-48 bg-indigo-300 rounded-full opacity-20 animate-float-slow"></div>
    </section>

@endsection

<style>
    /* Animations */
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    @keyframes floatSlow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-30px); }
    }
    @keyframes subtleMove {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(10px, 10px); }
    }
    .animate-slide-in {
        animation: slideIn 0.8s ease-out forwards;
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    .animate-float-slow {
        animation: floatSlow 8s ease-in-out infinite;
    }
    .animate-subtle-move {
        animation: subtleMove 20s ease-in-out infinite;
    }
</style>

<script>
    // Add loading state to submit button
    document.getElementById('login-form').addEventListener('submit', function () {
        const button = this.querySelector('button[type="submit"]');
        const spinner = document.getElementById('loading-spinner');
        button.disabled = true;
        spinner.classList.remove('hidden');
    });

    // Input animation on focus
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function () {
            this.parentElement.querySelector('label').classList.add('text-blue-500', 'scale-95');
        });
        input.addEventListener('blur', function () {
            this.parentElement.querySelector('label').classList.remove('text-blue-500', 'scale-95');
        });
    });
</script>