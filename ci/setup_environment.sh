#!/usr/bin/env sh

if [ "$CI" = true ]; then
    cd $TRAVIS_BUILD_DIR
fi

if [ "$CI" = true ]; then
    composer install --no-ansi --no-interaction --no-progress
fi

cp -nv .env.example .env

if [ "$CI" = true ]; then
    php artisan key:generate
fi

cp -v tests/sqlgrey.sqlite database/database_sqlgrey.sqlite

echo > database/database.sqlite

php artisan migrate --database=sqlite --seed --force
