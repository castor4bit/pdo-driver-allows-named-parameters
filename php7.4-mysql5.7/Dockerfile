FROM php:7.4-cli

WORKDIR /tmp
COPY php7.4-mysql5.7/composer.json .
COPY ./tests/*       ./tests/

RUN apt-get update \
    && apt-get install -y wget git unzip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install -j$(nproc) pdo_mysql

RUN wget https://getcomposer.org/download/latest-stable/composer.phar -O /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer install

CMD [ "vendor/bin/phpunit", "./tests" ]
