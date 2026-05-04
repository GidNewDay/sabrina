FROM php:8.3-fpm

ARG PUID=1000
ARG PGID=1000

# Объединяем команды, чтобы не плодить слои
RUN usermod -o -u ${PUID} www-data && groupmod -o -g ${PGID} www-data

# Установка системных зависимостей с очисткой кэша apt
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
