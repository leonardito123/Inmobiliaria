import Alpine from 'alpinejs'
import '../css/app.css'
import './pages/home.js'

// Initialize Alpine.js
window.Alpine = Alpine
Alpine.start()

// Console welcome message
console.log('🏗️ HAVRE ESTATES - Premium Real Estate Platform')
console.log('Environment:', import.meta.env.MODE)
