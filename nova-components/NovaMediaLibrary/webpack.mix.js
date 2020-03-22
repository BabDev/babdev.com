const mix = require('laravel-mix');

mix.setPublicPath('dist');

mix.js('resources/js/field.js', 'js');

mix.sass('resources/sass/field.scss', 'css')
    .options({
        postCss: [
            require('autoprefixer')()
        ]
    })
;
