let mix = require('laravel-mix').mix;


mix.js('resources/assets/js/app.js','public/js')
	.sass('resources/assets/sass/main.scss','public/test.css');