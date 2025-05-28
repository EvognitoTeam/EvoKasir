@extends('layouts.app')

@section('title')
    Profil User - {{ $mitra->mitra_name }}
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-5xl mx-auto bg-gray-800 rounded-2xl shadow-2xl p-8">
            <!-- Header dengan Avatar -->
            <div class="text-center mb-12">
                <div class="relative inline-block">
                    <div
                        class="w-24 h-24 rounded-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold mx-auto">
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
                        class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 rounded-full border-2 border-gray-800"></span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white mt-4">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-gray-300 mt-2 text-lg">Membership di {{ $mitra->mitra_name }}</p>
            </div>

            <!-- Konten Utama: Dua Kolom di Desktop -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Kolom Kiri: Informasi Pengguna dan Poin -->
                <div class="space-y-6">
                    <!-- Card untuk Informasi Pengguna -->
                    <div class="bg-gray-900 rounded-xl p-6 border border-gray-700 overflow-hidden">
                        <h2 class="text-xl font-semibold text-white mb-4">Informasi Akun</h2>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Nama Lengkap</label>
                                    <p class="text-lg text-white">{{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div class="flex-1 w-full max-w-[calc(100%-3rem)]">
                                    <label class="block text-sm font-medium text-gray-300">Email</label>
                                    <p class="text-lg text-white break-words sm:break-normal max-w-full sm:max-w-none"
                                        title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Nomor Telepon</label>
                                    <p class="text-lg text-white">{{ Auth::user()->phone ?? 'Belum diatur' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card untuk Membership -->
                    <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                        <h2 class="text-xl font-semibold text-white mb-4">Membership</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300">Lyalty Points</label>
                                        <p class="text-2xl font-bold text-yellow-400">{{ $loyaltyPoints }} Poin</p>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-600 text-white">
                                    Member
                                </span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Loyalty ID</label>
                                    {{-- <p class="text-lg text-white">{{ $loyaltyId }}</p> --}}
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button data-modal-target="barcodeModal" data-modal-toggle="barcodeModal" type="button">
                                    <svg id="barcode" class="mx-auto max-w-full h-24 cursor-pointer"></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Riwayat Aktivitas -->
                <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                    <div class="flex items-center space-x-3 mb-4">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-white">Riwayat Aktivitas</h2>
                    </div>
                    <ul class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse ($activities as $activity)
                            <li class="flex items-start space-x-3 p-3 bg-gray-800 rounded-lg">
                                <span class="text-indigo-400">
                                    @if ($activity->activity_type === 'login')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                    @elseif ($activity->activity_type === 'order')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    @elseif ($activity->activity_type === 'points')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif ($activity->activity_type === 'register')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    @elseif ($activity->activity_type === 'logout')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m-4 4v1a3 3 0 003 3h7a3 3 0 003-3V7a3 3 0 00-3-3H6a3 3 0 00-3 3v1" />
                                        </svg>
                                    @endif
                                </span>
                                <div>
                                    <p class="text-sm text-white">
                                        {{ $activity->description }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $activity->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="text-sm text-gray-400 p-3">Belum ada aktivitas</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('user.edit.profile', ['slug' => $slug]) }}"
                    class="w-full sm:w-1/2 py-4 px-6 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition duration-300 text-center">
                    Edit Profil
                </a>
                <form method="POST" action="{{ route('user.logout', ['slug' => $slug]) }}" class="w-full sm:w-1/2">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 px-6 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition duration-300">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Barcode -->
    <div id="barcodeModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-gray-800 rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700 rounded-t">
                    <h3 class="text-xl font-semibold text-white">
                        Barcode Loyalty ID
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-600 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="barcodeModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 text-center">
                    <svg id="modalBarcode" class="mx-auto max-w-full h-48"></svg>
                    <p class="text-lg text-white mt-4">{{ $loyaltyId }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan JsBarcode dan Flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Barcode di halaman utama
            JsBarcode("#barcode", "{{ $loyaltyId }}", {
                format: "CODE128",
                background: "#1F2937",
                lineColor: "#FFFFFF",
                width: 2,
                height: 80,
                displayValue: true
            });

            // Barcode di modal
            JsBarcode("#modalBarcode", "{{ $loyaltyId }}", {
                format: "CODE128",
                background: "#1F2937",
                lineColor: "#FFFFFF",
                width: 3,
                height: 120,
                displayValue: false
            });
        });
    </script>
@endsection
