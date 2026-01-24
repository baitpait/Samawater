#!/bin/bash

# سكريبت إصلاح مشكلة HTTP 500 Error
# يجب تشغيله من مجلد المشروع على السيرفر

echo "🔧 بدء إصلاح مشكلة HTTP 500..."
echo ""

# التحقق من وجود artisan
if [ ! -f "artisan" ]; then
    echo "❌ خطأ: ملف artisan غير موجود. تأكد من أنك في مجلد المشروع الصحيح."
    exit 1
fi

# 1. إصلاح الصلاحيات
echo "📁 [1/8] إصلاح الصلاحيات..."
chmod -R 775 storage bootstrap/cache 2>/dev/null
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || chown -R $(whoami):$(whoami) storage bootstrap/cache 2>/dev/null
echo "✅ تم إصلاح الصلاحيات"
echo ""

# 2. إنشاء مجلدات إذا لم تكن موجودة
echo "📂 [2/8] إنشاء المجلدات المطلوبة..."
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/app/public
echo "✅ تم إنشاء المجلدات"
echo ""

# 3. التحقق من ملف .env
echo "🔍 [3/8] التحقق من ملف .env..."
if [ ! -f ".env" ]; then
    echo "⚠️  ملف .env غير موجود. جاري إنشاؤه من .env.example..."
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo "✅ تم إنشاء ملف .env من .env.example"
        echo "⚠️  يرجى تعديل ملف .env وإضافة إعدادات قاعدة البيانات والإعدادات الأخرى"
    else
        echo "❌ ملف .env.example غير موجود أيضاً!"
    fi
else
    echo "✅ ملف .env موجود"
fi
echo ""

# 4. توليد APP_KEY
echo "🔑 [4/8] توليد APP_KEY..."
php artisan key:generate --force 2>/dev/null || echo "⚠️  لم يتم توليد APP_KEY (قد يكون موجوداً بالفعل)"
echo "✅ تم التحقق من APP_KEY"
echo ""

# 5. مسح Cache
echo "🧹 [5/8] مسح جميع أنواع Cache..."
php artisan config:clear 2>/dev/null
php artisan cache:clear 2>/dev/null
php artisan route:clear 2>/dev/null
php artisan view:clear 2>/dev/null
php artisan optimize:clear 2>/dev/null
echo "✅ تم مسح Cache"
echo ""

# 6. إعادة إنشاء Cache
echo "💾 [6/8] إعادة إنشاء Cache..."
php artisan config:cache 2>/dev/null || echo "⚠️  فشل في إنشاء config cache"
php artisan route:cache 2>/dev/null || echo "⚠️  فشل في إنشاء route cache"
php artisan view:cache 2>/dev/null || echo "⚠️  فشل في إنشاء view cache"
echo "✅ تم إعادة إنشاء Cache"
echo ""

# 7. إنشاء Storage Link
echo "🔗 [7/8] إنشاء Storage Link..."
php artisan storage:link 2>/dev/null || echo "⚠️  فشل في إنشاء storage link (قد يكون موجوداً بالفعل)"
echo "✅ تم التحقق من Storage Link"
echo ""

# 8. بناء Assets (CSS/JS)
echo "🎨 [8/9] بناء ملفات CSS و JavaScript..."
if command -v npm &> /dev/null; then
    if [ -f "package.json" ]; then
        echo "   جاري تثبيت Dependencies..."
        npm install --production 2>/dev/null || echo "⚠️  فشل في تثبيت npm packages"
        echo "   جاري بناء Assets..."
        npm run build 2>/dev/null || echo "⚠️  فشل في بناء Assets (قد تكون ملفات build موجودة بالفعل)"
        echo "✅ تم بناء Assets"
    else
        echo "⚠️  ملف package.json غير موجود. تخطي خطوة بناء Assets"
    fi
else
    echo "⚠️  npm غير موجود. تخطي خطوة بناء Assets"
fi
echo ""

# 9. تحسين Autoload
echo "⚡ [9/9] تحسين Autoload..."
if command -v composer &> /dev/null; then
    composer dump-autoload --optimize --no-dev 2>/dev/null || echo "⚠️  فشل في تحسين autoload"
    echo "✅ تم تحسين Autoload"
else
    echo "⚠️  Composer غير موجود. تخطي خطوة تحسين Autoload"
fi
echo ""

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ تم إكمال جميع الخطوات!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📋 الخطوات التالية:"
echo "1. تحقق من ملف .env وتأكد من صحة إعدادات قاعدة البيانات"
echo "2. إذا لم يتم بناء Assets، شغّل: npm install && npm run build"
echo "3. تحقق من الأخطاء: tail -f storage/logs/laravel.log"
echo "4. تأكد من أن Document Root في Webuzo يشير إلى مجلد public/"
echo "5. جرب الوصول إلى الموقع مرة أخرى"
echo ""
echo "🔍 لعرض آخر الأخطاء:"
echo "   tail -n 50 storage/logs/laravel.log"
echo ""

