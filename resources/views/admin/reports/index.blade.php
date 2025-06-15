@extends('layouts.admin')

@section('title')
    Laporan Pemesanan - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-6xl space-y-6 sm:space-y-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 animate-text-reveal flex items-center gap-2 sm:gap-3">
            <i class="fas fa-chart-line text-lg sm:text-xl"></i> Laporan Pemesanan - {{ $mitra->mitra_name }}
        </h1>

        <!-- Total Pendapatan Keseluruhan -->
        <div class="bg-gradient-to-r from-teal-500 to-coral-500 text-white p-4 sm:p-6 rounded-xl shadow-lg animate-scale-in">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-100">Total Pendapatan Keseluruhan</h2>
            <p class="text-2xl sm:text-3xl font-bold mt-2 sm:mt-3">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>

        <!-- Ringkasan Order (Harian, Mingguan, Bulanan) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 animate-fade-in">
                <h2 class="text-base sm:text-lg font-semibold text-gray-300 mb-2 sm:mb-3 flex items-center gap-2">
                    <i class="fas fa-calendar-day text-teal-400"></i> Harian
                </h2>
                <p class="text-sm sm:text-base text-gray-400">Transaksi: <span
                        class="font-bold text-gray-200">{{ $daily['transactions'] }}</span></p>
                <p class="text-sm sm:text-base text-gray-400">Total: <span class="font-bold text-teal-400">Rp
                        {{ number_format($daily['income'], 0, ',', '.') }}</span></p>
            </div>
            <div class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 animate-fade-in"
                style="animation-delay: 0.1s;">
                <h2 class="text-base sm:text-lg font-semibold text-gray-300 mb-2 sm:mb-3 flex items-center gap-2">
                    <i class="fas fa-calendar-week text-teal-400"></i> Mingguan
                </h2>
                <p class="text-sm sm:text-base text-gray-400">Transaksi: <span
                        class="font-bold text-gray-200">{{ $weekly['transactions'] }}</span></p>
                <p class="text-sm sm:text-base text-gray-400">Total: <span class="font-bold text-teal-400">Rp
                        {{ number_format($weekly['income'], 0, ',', '.') }}</span></p>
            </div>
            <div class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 animate-fade-in"
                style="animation-delay: 0.2s;">
                <h2 class="text-base sm:text-lg font-semibold text-gray-300 mb-2 sm:mb-3 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-teal-400"></i> Bulanan
                </h2>
                <p class="text-sm sm:text-base text-gray-400">Transaksi: <span
                        class="font-bold text-gray-200">{{ $monthly['transactions'] }}</span></p>
                <p class="text-sm sm:text-base text-gray-400">Total: <span class="font-bold text-teal-400">Rp
                        {{ number_format($monthly['income'], 0, ',', '.') }}</span></p>
            </div>
        </div>

        <!-- Total Pembayaran per Metode -->
        <div class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg animate-scale-in">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-300 mb-4 sm:mb-6 flex items-center gap-2">
                <i class="fas fa-credit-card text-teal-400"></i> Total Pembayaran (Cash & QRIS)
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                <div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-300 mb-2 sm:mb-3">Hari Ini</h3>
                    <p class="text-sm sm:text-base text-gray-400">Cash: <span class="font-bold text-teal-400">Rp
                            {{ number_format($cashToday, 0, ',', '.') }}</span></p>
                    <p class="text-sm sm:text-base text-gray-400">QRIS: <span class="font-bold text-teal-400">Rp
                            {{ number_format($qrisToday, 0, ',', '.') }}</span></p>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-300 mb-2 sm:mb-3">Minggu Ini</h3>
                    <p class="text-sm sm:text-base text-gray-400">Cash: <span class="font-bold text-teal-400">Rp
                            {{ number_format($cashWeek, 0, ',', '.') }}</span></p>
                    <p class="text-sm sm:text-base text-gray-400">QRIS: <span class="font-bold text-teal-400">Rp
                            {{ number_format($qrisWeek, 0, ',', '.') }}</span></p>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-300 mb-2 sm:mb-3">Bulan Ini</h3>
                    <p class="text-sm sm:text-base text-gray-400">Cash: <span class="font-bold text-teal-400">Rp
                            {{ number_format($cashTotal, 0, ',', '.') }}</span></p>
                    <p class="text-sm sm:text-base text-gray-400">QRIS: <span class="font-bold text-teal-400">Rp
                            {{ number_format($qrisTotal, 0, ',', '.') }}</span></p>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg animate-scale-in">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-300 mb-4 sm:mb-6 flex items-center gap-2">
                <i class="fas fa-fire text-teal-400"></i> Produk Paling Sering Dipesan
            </h2>
            @if ($mostOrderedProducts->count())
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-left text-sm sm:text-base">
                        <thead class="bg-gray-700/50 border-b border-gray-600 text-gray-300">
                            <tr>
                                <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">#</th>
                                <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Nama Produk</th>
                                <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Jumlah Dipesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mostOrderedProducts as $index => $product)
                                <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition-all duration-200">
                                    <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $index + 1 }}</td>
                                    <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $product['name'] }}</td>
                                    <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $product['quantity'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400 text-sm sm:text-base">Belum ada data pemesanan produk.</p>
            @endif
        </div>
    </div>
@endsection
