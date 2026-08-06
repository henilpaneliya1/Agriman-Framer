FROM php:8.2-apache

# GD (with FreeType for the libchart TTF charts) and mysqli
RUN apt-get update && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd mysqli \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ["Source Code/", "/var/www/html/"]

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
