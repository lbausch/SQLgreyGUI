SQLgreyGUI
==========

[![Build Status](https://travis-ci.org/lbausch/SQLgreyGUI.svg?branch=master)](https://travis-ci.org/lbausch/SQLgreyGUI)
[![CircleCI](https://circleci.com/gh/lbausch/SQLgreyGUI/tree/master.svg?style=shield&circle-token=a1aa5f540878177c22252802a2725e2ed93e6d43)](https://circleci.com/gh/lbausch/SQLgreyGUI/tree/master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/88a59ccb64a24a8480a13313cb37599a)](https://www.codacy.com/app/lbausch/SQLgreyGUI?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=lbausch/SQLgreyGUI&amp;utm_campaign=Badge_Grade)

Web interface for [SQLgrey](http://sqlgrey.sourceforge.net/) using the [Laravel 5](https://laravel.com/) Framework.

## Features
* Dashboard: quick overview of emails / domains in greylist, whitelist, opt-out and opt-in
* Greylist: delete entries or move them to the whitelist
* Whitelist: add sender emails or sender domains to prevent them from being greylisted and delivered directly
* Opt-out: define emails or domains you don't want greylisting to be enabled for
* Opt-in: define  emails or domains for which you want to enforce greylisting permanently
* Option of using seperate databases for SQLgrey and the application itself. This way you can maintain a user database in a single place and use it with all installations of SQLgreyGUI. In addition you don't need to alter the SQLgrey database at all.


## Requirements
* working SQLgrey setup
* Webserver (e.g. Apache) and Database (e.g. MySQL)
* PHP >= 5.5.9


## Installation in 7 simple steps
1. grab a copy of the code (download [master.zip](https://github.com/lbausch/SQLgreyGUI/archive/master.zip) or use `git clone https://github.com/lbausch/SQLgreyGUI.git`)
2. make your webserver use the `public` directory as document root
3. copy `.env.example` to `.env` and adjust it to your needs (`APP_URL`, `APP_TIMEZONE`, `APP_KEY` and database settings)
4. run `composer install --no-dev` to install all necessary dependencies
5. set a new application key with `php artisan key:generate`
6. run `php artisan migrate --seed --force` to create the database tables and an admin user
7. login with the username `admin` and the password `joh316` (you can change the password in "Settings")


## Screenshots
![Dasboard](/../screenshots/dashboard.png?raw=true "Dashboard")
![Auto-Whitelist](/../screenshots/auto-whitelist.png?raw=true "Auto-Whitelist")

Follow [@SQLgreyGUI](https://twitter.com/sqlgreygui) on Twitter
