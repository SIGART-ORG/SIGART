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
var bootstrap = template + 'vendor/bootstrap/';
var bootstrapMultiselect = template + 'vendor/bootstrap-multiselect/';
var fontAwesome = template + 'vendor/font-awesome/';
var magnificPopup = template + 'vendor/magnific-popup/';
var skins = template + 'stylesheets/skins/';
var modernizr = template + 'vendor/modernizr/';
var jqueryDir = template + 'vendor/jquery/';
var dirJBM = template + 'vendor/jquery-browser-mobile/';
var nanoscroller = template + 'vendor/nanoscroller/';
var bootstrapDatepicker = template + 'vendor/bootstrap-datepicker/';
var jqueryPlaceholder = template + 'vendor/jquery-placeholder/';
var jqueryUI = template + 'vendor/jquery-ui/';
var jqueryUiTouchPunch = template + 'vendor/jquery-ui-touch-punch/';
var jqueryAppear = template + 'vendor/jquery-appear/';
var jqueryEasypiechart = template + 'vendor/jquery-easypiechart/';
var jqueryFlot = template + 'vendor/flot/';
var jqueryFlotTooltip = template + 'vendor/flot-tooltip/';
var jquerySparkline = template + 'vendor/jquery-sparkline/';
var raphael = template + 'vendor/raphael/';
var morris = template + 'vendor/morris/';
var gauge = template + 'vendor/gauge/';
var snapSvg = template + 'vendor/snap-svg/';
var liquidMeter = template + 'vendor/liquid-meter/';
var jqvmap = template + 'vendor/jqvmap/';
var javascripts = template + 'javascripts/';

var publicPath = 'public/';
var cssDist = publicPath + 'css/';
var jsDist = publicPath + 'js/';

var distBootstrap = cssDist + 'bootstrap/';
var distFontAwesome = cssDist + 'font-awesome/';
var distMagnificPopup = cssDist + 'magnific-popup/';
var distJquery = jsDist + 'jquery/';
var distJqueryCss = cssDist + 'jquery/';
var distMorrisCss = cssDist + 'morris/';

var distSkin = cssDist + 'skins/';
var distModernizr = jsDist + 'modernizr/';
var distBootstrapJS = jsDist + 'bootstrap/';
var distNanoscroller = jsDist + 'nanoscroller/';
var distMagnificPopupJS = jsDist + 'magnific-popup/';
var distRaphaelJS = jsDist + 'raphael/';
var distMorrisJS = jsDist + 'morris/';
var distGaugeJS = jsDist + 'gauge/';
var distSnapSvgJS = jsDist + 'snap-svg/';
var distLiquidMeterJS = jsDist + 'liquid-meter/';
var distThemeJS = jsDist + 'theme/';
var development = jsDist + 'development/';

var images = 'images/';

