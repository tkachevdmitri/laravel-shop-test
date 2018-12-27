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
/*
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
*/
// npm run dev


// работа с файлами для фронтенда
mix.styles([
    'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/font-awesome.min.css',
    'resources/assets/css/prettyPhoto.css',
    'resources/assets/css/price-range.css',
    'resources/assets/front/css/animate.min.css',
    'resources/assets/css/main.css',
    'resources/assets/css/responsive.css',
], 'public/css/front.css');


mix.scripts([
    'resources/assets/js/jquery.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/jquery.scrollUp.min.js',
    'resources/assets/js/price-range.js',
    'resources/assets/js/jquery.prettyPhoto.js',
    'resources/assets/js/main.js',
], 'public/js/front.js');

mix.copy('resources/assets/js/html5shiv.js', 'public/js');

mix.copy('resources/assets/fonts', 'public/fonts');
mix.copy('resources/assets/images', 'public/images');
