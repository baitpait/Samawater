# 🔧 حل مشكلة Permission Denied في Views

## المشكلة
```
file_put_contents(.../storage/framework/views/...): Failed to open stream: Permission denied
```

**السبب:** مجلد `storage/framework/views` لا يملك صلاحيات الكتابة.

---

## ✅ الحل السريع

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
# 1. إصلاح صلاحيات storage/framework/views
chmod -R 775 storage/framework/views
chown -R www-data:www-data storage/framework/views

# 2. إذا لم يعمل www-data، جرب sarfesak
chown -R sarfesak:sarfesak storage/framework/views

# 3. حذف ملفات Views القديمة
rm -rf storage/framework/views/*.php

# 4. مسح View Cache
php artisan view:clear

# 5. التحقق من الصلاحيات
ls -la storage/framework/views/ | head -5
```

---

## 📝 الأوامر الكاملة (نسخ ولصق)

```bash
cd /home/sarfesak/public_html/eliyaa

# 1. إصلاح صلاحيات storage/framework/views
chmod -R 775 storage/framework/views
chown -R www-data:www-data storage/framework/views

# 2. إذا لم يعمل www-data
chown -R sarfesak:sarfesak storage/framework/views

# 3. حذف ملفات Views القديمة
rm -rf storage/framework/views/*.php

# 4. مسح View Cache
php artisan view:clear

# 5. إصلاح جميع صلاحيات storage
chmod -R 775 storage
chown -R www-data:www-data storage

# 6. التحقق
ls -la storage/framework/views/ | head -5
```

---

## 🔍 التحقق من الصلاحيات

```bash
# التحقق من صلاحيات storage/framework/views
ls -la storage/framework/views/

# يجب أن ترى:
# drwxrwxr-x  www-data www-data  views/
```

---

## ⚠️ إذا استمرت المشكلة

### الحل 1: استخدام المستخدم sarfesak

```bash
chown -R sarfesak:sarfesak storage
chmod -R 775 storage
```

### الحل 2: التحقق من المستخدم الذي يشغّل PHP

```bash
# معرفة المستخدم الذي يشغّل PHP
ps aux | grep php-fpm | head -1
ps aux | grep apache | head -1

# استخدام نفس المستخدم في chown
```

---

## ✅ بعد الإصلاح

```bash
# مسح Cache
php artisan view:clear
php artisan config:clear
php artisan cache:clear

# إعادة إنشاء Cache
php artisan config:cache
php artisan view:cache
```

**ثم جرّب الوصول للموقع مرة أخرى.**

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** حل مشكلة Permission Denied في Views


