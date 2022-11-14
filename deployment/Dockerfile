ARG BASEIMAGE=php:8.2-apache

FROM composer:latest as build
WORKDIR /app
COPY . .
RUN composer install --no-interaction --no-dev --optimize-autoloader

FROM node AS assets
WORKDIR /app
COPY package.json package-lock.json postcss.config.js tailwind.config.js vite.config.js /app/
COPY resources/ /app/resources/
RUN npm install
RUN npm run build

FROM ${BASEIMAGE}
MAINTAINER aus der Technik
WORKDIR /app
ENV APP_ENV production

RUN find /etc/apache2/ -type f -name '*.conf' -exec sed -i -e 's~/var/www/html~/app/public~' -e 's~/var/www~/app~' {} \; && a2enmod rewrite
RUN apt update && apt -y install libicu-dev && docker-php-ext-install intl pdo_mysql

COPY . .
COPY --from=build /app/vendor/ vendor/
COPY --from=assets /app/public/build/ public/build/

RUN find /app/storage/ -type d -exec chmod 777 {} \;; find /app/storage/ -type f -exec chmod 666 {} \;; find bootstrap/cache -type f -name '*.php' -exec rm {} \;
