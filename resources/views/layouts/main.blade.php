<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EvoKasir - Platform POS Cerdas untuk Mendorong Pertumbuhan Restoran Anda.">
    <meta name="keywords" content="EvoKasir, POS, kasir restoran, software kasir, manajemen restoran, point of sale">
    <meta name="author" content="Evognito Team">
    <title>@yield('title', 'Solusi Kasir Modern') - EvoKasir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="/storage/logo/6814f4b762b42.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GE812YVVQS"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-GE812YVVQS');
    </script>
</head>

<body class="bg-gray-100 text-gray-800 font-sans antialiased">

    <header id="main-header"
        class="bg-white/90 backdrop-blur-lg sticky top-0 z-50 transition-all duration-300 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="flex items-center space-x-3 group">
                    <img src="/storage/logo/6814f4b762b42.png" alt="EvoKasir Logo"
                        class="w-9 h-9 sm:w-10 sm:h-10 transform group-hover:rotate-12 transition-transform duration-300">
                    <span class="text-xl sm:text-2xl font-bold text-gray-900">EvoKasir</span>
                </a>

                <button id="menu-toggle" class="sm:hidden text-gray-700 focus:outline-none z-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>

                <nav class="hidden sm:flex items-center space-x-8">
                    <a href="/"
                        class="text-gray-600 font-medium hover:text-indigo-600 transition-colors">Beranda</a>
                    <a href="#features"
                        class="text-gray-600 font-medium hover:text-indigo-600 transition-colors">Fitur</a>
                    <a href="/register"
                        class="bg-indigo-600 text-white font-bold py-2 px-6 rounded-full hover:bg-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-indigo-500/50">
                        Mulai Gratis
                    </a>
                </nav>
            </div>
        </div>
        <div id="mobile-menu" class="hidden sm:hidden absolute top-0 left-0 w-full h-screen bg-white z-10">
            <nav class="flex flex-col items-center justify-center h-full space-y-8 text-xl">
                <a href="/" class="text-gray-800 font-semibold">Beranda</a>
                <a href="#features" class="text-gray-800 font-semibold">Fitur</a>
                <a href="/register" class="bg-indigo-600 text-white font-bold py-3 px-8 rounded-full">Mulai Gratis</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-400">
        <div class="border-t-4 border-indigo-600"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mt-2 border-t border-gray-800 pt-3 text-center text-sm">
                <p>© {{ now()->format('Y') }} EvoKasir. Dibuat dengan ❤️ oleh Evognito Team.</p>
            </div>
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
