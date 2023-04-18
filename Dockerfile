FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git zip libonig-dev libpq-dev libicu-dev libzip-dev libxml2-dev \
    && docker-php-ext-install -j$(nproc) bcmath dom intl iconv mbstring pdo_pgsql zip xml

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash

RUN apt-get update && apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD /docker/php.ini /usr/local/etc/php/conf.d/40-custom.ini

COPY app/. /var/www

WORKDIR /var/www

RUN composer install
RUN npm install
RUN npm run dev


COPY entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]