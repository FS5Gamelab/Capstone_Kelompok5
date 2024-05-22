/** @type {import('tailwindcss').Config} */
export default {
  prefix: "tw-",
  darkMode: "selector",
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
