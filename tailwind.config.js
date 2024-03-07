const plugin = require('tailwindcss/plugin');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
    "./src/Twig/Components/**/*.php"
  ],
  darkMode: 'media',
  theme: {
    extend: {
      animation: {
        'fade-in': 'fadeIn .5s ease-out;',
        wiggle: 'wiggle 1s ease-in-out infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
        wiggle: {
          '0%, 100%': { transform: 'rotate(-3deg)' },
          '50%': { transform: 'rotate(3deg)' },
        }
      },
    },
  },
  plugins: [
    plugin(function({ addVariant }) {
      addVariant('turbo-frame', 'turbo-frame[src] &');
      addVariant('modal', 'dialog &');
    }),
  ],
}
