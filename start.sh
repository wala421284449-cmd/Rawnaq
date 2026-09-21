#!/usr/bin/env bash

# تثبيت حزم PHP وتوليد الـ autoload
composer install --no-dev --optimize-autoloader

# تثبيت حزم الـ Node.js وتجميع ملفات الواجهة (Vite / Tailwind)
npm install
npm run build

# تشغيل الكاش والترحيل وقواعد البيانات
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan db:seed --force

# تشغيل سيرفر أباتشي
apache2-foreground
