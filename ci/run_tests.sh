#!/usr/bin/env sh

if [ ! "$CI" = true ]; then
    ./ci/setup_environment.sh
fi

./vendor/bin/phpunit
