FROM php:8.2-apache

# تثبيت حزم النظام و Node.js لتجميع التصميم عبر Vite و Tailwind
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd mbstring exif pcntl bcmath opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

# تثبيت حزم لارافيل وتجميع الواجهة والتصميم تلقائياً
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -s 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -s 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# أوامر التشغيل: تشغيل الـ Migrations، ربط التخزين، بناء الكاش، ثم تشغيل السيرفر
CMD php artisan migrate --force --seed && php artisan storage:link --force && php artisan config:cache && php artisan route:cache && apache2-foreground
