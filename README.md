# PHP Demo ToDo app

This app demonstrates a simple ToDo page before and after migrating authentifiction to Uitsmijter.

Before the Uitsmijter integration, users can register and the authentication is done by
reading and comparing entries from the database `users` table.
This can be tested using the state from the `db-backend` branch.

After integrating Uitsmijter it handles the users (identified by their email address).
When a user is not present in the ToDo app it will be added to the `users` table.
This can be tested using the state from the `uitsmijter-backend` branch.

## Installation
For JWT auth to work, [`php-open-source-saver/jwt-auth`](https://github.com/PHP-Open-Source-Saver/jwt-auth) is used.
The Uitsmijter Traefik middleware parses and validates the `uitsmijter-sso` cookie and sets an `authorization: Bearer [token]` header
which is used to authenticate the user.
For the exact setup steps see the [Uitsmijter](https://docs.uitsmijter.io/interceptor/interceptor/) docs,
[jwt-auth](https://laravel-jwt-auth.readthedocs.io/en/latest/) documentation and the commits in this repository for the implementation.

The user creation is done by the [`JWTAuthProvider.php`](app/Http/Helpers/JWTAuthProvider.php).
Some debug information can be viewed by visiting `/debug` on the page.

For local testing, a valid JWT must be send as an `Authorization: Bearer [token]` header for every request.

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
