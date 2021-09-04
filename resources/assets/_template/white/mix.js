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
 | ADMIN
 |--------------------------------------------------------------------------
 |
 */
mix.sass('resources/assets/_template/white/sass/vendor.scss', 'public/assets/admin/css/vendor.css').version();
mix.sass('resources/assets/_template/white/sass/style.scss', 'public/assets/admin/css/style.css').version();

mix.js('resources/assets/_template/white/js/admin/vendor.bundle.js', 'public/assets/admin/js')
    .js('resources/assets/_template/white/js/admin/template-core.js', 'public/assets/admin/js')
    .js('resources/assets/_template/white/js/admin/app.js', 'public/assets/admin/js')
    .copy('resources/assets/_template/white/js/plugins/modernizr.custom.js', 'public/assets/admin/js')
    .version();

mix.copyDirectory([
    'node_modules/font-awesome/fonts',
    'node_modules/@fortawesome/fontawesome-free/webfonts',
    'resources/assets/_template/white/sass/admin/template/pages-icon/fonts'
], 'public/fonts');

mix.copyDirectory([
    'resources/assets/_template/white/img'
], 'public/assets/img');

mix.copyDirectory([
    'node_modules/slick-carousel/slick/fonts',
], 'public/assets/admin/css/fonts');

mix.copyDirectory([
    'node_modules/summernote/dist/font',
], 'public/assets/admin/css/font');

mix.copyDirectory([
    'node_modules/slick-carousel/slick/ajax-loader.gif',
], 'public/assets/admin/css/');

mix.copyDirectory([
    'resources/assets/_template/white/ico'
], 'public/assets/ico');