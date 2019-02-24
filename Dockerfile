FROM composer AS build

WORKDIR /build

ADD . .
RUN composer install

FROM webdevops/php-nginx:alpine-php7

WORKDIR /app

COPY --from=build /build .

ENV WEB_DOCUMENT_ROOT /app/public
