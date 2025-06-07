@extends('layouts.app')

@section('title')
    {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <!-- Main Content -->
    <section class="bg-gray-900 py-10 sm:py-12 overflow-hidden">
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
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <!-- Profil Cafe/Toko -->
            <div
                class="bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-2xl p-6 sm:p-8 mb-6 sm:mb-8 text-center transform transition-all duration-500 animate-scale-in hover:shadow-[0_0_20px_rgba(248,113,113,0.5)]">
                <img src="{{ $mitra->banner ? asset('storage/images/banner/' . $mitra->banner) : 'https://dummyimage.com/1920x1080/cccccc/000000.png&text=Cafe+Banner+1920+x+1080' }}"
                    alt="Banner" class="w-full h-40 sm:h-48 object-cover rounded-lg mb-4 animate-fade-in">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-2 animate-text-reveal">
                    {{ $mitra->mitra_name }}</h1>
                <p class="text-gray-300 text-sm sm:text-base mt-2 animate-text-reveal" style="animation-delay: 0.2s;">
                    {{ $mitra->mitra_welcome ?? 'Selamat datang di tempat kami!' }}
                </p>
                <p class="text-gray-300 text-sm sm:text-base mt-2 animate-text-reveal" style="animation-delay: 0.2s;">
                    Lokasi: {!! $mitra->mitra_address ?? '<i>Not set yet</i>' !!}
                </p>
            </div>

            <!-- Promo & Diskon Terbaru -->
            <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 text-teal-400 animate-text-reveal">Promo & Diskon Terbaru
                🤑</h2>

            @if ($promos->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    @foreach ($promos as $promo)
                        <div class="bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 promo-card animate-scale-in"
                            style="animation-delay: {{ $loop->index * 0.2 }}s;">
                            @php
                                $promoImage = $promo->image
                                    ? asset('storage/images/promos/' . $promo->image)
                                    : 'https://dummyimage.com/1920x1080/cccccc/000000.png&text=Promo+Image+1920+x+1080';
                            @endphp
                            <a href="javascript:void(0)" onclick="showImage('{{ $promoImage }}')">
                                <img src="{{ $promoImage }}" alt="{{ $promo->title ?? 'Promo' }}"
                                    class="w-full h-32 sm:h-40 object-cover rounded-lg mb-3 cursor-pointer transform hover:scale-105 transition-all duration-300">
                            </a>
                            <h3 class="text-base sm:text-lg font-semibold text-coral-500 mb-2">{{ $promo->title }}</h3>
                            <p class="text-gray-300 text-sm sm:text-base">{!! $promo->description !!}</p>
                            <div class="mt-2 text-xs sm:text-sm text-red-400 font-bold">
                                Berlaku sampai {{ \Carbon\Carbon::parse($promo->expired_date)->format('d F Y H:i') }} WIB
                            </div>
                            <div class="mt-3 sm:mt-4 flex items-center justify-between">
                                @if ($promo->is_member_only && !Auth::check())
                                    <button
                                        class="px-3 py-2 sm:px-4 sm:py-2 bg-red-500 text-white text-sm sm:text-base rounded-lg hover:bg-red-600 transform hover:scale-105 transition-all duration-300"
                                        onclick="window.location.href='{{ route('user.register', ['slug' => $slug]) }}'">
                                        Membership Only
                                    </button>
                                    <span id="copyStatus{{ $promo->id }}"
                                        class="text-xs sm:text-sm text-gray-400 hidden animate-fade-in">Kode berhasil
                                        disalin!</span>
                                @elseif ($promo->is_member_only && Auth::check())
                                    <button id="copyButton{{ $promo->id }}"
                                        class="px-3 py-2 sm:px-4 sm:py-2 bg-teal-500 text-white text-sm sm:text-base rounded-lg hover:bg-teal-600 transform hover:scale-105 transition-all duration-300"
                                        onclick="copyPromoCode('{{ $promo->coupon_code }}', {{ $promo->id }})">
                                        Salin Kode Promo
                                    </button>
                                    <span id="copyStatus{{ $promo->id }}"
                                        class="text-xs sm:text-sm text-gray-400 hidden animate-fade-in">Kode berhasil
                                        disalin!</span>
                                @else
                                    <button id="copyButton{{ $promo->id }}"
                                        class="px-3 py-2 sm:px-4 sm:py-2 bg-teal-500 text-white text-sm sm:text-base rounded-lg hover:bg-teal-600 transform hover:scale-105 transition-all duration-300"
                                        onclick="copyPromoCode('{{ $promo->coupon_code }}', {{ $promo->id }})">
                                        Salin Kode Promo
                                    </button>
                                    <span id="copyStatus{{ $promo->id }}"
                                        class="text-xs sm:text-sm text-gray-400 hidden animate-fade-in">Kode berhasil
                                        disalin!</span>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm sm:text-base italic animate-fade-in">Belum ada promo saat ini.</p>
            @endif

            <!-- Menu Favorit -->
            <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 text-teal-400 animate-text-reveal mt-8 sm:mt-10">Menu
                Favorit ⭐</h2>

            @if ($favoriteProducts->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    @foreach ($favoriteProducts as $menu)
                        <div class="bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 animate-scale-in cursor-pointer"
                            style="animation-delay: {{ $loop->index * 0.2 }}s;" data-menu-id="{{ $menu->id }}"
                            data-menu-name="{{ $menu->name }}" data-menu-description="{{ $menu->description }}"
                            data-menu-stock="{{ $menu->stock }}" data-menu-price="{{ $menu->formatted_price }}"
                            data-menu-image="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                            data-add-url="{{ route('cart.add', ['slug' => $slug, 'id' => $menu->id]) }}"
                            onclick="openMenuDetails('{{ $menu->id }}')">
                            <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                                alt="{{ $menu->name }}"
                                class="w-full h-32 sm:h-40 object-cover rounded-lg mb-3 transform hover:scale-105 transition-all duration-300">
                            <h3 class="text-base sm:text-lg font-semibold text-coral-500 mb-2 line-clamp-1">
                                {{ $menu->name }}</h3>
                            <p class="text-gray-300 text-sm sm:text-base line-clamp-2">{!! Illuminate\Support\Str::limit(strip_tags($menu->description), 50) !!}</p>
                            <p class="text-teal-400 text-sm sm:text-base mt-2">Harga: {{ $menu->formatted_price }}</p>
                            @if ($menu->reviews->isEmpty())
                                <div class="review-empty bg-gray-900/50 p-3 rounded-md text-gray-400 text-sm">
                                    Belum ada ulasan untuk menu ini.
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($menu->reviews as $review)
                                        <div
                                            class="review-item bg-gray-900/70 p-3 rounded-md border border-gray-600/50 animate-fade-in">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-coral-500" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
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
                </div>
            @else
                <p class="text-gray-400 text-sm sm:text-base italic animate-fade-in">Belum ada menu favorit saat ini.</p>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Show Image in Modal
        function showImage(imageUrl) {
            Swal.fire({
                imageUrl: imageUrl,
                imageAlt: 'Promo Image',
                showConfirmButton: false,
                showCloseButton: true,
                padding: '1rem',
                background: '#1f2937',
                customClass: {
                    popup: 'max-w-[90%] sm:max-w-3xl rounded-2xl'
                }
            });
        }

        // Copy Promo Code
        function copyPromoCode(code, promoId) {
            navigator.clipboard.writeText(code).then(() => {
                const copyButton = document.getElementById(`copyButton${promoId}`);
                const copyStatus = document.getElementById(`copyStatus${promoId}`);
                copyButton.classList.add('hidden');
                copyStatus.classList.remove('hidden');
                setTimeout(() => {
                    copyButton.classList.remove('hidden');
                    copyStatus.classList.add('hidden');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

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
                title: `<p class="text-center text-white">${menuName}</p>`,
                html: `
                    <img src="${menuImage}" alt="${menuName}" class="w-full max-w-[200px] h-auto rounded-lg mx-auto mb-4">
                    <p class="text-left text-gray-300 text-sm"><strong>Deskripsi:</strong> <div class="text-left text-white">${menuDescription}</div></p>
                    <p class="text-left text-gray-300 text-sm"><strong>Stock:</strong> ${menuStock}</p>
                    <p class="text-left text-teal-400 text-sm"><strong>Harga:</strong> ${menuPrice}</p>
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
@endpush
