import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/js/app.js',
                'resources/css/inscricoes-publica.css',
                'resources/js/inscricoes-publica.js',],
            refresh: true,
        }),
    ],
});
