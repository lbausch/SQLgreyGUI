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
Route::get('optout/emails', 'OptoutController@showEmails');
Route::get('optout/domains', 'OptoutController@showDomains');


// OptIn
Route::get('optin/emails', 'OptinController@showEmails');
Route::get('optin/domains', 'OptinController@showDomains');


// About
Route::get('about', 'AboutController@index');


// Login & Logout
Route::get('logout', 'AuthController@logout');
