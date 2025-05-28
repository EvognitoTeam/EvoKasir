@extends('layouts.admin')

@section('title')
    Detail Pesanan - {{ $order->order_code }} - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-5xl">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-6 sm:mb-8 animate-text-reveal">Detail Pesanan</h1>

        <!-- Error Message -->
        @if (session('error'))
            <div
                class="mb-6 bg-red-500/20 border border-red-400/30 text-red-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="mb-6 bg-teal-500/20 border border-teal-400/30 text-teal-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-gray-800/90 backdrop-blur-md shadow-lg rounded-xl p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-8 animate-scale-in">
            <!-- Informasi Pesanan -->
            <div>
                <h2
                    class="text-lg sm:text-xl font-semibold text-gray-300 mb-2 sm:mb-3 border-b border-gray-700 pb-1 sm:pb-2">
                    Informasi Pesanan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                    <p><strong>Kode Pesanan:</strong> <span
                            class="font-semibold text-teal-400">{{ $order->order_code }}</span></p>
                    <p><strong>Meja:</strong> {{ $order->table->table_name ?? '-' }}</p>
                    <p><strong>Nama:</strong> {{ $order->name ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $order->email ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ Str::upper($order->payment_method) ?? '-' }}</p>
                    <div class="col-span-1 sm:col-span-2">
                        <strong>Status:</strong>
                        @php
                            $statusLabels = [
                                'pending' => 'Menunggu Diantar',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                            $statusColors = [
                                'pending' => 'bg-yellow-400',
                                'completed' => 'bg-teal-500',
                                'cancelled' => 'bg-red-500',
                            ];
                            $currentStatus = $statusLabels[$order->status] ?? 'Tidak Diketahui';
                            $currentColor = $statusColors[$order->status] ?? 'bg-gray-400';
                        @endphp
                        <form
                            action="{{ route('admin.orders.updateStatus', ['slug' => $slug, 'order_code' => $order->order_code]) }}"
                            method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                class="border border-gray-700 rounded-lg px-2 sm:px-3 py-1 sm:py-2 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 text-xs sm:text-sm">
                                @foreach ($statusLabels as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        <span
                            class="ml-2 px-2 sm:px-3 py-1 rounded-full text-white text-xs sm:text-sm {{ $currentColor }}">
                            {{ $currentStatus }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            <div>
                <h2
                    class="text-lg sm:text-xl font-semibold text-gray-300 mb-2 sm:mb-3 border-b border-gray-700 pb-1 sm:pb-2">
                    Informasi Pembayaran</h2>
                @php
                    $paymentStatusLabels = [
                        1 => 'Menunggu Pembayaran',
                        2 => 'Pembayaran Berhasil',
                        3 => 'Pembayaran Gagal',
                        4 => 'Pembayaran Expired',
                    ];
                    $paymentStatus = $paymentStatusLabels[$order->payment_status] ?? 'Tidak Diketahui';
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                    <p><strong>Status Pembayaran:</strong> {{ $paymentStatus }}</p>
                    <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Item Pesanan -->
            <div>
                <h2
                    class="text-lg sm:text-xl font-semibold text-gray-300 mb-2 sm:mb-3 border-b border-gray-700 pb-1 sm:pb-2">
                    Item Pesanan</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm sm:text-base text-left border border-gray-700">
                        <thead class="bg-gray-700/50 text-gray-300">
                            <tr>
                                <th class="py-2 sm:py-3 px-3 sm:px-4 border-b border-gray-600 font-semibold">Nama Produk
                                </th>
                                <th class="py-2 sm:py-3 px-3 sm:px-4 border-b border-gray-600 font-semibold">Jumlah</th>
                                <th class="py-2 sm:py-3 px-3 sm:px-4 border-b border-gray-600 font-semibold">Harga</th>
                                <th class="py-2 sm:py-3 px-3 sm:px-4 border-b border-gray-600 font-semibold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition-all duration-200">
                                    <td class="py-2 sm:py-3 px-3 sm:px-4 text-gray-300">{{ $item->product->name }}</td>
                                    <td class="py-2 sm:py-3 px-3 sm:px-4 text-gray-300">{{ $item->quantity }}</td>
                                    <td class="py-2 sm:py-3 px-3 sm:px-4 text-gray-300">Rp
                                        {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td class="py-2 sm:py-3 px-3 sm:px-4 text-gray-300">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 sm:mt-6 text-sm sm:text-base text-right space-y-1 sm:space-y-2">
                        <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        @if ($order->discount > 0)
                            <p><strong>Diskon:</strong> -Rp {{ number_format($order->discount, 0, ',', '.') }}</p>
                            <p class="text-base sm:text-lg font-bold text-teal-400">
                                <strong>Total Setelah Diskon:</strong> Rp
                                {{ number_format($order->totalAfterDiscount, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Aksi -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4 sm:pt-6 border-t border-gray-700">
                <a href="{{ route('admin.orders.index', ['slug' => $slug]) }}"
                    class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-600 hover:bg-gray-700 text-gray-200 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 text-center">
                    Kembali
                </a>
                <a href="{{ route('admin.orders.print', ['slug' => $slug, 'order_code' => $order->order_code]) }}"
                    class="px-4 sm:px-6 py-2 sm:py-3 bg-teal-500 hover:bg-teal-600 text-white rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 text-center">
                    <i class="fas fa-print mr-2"></i> Cetak
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('select[name="status"]').addEventListener('change', function(e) {
            Swal.fire({
                title: 'Ubah Status Pesanan?',
                text: `Apakah Anda yakin ingin mengubah status menjadi "${e.target.options[e.target.selectedIndex].text}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ubah',
                cancelButtonText: 'Batal',
                background: '#1f2937',
                customClass: {
                    title: 'text-coral-500',
                    content: 'text-gray-300',
                    confirmButton: 'bg-teal-500 hover:bg-teal-600 text-white',
                    cancelButton: 'bg-gray-600 hover:bg-gray-700 text-gray-200'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.closest('form').submit();
                } else {
                    e.target.value = '{{ $order->status }}'; // Revert selection
                }
            });
        });
    </script>
@endpush
