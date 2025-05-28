@extends('layouts.app')

@section('content')
    <div
        class="max-w-md w-full mx-auto mt-20 p-6 md:p-8 bg-white shadow-xl rounded-2xl border-l-8 border-red-500 animate-fade-in">

        {{-- Icon Gagal --}}
        <div class="flex justify-center mb-5">
            <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M19.07 4.93L4.93 19.07" />
            </svg>
        </div>

        {{-- Judul --}}
        <h2 class="text-2xl md:text-3xl font-bold text-center text-red-600">Checkout Gagal ❌</h2>

        <p class="mt-2 text-gray-600 text-sm text-center">
            Maaf, transaksi Anda tidak dapat diproses saat ini.
        </p>

        {{-- Penjelasan Detail --}}
        <div class="mt-6 space-y-3">
            <p class="text-sm text-gray-700 text-center">
                Pastikan koneksi internet stabil atau coba kembali beberapa saat lagi.
            </p>
            <p class="text-sm text-gray-500 text-center italic">
                Jika Anda sudah membayar namun tetap gagal, segera hubungi kasir dengan menunjukkan bukti pembayaran yang
                berisi ID Pesanan anda.
            </p>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-8 text-center">
            <a href="{{ route('menu.index', ['slug' => $slug]) }}"
                class="inline-block w-full md:w-auto bg-gray-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-gray-700 transition duration-300">
                Kembali ke Menu
            </a>
        </div>
    </div>

    {{-- Animasi --}}
    <style>
        @layer utilities {
            .animate-fade-in {
                @apply opacity-0 translate-y-6 animate-[fadeIn_0.6s_ease-out_forwards];
            }

            @keyframes fadeIn {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }
    </style>
@endsection
