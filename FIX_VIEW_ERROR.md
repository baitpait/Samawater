# 🔧 حل مشكلة View Error

## المشكلة
خطأ في Views - يبدو أن هناك مشكلة في أحد ملفات الـ views.

---

## ✅ الحل

### الخطوة 1: رؤية بداية الخطأ

**أين:** في Terminal السيرفر

```bash
# عرض أول 50 سطر من آخر خطأ
tail -n 200 storage/logs/laravel.log | head -n 50

# أو البحث عن "ERROR" أو "Exception"
grep -A 20 "ERROR\|Exception" storage/logs/laravel.log | tail -n 50
```

**انسخ بداية الخطأ (السطور الأولى) وأرسلها.**

---

### الخطوة 2: مسح View Cache

```bash
# مسح View Cache
php artisan view:clear

# حذف ملفات View المكشفة
rm -rf storage/framework/views/*.php

# إعادة إنشاء View Cache
php artisan view:cache
```

---

### الخطوة 3: التحقق من الصلاحيات

```bash
# إصلاح صلاحيات storage/framework/views
chmod -R 775 storage/framework/views
chown -R www-data:www-data storage/framework/views
```

---

### الخطوة 4: فعّل Debug Mode مؤقتاً

```bash
nano .env
# غيّر APP_DEBUG=false إلى APP_DEBUG=true
# احفظ: Ctrl+X, Y, Enter

php artisan config:clear
php artisan config:cache
```

**ثم جرّب الوصول للموقع مرة أخرى لرؤية الخطأ بالتفصيل.**

---

## 📝 الأوامر الكاملة (نسخ ولصق)

```bash
cd /home/sarfesak/public_html/eliyaa

# 1. رؤية بداية الخطأ
tail -n 200 storage/logs/laravel.log | head -n 50

# 2. مسح View Cache
php artisan view:clear
rm -rf storage/framework/views/*.php

# 3. إصلاح الصلاحيات
chmod -R 775 storage/framework/views
chown -R www-data:www-data storage/framework/views

# 4. فعّل Debug Mode
nano .env
# غيّر APP_DEBUG=true
# احفظ: Ctrl+X, Y, Enter

php artisan config:clear
php artisan config:cache
```

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** حل مشكلة View Error


