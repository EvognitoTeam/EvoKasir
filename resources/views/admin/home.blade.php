@extends('layouts.admin')

@section('title')
    Dashboard - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6 sm:space-y-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 animate-text-reveal">Dashboard</h1>

        <!-- Summary Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Card for Total Produk -->
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <h2 class="text-gray-300 text-sm sm:text-base font-semibold">Total Produk</h2>
                <p class="text-lg sm:text-xl font-bold text-teal-400 mt-2">{{ $totalProduk }}</p>
            </div>
            <!-- Card for Total Transaksi -->
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <h2 class="text-gray-300 text-sm sm:text-base font-semibold">Total Transaksi</h2>
                <p class="text-lg sm:text-xl font-bold text-teal-400 mt-2">{{ $totalTransaksi }}</p>
            </div>
            <!-- Card for Pendapatan Hari Ini -->
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <h2 class="text-gray-300 text-sm sm:text-base font-semibold">Pendapatan Hari Ini</h2>
                <p class="text-lg sm:text-xl font-bold text-teal-400 mt-2">Rp
                    {{ number_format($pendapatanHarian, 0, ',', '.') }}</p>
            </div>
            <!-- Card for Pendapatan Bulan Ini -->
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <h2 class="text-gray-300 text-sm sm:text-base font-semibold">Pendapatan Bulan Ini</h2>
                <p class="text-lg sm:text-xl font-bold text-teal-400 mt-2">Rp
                    {{ number_format($pendapatanBulanan, 0, ',', '.') }}</p>
            </div>
            <!-- Card for Total Pendapatan -->
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <h2 class="text-gray-300 text-sm sm:text-base font-semibold">Total Pendapatan</h2>
                <p class="text-lg sm:text-xl font-bold text-teal-400 mt-2">Rp
                    {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Graph Section -->
        <h2 class="text-xl sm:text-2xl font-bold text-coral-500 mt-6 sm:mt-8 mb-4 sm:mb-6">Grafik Pendapatan</h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Monthly Earnings Chart -->
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-300 mb-4">Pendapatan Bulanan ({{ date('Y') }})
                </h3>
                <canvas id="monthlyChart" class="w-full" height="200"></canvas>
            </div>
            <!-- Weekly Earnings Chart -->
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-300 mb-4">Pendapatan Mingguan</h3>
                <canvas id="weeklyChart" class="w-full" height="200"></canvas>
            </div>
            <!-- Yearly Earnings Chart -->
            <div
                class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-300 mb-4">Pendapatan Tahunan</h3>
                <canvas id="yearlyChart" class="w-full" height="200"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Data yearly earnings from backend (pastikan ini dikirim dari controller)
        const yearlyEarnings = @json($yearlyEarnings);

        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');

        // Monthly Chart
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan Bulanan (Rp)',
                    data: [
                        @for ($i = 1; $i <= 12; $i++)
                            {{ $monthlyEarnings[$i] ?? 0 }},
                        @endfor
                    ],
                    backgroundColor: '#2dd4bf', // Teal-400
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#d1d5db'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#d1d5db'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#d1d5db',
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        // Weekly Chart
        const weeklyChart = new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($weeklyEarnings as $date => $total)
                        '{{ \Carbon\Carbon::parse($date)->format('D, d M') }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Pendapatan Harian (Rp)',
                    data: [
                        @foreach ($weeklyEarnings as $total)
                            {{ $total }},
                        @endforeach
                    ],
                    fill: false,
                    borderColor: '#f87171', // Coral-500
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 5,
                    pointBackgroundColor: '#f87171'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#d1d5db'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#d1d5db'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#d1d5db',
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        // Yearly Chart
        const yearlyLabels = Object.keys(yearlyEarnings);
        const yearlyData = Object.values(yearlyEarnings);

        const yearlyChart = new Chart(yearlyCtx, {
            type: 'bar',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Pendapatan Tahunan (Rp)',
                    data: yearlyData,
                    backgroundColor: '#facc15', // Kuning
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#d1d5db'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#d1d5db'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#d1d5db',
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
@endpush
