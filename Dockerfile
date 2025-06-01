FROM php:8.2-fpm

RUN apt-get update && apt-get install -y  libpq-dev && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www COPY . /var/www RUN composer install

Исправляем права доступа для storage и bootstrap/cache

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000 CMD ["php-fpm"]
