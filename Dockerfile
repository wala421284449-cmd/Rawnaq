# استخدام صورة PHP رسمية مع Apache
FROM php:8.2-apache

# تثبيت الحزم والأدوات المطلوبة للنظام (بما فيها مكتبات PostgreSQL)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

# تنظيف الكاش لتصغير حجم الصورة
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# تمديد وتفعيل ملحقات PHP المطلوبة لـ Laravel (مع إضافة PostgreSQL)
RUN docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# تثبيت Composer (مدير حزم PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد مجلد العمل داخل الحاوية (Container)
WORKDIR /var/www/html

# نقل ملفات المشروع إلى الحاوية
COPY . /var/www/html

# إعطاء صلاحيات الكتابة لمجلدات التخزين والكاش في لارايفل
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# تغيير مسار الـ Document Root الخاص بـ Apache إلى مجلد public في لارايفل
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# تفعيل Module الـ Rewrite في أباتشي لتتوافق مسارات لارافيل
RUN a2enmod rewrite

# تعيين المنفذ الافتراضي الذي سيعمل عليه Render (Render يمرر PORT كمتغير بيئي)
EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# نسخ ملف السكريبت الخاص بالتشغيل إلى داخل الحاوية وإعطائه صلاحية التنفيذ
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# اعتماد ملف start.sh كأمر أساسي عند إقلاع الحاوية
CMD ["start.sh"]
