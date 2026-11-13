#!/bin/sh
set -e

# Pastikan file SQLite ada dan dapat ditulis
touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan migrasi dan seeder otomatis
php artisan migrate --force --seed || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
