/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/**/*.{html,php}", "./public/**/*.js", './node_modules/preline/dist/*.js',],
  safelist: [
    'alert-info',
    'alert-warning',
    'alert-success',
    'alert-danger' 
  ],
  plugins: [
    require('@tailwindcss/forms')
  ],
  theme: {
    fontFamily: {
      display: ['Inter', 'system-ui', 'sans-serif'],
      body: ['Inter', 'system-ui', 'sans-serif'],
    }
  }
}