mix.styles( [
        bootstrap + 'css/bootstrap.css',
    ], distBootstrap + 'bootstrap.min.css' )
    .styles( [
        jqueryUI + 'css/ui-lightness/jquery-ui-1.10.4.custom.css',
    ], distJqueryCss + 'jquery-ui-1.10.4.custom.min.css' )
    .styles( [
        bootstrapMultiselect + 'bootstrap-multiselect.css',
    ], distBootstrap + 'bootstrap-multiselect.min.css' )
    .styles( [
        morris + 'morris.css',
    ], distMorrisCss + 'morris.min.css' )
    .styles( [
        fontAwesome + 'css/font-awesome.css'
    ], distFontAwesome + 'style/font-awesome.min.css' )
    .styles( [
        magnificPopup + 'magnific-popup.css'
    ], distMagnificPopup + 'magnific-popup.min.css' )
    .styles( [
        bootstrapDatepicker + 'css/datepicker3.css'
    ], distBootstrap + 'datepicker3.min.css' )
    .styles( [
        template + 'stylesheets/theme.css'
    ], cssDist + 'theme.min.css' )
    .styles( [
        skins + 'default.css'
    ], distSkin + 'default.min.css' )
    .scripts( [
        modernizr + 'modernizr.js'
    ], distModernizr + 'modernizr.min.js' ).sourceMaps()
    .scripts( [
        jqueryDir + 'jquery.js'
    ], distJquery + 'jquery.min.js' ).sourceMaps()
    .scripts( [
        dirJBM + 'jquery.browser.mobile.js'
    ], distJquery + 'jquery.browser.mobile.min.js' ).sourceMaps()
    .scripts( [
        bootstrap + '/js/bootstrap.js'
    ], distBootstrapJS + 'bootstrap.min.js' ).sourceMaps()
    .scripts( [
        nanoscroller + 'nanoscroller.js'
    ], distNanoscroller + 'nanoscroller.min.js' ).sourceMaps()
    .scripts( [
        bootstrapDatepicker + 'js/bootstrap-datepicker.js'
    ], distBootstrapJS + 'bootstrap-datepicker.min.js' ).sourceMaps()
    .scripts( [
        magnificPopup + 'magnific-popup.js'
    ], distMagnificPopupJS + 'magnific-popup.min.js' ).sourceMaps()
    .scripts( [
        jqueryPlaceholder + 'jquery.placeholder.js'
    ], distJquery + 'jquery.placeholder.min.js' ).sourceMaps()
    .scripts( [
        jqueryUI + 'js/jquery-ui-1.10.4.custom.js'
    ], distJquery + 'query-ui-1.10.4.custom.min.js' ).sourceMaps()
    .scripts( [
        jqueryUiTouchPunch + 'jquery.ui.touch-punch.js'
    ], distJquery + 'jquery.ui.touch-punch.min.js' ).sourceMaps()
    .scripts( [
        jqueryUiTouchPunch + 'jquery.appear.js'
    ], distJquery + 'jquery.appear.min.js' ).sourceMaps()
    .scripts( [
        jqueryAppear + 'jquery.appear.js'
    ], distJquery + 'jquery.appear.min.js' ).sourceMaps()
    .scripts( [
        bootstrapMultiselect + 'bootstrap-multiselect.js'
    ], distBootstrapJS + 'bootstrap-multiselect.min.js' ).sourceMaps()
    .scripts( [
        jqueryEasypiechart + 'jquery.easypiechart.js'
    ], distJquery + 'jquery.easypiechart.min.js' ).sourceMaps()
    .scripts( [
        jqueryFlot + 'jquery.flot.js'
    ], distJquery + 'jquery.flot.min.js' ).sourceMaps()
    .scripts( [
        jqueryFlotTooltip + 'jquery.flot.tooltip.js'
    ], distJquery + 'jquery.flot.tooltip.min.js' ).sourceMaps()
    .scripts( [
        jqueryFlot + 'jquery.flot.pie.js'
    ], distJquery + 'jquery.flot.pie.min.js' ).sourceMaps()
    .scripts( [
        jqueryFlot + 'jquery.flot.categories.js'
    ], distJquery + 'jquery.flot.categories.min.js' ).sourceMaps()
    .scripts( [
        jqueryFlot + 'jquery.flot.resize.js'
    ], distJquery + 'jquery.flot.resize.min.js' ).sourceMaps()
    .scripts( [
        jquerySparkline + 'jquery.sparkline.js'
    ], distJquery + 'jquery.sparkline.min.js' ).sourceMaps()
    .scripts( [
        raphael + 'raphael.js'
    ], distRaphaelJS + 'raphael.min.js' ).sourceMaps()
    .scripts( [
        morris + 'morris.js'
    ], distMorrisJS + 'morris.min.js' ).sourceMaps()
    .scripts( [
        gauge + 'gauge.js'
    ], distGaugeJS + 'gauge.min.js' ).sourceMaps()
    .scripts( [
        snapSvg + 'snap.svg.js'
    ], distSnapSvgJS + 'snap.svg.min.js' ).sourceMaps()
    .scripts( [
        liquidMeter + 'liquid.meter.js'
    ], distLiquidMeterJS + 'liquid.meter.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'jquery.vmap.js'
    ], distJquery + 'jquery.vmap.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'data/jquery.vmap.sampledata.js'
    ], distJquery + 'jquery.vmap.sampledata.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'maps/jquery.vmap.world.js'
    ], distJquery + 'vmap.world.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'maps/continents/jquery.vmap.africa.js'
    ], distJquery + 'jquery.vmap.africa.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'maps/continents/jquery.vmap.asia.js'
    ], distJquery + 'jquery.vmap.asia.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'maps/continents/jquery.vmap.australia.js'
    ], distJquery + 'jquery.vmap.australia.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'maps/continents/jquery.vmap.europe.js'
    ], distJquery + 'jquery.vmap.europe.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'maps/continents/jquery.vmap.north-america.js'
    ], distJquery + 'jquery.vmap.north-america.min.js' ).sourceMaps()
    .scripts( [
        jqvmap + 'maps/continents/jquery.vmap.south-america.js'
    ], distJquery + 'jquery.vmap.south-america.min.js' ).sourceMaps()
    .scripts( [
        javascripts + 'theme.js'
    ], distThemeJS + 'theme.min.js' ).sourceMaps()
    .scripts( [
        javascripts + 'theme.custom.js'
    ], distThemeJS + 'theme.custom.min.js' ).sourceMaps()
    .scripts( [
        javascripts + 'theme.init.js'
    ], distThemeJS + 'theme.init.min.js' ).sourceMaps()
    .scripts( [
        javascripts + 'dashboard/examples.dashboard.js'
    ], development + 'dashboard.min.js' ).sourceMaps()
    .copyDirectory( bootstrap + 'fonts/', distBootstrap + 'fonts/')
    .copyDirectory( fontAwesome + 'fonts/', distFontAwesome + 'fonts/')
    .copyDirectory( [
            template + images + 'logo.png',
            template + images + '!logged-user.jpg',
            template + images + '!sample-user.jpg',
            template + images + 'projects/project-4.jpg',
            template + images + 'favicon.ico'
        ], publicPath + images )
    .js(['resources/js/app.js'], jsDist + 'app.min.js');
