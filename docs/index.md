## Features
* Dashboard: Quick overview of emails / domains in greylist, whitelist, opt-out and opt-in
* Greylist: Delete entries or move them to the whitelist
* Whitelist: Add sender emails or sender domains to prevent them from being greylisted and delivered directly
* Opt-Out: Define emails or domains you don't want greylisting to be enabled for
* Opt-In: Define  emails or domains for which you want to enforce greylisting permanently
* Option of using separate databases for SQLgrey and the application itself. This way you can maintain a user database in a single place and use it with all installations of SQLgreyGUI. In addition you don't need to alter the SQLgrey database at all.


## Requirements
* Working SQLgrey setup
* Webserver (e.g. Apache) and Database (e.g. MySQL)
* PHP >= 5.6.4


## Installation
* Download and extract [master.zip](https://github.com/lbausch/SQLgreyGUI/archive/master.zip) or clone the repository (`git clone https://github.com/lbausch/SQLgreyGUI.git`)
* Make your webserver use the `public` directory as document root
* Copy `.env.example` to `.env` and adjust it to your needs (`APP_URL`, `APP_TIMEZONE`, `APP_KEY` and database settings)
* Run `composer install --no-dev` to install all necessary PHP dependencies
* Set application key with `php artisan key:generate`
* Run `php artisan migrate --force` to create the database tables
* Install Laravel Passport: `php artisan passport:install`
* Install and generate frontend assets: `yarn install && yarn run prod` (or `npm install && npm run prod`)
* Create user: `php artisan sqlgreygui:user`
* Add cron entry `* * * * * php /path/to/sqlgreygui/artisan schedule:run >> /dev/null 2>&1` which will delete _undef_ records from the database


## Using separate databases for SQLgrey and SQLgreyGUI
Adjust the values starting with `SQLGREY_DB_` in the `.env` file.
Refer to the `.env.example` file for possible entries.
The default configuration in `config/database.php` is designed to work with MySQL out of the box.
If you need different settings, e.g. for PostgreSQL, take a look at the existing config blocks in `config/database.php`.
Additional documentation for available configuration possibilities may be found in the [Laravel documentation](https://laravel.com/docs/5.4/database#configuration).

Follow [@SQLgreyGUI](https://twitter.com/sqlgreygui) on Twitter
