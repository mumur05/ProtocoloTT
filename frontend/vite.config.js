import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'node:path';

// Las vistas se compilan directamente a la raiz del proyecto (donde XAMPP sirve los .php),
// con nombres de assets estables para que los archivos .php puedan referenciarlos.
export default defineConfig({
  root: __dirname,
  base: './',
  plugins: [react()],
  build: {
    outDir: resolve(__dirname, '..'),
    emptyOutDir: false,
    rollupOptions: {
      input: {
        inicio: resolve(__dirname, 'inicio.html'),
        iniciarSesion: resolve(__dirname, 'iniciarSesion.html'),
        registro: resolve(__dirname, 'registro.html'),
      },
      output: {
        entryFileNames: 'assets/[name].js',
        chunkFileNames: 'assets/[name].js',
        assetFileNames: 'assets/[name].[ext]',
      },
    },
  },
});
