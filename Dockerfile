FROM composer:2.0.9
WORKDIR /app
COPY . .
RUN composer install

FROM php:8.0.1-apache
COPY .docker/000-default.conf /etc/apache2/sites-available/
COPY .docker/start-apache /usr/local/bin
RUN a2enmod rewrite

COPY --from=0 /app /var/www/html
WORKDIR /var/www/html
RUN rm -rf .docker .do .git Dockerfile
RUN chown -R www-data:www-data /var/www

CMD ["start-apache"]

