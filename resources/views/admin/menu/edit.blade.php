@extends('layouts.admin')

@section('title')
    Edit Menu - {{ $menu->name }} - EvoKasir
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-4xl">
        <div class="bg-gray-800/90 backdrop-blur-md p-4 sm:p-6 lg:p-8 rounded-xl shadow-lg animate-scale-in overflow-y-auto">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-6 sm:mb-8 animate-text-reveal">Edit Menu</h2>

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
            <form action="{{ route('admin.menu.update', ['slug' => $slug, 'id' => $menu->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Menu -->
                <div class="mb-4 sm:mb-6">
                    <label for="name" class="block text-sm sm:text-base font-semibold text-gray-300">Nama Menu</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required
                        class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('name') border-red-500 @enderror">
                    @error('name')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-4 sm:mb-6">
                    <label for="description"
                        class="block text-sm sm:text-base font-semibold text-gray-300">Deskripsi</label>
                    <div id="quill-editor" class="bg-gray-900 text-gray-300 border border-gray-700 rounded-lg z-10"></div>
                    <textarea name="description" id="description" class="hidden">{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-4 sm:mb-6">
                    <label for="category_id" class="block text-sm sm:text-base font-semibold text-gray-300">Kategori</label>
                    <select name="category_id" id="category_id" required
                        class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('category_id') border-red-500 @enderror">
                        <option value="" disabled>Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $menu->categories_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="mb-4 sm:mb-6">
                    <label for="price" class="block text-sm sm:text-base font-semibold text-gray-300">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $menu->price) }}" required
                        min="0" step="1"
                        class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('price') border-red-500 @enderror">
                    @error('price')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stok -->
                <div class="mb-4 sm:mb-6">
                    <label for="stock" class="block text-sm sm:text-base font-semibold text-gray-300">Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $menu->stock) }}" required
                        min="0" step="1"
                        class="mt-1 block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('stock') border-red-500 @enderror">
                    @error('stock')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="mb-4 sm:mb-6">
                    <label for="image" class="block text-sm sm:text-base font-semibold text-gray-300">Gambar Menu</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full text-sm sm:text-base text-gray-400 border border-gray-700 rounded-lg bg-gray-900 p-2 sm:p-3 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('image') border-red-500 @enderror">
                    @if ($menu->image)
                        <img src="{{ asset('storage/menu/' . $menu->image) }}" alt="{{ $menu->name }}"
                            class="mt-2 w-32 sm:w-40 h-32 sm:h-40 object-cover rounded-lg shadow-md hover:scale-105 transition-all duration-200">
                    @endif
                    @error('image')
                        <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
                    <a href="{{ route('admin.menu.index', ['slug' => $slug]) }}"
                        class="bg-gray-600 hover:bg-gray-700 text-gray-200 font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition-all duration-200 text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                        Update Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                // Initialize Quill Editor
                const quill = new Quill('#quill-editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{
                                'header': [1, 2, false]
                            }],
                            ['bold', 'italic', 'underline'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['clean']
                        ]
                    }
                });

                // Set initial content
                const initialDescription = document.getElementById('description').value;
                if (initialDescription) {
                    quill.root.innerHTML = initialDescription;
                }

                // Sync Quill content with hidden textarea
                quill.on('text-change', () => {
                    document.getElementById('description').value = quill.root.innerHTML;
                });

                // Ensure Quill container is visible
                document.querySelector('#quill-editor').style.display = 'block';
            } catch (error) {
                console.error('Quill initialization failed:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal memuat editor deskripsi. Silakan coba lagi.',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false,
                    background: '#1f2937',
                    customClass: {
                        title: 'text-coral-500',
                        content: 'text-gray-300'
                    }
                });
            }

            // SweetAlert2 for form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Update Menu?',
                    text: 'Pastikan semua data sudah benar.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Update',
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
        });
    </script>

    <style>
        #quill-editor {
            min-height: 200px;
            height: auto;
            display: block;
            z-index: 10;
        }

        .ql-toolbar {
            background: #1f2937;
            border: 1px solid #4b5563;
            border-bottom: none;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            z-index: 11;
        }

        .ql-container {
            background: #111827;
            border: 1px solid #4b5563;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            color: #d1d5db;
            min-height: 150px;
            z-index: 10;
        }

        .ql-editor {
            min-height: 120px;
        }
    </style>
@endpush
