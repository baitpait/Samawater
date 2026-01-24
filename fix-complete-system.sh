#!/bin/bash

echo "=========================================="
echo "🔧 البدء في إصلاح النظام بالكامل"
echo "=========================================="

# الانتقال للمجلد الصحيح
cd /home/sarfesak/public_html/eliyaa

echo ""
echo "📁 الخطوة 1: إصلاح أذونات storage بالكامل"
echo "------------------------------------------"

# إنشاء جميع المجلدات المطلوبة
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/app/public
mkdir -p storage/app/public/basset
mkdir -p bootstrap/cache

# إصلاح أذونات storage بالكامل
chmod -R 775 storage
chown -R sarfesak:sarfesak storage

# أذونات خاصة لـ logs و views
chmod -R 777 storage/logs
chmod -R 777 storage/framework/views
chmod -R 777 storage/framework/cache
chmod -R 777 storage/framework/sessions

# أذونات bootstrap/cache
chmod -R 775 bootstrap/cache
chown -R sarfesak:sarfesak bootstrap/cache

echo "✅ تم إصلاح أذونات storage"

echo ""
echo "📦 الخطوة 2: إصلاح Basset بالكامل"
echo "------------------------------------------"

# إنشاء جميع مجلدات Basset المطلوبة
mkdir -p storage/app/public/basset/cdn.datatables.net/fixedheader/3.3.1/css
mkdir -p storage/app/public/basset/cdn.datatables.net/fixedheader/3.3.1/js
mkdir -p storage/app/public/basset/cdn.datatables.net/1.13.1/css
mkdir -p storage/app/public/basset/cdn.datatables.net/1.13.1/js
mkdir -p storage/app/public/basset/cdn.jsdelivr.net/npm/animate.css@4.1.1
mkdir -p storage/app/public/basset/cdn.jsdelivr.net/npm/noty@3.2.0-beta-deprecated/lib
mkdir -p storage/app/public/basset/cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css
mkdir -p storage/app/public/basset/cdn.jsdelivr.net/npm/jquery@3.6.1/dist
mkdir -p storage/app/public/basset/cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd
mkdir -p storage/app/public/basset/cdn.jsdelivr.net/npm/sweetalert@2.1.2/dist
mkdir -p storage/app/public/basset/cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd
mkdir -p storage/app/public/basset/cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js
mkdir -p storage/app/public/basset/cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/js
mkdir -p storage/app/public/basset/cdn.jsdelivr.net/npm/@digitallyhappy/backstrap@0.5.1/dist/css

# أذونات كاملة لـ Basset مؤقتاً
chmod -R 777 storage/app/public/basset
chown -R sarfesak:sarfesak storage/app/public/basset

# إعادة إنشاء الرابط الرمزي
rm -rf public/storage
php artisan storage:link

echo "✅ تم إصلاح Basset"

echo ""
echo "🧹 الخطوة 3: تنظيف الكاش بالكامل"
echo "------------------------------------------"

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

echo "✅ تم تنظيف الكاش"

echo ""
echo "⚙️ الخطوة 4: إعادة بناء الكاش"
echo "------------------------------------------"

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ تم إعادة بناء الكاش"

echo ""
echo "🎨 الخطوة 5: إصلاح أذونات CSS"
echo "------------------------------------------"

chmod 644 public/css/unified-forms.css
chown sarfesak:sarfesak public/css/unified-forms.css

echo "✅ تم إصلاح أذونات CSS"

echo ""
echo "🔄 الخطوة 6: إعادة تحميل PHP-FPM"
echo "------------------------------------------"

# محاولة إعادة تحميل PHP-FPM (قد يختلف حسب النظام)
if systemctl is-active --quiet php-fpm; then
    systemctl reload php-fpm
    echo "✅ تم إعادة تحميل PHP-FPM"
elif systemctl is-active --quiet php8.2-fpm; then
    systemctl reload php8.2-fpm
    echo "✅ تم إعادة تحميل PHP 8.2-FPM"
elif systemctl is-active --quiet php8.1-fpm; then
    systemctl reload php8.1-fpm
    echo "✅ تم إعادة تحميل PHP 8.1-FPM"
else
    echo "⚠️  لم يتم العثور على خدمة PHP-FPM"
fi

echo ""
echo "✅ الخطوة 7: التحقق من الحالة"
echo "------------------------------------------"

echo "📊 أذونات storage:"
ls -la storage/ | head -10

echo ""
echo "📊 أذونات Basset:"
ls -la storage/app/public/basset/ | head -10

echo ""
echo "📊 عدد أسطر unified-forms.css:"
wc -l public/css/unified-forms.css

echo ""
echo "=========================================="
echo "✅ اكتمل إصلاح النظام بنجاح!"
echo "=========================================="
echo ""
echo "الخطوات التالية:"
echo "1. افتح الموقع في المتصفح: https://eliyaa.baitpait.space"
echo "2. اضغط Ctrl+Shift+R لتحديث الصفحة (تجاوز الكاش)"
echo "3. افحص Console في Developer Tools"
echo ""
echo "إذا ما زالت المشكلة موجودة:"
echo "- أرسل نتيجة: tail -n 50 storage/logs/laravel.log"
echo "- أرسل أي أخطاء من Console"
echo ""

