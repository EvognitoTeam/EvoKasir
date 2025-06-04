@extends('layouts.admin')

@section('title')
    Daftar Kategori - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-5xl space-y-6 sm:space-y-8">
        <h1
            class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-6 sm:mb-8 animate-text-reveal flex items-center gap-2 sm:gap-3">
            <i class="fas fa-list text-lg sm:text-xl"></i> Daftar Kategori - {{ $mitra->mitra_name }}
        </h1>

        <!-- Success Message -->
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="mb-6 bg-teal-500/20 border border-teal-400/30 text-teal-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add New Table Button -->
        <div class="flex justify-between items-center mb-6 sm:mb-8">
            <a href="{{ route('admin.categories.create', ['slug' => $slug]) }}"
                class="bg-teal-500 hover:bg-teal-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Tambah Kategori Baru
            </a>
        </div>

        <!-- Table List -->
        <div class="bg-gray-800/90 backdrop-blur-md rounded-xl shadow-lg overflow-x-auto animate-scale-in">
            <table class="w-full table-auto text-left text-sm sm:text-base">
                <thead class="bg-gray-700/50 border-b border-gray-600 text-gray-300">
                    <tr>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Nama Kategori</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition-all duration-200">
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $category->name }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-center">
                                <div class="flex justify-center gap-2 sm:gap-3">
                                    <a href="{{ route('admin.categories.edit', ['slug' => $slug, 'id' => $category->id]) }}"
                                        class="px-3 sm:px-4 py-1 sm:py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg shadow-md text-xs sm:text-sm font-semibold transition-all duration-200">
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('admin.table.destroy', ['slug' => $slug, 'id' => $category->id]) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 sm:px-4 py-1 sm:py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-md text-xs sm:text-sm font-semibold transition-all duration-200"
                                            onclick="return confirmDelete(event)">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-6 sm:py-8 text-center text-gray-400">Belum ada tabel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Tabel?',
                text: 'Tabel ini akan dihapus permanen. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                background: '#1f2937',
                customClass: {
                    title: 'text-coral-500',
                    content: 'text-gray-300',
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white',
                    cancelButton: 'bg-gray-600 hover:bg-gray-700 text-gray-200'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit();
                }
            });
            return false;
        }
    </script>
@endpush
