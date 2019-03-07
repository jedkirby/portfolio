FROM php:5.6-alpine

RUN apk update && apk add curl && \
  curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN apk update && apk add libmcrypt-dev

RUN docker-php-ext-install pcntl
RUN docker-php-ext-install mcrypt

CMD php
