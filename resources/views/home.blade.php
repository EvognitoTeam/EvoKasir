@extends('layouts.main')

@section('title', 'Aplikasi Kasir Gratis untuk Bisnis Anda')

@section('content')

    <section class="relative min-h-[90vh] flex items-center justify-center text-white overflow-hidden">
        <div
            class="absolute inset-0 bg-gradient-to-br from-gray-900 via-indigo-900 to-teal-800 bg-[length:200%_200%] animate-background-pan z-0">
        </div>

        <div class="absolute inset-0 bg-[radial-gradient(#ffffff22_1px,transparent_1px)] [background-size:32px_32px]"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-4 leading-tight animate-fade-in-up">
                Aplikasi Kasir Gratis untuk Kembangkan Bisnis Anda
            </h1>
            <p class="text-lg sm:text-xl text-gray-300 mb-8 max-w-3xl mx-auto animate-fade-in-up"
                style="animation-delay: 0.2s;">
                Fokus pada rasa, biar kami yang urus transaksinya. Tanpa biaya bulanan, hanya potongan standar QRIS & fee
                cashout.
            </p>
            <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                <a href="/register"
                    class="inline-block bg-white text-indigo-700 font-bold py-3 px-10 rounded-full shadow-2xl hover:bg-gray-200 transform hover:scale-105 transition-all duration-300">
                    Daftar Gratis Sekarang
                </a>
            </div>
        </div>
    </section>

    <section id="features" class="py-16 sm:py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Semua yang Anda Butuhkan, Tanpa Biaya Tersembunyi
                </h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Dari kasir canggih hingga laporan lengkap, semuanya
                    tersedia gratis.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="group relative">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-teal-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-500">
                    </div>
                    <div class="relative p-6 bg-white rounded-2xl shadow-lg h-full ring-1 ring-gray-900/5">
                        <div
                            class="bg-indigo-100 text-indigo-600 rounded-lg w-12 h-12 flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Pesanan & Meja</h3>
                        <p class="text-gray-600">Catat pesanan dengan cepat, atur status meja, dan kirim pesanan langsung ke
                            dapur secara digital.</p>
                    </div>
                </div>

                <div class="group relative">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-teal-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-500">
                    </div>
                    <div class="relative p-6 bg-white rounded-2xl shadow-lg h-full ring-1 ring-gray-900/5">
                        <div class="bg-teal-100 text-teal-600 rounded-lg w-12 h-12 flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Penerimaan Pembayaran QRIS</h3>
                        <p class="text-gray-600">Terima pembayaran non-tunai dari semua e-wallet dan mobile banking dengan
                            mudah, cepat, dan aman.</p>
                    </div>
                </div>

                <div class="group relative">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-teal-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-500">
                    </div>
                    <div class="relative p-6 bg-white rounded-2xl shadow-lg h-full ring-1 ring-gray-900/5">
                        <div class="bg-sky-100 text-sky-600 rounded-lg w-12 h-12 flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan Penjualan Real-time</h3>
                        <p class="text-gray-600">Pantau performa bisnis Anda kapan saja dan di mana saja melalui dasbor
                            laporan yang lengkap dan mudah dibaca.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="relative bg-gradient-to-r from-indigo-600 to-teal-500 rounded-2xl p-8 sm:p-12 shadow-xl overflow-hidden text-center">
                <div
                    class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(#ffffff22_1px,transparent_1px)] [background-size:24px_24px] opacity-50">
                </div>
                <div class="relative">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Mulai Gunakan EvoKasir Hari Ini</h2>
                    <p class="text-lg text-indigo-100 mb-8 max-w-xl mx-auto">Daftar dalam 5 menit dan rasakan langsung
                        kemudahan mengelola bisnis Anda. Gratis, selamanya.</p>
                    <a href="/register"
                        class="inline-block bg-white text-indigo-600 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-gray-200 transform hover:scale-105 transition-all duration-300">
                        Buat Akun Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
