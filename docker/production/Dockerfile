FROM composer:lts AS composer

LABEL maintainer="Paxton Li"

WORKDIR /var/www/html

COPY ../composer.json composer.json
COPY ../composer.lock composer.lock

RUN --mount=type=cache,target=/tmp/cache/composer \
    composer i \
    --ignore-platform-reqs \
    --no-scripts \
    --no-interaction \
    --no-plugins \
    --prefer-dist

FROM node:lts-alpine3.19 AS node

WORKDIR /var/www/html

COPY ../package.json package.json
COPY ../package-lock.json package-lock.json

RUN --mount=type=cache,target=/tmp/cache/npm \
    npm ci

COPY ../resources resources
COPY ../vite.config.js vite.config.js
COPY ../postcss.config.js postcss.config.js
COPY ../tailwind.config.js tailwind.config.js
COPY ../tsconfig.json tsconfig.json
COPY ../eslint.config.js eslint.config.js
COPY ../.prettierrc .prettierrc
COPY ../.prettierignore .prettierignore

COPY --from=composer /var/www/html/vendor vendor

RUN --mount=type=cache,target=/tmp/cache/ssr \
    npm run build

FROM alpine:latest AS wait-for

WORKDIR /data/wait-for

RUN --mount=type=cache,target=/tmp/cache/wait-for \
    wget -qO- https://raw.githubusercontent.com/eficode/wait-for/v2.2.3/wait-for > wait-for.sh


FROM phpswoole/swoole:php8.3-alpine AS php

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

WORKDIR /var/www/html

RUN --mount=type=cache,target=/tmp/cache/apk \
    apk update \
    && apk add --no-cache \
    supervisor \
    autoconf \
    build-base \
    libuv libuv-dev \
    libevent \
    libevent-dev \
    openssl \
    openssl-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    icu-dev \
    imap-dev \
    krb5-dev \
    oniguruma-dev \
    libxml2-dev \
    gmp-dev

RUN --mount=type=cache,target=/tmp/cache/php-ext \
    docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl \
    && docker-php-ext-install gd && docker-php-ext-enable gd \
    && docker-php-ext-install zip && docker-php-ext-enable zip \
    && docker-php-ext-install mysqli && docker-php-ext-enable mysqli \
    && docker-php-ext-install bcmath && docker-php-ext-enable bcmath \
    && docker-php-ext-install intl && docker-php-ext-enable intl \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl && docker-php-ext-install imap && docker-php-ext-enable imap \
    && docker-php-ext-install soap && docker-php-ext-enable soap \
    && docker-php-ext-install gmp && docker-php-ext-enable gmp \
    && install-php-extensions zlib ldap

COPY .. .
COPY --from=composer /var/www/html/vendor vendor
COPY --from=node /var/www/html/public public
COPY --from=node /var/www/html/bootstrap/ssr bootstrap/ssr
COPY --from=wait-for /data/wait-for/wait-for.sh ./wait-for.sh
COPY ./docker/production/supervisord.conf /etc/supervisord.conf
COPY ./docker/production/start.sh ./start.sh

RUN chmod +x start.sh \
    && chmod +x wait-for.sh \
    && chown -R www-data:www-data vendor storage bootstrap

CMD ["/bin/sh","./start.sh"]
