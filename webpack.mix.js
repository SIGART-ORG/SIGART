let mix = require('laravel-mix');

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
var dist = 'public/dev/';

mix.styles([
    'resources/assets/plantilla/css/font-awesome.min.css',
    'resources/assets/plantilla/css/simple-line-icons.min.css',
    'resources/assets/plantilla/css/style.css',
    'resources/assets/plantilla/css/admin.css'
],  dist+'/css/plantilla.css')
.scripts([
    'resources/assets/plantilla/js/jquery.min.js',
    'resources/assets/plantilla/js/popper.min.js',
    'resources/assets/plantilla/js/bootstrap.min.js',
    'resources/assets/plantilla/js/Chart.min.js',
    'resources/assets/plantilla/js/pace.min.js',
    'resources/assets/plantilla/js/template.js',
    'resources/assets/plantilla/js/sweetalert2.all.js'
], dist + 'js/plantilla.js')
.js(['resources/assets/js/app.js'], dist+'js/app.js')
.js(['resources/assets/plantilla/js/functions.js'], dist+'js/functions.js');
