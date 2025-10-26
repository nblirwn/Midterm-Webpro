#!/usr/bin/env bash
set -e

cd /var/www/html

if [ ! -f .env ]; then
  cp .env.example .env
fi

if ! grep -q "APP_KEY=base64" .env; then
  php artisan key:generate --force || true
fi

mkdir -p storage/database
if [ ! -f storage/database/database.sqlite ]; then
  touch storage/database/database.sqlite
fi

chown -R www-data:www-data storage bootstrap/cache || true
chmod -R ug+rw storage bootstrap/cache || true

php artisan migrate --force || true

apache2-foreground
