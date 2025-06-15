<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ $mitra->mitra_name }} - Login Admin EvoKasir - Akses panel admin untuk manajemen bisnis Anda.">
    <meta name="keywords" content="EvoKasir, login admin, manajemen bisnis, POS">
    <meta name="author" content="Evognito Team">
    <meta name="robots" content="noindex, nofollow">
    <title>Login Admin - {{ $mitra->mitra_name }} - EvoKasir</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body
    class="bg-gray-900 min-h-screen flex items-center justify-center py-10 sm:py-12 overflow-hidden font-inter antialiased">
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

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-md">
        <div
            class="bg-gray-800/90 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-lg bg-gradient-to-b from-gray-800 to-gray-900/80 animate-scale-in">
            <!-- Logo -->
            <div class="mb-6 text-center">
                <i class="fas fa-lock text-4xl sm:text-5xl text-coral-500"></i>
            </div>

            <!-- Title -->
            <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-coral-500 mb-6 sm:mb-8 animate-text-reveal">
                Login Admin</h2>

            <!-- Success or Error Messages -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-teal-500/20 text-teal-400 rounded-xl border border-teal-400/30 shadow-lg animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    class="mb-6 p-4 bg-red-500/20 text-red-400 rounded-xl border border-red-400/30 shadow-lg animate-fade-in">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login', ['slug' => $slug]) }}">
                @csrf

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-sm sm:text-base font-semibold text-gray-300">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('email') border-red-500 @enderror">
                    @error('email')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password"
                        class="block text-sm sm:text-base font-semibold text-gray-300">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('password') border-red-500 @enderror">
                    @error('password')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" id="remember"
                        class="text-coral-500 focus:ring-coral-500 h-4 w-4 sm:h-5 sm:w-5">
                    <label for="remember" class="text-sm sm:text-base text-gray-300 ml-2">Ingat Saya</label>
                </div>

                <!-- Submit Button -->
                <div class="mb-6">
                    <button type="submit"
                        class="w-full bg-teal-500 hover:bg-teal-600 text-white py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                        Login
                    </button>
                </div>

                <!-- Forgot Password Link -->
                {{-- @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}"
                            class="text-sm sm:text-base text-teal-400 hover:text-teal-300 transition-all duration-200">
                            Lupa Password?
                        </a>
                    </div>
                @endif --}}
            </form>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.all.min.js"></script>
    <script>
        // Show SweetAlert2 for session messages on load
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                background: '#1f2937',
                customClass: {
                    title: 'text-coral-500',
                    content: 'text-gray-300'
                }
            });
        @elseif (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                timer: 2000,
                showConfirmButton: false,
                background: '#1f2937',
                customClass: {
                    title: 'text-coral-500',
                    content: 'text-gray-300'
                }
            });
        @endif
    </script>

    <style>
        /* Custom Colors */
        :root {
            --coral-500: #f87171;
            --teal-400: #2dd4bf;
            --teal-500: #14b8a6;
            --teal-600: #0d9488;
        }

        /* Animations */
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes subtlePulse {

            0%,
            100% {
                opacity: 0.1;
            }

            50% {
                opacity: 0.15;
            }
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out forwards;
        }

        .animate-text-reveal {
            animation: textReveal 0.8s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-subtle-pulse {
            animation: subtlePulse 10s ease-in-out infinite;
        }
    </style>
</body>

</html>
