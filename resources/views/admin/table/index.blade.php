@extends('layouts.admin')

@section('title')
    Daftar Tabel - {{ $mitra->mitra_name }} - EvoKasir
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-5xl space-y-6 sm:space-y-8">
        <h1
            class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-6 sm:mb-8 animate-text-reveal flex items-center gap-2 sm:gap-3">
            <i class="fas fa-chair text-lg sm:text-xl"></i> Daftar Tabel - {{ $mitra->mitra_name }}
        </h1>

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="mb-6 bg-teal-500/20 border border-teal-400/30 text-teal-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">
            <div class="flex gap-3">
                <a href="{{ route('admin.table.create', ['slug' => $slug]) }}"
                    class="bg-teal-500 hover:bg-teal-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Tabel
                </a>
                {{-- Tombol Download Semua QR hanya muncul jika ada tabel --}}
                @if ($tableList->isNotEmpty())
                    <a href="{{ route('admin.table.qr.downloadAll', ['slug' => $slug]) }}"
                        class=" bg-cyan-500 hover:bg-cyan-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-download"></i> Download Semua QR
                    </a>
                @endif
            </div>
        </div>
        <div class="bg-gray-800/90 backdrop-blur-md rounded-xl shadow-lg overflow-x-auto animate-scale-in">
            <table class="w-full table-auto text-left text-sm sm:text-base">
                <thead class="bg-gray-700/50 border-b border-gray-600 text-gray-300">
                    <tr>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Nama Meja</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Kode Meja</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Status</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tableList as $table)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition-all duration-200">
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $table->table_name }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $table->table_code }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                <select name="status"
                                    class="status-select border border-gray-700 rounded-lg p-1 sm:p-2 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200"
                                    data-table-id="{{ $table->id }}">
                                    <option value="0" {{ $table->status == 0 ? 'selected' : '' }}>Unavailable</option>
                                    <option value="1" {{ $table->status == 1 ? 'selected' : '' }}>Available</option>
                                    <option value="2" {{ $table->status == 2 ? 'selected' : '' }}>Occupied</option>
                                    <option value="3" {{ $table->status == 3 ? 'selected' : '' }}>Reserved</option>
                                </select>
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-center">
                                <div class="flex justify-center items-center gap-2 sm:gap-3">
                                    <a href="{{ route('admin.table.qr.download', ['slug' => $slug, 'table' => $table->id]) }}"
                                        title="Download QR Code"
                                        class="px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-md transition-all duration-200">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                    <a href="{{ route('admin.table.edit', ['slug' => $slug, 'id' => $table->id]) }}"
                                        class="px-3 sm:px-4 py-1 sm:py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg shadow-md text-xs sm:text-sm font-semibold transition-all duration-200">
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('admin.table.destroy', ['slug' => $slug, 'id' => $table->id]) }}"
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
                            <td colspan="4" class="py-6 sm:py-8 text-center text-gray-400">Belum ada tabel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const tableId = this.getAttribute('data-table-id');
                const newStatus = this.value;

                // Kirim permintaan AJAX untuk update status
                fetch("{{ route('admin.table.updateStatus', ['slug' => $slug]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            table_id: tableId,
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // console.log(data);
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Status meja berhasil diperbarui.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false,
                                background: '#1f2937',
                                customClass: {
                                    title: 'text-coral-500',
                                    content: 'text-gray-300'
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Gagal memperbarui status meja.',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false,
                                background: '#1f2937',
                                customClass: {
                                    title: 'text-coral-500',
                                    content: 'text-gray-300'
                                }
                            });
                            // Kembalikan ke nilai sebelumnya jika gagal
                            this.value = data.original_status || this.value;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memperbarui status.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                            background: '#1f2937',
                            customClass: {
                                title: 'text-coral-500',
                                content: 'text-gray-300'
                            }
                        });
                    });
            });
        });
    </script>
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
