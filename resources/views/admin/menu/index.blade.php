@extends('layouts.admin')

@section('title')
    Daftar Menu - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6 sm:space-y-8">
        <!-- Success Message -->
        @if (session('success'))
            <div id="success-alert"
                class="flex items-center justify-between p-4 mb-4 text-sm sm:text-base text-teal-400 bg-teal-500/20 border border-teal-400/30 rounded-xl shadow-lg transition-opacity duration-500 animate-fade-in"
                role="alert">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-lg sm:text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('success-alert').remove();"
                    class="text-teal-400 hover:text-teal-300 focus:outline-none">
                    <i class="fas fa-times text-lg sm:text-xl"></i>
                </button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm sm:text-base text-red-400 bg-red-500/20 border border-red-400/30 rounded-xl shadow-lg animate-fade-in"
                role="alert">
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

        <!-- Header and Add Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-coral-500 animate-text-reveal">Daftar Menu</h2>
            <a href="{{ route('admin.menu.create', ['slug' => $slug]) }}"
                class="bg-teal-500 hover:bg-teal-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Tambah Menu
            </a>
        </div>

        <!-- Menu Table -->
        <div class="bg-gray-800/90 backdrop-blur-md shadow-lg rounded-xl overflow-x-auto p-4 sm:p-6">
            <table class="w-full table-auto text-left text-sm sm:text-base">
                <thead>
                    <tr class="bg-gray-700/50 border-b border-gray-600 text-gray-300">
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">#</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Gambar</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Nama</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Kategori</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Deskripsi</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Stok</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Harga</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Status</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition-all duration-200">
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $loop->iteration }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6">
                                <img src="{{ asset('storage/menu/' . $menu->image) }}" alt="{{ $menu->name }}"
                                    class="w-16 sm:w-20 rounded-md shadow-md hover:scale-105 transition-all duration-200">
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $menu->name }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-400">{{ ucfirst($menu->getCategory->name) }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-400">
                                @if (is_null($menu->description) || $menu->description === '')
                                    <span class="italic text-gray-500">Tidak ada deskripsi</span>
                                @else
                                    {{ Str::limit($menu->description, 50, '...') }}
                                @endif
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $menu->stock }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">Rp
                                {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6">
                                @if ($menu->status)
                                    <span class="text-teal-400 font-semibold">Aktif</span>
                                @else
                                    <span class="text-red-400 font-semibold">Habis</span>
                                @endif
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-right space-x-2">
                                <a href="{{ route('admin.menu.edit', ['slug' => $slug, 'id' => $menu->id]) }}"
                                    class="inline-block bg-teal-500 hover:bg-teal-600 text-white px-3 sm:px-4 py-1 sm:py-2 rounded-lg shadow-md transition-all duration-200">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('admin.menu.destroy', ['slug' => $slug, 'id' => $menu->id]) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 sm:px-4 py-1 sm:py-2 rounded-lg shadow-md transition-all duration-200"
                                        onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-6 sm:py-8 text-center text-gray-400">Belum ada menu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="py-4 px-4 sm:px-6">
                @if ($menus->hasPages())
                    {{ $menus->links('vendor.pagination.tailwind') }}
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-dismiss success alert after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.add('opacity-0');
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);

        // SweetAlert2 for success message
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                background: '#1f2937',
                customClass: {
                    title: 'text-coral-500',
                    content: 'text-gray-300'
                }
            });
        @endif
    </script>
@endpush
