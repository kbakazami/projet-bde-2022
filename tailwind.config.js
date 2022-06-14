module.exports = {
  content: [
      "./src/**/*.{html,js}",
    './templates/**/*.html.twig',
    './node_modules/tw-elements/dist/js/**/*.js'
  ],
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
        'blue-60' : 'rgba(45,39,255, 0.6)',
        'purple': '#AE20D5',
        'purple-60': 'rgba(174,32,213, 0.6)',
        'pink': '#FF0A6C',
        'pink-60': 'rgba(255,10,108, 0.6)',
        'red': '#FF0000'
      },
      fontFamily:{
        hind:["hind","roboto"],
        expletus:["expletus","roboto"],
      },
      width:{
        '400':'400px',
        '300':'300px',
        '220':'220px',
        '600':'600px'
      },
      height:{
        '400':'400px',
        '300':'300px',
        '200':'200px',
        '600':'600px'
      },
      boxShadow:{
        'glowEffect':'inset 0 0 10px blue, inset 0 0 40px pink, 0 0 20px purple',
        'glowEffecty':' 0 0 10px blue,  0 0 40px pink, 0 0 10px purple'
      },
      rotate:{
        '270':'270deg',
      },
      spacing:{
        '26':'106px'
      }
    },
  },
  variants:{
    extend: {
      display: ['after','before']
    }
  },
}
