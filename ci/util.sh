#!/usr/bin/env bash

create_database() {
    mysql -uroot -e "DROP DATABASE IF EXISTS testing"
    mysql -uroot -e "CREATE DATABASE testing"
    mysql -uroot -e "GRANT ALL ON testing.* to 'homestead'@'%';"
    mysql -uroot --database testing < sqlgrey.sql
}

copy_configuration() {
    cp -n .env .env.bak
    cp -v ci/.env.testing .env
}

configure_application() {
    php artisan key:generate
    php artisan migrate
    php artisan passport:install
}

restore_configuration() {
    mv .env.bak .env
}
