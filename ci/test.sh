#!/usr/bin/env bash

cd $(cd -P -- "$(dirname -- "$0")" && pwd -P)

. util.sh

create_database

cd ..

copy_configuration

configure_application

./vendor/bin/phpunit

restore_configuration
