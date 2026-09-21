#!/usr/bin/env bash

# تشغيل الكاش لتسريع الأداء
php artisan config:cache
php artisan route:cache
php artisan view:cache

# تطبيق جداول قاعدة البيانات وسحب التحديثات
php artisan migrate --force

# تشغيل الـ Seeders لإدخال البيانات الأولية
php artisan db:seed --force

# تشغيل سيرفر أباتشي ليبقي الموقع شغالاً
apache2-foreground
