import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
     server: {
        host: 'vinste.local',
        hmr: {
            host: 'vinste.local',
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
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/transitions.js',
            ],
            refresh: true,
        }),
    ],
});
