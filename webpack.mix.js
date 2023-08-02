const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .sass('resources/sass/app.scss', 'public/css')
    .scripts([
        'resources/vendor/modernizr/modernizr.js',
        'resources/vendor/jquery/jquery.js',
        'resources/vendor/jquery-browser-mobile/jquery.browser.mobile.js',
        'resources/vendor/popper/umd/popper.min.js',
        'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'resources/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'resources/vendor/common/common.js',
        'resources/vendor/nanoscroller/nanoscroller.js',
        'resources/vendor/magnific-popup/jquery.magnific-popup.js',
        'resources/vendor/jquery-placeholder/jquery.placeholder.js',
        'resources/vendor/jquery-ui/jquery-ui.js',
        'resources/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js',
        'resources/vendor/jquery-appear/jquery.appear.js',
        'resources/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js',
        'resources/js/theme.js',
        'resources/js/custom.js',
        'resources/js/theme.init.js',
    ], 'public/js/vendor.js')
    .styles([
        'resources/vendor/bootstrap/css/bootstrap.css',
        'resources/vendor/animate/animate.compat.css',
        'resources/vendor/boxicons/css/boxicons.min.css',
        'resources/vendor/magnific-popup/magnific-popup.css',
        'resources/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css',
        'resources/vendor/jquery-ui/jquery-ui.css',
        'resources/vendor/jquery-ui/jquery-ui.theme.css',
        'resources/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css',
        'resources/css/theme.css',
        'resources/css/skins/default.css',
        'resources/css/custom.css',
    ], 'public/css/vendor.css').copy(
        'node_modules/@fortawesome/fontawesome-free/webfonts',
        'public/webfonts'
    );