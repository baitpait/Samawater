#!/bin/bash

cd /home/sarfesak/public_html/eliyaa

# 1. التحقق من المستخدم الحالي والمجموعة
echo "=== التحقق من الأذونات الحالية ==="
ls -la storage/framework/views | head -5

# 2. حذف جميع الملفات المؤقتة في views
echo "=== حذف الملفات المؤقتة ==="
rm -rf storage/framework/views/*

# 3. التأكد من وجود المجلد
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/logs

# 4. إصلاح الأذونات بشكل كامل
echo "=== إصلاح الأذونات ==="
chmod -R 775 storage/framework/views
chown -R www-data:www-data storage/framework/views

chmod -R 775 storage/framework/cache
chown -R www-data:www-data storage/framework/cache

chmod -R 775 storage/framework/sessions
chown -R www-data:www-data storage/framework/sessions

chmod -R 775 storage/framework
chown -R www-data:www-data storage/framework

chmod -R 775 storage/logs
chown -R www-data:www-data storage/logs

chmod -R 775 storage
chown -R www-data:www-data storage

# 5. التحقق من الأذونات بعد الإصلاح
echo "=== التحقق من الأذونات بعد الإصلاح ==="
ls -la storage/framework/views

# 6. مسح الكاش
echo "=== مسح الكاش ==="
php artisan view:clear
php artisan cache:clear
php artisan config:clear

echo "تم إصلاح الأذونات بنجاح!"



