SQLgreyGUI
==========

GUI for [SQLgrey](http://sqlgrey.sourceforge.net/) using the [Laravel](http://laravel.com/) Framework.


## Features

* quick overview of greylisted hosts and domains
* show auto-whitelisted senders and domains
* exclude recipients and domains from greylisting (Opt-Out)
* enforce greylisting for recipients and domains (Opt-In)
* option of using seperate databases for SQLgrey and application


## Requirements

* working SQLgrey setup
* Webserver (Apache)
* PHP >= 5.4.0


## Installation in 7 steps

1. grab a copy of the code (download [master.zip](https://github.com/lbausch/SQLgreyGUI/archive/master.zip) or use `git clone https://github.com/lbausch/SQLgreyGUI.git`)
2. make your webserver use the `/code/public/` directory as document root
3. rename `config-dist.php` to `config.php` and adjust the settings
4. run `composer update` to install all necessary dependencies
5. run `php artisan migrate --force` to create the database tables
6. run `php artisan db:seed` to create an admin user
7. login with the username `admin` and the password `joh316`