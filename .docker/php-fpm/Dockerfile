FROM php:7.4-fpm

# Install required packages
RUN apt-get update && apt-get install -y \
    zip unzip curl libmagickwand-dev libzip-dev exiftool \
    --no-install-recommends

# Install mysqli
RUN docker-php-ext-install mysqli

# Install imagick
RUN pecl install imagick && \
    docker-php-ext-enable imagick

# Install xdebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

# Install other modules
RUN pecl install exif zip && \
    docker-php-ext-install exif && \
    docker-php-ext-enable zip exif

COPY ./xdebug.ini $PHP_INI_DIR/conf.d/
COPY ./php.ini $PHP_INI_DIR/conf.d/