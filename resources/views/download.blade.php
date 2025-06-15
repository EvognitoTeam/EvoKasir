@extends('layouts.main')

@section('title', 'Download Aplikasi - Evokasir')

@section('content')
    <!-- Hero Section with Animated Background -->
    <section
        class="relative min-h-[70vh] sm:min-h-[80vh] flex items-center justify-center bg-gradient-to-br from-indigo-600 via-blue-500 to-teal-400 text-white overflow-hidden">
        <!-- Background Pattern -->
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
        <!-- Decorative Floating Elements -->
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
                📲 Download Aplikasi Evokasir
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-100 mb-6 sm:mb-8 max-w-xl   mx-auto animate-text-reveal"
                style="animation-delay: 0.2s;">
                Kelola bisnis Anda dengan aplikasi Evokasir yang cepat, mudah, dan handal.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="https://play.google.com/store/apps/details?id=id.my.evognito.evokasir" target="_blank"
                    class="text-indigo-600 font-semibold py-2 px-6 sm:py-3 sm:px-8 rounded-full shadow-lg hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 animate-button-reveal">
                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/id_badge_web_generic.png"
                        alt="Download di Google Play" class="h-12 hover:opacity-90 transition duration-300">
                </a>
                {{-- <a href="https://evokasir.com/download" target="_blank"
                    class="border-2 border-white text-white font-semibold py-2 px-6 sm:py-3 sm:px-8 rounded-full hover:bg-white hover:text-indigo-600 transform hover:scale-105 transition-all duration-300 animate-button-reveal"
                    style="animation-delay: 0.1s;">
                    Download APK
                </a> --}}
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2
                class="text-2xl sm:text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8 sm:mb-12 animate-text-reveal">
                Mengapa Memilih Aplikasi Evokasir?
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                <!-- Fitur 1 -->
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
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Antarmuka Intuitif</h3>
                    <p class="text-gray-600 text-sm sm:text-base text-center">Navigasi yang mudah untuk pengguna dari semua
                        level.</p>
                </div>
                <!-- Fitur 2 -->
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
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Laporan Real-Time</h3>
                    <p class="text-gray-600 text-sm sm:text-base text-center">Pantau penjualan dan stok secara langsung.</p>
                </div>
                <!-- Fitur 3 -->
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
                                d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6a2 2 0 110-4 2 2 0 010 4z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Integrasi Printer</h3>
                    <p class="text-gray-600 text-sm sm:text-base text-center">Cetak struk dengan mudah menggunakan printer
                        Bluetooth.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    {{-- <section class="py-12 sm:py-16 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2
                class="text-2xl sm:text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8 sm:mb-12 animate-text-reveal">
                Apa Kata Pengguna Aplikasi Kami
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="p-4 sm:p-6 bg-white rounded-xl shadow-lg testimonial-card">
                    <p class="text-gray-600 italic mb-4 text-sm sm:text-base">"Aplikasi Evokasir sangat membantu saya
                        mengelola pesanan dengan cepat!"</p>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                            R
                        </div>
                        <div class="ml-2 sm:ml-3">
                            <p class="font-semibold text-gray-800 text-sm sm:text-base">Rina Wulandari</p>
                            <p class="text-xs text-gray-500">Pemilik Warung Makan</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-6 bg-white rounded-xl shadow-lg testimonial-card">
                    <p class="text-gray-600 italic mb-4 text-sm sm:text-base">"Fitur laporan real-time sangat membantu
                        untuk memantau bisnis saya."</p>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                            B
                        </div>
                        <div class="ml-2 sm:ml-3">
                            <p class="font-semibold text-gray-800 text-sm sm:text-base">Budi Santoso</p>
                            <p class="text-xs text-gray-500">Pengusaha Kafe</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Call to Action Section -->
    <section class="py-12 sm:py-16 bg-gradient-to-r from-indigo-600 to-teal-400 text-white text-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 animate-text-reveal">
                Unduh Aplikasi Evokasir Sekarang
            </h2>
            <p class="text-base sm:text-lg text-gray-200 mb-6 max-w-xl mx-auto animate-text-reveal"
                style="animation-delay: 0.2s;">
                Mulai kelola bisnis Anda dengan lebih efisien hari ini!
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="https://play.google.com/store/apps/details?id=id.my.evognito.evokasir" target="_blank"
                    class="text-indigo-600 font-semibold py-2 px-6 sm:py-3 sm:px-8 rounded-full shadow-lg hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 animate-button-reveal">
                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/id_badge_web_generic.png"
                        alt="Download di Google Play" class="h-12 hover:opacity-90 transition duration-300">
                </a>

                {{-- <a href="https://evokasir.com/download" target="_blank"
                    class="border-2 border-white text-white font-semibold py-2 px-6 sm:py-3 sm:px-8 rounded-full hover:bg-white hover:text-indigo-600 transform hover:scale-105 transition-all duration-300 animate-button-reveal"
                    style="animation-delay: 0.1s;">
                    Download APK
                </a> --}}
            </div>
            <div class="text-sm text-gray-200 mt-6">
                <p>Butuh bantuan? Hubungi kami di:</p>
                <p>Email: <a href="mailto:chat.evognitoteam@gmail.com" class="underline">chat.evognitoteam@gmail.com</a>
                </p>
                <p>Telepon: +62-851-7677-3826</p>
            </div>
        </div>
    </section>

@endsection

<style>
    /* Animations */
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

    .feature-card,
    .testimonial-card {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .feature-card.visible,
    .testimonial-card.visible {
        opacity: 1;
        transform: translateY(0);
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>

<script>
    // Intersection Observer for animations
    document.addEventListener('DOMContentLoaded', () => {
        const elements = document.querySelectorAll('.feature-card, .testimonial-card');
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
