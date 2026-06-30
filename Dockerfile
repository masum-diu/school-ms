FROM php:8.3-cli-bookworm

RUN apt-get update && apt-get install -y \
    git unzip libsqlite3-dev libpq-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

COPY package.json package-lock.json* ./
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm ci --ignore-scripts 2>/dev/null || npm install --ignore-scripts \
    && rm -rf /var/lib/apt/lists/*

COPY . .

RUN composer dump-autoload --optimize \
    && npm run build \
    && php artisan config:clear \
    && chown -R www-data:www-data storage bootstrap/cache database

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
