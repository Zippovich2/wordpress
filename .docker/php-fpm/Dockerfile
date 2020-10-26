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

# Composer Install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php -- --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Create php-user
RUN useradd -m php-user -G www-data

WORKDIR /var/www/app

USER php-user
