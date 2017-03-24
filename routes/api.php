<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group(['prefix' => 'v1'], function ($router) {
    //$router->post('auth', 'v1\Controllers\AuthController@auth');

    $router->group(['middleware' => 'auth:api'], function ($router) {
        $router->get('stats', 'v1\Controllers\StatsController@index');

        $router->get('greylist', 'v1\Controllers\GreylistController@index');
        $router->post('greylist', 'v1\Controllers\GreylistController@delete');
    });
});
