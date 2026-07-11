FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
