/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './student068/dwes/includes/header.php',
    './student068/dwes/includes/footer.php',
    './student068/dwes/*.php', // Otras páginas PHP
    './student068/dwes/**/*.php', // Si tienes subdirectorios
    './student068/dwes/**/*.html', // Si usas HTML también
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
