FROM mariusbuescher/k8s-example-code AS build

FROM php:7.3-fpm-alpine3.10

RUN apk add postgresql postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY ./php.ini $PHP_INI_DIR/conf.d/local-conf.ini

COPY --from=build /opt/build /var/www/html

RUN bin/console cache:clear --env=prod \
    && chown www-data:www-data var -R
