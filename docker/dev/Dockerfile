FROM node:20.18.0 AS node

FROM phpswoole/swoole:php8.3-dev

WORKDIR /var/www/html

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN --mount=type=cache,target=/tmp/cache/apt \
    apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    libc-client-dev \
    libkrb5-dev \
    libonig-dev \
    libxml2-dev \
    libgmp-dev

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

RUN apt-get purge -y

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

COPY supervisord.conf /etc/supervisord.conf
COPY start.sh /var/www/start.sh
COPY php.ini /usr/local/etc/php/conf.d/99-custom.ini

RUN chmod +x /var/www/start.sh

CMD ["/bin/sh","/var/www/start.sh"]
