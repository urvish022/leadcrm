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

mix.combine([
    'public/assets/coreui/coreui.min.css',
    'public/assets/datatables/jquery.dataTables.min.css',
    'public/assets/toastr/toastr.min.css',
    'public/assets/trumbowyg/dist/ui/trumbowyg.min.css',
    'public/assets/datetimepicker/build/jquery.datetimepicker.min.css',
], 'public/css/plugins.css');

mix.combine([
    'public/assets/coreui/coreui.min.js',
    'public/assets/datatables/jquery.dataTables.min.js',
    'public/assets/trumbowyg/dist/trumbowyg.min.js',
    'public/assets/toastr/toastr.min.js',
    'public/assets/copiq/jquery.copiq.js',
    'public/assets/clipboard/clipboard.min.js',
    'public/assets/datetimepicker/build/jquery.datetimepicker.full.min.js',
], 'public/js/plugins.js');
