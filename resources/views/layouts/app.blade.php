<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EvoKasir - Solusi kasir modern untuk bisnis Anda. Cepat, mudah, dan handal.">
    <meta name="keywords" content="EvoKasir, kasir, manajemen bisnis, laporan penjualan, sistem keanggotaan, POS">
    <meta name="author" content="Evognito Team">
    <meta name="robots" content="index, follow">
    <title>@yield('title', 'Evokasir')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-300 font-inter antialiased flex flex-col min-h-screen">
    <!-- Header -->
    <nav class="bg-gray-800 text-white py-3 sm:py-4 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="{{ route('user.index', ['slug' => $slug]) }}"
                class="text-lg sm:text-xl lg:text-2xl font-semibold text-coral-500 hover:text-coral-400 transition-all duration-200 transform hover:scale-105 animate-text-reveal">Evokasir</a>
            <button id="menu-toggle" class="sm:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
            <div id="nav-menu" class="hidden sm:flex items-center space-x-3 sm:space-x-4 lg:space-x-6">
                <a href="{{ route('user.index', ['slug' => $slug]) }}"
                    class="text-gray-300 text-sm sm:text-base lg:text-lg hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">Home</a>
                <a href="{{ route('menu.index', ['slug' => $slug]) }}"
                    class="text-gray-300 text-sm sm:text-base lg:text-lg hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">Menu</a>
                <a href="{{ route('cart.index', ['slug' => $slug]) }}"
                    class="relative text-gray-300 hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">
                    <i class="fas fa-shopping-cart text-base sm:text-lg lg:text-xl"></i>
                    @php
                        $cart = session('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    @if ($cartCount > 0)
                        <span
                            class="absolute -top-1 -right-3 sm:-top-2 sm:-right-2 bg-coral-500 text-white text-xs font-bold px-1 sm:px-1.5 py-0.5 rounded-full animate-pulse">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                @auth
                    <a href="{{ route('user.profile', ['slug' => $slug]) }}"
                        class="text-gray-300 text-sm sm:text-base lg:text-lg hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">
                        Profil
                    </a>
                    <form method="POST" action="{{ route('user.logout', ['slug' => $slug]) }}">
                        @csrf
                        <button type="submit"
                            class="text-gray-300 text-sm sm:text-base lg:text-lg hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('user.login', ['slug' => $slug]) }}"
                        class="text-gray-300 text-sm sm:text-base lg:text-lg hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">
                        Login
                    </a>
                    <a href="{{ route('user.register', ['slug' => $slug]) }}"
                        class="text-gray-300 text-sm sm:text-base lg:text-lg hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">
                        Register
                    </a>
                @endauth
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden sm:hidden bg-gray-800 shadow-lg w-full absolute top-full left-0">
            <div class="flex flex-col items-center space-y-3 py-4">
                <a href="{{ route('user.index', ['slug' => $slug]) }}"
                    class="text-gray-300 text-base hover:text-teal-400 transition-all duration-200">Home</a>
                <a href="{{ route('menu.index', ['slug' => $slug]) }}"
                    class="text-gray-300 text-base hover:text-teal-400 transition-all duration-200">Menu</a>
                <a href="{{ route('cart.index', ['slug' => $slug]) }}"
                    class="relative text-gray-300 hover:text-teal-400 transition-all duration-200">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    @if ($cartCount > 0)
                        <span
                            class="absolute -top-1 -right-3 bg-coral-500 text-white text-xs font-bold px-1 py-0.5 rounded-full animate-pulse">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                @auth
                    <a href="{{ route('user.profile', ['slug' => $slug]) }}"
                        class="text-gray-300 text-base hover:text-teal-400 transition-all duration-200">
                        Profil
                    </a>
                    <form method="POST" action="{{ route('user.logout', ['slug' => $slug]) }}">
                        @csrf
                        <button type="submit"
                            class="text-gray-300 text-base hover:text-teal-400 transition-all duration-200">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('user.login', ['slug' => $slug]) }}"
                        class="text-gray-300 text-base hover:text-teal-400 transition-all duration-200">
                        Login
                    </a>
                    <a href="{{ route('user.register', ['slug' => $slug]) }}"
                        class="text-gray-300 text-base hover:text-teal-400 transition-all duration-200">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 sm:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-xs sm:text-sm lg:text-base">
                © {{ date('Y') }} Evokasir by <a href="https://evognito.my.id"
                    class="text-coral-500 hover:text-coral-400 transition-all duration-200">Evognito Team</a>. All
                rights reserved.
            </p>
        </div>
    </footer>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.all.min.js"></script>
    <script>
        // Toggle mobile menu
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    <script>
        // Function to show full image using SweetAlert2
        function showImage(imageUrl) {
            Swal.fire({
                imageUrl: imageUrl,
                imageAlt: 'Full Size Image',
                imageWidth: '60%',
                showCloseButton: true,
                showConfirmButton: false,
                width: '50%',
                heightAuto: true,
                padding: '20px',
            });
        }

        // Function to copy promo code to clipboard
        function copyPromoCode(code, promoId) {
            const textarea = document.createElement('textarea');
            textarea.value = code;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            // Show confirmation message
            const statusElement = document.getElementById('copyStatus' + promoId);
            statusElement.classList.remove('hidden');
            setTimeout(() => {
                statusElement.classList.add('hidden');
            }, 2000);
        }
    </script>
    @stack('scripts')

    <style>
        /* Custom Colors */
        :root {
            --coral-500: #f87171;
            --teal-400: #2dd4bf;
            --teal-500: #14b8a6;
            --teal-600: #0d9488;
        }

        /* Animations */
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

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .animate-text-reveal {
            animation: textReveal 0.8s ease-out forwards;
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

        .animate-pulse {
            animation: pulse 2s ease-in-out infinite;
        }
    </style>
</body>

</html>
