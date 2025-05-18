<!-- Footer -->
<footer class="bg-gray-800 text-white py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-xs sm:text-sm">
            © {{ date('Y') }} Evokasir by <a href="https://evognito.my.id"
                class="text-coral-500 hover:text-coral-400 transition-all duration-200">Evognito Team</a>. All rights
            reserved.
        </p>
    </div>
</footer>
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    // Toggle mobile menu
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });

    // Function to show full image using SweetAlert2
    function showImage(imageUrl) {
        Swal.fire({
            imageUrl: imageUrl,
            imageAlt: 'Full Size Image',
            imageWidth: '90%',
            showCloseButton: true,
            showConfirmButton: false,
            width: 'auto',
            padding: '1rem',
            customClass: {
                popup: 'max-w-3xl'
            }
        });
    }

    // Function to copy promo code to clipboard
    function copyPromoCode(code, promoId) {
        navigator.clipboard.writeText(code).then(() => {
            const statusElement = document.getElementById('copyStatus' + promoId);
            statusElement.classList.remove('hidden');
            setTimeout(() => {
                statusElement.classList.add('hidden');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>

<style>
    /* Custom Colors */
    :root {
        --coral-500: #f87171;
        --teal-400: #2dd4bf;
        --teal-500: #14b8a6;
        --teal-600: #0d9488;
    }

    /* Animations */
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes textReveal {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes subtlePulse {

        0%,
        100% {
            opacity: 0.1;
        }

        50% {
            opacity: 0.15;
        }
    }

    @keyframes navSlide {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-scale-in {
        animation: scaleIn 0.8s ease-out forwards;
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .animate-text-reveal {
        animation: textReveal 0.8s ease-out forwards;
    }

    .animate-subtle-pulse {
        animation: subtlePulse 10s ease-in-out infinite;
    }

    .animate-nav {
        animation: navSlide 0.5s ease-out forwards;
    }

    .animate-nav:nth-child(1) {
        animation-delay: 0.1s;
    }

    .animate-nav:nth-child(2) {
        animation-delay: 0.2s;
    }

    .animate-nav:nth-child(3) {
        animation-delay: 0.3s;
    }
</style>
