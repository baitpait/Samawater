#!/bin/bash

cd /home/sarfesak/public_html/eliyaa

# 1. إنشاء جميع المجلدات المطلوبة لـ DataTables
mkdir -p storage/app/public/basset/cdn.datatables.net/fixedheader/3.3.1/css
mkdir -p storage/app/public/basset/cdn.datatables.net/fixedheader/3.3.1/js
mkdir -p storage/app/public/basset/cdn.datatables.net/1.13.1/css
mkdir -p storage/app/public/basset/cdn.datatables.net/1.13.1/js

# 2. إنشاء المجلد الرئيسي لـ DataTables مع أذونات كاملة
mkdir -p storage/app/public/basset/cdn.datatables.net
chmod -R 777 storage/app/public/basset/cdn.datatables.net

# 3. إصلاح أذونات جميع مجلدات Basset
chmod -R 777 storage/app/public/basset
chown -R sarfesak:sarfesak storage/app/public/basset

# 4. إصلاح أذونات storage/app/public
chmod -R 775 storage/app/public
chown -R sarfesak:sarfesak storage/app/public

# 5. إصلاح أذونات storage بالكامل
chmod -R 775 storage
chown -R sarfesak:sarfesak storage

# 6. مسح الكاش
php artisan cache:clear
php artisan view:clear
php artisan config:clear

echo "تم إصلاح أذونات Basset بنجاح!"



