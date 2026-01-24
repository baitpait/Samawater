# 🔧 حل مشكلة صلاحيات ملفات Build

## المشكلة
```
drwxr-xr-x 2 root root 4096 assets
```

**السبب:** مجلد `assets` مملوك لـ `root` بدلاً من `www-data`، مما يمنع Web Server من قراءة الملفات.

---

## ✅ الحل السريع

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
# 1. إصلاح صلاحيات public/build بالكامل
chmod -R 755 public/build
chown -R www-data:www-data public/build

# 2. إذا لم يعمل www-data، جرب sarfesak
chown -R sarfesak:sarfesak public/build
chmod -R 755 public/build

# 3. التحقق من الصلاحيات
ls -la public/build/
ls -la public/build/assets/
```

---

## 📝 الأوامر الكاملة (نسخ ولصق)

```bash
cd /home/sarfesak/public_html/eliyaa

# 1. إصلاح صلاحيات public/build
chmod -R 755 public/build
chown -R www-data:www-data public/build

# 2. إذا لم يعمل www-data
chown -R sarfesak:sarfesak public/build
chmod -R 755 public/build

# 3. التحقق من الصلاحيات
ls -la public/build/
ls -la public/build/assets/

# 4. التحقق من الملفات
ls -la public/build/assets/

# 5. مسح Cache
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

---

## 🔍 التحقق من الصلاحيات

**بعد الإصلاح، يجب أن ترى:**

```bash
ls -la public/build/
# drwxr-xr-x  www-data www-data  build/

ls -la public/build/assets/
# drwxr-xr-x  www-data www-data  assets/
# -rw-r--r--  www-data www-data  app-*.css
# -rw-r--r--  www-data www-data  app-*.js
```

---

## ✅ بعد الإصلاح

1. **امسح Cache المتصفح:** `Ctrl+Shift+Delete`
2. **أعد تحميل الصفحة:** `Ctrl+F5` (Hard Refresh)
3. **تحقق من Developer Tools:** `F12` → Network → تحقق من تحميل CSS/JS

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** حل مشكلة صلاحيات ملفات Build


