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
        $router->get('me', 'v1\Controllers\UserController@me');
        $router->patch('me', 'v1\Controllers\UserController@update');
        $router->post('me/password', 'v1\Controllers\UserController@password');

        $router->get('stats', 'v1\Controllers\StatsController@index');

        $router->get('greylist', 'v1\Controllers\GreylistController@index');
        $router->post('greylist', 'v1\Controllers\GreylistController@delete');

        $router->get('whitelist/emails', 'v1\Controllers\WhitelistController@emails');
        $router->post('whitelist/emails/add', 'v1\Controllers\WhitelistController@addEmail');
        $router->post('whitelist/emails', 'v1\Controllers\WhitelistController@deleteEmails');

        $router->get('whitelist/domains', 'v1\Controllers\WhitelistController@domains');
        $router->post('whitelist/domains/add', 'v1\Controllers\WhitelistController@addDomain');
        $router->post('whitelist/domains', 'v1\Controllers\WhitelistController@deleteDomains');
    });
});
