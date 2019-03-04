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
var dev = 'public/dev/';
var dist = 'public/dist/';

mix.styles([
    'resources/assets/plantilla/css/font-awesome.min.css',
    'resources/assets/plantilla/css/simple-line-icons.min.css',
    'resources/assets/plantilla/css/style.css',
    'resources/assets/plantilla/css/admin.css'
],  dev+'/css/plantilla.css')
    .styles([
        'resources/assets/css/datatables.css'
    ], dist + 'css/data-tables.min.css')
.scripts([
    'resources/assets/plantilla/js/jquery.min.js',
    'resources/assets/plantilla/js/popper.min.js',
    'resources/assets/plantilla/js/bootstrap.min.js',
    'resources/assets/plantilla/js/Chart.min.js',
    'resources/assets/plantilla/js/pace.min.js',
    'resources/assets/plantilla/js/template.js',
    'resources/assets/plantilla/js/sweetalert2.all.js'
], dev + 'js/plantilla.js')
.js(['resources/assets/js/app.js'], dev+'js/app.js')
.js(['resources/assets/plantilla/js/functions.js'], dev+'js/functions.js');
