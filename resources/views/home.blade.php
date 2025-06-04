@extends('layouts.main')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section with Animated Background -->
    <section
        class="relative min-h-[70vh] sm:min-h-[80vh] flex items-center justify-center bg-gradient-to-br from-indigo-600 via-blue-500 to-teal-400 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"
                preserveAspectRatio="xMidYMid slice">
                <defs>
                    <pattern id="hero-pattern" patternUnits="userSpaceOnUse" width="20" height="20">
                        <circle cx="10" cy="10" r="2" fill="white" />
                        <line x1="0" y1="20" x2="20" y2="0" stroke="white"
                            stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hero-pattern)" class="animate-subtle-move" />
            </svg>
        </div>
        <div
            class="absolute top-10 left-10 w-20 h-20 sm:w-32 sm:h-32 bg-teal-300 rounded-full opacity-20 animate-float hidden sm:block">
        </div>
        <div
            class="absolute bottom-10 right-10 w-24 h-24 sm:w-48 sm:h-48 bg-indigo-300 rounded-full opacity-20 animate-float-slow hidden sm:block">
        </div>
        <div class="absolute top-1/3 right-1/4 w-16 h-16 sm:w-24 sm:h-24 bg-blue-300 rounded-full opacity-15 animate-float hidden sm:block"
            style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/3 left-1/4 w-20 h-20 sm:w-36 sm:h-36 bg-teal-200 rounded-full opacity-15 animate-float-slow hidden sm:block"
            style="animation-delay: 0.5s;"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 leading-tight animate-text-reveal">
                EvoKasir: Solusi Bisnis Modern
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-100 mb-6 sm:mb-8 max-w-xl mx-auto animate-text-reveal"
                style="animation-delay: 0.2s;">
                Kelola bisnis Anda dengan cepat, mudah, dan handal.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/register"
                    class="bg-white text-indigo-600 font-semibold py-2 px-6 sm:py-3 sm:px-8 rounded-full shadow-lg hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 animate-button-reveal">
                    Mulai Sekarang
                </a>
                <a href="#features"
                    class="scroll-to-features border-2 border-white text-white font-semibold py-2 px-6 sm:py-3 sm:px-8 rounded-full hover:bg-white hover:text-indigo-600 transform hover:scale-105 transition-all duration-300 animate-button-reveal"
                    style="animation-delay: 0.1s;">
                    Lihat Fitur
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2
                class="text-2xl sm:text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8 sm:mb-12 animate-text-reveal">
                Fitur Unggulan Kami
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                <div
                    class="group relative p-4 sm:p-6 bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 feature-card">
                    <div
                        class="absolute inset-0 bg-indigo-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-500">
                    </div>
                    <div
                        class="text-indigo-600 mb-3 sm:mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Manajemen Produk</h3>
                    <p class="text-gray-600 text-sm sm:text-base text-center">Atur produk, kategori, dan stok dengan
                        antarmuka intuitif.</p>
                </div>
                <div
                    class="group relative p-4 sm:p-6 bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 feature-card">
                    <div
                        class="absolute inset-0 bg-indigo-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-500">
                    </div>
                    <div
                        class="text-indigo-600 mb-3 sm:mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Laporan Penjualan</h3>
                    <p class="text-gray-600 text-sm sm:text-base text-center">Wawasan bisnis melalui laporan real-time.</p>
                </div>
                <div
                    class="group relative p-4 sm:p-6 bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 feature-card">
                    <div
                        class="absolute inset-0 bg-indigo-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-500">
                    </div>
                    <div
                        class="text-indigo-600 mb-3 sm:mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Integrasi Membership</h3>
                    <p class="text-gray-600 text-sm sm:text-base text-center">Tingkatkan loyalitas pelanggan dengan sistem
                        keanggotaan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-12 sm:py-16 bg-gradient-to-r from-indigo-600 to-teal-400 text-white text-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 animate-text-reveal">
                Optimalkan Bisnis Anda Sekarang
            </h2>
            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl mx-auto animate-text-reveal"
                style="animation-delay: 0.2s;">
                Bergabunglah dengan ribuan bisnis yang mempercayai EvoKasir.
            </p>
            <a href="/register"
                class="inline-block bg-white text-indigo-600 font-semibold py-2 px-6 sm:py-3 sm:px-8 rounded-full shadow-lg hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 animate-button-reveal">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-gray-800 py-6 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm sm:text-base mb-4">
                © {{ date('Y') }} EvoKasir. Semua hak dilindungi.
            </p>
            <a href="{{ route('privacy.policy') }}" class="text-teal-400 hover:text-teal-300 text-sm sm:text-base">
                Kebijakan Privasi
            </a>
        </div>
    </footer>
@endsection

@push('styles')
    <style>
        @keyframes textReveal {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes buttonReveal {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes floatSlow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-30px);
            }
        }

        @keyframes subtleMove {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(10px, 10px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-text-reveal {
            animation: textReveal 0.8s ease-out forwards;
        }

        .animate-button-reveal {
            animation: buttonReveal 0.6s ease-out forwards;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: floatSlow 8s ease-in-out infinite;
        }

        .animate-subtle-move {
            animation: subtleMove 20s ease-in-out infinite;
        }

        .feature-card {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .feature-card.visible {
            opacity: 1;
            transform: translateY(0);
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.querySelectorAll('.scroll-to-features').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.feature-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('visible');
                        }, index * 150);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });

            elements.forEach(element => observer.observe(element));
        });
    </script>
@endpush
