import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tsconfigPaths from 'vite-tsconfig-paths';

export default defineConfig({
    test: {
        environment: 'jsdom',  // Set jsdom as the environment for Vitest
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.ts',
                'resources/sass/appBlog.scss',
                'resources/js/blog/appBlog.ts',
            ],
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
        tsconfigPaths(),
    ],
    resolve: {
        extensions: ['.js', '.ts', '.vue']
    },
    build: {
        rollupOptions: {
            output: {
                entryFileNames: '[name].[hash].js',
                chunkFileNames: '[name].[hash].js',
                assetFileNames: '[name].[hash].[ext]',
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        if (id.includes('primevue')) {
                            return 'primevue';
                        }
                        // Create a separate chunk for node_modules (vendor)
                        return 'vendor';
                    }
                }
            }
        }
    }
});
