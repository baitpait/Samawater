#!/bin/bash

# إنشاء المجلد المطلوب
mkdir -p /home/sarfesak/public_html/eliyaa/storage/app/public/basset/cdn.datatables.net/1.13.1/css

# إصلاح الأذونات لجميع مجلدات Basset
chmod -R 775 /home/sarfesak/public_html/eliyaa/storage/app/public/basset
chown -R www-data:www-data /home/sarfesak/public_html/eliyaa/storage/app/public/basset

# التأكد من أن المجلد الرئيسي له الأذونات الصحيحة
chmod -R 775 /home/sarfesak/public_html/eliyaa/storage/app/public
chown -R www-data:www-data /home/sarfesak/public_html/eliyaa/storage/app/public

echo "تم إنشاء المجلد وإصلاح الأذونات بنجاح!"



