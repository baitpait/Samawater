#!/bin/bash

# إنشاء جميع المجلدات المحتملة لـ DataTables
mkdir -p /home/sarfesak/public_html/eliyaa/storage/app/public/basset/cdn.datatables.net/1.13.1/css
mkdir -p /home/sarfesak/public_html/eliyaa/storage/app/public/basset/cdn.datatables.net/fixedheader/3.3.1/css
mkdir -p /home/sarfesak/public_html/eliyaa/storage/app/public/basset/cdn.datatables.net/1.13.1/js
mkdir -p /home/sarfesak/public_html/eliyaa/storage/app/public/basset/cdn.datatables.net/fixedheader/3.3.1/js

# إصلاح الأذونات لجميع مجلدات Basset
chmod -R 775 /home/sarfesak/public_html/eliyaa/storage/app/public/basset
chown -R www-data:www-data /home/sarfesak/public_html/eliyaa/storage/app/public/basset

# إصلاح الأذونات للمجلد الرئيسي
chmod -R 775 /home/sarfesak/public_html/eliyaa/storage/app/public
chown -R www-data:www-data /home/sarfesak/public_html/eliyaa/storage/app/public

# إصلاح الأذونات لجميع مجلدات storage
chmod -R 775 /home/sarfesak/public_html/eliyaa/storage
chown -R www-data:www-data /home/sarfesak/public_html/eliyaa/storage

echo "تم إنشاء جميع المجلدات وإصلاح الأذونات بنجاح!"



