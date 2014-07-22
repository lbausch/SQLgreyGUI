<?php

// Dashboard
Route::get('/', 'DashboardController@index');
Route::get('dashboard', 'DashboardController@index');


// Greylisted
Route::get('greylisted', 'GreylistedController@index');


// Whitelisted
Route::get('whitelisted/emails', 'WhitelistedController@showEmails');
Route::get('whitelisted/domains', 'WhitelistedController@showDomains');


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
