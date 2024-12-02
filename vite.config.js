import laravel from 'laravel-vite-plugin';
import {defineConfig} from 'vite';
import manifestSRI from 'vite-plugin-manifest-sri';

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern',
                // See the Deprecations interface in https://github.com/sass/sass/blob/main/js-api-doc/deprecations.d.ts for the list of IDs
                silenceDeprecations: [
                    'color-functions', // Global color functions are deprecated in favor of the sass:color module (Bootstrap needs to fix this)
                    'global-builtin', // Global built-in functions are deprecated in favor of the sass: modules (as of this writing, all of these uses are from Bootstrap)
                    'import', // @import is deprecated in favor of the module system (i.e. @use)
                    'mixed-decls', // The remaining warnings for this deprecation are fixed in the upcoming Bootstrap 5.3.4 release
                ],
            },
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/docs.js',
                'resources/js/updates.js',
            ],
            refresh: true,
        }),
        manifestSRI(),
    ],
});
