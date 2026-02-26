import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

// project ran using ddev
const isDdev = process.env.IS_DDEV_PROJECT === 'true';
// take ddev url
const ddevHost = isDdev ? process.env.DDEV_HOSTNAME.split(',')[0] : 'localhost';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    ...(isDdev && {
        server: {
            host: '0.0.0.0',
            port: 5173,
            strictPort: true,
            hmr: {
                host: ddevHost,
                protocol: 'wss',
            },
        }
    })
});
