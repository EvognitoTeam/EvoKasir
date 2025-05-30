@extends('layouts.app')

@section('title')
    Daftar Menu - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <!-- Header -->
    <header class="relative bg-gray-800 py-8 sm:py-12 overflow-hidden">
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
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl text-center">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-3 animate-text-reveal">Menu
                {{ $mitra->mitra_name }}</h1>
            <p class="text-gray-300 text-sm sm:text-base animate-text-reveal" style="animation-delay: 0.2s;">
                Jelajahi pilihan menu lezat kami!
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <section class="bg-gray-900 py-8 sm:py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            {{-- Success Message --}}
            @if (session('success'))
                <div id="success-message"
                    class="mb-6 p-4 bg-teal-500/20 text-teal-400 rounded-lg border border-teal-400/50 shadow animate-fade-in">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(() => {
                        const successMessage = document.getElementById('success-message');
                        if (successMessage) successMessage.remove();
                    }, 5000);
                </script>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div id="error-message"
                    class="mb-6 p-4 bg-red-500/20 text-red-400 rounded-lg border border-red-400/50 shadow animate-fade-in">
                    <ul class="list-none pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>
                    setTimeout(() => {
                        const errorMessage = document.getElementById('error-message');
                        if (errorMessage) errorMessage.remove();
                    }, 5000);
                </script>
            @endif

            @if (count($menus) > 0)
                <!-- Tab Menu Kategori -->
                <div class="flex flex-wrap gap-2 sm:gap-4 mb-6 border-b-2 border-gray-700 overflow-x-auto">
                    @foreach ($menus as $categoryName => $categoryMenus)
                        <button
                            class="category-tab px-3 py-2 text-sm sm:text-base font-semibold text-gray-300 hover:text-coral-500 focus:outline-none transition-all duration-200 whitespace-nowrap"
                            data-tab="{{ $categoryName }}">
                            {{ $categoryName }}
                        </button>
                    @endforeach
                </div>

                <!-- Konten Menu Berdasarkan Kategori -->
                @foreach ($menus as $categoryName => $categoryMenus)
                    <div class="category-content hidden" id="tab-{{ $categoryName }}">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                            @foreach ($categoryMenus as $menu)
                                <div class="bg-gray-800/90 backdrop-blur-md p-3 sm:p-4 rounded-2xl shadow-lg cursor-pointer hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-scale-in"
                                    data-menu-id="{{ $menu->id }}" data-menu-name="{{ $menu->name }}"
                                    data-menu-description="{{ $menu->description }}" data-menu-stock="{{ $menu->stock }}"
                                    data-menu-price="{{ $menu->formatted_price }}"
                                    data-menu-image="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                                    data-add-url="{{ route('cart.add', ['slug' => $slug, 'id' => $menu->id]) }}"
                                    onclick="openMenuDetails('{{ $menu->id }}')">
                                    <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                                        alt="{{ $menu->name }}"
                                        class="w-full h-20 sm:h-28 object-cover rounded-lg mb-2 sm:mb-3 transform hover:scale-105 transition-all duration-300">
                                    <h3 class="text-sm sm:text-lg font-semibold text-coral-500 line-clamp-1">
                                        {{ $menu->name }}</h3>
                                    <p class="text-gray-300 text-xs sm:text-sm line-clamp-2 menu-description">
                                        {!! Illuminate\Support\Str::limit(strip_tags($menu->description), 20) !!}</p>
                                    <p class="text-teal-400 text-xs sm:text-sm mt-1 menu-price">Harga:
                                        {{ $menu->formatted_price }}</p>
                                    <button
                                        class="add-to-cart-btn w-full mt-2 bg-teal-500 text-white text-xs sm:text-sm px-2 sm:px-3 py-1 sm:py-2 rounded-lg hover:bg-teal-600 transition-all duration-200 transform hover:scale-105"
                                        onclick="addToCart('{{ $menu->id }}', event)">
                                        + Tambah
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Pesan Ketika Tidak Ada Menu -->
                <div class="bg-gray-800/90 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-lg text-center">
                    <svg class="w-16 h-16 mx-auto text-coral-500 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg sm:text-xl font-semibold text-coral-500 mb-2">Tidak Ada Menu Tersedia</h3>
                    <p class="text-gray-300 text-sm sm:text-base">Maaf, saat ini tidak ada menu yang tersedia untuk
                        {{ $mitra->mitra_name }}. Silakan cek kembali nanti!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Floating Cart Button -->
    <a href="{{ route('cart.index', ['slug' => $slug]) }}"
        class="fixed bottom-4 right-4 bg-coral-500 text-white p-3 rounded-full shadow-lg hover:bg-coral-600 transition-all duration-200 z-50 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span
            class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
            id="cart-count">0</span>
    </a>
@endsection

