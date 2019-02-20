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
   .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'public/css/main.css',
    'public/css/animate.min.css',
    'public/css/bootstrap.min.css',
    'public/css/demo.css',
    'public/css/paper-dashboard.css',
    'public/css/themify-icons.css'
], 'public/css/all.css');

mix.js([
    'public/js/bootstrap.min.js',
    'public/js/bootstrap-notify.js',
    'public/js/chartist.min.js',
    'public/js/demo.js',
    'public/js/paper-dashboard.js',
    'public/js/lazysizes.min.js',
], 'public/js/all.js');
