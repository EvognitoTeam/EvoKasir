@extends('layouts.admin')

@section('title', 'Pengaturan Struk - EvoKasir')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-8 space-y-6 sm:space-y-8 bg-transparent relative z-10">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-coral-500 mb-4 sm:mb-6 flex items-center gap-2">
            <i class="fas fa-receipt text-lg sm:text-xl"></i> Pengaturan Struk
        </h1>

        @if (session('success'))
            <div id="successMessage"
                class="bg-teal-500/20 border border-teal-400/30 text-teal-400 px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg mb-4 sm:mb-6 transition-opacity duration-300">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.print-setting.save', ['slug' => $slug]) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4 sm:space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">Judul Struk</label>
                <input type="text" name="title" id="title" value="{{ old('title', $title) }}"
                    class="w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('title') border-red-500 @enderror">
                @error('title')
                    <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="footer_text" class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">Footer
                    Teks</label>
                <div id="footer_text" class="w-full bg-gray-900 text-gray-300 border border-gray-700 rounded-lg"></div>
                <textarea name="footer_text" id="footer_text_input" style="display:none;">{{ old('footer_text', $footerText) }}</textarea>
                @error('footer_text')
                    <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="show_logo" value="1"
                        {{ old('show_logo', $showLogo) ? 'checked' : '' }}
                        class="border-gray-700 bg-gray-900 text-teal-500 focus:ring-coral-500 rounded">
                    <span class="ml-2 text-sm sm:text-base text-gray-300">Tampilkan Logo di Struk</span>
                </label>
            </div>

            <div>
                <label for="logo" class="block text-sm sm:text-base font-semibold text-gray-300 mb-1">Upload
                    Logo</label>
                <input type="file" name="logo" id="logo" accept="image/*"
                    class="block w-full border border-gray-700 rounded-lg px-4 py-2 sm:py-3 text-gray-300 bg-gray-900 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-all duration-200 @error('logo') border-red-500 @enderror">
                @error('logo')
                    <div class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</div>
                @enderror
                @if (!empty($logo))
                    <img src="{{ asset('storage/' . $logo) }}" class="h-16 mt-2 rounded shadow-sm" alt="Logo">
                @endif
            </div>

            <button type="submit"
                class="bg-teal-500 hover:bg-teal-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md text-sm sm:text-base font-semibold transition-all duration-200 transform hover:scale-105">
                Simpan
            </button>
        </form>
    </div>

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
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Print Settings page loaded, checking geometric background');
                const geoBackground = document.querySelector('.fixed.inset-0');
                if (geoBackground) {
                    console.log('Geometric background element found');
                    console.log('Opacity:', geoBackground.style.opacity);
                    console.log('Z-index:', geoBackground.style.zIndex);
                    console.log('Computed display:', window.getComputedStyle(geoBackground).display);
                } else {
                    console.error('Geometric background element not found');
                }

                // Initialize Quill editor
                try {
                    const quill = new Quill('#footer_text', {
                        theme: 'snow',
                        placeholder: 'Masukkan footer text...',
                        modules: {
                            toolbar: [
                                [{
                                    'header': '1'
                                }, {
                                    'header': '2'
                                }, {
                                    'font': []
                                }],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                ['bold', 'italic', 'underline'],
                                [{
                                    'align': []
                                }],
                                ['link'],
                                ['blockquote']
                            ]
                        }
                    });
                    quill.root.innerHTML = @json(old('footer_text', $footerText));
                    quill.on('text-change', function() {
                        document.querySelector('#footer_text_input').value = quill.root.innerHTML;
                        console.log('Quill content updated:', quill.root.innerHTML);
                    });
                    console.log('Quill initialized for footer_text');
                } catch (error) {
                    console.error('Failed to initialize Quill:', error);
                }

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
                    console.log('Print Settings form submission triggered');
                    console.log('Form action:', this.action);
                    console.log('Footer text:', document.querySelector('#footer_text_input').value);
                });
            });
        </script>
    @endpush
@endsection
