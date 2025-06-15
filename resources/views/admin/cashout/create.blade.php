@extends('layouts.admin')

@section('title')
    Ajukan Cashout - {{ $mitra->mitra_name }}
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl mx-auto bg-gray-800 rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="flex items-center space-x-3 mb-8">
                <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white">Ajukan Cashout</h1>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.cashout.store', ['slug' => $mitra->mitra_slug]) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-semibold text-gray-300">Jumlah Cashout</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">Rp</span>
                        <input type="text" name="amount_display" id="amount_display"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-700 rounded-lg bg-gray-900 text-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200"
                            placeholder="1.000.000" required oninput="formatRupiah(this)" autocomplete="off">
                        <input type="hidden" name="amount" id="amount" value="{{ old('amount') }}">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Minimum Rp100.000, Maksimum
                        Rp{{ number_format($availableCashout, 0, ',', '.') }}</p>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full px-4 py-3 bg-teal-600 text-white font-semibold hover:bg-teal-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-300">
                        Ajukan Cashout
                    </button>
                </div>
            </form>

            <!-- Kembali -->
            <div class="mt-4 text-center">
                <a href="{{ route('admin.cashout.index', ['slug' => $mitra->mitra_slug]) }}"
                    class="text-sm text-gray-400 hover:text-teal-400">Kembali ke Cashout</a>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk format Rupiah -->
    <script>
        function formatRupiah(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
                input.value = value;
                document.getElementById('amount').value = parseInt(value.replace(/\./g, '')) || 0;
            } else {
                input.value = '';
                document.getElementById('amount').value = '';
            }
        }
    </script>
@endsection
