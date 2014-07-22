<?php

// Dashboard
Route::get('/', 'DashboardController@index');
Route::get('dashboard', 'DashboardController@index');


// Greylisted
Route::get('greylist', 'GreylistController@index');


// Whitelisted
Route::get('whitelist/emails', 'WhitelistController@showEmails');
Route::get('whitelist/domains', 'WhitelistController@showDomains');


// OptOut
Route::get('optout/emails', 'OptOutController@showEmails');
Route::get('optout/domains', 'OptOutController@showDomains');


// OptIn
Route::get('optin/emails', 'OptInController@showEmails');
Route::get('optin/domains', 'OptInController@showDomains');


// About
Route::get('about', 'AboutController@index');


// Login & Logout
Route::get('logout', 'AuthController@logout');
