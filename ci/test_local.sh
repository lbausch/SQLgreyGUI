#!/usr/bin/env bash

cd $(cd -P -- "$(dirname -- "$0")" && pwd -P)

mysql -uroot -e "DROP DATABASE IF EXISTS testing"
mysql -uroot -e "CREATE DATABASE testing"
mysql -uroot -e "GRANT ALL ON testing.* to 'homestead'@'%';"
mysql -uroot --database testing < sqlgrey.sql

cd ..

cp -n .env .env.bak
cp -v ci/.env.testing .env

php artisan key:generate
php artisan migrate
php artisan passport:install

pids=$(pidof /usr/bin/Xvfb)

if [ ! -n "$pids" ]; then
    Xvfb :0 -screen 0 1366x768x24 &
fi

php artisan dusk

mv .env.bak .env
