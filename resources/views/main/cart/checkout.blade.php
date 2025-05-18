@extends('layouts.app')

@section('title')
    Checkout - {{ $mitra->mitra_name }} - EvoKasir
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

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-coral-500 mb-6 sm:mb-8 animate-text-reveal">
                Checkout</h2>

            <!-- Success or Error Messages -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-teal-500/20 text-teal-400 rounded-xl border border-teal-400/30 shadow-lg animate-fade-in">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div
                    class="mb-6 p-4 bg-red-500/20 text-red-400 rounded-xl border border-red-400/30 shadow-lg animate-fade-in">
                    <strong>Gagal!</strong> {{ session('error') }}
                </div>
            @endif

            <!-- Main Layout: Two Columns -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Left Column: Order Details, Coupon, Summary -->
                <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                    <!-- Detail Pesanan -->
                    <div
                        class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-2xl shadow-lg bg-gradient-to-b from-gray-800 to-gray-900/80 animate-scale-in">
                        <h3 class="text-lg sm:text-xl font-semibold text-coral-500 mb-4">Detail Pesanan</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm sm:text-base">
                                <thead>
                                    <tr class="border-b border-gray-700">
                                        <th class="py-2 sm:py-3">Produk</th>
                                        <th class="py-2 sm:py-3">Jumlah</th>
                                        <th class="py-2 sm:py-3">Harga</th>
                                        <th class="py-2 sm:py-3 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $item)
                                        <tr class="border-b border-gray-700">
                                            <td class="py-2 sm:py-3">{{ $item['name'] }}</td>
                                            <td class="py-2 sm:py-3">{{ $item['quantity'] }}</td>
                                            <td class="py-2 sm:py-3">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                            <td class="py-2 sm:py-3 text-right">
                                                Rp{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Kupon -->
                    <div
                        class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-2xl shadow-lg bg-gradient-to-b from-gray-800 to-gray-900/80 animate-scale-in">
                        <h3 class="text-lg sm:text-xl font-semibold text-coral-500 mb-4">Gunakan Kupon</h3>
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            @if (!session('discount'))
                                <div class="w-full sm:w-2/3">
                                    <label for="coupon_code"
                                        class="block text-sm sm:text-base text-gray-300 font-semibold mb-2">Masukkan Kode
                                        Kupon</label>
                                    <input type="text" id="coupon_code" name="coupon_code"
                                        class="w-full border border-gray-700 rounded-lg px-4 py-2 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                                        placeholder="Contoh: DISKON10">
                                </div>
                                <div>
                                    <button type="button" onclick="applyCoupon()"
                                        class="bg-teal-500 hover:bg-teal-600 text-white px-4 sm:px-6 py-2 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                                        Terapkan Kupon
                                    </button>
                                </div>
                            @else
                                <div class="text-teal-400 font-semibold text-sm sm:text-base">
                                    Kupon diterapkan: {{ session('applied_coupon') }} (Diskon:
                                    Rp{{ number_format(session('discount'), 0, ',', '.') }})
                                </div>
                                <form action="{{ route('cart.removeCoupon', ['slug' => $slug]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                                        Hapus Kupon
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Ringkasan Pembayaran -->
                    <div
                        class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-2xl shadow-lg bg-gradient-to-b from-gray-800 to-gray-900/80 animate-scale-in">
                        <h3 class="text-lg sm:text-xl font-semibold text-coral-500 mb-4">Ringkasan Pembayaran</h3>
                        <div class="space-y-3 text-sm sm:text-base">
                            <div class="flex justify-between">
                                <span class="text-gray-300">Total:</span>
                                <span id="totalPrice"
                                    class="text-gray-300">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300">Potongan:</span>
                                <span id="discountPrice" class="text-teal-400">-
                                    Rp{{ number_format(session('discount', 0), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-base sm:text-lg border-t border-gray-700 pt-3">
                                <span class="text-coral-500">Total Bayar:</span>
                                <span
                                    class="text-teal-400">Rp{{ number_format($totalPrice - session('discount', 0), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Payment Method -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-2xl shadow-lg bg-gradient-to-b from-gray-800 to-gray-900/80 animate-scale-in sticky top-20">
                        <h3 class="text-lg sm:text-xl font-semibold text-coral-500 mb-4">Pilih Metode Pembayaran</h3>
                        <form action="{{ route('cart.store', ['slug' => $slug]) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name"
                                    class="block mb-2 text-sm sm:text-base text-gray-300 font-semibold">Nama Anda*</label>
                                <input type="text" name="name" id="name"
                                    class="border border-gray-700 rounded-lg p-2 sm:p-3 w-full text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                                    placeholder="Masukkan Nama Anda" required>
                            </div>
                            <div class="mb-4">
                                <label for="email"
                                    class="block mb-2 text-sm sm:text-base text-gray-300 font-semibold">Email Anda*</label>
                                <input type="email" name="email" id="email"
                                    class="border border-gray-700 rounded-lg p-2 sm:p-3 w-full text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                                    placeholder="Masukkan Email Anda" required>
                            </div>
                            <div class="mb-4">
                                <label for="table_number"
                                    class="block mb-2 text-sm sm:text-base text-gray-300 font-semibold">Pilih Nomor
                                    Meja*</label>
                                <select name="table_number" id="table_number"
                                    class="border border-gray-700 rounded-lg p-2 sm:p-3 w-full text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                                    required>
                                    <option value="" selected disabled>Pilih Meja Anda</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">{{ $table->table_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <input type="hidden" name="payment_method" id="payment_method" value="cash">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="payment-option cursor-pointer bg-gray-900 rounded-lg p-3 sm:p-4 border-2 border-gray-700 hover:border-coral-500 transition-all duration-200 transform hover:scale-105"
                                        data-value="cash" onclick="selectPaymentMethod('cash')">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-money-bill-wave text-xl sm:text-2xl text-teal-400"></i>
                                            <span class="text-sm sm:text-base font-semibold text-gray-300">Cash</span>
                                        </div>
                                        <p class="text-xs sm:text-sm text-gray-400 mt-2">Bayar langsung dengan uang tunai
                                        </p>
                                    </div>
                                    <div class="payment-option cursor-pointer bg-gray-900 rounded-lg p-3 sm:p-4 border-2 border-gray-700 hover:border-coral-500 transition-all duration-200 transform hover:scale-105"
                                        data-value="qris" onclick="selectPaymentMethod('qris')">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-qrcode text-xl sm:text-2xl text-teal-400"></i>
                                            <span class="text-sm sm:text-base font-semibold text-gray-300">QRIS</span>
                                        </div>
                                        <p class="text-xs sm:text-sm text-gray-400 mt-2">Scan kode QR untuk pembayaran</p>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full bg-teal-500 hover:bg-teal-600 text-white py-2 sm:py-3 px-4 sm:px-6 rounded-lg text-base sm:text-lg font-semibold shadow-md transition-all duration-200 transform hover:scale-105">
                                Bayar Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function applyCoupon() {
            const couponCode = document.getElementById('coupon_code').value.trim();

            if (!couponCode) {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Kode kupon tidak boleh kosong!',
                    icon: 'error',
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

            fetch("{{ route('cart.applyCoupon', ['slug' => $slug]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        coupon_code: couponCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Kupon diterapkan! Potongan: Rp${data.discount}`,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                            background: '#1f2937',
                            customClass: {
                                title: 'text-coral-500',
                                content: 'text-gray-300'
                            }
                        });
                        window.location.reload();
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: data.message || 'Kode kupon tidak valid.',
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
                        text: 'Terjadi kesalahan saat menerapkan kupon.',
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

        function selectPaymentMethod(method) {
            const input = document.getElementById('payment_method');
            const options = document.querySelectorAll('.payment-option');
            input.value = method;

            options.forEach(option => {
                if (option.getAttribute('data-value') === method) {
                    option.classList.remove('border-gray-700');
                    option.classList.add('border-coral-500', 'bg-gray-800/50', 'shadow-inner');
                } else {
                    option.classList.remove('border-coral-500', 'bg-gray-800/50', 'shadow-inner');
                    option.classList.add('border-gray-700');
                }
            });
        }

        // Set default selection
        document.addEventListener('DOMContentLoaded', () => {
            selectPaymentMethod('cash');
        });
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
            animation: scaleIn 0.6s ease-out forwards;
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
