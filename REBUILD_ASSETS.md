# 🔄 إعادة بناء Assets باستخدام Node.js 20

## المشكلة
ملفات build قديمة - تم إنشاؤها أمس قبل تثبيت Node.js 20.

---

## ✅ الحل: إعادة بناء Assets

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

### الخطوة 1: حذف Build القديم

```bash
# حذف build القديم
rm -rf public/build
rm -rf node_modules/.vite
```

---

### الخطوة 2: استخدام Node.js 20

```bash
# تحميل NVM
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

# استخدام Node.js 20
nvm use 20

# التحقق من الإصدار
node -v
# يجب أن يكون: v20.x.x
```

---

### الخطوة 3: إعادة بناء Assets

```bash
# الانتقال إلى مجلد المشروع
cd /home/sarfesak/public_html/eliyaa

# إعادة بناء Assets
npm run build
```

**انتظر حتى يكتمل البناء...**

---

### الخطوة 4: إصلاح الصلاحيات

```bash
# إصلاح صلاحيات public/build
chmod -R 755 public/build
chown -R www-data:www-data public/build

# إذا لم يعمل www-data
chown -R sarfesak:sarfesak public/build
chmod -R 755 public/build
```

---

### الخطوة 5: التحقق من الملفات

```bash
# التحقق من وجود الملفات
ls -la public/build/
ls -la public/build/assets/

# يجب أن ترى:
# - manifest.json
# - assets/app-*.css
# - assets/app-*.js
```

---

### الخطوة 6: مسح Cache

```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

---

## 📝 الأوامر الكاملة (نسخ ولصق)

```bash
cd /home/sarfesak/public_html/eliyaa

# 1. تحميل NVM
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

# 2. استخدام Node.js 20
nvm use 20

# 3. حذف build القديم
rm -rf public/build
rm -rf node_modules/.vite

# 4. إعادة بناء Assets
npm run build

# 5. إصلاح الصلاحيات
chmod -R 755 public/build
chown -R www-data:www-data public/build

# 6. التحقق من الملفات
ls -la public/build/assets/

# 7. مسح Cache
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

---

## ✅ بعد الإصلاح

1. **امسح Cache المتصفح:** `Ctrl+Shift+Delete`
2. **أعد تحميل الصفحة:** `Ctrl+F5` (Hard Refresh)
3. **تحقق من Developer Tools:** `F12` → Network → تحقق من تحميل CSS/JS

---

## 🔍 التحقق من النتيجة

**بعد البناء، يجب أن ترى:**

```bash
ls -la public/build/assets/
# -rw-r--r--  www-data www-data  app-*.css
# -rw-r--r--  www-data www-data  app-*.js
```

**والحجم يجب أن يكون أكبر من الملفات القديمة.**

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** إعادة بناء Assets باستخدام Node.js 20


