FROM php:7.2-fpm-alpine

RUN docker-php-ext-install mbstring tokenizer mysqli pdo_mysql
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

ADD . /var/www/lumen
RUN chown -R www-data:www-data /var/www

WORKDIR /var/www/lumen

RUN composer install