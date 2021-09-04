const mix = require('laravel-mix');
mix.options({
    processCssUrls: false
}).disableNotifications();

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'inline-source-map'
    }).sourceMaps();
}
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

/*
 |--------------------------------------------------------------------------
 | Core
 |--------------------------------------------------------------------------
 |
 */
mix.setPublicPath('./public');
const assets_path = 'public/assets/base';

mix.scripts([
    'node_modules/gentelella/vendors/jquery/dist/jquery.min.js',
    'node_modules/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js',
    'node_modules/gentelella/vendors/fastclick/lib/fastclick.js',
    'node_modules/gentelella/vendors/nprogress/nprogress.js',
    'node_modules/gentelella/vendors/Chart.js/dist/Chart.min.js',
    'node_modules/gentelella/vendors/gauge.js/dist/gauge.min.js',
    'node_modules/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
    'node_modules/gentelella/vendors/iCheck/icheck.min.js',
    'node_modules/gentelella/vendors/switchery/dist/switchery.min.js',
    'node_modules/gentelella/vendors/select2/dist/js/select2.full.min.js',
    'node_modules/gentelella/vendors/skycons/skycons.js',
    'node_modules/gentelella/vendors/Flot/jquery.flot.js',
    'node_modules/gentelella/vendors/Flot/jquery.flot.pie.js',
    'node_modules/gentelella/vendors/Flot/jquery.flot.time.js',
    'node_modules/gentelella/vendors/Flot/jquery.flot.resize.js',
    'node_modules/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js',
    'node_modules/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js',
    'node_modules/gentelella/vendors/flot.curvedlines/curvedLines.js',
    'node_modules/gentelella/vendors/DateJS/build/date.js',
    'node_modules/gentelella/vendors/jqvmap/dist/jquery.vmap.js',
    'node_modules/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js',
    'node_modules/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js',
    'node_modules/gentelella/vendors/moment/min/moment.min.js',
    'node_modules/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js',
    'node_modules/gentelella/build/js/custom.min.js',
    'node_modules/pace-progress/pace.js',
    'node_modules/jquery-validation/dist/jquery.validate.js',
    'node_modules/jQuery-QueryBuilder/dist/js/query-builder.standalone.js',
    // 'node_modules/interactjs/dist/interact.js',
    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    'node_modules/bootstrap-select/dist/js/bootstrap-select.js'
    // 'node_modules/moment/dist/moment.js'
], assets_path + '/js/vendor.js').version();

mix.js('resources/assets/_template/base/js/app.js',
    assets_path + '/js/app.js').version();

mix.styles([
    'node_modules/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css',
    'node_modules/gentelella/vendors/font-awesome/css/font-awesome.min.css',
    'node_modules/gentelella/vendors/nprogress/nprogress.css',
    'node_modules/gentelella/vendors/iCheck/skins/flat/green.css',
    'node_modules/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
    'node_modules/gentelella/vendors/jqvmap/dist/jqvmap.min.css',
    'node_modules/gentelella/vendors/switchery/dist/switchery.min.css',
    'node_modules/gentelella/vendors/select2/dist/css/select2.min.css',
    'node_modules/gentelella/build/css/custom.min.css',
    'node_modules/gentelella/vendors/animate.css/animate.css',
    'node_modules/guidechimp/dist/guidechimp.min.css',
    'node_modules/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css',
    'node_modules/pace-progress/themes/blue/pace-theme-minimal.css',
    'node_modules/jQuery-QueryBuilder/dist/css/query-builder.default.css',
    'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
    'node_modules/bootstrap-select/dist/css/bootstrap-select.css'
], assets_path + '/css/vendor.css').version();

mix.sass('resources/assets/_template/base/css/app.scss',
    assets_path + '/css/app.css').version();

mix.copy([
    'node_modules/font-awesome/fonts/',
    'node_modules/gentelella/vendors/bootstrap/dist/fonts',
], assets_path + '/fonts');

mix.copy([
    'node_modules/gentelella/vendors/iCheck/skins/flat',
], assets_path + "/css");

mix.copy([
    'resources/assets/_template/base/build/images/',
], assets_path + "/images");

mix.copy([
    'resources/assets/_template/base/images/favicon/',
], assets_path + "/favicon");

mix.copy([
    'resources/assets/_template/base/images/favicon/',
], assets_path + "/icon");