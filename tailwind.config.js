const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        // Ganti 'Inter' dengan 'Poppins' untuk nuansa yang sedikit berbeda
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
      keyframes: {
        'fade-in-up': {
            '0%': {
                opacity: '0',
                transform: 'translateY(20px)'
            },
            '100%': {
                opacity: '1',
                transform: 'translateY(0)'
            },
        },
        'background-pan': {
            '0%': { backgroundPosition: '0% 50%' },
            '50%': { backgroundPosition: '100% 50%' },
            '100%': { backgroundPosition: '0% 50%' },
        }
      },
      animation: {
        'fade-in-up': 'fade-in-up 0.8s ease-out forwards',
        'background-pan': 'background-pan 15s ease infinite',
      }
    },
  },
  plugins: [],
}