# 🔍 تشخيص مشكلة HTTP 500

## الخطوة 1: عرض الأخطاء

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
# عرض آخر 100 سطر من ملف الأخطاء
tail -n 100 storage/logs/laravel.log
```

**أو:**

```bash
# عرض آخر الأخطاء فقط
tail -n 50 storage/logs/laravel.log | grep -A 10 "ERROR"
```

---

## الخطوة 2: التحقق من ملف .env

```bash
# التحقق من APP_KEY
cat .env | grep APP_KEY

# التحقق من APP_DEBUG
cat .env | grep APP_DEBUG

# التحقق من APP_URL
cat .env | grep APP_URL

# التحقق من قاعدة البيانات
cat .env | grep DB_
```

---

## الخطوة 3: مسح Cache وإعادة المحاولة

```bash
# مسح جميع أنواع Cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# إعادة إنشاء Cache
php artisan config:cache
php artisan route:cache
```

---

## الخطوة 4: التحقق من Composer

```bash
# التحقق من Composer
composer --version

# إعادة تحميل Autoload بدون optimize
composer dump-autoload

# إذا فشل، جرب:
composer dump-autoload --no-scripts
```

---

## الخطوة 5: فعّل Debug Mode مؤقتاً

```bash
# تعديل ملف .env
nano .env
```

**غيّر:**
```
APP_DEBUG=false
```
**إلى:**
```
APP_DEBUG=true
```

**ثم:**
```bash
php artisan config:clear
php artisan config:cache
```

**ثم جرب الوصول للموقع مرة أخرى لرؤية الخطأ بالتفصيل.**

---

## الخطوة 6: التحقق من الصلاحيات

```bash
# التحقق من صلاحيات storage
ls -la storage/

# التحقق من صلاحيات bootstrap/cache
ls -la bootstrap/cache/

# إصلاح الصلاحيات
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## الخطوة 7: التحقق من PHP Errors

```bash
# عرض أخطاء PHP
php -v

# اختبار PHP
php -r "echo 'PHP works';"
```

---

## الخطوة 8: التحقق من Web Server Logs

```bash
# Apache
tail -n 50 /var/log/apache2/error.log

# أو Nginx
tail -n 50 /var/log/nginx/error.log
```

---

## الأخطاء الشائعة وحلولها

### خطأ: "Class not found"
```bash
composer dump-autoload
php artisan optimize:clear
```

### خطأ: "Permission denied"
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### خطأ: "APP_KEY is not set"
```bash
php artisan key:generate --force
php artisan config:clear
php artisan config:cache
```

### خطأ: "Database connection failed"
```bash
# تحقق من إعدادات قاعدة البيانات في .env
cat .env | grep DB_
```

---

## الحل السريع (إعادة تعيين كل شيء)

```bash
# 1. مسح جميع أنواع Cache
php artisan optimize:clear

# 2. إعادة تحميل Autoload
composer dump-autoload

# 3. إعادة إنشاء Cache
php artisan config:cache
php artisan route:cache

# 4. التحقق من الأخطاء
tail -n 50 storage/logs/laravel.log
```

