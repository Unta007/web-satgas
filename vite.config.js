import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/dashboard.js',
                'resources/js/charts.js',
                'resources/js/report-list.js',
                'resources/js/report-edit.js',
                'resources/js/admin-alerts.js',
                'resources/js/admin-articles.js',
            ],
            refresh: true,
        }),
    ],
});
