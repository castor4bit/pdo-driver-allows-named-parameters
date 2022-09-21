FROM php:8.0-cli

WORKDIR /tmp
COPY php8.0-mysql8.0/composer.json .
COPY ./tests/*       ./tests/

RUN apt-get update \
    && apt-get install -y wget git unzip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install -j$(nproc) pdo_mysql

RUN wget https://getcomposer.org/download/latest-stable/composer.phar -O /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer install

CMD [ "vendor/bin/phpunit", "./tests" ]
