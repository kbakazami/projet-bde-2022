module.exports = {
  content: ["./templates/**/*.html.twig"],
  theme: {
    screens: {
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1536px',
    },
    extend: {
      colors:{
        'blue': '#2D27FF',
        'purple': '#AE20D5',
        'pink': '#FF0A6C',
      }
    },
  },
  plugins: [],
}
