/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Poppins', 'Arial', 'sans-serif'],
      },
      colors: {
        'custom-blue': '#2A8EBF',
        'custom-blue-li': '#B5D9EB',
        'custom-gray-me': '#DFE0DF',
        'custom-text': '#0072AE',
        'custom-icon': '#435473',
        'custom-found': '#f2f2f2',
        'custom-text-yell': '#febe16',
        'custom-wp': '#25d366'
      },
      borderRadius: {
        'xl': '16px',
      },
      listStyleType: {
        'disc': 'disc', // Viñetas redondas (predeterminadas)
        'decimal': 'decimal', // Numeración decimal
        'square': 'square', // Viñetas cuadradas
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

