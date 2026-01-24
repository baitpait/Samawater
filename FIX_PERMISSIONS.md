# 🔧 حل مشكلة Permission Denied

## المشكلة
```
file_put_contents(.../storage/framework/views/...): Failed to open stream: Permission denied
```

**السبب:** مجلدات `storage` و `bootstrap/cache` لا تملك صلاحيات الكتابة.

---

## ✅ الحل السريع

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
# 1. إصلاح الصلاحيات
chmod -R 775 storage bootstrap/cache

# 2. تغيير المالك
chown -R www-data:www-data storage bootstrap/cache

# 3. إذا لم يعمل www-data، جرب المستخدم الحالي
chown -R sarfesak:sarfesak storage bootstrap/cache

# 4. مسح Cache
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# 5. إعادة إنشاء Cache
php artisan config:cache
php artisan view:cache
```

---

## 🔍 التحقق من الصلاحيات

```bash
# التحقق من صلاحيات storage
ls -la storage/

# يجب أن ترى:
# drwxrwxr-x  www-data www-data  storage/

# التحقق من صلاحيات bootstrap/cache
ls -la bootstrap/cache/

# يجب أن ترى:
# drwxrwxr-x  www-data www-data  cache/
```

---

## ⚠️ إذا استمرت المشكلة

### الحل 1: استخدام المستخدم sarfesak

```bash
chown -R sarfesak:sarfesak storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### الحل 2: التحقق من المستخدم الصحيح

```bash
# معرفة المستخدم الذي يشغّل PHP
ps aux | grep php-fpm

# أو
ps aux | grep apache
```

**ثم استخدم نفس المستخدم في chown.**

---

## 📝 الأوامر الكاملة (نسخ ولصق)

```bash
# إصلاح الصلاحيات
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# إذا لم يعمل www-data
chown -R sarfesak:sarfesak storage bootstrap/cache

# مسح Cache
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# إعادة إنشاء Cache
php artisan config:cache
php artisan view:cache
```

---

## ✅ التحقق النهائي

```bash
# التحقق من الصلاحيات
ls -la storage/framework/views/ | head -5

# يجب أن ترى صلاحيات: drwxrwxr-x
```

**ثم جرّب الوصول للموقع مرة أخرى.**

