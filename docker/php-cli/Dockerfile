FROM php:8.1-cli-alpine
ENV XDEBUG_VERSION 3.1.2

RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash
RUN apk add --update linux-headers

RUN pecl install xdebug && docker-php-ext-enable xdebug;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /app
