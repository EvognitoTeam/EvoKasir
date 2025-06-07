<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EvoKasir - Solusi kasir modern untuk bisnis Anda. Cepat, mudah, dan handal.">
    <meta name="keywords" content="EvoKasir, kasir, manajemen bisnis, laporan penjualan, sistem keanggotaan, POS">
    <meta name="author" content="Evognito Team">
    {{-- <meta name="robots" content="index, follow"> --}}
    <title>@yield('title') - EvoKasir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @yield('styles')
</head>

<body class="bg-gray-50 text-gray-800 font-inter antialiased">

    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-lg shadow-lg sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="/"
                class="flex items-center space-x-2 sm:space-x-3 transform transition-all duration-300 hover:scale-105">
                <div
                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-indigo-600 to-teal-400 rounded-full flex items-center justify-center text-white font-bold text-lg sm:text-xl animate-pulse">
                    E</div>
                <span
                    class="text-xl sm:text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-teal-400">EvoKasir</span>
            </a>
            <!-- Hamburger Menu for Mobile -->
            <button id="menu-toggle" class="sm:hidden text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
            <!-- Navigation -->
            <nav id="nav-menu" class="hidden sm:flex sm:items-center sm:space-x-4 lg:space-x-6">
                <a href="/"
                    class="text-gray-700 font-semibold text-base lg:text-lg transition-all duration-200 hover:text-indigo-600 transform hover:scale-110 animate-nav">Beranda</a>
                {{-- <a href="/download"
                    class="text-gray-700 font-semibold text-base lg:text-lg transition-all duration-200 hover:text-indigo-600 transform hover:scale-110 animate-nav">Download</a> --}}
                {{-- <a href="/login"
                    class="text-gray-700 font-semibold text-base lg:text-lg transition-all duration-200 hover:text-indigo-600 transform hover:scale-110 animate-nav">Login</a> --}}
                <a href="/register"
                    class="bg-gradient-to-r from-indigo-600 to-teal-400 text-white font-semibold py-2 px-4 lg:px-6 rounded-full hover:from-indigo-700 hover:to-teal-500 transform hover:scale-105 transition-all duration-300 animate-nav">Daftar</a>
            </nav>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden sm:hidden bg-white shadow-lg">
            <nav class="flex flex-col items-center space-y-4 py-4">
                <a href="/"
                    class="text-gray-700 font-semibold text-base transition-all duration-200 hover:text-indigo-600">Beranda</a>
                {{-- <a href="/login"
                    class="text-gray-700 font-semibold text-base transition-all duration-200 hover:text-indigo-600">Login</a> --}}
                <a href="/register"
                    class="bg-gradient-to-r from-indigo-600 to-teal-400 text-white font-semibold py-2 px-4 rounded-full hover:from-indigo-700 hover:to-teal-500 transition-all duration-300">Daftar</a>
            </nav>
        </div>
    </header>

    <!-- Content -->
    <main class="relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-gray-900 to-gray-800 text-gray-300 py-8 sm:py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                <!-- Brand Info -->
                <div>
                    <div class="flex items-center space-x-2 sm:space-x-3 mb-4">
                        <div
                            class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-indigo-600 to-teal-400 rounded-full flex items-center justify-center text-white font-bold animate-pulse">
                            E</div>
                        <h3 class="text-lg sm:text-xl font-bold text-white">EvoKasir</h3>
                    </div>
                    <p class="text-gray-400 text-sm sm:text-base">Platform kasir modern untuk efisiensi bisnis Anda.</p>
                </div>
                <!-- Quick Links -->
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm sm:text-base">
                        <li><a href="/"
                                class="hover:text-indigo-400 transition-all duration-200 transform hover:translate-x-1">Beranda</a>
                        </li>
                        {{-- <li><a href="/login"
                                class="hover:text-indigo-400 transition-all duration-200 transform hover:translate-x-1">Login</a>
                        </li> --}}
                        <li><a href="/register"
                                class="hover:text-indigo-400 transition-all duration-200 transform hover:translate-x-1">Daftar</a>
                        </li>
                    </ul>
                </div>
                <!-- Support -->
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4">Dukungan</h3>
                    <ul class="space-y-2 text-sm sm:text-base">
                        {{-- <li><a href="#"
                                class="hover:text-indigo-400 transition-all duration-200 transform hover:translate-x-1">FAQ</a>
                        </li> --}}
                        <li><a href="mailto:chat.evognitoteam@gmail.com"
                                class="hover:text-indigo-400 transition-all duration-200 transform hover:translate-x-1">Kontak
                                Kami</a></li>
                        <li><a href="{{ route('privacy') }}"
                                class="hover:text-indigo-400 transition-all duration-200 transform hover:translate-x-1">Kebijakan
                                Privasi</a></li>
                    </ul>
                </div>
                <!-- Newsletter -->
                {{-- <div>
                    <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4">Berlangganan</h3>
                    <p class="text-gray-400 text-sm sm:text-base mb-3">Dapatkan pembaruan terbaru EvoKasir.</p>
                    <div class="flex">
                        <input type="email" placeholder="Email Anda"
                            class="w-full py-2 px-3 rounded-l-lg text-gray-800 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                        <button
                            class="bg-indigo-600 text-white py-2 px-3 sm:px-4 rounded-r-lg hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 text-sm sm:text-base">Berlangganan</button>
                    </div>
                </div> --}}
            </div>
            <div class="mt-6 sm:mt-8 border-t border-gray-700 pt-4 sm:pt-6 text-center">
                <div class="flex justify-center space-x-4 mb-4">
                    {{-- <a href="#"
                        class="text-gray-400 hover:text-indigo-400 transform hover:scale-125 transition-all duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.04c-5.5 0-10 4.5-10 10 0 4.4 3.6 8 8 8h2.5v-8h-2v-3h2v-2c0-2.2 1.8-4 4-4h2v3h-2c-1.1 0-2 .9-2 2v2h4l-.5 3h-3.5v8h2.5c4.4 0 8-3.6 8-8 0-5.5-4.5-10-10-10z" />
                        </svg>
                    </a> --}}
                    {{-- <a href="#"
                        class="text-gray-400 hover:text-indigo-400 transform hover:scale-125 transition-all duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                        </svg>
                    </a> --}}
                    {{-- <a href="#"
                        class="text-gray-400 hover:text-indigo-400 transform hover:scale-125 transition-all duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                        </svg>
                    </a> --}}
                </div>
                <p class="text-xs sm:text-sm">© {{ now()->format('Y') }} EvoKasir. Dibuat oleh Evognito Team.</p>
            </div>
        </div>
    </footer>

</body>

</html>

<style>
    /* Animations */
    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    @keyframes navSlide {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    .animate-nav {
        animation: navSlide 0.5s ease-out forwards;
    }

    .animate-nav:nth-child(1) {
        animation-delay: 0.1s;
    }

    .animate-nav:nth-child(2) {
        animation-delay: 0.2s;
    }

    .animate-nav:nth-child(3) {
        animation-delay: 0.3s;
    }
</style>

<script>
    // Toggle mobile menu
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>
