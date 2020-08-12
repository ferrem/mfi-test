FROM php:7-fpm-alpine
RUN apk update && apk add --no-cache \
        postgresql-dev composer \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql

ENTRYPOINT cd /app && composer install; php bin/console doctrine:migrations:migrate && php-fpm