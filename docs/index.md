## Features
* Dashboard: Quick overview of emails / domains in greylist, whitelist, opt-out and opt-in
* Greylist: Delete entries or move them to the whitelist
* Whitelist: Add sender emails or sender domains to prevent them from being greylisted and delivered directly
* Opt-Out: Define emails or domains you don't want greylisting to be enabled for
* Opt-In: Define  emails or domains for which you want to enforce greylisting permanently
* Option of using seperate databases for SQLgrey and the application itself. This way you can maintain a user database in a single place and use it with all installations of SQLgreyGUI. In addition you don't need to alter the SQLgrey database at all.


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


Follow [@SQLgreyGUI](https://twitter.com/sqlgreygui) on Twitter
