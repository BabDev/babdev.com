const mix = require('laravel-mix');
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
    .js('resources/js/updates.js', 'public/js')
    .extract(['jquery', 'popper.js']);

mix.sass('resources/sass/app.scss', 'public/css')
    .options({
        postCss: [
            require('autoprefixer')()
        ]
    })
    .purgeCss({
        extend: {
            content: [path.join(__dirname, 'vendor/babdev/laravel-breadcrumbs/**/*.php')],
            // Whitelist highlight styles and styles used only in docs
            whitelistPatterns: [/^hljs/, /^hljs-/, /^table-/, /^docs-note/],
            whitelistPatternsChildren: [/^hljs/, /^hljs-/, /^table/, /^docs-note/],
        },
    })
;

mix.copy('resources/images', 'public/images', false);

if (Mix.inProduction()) {
    mix.version();
}
