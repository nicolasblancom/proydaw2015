var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	/**
	 * Nombres:
	 * main.ext: viene de compilar y/o concatenar
	 * all.ext: viene de concatenar
	 */

	// SASS
    mix.sass([
    	'main.sass'
    ], 'public/output/css/all.css');

    // CSS
    /*mix.styles([
    	'_main.css'
    ], 'public/output/css/all.css', 'public/output/css');*/

    // JS
    mix.scripts([
    	// origen resources/assets/js
    	'jquery.js',
    	'bootstrap.js',
    	'functions.js'
    ], 'public/output/js/all.js');

    /*mix.version([
    	'output/css/all.css',
    	'output/js/all.js',
    ]);*/

});
