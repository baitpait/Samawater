# 🔧 حل مشكلة HTTP 500 Error على السيرفر

## المشكلة
```
HTTP ERROR 500 عند الوصول إلى: https://eliyaa.baitpait.space/admin/login
```

---

## ✅ الحل السريع - خطوات يجب تنفيذها على السيرفر

### الخطوة 1: الاتصال بالسيرفر عبر SSH

```bash
ssh username@your-server-ip
# أو
ssh username@eliyaa.baitpait.space
```

### الخطوة 2: الانتقال إلى مجلد المشروع

```bash
# ابحث عن مجلد المشروع (عادة في public_html)
cd /home/username/public_html/eliyaa
# أو
cd /home/username/domains/eliyaa.baitpait.space/public_html
```

### الخطوة 3: التحقق من ملف .env

```bash
# تحقق من وجود ملف .env
ls -la .env

# إذا لم يكن موجوداً، أنشئه من .env.example
cp .env.example .env

# تحرير ملف .env
nano .env
```

**تأكد من وجود هذه الإعدادات في ملف .env:**

```env
APP_NAME="Eliyaa Water Distribution"
APP_ENV=production
APP_KEY=base64:eTVtaWVpZmdqbm40czU5NXB3YXQ0cGk3ajZmaTJqZ3k=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://eliyaa.baitpait.space

APP_LOCALE=ar
APP_FALLBACK_LOCALE=ar

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
```

### الخطوة 4: توليد APP_KEY (مهم جداً!)

```bash
php artisan key:generate
```

### الخطوة 5: إصلاح الصلاحيات (Permissions)

```bash
# إعطاء صلاحيات للمجلدات المطلوبة
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# تغيير المالك (استبدل www-data بـ المستخدم الصحيح)
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

# أو إذا كان المستخدم مختلفاً
chown -R username:username storage
chown -R username:username bootstrap/cache
```

### الخطوة 6: تثبيت Dependencies

```bash
# تثبيت Composer packages
composer install --no-dev --optimize-autoloader

# إذا لم يكن composer مثبتاً، استخدم المسار الكامل
/usr/local/bin/composer install --no-dev --optimize-autoloader

# تثبيت NPM packages وبناء Assets
npm install
npm run build
```

### الخطوة 7: مسح جميع أنواع Cache

```bash
# مسح Cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# إعادة إنشاء Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### الخطوة 8: إنشاء Storage Link

```bash
php artisan storage:link
```

### الخطوة 9: التحقق من قاعدة البيانات

```bash
# اختبار الاتصال بقاعدة البيانات
php artisan tinker
# ثم في Tinker:
DB::connection()->getPdo();
# إذا نجح، اكتب exit
```

### الخطوة 10: التحقق من الأخطاء في Logs

```bash
# عرض آخر الأخطاء
tail -n 50 storage/logs/laravel.log

# أو عرض الأخطاء في الوقت الفعلي
tail -f storage/logs/laravel.log
```

---

## 🔍 تشخيص المشكلة - خطوات التحقق

### 1. التحقق من PHP Version

```bash
php -v
# يجب أن يكون PHP 8.1 أو أحدث
```

### 2. التحقق من PHP Extensions المطلوبة

```bash
php -m | grep -E "pdo|mbstring|openssl|tokenizer|xml|ctype|json|bcmath"
```

**Extensions المطلوبة:**
- pdo_mysql
- mbstring
- openssl
- tokenizer
- xml
- ctype
- json
- bcmath

### 3. التحقق من Composer

```bash
composer --version
# أو
/usr/local/bin/composer --version
```

### 4. التحقق من صلاحيات الملفات

```bash
# يجب أن تكون الصلاحيات كالتالي:
ls -la storage/
ls -la bootstrap/cache/
```

### 5. التحقق من إعدادات Web Server

**للتحقق من Apache:**
```bash
# التحقق من DocumentRoot
cat /etc/apache2/sites-available/eliyaa.baitpait.space.conf | grep DocumentRoot

