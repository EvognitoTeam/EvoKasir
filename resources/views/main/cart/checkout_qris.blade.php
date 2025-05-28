@extends('layouts.app')

@section('title')
    Pembayaran QRIS - {{-- {{ $order->mitra->mitra_name }} - --}} EvoKasir
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

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-lg">
            <div
                class="bg-gray-800/90 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-lg bg-gradient-to-b from-gray-800 to-gray-900/80 animate-scale-in">
                @if (isset($qris_url))
                    <h2
                        class="text-2xl sm:text-3xl font-extrabold text-center text-coral-500 mb-4 sm:mb-6 animate-text-reveal">
                        Scan QRIS untuk Pembayaran
                    </h2>

                    <div class="mb-6 flex justify-center">
                        <img src="{{ $qris_url }}" alt="QRIS QR Code"
                            class="w-56 sm:w-64 border-2 border-gray-700 p-2 bg-white rounded-lg shadow-md transform hover:scale-105 transition-all duration-200" />
                    </div>

                    <p class="text-gray-300 text-sm sm:text-base text-center mb-4 sm:mb-6">
                        Gunakan aplikasi pembayaran yang mendukung QRIS untuk menyelesaikan transaksi Anda.
                    </p>

                    <div class="text-sm sm:text-base text-gray-300 text-center mb-4 sm:mb-6">
                        QR Code akan kedaluwarsa dalam
                        <span id="countdown" class="font-semibold text-red-400">--:--</span>
                    </div>

                    <button id="checkStatusBtn"
                        class="w-full sm:w-auto bg-teal-500 hover:bg-teal-600 text-white px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                        Cek Status Pembayaran
                    </button>

                    <div id="statusMessage" class="mt-4 text-sm sm:text-base text-gray-300 text-center hidden">
                        Memeriksa status pembayaran...
                    </div>
                @else
                    <div class="text-red-400 font-semibold text-center text-sm sm:text-base">
                        QRIS QR Code tidak tersedia.
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if (isset($expiry_time) && isset($order_code))
        @push('scripts')
            <script>
                const expiryTime = new Date("{{ \Carbon\Carbon::parse($expiry_time)->format('Y-m-d\TH:i:s') }}");
                const countdownEl = document.getElementById('countdown');
                const checkStatusBtn = document.getElementById('checkStatusBtn');
                const statusMessage = document.getElementById('statusMessage');
                const orderId = "{{ $order_code }}";
                const slug = "{{ $slug }}";
                const successUrl = "{{ route('checkout.success', ['slug' => $slug, 'order_code' => $order_code]) }}";

                function updateCountdown() {
                    const now = new Date();
                    const diff = Math.max(0, Math.floor((expiryTime - now) / 1000)); // in seconds
                    const minutes = Math.floor(diff / 60);
                    const seconds = diff % 60;
                    countdownEl.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                    if (diff <= 0) {
                        countdownEl.textContent = 'Expired';
                        Swal.fire({
                            title: 'QRIS Kedaluwarsa!',
                            text: 'QR Code telah kedaluwarsa. Silakan buat pesanan baru.',
                            icon: 'error',
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

                async function checkPaymentStatus() {
                    statusMessage.classList.remove('hidden');
                    try {
                        const res = await fetch(`/api/payment-status/${orderId}`);
                        const data = await res.json();

                        if (data.payment_status === "2") {
                            Swal.fire({
                                title: 'Pembayaran Berhasil!',
                                text: 'Transaksi Anda telah selesai.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false,
                                background: '#1f2937',
                                customClass: {
                                    title: 'text-coral-500',
                                    content: 'text-gray-300'
                                }
                            }).then(() => {
                                window.location.href = successUrl;
                            });
                        } else {
                            statusMessage.textContent = 'Pembayaran belum dikonfirmasi.';
                            setTimeout(() => {
                                statusMessage.classList.add('hidden');
                            }, 3000);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        statusMessage.textContent = 'Gagal memeriksa status pembayaran.';
                        setTimeout(() => {
                            statusMessage.classList.add('hidden');
                        }, 3000);
                    }
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);

                // Manual check button
                checkStatusBtn?.addEventListener('click', checkPaymentStatus);

                // Auto check every 15 seconds
                setInterval(checkPaymentStatus, 15000);
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

                .animate-text-reveal {
                    animation: textReveal 0.8s ease-out forwards;
                }

                .animate-subtle-pulse {
                    animation: subtlePulse 10s ease-in-out infinite;
                }
            </style>
        @endpush
    @endif
@endsection
