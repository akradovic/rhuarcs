/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './assets/js/admin/src/**/*.{js,jsx}',
    './*.php',
    './inc/**/*.php',
    './template-parts/**/*.php'
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          purple: '#4A148C', // Adjust this to match your brand color
          light: '#7C43BD',
          dark: '#12005E',
        }
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}