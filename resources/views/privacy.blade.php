@extends('layouts.main')

@section('title')
    Kebijakan Privasi
@endsection

@section('content')
    <!-- Header -->
    <header
        class="relative py-12 sm:py- py-16 bg-gradient-to-br from-indigo-600 via-blue-500 to-teal-400 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"
                preserveAspectRatio="xMidYMid slice">
                <defs>
                    <pattern id="hero-pattern" patternUnits="userSpaceOnUse" width="20" height="20">
                        <circle cx="10" cy="10" r="2" fill="white" stroke="white" />
                        <line x1="0" y1="20" x2="20" y2="0" stroke="white"
                            stroke-width="0.5" />
                    </pattern>
        </div>
        </defs>
        <rect width="100%" height="100%" fill="url(#hero-pattern)" class="animate-subtle-move" />
        </svg>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl font-bold mb-4 animate-text-reveal">
                Kebijakan Privasi
            </h1>
            <p class="text-base sm:text-lg text-gray-100 max-w-xl mx-auto animate-text-reveal"
                style="animation-delay: 0.2s;">
                Kami berkomitmen untuk melindungi privasi Anda. Pelajari bagaimana kami mengelola data Anda.
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-4 sm:p-6 bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg feature-card">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">1. Pendahuluan</h2>
                <p class="text-gray-600 text-sm sm:text-base mb-4">
                    Selamat datang di EvoKasir. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan,
                    menyimpan, dan melindungi informasi pribadi Anda saat menggunakan aplikasi kami. Dengan menggunakan
                    EvoKasir, Anda menyetujui praktik yang dijelaskan di bawah ini.
                </p>

                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">2. Data yang Kami Kumpulkan</h2>
                <p class="text-gray-600 text-sm sm:text-base mb-4">Kami dapat mengumpulkan informasi berikut:</p>
                <ul class="list-disc pl-5 text-gray-600 text-sm sm:text-base space-y-2 mb-4">
                    <li><strong>Data Identitas:</strong> Nama, alamat email, nomor telepon, dan informasi akun saat Anda
                        mendaftar.</li>
                    <li><strong>Data Transaksi:</strong> Detail pesanan, pembayaran, dan riwayat aktivitas di aplikasi.</li>
                    <li><strong>Data Teknis:</strong> Alamat IP, jenis perangkat, sistem operasi, dan data penggunaan
                        aplikasi.</li>
                    <li><strong>Data Lokasi:</strong> Lokasi umum untuk keperluan pengiriman atau layanan berbasis lokasi,
                        jika diizinkan.</li>
                </ul>

                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">3. Penggunaan Data</h2>
                <p class="text-gray-600 text-sm sm:text-base mb-4">Kami menggunakan data Anda untuk:</p>
                <ul class="list-disc pl-5 text-gray-600 text-sm sm:text-base space-y-2 mb-4">
                    <li>Menyediakan dan mengelola layanan EvoKasir, termasuk pemrosesan pesanan dan pembayaran.</li>
                    <li>Meningkatkan pengalaman pengguna melalui personalisasi dan analitik.</li>
                    <li>Mengirimkan pemberitahuan terkait pesanan, promosi, atau pembaruan layanan.</li>
                    <li>Mematuhi kewajiban hukum dan mencegah penyalahgunaan aplikasi.</li>
                </ul>

                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">4. Pembagian Data</h2>
                <p class="text-gray-600 text-sm sm:text-base mb-4">Kami tidak menjual data pribadi Anda. Data dapat
                    dibagikan dengan:</p>
                <ul class="list-disc pl-5 text-gray-600 text-sm sm:text-base space-y-2 mb-4">
                    <li><strong>Mitra Bisnis:</strong> Restoran atau penyedia layanan untuk memenuhi pesanan Anda.</li>
                    <li><strong>Penyedia Layanan:</strong> Pihak ketiga untuk hosting, analitik, atau pemrosesan pembayaran.
                    </li>
                    <li><strong>Otoritas Hukum:</strong> Jika diwajibkan oleh hukum atau untuk melindungi hak kami.</li>
                </ul>

                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">5. Hak Anda</h2>
                <p class="text-gray-600 text-sm sm:text-base mb-4">Anda memiliki hak untuk:</p>
                <ul class="list-disc pl-5 text-gray-600 text-sm sm:text-base space-y-2 mb-4">
                    <li>Mengakses, memperbarui, atau menghapus data pribadi Anda.</li>
                    <li>Menolak pemrosesan data untuk tujuan pemasaran.</li>
                    <li>Mengajukan keluhan kepada otoritas perlindungan data.</li>
                </ul>
                <p class="text-gray-600 text-sm sm:text-base mb-4">
                    Untuk menggunakan hak ini, hubungi kami melalui informasi di bawah.
                </p>

                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">6. Keamanan Data</h2>
                <p class="text-gray-600 text-sm sm:text-base mb-4">
                    Kami menggunakan langkah-langkah keamanan seperti enkripsi dan autentikasi untuk melindungi data Anda.
                    Namun, tidak ada sistem yang sepenuhnya aman, dan kami tidak dapat menjamin keamanan absolut.
                </p>

                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">7. Perubahan Kebijakan</h2>
                <p class="text-gray-600 text-sm sm:text-base mb-4">
                    Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan diberitahukan melalui
                    aplikasi atau email. Versi terbaru selalu tersedia di halaman ini.
                </p>

                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">8. Hubungi Kami</h2>
                <p class="text-gray-600 text-sm sm:text-base mb-4">
                    Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, hubungi kami di:
                </p>
                <ul class="list-none text-gray-600 text-sm sm:text-base space-y-2">
                    <li><strong>Email:</strong> <a href="mailto:chat.evognitoteam@gmail.com"
                            class="text-indigo-600 hover:text-indigo-500">chat.evognitoteam@gmail.com</a></li>
                    <li><strong>Telepon:</strong> +62 851 7677 3826</li>
                </ul>
            </div>
        </div>
    </section>
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

        @media (max-width: 640px) {
            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            header {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }

            h1 {
                font-size: 1.875rem;
            }

            h2 {
                font-size: 1.125rem;
            }

            p,
            li {
                font-size: 0.875rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
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
