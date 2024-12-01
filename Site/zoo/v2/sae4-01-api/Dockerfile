# Environment variable
ARG PHP_VERSION=8.1
ARG NGINX_VERSION=1.18.0


# Dev phase of the ZooTechPark App API
FROM php:${PHP_VERSION}-fpm-alpine AS zootechpark_php
RUN apk add --no-cache \
        acl \
        fcgi \
        file \
        gettext \
    ;
ARG APCU_VERSION=5.1.21
RUN set -eux; \
  apk add --no-cache --virtual .build-deps \
      $PHPIZE_DEPS \
      icu-dev \
      libzip-dev \
  ; \
  \
  docker-php-ext-configure zip; \
  docker-php-ext-install -j$(nproc) \
      intl \
      pdo_mysql \
      zip \
  ; \
  pecl install \
      apcu-${APCU_VERSION} \
  ; \
  pecl clear-cache; \
  docker-php-ext-enable \
      apcu \
      opcache \
  ; \
  \
  runDeps="$( \
      scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
          | tr ',' '\n' \
          | sort -u \
          | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
  )"; \
  apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
  \
  apk del .build-deps
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"
RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY docker/php/conf.d/config.ini $PHP_INI_DIR/conf.d/config.ini
ENV COMPOSER_ALLOW_SUPERUSER=TRUE
RUN set -eux; \
composer global config --no-plugins allow-plugins.symfony/flex true; \
composer global require "symfony/flex" --prefer-dist --no-progress --classmap-authoritative; \
composer clear-cache
WORKDIR /srv/contacts
COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod a+x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]


# Dev phase of the ZooTechPark App Proxy
FROM nginx:${NGINX_VERSION}-alpine AS zootechpark_nginx
COPY docker/nginx/conf.d /etc/nginx/conf.d
WORKDIR /srv/contacts/public


# Production phase of the ZooTechPark App API
FROM zootechpark_php as zootechpark_php_prod
ENV APP_ENV=prod
COPY composer.json ./composer.json
COPY composer.lock ./composer.lock
COPY symfony.lock ./symfony.lock
RUN set -eux; \
    composer install --prefer-dist --no-dev --no-scripts --no-progress; \
    composer clear-cache
COPY .env .
RUN composer dump-env prod
COPY bin ./bin
COPY config ./config
COPY migrations ./migrations
COPY public ./public
COPY src ./src
COPY templates ./templates
RUN find config migrations public src templates -type d -exec chmod a+rx {} \;
RUN find config migrations public src templates -type f -exec chmod a+r {} \;
RUN set -eux; \
mkdir -p var/cache var/log; \
composer dump-autoload --classmap-authoritative --no-dev; \
composer run-script --no-dev post-install-cmd; \
chmod +x bin/console; sync


# Production phase of the ZooTechPark App Proxy
FROM zootechpark_nginx as zootechpark_nginx_prod
COPY  --from=zootechpark_php_prod /srv/contacts /srv/contacts