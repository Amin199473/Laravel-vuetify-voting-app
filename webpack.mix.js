let mix = require('laravel-mix');

mix.copy('node_modules/@mdi/font/fonts/', 'public/dist/fonts/')
    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css').vue({ version: 3 });
