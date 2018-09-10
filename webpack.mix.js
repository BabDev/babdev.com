const mix = require('laravel-mix');

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
    .extract(['jquery', 'bootstrap/js/dist/util', 'bootstrap/js/dist/collapse']);

mix
    .sass('resources/sass/app.scss', 'public/css', [
        require('autoprefixer')({
            browsers: [
                'last 2 versions',
            ]
        })
    ]);

mix.copy('resources/images', 'public/images', false);
