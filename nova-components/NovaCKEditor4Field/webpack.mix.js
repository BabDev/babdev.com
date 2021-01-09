const mix = require('laravel-mix');

mix.setPublicPath('dist');

mix.js('resources/js/field.js', 'js').vue();
