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
    Route::post('whitelist/emails/add', 'WhitelistController@addEmail');
    Route::post('whitelist/deleteEmails', 'WhitelistController@deleteEmails');
    Route::get('whitelist/domains', 'WhitelistController@showDomains');
    Route::post('whitelist/domains/add', 'WhitelistController@addDomain');
    Route::post('whitelist/deleteDomains', 'WhitelistController@deleteDomains');

    // OptOut
    Route::get('optout/emails', 'OptOutController@showEmails');
    Route::post('optout/emails/add', 'OptOutController@addEmail');
    Route::post('optout/emails/delete', 'OptOutController@deleteEmails');
    Route::get('optout/domains', 'OptOutController@showDomains');
    Route::post('optout/domains/add', 'OptOutController@addDomain');
    Route::post('optout/domains/delete', 'OptOutController@deleteDomains');

    // OptIn
    Route::get('optin/emails', 'OptInController@showEmails');
    Route::post('optin/emails/add', 'OptInController@addEmail');
    Route::post('optin/emails/delete', 'OptInController@deleteEmails');
    Route::get('optin/domains', 'OptInController@showDomains');
    Route::post('optin/domains/add', 'OptInController@addDomain');
    Route::post('optin/domains/delete', 'OptInController@deleteDomains');

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
