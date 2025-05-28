@extends('layouts.admin')

@section('title', 'Daftar Kupon - EvoKasir')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-7xl space-y-6 sm:space-y-8">
        <div class="flex justify-between items-center mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-coral-500 flex items-center gap-2 sm:gap-3">
                <i class="fas fa-ticket-alt text-lg sm:text-xl"></i> Daftar Kupon
            </h2>
            <button onclick="openCreateModal()"
                class="bg-teal-500 hover:bg-teal-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Tambah Kupon
            </button>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div id="successMessage"
                class="mb-6 bg-teal-500/20 border border-teal-400/30 text-teal-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg transition-opacity duration-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div
                class="mb-6 bg-red-500/20 border border-red-400/30 text-red-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-exclamation-circle text-lg sm:text-xl"></i>
                    <strong>Terjadi kesalahan:</strong>
                </div>
                <ul class="list-disc list-inside text-sm sm:text-base">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Coupon Table -->
        <div class="bg-gray-800/90 backdrop-blur-md rounded-xl shadow-lg overflow-x-auto">
            <table class="w-full table-auto text-left text-sm sm:text-base">
                <thead class="bg-gray-700/50 border-b border-gray-600 text-gray-300">
                    <tr>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-center">#</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Image</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Judul</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Kode Kupon</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Potongan Harga</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Potongan Persen</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-center">Terpakai</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-center">Maks. Penggunaan</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold">Batas Waktu</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-center">Status</th>
                        <th class="py-3 sm:py-4 px-4 sm:px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                        @php
                            $expired = \Carbon\Carbon::parse($coupon->expired_date);
                            $now = now();
                            $diffInSeconds = $expired->diffInSeconds($now, false);
                        @endphp
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition-all duration-200">
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300 text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                @if (empty($coupon->image))
                                    <span class="italic text-gray-400">No Image</span>
                                @else
                                    <img src="{{ asset('storage/menu/' . $coupon->image) }}" alt="{{ $coupon->title }}"
                                        class="w-20 sm:w-24 h-auto rounded shadow-sm">
                                @endif
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $coupon->title }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">{{ $coupon->coupon_code }}</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                {{ $coupon->discount_price ? 'Rp ' . number_format($coupon->discount_price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                {{ $coupon->discount_rate ? number_format($coupon->discount_rate, 0, ',', '.') . '%' : '-' }}
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300 text-center">{{ $coupon->already_used }} x
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300 text-center">{{ $coupon->max_use }} x</td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-gray-300">
                                {{ $expired->translatedFormat('d M Y H:i') }} WIB
                                <br>
                                @if ($diffInSeconds > 0)
                                    @php
                                        $diffPast = abs($diffInSeconds);
                                        $daysPast = floor($diffPast / 86400);
                                        $hoursPast = floor(($diffPast % 86400) / 3600);
                                        $minutesPast = floor(($diffPast % 3600) / 60);
                                    @endphp
                                    <span class="text-red-400 text-xs sm:text-sm">
                                        Kadaluarsa {{ $daysPast > 0 ? $daysPast . ' hari' : '' }}
                                        {{ $hoursPast > 0 ? $hoursPast . ' jam' : '' }}
                                        {{ $minutesPast > 0 ? $minutesPast . ' menit lalu' : '' }}
                                    </span>
                                @elseif ($diffInSeconds === 0)
                                    <span class="text-yellow-400 text-xs sm:text-sm">Kadaluarsa sekarang</span>
                                @else
                                    @php
                                        $diffFuture = abs($diffInSeconds);
                                        $daysFuture = floor($diffFuture / 86400);
                                        $hoursFuture = floor(($diffFuture % 86400) / 3600);
                                        $minutesFuture = floor(($diffFuture % 3600) / 60);
                                    @endphp
                                    <span class="text-teal-400 text-xs sm:text-sm">
                                        {{ $daysFuture > 0 ? $daysFuture . ' hari' : '' }}
                                        {{ $hoursFuture > 0 ? $hoursFuture . ' jam' : '' }}
                                        {{ $minutesFuture > 0 ? $minutesFuture . ' menit lagi' : '' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-center">
                                @if ($coupon->already_used < $coupon->max_use && $diffInSeconds <= 0)
                                    <span class="text-teal-400 font-semibold">Aktif</span>
                                @else
                                    <span class="text-red-400 font-semibold">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="py-3 sm:py-4 px-4 sm:px-6 text-right space-x-2">
                                <button onclick="openEditModal('{{ $coupon->id }}')"
                                    class="px-3 sm:px-4 py-1 sm:py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg shadow-md text-xs sm:text-sm font-semibold transition-all duration-200">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <button onclick="confirmDelete('{{ $coupon->id }}', '{{ addslashes($coupon->title) }}')"
                                    class="px-3 sm:px-4 py-1 sm:py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-md text-xs sm:text-sm font-semibold transition-all duration-200">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-6 sm:py-8 text-center text-gray-400">Belum ada kupon.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="py-4 px-4 sm:px-6">
                @if ($coupons->hasPages())
                    {{ $coupons->links('vendor.pagination.tailwind') }}
                @endif
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-gray-800 rounded-xl p-4 sm:p-6 w-full max-w-lg sm:max-w-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg sm:text-xl font-semibold text-coral-500 mb-4 flex items-center gap-2">
                <i class="fas fa-ticket-alt"></i> Tambah Kupon Baru
            </h3>
            <form id="createForm" action="{{ route('admin.coupon.store', ['slug' => $slug]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="title" class="block text-sm sm:text-base font-semibold text-gray-300">Judul</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('title') border-red-500 @enderror">
                        @error('title')
                            <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="coupon_code" class="block text-sm sm:text-base font-semibold text-gray-300">Kode
                            Kupon</label>
                        <input type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code') }}" required
                            class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('coupon_code') border-red-500 @enderror">
                        @error('coupon_code')
                            <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="discount_price" class="block text-sm sm:text-base font-semibold text-gray-300">Potongan
                            Harga (Rp)</label>
                        <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price') }}"
                            class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('discount_price') border-red-500 @enderror">
                        @error('discount_price')
                            <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="discount_rate" class="block text-sm sm:text-base font-semibold text-gray-300">Potongan
                            Persen (%)</label>
                        <input type="number" name="discount_rate" id="discount_rate" value="{{ old('discount_rate') }}"
                            class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('discount_rate') border-red-500 @enderror">
                        @error('discount_rate')
                            <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="max_use" class="block text-sm sm:text-base font-semibold text-gray-300">Maksimal
                            Penggunaan</label>
                        <input type="number" name="max_use" id="max_use" value="{{ old('max_use') }}" required
                            class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('max_use') border-red-500 @enderror">
                        @error('max_use')
                            <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="expired_date" class="block text-sm sm:text-base font-semibold text-gray-300">Batas
                            Waktu</label>
                        <input type="datetime-local" name="expired_date" id="expired_date"
                            value="{{ old('expired_date') }}" required
                            class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('expired_date') border-red-500 @enderror">
                        @error('expired_date')
                            <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-1 sm:col-span-2">
                        <label for="description"
                            class="block text-sm sm:text-base font-semibold text-gray-300">Deskripsi</label>
                        <div id="quill-create" class="mt-1 bg-gray-900 text-gray-300 border border-gray-700 rounded-lg">
                        </div>
                        <input type="hidden" name="description" id="description">
                        @error('description')
                            <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-1 sm:col-span-2 mt-12">
                        <label for="image" class="block text-sm sm:text-base font-semibold text-gray-300">Gambar
                            (opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('image') border-red-500 @enderror">
                        @error('image')
                            <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-3 sm:gap-4 mt-4 sm:mt-6">
                    <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')"
                        class="bg-gray-600 hover:bg-gray-700 text-gray-200 font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition-all duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                        Simpan Kupon
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach ($coupons as $coupon)
        <div id="editModal-{{ $coupon->id }}"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-gray-800 rounded-xl p-4 sm:p-6 w-full max-w-lg sm:max-w-2xl max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg sm:text-xl font-semibold text-coral-500 mb-4 flex items-center gap-2">
                    <i class="fas fa-ticket-alt"></i> Edit Kupon
                </h3>
                <form id="editForm-{{ $coupon->id }}"
                    action="{{ route('admin.coupon.update', ['slug' => $slug, 'id' => $coupon->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="edit_title_{{ $coupon->id }}"
                                class="block text-sm sm:text-base font-semibold text-gray-300">Judul</label>
                            <input type="text" name="title" id="edit_title_{{ $coupon->id }}"
                                value="{{ old('title', $coupon->title) }}" required
                                class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('title') border-red-500 @enderror">
                            @error('title')
                                <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="edit_coupon_code_{{ $coupon->id }}"
                                class="block text-sm sm:text-base font-semibold text-gray-300">Kode Kupon</label>
                            <input type="text" name="coupon_code" id="edit_coupon_code_{{ $coupon->id }}"
                                value="{{ old('coupon_code', $coupon->coupon_code) }}" required
                                class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('coupon_code') border-red-500 @enderror">
                            @error('coupon_code')
                                <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="edit_discount_price_{{ $coupon->id }}"
                                class="block text-sm sm:text-base font-semibold text-gray-300">Potongan Harga (Rp)</label>
                            <input type="number" name="discount_price" id="edit_discount_price_{{ $coupon->id }}"
                                value="{{ old('discount_price', $coupon->discount_price) }}"
                                class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('discount_price') border-red-500 @enderror">
                            @error('discount_price')
                                <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="edit_discount_rate_{{ $coupon->id }}"
                                class="block text-sm sm:text-base font-semibold text-gray-300">Potongan Persen (%)</label>
                            <input type="number" name="discount_rate" id="edit_discount_rate_{{ $coupon->id }}"
                                value="{{ old('discount_rate', $coupon->discount_rate) }}"
                                class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('discount_rate') border-red-500 @enderror">
                            @error('discount_rate')
                                <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="edit_max_use_{{ $coupon->id }}"
                                class="block text-sm sm:text-base font-semibold text-gray-300">Maksimal Penggunaan</label>
                            <input type="number" name="max_use" id="edit_max_use_{{ $coupon->id }}"
                                value="{{ old('max_use', $coupon->max_use) }}" required
                                class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('max_use') border-red-500 @enderror">
                            @error('max_use')
                                <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="edit_expired_date_{{ $coupon->id }}"
                                class="block text-sm sm:text-base font-semibold text-gray-300">Batas Waktu</label>
                            <input type="datetime-local" name="expired_date" id="edit_expired_date_{{ $coupon->id }}"
                                value="{{ old('expired_date', $coupon->expired_date) }}" required
                                class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('expired_date') border-red-500 @enderror">
                            @error('expired_date')
                                <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-span-1 sm:col-span-2">
                            <label for="edit_description_{{ $coupon->id }}"
                                class="block text-sm sm:text-base font-semibold text-gray-300">Deskripsi</label>
                            <div id="quill-edit-{{ $coupon->id }}"
                                class="mt-1 bg-gray-900 text-gray-300 border border-gray-700 rounded-lg"></div>
                            <input type="hidden" name="description" id="edit_description_{{ $coupon->id }}">
                            @error('description')
                                <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-span-1 sm:col-span-2 mt-12">
                            <label for="edit_image_{{ $coupon->id }}"
                                class="block text-sm sm:text-base font-semibold text-gray-300">Gambar
                                (opsional)
                            </label>
                            <input type="file" name="image" id="edit_image_{{ $coupon->id }}" accept="image/*"
                                class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('image') border-red-500 @enderror">
                            @error('image')
                                <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <p class="text-gray-400 text-xs sm:text-sm mt-1">Kosongkan jika tidak ingin mengubah gambar.
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 sm:gap-4 mt-4 sm:mt-6">
                        <button type="button"
                            onclick="document.getElementById('editModal-{{ $coupon->id }}').classList.add('hidden')"
                            class="bg-gray-600 hover:bg-gray-700 text-gray-200 font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition-all duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                            Update Kupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Delete Forms -->
    @foreach ($coupons as $coupon)
        <form id="delete-form-{{ $coupon->id }}"
            action="{{ route('admin.coupon.destroy', ['slug' => $slug, 'id' => $coupon->id]) }}" method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection

@push('styles')
    <style>
        .ql-container {
            background-color: #1f2937;
            color: #d1d5db;
            border: 1px solid #374151;
            border-radius: 0.5rem;
        }

        .ql-toolbar {
            background-color: #374151;
            border: 1px solid #374151;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .ql-container.ql-snow {
            border-radius: 0 0 0.5rem 0.5rem;
        }

        .ql-editor {
            min-height: 100px;
        }

        .ql-snow .ql-picker {
            color: #d1d5db;
        }

        .ql-snow .ql-stroke {
            stroke: #d1d5db;
        }

        .ql-snow .ql-fill {
            fill: #d1d5db;
        }

        .ql-snow .ql-picker-options {
            background-color: #374151;
            border: 1px solid #4b5563;
        }

        .ql-snow .ql-picker-item:hover {
            color: #f9a8d4;
        }

        .ql-snow .ql-picker-item.ql-selected {
            color: #14b8a6;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function openCreateModal() {
            console.log('Attempting to open create modal');
            const modal = document.getElementById('createModal');
            if (modal) {
                modal.classList.remove('hidden');
                console.log('Create modal opened successfully');
                console.log('Modal classes:', modal.className);
                console.log('Modal computed style display:', window.getComputedStyle(modal).display);
            } else {
                console.error('Create modal element not found');
            }
        }

        function openEditModal(id) {
            console.log('Attempting to open edit modal for coupon ID:', id);
            const modal = document.getElementById('editModal-' + id);
            if (modal) {
                modal.classList.remove('hidden');
                console.log('Edit modal opened successfully for ID:', id);
                console.log('Modal classes:', modal.className);
                console.log('Modal computed style display:', window.getComputedStyle(modal).display);
            } else {
                console.error('Edit modal element not found for ID:', id);
            }
        }

        function confirmDelete(id, title) {
            console.log('Delete triggered for coupon ID:', id);
            Swal.fire({
                title: 'Hapus Kupon?',
                text: `Apakah Anda yakin ingin menghapus kupon "${title}"?`,
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
                    console.log('Submitting delete form for ID:', id);
                    const form = document.getElementById('delete-form-' + id);
                    if (form) {
                        form.submit();
                    } else {
                        console.error('Delete form not found for ID:', id);
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing scripts');

            // Check asset loading
            if (typeof Swal === 'undefined') {
                console.error(
                    'SweetAlert2 is not loaded. Please ensure the SweetAlert2 script is included in admin.layouts.app.'
                );
            } else {
                console.log('SweetAlert2 is loaded successfully');
            }
            if (typeof Quill === 'undefined') {
                console.error(
                    'Quill.js is not loaded. Please ensure the Quill script is included in admin.layouts.app.');
            } else {
                console.log('Quill.js is loaded successfully');
            }

            // Initialize Quill for create modal
            try {
                const quillCreate = new Quill('#quill-create', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            ['link'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['clean']
                        ]
                    }
                });
                quillCreate.on('text-change', function() {
                    document.getElementById('description').value = quillCreate.root.innerHTML;
                });
                @if (old('description'))
                    quillCreate.root.innerHTML = @json(old('description'));
                @endif
                console.log('Quill initialized for create modal');
            } catch (error) {
                console.error('Failed to initialize Quill for create modal:', error);
            }

            // Initialize Quill for edit modals
            @foreach ($coupons as $coupon)
                try {
                    const quillEdit{{ $coupon->id }} = new Quill('#quill-edit-{{ $coupon->id }}', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline'],
                                ['link'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                ['clean']
                            ]
                        }
                    });
                    quillEdit{{ $coupon->id }}.root.innerHTML = @json(old('description', $coupon->description ?? ''));
                    quillEdit{{ $coupon->id }}.on('text-change', function() {
                        document.getElementById('edit_description_{{ $coupon->id }}').value =
                            quillEdit{{ $coupon->id }}.root.innerHTML;
                    });
                    console.log('Quill initialized for edit modal ID:', {{ $coupon->id }});
                } catch (error) {
                    console.error('Failed to initialize Quill for edit modal ID {{ $coupon->id }}:', error);
                }
            @endforeach

            // Form submission confirmations
            document.querySelectorAll('form').forEach(form => {
                if (!form.id.includes('delete-form')) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        console.log('Form submission triggered for:', form.id);
                        Swal.fire({
                            title: 'Simpan Kupon?',
                            text: 'Pastikan data kupon sudah benar.',
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
                                console.log('Form confirmed, submitting:', form.id);
                                this.submit();
                            } else {
                                console.log('Form submission cancelled for:', form.id);
                            }
                        });
                    });
                }
            });

            // Close modals when clicking outside
            document.querySelectorAll('[id^=createModal], [id^=editModal-]').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                        console.log('Modal closed by clicking outside:', modal.id);
                    }
                });
            });

            // Auto-hide success message
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                console.log('Success message found, will hide after 3 seconds');
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                    console.log('Success message hidden');
                }, 3000);
            }

            // Debug modal existence
            const createModal = document.getElementById('createModal');
            console.log('Create modal exists:', !!createModal);
            @foreach ($coupons as $coupon)
                const editModal{{ $coupon->id }} = document.getElementById('editModal-{{ $coupon->id }}');
                console.log('Edit modal exists for ID {{ $coupon->id }}:', !!editModal{{ $coupon->id }});
            @endforeach
        });
    </script>
@endpush
