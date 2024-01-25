import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/landing/style.css',
                'resources/js/landing/main.js',
            ],
            refresh: true,
        }),
    ],
});
