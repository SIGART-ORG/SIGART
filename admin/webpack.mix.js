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
        resourceJS + 'main.js'
    ], jsDist + 'main.min.js' ).sourceMaps()
    .copyDirectory( [
            template + images + 'logo.png',
            template + images + 'cover-page-default.jpg',
            template + images + 'user-default.jpg',
            template + images + 'projects/project-4.jpg',
            template + images + 'favicon.ico',
            template + images + 'logo.png'
        ], publicPath + images )
    .js(['resources/js/app.js'], jsDist + 'app.min.js');

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
