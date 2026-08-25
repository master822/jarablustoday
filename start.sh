#!/usr/bin/env bash

echo "Configuring Apache for Laravel and Symlinks..."
APACHE_CONF="/etc/apache2/apache2.conf"

if ! grep -q "FollowSymLinks" "$APACHE_CONF"; then
    echo "" >> "$APACHE_CONF"
    echo "<Directory /var/www/html>" >> "$APACHE_CONF"
    echo "    Options Indexes FollowSymLinks" >> "$APACHE_CONF"
    echo "    AllowOverride All" >> "$APACHE_CONF"
    echo "    Require all granted" >> "$APACHE_CONF"
    echo "</Directory>" >> "$APACHE_CONF"
fi

echo "Clearing and caching configurations..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache

echo "Recreating storage link..."
rm -rf public/storage
php artisan storage:link

echo "Running automated database migrations..."
php artisan migrate --force

echo "Configuring master admin account..."
php artisan db:seed --class=AdminSeeder --force

echo "Starting Apache..."
exec apache2-foreground