# يجب أن يشير إلى: /path/to/eliyaa/public
```

**للتحقق من Nginx:**
```bash
cat /etc/nginx/sites-available/eliyaa.baitpait.space | grep root
```

---

## 🚨 حلول للمشاكل الشائعة

### المشكلة 1: "Class not found" أو "Autoload error"

```bash
composer dump-autoload
php artisan optimize:clear
```

### المشكلة 2: "Permission denied" في storage

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### المشكلة 3: "Database connection failed"

1. تحقق من بيانات قاعدة البيانات في `.env`
2. تأكد من أن قاعدة البيانات موجودة
3. تأكد من صلاحيات المستخدم

```bash
# اختبار الاتصال
mysql -u your_username -p your_database_name
```

### المشكلة 4: "APP_KEY is not set"

```bash
php artisan key:generate
php artisan config:clear
php artisan config:cache
```

### المشكلة 5: "The stream or file could not be opened"

```bash
# إنشاء مجلدات logs إذا لم تكن موجودة
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views

# إعطاء الصلاحيات
chmod -R 775 storage
chown -R www-data:www-data storage
```

---

## 📝 سكريبت تلقائي لإصلاح المشاكل

أنشئ ملف `fix-500.sh` على السيرفر:

```bash
#!/bin/bash

echo "🔧 بدء إصلاح مشكلة HTTP 500..."

# الانتقال إلى مجلد المشروع
cd /path/to/eliyaa

# 1. إصلاح الصلاحيات
echo "📁 إصلاح الصلاحيات..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 2. إنشاء مجلدات إذا لم تكن موجودة
echo "📂 إنشاء المجلدات المطلوبة..."
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views

# 3. توليد APP_KEY
echo "🔑 توليد APP_KEY..."
php artisan key:generate --force

# 4. مسح Cache
echo "🧹 مسح Cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 5. إعادة إنشاء Cache
echo "💾 إعادة إنشاء Cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. إنشاء Storage Link
echo "🔗 إنشاء Storage Link..."
php artisan storage:link

# 7. تحسين Autoload
echo "⚡ تحسين Autoload..."
composer dump-autoload --optimize

echo "✅ تم إصلاح المشاكل!"
echo "📋 تحقق من الأخطاء: tail -f storage/logs/laravel.log"
```

**استخدام السكريبت:**

```bash
# جعل السكريبت قابل للتنفيذ
chmod +x fix-500.sh

# تشغيل السكريبت
./fix-500.sh
```

---

## 🔐 إعدادات Webuzo المهمة

### 1. Document Root في Webuzo

1. سجل الدخول إلى Webuzo
2. اذهب إلى **Apache Settings** أو **Nginx Settings**
3. تأكد من أن **Document Root** يشير إلى:
   ```
   /home/username/public_html/eliyaa/public
   ```
   **وليس:**
   ```
   /home/username/public_html/eliyaa
   ```

### 2. PHP Version في Webuzo

1. اذهب إلى **PHP Settings**
2. تأكد من أن PHP Version هو 8.1 أو أحدث
3. تأكد من تفعيل Extensions المطلوبة

---

## ✅ قائمة التحقق النهائية

- [ ] ملف `.env` موجود ويحتوي على جميع الإعدادات
- [ ] `APP_KEY` موجود ومولّد
- [ ] صلاحيات `storage/` و `bootstrap/cache/` صحيحة (775)
- [ ] `composer install` تم بنجاح
- [ ] جميع أنواع Cache تم مسحها وإعادة إنشائها
- [ ] `storage:link` تم إنشاؤه
- [ ] قاعدة البيانات متصلة
- [ ] Document Root يشير إلى `public/`
- [ ] PHP Version 8.1 أو أحدث
- [ ] جميع PHP Extensions المطلوبة مثبتة

---

## 📞 إذا استمرت المشكلة

1. **تحقق من Logs:**
   ```bash
   tail -n 100 storage/logs/laravel.log
   ```

2. **فعّل Debug Mode مؤقتاً:**
   ```bash
   # في ملف .env
   APP_DEBUG=true
   
   # ثم مسح Cache
   php artisan config:clear
   ```

3. **تحقق من Web Server Logs:**
   ```bash
   # Apache
   tail -f /var/log/apache2/error.log
   
   # Nginx
   tail -f /var/log/nginx/error.log
   ```

---

## 🎯 الحل السريع (Quick Fix)

```bash
cd /path/to/eliyaa
chmod -R 775 storage bootstrap/cache
php artisan key:generate --force
php artisan config:clear
php artisan cache:clear
php artisan config:cache
composer dump-autoload --optimize
```

---

**تاريخ الإنشاء:** 2025-01-01
**آخر تحديث:** بعد اكتشاف مشكلة HTTP 500

