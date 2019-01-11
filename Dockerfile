FROM composer AS build

WORKDIR /build

COPY ./composer.json ./composer.json
COPY ./composer.lock ./composer.lock
COPY ./tests ./tests
COPY ./database ./database

RUN composer install
RUN composer dump-autoload

FROM dewadg/lumen:latest

ADD . /var/www/lumen
COPY --from=build /build/vendor /var/www/lumen/vendor
