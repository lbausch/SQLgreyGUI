<?php

// Authentication Routes...
$router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$router->post('login', 'Auth\LoginController@login');
$router->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//$VueRouter->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$VueRouter->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$router->post('password/reset', 'Auth\ResetPasswordController@reset');

$router->group(['middleware' => ['auth']], function ($router) {
    // Dashboard
    $router->get('/', 'HomeController@index');
    $router->get('dashboard', 'HomeController@index');
    $router->get('home', 'HomeController@index');

    // Greylist
    /*$VueRouter->get('greylist', 'GreylistController@index');
    $VueRouter->post('greylist/delete', 'GreylistController@delete');
    $VueRouter->post('greylist/move', 'GreylistController@move');
    $VueRouter->post('greylist/deletebydate', 'GreylistController@deleteByDate');

    // Whitelist
    $VueRouter->get('whitelist/emails', 'WhitelistController@showEmails');
    $VueRouter->post('whitelist/emails/add', 'WhitelistController@addEmail');
    $VueRouter->post('whitelist/deleteEmails', 'WhitelistController@deleteEmails');
    $VueRouter->get('whitelist/domains', 'WhitelistController@showDomains');
    $VueRouter->post('whitelist/domains/add', 'WhitelistController@addDomain');
    $VueRouter->post('whitelist/deleteDomains', 'WhitelistController@deleteDomains');

    // OptOut
    $VueRouter->get('optout/emails', 'OptOutController@showEmails');
    $VueRouter->post('optout/emails/add', 'OptOutController@addEmail');
    $VueRouter->post('optout/emails/delete', 'OptOutController@deleteEmails');
    $VueRouter->get('optout/domains', 'OptOutController@showDomains');
    $VueRouter->post('optout/domains/add', 'OptOutController@addDomain');
    $VueRouter->post('optout/domains/delete', 'OptOutController@deleteDomains');

    // OptIn
    $VueRouter->get('optin/emails', 'OptInController@showEmails');
    $VueRouter->post('optin/emails/add', 'OptInController@addEmail');
    $VueRouter->post('optin/emails/delete', 'OptInController@deleteEmails');
    $VueRouter->get('optin/domains', 'OptInController@showDomains');
    $VueRouter->post('optin/domains/add', 'OptInController@addDomain');
    $VueRouter->post('optin/domains/delete', 'OptInController@deleteDomains');

    // Settings
    $VueRouter->get('settings', 'SettingController@index');
    $VueRouter->get('settings/password', 'SettingController@changePassword');
    $VueRouter->post('settings/password', 'SettingController@password');
    $VueRouter->get('settings/email', 'SettingController@changeEmail');
    $VueRouter->post('settings/email', 'SettingController@email');

    // Users
    $VueRouter->resource('admin/users', 'UserController');
    $VueRouter->post('admin/users/delete', 'UserController@deleteUsers');
    $VueRouter->get('admin/usertable', 'UserController@getTable');

    // About
    $VueRouter->get('about', 'AboutController@index');*/
});
