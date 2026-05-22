FROM php:7.4-apache

RUN a2enmod rewrite

RUN docker-php-ext-install mysqli

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chmod -R 777 application/cache application/logs

RUN if [ -f "composer.json" ]; then composer install --no-dev --no-interaction; fi

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" || true
