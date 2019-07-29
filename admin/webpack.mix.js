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

var resourceTemplate = 'resources/assets/';
var template = resourceTemplate + 'plantilla/';
var resourceCss = template + 'css/';
var resourceJS = template + 'js/';
var pathMintos = 'resources/mintos-assets/';


var plugins = resourceJS + 'plugins/';

var publicPath = 'public/';
var cssDist = publicPath + 'css/';
var jsDist = publicPath + 'js/';
var pluginsDist = jsDist + 'plugins/';

var images = 'images/';

mix.styles( [
        resourceCss + 'main.css',
    ], cssDist + 'main.min.css' )
    .scripts( [
        resourceJS + 'jquery-3.2.1.min.js'
    ], jsDist + 'jquery-3.2.1.min.js' ).sourceMaps()
    .scripts( [
        resourceJS + '/bootstrap.min.js'
    ], jsDist + 'bootstrap.min.js' ).sourceMaps()
    .scripts( [
        resourceJS + 'popper.min.js'
    ], jsDist + 'popper.min.js' ).sourceMaps()
    .scripts( [
        plugins + 'pace.min.js'
    ], pluginsDist + 'pace.min.js' ).sourceMaps()
    .scripts( [
        plugins + 'chart.js'
    ], pluginsDist + 'chart.min.js' ).sourceMaps()
    .scripts( [
        resourceJS + 'functions.js',
        resourceJS + 'main.js'
    ], jsDist + 'main.min.js' ).sourceMaps()
    .copyDirectory( [
            template + images + 'logo.png',
            template + images + 'cover-page-default.jpg',
            template + images + 'user-default.jpg',
            template + images + 'projects/project-4.jpg',
            template + images + 'favicon.ico',
            template + images + 'not-image-product.png',
            template + images + 'placeholder-upload.png',
            template + images + 'marca_agua.png',
            template + images + 'logo.png',
            template + images + 'generic.png'
        ], publicPath + images )
    .scripts( [
        resourceJS + 'login-colaborator.js'
    ], jsDist + 'login-colaborator.min.js' ).sourceMaps()
    .sass('resources/sass/styles-admin.scss', 'public/css/styles-admin.min.css')

    /*Module: Generales*/
    .js([ 'resources/js/modules/dashboard.js' ], jsDist + 'modules/dashboard.min.js')
    .js([ 'resources/js/modules/profile.js' ], jsDist + 'modules/profile.min.js')

    /*Module 1: Seguridad*/
    .js([ 'resources/js/modules/module.js' ], jsDist + 'modules/module.min.js')
    .js([ 'resources/js/modules/page.js' ], jsDist + 'modules/page.min.js')
    .js([ 'resources/js/modules/logs.js' ], jsDist + 'modules/logs.min.js')

    /*Module 2: Accesos*/
    .js([ 'resources/js/modules/access.js' ], jsDist + 'modules/access.min.js')
    .js([ 'resources/js/modules/role.js' ], jsDist + 'modules/role.min.js')
    .js([ 'resources/js/modules/user.js' ], jsDist + 'modules/user.min.js')

    /*Module 3: Configuración*/
    .js([ 'resources/js/modules/unity.js' ], jsDist + 'modules/unity.min.js')
    .js([ 'resources/js/modules/categories.js' ], jsDist + 'modules/categories.min.js')
    .js([ 'resources/js/modules/sites.js' ], jsDist + 'modules/sites.min.js')
    .js([ 'resources/js/modules/icons.js' ], jsDist + 'modules/icons.min.js')

    /*Module 4: Eventos*/
    .js([ 'resources/js/modules/holidays.js' ], jsDist + 'modules/holidays.min.js')
    .js([ 'resources/js/modules/calendar.js' ], jsDist + 'modules/calendar.min.js')

    /*Module 5: Almacén*/
    .js([ 'resources/js/modules/products.js' ], jsDist + 'modules/products.min.js')
    .js([ 'resources/js/modules/presentation.js' ], jsDist + 'modules/presentation.min.js')
    .js([ 'resources/js/modules/stock.js' ], jsDist + 'modules/stock.min.js')

    /*Module 6: Compras*/
    .js([ 'resources/js/modules/providers.js' ], jsDist + 'modules/providers.min.js')
    .js([ 'resources/js/modules/purchase-request.js' ], jsDist + 'modules/purchase-request.min.js')
    .js([ 'resources/js/modules/quotation.js' ], jsDist + 'modules/quotation.min.js')

    /*Module 7: Ventas*/
    .js([ 'resources/js/modules/customers.js' ], jsDist + 'modules/customers.min.js')

    .copyDirectory( pathMintos, 'public/assets/' )
    .extract(['vue'])
    .version();

mix.webpackConfig({
    module: {
        rules: [
            {
                enforce: 'pre',
                exclude: /node_modules/
            }
        ]
    }
});
