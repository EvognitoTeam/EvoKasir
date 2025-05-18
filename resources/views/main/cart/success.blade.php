@extends('layouts.app')

@section('title')
    Pembayaran Berhasil - {{ $order->mitra->mitra_name }} - EvoKasir
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

        @php
            $isCash = $order->payment_method === 'cash';
            $isPaid = $order->payment_status == 2;
        @endphp

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-lg">
            <div
                class="bg-gray-800/90 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-lg bg-gradient-to-b from-gray-800 to-gray-900/80 animate-scale-in border-l-8 {{ $isCash && !$isPaid ? 'border-yellow-400' : 'border-teal-500' }}">

                <!-- Icon -->
                <div class="flex justify-center mb-5">
                    @if ($isCash && !$isPaid)
                        <i class="fas fa-money-check-alt text-5xl sm:text-6xl text-yellow-400"></i>
                    @else
                        <i class="fas fa-check-circle text-5xl sm:text-6xl text-teal-400"></i>
                    @endif
                </div>

                <!-- Title -->
                <h2
                    class="text-2xl sm:text-3xl font-extrabold text-center {{ $isCash && !$isPaid ? 'text-yellow-400' : 'text-teal-400' }}">
                    {{ $isCash && !$isPaid ? 'Checkout Berhasil 🎉' : 'Pembayaran Berhasil 🎉' }}
                </h2>

                <p class="mt-2 text-gray-300 text-sm sm:text-base text-center">
                    Terima kasih telah memesan di
                    <span class="font-semibold text-coral-500">{{ $order->mitra->mitra_name }}</span>!
                </p>

                <!-- Order Details -->
                <div class="mt-6 space-y-4 sm:space-y-5">
                    <!-- Order Code -->
                    <div>
                        <p class="text-sm font-semibold text-gray-300">Kode Pesanan:</p>
                        <div
                            class="mt-1 px-4 py-2 bg-gray-900 text-teal-400 font-mono text-base sm:text-lg rounded-lg select-all tracking-wide shadow-inner">
                            {{ $order_code }}
                        </div>
                        @if ($isCash && !$isPaid)
                            <p class="text-xs sm:text-sm text-yellow-400 mt-1 italic">
                                Silakan lakukan pembayaran ke kasir dan tunjukkan kode ini. Pesanan diproses setelah
                                pembayaran.
                            </p>
                        @else
                            <p class="text-xs sm:text-sm text-gray-400 mt-1">
                                Gunakan kode ini jika diminta oleh petugas atau sistem.
                            </p>
                        @endif
                    </div>

                    <!-- Total Paid -->
                    <div>
                        <p class="text-sm font-semibold text-gray-300">Total Dibayar:</p>
                        <p class="text-lg sm:text-xl font-bold text-teal-400">
                            Rp {{ number_format($totalPaid, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Payment Method -->
                    <div class="flex justify-between items-center text-sm sm:text-base text-gray-300">
                        <span class="font-semibold">Metode Pembayaran:</span>
                        <span class="uppercase">{{ $order->payment_method }}</span>
                    </div>

                    <!-- Order Status -->
                    <div class="flex justify-between items-center text-sm sm:text-base text-gray-300">
                        <span class="font-semibold">Status Pesanan:</span>
                        <span>{{ ucfirst($order->status) }}</span>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6 sm:mt-8 text-center">
                    <a href="{{ route('menu.index', ['slug' => $slug]) }}"
                        class="inline-block w-full sm:w-auto bg-teal-500 hover:bg-teal-600 text-white px-6 py-2.5 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
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

        .animate-subtle-pulse {
            animation: subtlePulse 10s ease-in-out infinite;
        }
    </style>
@endpush
