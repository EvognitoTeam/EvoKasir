{{-- data-promo-card-alpine adalah wrapper untuk interaktivitas copy-paste --}}
<div x-data="{ copied: false }"
    class="bg-gray-800/80 backdrop-blur-md rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 animate-scale-in"
    style="animation-delay: {{ $loop->index * 0.1 }}s;">
    @php
        $promoImage = $promo->image
            ? asset('storage/' . $promo->image)
            : 'https://via.placeholder.com/800x450/1f2937/FFFFFF?text=Promo';
    @endphp

    <img src="{{ $promoImage }}" alt="{{ $promo->title }}"
        @click="$dispatch('show-image', { imageUrl: '{{ $promoImage }}' })"
        class="w-full h-40 object-cover rounded-lg mb-4 cursor-pointer transform hover:scale-105 transition-transform duration-300">

    <h3 class="text-lg font-semibold text-coral-500 mb-2">{{ $promo->title }}</h3>
    <div class="text-gray-300 text-sm prose prose-invert max-w-none">{!! $promo->description !!}</div>

    <div class="mt-2 text-xs text-red-400 font-bold">
        Berlaku sampai {{ \Carbon\Carbon::parse($promo->expired_date)->translatedFormat('d F Y') }}
    </div>

    <div class="mt-4 flex items-center justify-between">
        @if ($promo->coupon_code)
            <button
                @click="navigator.clipboard.writeText('{{ $promo->coupon_code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                class="px-4 py-2 bg-teal-500 text-white text-sm rounded-lg hover:bg-teal-600 transform hover:scale-105 transition-all duration-300">
                <span x-show="!copied">Salin Kode Promo</span>
                <span x-show="copied" class="text-white">Berhasil Disalin! <i class="fas fa-check"></i></span>
            </button>
        @endif
    </div>
</div>
