#!/usr/bin/env bash

cd $(cd -P -- "$(dirname -- "$0")" && pwd -P)

. util.sh

create_database

cd ..

copy_configuration

configure_application

pids=$(pidof /usr/bin/Xvfb)

if [ ! -n "$pids" ]; then
    Xvfb :0 -screen 0 1366x768x24 &
fi

php artisan dusk

restore_configuration
