FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    ca-certificates \
    icu-dev \
    libzip-dev \
    zlib-dev \
    postgresql-dev \
    oniguruma-dev \
    openssl \
    $PHPIZE_DEPS

RUN docker-php-ext-configure intl \
 && docker-php-ext-install -j"$(nproc)" intl pdo_pgsql bcmath zip opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY .docker/php/conf/custom.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html
