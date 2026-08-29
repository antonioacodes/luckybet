import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                base: null,
                includeAbsolute: false
            }
        }),
        i18n(),
    ],
    server: {
        host: '147.93.71.27', // Permite acesso externo (não apenas localhost)
        port: 5175, // A porta que você quer usar
        strictPort: true, // Impede que o Vite mude para outra porta automaticamente
        watch: {
            usePolling: true, // Evita problemas de file watchers
        }
    },
    resolve: {
        alias: {
            // Defina aliases se necessário
        }
    }
});
