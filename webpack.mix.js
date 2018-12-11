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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

//
// ORDER MODULE
mix.js(
    [
        'resources/assets/js/modules/order/Order.js',
        'resources/assets/js/modules/order/order-crud.js',
    ], 'public/js/modules/order')
    .sourceMaps();


mix.copy('resources/assets/js/modules/order/Order.js', 'public/js/modules/order');
mix.copy('resources/assets/js/modules/order/order-crud.js', 'public/js/modules/order');

mix.styles([
    'node_modules/air-datepicker/dist/css/datepicker.css',
], 'public/css/datepicker.css');
