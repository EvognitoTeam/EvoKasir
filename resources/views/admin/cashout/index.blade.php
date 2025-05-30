@extends('layouts.admin')

@section('title')
    Cashout - {{ $mitra->mitra_name }}
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-5xl mx-auto bg-gray-800 rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="flex items-center space-x-3 mb-8">
                <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white">Cashout</h1>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div id="success-alert"
                    class="flex items-center justify-between p-4 mb-4 text-sm sm:text-base text-teal-400 bg-teal-500/20 border border-teal-400/30 rounded-xl shadow-lg transition-opacity duration-500 animate-fade-in"
                    role="alert">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-lg sm:text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="document.getElementById('success-alert').remove();"
                        class="text-teal-400 hover:text-teal-300 focus:outline-none">
                        <i class="fas fa-times text-lg sm:text-xl"></i>
                    </button>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm sm:text-base text-red-400 bg-red-500/20 border border-red-400/30 rounded-xl shadow-lg animate-fade-in"
                    role="alert">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-exclamation-circle text-lg sm:text-xl"></i>
                        <strong>Terjadi kesalahan:</strong>
                    </div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Konten Utama -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Card Pendapatan -->
                <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                    <div class="flex items-center space-x-3 mb-4">
                        <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-white">Total Pendapatan</h2>
                    </div>
                    <p class="text-3xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-400 mt-2">Pendapatan dari semua pesanan yang diselesaikan.</p>
                </div>

                <!-- Card Jumlah Cashout -->
                <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                    <div class="flex items-center space-x-3 mb-4">
                        <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-white">Jumlah Tersedia untuk Cashout</h2>
                    </div>
                    <p class="text-3xl font-bold text-white">Rp {{ number_format($availableCashout, 0, ',', '.') }}</p>
                    <div class="text-sm text-gray-400 mt-2">
                        <p>Biaya Midtrans (0.7%): Rp {{ number_format($midtransFee, 0, ',', '.') }}</p>
                        <p>Biaya Platform (15%): Rp {{ number_format($platformFee, 0, ',', '.') }}</p>
                        <p class="mt-1">Dana yang dapat ditarik setelah biaya Midtrans (0.7%) dan platform (15%).</p>
                    </div>
                    <div class="mt-4">
                        @php
                            $canCashout = $availableCashout >= 100000;
                        @endphp

                        {{-- <a href="{{ $canCashout ? route('admin.cashout.create', ['slug' => $mitra->mitra_slug]) : 'javascript:void(0)' }}"
                            class="inline-flex items-center px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg transition duration-300
          {{ $canCashout ? 'hover:bg-teal-700' : 'opacity-50 cursor-not-allowed pointer-events-none' }}">
                            Ajukan Cashout
                        </a> --}}
                        <form action="{{ route('admin.cashout.store', ['slug' => $mitra->mitra_slug]) }}" method="POST">
                            @csrf

                            <input type="hidden" name="amount" id="amount" value="{{ $availableCashout }}">
                            <div class="mt-6">
                                <button type="submit" {{ !$canCashout ? 'disabled' : '' }}
                                    class="inline-flex items-center px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg transition duration-300
          {{ $canCashout ? 'hover:bg-teal-700' : 'opacity-50 cursor-not-allowed pointer-events-none' }}">
                                    Ajukan Cashout
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Cashout -->
            <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center space-x-3 mb-4">
                    <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-white">Riwayat Cashout</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-300">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="py-3 px-4 text-sm font-medium">Tanggal</th>
                                <th class="py-3 px-4 text-sm font-medium">Jumlah</th>
                                <th class="py-3 px-4 text-sm font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cashouts as $cashout)
                                <tr class="border-b border-gray-800">
                                    <td class="py-3 px-4 text-sm">{{ $cashout->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3 px-4 text-sm">Rp {{ number_format($cashout->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $cashout->status == 'approved' ? 'bg-green-500 text-white' : ($cashout->status === 'pending' ? 'bg-yellow-500 text-gray-800' : 'bg-red-500 text-white') }}">
                                            {{ ucfirst($cashout->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="text-nowrap-3" class="text-sm text-center text-500">Belum ada pengajuan
                                        cashout.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
