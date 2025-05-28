@extends('layouts.app')

@section('title')
    Keranjang Belanja - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
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

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-6 animate-text-reveal">🛒 Keranjang Belanja
            </h1>

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
                    <ul class="list-disc pl-5 space-y-1">
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

            @if (session('cart'))
                <div class="space-y-4 sm:space-y-6">
                    @foreach ($cart as $id => $item)
                        <div class="flex flex-col md:flex-row justify-between items-start bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-lg p-4 sm:p-6 space-y-4 md:space-y-0 md:space-x-6 animate-scale-in"
                            style="animation-delay: {{ $loop->index * 0.2 }}s;">
                            <!-- Bagian Gambar & Info -->
                            <div class="flex items-start space-x-4 w-full md:w-2/3">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 overflow-hidden rounded-lg border border-gray-700">
                                    <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://dummyimage.com/300x200/cccccc/000000.png&text=No+Image' }}"
                                        alt="{{ $item['name'] }}"
                                        class="w-full h-full object-cover transform hover:scale-110 transition-all duration-300">
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-lg sm:text-xl font-semibold text-coral-500">{{ $item['name'] }}</h2>
                                    <p class="text-gray-300 text-sm sm:text-base mt-1">
                                        Harga: <strong
                                            class="text-teal-400">Rp{{ number_format($item['price'], 0, ',', '.') }}</strong>
                                    </p>
                                </div>
                            </div>

                            <!-- Bagian Aksi -->
                            <div class="flex flex-col items-center md:items-end w-full md:w-1/3 space-y-3">
                                <!-- Quantity -->
                                <div class="flex space-x-2 items-center">
                                    <button type="button"
                                        class="bg-teal-500 hover:bg-teal-600 text-white py-1 px-3 rounded-full transition-all duration-200 transform hover:scale-105"
                                        onclick="updateQuantity({{ $id }}, -1)">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="text" inputmode="numeric" id="quantity-{{ $id }}"
                                        name="quantity" value="{{ $item['quantity'] }}" min="1"
                                        class="w-12 sm:w-16 border border-gray-700 rounded-md px-2 py-1 text-center text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500"
                                        readonly>
                                    <button type="button"
                                        class="bg-teal-500 hover:bg-teal-600 text-white py-1 px-3 rounded-full transition-all duration-200 transform hover:scale-105"
                                        onclick="updateQuantity({{ $id }}, 1)">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <!-- Hapus -->
                                <form action="{{ route('cart.remove', ['slug' => $slug, 'id' => $id]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-md transition-all duration-200 transform hover:scale-105">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total Harga -->
                <div
                    class="mt-6 bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-2xl shadow-lg flex justify-between items-center animate-scale-in">
                    <h3 class="text-lg sm:text-xl font-semibold text-coral-500">Total Harga:</h3>
                    <p id="totalPrice" class="text-lg sm:text-xl font-bold text-teal-400">
                        Rp{{ number_format($totalPrice, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Checkout -->
                <div class="mt-6 sm:mt-8 flex justify-end">
                    <a href="{{ route('cart.checkout', ['slug' => $slug]) }}"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                        Checkout Sekarang
                    </a>
                </div>
            @else
                <div class="text-center text-gray-400 mt-12 sm:mt-16 animate-fade-in">
                    <p class="text-lg sm:text-xl">Keranjang kamu masih kosong 😢</p>
                    <a href="{{ route('menu.index', ['slug' => $slug]) }}"
                        class="mt-4 inline-block bg-coral-500 hover:bg-coral-600 text-white px-4 sm:px-5 py-2 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                        Lihat Menu
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function updateQuantity(id, change) {
            const quantityInput = document.getElementById('quantity-' + id);
            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + change;

            if (newQuantity >= 1) {
                quantityInput.value = newQuantity;

                // Send AJAX request to update the cart
                fetch(`{{ route('cart.update', ['slug' => $slug, 'id' => ':id']) }}`.replace(':id', id), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: newQuantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Jumlah item diperbarui.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false,
                                background: '#1f2937',
                                customClass: {
                                    title: 'text-coral-500',
                                    content: 'text-gray-300'
                                }
                            });
                            location.reload(); // Reload to update total price
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Gagal memperbarui jumlah item.',
                                icon: 'error',
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
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memperbarui jumlah item.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                            background: '#1f2937',
                            customClass: {
                                title: 'text-coral-500',
                                content: 'text-gray-300'
                            }
                        });
                    });
            }
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
    </style>
@endpush
