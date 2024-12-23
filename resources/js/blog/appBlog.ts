import axios from "axios";
import Alpine from 'alpinejs'

console.log('--> Init Alpine...')
var Api = axios.create({
    baseURL: import.meta.env.VITE_BACKEND_URL,
    withCredentials: true,
    headers: { Accept: 'application/json' }
});

// Initialize Alpine.js
window.Alpine = Alpine;

Alpine.start()
