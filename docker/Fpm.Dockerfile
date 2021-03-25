FROM php:7.4-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql \
&& apt-get install zip unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/diplom
CMD ["php-fpm"]