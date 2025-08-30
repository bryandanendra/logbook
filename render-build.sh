#!/usr/bin/env bash
# exit on error
set -o errexit

composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
