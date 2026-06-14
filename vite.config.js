import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
     server: {
        host: 'localhost',
        hmr: {
            host: 'localhost',
        },
        cors: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/login.css',
                'resources/css/admin.css',
                'resources/css/nav.css',
                'resources/css/table.css',
                'resources/css/form.css',
                'resources/css/mobile.css',
                'resources/css/dashboard.css',
                'resources/css/ui-v2.css',
                'resources/css/order-response.css',
                'resources/css/provider-prices.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/nav.js',

                'resources/images/chart.png',
                'resources/images/logo.png',
                'resources/images/logo-no-bg.png',
            ],
            refresh: true,
        }),
    ],
});
