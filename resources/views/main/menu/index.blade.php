@extends('layouts.app')

@section('title')
    Daftar Menu - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <!-- Header -->
    <header class="relative bg-gray-800 py-12 sm:py-16 overflow-hidden">
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
            <h1 class="text-3xl sm:text-4xl font-extrabold text-coral-500 mb-4 animate-text-reveal">Menu
                {{ $mitra->mitra_name }}</h1>
            <p class="text-gray-300 text-sm sm:text-base animate-text-reveal" style="animation-delay: 0.2s;">
                Jelajahi pilihan menu lezat kami!
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <section class="bg-gray-900 py-10 sm:py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <!-- Tab Menu Kategori -->
            <div class="flex flex-wrap gap-2 sm:gap-4 mb-6 border-b-2 border-gray-700">
                @foreach ($menus as $categoryName => $categoryMenus)
                    <button
                        class="category-tab px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-lg font-semibold text-gray-300 hover:text-coral-500 focus:outline-none transition-all duration-200"
                        data-tab="{{ $categoryName }}">
                        {{ $categoryName }}
                    </button>
                @endforeach
            </div>

            <!-- Konten Menu Berdasarkan Kategori -->
            @foreach ($menus as $categoryName => $categoryMenus)
                <div class="category-content hidden" id="tab-{{ $categoryName }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                        @foreach ($categoryMenus as $menu)
                            <div class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-5 rounded-2xl shadow-lg cursor-pointer hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 animate-scale-in"
                                data-menu-id="{{ $menu->id }}" data-menu-name="{{ $menu->name }}"
                                data-menu-description="{{ $menu->description }}" data-menu-stock="{{ $menu->stock }}"
                                data-menu-price="{{ $menu->formatted_price }}"
                                data-menu-image="{{ $menu->image ? asset('storage/menu/' . $menu->image) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                                data-add-url="{{ route('cart.add', ['slug' => $slug, 'id' => $menu->id]) }}"
                                onclick="openMenuDetails('{{ $menu->id }}')">
                                <img src="{{ $menu->image ? asset('storage/menu/' . $menu->image) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                                    alt="{{ $menu->name }}"
                                    class="w-full h-28 sm:h-32 object-cover rounded-lg mb-3 transform hover:scale-105 transition-all duration-300">
                                <h3 class="text-lg sm:text-xl font-semibold text-coral-500">{{ $menu->name }}</h3>
                                <p class="text-gray-300 text-sm sm:text-base line-clamp-2">{{ $menu->description }}</p>
                                <p class="text-teal-400 text-sm sm:text-base mt-1">Harga: {{ $menu->formatted_price }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
    <script>
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
        });

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
                    <p class="text-left text-gray-300"><strong>Deskripsi:</strong> ${menuDescription}</p>
                    <p class="text-left text-gray-300"><strong>Stock:</strong> ${menuStock}</p>
                    <p class="text-left text-teal-400"><strong>Harga:</strong> ${menuPrice}</p>
                    <form method="POST" action="${addToCartUrl}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit"
                            class="mt-2 bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600 transition-all duration-200 transform hover:scale-105">
                            + Tambah ke Keranjang
                        </button>
                    </form>
                `,
                imageUrl: menuImage,
                imageWidth: 200,
                imageHeight: 200,
                imageAlt: menuName,
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                padding: '1.5rem',
                background: '#1f2937',
                customClass: {
                    popup: 'max-w-2xl rounded-2xl',
                    title: 'text-coral-500 text-2xl font-bold',
                    htmlContainer: 'text-sm sm:text-base'
                }
            });
        }
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
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
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

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-text-reveal {
            animation: textReveal 0.8s ease-out forwards;
        }

        .animate-subtle-pulse {
            animation: subtlePulse 10s ease-in-out infinite;
        }

        /* Truncate text to two lines */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
