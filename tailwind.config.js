/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/**/*.{html,php}", "./public/**/*.js"],
  plugins: [],
  theme: {
    fontFamily: {
      display: ['Inter', 'system-ui', 'sans-serif'],
      body: ['Inter', 'system-ui', 'sans-serif'],
    }
  }
}