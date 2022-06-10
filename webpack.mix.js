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
                    corejs: 3,
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
                standard: [
                    // highlight.js
                    /^.hljs/, /^.hljs-/, /^hljs/, /^hljs-/,
                    // Bootstrap Tables
                    /^.table/, /^.table-/, /^table/, /^tr/, /^td/, /^th/, /^thead/, /^tbody/, /^tfoot/,
                    // App styles
                    /^docs-note/,
                ],
                deep: [
                    // highlight.js
                    /^.hljs/, /^.hljs-/, /^hljs/, /^hljs-/,
                    // Bootstrap Tables
                    /^.table/, /^.table-/, /^table/, /^tr/, /^td/, /^th/, /^thead/, /^tbody/, /^tfoot/,
                    // App styles
                    /^docs-note/,
                ],
            },
        },
    })
;

mix.generateIntegrityHash({
    algorithm: 'sha384',
    enabled: true,
});

mix.copy('resources/images', 'public/images', false);

if (mix.inProduction()) {
    mix.version();
}
