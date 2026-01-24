# 🔧 أوامر حل مشكلة HTTP 500 (نسخ ولصق)

## الأوامر الكاملة (شغلها بالترتيب)

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
# 1. إصلاح الصلاحيات
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 2. إنشاء مجلدات إذا لم تكن موجودة
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/app/public

# 3. توليد APP_KEY
php artisan key:generate --force

# 4. مسح جميع أنواع Cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# 5. إعادة إنشاء Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. إنشاء Storage Link
php artisan storage:link

# 7. تحسين Autoload
composer dump-autoload --optimize --no-dev
```

---

## التحقق من الأخطاء

```bash
# عرض آخر الأخطاء
tail -n 50 storage/logs/laravel.log
```

---

## إذا استمرت المشكلة

### 1. تحقق من ملف .env

```bash
nano .env
```

**تأكد من وجود:**
- `APP_KEY=base64:...`
- `APP_DEBUG=false`
- `APP_URL=https://eliyaa.baitpait.space`
- إعدادات قاعدة البيانات صحيحة

### 2. تحقق من Document Root في Webuzo

تأكد من أن Document Root يشير إلى:
```
/home/sarfesak/public_html/eliyaa/public
```
**وليس:**
```
/home/sarfesak/public_html/eliyaa
```

