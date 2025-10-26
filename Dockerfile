FROM composer:2 AS builder
WORKDIR /app
RUN composer create-project laravel/laravel:^11.0 /app

FROM php:8.2-apache

RUN apt-get update && apt-get install -y libzip-dev unzip git sqlite3 libsqlite3-dev pkg-config && docker-php-ext-configure pdo_sqlite --with-pdo-sqlite=/usr && docker-php-ext-install pdo_sqlite && a2enmod rewrite && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf && sed -ri -e 's!Directory /var/www/!Directory ${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

COPY --from=builder /app /var/www/html

COPY overlay/ /var/www/html/

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh && chown -R www-data:www-data /var/www/html
WORKDIR /var/www/html
EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]

RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
