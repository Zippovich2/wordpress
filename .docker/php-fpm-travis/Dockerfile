FROM php:7.4-fpm

RUN docker-php-ext-install mysqli

# Create php-user
RUN useradd -m php-user -G www-data

WORKDIR /var/www/app

USER php-user