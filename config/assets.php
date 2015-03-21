<?php

/*
|---------------------------------------------------------------------------
| Here are SOME of the available configuration options with suitable values.
| Uncomment and customize those you want to override or remove them to
| use their default values. For a FULL list of options please visit
| https://github.com/Stolz/Assets/blob/master/API.md#assets
|---------------------------------------------------------------------------
*/

return array(

	/**
	 * Regex to match against a filename/url to determine if it is an asset.
	 *
	 * @var string
	 */
	//'asset_regex' => '/.\.(css|js)$/i',

	/**
	 * Regex to match against a filename/url to determine if it is a CSS asset.
	 *
	 * @var string
	 */
	//'css_regex' => '/.\.css$/i',

	/**
	 * Regex to match against a filename/url to determine if it is a JavaScript asset.
	 *
	 * @var string
	 */
	//'js_regex' => '/.\.js$/i',

	/**
	 * Absolute path to the public directory of your App (WEBROOT).
	 * Required if you enable the pipeline.
	 * No trailing slash!.
	 *
	 * @var string
	 */
	'public_dir' => (function_exists('public_path')) ? public_path() : '/var/www/localhost/htdocs',

	/**
	 * Directory for local CSS assets.
	 * Relative to your public directory ('public_dir').
	 * No trailing slash!.
	 *
	 * @var string
	 */
	'css_dir' => 'assets/css',

	/**
	 * Directory for local JavaScript assets.
	 * Relative to your public directory ('public_dir').
	 * No trailing slash!.
	 *
	 * @var string
	 */
	'js_dir' => 'assets/js',

	/**
	 * Directory for local package assets.
	 * Relative to your public directory ('public_dir').
	 * No trailing slash!.
	 *
	 * @var string
	 */
	//'packages_dir' => 'packages',

	/**
	 * Enable assets pipeline (concatenation and minification).
	 * If you set an integer value greather than 1 it will be used
	 * as a timestamp that will be added to the pipelined assets name.
	 *
	 * @var bool|integer
	 */
	'pipeline' => env('ASSETS_PIPELINE', false),

	/**
	 * Directory for storing pipelined assets.
	 * Relative to your assets directories ('css_dir' and 'js_dir').
	 * No trailing slash!.
	 *
	 * @var string
	 */
	'pipeline_dir' => '../min',

	/**
	 * Enable pipelined assets compression with Gzip.
	 * Use only if your webserver supports Gzip HTTP_ACCEPT_ENCODING.
	 * Set to true to use the default compression level.
	 * Set an integer between 0 (no compression) and 9 (maximum compression) to choose compression level.
	 *
	 * @var bool|integer
	 */
	//'pipeline_gzip' => false,

	/**
	 * Closure used by the pipeline to fetch assets.
	 *
	 * Useful when file_get_contents() function is not available in your PHP
	 * instalation or when you want to apply any kind of preprocessing to
	 * your assets before they get pipelined.
	 *
	 * The closure will receive as the only parameter a string with the path/URL of the asset and
	 * it should return the content of the asset file as a string.
	 *
	 * @var Closure
	 */
	//'fetch_command' => function ($asset) {return preprocess(file_get_contents($asset));},

	/**
	 * Available collections.
	 * Each collection is an array of assets.
	 * Collections may also contain other collections.
	 *
	 * @var array
	 */
	'collections' => [
            'bootstrap' => [
                'jquery',
                'bootstrap.css',
                'bootstrap.js',                
            ],
            
            'dataTables' => [
                'jquery',
                'jquery.dataTables.js',
                'dataTables.bootstrap.js',
                'dataTables.bootstrap.css',
                'dataTables.responsive.css',
            ],
            
            'font-awesome' => [
                'font-awesome.css',
            ],
            
            'jquery' => [
                'jquery.js'
            ],
            
            'metisMenu' => [
                'metisMenu.css',
                'metisMenu.js',
            ],
	],

	/**
	 * Preload assets.
	 * Here you may set which assets (CSS files, JavaScript files or collections)
	 * should be loaded by default even if you don't explicitly add them on run time.
	 *
	 * @var array
	 */
	'autoload' => [
            'jquery',
            'bootstrap',
            'metisMenu',
            'dataTables',
            'sb-admin-2.css',
            'sb-admin-2.js',
            'font-awesome',
            'app.css',
            'app.js',
        ],

);
