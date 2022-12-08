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

mix.js('resources/js/app.js', 'public/js').
    js('resources/js/like.js', 'public/js').
    js('resources/js/memo-modal.js', 'public/js').
    js('resources/js/memo-accordion.js', 'public/js').
    js('resources/js/setting.js', 'public/js').
    js('resources/js/header.js', 'public/js')
    .autoload({
    "jquery": ['$', 'window.jQuery'],
})
   .sass('resources/sass/app.scss', 'public/css');
