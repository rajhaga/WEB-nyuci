// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import tailwindcss from '@tailwindcss/vite';

// export default defineConfig({
//     plugins: [
//         tailwindcss(),
//         laravel([
//             'resources/css/app.css',
//             'resources/js/app.js',
//         ]),
//     ],
//     build: {
//         outDir: 'dist', // Menentukan folder output hasil build
//         emptyOutDir: true, // Menghapus isi folder sebelum build baru
//     },
// });

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import tailwindcss from '@tailwindcss/vite';

// export default defineConfig({
//   plugins: [
//     tailwindcss(),
//     laravel({
//       input: ['resources/css/app.css', 'resources/js/app.js'],
//       refresh: true,
//     }),
//   ],
//   build: {
//     manifest: true,
//     outDir: 'public/build',
//     emptyOutDir: true,
//   },
// });

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';

// export default defineConfig({
//   plugins: [
//     laravel({
//       input: ['resources/css/app.css', 'resources/js/app.js'],
//       refresh: true,
//     }),
//   ],
//   build: {
//     manifest: true, // Pastikan ini true
//     outDir: 'public/build',
//     emptyOutDir: true,
//   },
// });
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: false, // Nonaktifkan untuk production
    }),
  ],
  build: {
    manifest: true, // Wajib true
    outDir: 'public/build', // Wajib sesuai
    emptyOutDir: true,
    rollupOptions: {
      output: {
        assetFileNames: 'assets/[name]-[hash][extname]',
        entryFileNames: 'assets/[name]-[hash].js'
      }
    }
  }
});
// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';

// export default defineConfig({
//   plugins: [
//     laravel({
//       input: [
//         'resources/css/app.css',
//         'resources/js/app.js'
//       ],
//       refresh: true,
//     }),
//   ],
//   build: {
//     manifest: true,
//     outDir: 'public/build',
//     emptyOutDir: true,
//   }
// });