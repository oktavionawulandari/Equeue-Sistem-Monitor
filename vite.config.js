import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: 'localhost', // Use 'localhost' if you only need local access
        port: 5173, // Ensure this port is not in use
        hmr: {
            host: 'localhost', // Match this with the host
            overlay: false
        }
    },
    resolve: {
        alias: {
            // Example alias configuration
            '@': '/resources/js',
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        })
    ],
});