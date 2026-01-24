# 🔧 حل سريع لمشكلة HTTP 500 - دليل بالعربية

## المشكلة
عند الوصول إلى `https://eliyaa.baitpait.space/admin/login` تظهر رسالة:
```
HTTP ERROR 500
This page isn't working
eliyaa.baitpait.space is currently unable to handle this request.
```

---

## ✅ الحل السريع (5 دقائق)

### الخطوة 1: الاتصال بالسيرفر

افتح Terminal أو SSH Client واتصل بالسيرفر:

```bash
ssh username@your-server-ip
```

### الخطوة 2: الانتقال لمجلد المشروع

```bash
# ابحث عن مجلد المشروع (عادة في public_html)
cd /home/username/public_html/eliyaa
# أو
cd /home/username/domains/eliyaa.baitpait.space/public_html
```

### الخطوة 3: رفع ملف fix-500.sh

**من جهازك المحلي:**
```bash
scp fix-500.sh username@your-server-ip:/home/username/public_html/eliyaa/
```

**أو أنشئ الملف مباشرة على السيرفر:**
```bash
nano fix-500.sh
# ثم انسخ محتوى الملف والصقه
```

### الخطوة 4: تشغيل السكريبت

```bash
# جعل الملف قابل للتنفيذ
chmod +x fix-500.sh

# تشغيل السكريبت
./fix-500.sh
```

### الخطوة 5: التحقق من ملف .env

```bash
# تحرير ملف .env
nano .env
```

**تأكد من وجود هذه الإعدادات:**

```env
APP_NAME="Eliyaa Water Distribution"
APP_ENV=production
APP_KEY=base64:eTVtaWVpZmdqbm40czU5NXB3YXQ0cGk3ajZmaTJqZ3k=
APP_DEBUG=false
APP_URL=https://eliyaa.baitpait.space

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=اسم_قاعدة_البيانات
DB_USERNAME=اسم_المستخدم
DB_PASSWORD=كلمة_المرور
```

**احفظ الملف:** `Ctrl+X` ثم `Y` ثم `Enter`

### الخطوة 6: ترقية Node.js (إذا كان الإصدار قديم)

**إذا ظهرت رسالة خطأ تتعلق بـ Node.js version:**

```bash
# تثبيت NVM
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

# تثبيت Node.js 20
nvm install 20
nvm use 20
nvm alias default 20

# التحقق من الإصدار
node -v  # يجب أن يكون v20.x.x
```

### الخطوة 7: بناء ملفات CSS و JavaScript

```bash
# الانتقال إلى مجلد المشروع
cd /home/sarfesak/public_html/eliyaa

# حذف node_modules القديم (اختياري)
rm -rf node_modules package-lock.json

# تثبيت Dependencies
npm install

# بناء Assets
npm run build
```

### الخطوة 7: مسح Cache مرة أخرى

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### الخطوة 7: التحقق من الأخطاء

```bash
tail -n 50 storage/logs/laravel.log
```

---

## 🔍 إذا استمرت المشكلة

### 1. تحقق من Document Root في Webuzo

1. سجل الدخول إلى لوحة تحكم Webuzo
2. اذهب إلى **Apache Settings** أو **Nginx Settings**
3. تأكد من أن **Document Root** يشير إلى:
   ```
   /home/username/public_html/eliyaa/public
   ```
   **مهم جداً:** يجب أن ينتهي بـ `/public`

### 2. تحقق من PHP Version

في Webuzo:
1. اذهب إلى **PHP Settings**
2. تأكد من أن PHP Version هو **8.1** أو أحدث

### 3. تحقق من الصلاحيات يدوياً

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 4. تحقق من Composer و NPM

```bash
# تثبيت Composer Dependencies
composer install --no-dev --optimize-autoloader

# تثبيت NPM Dependencies وبناء Assets
npm install
npm run build
```

### 5. فعّل Debug Mode مؤقتاً

```bash
# في ملف .env
APP_DEBUG=true

# ثم مسح Cache
php artisan config:clear
```

ثم جرب الوصول للموقع مرة أخرى لرؤية الخطأ بالتفصيل.

---

## 📋 قائمة التحقق

- [ ] تم تشغيل سكريبت `fix-500.sh`
- [ ] ملف `.env` موجود ويحتوي على جميع الإعدادات
- [ ] Document Root في Webuzo يشير إلى `public/`
- [ ] PHP Version 8.1 أو أحدث
- [ ] تم تثبيت Composer Dependencies
- [ ] الصلاحيات صحيحة (775 لـ storage و bootstrap/cache)
- [ ] تم مسح Cache

---

## 🆘 إذا لم تحل المشكلة

### عرض الأخطاء بالتفصيل:

```bash
# عرض آخر 100 سطر من ملف الأخطاء
tail -n 100 storage/logs/laravel.log

# أو عرض الأخطاء في الوقت الفعلي
tail -f storage/logs/laravel.log
```

### عرض أخطاء Web Server:

```bash
# Apache
tail -f /var/log/apache2/error.log

# Nginx  
tail -f /var/log/nginx/error.log
```

---

## ✅ الحل السريع جداً (نسخ ولصق)

```bash
cd /home/username/public_html/eliyaa
chmod -R 775 storage bootstrap/cache
php artisan key:generate --force
npm install && npm run build
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload --optimize
```

---

**ملاحظة:** بعد إصلاح المشكلة، تأكد من تعطيل `APP_DEBUG=true` في ملف `.env` ووضع `APP_DEBUG=false` للأمان.

