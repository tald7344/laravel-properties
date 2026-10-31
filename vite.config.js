import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/page-overrides.scss',
                'resources/css/admin.css',
                'resources/js/app.js',
                'resources/scss/owner-dashboard.scss',
                'resources/scss/property-details.scss',
                'resources/scss/navigation.scss',
                'resources/scss/owner-property-form.scss',
                'resources/scss/profile-owner.scss',
                'resources/scss/profile-renter.scss',
                'resources/scss/renter-dashboard.scss',
                'resources/scss/legal-page.scss',
                'resources/scss/admin-settings.scss',
                'resources/scss/admin-legal-pages.scss',
            ],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    build: {
        manifest: 'manifest.json',
        outDir: 'public/build',
    },
});
