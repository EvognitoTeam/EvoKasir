<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - Evokasir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientMove 10s ease infinite;
        }

        .scale-in {
            animation: scaleIn 0.5s ease-out forwards;
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 animate-gradient flex items-center justify-center px-4">
    <div class="max-w-lg w-full bg-gray-800 rounded-2xl shadow-2xl p-8 text-center scale-in">
        <!-- Ikon -->
        <div class="flex justify-center mb-6">
            <i class="fas fa-tools text-teal-400 text-5xl animate-spin" style="animation-duration: 2s;"></i>
        </div>

        <!-- Judul -->
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Evokasir Sedang Dalam Pemeliharaan</h1>

        <!-- Pesan -->
        <p class="text-gray-300 text-lg mb-6">
            Maaf atas ketidaknyamanannya. Kami sedang meningkatkan sistem untuk pengalaman lebih baik.
        </p>

        <!-- Countdown Timer -->
        <div id="countdown" class="text-teal-400 text-xl font-semibold mb-6 hidden">
            Selesai dalam: <span id="timer"></span>
        </div>

        <!-- Fallback Pesan -->
        <p id="fallback-message" class="text-gray-300 text-lg mb-6">
            Kami akan segera kembali!
        </p>

        <!-- Branding -->
        <p class="text-gray-400 text-sm">
            © {{ date('Y') }} Evokasir. Semua hak dilindungi.
        </p>
    </div>

    <!-- JavaScript untuk Countdown -->
    <script>
        // Waktu akhir pemeliharaan dari .env
        const maintenanceEndTime = '{{ env('MAINTENANCE_END_TIME') }}';
        const endDate = maintenanceEndTime ? new Date(maintenanceEndTime) : null;

        if (endDate && !isNaN(endDate)) {
            const countdownElement = document.getElementById('countdown');
            const timerElement = document.getElementById('timer');
            const fallbackMessage = document.getElementById('fallback-message');

            countdownElement.classList.remove('hidden');
            fallbackMessage.classList.add('hidden');

            function updateCountdown() {
                const now = new Date();
                const distance = endDate - now;

                if (distance < 0) {
                    countdownElement.classList.add('hidden');
                    fallbackMessage.classList.remove('hidden');
                    fallbackMessage.textContent = 'Pemeliharaan selesai, segera kembali!';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                timerElement.textContent =
                    `${days ? days + ' hari, ' : ''}${hours ? hours + ' jam, ' : ''}${minutes} menit, ${seconds} detik`;
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();
        } else {
            document.getElementById('countdown').classList.add('hidden');
        }
    </script>
</body>

</html>
