<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-gray-900 text-white flex flex-col items-center justify-center px-4 py-12 space-y-10">
    <div class="text-center">
        <h1 class="text-3xl sm:text-4xl font-bold text-coral-500">403 - Akses Ditolak</h1>
        <p class="mt-2 text-gray-300 text-lg sm:text-xl">{{ $exception->getMessage() }}</p>
    </div>

    <div class="w-full max-w-xl bg-gray-800 rounded-xl shadow-lg p-6 sm:p-8 space-y-6 text-center">
        <svg class="w-16 h-16 mx-auto text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 11c-1.104 0-2-.896-2-2s.896-2 2-2 2 .896 2 2-2 2-2 2zm0 2c1.104 0 2 .896 2 2v3H10v-3c0-1.104.896-2 2-2z">
            </path>
        </svg>
        <p class="text-gray-400">Maaf, Anda tidak dapat mengakses halaman ini karena izin terbatas.</p>

        <div class="space-y-4">
            <button onclick="javascript:history.back()"
                class="inline-flex items-center justify-center px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white text-lg font-semibold rounded-lg transition-all shadow-md">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </button>
        </div>
    </div>

    <div class="text-sm text-gray-500">
        © {{ date('Y') }} Evokasir. All rights reserved.
    </div>
</body>

</html>
