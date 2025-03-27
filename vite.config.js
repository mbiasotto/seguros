import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Configuração simplificada para melhor desempenho
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: undefined
            }
        }
    }
});
