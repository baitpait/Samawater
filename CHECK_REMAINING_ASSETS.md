# 🔍 فحص الأخطاء المتبقية في Assets

## المشكلة
التصميم يعمل جزئياً - بعض الأجزاء تعمل والبعض الآخر لا.

---

## ✅ خطوات التشخيص

### الخطوة 1: فتح Developer Tools في المتصفح

**في المتصفح:**
1. اضغط `F12` لفتح Developer Tools
2. اذهب إلى **Console** - تحقق من الأخطاء الحمراء
3. اذهب إلى **Network** - تحقق من الملفات التي تفشل في التحميل (404, 403, 500)

**أرسل لي:**
- قائمة بجميع الأخطاء من Console
- قائمة بجميع الملفات التي تفشل في التحميل من Network (404, 403, 500)

---

### الخطوة 2: التحقق من ملفات Assets على السيرفر

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
# 1. التحقق من unified-forms.css
ls -la public/css/unified-forms.css

# 2. التحقق من ملفات build
ls -la public/build/assets/

# 3. التحقق من Basset
ls -la storage/app/public/basset/
ls -la public/storage/basset/

# 4. التحقق من storage link
ls -la public/storage
```

---

### الخطوة 3: إصلاح المشاكل الشائعة

#### المشكلة 1: unified-forms.css غير موجود

```bash
# إذا لم يكن موجوداً، يجب رفعه من المشروع المحلي
# أو إنشاءه على السيرفر
touch public/css/unified-forms.css
chmod 644 public/css/unified-forms.css
chown www-data:www-data public/css/unified-forms.css
```

#### المشكلة 2: ملفات Basset لا تُحمّل (404)

```bash
# إصلاح صلاحيات Basset
chmod -R 775 storage/app/public/basset
chown -R www-data:www-data storage/app/public/basset

# التأكد من storage link
php artisan storage:link

# مسح Cache
php artisan view:clear
php artisan cache:clear
```

#### المشكلة 3: ملفات Vite لا تُحمّل

```bash
# التحقق من ملفات build
ls -la public/build/assets/

# إذا لم تكن موجودة، أعد بناء Assets
nvm use 20
npm run build

# إصلاح الصلاحيات
chmod -R 755 public/build
chown -R www-data:www-data public/build
```

---

## 📝 الأوامر الكاملة للفحص

```bash
cd /home/sarfesak/public_html/eliyaa

# 1. فحص unified-forms.css
echo "=== unified-forms.css ==="
ls -la public/css/unified-forms.css

# 2. فحص build assets
echo "=== Build Assets ==="
ls -la public/build/assets/

# 3. فحص Basset
echo "=== Basset ==="
ls -la storage/app/public/basset/ | head -20
ls -la public/storage/basset/ | head -20

# 4. فحص storage link
echo "=== Storage Link ==="
ls -la public/storage

# 5. فحص الصلاحيات
echo "=== Permissions ==="
ls -ld public/css public/build public/storage
```

---

## 🔧 الحل الشامل (إذا لم تعرف المشكلة)

```bash
cd /home/sarfesak/public_html/eliyaa

# 1. إصلاح جميع الصلاحيات
chmod -R 755 public/css public/build
chown -R www-data:www-data public/css public/build

chmod -R 775 storage/app/public/basset
chown -R www-data:www-data storage/app/public/basset

# 2. التأكد من storage link
php artisan storage:link

# 3. مسح جميع Cache
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear

# 4. إعادة بناء Cache
php artisan config:cache
php artisan view:cache
```

---

## 📋 ما يجب إرساله

**بعد فتح Developer Tools (`F12`):**

1. **Console Tab:**
   - انسخ جميع الأخطاء الحمراء
   - مثال: `GET https://... 404 (Not Found)`

2. **Network Tab:**
   - ابحث عن الملفات التي تفشل (Status: 404, 403, 500)
   - انسخ أسماء الملفات التي تفشل

**أرسل لي:**
- لقطة شاشة من Console
- لقطة شاشة من Network (الملفات الفاشلة)
- أو انسخ النص من الأخطاء

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** فحص الأخطاء المتبقية في Assets


