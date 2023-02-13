const mix = require('laravel-mix');
//const webpackConfig = require('./webpack.config');
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

mix.js('resources/js/heater.js', 'public/js')
    //.webpackConfig(webpackConfig)
    .vue()
    .sass('resources/sass/main.scss', 'public/css');
