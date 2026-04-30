/** @type {import('tailwindcss').Config} */
export default {
  content: [
    '../src/Views/**/*.php'
  ],
  theme: {
    extend: {
      colors: {
        'ink': '#0a0a0a',
        'paper': '#f5f0e8',
        'gold': '#b8942a',
        'rust': '#c0392b',
        'muted': '#7a7060',
        'rule': '#d4c9b0',
        'code-bg': '#1a1a1a',
        'code-fg': '#e8dfc8',
        'accent': '#2c5f8a'
      },
      fontFamily: {
        'serif': ['Playfair Display', 'serif'],
        'mono': ['IBM Plex Mono', 'monospace'],
        'sans': ['IBM Plex Sans', 'sans-serif']
      },
      fontSize: {
        'xs': '0.75rem',
        'sm': '0.875rem',
        'base': '15px',
        'lg': '1.05rem',
        'xl': '1.25rem',
        '2xl': '1.5rem',
        '3xl': '1.9rem',
        '4xl': '2.4rem',
        '5xl': 'clamp(2.4rem, 5vw, 4.2rem)'
      },
      spacing: {
        'gutter': '2rem',
        'section': '3rem'
      },
      animation: {
        'scroll-reveal': 'scroll-reveal 0.6s ease-out forwards'
      },
      keyframes: {
        'scroll-reveal': {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' }
        }
      }
    }
  },
  plugins: []
}
