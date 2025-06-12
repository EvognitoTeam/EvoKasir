<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EvoKasir Admin Panel - Kelola bisnis Anda dengan mudah dan efisien.">
    <meta name="keywords" content="EvoKasir, admin panel, manajemen bisnis, POS">
    <meta name="author" content="Evognito Team">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Evognito')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-900 text-gray-300 font-inter antialiased flex flex-col">
    <!-- Background Geometric Overlay -->
    {{-- <div class="absolute inset-0 opacity-10 z-100">
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
    </div> --}}

    <!-- Navbar -->
    <nav
        class="bg-gray-800/90 backdrop-blur-md shadow-lg px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-3 sm:gap-4">
            <button id="menu-toggle" class="lg:hidden text-xl sm:text-2xl text-teal-400 focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('admin.index', ['slug' => $slug]) }}"
                class="text-lg sm:text-xl lg:text-2xl font-semibold text-coral-500 hover:text-coral-400 transition-all duration-200 animate-text-reveal">
                Admin Panel
            </a>
        </div>
        <div class="flex items-center space-x-3 sm:space-x-4">
            <span class="text-sm sm:text-base text-gray-300">
                <strong>{{ auth()->user()->name ?? 'Admin' }}</strong> (You)
            </span>
            <form action="{{ route('admin.logout', ['slug' => $slug]) }}" method="POST">
                @csrf
                <button type="submit"
                    class="text-sm sm:text-base text-red-400 hover:text-red-300 transition-all duration-200">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar + Content -->
    <div class="flex flex-1">
        <!-- Sidebar -->
        @php
            $role = Auth::user()->role;
        @endphp

        <aside id="sidebar"
            class="fixed top-0 left-0 z-40 w-64 sm:w-72 min-h-screen bg-gray-800/90 backdrop-blur-md border-r border-gray-700 shadow-lg pt-16 sm:pt-20 px-4 sm:px-6 transform -translate-x-full transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 lg:block lg:pt-4">
            <ul class="space-y-2 sm:space-y-3">
                <li>
                    <a href="{{ route('admin.index', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-tachometer-alt text-lg sm:text-xl"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.menu.index', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.menu.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-utensils text-lg sm:text-xl"></i>
                        Menus
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.orders.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-shopping-cart text-lg sm:text-xl"></i>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.report.index', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.report.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-chart-line text-lg sm:text-xl"></i>
                        Reports
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.table.index', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.table.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-chair text-lg sm:text-xl"></i>
                        Tables
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.categories.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-list text-lg sm:text-xl"></i>
                        Categories
                    </a>
                </li>
                @if ($role !== 'Cashier')
                    <li>
                        <a href="{{ route('admin.users.index', ['slug' => $slug]) }}"
                            class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.users.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                            <i class="fas fa-users text-lg sm:text-xl"></i>
                            Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.coupon.index', ['slug' => $slug]) }}"
                            class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.coupon.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                            <i class="fas fa-ticket-alt text-lg sm:text-xl"></i>
                            Coupons
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.cashout.index', ['slug' => $slug]) }}"
                            class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.cashout.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                            <i class="fas fa-money-bill-wave text-lg sm:text-xl"></i>
                            Cashout
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('admin.setting.index', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.setting.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-cog text-lg sm:text-xl"></i>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pos.index', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('admin.pos.index') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-cash-register text-lg sm:text-xl"></i>
                        Point of Sales
                    </a>
                </li>
                <li>
                    <a href="{{ route('download', ['slug' => $slug]) }}"
                        class="flex items-center gap-2 py-2 sm:py-3 px-3 rounded-lg hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('download') ? 'bg-gray-700 text-teal-400 font-semibold' : 'text-gray-300' }}">
                        <i class="fas fa-download text-lg sm:text-xl"></i>
                        Download POS
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Overlay for mobile menu -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"
            onclick="toggleSidebar()"></div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-900/85 pt-4 sm:pt-6 p-4 sm:p-6 pb-16 min-h-screen z-10">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.all.min.js"></script>

    <div id="toast-container" class="fixed bottom-4 right-4 sm:bottom-5 sm:right-5 space-y-2 z-50"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastContainer = document.getElementById('toast-container');

            const notifSound = @json($notifSound);
            let audioUrl = '';

            if (notifSound === 'none' || !notifSound) {
                audioUrl = null; // No sound
            } else if (notifSound.startsWith('sounds/custom/')) {
                audioUrl = "{{ asset('storage') }}/" + notifSound;
            } else {
                audioUrl = "{{ asset('storage') }}/" + notifSound;
            }

            setInterval(() => {
                fetch("{{ route('admin.orders.checkNew', ['slug' => $slug]) }}")
                    .then(res => res.json())
                    .then(data => {
                        if (data.hasNew) {
                            let notifications = JSON.parse(localStorage.getItem(
                                'orderNotifications')) || [];
                            const exists = notifications.some(n => n.order_code === data.order_code);
                            if (!exists) {
                                notifications.push({
                                    message: data.message,
                                    order_code: data.order_code,
                                });
                                localStorage.setItem('orderNotifications', JSON.stringify(
                                    notifications));
                                showAllNotifications(notifications);

                                // Play sound if set
                                if (audioUrl) {
                                    const audio = new Audio(audioUrl);
                                    audio.play().catch(error => console.error('Audio playback failed:',
                                        error));
                                }

                                // SweetAlert2 notification
                                Swal.fire({
                                    title: 'Pesanan Baru!',
                                    text: `${data.message} (Kode: ${data.order_code})`,
                                    icon: 'info',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    background: '#1f2937',
                                    customClass: {
                                        title: 'text-coral-500',
                                        content: 'text-gray-300'
                                    }
                                });
                            }
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            }, 2000);

            const storedNotifications = localStorage.getItem('orderNotifications');
            if (storedNotifications) {
                showAllNotifications(JSON.parse(storedNotifications));
            }

            function showAllNotifications(notifications) {
                toastContainer.innerHTML = '';
                notifications.forEach(notification => {
                    const toast = document.createElement('div');
                    toast.id = 'order-toast-' + notification.order_code;
                    toast.className =
                        'bg-teal-500 text-white px-4 sm:px-5 py-2 sm:py-3 rounded-lg shadow-lg flex justify-between items-center max-w-sm animate-fade-in';
                    toast.innerHTML = `
                        <span class="text-sm sm:text-base">${notification.message} (Kode: <strong>${notification.order_code}</strong>)</span>
                        <button data-code="${notification.order_code}" class="ml-2 sm:ml-4 text-xs sm:text-sm text-gray-200 hover:text-gray-100">Tutup</button>
                    `;
                    toastContainer.appendChild(toast);
                });

                document.querySelectorAll('#toast-container button').forEach(button => {
                    button.addEventListener('click', function() {
                        const code = this.getAttribute('data-code');
                        let notifications = JSON.parse(localStorage.getItem(
                            'orderNotifications')) || [];
                        notifications = notifications.filter(n => n.order_code !== code);
                        localStorage.setItem('orderNotifications', JSON.stringify(notifications));

                        const toastElement = document.getElementById('order-toast-' + code);
                        if (toastElement) toastElement.remove();
                    });
                });
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        document.getElementById('menu-toggle').addEventListener('click', toggleSidebar);
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
