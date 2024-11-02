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

 //mix.js('resources/js/assets-charts.js', 'public/js')
    //.sass('resources/sass/app-master.scss', 'public/css');

//mix.js('resources/js/app-master.js', 'public/js').vue()
    //.sass('resources/sass/app-master.scss', 'public/css');

    //.copy('node_modules/jquery-ui/dist/themes/base/jquery-ui.css', 'public/css')
    //.copy('node_modules/jquery-ui/dist/jquery-ui.min.js', 'public/js');

mix.js('resources/js/basic.js', 'public/js')
   .js('resources/js/auth.js', 'public/js')
   .sass('resources/sass/basic.scss', 'public/css')
   .sass('resources/sass/auth.scss', 'public/css');
  