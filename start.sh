#!/usr/bin/env bash

# تثبيت حزم PHP وتجميع الواجهة
composer install --no-dev --optimize-autoloader
npm install
npm run build

# كاش وراوت لارافيل
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache

# تشغيل المايجريشن والسييدز لإدخال بيانات الدخول وقاعدة البيانات
php artisan migrate:fresh --force --seed

# تشغيل سيرفر أباتشي
apache2-foreground
