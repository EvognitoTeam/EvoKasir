@extends('layouts.app')

@section('title')
    Profil User - {{ $mitra->mitra_name }}
@endsection

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 py-6 sm:py-8 relative overflow-hidden">
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

        <div
            class="w-full max-w-5xl mx-auto bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl p-4 sm:p-6 relative z-10">
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
                    <ul class="list-none pl-5 space-y-1">
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
            <!-- Header dengan Avatar -->
            <div class="text-center mb-6">
                <div class="relative inline-block">
                    <div
                        class="w-20 h-20 rounded-full bg-teal-500 flex items-center justify-center text-white text-2xl font-bold mx-auto">
                        @php
                            $name = Auth::user()->name ?? '';
                            $words = explode(' ', trim($name));
                            $initials = '';
                            if (count($words) >= 2) {
                                $initials = Str::upper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                            } elseif (count($words) === 1 && !empty($words[0])) {
                                $initials = Str::upper(substr($words[0], 0, 2));
                            }
                            echo $initials;
                        @endphp
                    </div>
                    <span
                        class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-gray-800"></span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-coral-500 mt-4">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-gray-300 mt-2 text-sm sm:text-base">Membership di {{ $mitra->mitra_name }}</p>
            </div>

            <!-- Konten Utama: Dua Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kolom Kiri: Informasi Pengguna, Membership, Kupon -->
                <div class="space-y-4">
                    <!-- Informasi Akun -->
                    <div class="bg-gray-900 rounded-xl p-4 border border-gray-700">
                        <h2 class="text-lg font-semibold text-white mb-3">Informasi Akun</h2>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <label class="block text-xs font-medium text-gray-300">Nama Lengkap</label>
                                    <p class="text-base text-white">{{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div class="flex-1 w-full max-w-[calc(100%-2.5rem)]">
                                    <label class="block text-xs font-medium text-gray-300">Email</label>
                                    <p class="text-base text-white break-words sm:break-normal max-w-full sm:max-w-none"
                                        title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <label class="block text-xs font-medium text-gray-300">Nomor Telepon</label>
                                    <p class="text-base text-white">{{ Auth::user()->phone ?? 'Belum diatur' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Membership -->
                    <div class="bg-gray-900 rounded-xl p-4 border border-gray-700">
                        <h2 class="text-lg font-semibold text-white mb-3">Membership</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-300">Loyalty Points</label>
                                        <p class="text-xl font-bold text-yellow-400">{{ $loyaltyPoints }} Poin</p>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-500 text-white">
                                    Member
                                </span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <div>
                                    <label class="block text-xs font-medium text-gray-300">Loyalty ID</label>
                                    <p class="text-base text-white">{{ $loyaltyId }}</p>
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                                <button type="button" onclick="showBarcode()" class="focus:outline-none">
                                    <svg id="barcode" class="mx-auto max-w-full h-20 cursor-pointer"></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Kupon Khusus Member -->
                    <div class="bg-gray-900 rounded-xl p-4 border border-gray-700">
                        <h2 class="text-lg font-semibold text-white mb-3">Kupon Khusus Member</h2>
                        <div class="space-y-3 max-h-48 overflow-y-auto">
                            @forelse ($coupons as $coupon)
                                <div class="flex items-center justify-between p-2 bg-gray-800 rounded-lg">
                                    <div>
                                        <p class="text-sm text-white font-medium">Code : {{ $coupon->coupon_code }}</p>
                                        <p class="text-xs text-gray-400">Diskon: {{ $coupon->discount_rate }}% | Maks:
                                            {{ number_format($coupon->discount_price, 0, ',', '.') }} |
                                            Berlaku hingga:
                                            {{ \Carbon\Carbon::parse($coupon->expired_date)->translatedFormat('d M Y H:i:s') }}
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-500 text-white">
                                        Aktif
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400">Belum ada kupon tersedia</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Riwayat Aktivitas & Pemesanan -->
                <div class="bg-gray-900 rounded-xl p-4 border border-gray-700">
                    <!-- Tabs -->
                    <div class="flex border-b border-gray-700 mb-4">
                        {{-- <button class="tab-btn py-2 px-4 text-sm font-medium text-teal-400 border-b-2 border-teal-400"
                            onclick="showTab('activities')">Riwayat Aktivitas</button> --}}
                        <button class="tab-btn py-2 px-4 text-sm font-medium text-gray-400"
                            onclick="showTab('orders')">Riwayat Pemesanan</button>
                    </div>

                    <!-- Tab: Riwayat Aktivitas -->
                    {{-- <div id="activities" class="tab-content">
                        <div class="flex items-center space-x-3 mb-3">
                            <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-white">Riwayat Aktivitas</h3>
                        </div>
                        <ul class="space-y-2 max-h-96 overflow-y-auto">
                            @forelse ($activities as $activity)
                                <li class="flex items-start space-x-3 p-2 bg-gray-800 rounded-lg">
                                    <span class="text-teal-400">
                                        @if ($activity->activity_type === 'login')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 16l-4-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                        @elseif ($activity->activity_type === 'order')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        @elseif ($activity->activity_type === 'points')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif ($activity->activity_type === 'register')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        @elseif ($activity->activity_type === 'menu')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        @elseif ($activity->activity_type === 'checkout')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        @elseif ($activity->activity_type === 'logout')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m-4 4v1a3 3 0 003 3h7a3 3 0 003-3V7a3 3 0 00-3-3H6a3 3 0 00-3 3v1" />
                                            </svg>
                                        @endif
                                    </span>
                                    <div>
                                        <p class="text-xs text-white">{{ $activity->description }}</p>
                                        <p class="text-xs text-gray-400">{{ $activity->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-xs text-gray-400 p-2">Belum ada aktivitas</li>
                            @endforelse
                        </ul>
                    </div> --}}

                    <!-- Tab: Riwayat Pemesanan -->
                    <div id="orders" class="tab-content hidden">
                        <div class="flex items-center space-x-3 mb-3">
                            <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-white">Riwayat Pemesanan</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-300">
                                <thead class="text-xs text-gray-400 uppercase bg-gray-800">
                                    <tr>
                                        <th scope="col" class="px-3 py-2">Kode</th>
                                        <th scope="col" class="px-3 py-2">Total</th>
                                        <th scope="col" class="px-3 py-2">Status</th>
                                        <th scope="col" class="px-3 py-2">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders ?? [] as $order)
                                        <tr class="bg-gray-900 border-b border-gray-700 cursor-pointer hover:bg-gray-800"
                                            onclick="showOrderDetails({{ json_encode([
                                                'id' => $order->id,
                                                'code' => $order->order_code,
                                                'total' => number_format($order->total_price, 0, ',', '.'),
                                                'status' => $order->payment_status ? 'Lunas' : 'Belum Lunas',
                                                'status_class' => $order->payment_status ? 'bg-green-500' : 'bg-red-500',
                                                'date' => $order->created_at->format('d M Y, H:i'),
                                                'payment_method' => $order->payment_method ? strtoupper($order->payment_method) : 'Tidak Diketahui',
                                                'items' => $order->items->map(function ($item) {
                                                        return [
                                                            'id' => $item->id,
                                                            'name' => $item->product ? $item->product->name : 'Produk Tidak Ditemukan',
                                                            'quantity' => $item->quantity,
                                                            'price' => number_format($item->price, 0, ',', '.'),
                                                            'subtotal' => number_format($item->quantity * $item->price, 0, ',', '.'),
                                                            'product_id' => $item->product_id,
                                                        ];
                                                    })->toArray(),
                                            ]) }})">
                                            <td class="px-3 py-2">{{ $order->order_code }}</td>
                                            <td class="px-3 py-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-3 py-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $order->payment_status ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                                    {{ $order->payment_status ? 'Lunas' : 'Belum Lunas' }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-3 py-2 text-center text-gray-400">Belum ada
                                                pemesanan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
                <form method="POST" action="{{ route('user.logout', ['slug' => $slug]) }}" class="w-full sm:w-1/2">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 px-4 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambahkan JsBarcode dan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Barcode di halaman utama
            JsBarcode("#barcode", "{{ $loyaltyId }}", {
                format: "CODE128",
                background: "#1F2937",
                lineColor: "#FFFFFF",
                width: 2,
                height: 60,
                displayValue: true
            });

            // Tab switching
            const tabs = document.querySelectorAll('.tab-btn');
            const contents = document.querySelectorAll('.tab-content');

            function showTab(tabId) {
                contents.forEach(content => content.classList.add('hidden'));
                document.getElementById(tabId).classList.remove('hidden');

                tabs.forEach(btn => {
                    btn.classList.remove('text-teal-400', 'border-b-2', 'border-teal-400');
                    btn.classList.add('text-gray-400');
                });
                const activeBtn = Array.from(tabs).find(btn => btn.getAttribute('onclick') ===
                    `showTab('${tabId}')`);
                activeBtn.classList.add('text-teal-400', 'border-b-2', 'border-teal-400');
                activeBtn.classList.remove('text-gray-400');
            }

            tabs.forEach(btn => {
                btn.addEventListener('click', () => {
                    const tabId = btn.getAttribute('onclick').match(/'([^']+)'/)[1];
                    showTab(tabId);
                });
            });

            // Show activities tab by default
            showTab('orders');
        });

        function showBarcode() {
            const barcodeSvg = document.getElementById('barcode').outerHTML;
            Swal.fire({
                title: `<p class="text-center text-white">Barcode Loyalty ID</p>`,
                html: `
                    <div class="flex flex-col items-center">
                        ${barcodeSvg}
                    </div>
                `,
                background: '#1F2937',
                customClass: {
                    title: 'text-coral-500 text-lg font-semibold',
                    popup: 'rounded-lg',
                    confirmButton: 'bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg'
                },
                confirmButtonColor: '#14b8a6',
                confirmButtonText: 'Tutup'
            });
        }

        function showOrderDetails(order) {
            let itemsHtml = '';
            order.items.forEach(item => {
                // Cek apakah sudah ada review untuk item ini
                @php
                    $existingReviews = \App\Models\Rating::where('user_id', auth()->id())
                        ->get()
                        ->keyBy(function ($review) {
                            return $review->product_id;
                        });
                @endphp
                const existingReview = @json($existingReviews)[item.product_id] || null;
                const isPaid = order.status === 'Lunas';
                let reviewForm = '';
                if (isPaid && !existingReview) {
                    reviewForm = `
                        <form action="{{ route('user.review.store', ['slug' => $slug, 'order' => ':order_id', 'item' => ':item_id']) }}"
                              method="POST" class="mt-2">
                            @csrf
                            <div class="flex flex-col space-y-2">
                                <label class="text-xs text-gray-300">Rating</label>
                                <div class="star-rating" data-item-id="${item.id}" data-rating="0">
                                    <span class="star" data-index="1">★</span>
                                    <span class="star" data-index="2">★</span>
                                    <span class="star" data-index="3">★</span>
                                    <span class="star" data-index="4">★</span>
                                    <span class="star" data-index="5">★</span>
                                </div>
                                <input type="hidden" name="rating" class="rating-value" data-item-id="${item.id}" value="0">
                                <label class="text-xs text-gray-300">Komentar</label>
                                <textarea name="comment" rows="2"
                                          class="bg-gray-800 text-white p-2 rounded-lg border border-gray-700 focus:outline-none focus:border-teal-500"></textarea>
                                <button type="submit"
                                        class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    Kirim Review
                                </button>
                            </div>
                        </form>
                    `.replace(':order_id', order.id)
                        .replace(':item_id', item.id);
                } else if (existingReview) {
                    // Tampilkan rating yang sudah ada sebagai bintang
                    let starsHtml = '';
                    const rating = parseFloat(existingReview.rating);
                    for (let i = 1; i <= 5; i++) {
                        if (rating >= i) {
                            starsHtml += `<span class="star rated">★</span>`;
                        } else if (rating >= i - 0.5 && rating < i) {
                            starsHtml += `<span class="star half-rated">★</span>`;
                        } else {
                            starsHtml += `<span class="star">★</span>`;
                        }
                    }
                    reviewForm = `
                        <div class="mt-2 text-sm text-gray-300">
                            <p><span class="font-medium">Rating Anda:</span> <span class="star-rating static">${starsHtml}</span> (${existingReview.rating})</p>
                            <p><span class="font-medium">Komentar:</span> ${existingReview.comment || 'Tidak ada'}</p>
                        </div>
                    `;
                } else {
                    reviewForm =
                        '<p class="text-xs text-gray-400 mt-2">Review hanya tersedia untuk pesanan lunas.</p>';
                }

                itemsHtml += `
                    <tr class="bg-gray-900 border-b border-gray-700">
                        <td class="px-3 py-2 text-sm">${item.name}</td>
                        <td class="px-3 py-2 text-sm">${item.quantity}</td>
                        <td class="px-3 py-2 text-sm">Rp ${item.price}</td>
                        <td class="px-3 py-2 text-sm">Rp ${item.subtotal}</td>
                    </tr>
                    <tr class="bg-gray-900 border-b border-gray-700">
                        <td colspan="4" class="px-3 py-2">
                            ${reviewForm}
                        </td>
                    </tr>
                `;
            });

            Swal.fire({
                title: `<p class="text-center text-white">Detail Pesanan</p>`,
                html: `
                    <div class="text-left text-gray-300 text-sm space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium">Kode Pesanan:</span>
                            <span>${order.code}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Total Harga:</span>
                            <span>Rp ${order.total}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Metode Pembayaran:</span>
                            <span>${order.payment_method}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Status:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white ${order.status_class}">
                                ${order.status}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Tanggal:</span>
                            <span>${order.date}</span>
                        </div>
                        <h4 class="text-sm font-semibold text-white mt-4">Item Pesanan</h4>
                        <div class="overflow-x-auto max-h-48">
                            <table class="w-full text-sm text-left text-gray-300">
                                <thead class="text-xs text-gray-400 uppercase bg-gray-800">
                                    <tr>
                                        <th class="px-3 py-2">Produk</th>
                                        <th class="px-3 py-2">Jumlah</th>
                                        <th class="px-3 py-2">Harga</th>
                                        <th class="px-3 py-2">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHtml}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `,
                background: '#1F2937',
                customClass: {
                    title: 'text-coral-500 text-lg font-semibold',
                    popup: 'rounded-lg max-w-2xl',
                    confirmButton: 'bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg'
                },
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#14b8a6',
                width: '90%',
                padding: '1rem',
                didOpen: () => {
                    const stars = document.querySelectorAll('.star-rating:not(.static) .star');
                    stars.forEach(star => {
                        star.addEventListener('click', (e) => {
                            const ratingContainer = star.parentElement;
                            const itemId = ratingContainer.getAttribute('data-item-id');
                            const index = parseInt(star.getAttribute('data-index'));
                            const rect = star.getBoundingClientRect();
                            const clickX = e.clientX - rect.left;
                            const isHalf = clickX < rect.width / 2;
                            const rating = isHalf ? index - 0.5 : index;

                            ratingContainer.setAttribute('data-rating', rating);

                            // Seleksi bintang berdasarkan container star-rating
                            const containerStars = ratingContainer.querySelectorAll('.star');
                            containerStars.forEach(s => {
                                const sIndex = parseInt(s.getAttribute('data-index'));
                                if (sIndex < index || (sIndex === index && !isHalf)) {
                                    s.classList.add('rated');
                                    s.classList.remove('half-rated');
                                } else if (sIndex === index && isHalf) {
                                    s.classList.add('half-rated');
                                    s.classList.remove('rated');
                                } else {
                                    s.classList.remove('rated', 'half-rated');
                                }
                            });

                            // Update input rating
                            const ratingInput = document.querySelector(
                                `.rating-value[data-item-id="${itemId}"]`);
                            if (ratingInput) {
                                ratingInput.value = rating;
                            }
                        });
                    });
                }
            });
        }
    </script>
