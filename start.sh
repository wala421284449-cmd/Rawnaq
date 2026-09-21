#!/usr/bin/env bash

composer install --no-dev --optimize-autoloader
npm install
npm run build

# مسح جميع أنواع الكاش القديمة من السيرفر
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# إعادة بناء الكاش الجديد
php artisan config:cache
php artisan route:cache
php artisan view:cache

# تشغيل التحديث والـ Seeders بدون مسح الجداول
php artisan migrate --force
php artisan db:seed --force

apache2-foreground
