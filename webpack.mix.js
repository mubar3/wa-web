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

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

// Login
mix.styles([
    'resources/css/vendors/core/core.css',
    'resources/css/fonts/feather-font/css/iconfont.css',
    'resources/css/css/demo_1/style.css',
],'public/css/login.css');

mix.scripts([
    'resources/css/vendors/core/core.js',
    'resources/css/vendors/feather-icons/feather.min.js',
    'resources/css/js/template.js'
],'public/js/login.js');


// Master
mix.styles([
    'resources/css/vendors/core/core.css',
    // 'resources/css/fonts/feather-font/css/iconfont.css',
    'resources/css/css/feather.css',
    'resources/css/css/demo_1/style.css',
],'public/css/admin.css');

mix.scripts([
    'resources/css/vendors/core/core.js',
    // 'resources/css/vendors/feather-icons/feather.min.js',
    'resources/css/js/template.js'
],'public/js/admin.js');
