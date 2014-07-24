SQLgreyGUI
==========

Web interface for [SQLgrey](http://sqlgrey.sourceforge.net/) using the [Laravel](http://laravel.com/) Framework.


## Features
* Dashboard: quick overview of eMails / domains in greylist, whitelist, opt-out and opt-in
* Greylist: delete entries or move them to the whitelist
* Whitelist: add sender eMails or sender domains to prevent them from being greylisted and delivered directly
* Opt-out: define eMails or Domains you don't want greylisting to be enabled for
* Opt-in: define  eMails or Domains for which you want to enforce greylisting permanently
* Option of using seperate databases for SQLgrey and the application itself. This way you can maintain a user database in a single place and use it with all installations of SQLgreyGUI. In addition you don't need to alter the SQLgrey database at all.


## Requirements
* working SQLgrey setup
* Webserver (e.g. Apache) and Database (e.g. MySQL)
* PHP >= 5.4.0


## Installation in 7 steps
1. grab a copy of the code (download [master.zip](https://github.com/lbausch/SQLgreyGUI/archive/master.zip) or use `git clone https://github.com/lbausch/SQLgreyGUI.git`)
2. make your webserver use the `public` directory as document root
3. rename `config-dist.php` to `config.php`, `app/config/app-dist.php` to `app/config/app.php` and `app/config/mail-dist.php` to `app/config/mail.php`. Adjust the settings to your needs.
4. run `composer update` to install all necessary dependencies
5. run `php artisan migrate --force` to create the database tables
6. run `php artisan db:seed --force` to create an admin user
7. login with the username `admin` and the password `joh316`


## Screenshots
![Dasboard](/../screenshots/dashboard.png?raw=true "Dashboard")
![Auto-Whitelist](/../screenshots/auto-whitelist.png?raw=true "Auto-Whitelist")