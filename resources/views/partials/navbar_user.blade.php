<!-- Header -->
<nav class="bg-gray-800 text-white py-4 sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <a href="{{ route('menu.index', ['slug' => $slug]) }}"
            class="text-xl sm:text-2xl font-semibold text-coral-500 hover:text-coral-400 transition-all duration-200 transform hover:scale-105 animate-text-reveal">Evokasir</a>
        <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <div id="nav-menu" class="hidden md:flex items-center space-x-4 lg:space-x-6">
            <a href="{{ route('user.index', ['slug' => $slug]) }}"
                class="text-gray-300 text-sm lg:text-base hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">Home</a>
            <a href="{{ route('menu.index', ['slug' => $slug]) }}"
                class="text-gray-300 text-sm lg:text-base hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">Menu</a>
            <a href="{{ route('cart.index', ['slug' => $slug]) }}"
                class="relative text-gray-300 hover:text-teal-400 transition-all duration-200 transform hover:scale-105 animate-nav">
                <i class="fas fa-shopping-cart text-lg lg:text-xl"></i>
                @php
                    $cart = session('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                @endphp
                @if ($cartCount > 0)
                    <span
                        class="absolute -top-2 -right-2 bg-coral-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full animate-pulse">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-gray-800 shadow-lg">
            <div class="flex flex-col items-center space-y-4 py-4">
                <a href="{{ route('user.index', ['slug' => $slug]) }}"
                    class="text-gray-300 text-sm hover:text-teal-400 transition-all duration-200">Home</a>
                <a href="{{ route('menu.index', ['slug' => $slug]) }}"
                    class="text-gray-300 text-sm hover:text-teal-400 transition-all duration-200">Menu</a>
                <a href="{{ route('cart.index', ['slug' => $slug]) }}"
                    class="relative text-gray-300 hover:text-teal-400 transition-all duration-200">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    @if ($cartCount > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-coral-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full animate-pulse">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</nav>
