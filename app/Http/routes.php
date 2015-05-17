<?php

Route::group(['middleware' => 'auth'], function() {
    // Dashboard
    get('/', 'DashboardController@index');
    get('dashboard', 'DashboardController@index');

    // Greylist
    get('greylist', 'GreylistController@index');
    post('greylist/live', 'GreylistController@live');
    post('greylist/delete', 'GreylistController@delete');
    post('greylist/move', 'GreylistController@move');
    post('greylist/deletebydate', 'GreylistController@deleteByDate');

    // Whitelist
    get('whitelist/emails', 'WhitelistController@showEmails');
    post('whitelist/emails/add', 'WhitelistController@addEmail');
    post('whitelist/deleteEmails', 'WhitelistController@deleteEmails');
    get('whitelist/domains', 'WhitelistController@showDomains');
    post('whitelist/domains/add', 'WhitelistController@addDomain');
    post('whitelist/deleteDomains', 'WhitelistController@deleteDomains');

    // OptOut
    get('optout/emails', 'OptOutController@showEmails');
    post('optout/emails/add', 'OptOutController@addEmail');
    post('optout/emails/delete', 'OptOutController@deleteEmails');
    get('optout/domains', 'OptOutController@showDomains');
    post('optout/domains/add', 'OptOutController@addDomain');
    post('optout/domains/delete', 'OptOutController@deleteDomains');

    // OptIn
    get('optin/emails', 'OptInController@showEmails');
    post('optin/emails/add', 'OptInController@addEmail');
    post('optin/emails/delete', 'OptInController@deleteEmails');
    get('optin/domains', 'OptInController@showDomains');
    post('optin/domains/add', 'OptInController@addDomain');
    post('optin/domains/delete', 'OptInController@deleteDomains');

    // Settings
    get('settings', 'SettingController@index');
    get('settings/password', 'SettingController@changePassword');
    post('settings/password', 'SettingController@password');
    get('settings/email', 'SettingController@changeEmail');
    post('settings/email', 'SettingController@email');

    // Users
    Route::resource('admin/users', 'UserController');
    post('admin/users/delete', 'UserController@deleteUsers');
    get('admin/usertable', 'UserController@getTable');

    // About
    get('about', 'AboutController@index');
});

// Login & Logout
get('login', 'AuthController@showLogin');
post('login', 'AuthController@login');
get('logout', 'AuthController@logout');
