#!/usr/bin/env bash

composer install --no-dev --optimize-autoloader
npm install
npm run build

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# تحديث الجداول فقط بدون إعادة تنفيذ الـ Seeder الإجباري الذي يخرب بيانات الدخول
php artisan migrate --force

apache2-foreground
