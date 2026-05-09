import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [vue()],
    define: {
        route: 'window.route',
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url)),
        },
    },
    server: {
        proxy: {
            '/api': {
                target: process.env.VITE_API_PROXY_TARGET || 'http://127.0.0.1:8000',
                changeOrigin: true,
            },
            '/sanctum': {
                target: process.env.VITE_API_PROXY_TARGET || 'http://127.0.0.1:8000',
                changeOrigin: true,
            },
            '/images': {
                target: process.env.VITE_API_PROXY_TARGET || 'http://127.0.0.1:8000',
                changeOrigin: true,
            },
            '/storage': {
                target: process.env.VITE_API_PROXY_TARGET || 'http://127.0.0.1:8000',
                changeOrigin: true,
            },
        },
    },
});
