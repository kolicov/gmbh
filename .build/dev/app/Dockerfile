FROM php:7.4.25-apache-buster
MAINTAINER pk

RUN apt-get update \
   && apt-get install -y libzip-dev \
   && apt-get install -y git

RUN pecl channel-update pecl.php.net \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/app
