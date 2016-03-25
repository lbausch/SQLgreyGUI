#!/usr/bin/env sh

cd $TRAVIS_BUILD_DIR

composer install --no-interaction

cp -nv .env.example .env

php artisan key:generate

cp -nv tests/sqlgrey.sqlite database/database_sqlgrey.sqlite

echo > database/database.sqlite

php artisan migrate --database=sqlite --seed --force
