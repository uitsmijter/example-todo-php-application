#!/usr/bin/env bash

set -e

cd "$(dirname "${BASH_SOURCE[0]}")"

[[ -a ".env" ]] || cp .env.dev .env
[[ -d "vendor" ]] ||
    docker run -t --rm \
        -v "${PWD}":/data -w /data \
        -u "$(id -u):$(id -g)" \
        -v /tmp:/cache -v /tmp:/logs \
        composer install

./vendor/bin/sail up -d
while ! ./vendor/bin/sail artisan migrate; do sleep 1; done&
./vendor/bin/sail up
