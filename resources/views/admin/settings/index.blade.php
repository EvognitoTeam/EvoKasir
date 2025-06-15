@extends('layouts.admin')

@section('title', 'Pengaturan - EvoKasir')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-8 space-y-6 sm:space-y-8 bg-transparent relative z-10">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-4 sm:mb-6 flex items-center gap-2">
            <i class="fas fa-cog text-lg sm:text-xl"></i> Pengaturan
        </h1>

        @if (session('success'))
            <div id="successMessage"
                class="bg-teal-500/20 border border-teal-400/30 text-teal-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg mb-4 sm:mb-6 transition-opacity duration-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="errorMessage"
                class="bg-red-500/20 border border-red-400/30 text-red-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg mb-4 sm:mb-6 transition-opacity duration-300">
                {{ session('error') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div
                class="p-4 mb-6 text-sm sm:text-base text-red-400 bg-red-500/20 border border-red-400/30 rounded-xl shadow-lg animate-fade-in">
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

        <form action="{{ route('admin.setting.save', ['slug' => $slug]) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            {{-- Pilih suara --}}
            <div>
                <label for="notif_sound" class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">Pilih Suara
                    Notifikasi</label>
                <select name="notif_sound" id="notif_sound"
                    class="w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200">
                    <option value="sounds/ding.mp3" {{ $notifSound === 'sounds/ding.mp3' ? 'selected' : '' }}>Default
                    </option>
                    <option value="sounds/success-chime.mp3"
                        {{ $notifSound === 'sounds/success-chime.mp3' ? 'selected' : '' }}>Chime</option>
                    <option value="sounds/alert.mp3" {{ $notifSound === 'sounds/alert.mp3' ? 'selected' : '' }}>Alert
                    </option>
                    <option value="custom" {{ str_starts_with($notifSound, 'sounds/custom/') ? 'selected' : '' }}>Custom
                        Upload</option>
                </select>
            </div>

            {{-- Upload suara custom --}}
            <div id="custom_sound_section" style="display: none;">
                <label class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">Upload Suara Kustom</label>
                <input type="file" name="custom_sound" accept="audio/mpeg"
                    class="block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200">
                @if ($notifSound && str_starts_with($notifSound, 'sounds/custom/'))
                    <audio controls class="mt-2 w-full">
                        <source src="{{ asset('storage/' . $notifSound) }}" type="audio/mpeg">
                        Browser tidak mendukung audio.
                    </audio>
                @endif
            </div>

            <button type="submit"
                class="bg-teal-500 hover:bg-teal-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                Simpan
            </button>
        </form>

        {{-- Link ke pengaturan struk --}}
        <div class="mt-6 sm:mt-8">
            <a href="{{ route('admin.print-setting', ['slug' => $slug]) }}"
                class="inline-block bg-gray-700 hover:bg-gray-600 text-gray-200 px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200">
                Atur Struk Pembelian
            </a>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-4 sm:mb-6 flex items-center gap-2">
            <i class="fas fa-credit-card text-lg sm:text-xl"></i> Pengaturan Rekening
        </h1>
        @php
            use Illuminate\Support\Carbon;

            $rekAt = $mitra->rek_added_at ? Carbon::parse($mitra->rek_added_at) : null;
            $canEditAt = $rekAt ? $rekAt->copy()->addDays(7) : null;
            $isDisabled = $canEditAt && now()->lessThan($canEditAt);
        @endphp

        @if (Auth::user()->role == 'Owner')
            <form action="{{ route('admin.setting.rekening', ['slug' => $slug]) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label for="nama_rek" class="block text-sm font-medium text-white mb-1">Nama Rekening</label>
                    <input type="text" id="nama_rek" name="nama_rek"
                        value="{{ old('nama_rek', $mitra->nama_rek ?? '') }}" {{ $isDisabled ? 'disabled' : '' }}
                        class="w-full rounded-lg border px-4 py-3 text-sm text-white placeholder-gray-400 
                focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent
                bg-gray-800 border-gray-600 disabled:bg-gray-700 disabled:cursor-not-allowed"
                        placeholder="Evognito Team" autocomplete="off">
                    @error('nama_rek')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_rek" class="block text-sm font-medium text-white mb-1">Nomor Rekening</label>
                    <input type="text" id="no_rek" name="no_rek" value="{{ old('no_rek', $mitra->no_rek ?? '') }}"
                        {{ $isDisabled ? 'disabled' : '' }}
                        class="w-full rounded-lg border px-4 py-3 text-sm text-white placeholder-gray-400 
                focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent
                bg-gray-800 border-gray-600 disabled:bg-gray-700 disabled:cursor-not-allowed"
                        placeholder="1234567890" autocomplete="off">
                    @error('no_rek')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" {{ $isDisabled ? 'disabled' : '' }}
                    class="w-full rounded-lg px-4 py-3 text-sm font-semibold 
            bg-gradient-to-r from-teal-500 to-green-500 hover:from-teal-600 hover:to-green-600
            disabled:bg-gray-600 disabled:cursor-not-allowed text-white transition-all duration-200">
                    Simpan Rekening
                </button>

                @if ($isDisabled)
                    <p class="text-yellow-400 text-center text-sm mt-3">
                        Anda dapat mengubah rekening kembali pada:
                        <strong>{{ $canEditAt->locale('id')->translatedFormat('d F Y H:i') }}</strong>
                    </p>
                @endif
            </form>
        @else
            <p class="text-center text-gray-400">Anda tidak memiliki akses ke pengaturan ini.</p>
        @endif

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Settings page loaded, checking geometric background');
                const geoBackground = document.querySelector('.fixed.inset-0');
                if (geoBackground) {
                    console.log('Geometric background element found');
                    console.log('Opacity:', geoBackground.style.opacity);
                    console.log('Z-index:', geoBackground.style.zIndex);
                    console.log('Computed display:', window.getComputedStyle(geoBackground).display);
                } else {
                    console.error('Geometric background element not found');
                }

                function toggleCustomSoundSection() {
                    const selected = document.getElementById('notif_sound').value;
                    const section = document.getElementById('custom_sound_section');
                    section.style.display = (selected === 'custom') ? 'block' : 'none';
                    console.log('Custom sound section display:', section.style.display);
                }

                document.getElementById('notif_sound').addEventListener('change', toggleCustomSoundSection);
                toggleCustomSoundSection();

                // Auto-hide success message
                const successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    console.log('Success message found, will hide after 3 seconds');
                    setTimeout(() => {
                        successMessage.classList.add('hidden');
                        console.log('Success message hidden');
                    }, 3000);
                }

                // Debug form submission
                document.querySelector('form').addEventListener('submit', function(e) {
                    console.log('Settings form submission triggered');
                    console.log('Form action:', this.action);
                });
            });
        </script>
    @endpush
@endsection
