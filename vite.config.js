import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    build: {
        outDir: 'dist', // Menentukan folder output hasil build
        emptyOutDir: true, // Menghapus isi folder sebelum build baru
    },
});
