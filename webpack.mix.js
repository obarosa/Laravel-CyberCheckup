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

mix.autoload({
    jquery: ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"],
    'popper.js/dist/umd/popper.js': ['Popper']
})
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/backoffice/utilizadores.js', 'public/js')
    .js('resources/js/backoffice/tipos.js', 'public/js')
    .js('resources/js/backoffice/categorias.js', 'public/js')
    .js('resources/js/backoffice/questoes.js', 'public/js')
    .js('resources/js/backoffice/respostas.js', 'public/js')
    .js('resources/js/backoffice/dashboard.js', 'public/js')
    .js('resources/js/backoffice/respondidas.js', 'public/js')
    .js('resources/js/backoffice/tentativas.js', 'public/js')
    .js('resources/js/frontoffice/home.js', 'public/js')
    .js('resources/js/frontoffice/questionario.js', 'public/js')
    .js('resources/js/frontoffice/resultado.js', 'public/js')
    .postCss('resources/css/frontoffice.css', 'public/css')
    .postCss('resources/css/backoffice.css', 'public/css')
    .copy('resources/imgs', 'public/assets/imgs')
    .postCss('resources/css/app.css', 'public/css',
        [
            require('tailwindcss'),
            require('autoprefixer'),
        ]);
