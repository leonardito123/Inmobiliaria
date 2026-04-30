import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  root: 'resources',
  base: '/assets/',
  plugins: [tailwindcss()],
  build: {
    manifest: true,
    outDir: '../public/assets',
    rollupOptions: {
      input: {
        main: 'resources/js/main.js',
        home: 'resources/js/pages/home.js',
        venta: 'resources/js/pages/venta.js',
        renta: 'resources/js/pages/renta.js',
        desarrollos: 'resources/js/pages/desarrollos.js',
        contacto: 'resources/js/pages/contacto.js'
      },
      output: {
        entryFileNames: '[name].[hash].js',
        chunkFileNames: 'chunks/[name].[hash].js',
        assetFileNames: (assetInfo) => {
          const info = assetInfo.name.split('.')
          const ext = info[info.length - 1]
          if (['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'avif'].includes(ext)) {
            return `images/[name][extname]`
          } else if (ext === 'css') {
            return `css/[name].[hash][extname]`
          }
          return `[name].[hash][extname]`
        }
      }
    }
  }
})
