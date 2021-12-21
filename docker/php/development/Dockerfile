FROM composer:latest AS composer
FROM php:8.0.2-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils \
    nano \
    bash \
    libcurl4-gnutls-dev \
    debconf \
    git \
    apt-transport-https \
    build-essential \
    locales \
    libxml2-dev \
    acl \
    mailutils \
    wget \
    zip \
    unzip \
    gnupg \
    gnupg1 \
    gnupg2 \
    zlib1g-dev \
    libpng-dev \
    libonig-dev \
    librabbitmq-dev

RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev libzip-dev

RUN docker-php-ext-install xml \
    ctype \
    tokenizer \
    mbstring \
    curl \
    gd \
    pdo \
    pdo_mysql \
    zip

RUN pecl install xdebug \
    mongo \
    mongodb \
    && docker-php-ext-enable xdebug

RUN docker-php-source delete \
    && apt-get remove -y g++ wget \
    && apt-get autoremove --purge -y \
    && apt-get autoclean -y \
    && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/* /var/tmp/*

COPY php.ini /usr/local/etc/php/php.ini
COPY php-fpm-pool.conf 	/usr/local/etc/php/pool.d/www.conf

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m
RUN passwd -d dev

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen

RUN echo "dev ALL=(ALL) ALL" > /etc/sudoers
