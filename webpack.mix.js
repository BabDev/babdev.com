const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-purgecss');

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
    .js('resources/js/updates.js', 'public/js');

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
                standard: [/^hljs/, /^hljs-/, /^table-/, /^docs-note/],
                deep: [/^hljs/, /^hljs-/, /^table/, /^docs-note/],
            },
        },
    })
    .sourceMaps() // Required due to https://github.com/JeffreyWay/laravel-mix/issues/2678
;

mix.copy('resources/images', 'public/images', false);

if (Mix.inProduction()) {
    mix.version();
}
