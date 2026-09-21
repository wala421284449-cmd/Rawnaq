#!/usr/bin/env bash

# تثبيت حزم PHP وتجميع الواجهة
composer install --no-dev --optimize-autoloader
npm install
npm run build

# كاش وراوت لارافيل
php artisan config:cache
php artisan route:cache
php artisan view:cache

# تشغيل الـ Migrations والـ Seeders بأمان بدون حذف البيانات الحالية
php artisan migrate --force
php artisan db:seed --force

# تشغيل سيرفر أباتشي
apache2-foreground
