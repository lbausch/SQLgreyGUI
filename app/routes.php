<?php

Route::group(array('before' => 'auth'), function() {
    // Dashboard
    Route::get('/', 'DashboardController@index');
    Route::get('dashboard', 'DashboardController@index');

    // Greylist
    Route::get('greylist', 'GreylistController@index');
    Route::post('greylist/delete', 'GreylistController@delete');
    Route::post('greylist/move', 'GreylistController@move');

    // Whitelist
    Route::get('whitelist/emails', 'WhitelistController@showEmails');
    Route::get('whitelist/domains', 'WhitelistController@showDomains');

    // OptOut
    Route::get('optout/emails', 'OptOutController@showEmails');
    Route::get('optout/domains', 'OptOutController@showDomains');

    // OptIn
    Route::get('optin/emails', 'OptInController@showEmails');
    Route::get('optin/domains', 'OptInController@showDomains');

    // Settings
    Route::get('settings', 'SettingController@index');
    Route::get('settings/password', 'SettingController@changePassword');
    Route::post('settings/password', 'SettingController@password');
    Route::get('settings/email', 'SettingController@changeEmail');
    Route::post('settings/email', 'SettingController@email');

    // About
    Route::get('about', 'AboutController@index');
});

// Login & Logout
Route::get('login', 'AuthController@showLogin');
Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout');
