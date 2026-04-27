FROM php:8.3-fpm

# Match host uid/gid so files created in the container are owned by your user (bind mount).
# Override via: docker compose build --build-arg PUID=$(id -u) --build-arg PGID=$(id -g)
ARG PUID=1000
ARG PGID=1000
RUN usermod -o -u ${PUID} www-data \
  && groupmod -o -g ${PGID} www-data

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www