@endsection

@push('styles')
    <style>
        :root {
            --coral-500: #f87171;
            --teal-400: #2dd4bf;
            --teal-500: #14b8a6;
            --teal-600: #0d9488;
        }

        @keyframes subtlePulse {
            0% {
                opacity: 0.1;
            }

            50% {
                opacity: 0.15;
            }

            100% {
                opacity: 0.1;
            }
        }

        .animate-subtle-pulse {
            animation: subtlePulse 4s ease-in-out infinite;
        }

        /* Gaya untuk star rating */
        .star-rating {
            display: inline-flex;
            gap: 2px;
            cursor: pointer;
        }

        .star-rating.static {
            cursor: default;
        }

        .star {
            font-size: 20px;
            color: #4b5563;
            /* Gray-600 untuk bintang kosong */
            transition: color 0.2s, transform 0.2s;
            position: relative;
            width: 20px;
            text-align: center;
            user-select: none;
        }

        .star.rated {
            color: #facc15;
            /* Yellow-400 untuk bintang terisi */
        }

        .star.half-rated::before {
            content: '★';
            position: absolute;
            left: 0;
            width: 50%;
            overflow: hidden;
            color: #facc15;
        }

        .star:hover,
        .star-rating:not(.static):hover .star {
            color: #facc15;
            /* Efek hover */
            transform: scale(1.1);
        }
    </style>
@endpush
