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

mix.js(['node_modules/jquery/dist/jquery.js',
            'resources/js/app.js',
            'resources/js/lib/core.js',
            'resources/js/lib/maps.js',
            'resources/js/lib/animated.js',
            'resources/js/lib/charts.js',
            'resources/js/lib/worldHigh.js',
            'node_modules/chart.js/dist/Chart.min.js',
            'resources/js/lib/dataTables.js',
        ],

        'public/js/app.js')
    .postCss('resources/css/main.css', 'public/css', [
        require('tailwindcss'),
        //  require('bootstrap')
    ])
    .sass('resources/sass/app.scss', 'public/css');
