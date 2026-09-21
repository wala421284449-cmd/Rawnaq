#!/usr/bin/env bash

# تثبيت حزم المشروع وتوليد مجلد vendor وملفات الـ autoload
composer install --no-dev --optimize-autoloader

# تشغيل الكاش والترحيل وقواعد البيانات
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan db:seed --force

# تشغيل سيرفر أباتشي ليبقي الموقع شغالاً
apache2-foreground
