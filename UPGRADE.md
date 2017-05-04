# Upgrading

## Upgrading from v2.x to v3.x
+ Backup everything
+ Get the latest code from GitHub (`git fetch` and `git checkout master`)
+ Update your `.env` file based on `.env.example`
+ Install PHP packages: `composer install --no-dev`
+ Install npm packages: `yarn install` (if you don't use yarn `npm install` should work as well)
+ Generate frontend assets: `yarn run prod` (or `npm run prod`)
+ Upgrade database: `php artisan migrate`
+ Install Laravel Passport: `php artisan passport:install`
+ Add cron entry as mentioned in installation instructions (`README.md`)
