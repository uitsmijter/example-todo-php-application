# PHP Demo ToDo app

This app demonstrates a simple ToDo page.

## Setup

```shell
docker run --rm -v "$PWD":/app -u $(id -u):$(id -g) composer install --ignore-platform-reqs
cp .env.dev .env
vendor/bin/sail build
```

## Run the application

```shell
vendor/bin/sail up
```

and in another terminal to set up the env:
```shell
vendor/bin/sail npm install
vendor/bin/sail npm run build
vendor/bin/sail artisan migrate
```

The application is available at [localhost](http://localhost).

## Stop the application

```shell
vendor/bin/sail stop
```

or press `Ctrl`+`C`
