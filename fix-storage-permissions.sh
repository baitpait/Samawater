#!/bin/bash

# إصلاح أذونات جميع مجلدات storage
cd /home/sarfesak/public_html/eliyaa

# إصلاح أذونات storage/framework
chmod -R 775 storage/framework
chown -R www-data:www-data storage/framework

# إصلاح أذونات storage/framework/views بشكل خاص
chmod -R 775 storage/framework/views
chown -R www-data:www-data storage/framework/views

# إصلاح أذونات storage/framework/cache
chmod -R 775 storage/framework/cache
chown -R www-data:www-data storage/framework/cache

# إصلاح أذونات storage/framework/sessions
chmod -R 775 storage/framework/sessions
chown -R www-data:www-data storage/framework/sessions

# إصلاح أذونات storage/logs
chmod -R 775 storage/logs
chown -R www-data:www-data storage/logs

# إصلاح أذونات storage/app
chmod -R 775 storage/app
chown -R www-data:www-data storage/app

# إصلاح أذونات storage بالكامل
chmod -R 775 storage
chown -R www-data:www-data storage

# مسح الكاش
php artisan cache:clear
php artisan view:clear
php artisan config:clear

echo "تم إصلاح جميع أذونات storage بنجاح!"



