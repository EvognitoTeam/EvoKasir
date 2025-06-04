@extends('layouts.admin')

@section('title', 'Tambah Kategori - EvoKasir')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-4xl">
        <div class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 lg:p-8 rounded-xl shadow-lg animate-scale-in">
            <h2
                class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-6 sm:mb-8 animate-text-reveal flex items-center gap-2 sm:gap-3">
                <i class="fas fa-list text-lg sm:text-xl"></i> Tambah Kategori Baru
            </h2>

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

            <!-- Form -->
            <form action="{{ route('admin.categories.store', ['slug' => $slug]) }}" method="POST">
                @csrf

                <!-- Nama Meja -->
                <div class="mb-4 sm:mb-6">
                    <label for="category_name" class="block text-sm sm:text-base font-semibold text-gray-300">Nama
                        Kategori</label>
                    <input type="text" name="category_name" id="category_name" value="{{ old('category_name') }}"
                        required
                        class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('table_name') border-red-500 @enderror">
                    @error('category_name')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
                    <a href="{{ route('admin.categories.index', ['slug' => $slug]) }}"
                        class="bg-gray-600 hover:bg-gray-700 text-gray-200 font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition-all duration-200 text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Kategori?',
                text: 'Pastikan nama kategori sudah benar.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                background: '#1f2937',
                customClass: {
                    title: 'text-coral-500',
                    content: 'text-gray-300',
                    confirmButton: 'bg-teal-500 hover:bg-teal-600 text-white',
                    cancelButton: 'bg-gray-600 hover:bg-gray-700 text-gray-200'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
