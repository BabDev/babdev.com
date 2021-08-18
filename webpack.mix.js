const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-purgecss');
require('laravel-mix-sri');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/docs.js', 'public/js')
    .js('resources/js/updates.js', 'public/js')
    .babelConfig({
        presets: [
            [
                '@babel/preset-env',
                {
                    modules: 'auto',
                    forceAllTransforms: false,
                    useBuiltIns: 'usage',
                    corejs: '3.16',
                }
            ]
        ],
        plugins: [
            '@babel/plugin-proposal-private-methods',
        ],
    });

mix.sass('resources/sass/app.scss', 'public/css')
    .options({
        postCss: [
            require('autoprefixer')()
        ],
    })
    .purgeCss({
        extend: {
            content: [path.join(__dirname, 'vendor/babdev/laravel-breadcrumbs/**/*.php')],
            // Allow highlight styles and styles used only in docs
            safelist: {
                standard: [/^.hljs/, /^.hljs-/, /^hljs/, /^hljs-/, /^table-/, /^docs-note/],
                deep: [/^.hljs/, /^.hljs-/, /^hljs/, /^hljs-/, /^table/, /^docs-note/],
            },
        },
    })
;

mix.generateIntegrityHash({
    algorithm: 'sha384',
    enabled: true,
});

mix.copy('resources/images', 'public/images', false);

if (Mix.inProduction()) {
    mix.version();
}
