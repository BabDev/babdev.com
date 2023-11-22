import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import manifestSRI from 'vite-plugin-manifest-sri';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/docs.js',
                'resources/js/updates.js',
            ],
            refresh: true,
        }),
        manifestSRI(),
    ],
});