@push('scripts')
    <script>
        // Tab Switching
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.category-tab');
            const contents = document.querySelectorAll('.category-content');

            if (tabs.length > 0) {
                tabs[0].classList.add('text-coral-500', 'border-coral-500', 'border-b-2');
                contents[0].classList.remove('hidden');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('text-coral-500', 'border-coral-500',
                        'border-b-2'));
                    contents.forEach(c => c.classList.add('hidden'));

                    tab.classList.add('text-coral-500', 'border-coral-500', 'border-b-2');
                    const category = tab.getAttribute('data-tab');
                    const activeContent = document.getElementById('tab-' + category);
                    activeContent.classList.remove('hidden');
                });
            });

            // Initialize cart count
            updateCartCount();
        });

        // Open Menu Details Modal
        function openMenuDetails(menuId) {
            const menuElement = document.querySelector(`[data-menu-id='${menuId}']`);
            const menuName = menuElement.getAttribute('data-menu-name');
            const menuDescription = menuElement.getAttribute('data-menu-description');
            const menuStock = menuElement.getAttribute('data-menu-stock');
            const menuPrice = menuElement.getAttribute('data-menu-price');
            const menuImage = menuElement.getAttribute('data-menu-image');
            const addToCartUrl = menuElement.getAttribute('data-add-url');

            Swal.fire({
                title: menuName,
                html: `
                    <img src="${menuImage}" alt="${menuName}" class="w-full max-w-[200px] h-auto rounded-lg mx-1rem mx-auto mb-4">
                    <p class="text-left text-white text-sm"><strong>Deskripsi:</strong> <div class="text-left text-white">${menuDescription}</div></p>
                    <p class="text-left text-gray-300 text-sm"><strong>Stock:</strong> ${menuStock}</p>
                    <p class="text-left text-teal-400 text-sm"><strong>Harga:</strong> ${menuPrice}</p>
                    <button
                        class="add-to-cart-btn w-full mt-4 bg-teal-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-teal-600 transition-all duration-200 transform hover:scale-105"
                        onclick="addToCart('${menuId}', event)">
                        + Tambah ke Keranjang
                    </button>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                padding: '1rem',
                background: '#1f2937',
                customClass: {
                    popup: 'max-w-[90%] sm:max-w-lg rounded-2xl',
                    title: 'text-coral-500 text-xl sm:text-2xl font-bold',
                    htmlContainer: 'text-sm sm:text-base'
                }
            });
        }

        // Add to Cart with AJAX
        function addToCart(menuId, event) {
            event.preventDefault();
            event.stopPropagation(); // Prevent modal click from bubbling
            const menuElement = document.querySelector(`[data-menu-id='${menuId}']`);
            const addToCartUrl = menuElement.getAttribute('data-add-url');
            const button = event.target;
            const originalText = button.innerText;

            // Disable button and show loading state
            button.disabled = true;
            button.innerText = 'Menambahkan...';

            fetch(addToCartUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Menu ditambahkan ke keranjang.',
                            timer: 1500,
                            showConfirmButton: false,
                            background: '#1f2937',
                            customClass: {
                                title: 'text-coral-500',
                                content: 'text-gray-300'
                            }
                        });
                        updateCartCount();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal menambahkan ke keranjang.',
                            timer: 2000,
                            showConfirmButton: false,
                            background: '#1f2937',
                            customClass: {
                                title: 'text-coral-500',
                                content: 'text-gray-300'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan. Coba lagi nanti.',
                        timer: 2000,
                        showConfirmButton: false,
                        background: '#1f2937',
                        customClass: {
                            title: 'text-coral-500',
                            content: 'text-gray-300'
                        }
                    });
                })
                .finally(() => {
                    button.disabled = false;
                    button.innerText = originalText;
                });
        }

        // Update Cart Count
        function updateCartCount() {
            fetch('{{ route('cart.count', ['slug' => $slug]) }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').innerText = data.count || 0;
                })
                .catch(error => console.error('Error fetching cart count:', error));
        }
    </script>

    <style>
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
                transform: scale(0.8);
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
            animation: scaleIn 0.8s ease-out forwards;
        }

        .animate-text-reveal {
            animation: textReveal 0.8s ease-out forwards;
        }

        .animate-subtle-pulse {
            animation: subtlePulse 10s ease-in-out infinite;
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Mobile-Specific Styles */
        @media (max-width: 640px) {
            .category-tab {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }

            .grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.75rem;
            }

            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            header {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .add-to-cart-btn {
                font-size: 0.7rem;
                padding: 0.5rem 0.75rem;
            }

            .menu-card {
                padding: 0.75rem;
            }

            .menu-image {
                height: 4.5rem;
            }

            .menu-title {
                font-size: 0.875rem;
            }

            .menu-description {
                font-size: 0.65rem;
                line-height: 1.2;
            }

            .menu-price {
                font-size: 0.65rem;
            }
        }
    </style>
@endpush
