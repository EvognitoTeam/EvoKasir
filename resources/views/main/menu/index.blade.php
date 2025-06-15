@extends('layouts.app')

@section('title')
    Daftar Menu - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <!-- Dependensi SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.28/sweetalert2.min.js"></script>

    <!-- Header -->
    <header class="relative bg-gray-800 py-8 sm:py-12 overflow-hidden">
        <div class="absolute inset-0 opacity-60">
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

            {{-- Table Display --}}
            @if (isset($table) && $table)
                <div
                    class="mb-6 bg-gray-800/90 backdrop-blur-md rounded-lg px-3 py-2 inline-flex items-center space-x-2 animate-scale-in max-w-full">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18m-7 6h7" />
                    </svg>
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs sm:text-sm font-semibold bg-teal-500 text-white">
                        Meja: {{ $table->table_name }}
                    </span>
                </div>
            @endif

            @if ($menus->isNotEmpty())
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
                                <div class="bg-gray-800/90 backdrop-blur-md p-3 sm:p-4 rounded-2xl shadow-lg {{ $menu->stock > 0 ? 'cursor-pointer hover:shadow-xl transform hover:-translate-y-1' : 'cursor-not-allowed' }} transition-all duration-300 animate-scale-in"
                                    data-menu-id="{{ $menu->id }}" data-menu-name="{{ $menu->name }}"
                                    data-menu-description="{{ $menu->description }}" data-menu-stock="{{ $menu->stock }}"
                                    data-menu-price="{{ $menu->formatted_price }}"
                                    data-menu-image="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                                    data-add-url="{{ route('cart.add', ['slug' => $slug, 'id' => $menu->id]) }}"
                                    data-reviews="{{ base64_encode(
                                        json_encode(
                                            $menu->reviews->map(function ($review) {
                                                    return [
                                                        'user_name' => $review->user->name ?? 'Anonim',
                                                        'rating' => (float) ($review->rating ?? 0),
                                                        'comment' => $review->comment ?? 'Tidak ada komentar',
                                                        'created_at' => $review->created_at
                                                            ? \Carbon\Carbon::parse($review->created_at)->translatedFormat('d M Y, H:i')
                                                            : 'Tanggal tidak tersedia',
                                                    ];
                                                })->toArray(),
                                            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                                        ),
                                    ) }}">
                                    <div class="relative">
                                        <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                                            alt="{{ $menu->name }}"
                                            class="w-full h-20 sm:h-28 object-cover rounded-lg mb-2 sm:mb-3 {{ $menu->stock == 0 ? 'filter grayscale' : '' }} transform {{ $menu->stock > 0 ? 'hover:scale-105' : '' }} transition-all duration-300">
                                        @if ($menu->stock == 0)
                                            <span
                                                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-coral-500 text-xs sm:text-sm font-semibold bg-coral-500/20 px-2 py-1 rounded-full">
                                                Stok Habis
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="text-sm sm:text-lg font-semibold text-coral-500 line-clamp-1">
                                        {{ $menu->name }}</h3>
                                    <p class="text-gray-300 text-xs sm:text-sm line-clamp-2 menu-description">
                                        {!! Illuminate\Support\Str::limit(strip_tags($menu->description), 20) !!}</p>
                                    <p class="text-teal-400 text-xs sm:text-sm mt-1 menu-price">Harga:
                                        {{ $menu->formatted_price }}</p>
                                    <!-- Tampilan Rating -->
                                    <div class="mt-1 flex items-center space-x-1">
                                        <span class="star-rating">
                                            @php
                                                $averageRating = $menu->average_rating ?? 0;
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($averageRating >= $i) {
                                                        echo '<span class="star rated">★</span>';
                                                    } elseif ($averageRating >= $i - 0.5 && $averageRating < $i) {
                                                        echo '<span class="star half-rated">★</span>';
                                                    } else {
                                                        echo '<span class="star">★</span>';
                                                    }
                                                }
                                            @endphp
                                        </span>
                                        <span class="text-gray-300 text-xs sm:text-sm">
                                            ({{ number_format($averageRating, 1) }} - {{ $menu->review_count ?? 0 }}
                                            ulasan)
                                        </span>
                                    </div>
                                    @if ($menu->stock > 0 && $menu->stock < 10)
                                        <p
                                            class="text-teal-400 text-xs sm:text-sm mt-1 bg-teal-500/20 px-2 py-1 rounded-full inline-block animate-fade-in">
                                            Sisa: {{ $menu->stock }}
                                        </p>
                                    @endif
                                    <button
                                        class="add-to-cart-btn w-full mt-2 text-white text-xs sm:text-sm px-2 sm:px-3 py-1 sm:py-2 rounded-lg transition-all duration-200 transform {{ $menu->stock > 0 ? 'bg-teal-500 hover:bg-teal-600 hover:scale-105' : 'bg-gray-600 cursor-not-allowed' }}"
                                        @if ($menu->stock > 0) onclick="openMenuDetails('{{ $menu->id }}', event)" @else disabled @endif>
                                        {{ $menu->stock > 0 ? '+ Tambah' : 'Stok Habis' }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Kontainer Ulasan di Bawah Daftar Menu -->
                @if ($menus->isNotEmpty())
                    <div
                        class="reviews-container mt-8 p-4 sm:p-6 bg-gray-900/80 rounded-lg max-h-96 overflow-y-auto animate-fade-in">
                        <h3 class="text-lg sm:text-xl font-semibold text-coral-500 mb-4">Semua Ulasan</h3>
                        @foreach ($menus as $categoryName => $categoryMenus)
                            @foreach ($categoryMenus as $menu)
                                <div
                                    class="menu-reviews mb-6 bg-gray-800/90 rounded-lg p-4 sm:p-5 shadow-md border border-gray-700/50">
                                    <h4 class="text-md sm:text-lg font-semibold text-teal-400 mb-3">{{ $menu->name }}
                                    </h4>
                                    @if ($menu->reviews->isEmpty())
                                        <div class="review-empty bg-gray-900/50 p-3 rounded-md text-gray-400 text-sm">
                                            Belum ada ulasan untuk menu ini.
                                        </div>
                                    @else
                                        <div class="space-y-3">
                                            @foreach ($menu->reviews as $review)
                                                <div
                                                    class="review-item bg-gray-900/70 p-3 rounded-md border border-gray-600/50 animate-fade-in">
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                        <div class="flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-coral-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            <span class="text-white text-sm font-semibold">
                                                                {{ $review->user->name ?? 'Anonim' }}
                                                            </span>
                                                            <span class="star-rating static flex items-center">
                                                                @php
                                                                    $rating = $review->rating ?? 0;
                                                                    for ($i = 1; $i <= 5; $i++) {
                                                                        if ($rating >= $i) {
                                                                            echo '<span class="star rated">★</span>';
                                                                        } elseif ($rating >= $i - 0.5 && $rating < $i) {
                                                                            echo '<span class="star half-rated">★</span>';
                                                                        } else {
                                                                            echo '<span class="star">★</span>';
                                                                        }
                                                                    }
                                                                @endphp
                                                            </span>
                                                        </div>
                                                        <span class="text-gray-500 text-xs sm:text-right">
                                                            {{ $review->created_at ? \Carbon\Carbon::parse($review->created_at)->translatedFormat('d M Y, H:i') : 'Tanggal tidak tersedia' }}
                                                        </span>
                                                    </div>
                                                    <p class="text-gray-300 text-sm mt-2 pl-6">
                                                        {{ $review->comment ?? 'Tidak ada komentar' }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @endif
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
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
            </path>
        </svg>
        <span
            class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
            id="cart-count">0</span>
    </a>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
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

            // Card click handler
            document.querySelectorAll('[data-menu-id]').forEach(card => {
                card.addEventListener('click', (e) => {
                    if (e.target.closest('.add-to-cart-btn')) return; // Ignore button clicks
                    const menuId = card.getAttribute('data-menu-id');
                    openMenuDetails(menuId);
                });
            });
        });

        // Open Menu Details Modal with Notes Input and Reviews
        function openMenuDetails(menuId, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const menuElement = document.querySelector(`[data-menu-id='${menuId}']`);
            const menuName = menuElement.getAttribute('data-menu-name');
            const menuDescription = menuElement.getAttribute('data-menu-description');
            const menuStock = parseInt(menuElement.getAttribute('data-menu-stock'));
            const menuPrice = menuElement.getAttribute('data-menu-price');
            const menuImage = menuElement.getAttribute('data-menu-image');
            const addToCartUrl = menuElement.getAttribute('data-add-url');
            const reviewsRaw = menuElement.getAttribute('data-reviews') || '';

            // Debugging: Log raw data and inspect characters
            // console.log('Raw data-reviews:', reviewsRaw);
            // console.log('Length:', reviewsRaw.length);
            // console.log('First 10 chars:', reviewsRaw.substring(0, 10));
            // console.log('Char codes:', reviewsRaw.split('').map(c => c.charCodeAt(0)));

            let reviewsData;
            try {
                // Decode base64 and parse JSON
                const decoded = atob(reviewsRaw);
                console.log('Decoded base64:', decoded);
                reviewsData = JSON.parse(decoded);
            } catch (e) {
                console.error('JSON parse error:', e.message);
                console.error('Invalid data:', reviewsRaw);
                reviewsData = [];
            }

            const isOutOfStock = menuStock === 0;
            const imageClass = isOutOfStock ? 'filter grayscale' : '';
            const stockText = isOutOfStock ? 'Stok Habis' : `Stock: ${menuStock}`;
            const actionHtml = isOutOfStock ?
                '' :
                `
                    <div class="mt-4">
                        <label for="menu-notes-${menuId}" class="text-sm font-semibold text-gray-300 block">Catatan (opsional):</label>
                        <textarea id="menu-notes-${menuId}" placeholder="Misalnya: tanpa gula, tambah saus" class="w-full border border-gray-700 rounded-md px-3 py-2 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 resize-none text-sm transition-all duration-200 hover:border-teal-500" rows="3" maxlength="255"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 255 karakter</p>
                    </div>
                    <div class="mt-4 flex space-x-2">
                        <input type="number" id="menu-quantity-${menuId}" value="1" min="1" max="${menuStock}" class="w-16 border border-gray-700 rounded-md px-2 py-1 text-center text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500">
                        <button
                            class="add-to-cart-btn w-full bg-teal-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-teal-600 transition-all duration-200 transform"
                            onclick="addToCart('${menuId}')">
                            + Tambah ke Keranjang
                        </button>
                    </div>
                `;

            // Generate reviews HTML for modal
            let reviewsHtml = '<h3 class="text-md font-semibold text-[#f87171] mt-4 mb-2">Ulasan</h3>';
            if (reviewsData.length === 0) {
                reviewsHtml += '<p class="text-gray-400 text-sm">Belum ada ulasan untuk menu ini.</p>';
            } else {
                reviewsData.forEach(review => {
                    const starsHtml = Array(5).fill(0).map((_, i) => {
                        const rating = parseFloat(review.rating);
                        if (rating >= i + 1) {
                            return '<span class="star rated">★</span>';
                        } else if (rating >= i + 0.5 && rating < i + 1) {
                            return '<span class="star half-rated">★</span>';
                        } else {
                            return '<span class="star">★</span>';
                        }
                    }).join('');
                    // Escape HTML in comment to prevent XSS
                    const escapedComment = review.comment
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#039;');
                    reviewsHtml += `
                        <div class="review-item py-2 border-b border-gray-700 bg-gray-900 px-3 rounded-md last:border-b-0">
                            <div class="flex items-center space-x-1">
                                <span class="text-white text-sm font-semibold">${review.user_name}</span>
                                <span class="star-rating static">${starsHtml}</span>
                            </div>
                            <p class="text-gray-300 text-sm mt-1">${escapedComment}</p>
                            <p class="text-gray-500 text-xs mt-1">${review.created_at}</p>
                        </div>
                    `;
                });
            }

            Swal.fire({
                title: `<p class="text-center text-white">${menuName}</p>`,
                html: `
                    <img src="${menuImage}" alt="${menuName}" class="w-full max-w-[200px] h-auto rounded-lg mx-auto mb-4 ${imageClass}">
                    <p class="text-left text-white text-sm"><strong>Deskripsi:</strong> <div class="text-left text-white">${menuDescription}</div></p>
                    <p class="text-left ${isOutOfStock ? 'text-coral-500' : 'text-gray-300'} text-sm"><strong>Stock:</strong> ${stockText}</p>
                    <p class="text-left text-teal-400 text-sm"><strong>Harga:</strong> ${menuPrice}</p>
                    ${actionHtml}
                    ${reviewsHtml}
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
        function addToCart(menuId) {
            const menuElement = document.querySelector(`[data-menu-id='${menuId}']`);
            const addToCartUrl = menuElement.getAttribute('data-add-url');
            const menuStock = parseInt(menuElement.getAttribute('data-menu-stock'));
            const notes = document.getElementById(`menu-notes-${menuId}`)?.value.trim() || '';
            const quantity = parseInt(document.getElementById(`menu-quantity-${menuId}`)?.value) || 1;
            const button = document.querySelector(`.add-to-cart-btn[onclick="addToCart('${menuId}')"]`);
            const originalText = button?.innerText || '+ Tambah ke Keranjang';

            if (menuStock === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Stok Habis!',
                    text: 'Menu ini tidak tersedia untuk ditambahkan ke keranjang.',
                    timer: 2000,
                    showConfirmButton: false,
                    background: '#1f2937',
                    customClass: {
                        title: 'text-coral-500',
                        content: 'text-gray-300'
                    }
                });
                return;
            }

            if (isNaN(quantity) || quantity < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Jumlah harus minimal 1.',
                    timer: 2000,
                    showConfirmButton: false,
                    background: '#1f2937',
                    customClass: {
                        title: 'text-coral-500',
                        content: 'text-gray-300'
                    }
                });
                return;
            }

            if (quantity > menuStock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: `Jumlah melebihi stok tersedia (${menuStock}).`,
                    timer: 2000,
                    showConfirmButton: false,
                    background: '#1f2937',
                    customClass: {
                        title: 'text-coral-500',
                        content: 'text-gray-300'
                    }
                });
                return;
            }

            if (notes.length > 255) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Catatan tidak boleh melebihi 255 karakter.',
                    timer: 2000,
                    showConfirmButton: false,
                    background: '#1f2937',
                    customClass: {
                        title: 'text-coral-500',
                        content: 'text-gray-300'
                    }
                });
                return;
            }

            // Disable button and show loading state
            if (button) {
                button.disabled = true;
                button.innerText = 'Menambahkan...';
            }

            fetch(addToCartUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: quantity,
                        notes: notes
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
                        Swal.close();
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
                    console.error('Error:', error);
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
                    if (button) {
                        button.disabled = false;
                        button.innerText = originalText;
                    }
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
@endpush

@push('styles')
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
                opacity: 0.4;
            }

            50% {
                opacity: 0.6;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
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

        /* Styling untuk textarea notes */
        textarea {
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        textarea:focus {
            border-color: var(--teal-400);
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.2);
        }

        textarea::placeholder {
            color: #6b7280;
            font-style: italic;
        }

        /* Gaya untuk star rating */
        .star-rating {
            display: inline-flex;
            gap: 2px;
            cursor: default;
        }

        .star-rating.static {
            cursor: default;
        }

        .star {
            font-size: 14px;
            color: #4b5563;
            position: relative;
            width: 14px;
            text-align: center;
            user-select: none;
        }

        .star.rated {
            color: #facc15;
        }

        .star.half-rated::before {
            content: '★';
            position: absolute;
            left: 0;
            width: 50%;
            overflow: hidden;
            color: #facc15;
        }

        /* Gaya untuk reviews container */
        .reviews-container {
            transition: all 0.3s ease;
        }

        .review-item {
            transition: opacity 0.3s ease;
        }

        .review-empty {
            transition: opacity 0.3s ease;
        }

        /* Smaller text size */
        .text-smaller {
            font-size: 0.75rem;
        }

        .text-tiny {
            font-size: 0.65rem;
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

            .star {
                font-size: 12px;
                width: 12px;
            }

            .text-smaller {
                font-size: 0.65rem;
            }

            .text-tiny {
                font-size: 0.55rem;
            }

            .reviews-container {
                padding: 0.75rem;
            }

            .menu-reviews {
                padding: 0.75rem;
            }

            .review-item {
                padding: 0.5rem;
            }
        }
    </style>
@endpush
