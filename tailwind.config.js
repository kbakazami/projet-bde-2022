module.exports = {
  content: [
      "./src/**/*.{html,js}",
    './templates/**/*.html.twig',
      './js/*.js',
      './**/js/*.js',
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
        'red': '#FF0000',
        'orange': '#FF5900',
        'green':'#2EA233',
        'black-80':'rgba(0, 0, 0, 0.8)'
      },
      fontFamily:{
        hind:["hind","roboto"],
        expletus:["expletus","roboto"],
      },
      width:{
        '520':'520px',
        '400':'400px',
        '420':'420px',
        '290':'290px',
        '50':'200px',
        '46':'185px',
        '34':'140px',
        '30':'125px',
        '1080':'1080px',
        '700':'700px',
        '13':'50px',
        '11.5':'46px'
      },
      height:{
        '320':'320px',
        '220':'220px',
        '34':'136px',
      },
      boxShadow:{
        'glowEffect':'inset 0 0 10px blue, inset 0 0 40px pink, 0 0 20px purple',
        'glowEffecty':' 0 0 10px blue,  0 0 40px pink, 0 0 10px purple'
      },
      borderWidth:{
        '3':'3px',
      },
      spacing:{
        '15':'60px',
        'pxmd':'1.5px',
        '0.1':'0.1rem',
        '0.2':'0.2rem',
      },
      zIndex:{
        '1':'1',
      },
      skew:{
        '125':'125deg'
      },
      minHeight:{
        '34':'136px'
      },
      backgroundImage:{
        'banner-home':"url('/img/bg-base.jpg')"
      }
    },
  },
  variants:{
    extend: {
      display: ['after','before']
    }
  },
}
