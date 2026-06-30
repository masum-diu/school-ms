#!/bin/sh
set -e

cd /var/www/html

if [ -z "$APP_KEY" ]; then
    export APP_KEY=$(php artisan key:generate --show)
fi

if [ "$DB_CONNECTION" = "sqlite" ]; then
    touch database/database.sqlite
fi

php artisan migrate --force --no-interaction
php artisan db:seed --force --no-interaction
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

PORT=${PORT:-8080}
exec php artisan serve --host=0.0.0.0 --port="$PORT"
