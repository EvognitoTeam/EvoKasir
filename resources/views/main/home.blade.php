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
                    {{ $mitra->description ?? 'Selamat datang di tempat kami!' }}
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
                                <button id="copyButton{{ $promo->id }}"
                                    class="px-3 py-2 sm:px-4 sm:py-2 bg-teal-500 text-white text-sm sm:text-base rounded-lg hover:bg-teal-600 transform hover:scale-105 transition-all duration-300"
                                    onclick="copyPromoCode('{{ $promo->coupon_code }}', {{ $promo->id }})">
                                    Salin Kode Promo
                                </button>
                                <span id="copyStatus{{ $promo->id }}"
                                    class="text-xs sm:text-sm text-gray-400 hidden animate-fade-in">Kode berhasil
                                    disalin!</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm sm:text-base italic animate-fade-in">Belum ada promo saat ini.</p>
            @endif
        </div>
    </section>
@endsection
