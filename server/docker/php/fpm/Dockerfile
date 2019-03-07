FROM php:5.6-fpm-alpine

RUN apk update && apk add libmcrypt-dev

RUN docker-php-ext-install pcntl
RUN docker-php-ext-install mcrypt
