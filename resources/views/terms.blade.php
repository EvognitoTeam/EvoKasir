@extends('layouts.main')

@section('title', 'Ketentuan Layanan')

@section('content')

    <div class="bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

            <div class="max-w-4xl mx-auto bg-white p-6 sm:p-10 rounded-xl shadow-lg">

                <div class="text-center mb-8 border-b pb-6">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Ketentuan Layanan EvoKasir</h1>
                    <p class="mt-2 text-sm text-gray-500">Terakhir diperbarui: 10 Juli 2025</p>
                </div>

                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-r-lg mb-8" role="alert">
                    <p class="font-bold">Disclaimer Penting</p>
                    <p class="text-sm">Dokumen ini adalah templat dan tidak boleh dianggap sebagai nasihat hukum yang final.
                        Kami sangat menyarankan Anda untuk berkonsultasi dengan profesional hukum guna memastikan dokumen
                        ini sesuai dengan yurisdiksi dan model bisnis spesifik Anda.</p>
                </div>

                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    <p>Selamat datang di EvoKasir! Ketentuan Layanan ("Ketentuan") ini mengatur akses Anda ke dan penggunaan
                        layanan kami, termasuk situs web, aplikasi, dan perangkat lunak lain yang kami sediakan (secara
                        kolektif disebut "**Layanan**").</p>
                    <p>Dengan mendaftar atau menggunakan Layanan kami, Anda setuju untuk terikat oleh Ketentuan ini. Jika
                        Anda tidak setuju dengan Ketentuan ini, Anda tidak boleh mengakses atau menggunakan Layanan kami.
                    </p>

                    <h2>1. Definisi</h2>
                    <ul>
                        <li><strong>"EvoKasir"</strong>, <strong>"kami"</strong>, atau <strong>"milik kami"</strong> merujuk
                            pada Evognito Team sebagai penyedia Layanan.</li>
                        <li><strong>"Pengguna"</strong>, <strong>"Anda"</strong>, atau <strong>"milik Anda"</strong> merujuk
                            pada individu atau entitas bisnis yang mendaftar dan menggunakan Layanan EvoKasir.</li>
                        <li><strong>"Akun"</strong> berarti akun yang Anda buat untuk mengakses Layanan kami.</li>
                        <li><strong>"Data Transaksi"</strong> merujuk pada informasi terkait penjualan, produk, dan
                            pembayaran yang Anda proses melalui Layanan kami.</li>
                    </ul>

                    <h2>2. Penggunaan Layanan</h2>
                    <p>Anda bertanggung jawab penuh atas Akun Anda dan semua aktivitas yang terjadi di dalamnya. Anda setuju
                        untuk:</p>
                    <ol>
                        <li>Menyediakan informasi yang akurat, terkini, dan lengkap selama proses pendaftaran.</li>
                        <li>Menjaga keamanan kata sandi Anda dan tidak membagikannya kepada pihak ketiga.</li>
                        <li>Menggunakan Layanan sesuai dengan hukum dan peraturan yang berlaku di Republik Indonesia.</li>
                        <li>Tidak menggunakan Layanan untuk tujuan ilegal, penipuan, atau aktivitas terlarang lainnya.</li>
                    </ol>

                    <h2>3. Biaya dan Pembayaran</h2>
                    <p>Kami menyediakan perangkat lunak (aplikasi kasir) EvoKasir kepada Anda secara **gratis**, tanpa biaya
                        langganan bulanan atau tahunan.</p>
                    <p>Biaya layanan kami didasarkan pada model **Merchant Discount Rate (MDR)** untuk setiap transaksi
                        non-tunai yang berhasil diproses melalui QRIS. Besaran MDR ditetapkan sesuai dengan peraturan yang
                        berlaku dari Bank Indonesia dan dapat berubah sewaktu-waktu. Anda setuju bahwa biaya MDR akan secara
                        otomatis dipotong dari setiap nominal transaksi yang masuk.</p>

                    <h2>4. Hak Kekayaan Intelektual</h2>
                    <p>Semua hak, kepemilikan, dan kepentingan dalam dan terhadap Layanan (termasuk namun tidak terbatas
                        pada perangkat lunak, logo, dan merek dagang) adalah dan akan tetap menjadi milik eksklusif EvoKasir
                        dan pemberi lisensinya. Anda tidak diberikan hak apa pun atas Layanan selain yang diizinkan secara
                        tegas oleh Ketentuan ini.</p>
                    <p>Data Transaksi yang Anda masukkan ke dalam sistem adalah milik Anda sepenuhnya. Kami tidak akan
                        mengklaim kepemilikan atas data Anda.</p>

                    <h2>5. Kebijakan Privasi</h2>
                    <p>Penggunaan Anda atas Layanan kami juga diatur oleh <a href="{{ url('/kebijakan-privasi') }}"
                            class="text-indigo-600 hover:underline">Kebijakan Privasi</a> kami, yang menjelaskan bagaimana
                        kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda. </p>

                    <h2>6. Pembatasan Tanggung Jawab</h2>
                    <p>Layanan kami disediakan "sebagaimana adanya" dan "sebagaimana tersedia" tanpa jaminan apa pun. Sejauh
                        yang diizinkan oleh hukum, EvoKasir tidak akan bertanggung jawab atas kerusakan tidak langsung,
                        insidental, atau konsekuensial, atau kehilangan keuntungan atau pendapatan, yang timbul dari
                        penggunaan Layanan oleh Anda.</p>

                    <h2>7. Penghentian</h2>
                    <p>Kami dapat menangguhkan atau menghentikan akses Anda ke Layanan kapan saja, dengan atau tanpa sebab,
                        jika Anda melanggar Ketentuan ini. Anda juga dapat berhenti menggunakan Layanan dan meminta
                        penutupan Akun Anda kapan saja.</p>

                    <h2>8. Perubahan Ketentuan</h2>
                    <p>Kami berhak untuk mengubah Ketentuan ini dari waktu ke waktu. Jika kami melakukan perubahan, kami
                        akan memberi tahu Anda dengan merevisi tanggal di bagian atas Ketentuan ini dan, dalam beberapa
                        kasus, kami mungkin memberikan pemberitahuan tambahan (seperti menambahkan pernyataan ke halaman
                        beranda kami atau mengirimi Anda email).</p>

                    <h2>9. Informasi Kontak</h2>
                    <p>Jika Anda memiliki pertanyaan tentang Ketentuan Layanan ini, silakan hubungi kami melalui email di:
                        <a href="mailto:chat.evognitoteam@gmail.com"
                            class="text-indigo-600 hover:underline">chat.evognitoteam@gmail.com</a>.</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* Styling tambahan untuk konten legal agar mudah dibaca */
        .prose h2 {
            @apply text-2xl font-bold text-gray-800 mt-8 mb-4 border-b pb-2;
        }

        .prose p,
        .prose li {
            @apply text-base text-gray-600;
        }

        .prose ul,
        .prose ol {
            @apply list-inside;
        }

        .prose ul li {
            @apply list-disc ml-4;
        }

        .prose ol li {
            @apply list-decimal ml-4;
        }
    </style>
@endpush
