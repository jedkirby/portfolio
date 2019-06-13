var elixir = require('laravel-elixir');

elixir(function(mix){

	mix
		.sass(
			'main.scss',
			'public/assets/css/build/main.css'
		)
		.scriptsIn(
			'resources/assets/js/vendor',
			'public/assets/js/build/vendor.js'
		)
		.scriptsIn(
			'resources/assets/js/app',
			'public/assets/js/build/app.js'
		)
		.version([
			'public/assets/css/build/main.css',
			'public/assets/js/build/vendor.js',
			'public/assets/js/build/app.js'
		]);

});
