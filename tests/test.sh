#!/usr/bin/env bash

cd $(cd -P -- "$(dirname -- "$0")" && pwd -P)

. util.sh

cd ..

create_database

copy_configuration

configure_application

./vendor/bin/phpunit

restore_configuration
