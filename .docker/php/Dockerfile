FROM composer:2.9 AS composer_install_stage

WORKDIR /app

COPY composer.json ./

RUN composer install --no-dev --no-interaction --optimize-autoloader --prefer-dist

# Multi stage build
FROM php:8.2-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

COPY --from=composer_install_stage /app/vendor ./vendor

#   Where nginx connects to
EXPOSE 9000 

CMD ["php-fpm"]