@extends('layouts.main')

@section('title', 'Daftar Akun Baru')

@section('content')
    <section class="min-h-screen w-full flex items-center justify-center p-4 py-8">
        <div
            class="absolute inset-0 bg-gradient-to-br from-gray-900 via-indigo-900 to-teal-800 bg-[length:200%_200%] animate-background-pan z-0">
        </div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff22_1px,transparent_1px)] [background-size:32px_32px]"></div>

        <div
            class="relative w-full max-w-4xl bg-white/95 backdrop-blur-lg p-6 sm:p-8 rounded-2xl shadow-xl animate-fade-in-up">

            <div class="text-center mb-8">
                <a href="/" class="inline-block mb-4">
                    <img src="/storage/logo/6814f4b762b42.png" alt="EvoKasir Logo" class="w-12 h-12 mx-auto">
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Buat Akun EvoKasir Anda</h2>
                <p class="text-gray-600 mt-1">Langkah pertama untuk mentransformasi bisnis Anda.</p>
            </div>

            <form action="{{ route('admin.register') }}" method="POST" id="register-form">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-300 pb-2">Informasi Usaha</h3>

                        <div class="relative">
                            <input type="text" name="business_name" id="business_name" required
                                value="{{ old('business_name') }}"
                                class="peer w-full p-3 pt-6 bg-gray-50/50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                                placeholder="Nama Usaha Anda">
                            <label for="business_name"
                                class="absolute left-3 top-1 text-gray-500 text-xs transition-all duration-300
                                      peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 
                                      peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-600">
                                Nama Usaha
                            </label>
                            @error('business_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="relative">
                            <input type="text" name="business_tagline" id="business_tagline" required
                                value="{{ old('business_tagline') }}"
                                class="peer w-full p-3 pt-6 bg-gray-50/50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                                placeholder="Cth: Kopi Terbaik di Kota">
                            <label for="business_tagline"
                                class="absolute left-3 top-1 text-gray-500 text-xs transition-all duration-300
                                      peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 
                                      peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-600">
                                Tagline Usaha
                            </label>
                            @error('business_tagline')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="relative">
                            <textarea name="business_address" id="business_address" required rows="4"
                                class="peer w-full p-3 pt-6 bg-gray-50/50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                                placeholder="Alamat Lengkap Usaha Anda">{{ old('business_address') }}</textarea>
                            <label for="business_address"
                                class="absolute left-3 top-1 text-gray-500 text-xs transition-all duration-300
                                      peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 
                                      peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-600">
                                Alamat Usaha
                            </label>
                            @error('business_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-300 pb-2">Informasi Akun</h3>

                        <div class="relative">
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                class="peer w-full p-3 pt-6 bg-gray-50/50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                                placeholder="Nama Lengkap Anda">
                            <label for="name"
                                class="absolute left-3 top-1 text-gray-500 text-xs transition-all duration-300
                                      peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 
                                      peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-600">
                                Nama Lengkap Pemilik
                            </label>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="relative">
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="peer w-full p-3 pt-6 bg-gray-50/50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                                placeholder="email@anda.com">
                            <label for="email"
                                class="absolute left-3 top-1 text-gray-500 text-xs transition-all duration-300
                                      peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 
                                      peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-600">
                                Alamat Email
                            </label>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="peer w-full p-3 pt-6 bg-gray-50/50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                                placeholder="Minimal 8 karakter">
                            <label for="password"
                                class="absolute left-3 top-1 text-gray-500 text-xs transition-all duration-300
                                      peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 
                                      peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-600">
                                Kata Sandi
                            </label>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="peer w-full p-3 pt-6 bg-gray-50/50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent"
                                placeholder="Ulangi kata sandi">
                            <label for="password_confirmation"
                                class="absolute left-3 top-1 text-gray-500 text-xs transition-all duration-300
                                      peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 
                                      peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-600">
                                Konfirmasi Kata Sandi
                            </label>
                        </div>
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-gradient-to-r from-indigo-600 to-teal-500 hover:from-indigo-700 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105 disabled:opacity-75 disabled:cursor-not-allowed">
                            <span id="button-text">Buat Akun Saya</span>
                            <svg id="loading-spinner" class="animate-spin h-5 w-5 text-white hidden"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                        <p class="mt-4 text-xs text-center text-gray-500">
                            Dengan mendaftar, Anda menyetujui <a href="{{ route('terms') }}"
                                class="font-medium text-indigo-600 hover:underline">Ketentuan Layanan</a> & <a
                                href="{{ route('privacy') }}"
                                class="font-medium text-indigo-600 hover:underline">Kebijakan
                                Privasi</a>
                            kami.
                        </p>
                    </div>

                </div>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="/login" class="font-bold text-indigo-600 hover:text-indigo-500 hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        document.getElementById('register-form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('loading-spinner');

            button.disabled = true;

            // Sembunyikan teks dan tampilkan spinner
            buttonText.style.display = 'none';
            spinner.classList.remove('hidden');
        });
    </script>
@endpush
