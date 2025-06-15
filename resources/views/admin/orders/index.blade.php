@extends('layouts.admin')

@section('title')
    Daftar Pesanan - {{ $mitra->mitra_name }} - EvoKasir
@endsection
@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-7xl">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-6 sm:mb-8 animate-text-reveal">Daftar Pesanan</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="mb-6 bg-teal-500/20 border border-teal-400/30 text-teal-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <!-- Orders Table -->
        <div class="bg-gray-800/90 backdrop-blur-md shadow-lg rounded-xl overflow-x-auto p-4 sm:p-6">
            <table class="w-full table-auto text-left text-sm sm:text-base whitespace-nowrap">
                <thead class="bg-gray-700/50 border-b border-gray-600 text-gray-300">
                    <tr>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">#</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Kode Pesanan</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Tanggal</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Meja</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Total</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Metode Pembayaran</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Status Pembayaran</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Status Pesanan</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition-all duration-200">
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                {{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-teal-400">
                                {{ $order->order_code ?? '-' }}
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                {{ $order->table->table_name ?? '-' }}
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300 font-semibold">
                                {{ Str::upper($order->payment_method) ?? '-' }}
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6">
                                @php
                                    $paymentStatusLabel = [
                                        1 => ['text' => 'Menunggu Pembayaran', 'color' => 'bg-yellow-500'],
                                        2 => ['text' => 'Pembayaran Berhasil', 'color' => 'bg-teal-500'],
                                        3 => ['text' => 'Pembayaran Gagal', 'color' => 'bg-red-500'],
                                        4 => ['text' => 'Pembayaran Expired', 'color' => 'bg-gray-500'],
                                    ];
                                    $pStatus = $paymentStatusLabel[$order->payment_status] ?? [
                                        'text' => 'Tidak Diketahui',
                                        'color' => 'bg-gray-400',
                                    ];
                                @endphp
                                <span
                                    class="inline-block px-2 sm:px-3 py-1 rounded-full text-white text-xs sm:text-sm text-center {{ $pStatus['color'] }}">
                                    {{ $pStatus['text'] }}
                                </span>
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-400',
                                        'completed' => 'bg-teal-500',
                                        'cancelled' => 'bg-red-500',
                                    ];
                                    $color = $statusColors[$order->status] ?? 'bg-gray-400';
                                @endphp
                                <span
                                    class="px-2 sm:px-3 py-1 rounded-full text-white text-xs sm:text-sm {{ $color }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6">
                                <div class="flex gap-2 flex-wrap">
                                    <a href="{{ route('admin.orders.detail', ['slug' => $slug, 'order_code' => $order->order_code]) }}"
                                        class="px-3 sm:px-4 py-1 sm:py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg shadow-md text-xs sm:text-sm font-semibold transition-all duration-200">
                                        Detail
                                    </a>
                                    <form
                                        action="{{ route('admin.orders.destroy', ['slug' => $slug, 'id' => $order->id]) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 sm:px-4 py-1 sm:py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-md text-xs sm:text-sm font-semibold transition-all duration-200"
                                            onclick="return confirmDelete(event)">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-6 sm:py-8 text-center text-gray-400">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="py-4 sm:py-6 px-4 sm:px-6">
                @if ($orders->hasPages())
                    {{ $orders->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Pesanan?',
                text: 'Pesanan ini akan dihapus permanen. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                background: '#1f2937',
                customClass: {
                    title: 'text-coral-500',
                    content: 'text-gray-300',
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white',
                    cancelButton: 'bg-gray-600 hover:bg-gray-700 text-gray-200'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit();
                }
            });
            return false;
        }
    </script>
@endpush
