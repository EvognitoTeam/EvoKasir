@php
    // Kalkulasi awal jumlah keranjang dari session
    $initialCartCount = array_sum(array_column(session("cart.$slug", []), 'quantity'));
@endphp

{{-- Link Navigasi Umum --}}
<a href="{{ route('user.index', ['slug' => $slug]) }}"
    class="text-gray-300 hover:text-teal-400 transition-colors duration-200">Home</a>
<a href="{{ route('menu.index', ['slug' => $slug]) }}"
    class="text-gray-300 hover:text-teal-400 transition-colors duration-200">Menu</a>

{{-- Ikon Keranjang Belanja yang Reaktif dengan Alpine.js --}}
<a href="{{ route('cart.index', ['slug' => $slug]) }}" x-data="{ cartCount: {{ $initialCartCount }} }"
    @cart-updated.window="
       fetch('{{ route('cart.count', ['slug' => $slug]) }}')
           .then(res => res.json())
           .then(data => cartCount = data.count)
           .catch(error => console.error('Error fetching cart count:', error))
   "
    class="relative text-gray-300 hover:text-teal-400 transition-colors duration-200">
    <i class="fas fa-shopping-cart text-xl"></i>
    <template x-if="cartCount > 0">
        <span x-text="cartCount"
            class="absolute -top-2 -right-3 bg-coral-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full animate-pulse"></span>
    </template>
</a>

{{-- Link Berdasarkan Status Login --}}
@auth
    <a href="{{ route('user.profile', ['slug' => $slug]) }}"
        class="text-gray-300 hover:text-teal-400 transition-colors duration-200">Profil</a>
    <form method="POST" action="{{ route('user.logout', ['slug' => $slug]) }}">
        @csrf
        <button type="submit" class="text-gray-300 hover:text-teal-400 transition-colors duration-200">Logout</button>
    </form>
@else
    <a href="{{ route('user.login', ['slug' => $slug]) }}"
        class="text-gray-300 hover:text-teal-400 transition-colors duration-200">Login</a>
    <a href="{{ route('user.register', ['slug' => $slug]) }}"
        class="text-gray-300 hover:text-teal-400 transition-colors duration-200">Register</a>
@endauth
