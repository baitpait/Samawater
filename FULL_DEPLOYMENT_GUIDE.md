# 🚀 دليل رفع المشروع الكامل على السيرفر
## Full Project Deployment Guide

**الدومين:** https://eliyaa.baitpait.space/
**التاريخ:** 31 ديسمبر 2024
**الحالة:** رفع المشروع بالكامل (قاعدة البيانات موجودة)

---

## 📋 **الوضع الحالي:**

- ✅ قاعدة البيانات موجودة على السيرفر (`sarfesak_eliyaa`)
- ❌ جميع ملفات المشروع تم حذفها
- ✅ يجب رفع المشروع بالكامل

---

## 📦 **الملفات للرفع:**

### ✅ **ملفات يجب رفعها:**
- ✅ `app/` - جميع ملفات التطبيق
- ✅ `bootstrap/` - ملفات Bootstrap
- ✅ `config/` - ملفات الإعدادات
- ✅ `database/` - Migrations و Seeders
- ✅ `public/` - الملفات العامة (CSS, JS, images)
- ✅ `resources/` - Views و Assets
- ✅ `routes/` - ملفات Routes
- ✅ `storage/` - مجلد Storage (بدون logs و cache)
- ✅ `composer.json` و `composer.lock`
- ✅ `package.json` و `package-lock.json`
- ✅ `.htaccess` (إن وجد)
- ✅ `artisan` - ملف Laravel الرئيسي

### ❌ **ملفات لا ترفعها:**
- ❌ `vendor/` - سيتم تثبيته عبر `composer install`
- ❌ `node_modules/` - سيتم تثبيته عبر `npm install`
- ❌ `.git/` - مجلد Git
- ❌ `.env` - سيتم إنشاؤه على السيرفر
- ❌ `.env.example` - اختياري
- ❌ `storage/logs/*.log` - ملفات السجلات
- ❌ `storage/framework/cache/*` - ملفات Cache
- ❌ `storage/framework/sessions/*` - ملفات Sessions
- ❌ `storage/framework/views/*` - ملفات Views المترجمة
- ❌ `*.zip` - ملفات ZIP

---

## 🚀 **خطوات الرفع:**

### **الخطوة 1: إنشاء ملف ZIP للمشروع الكامل**

#### على جهازك المحلي:
```bash
cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/water Aelea/eliyaa file/eliyaa"

# إنشاء ملف ZIP (استثناء الملفات غير الضرورية)
zip -r eliyaa-full-deployment.zip . \
  -x "node_modules/*" \
  -x "vendor/*" \
  -x ".git/*" \
  -x ".env" \
  -x "storage/logs/*.log" \
  -x "storage/framework/cache/*" \
  -x "storage/framework/sessions/*" \
  -x "storage/framework/views/*" \
  -x "*.zip" \
  -x ".DS_Store" \
  -x "*.swp" \
  -x "*.swo"
```

---

### **الخطوة 2: رفع ملف ZIP عبر Webuzo**

1. سجل الدخول إلى Webuzo: `https://your-server-ip:2443`
2. اذهب إلى **File Manager**
3. انتقل إلى مجلد المشروع (عادة `/home/username/public_html/` أو `/home/username/domains/eliyaa.baitpait.space/public_html/`)
4. اضغط **Upload**
5. اختر ملف `eliyaa-full-deployment.zip`
6. انتظر اكتمال الرفع (قد يستغرق وقتاً حسب حجم الملف)

---

### **الخطوة 3: استخراج الملفات**

#### عبر Webuzo File Manager:
1. في File Manager، انقر بزر الماوس الأيمن على `eliyaa-full-deployment.zip`
2. اختر **Extract** أو **Unzip**
3. تأكد من استخراج الملفات في المجلد الصحيح

#### أو عبر SSH:
```bash
cd /path/to/project
unzip -o eliyaa-full-deployment.zip
```

---

### **الخطوة 4: إنشاء ملف .env على السيرفر**

#### **الطريقة 1: رفع الملف القديم (الأسهل)**

إذا كان لديك ملف `.env` قديم على جهازك:

1. في File Manager، ارفع ملف `.env` من جهازك
2. **مهم جداً:** بعد الرفع، افتح ملف `.env` على السيرفر وعدّل هذه الإعدادات الثلاثة:
   ```env
   APP_ENV=production        # غير من local إلى production
   APP_DEBUG=false           # غير من true إلى false
   LOG_LEVEL=error           # غير من debug إلى error
   ```
3. احفظ الملف

#### **الطريقة 2: إنشاء ملف جديد**

#### عبر Webuzo File Manager:
1. في File Manager، أنشئ ملف جديد باسم `.env`
2. انسخ المحتوى التالي:

```env
APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:eTVtaWVpZmdqbm40czU5NXB3YXQ0cGk3ajZmaTJqZ3k=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://eliyaa.baitpait.space

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=sarfesak_eliyaa
DB_USERNAME=sarfesak_eliyaa
DB_PASSWORD=(!7poSOM68

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=reverb
FILESYSTEM_DISK=local

CACHE_STORE=file
QUEUE_CONNECTION=sync
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

REVERB_APP_ID=481276
REVERB_APP_KEY=8a70sj1ekpiluxp2kqns
REVERB_APP_SECRET=jljtvicenm1rk753bpxr
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

#### أو عبر SSH:
```bash
cd /path/to/project
nano .env
# الصق المحتوى أعلاه
# احفظ الملف (Ctrl+X, ثم Y, ثم Enter)
```

---

> **💡 نصيحة:** إذا رفعت الملف القديم، راجع ملف `ENV_UPDATE_INSTRUCTIONS.md` لمعرفة التعديلات المطلوبة.

---

### **الخطوة 5: تثبيت Dependencies**

#### عبر SSH:
```bash
cd /path/to/project

# تثبيت Composer Dependencies
composer install --no-dev --optimize-autoloader

# تثبيت NPM Dependencies (إذا لزم الأمر)
npm install

# بناء Assets (إذا لزم الأمر)
npm run build
# أو
npm run production
```

---

### **الخطوة 6: إعداد الصلاحيات**

```bash
cd /path/to/project

# إعطاء صلاحيات للمجلدات
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

# حماية ملف .env
chmod 600 .env
```

---

### **الخطوة 7: توليد Key و Cache**

```bash
cd /path/to/project

# توليد Application Key (إذا لزم الأمر)
php artisan key:generate

# مسح Cache القديم
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# إنشاء Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### **الخطوة 8: التحقق من قاعدة البيانات**

#### عبر phpMyAdmin (Webuzo):
1. سجل الدخول إلى Webuzo
2. اذهب إلى **phpMyAdmin**
3. تأكد من وجود قاعدة البيانات `sarfesak_eliyaa`
4. تأكد من أن جميع الجداول موجودة

#### عبر SSH:
```bash
# اختبار الاتصال بقاعدة البيانات
php artisan tinker
# ثم اكتب:
DB::connection()->getPdo();
# إذا ظهرت رسالة نجاح، الاتصال يعمل
```

---

### **الخطوة 9: إعداد Web Server**

#### عبر Webuzo:
1. سجل الدخول إلى Webuzo
2. اذهب إلى **Apache Settings** أو **Nginx Settings**
3. تأكد من أن Document Root يشير إلى مجلد `public` في Laravel
4. مثال: `/home/username/public_html/your-project-name/public`

#### عبر SSH (إذا لزم الأمر):
```bash
# للتحقق من إعدادات Apache
cat /etc/apache2/sites-available/eliyaa.baitpait.space.conf

# إعادة تشغيل Apache
sudo systemctl restart apache2
# أو
sudo service apache2 restart
```

---

## ✅ **قائمة التحقق النهائية:**

- [ ] تم رفع ملف ZIP واستخراجه
- [ ] تم إنشاء ملف `.env` على السيرفر
- [ ] تم تثبيت Composer Dependencies (`composer install`)
- [ ] تم تثبيت NPM Dependencies (`npm install`)
- [ ] تم بناء Assets (`npm run build`)
- [ ] تم إعطاء الصلاحيات الصحيحة
- [ ] تم توليد Application Key
- [ ] تم مسح Cache
- [ ] تم إنشاء Cache
- [ ] تم التحقق من قاعدة البيانات
- [ ] تم إعداد Web Server
- [ ] تم اختبار الموقع

---

## 🧪 **اختبار الموقع:**

بعد الرفع، اختبر الصفحات التالية:

1. **الصفحة الرئيسية:**
   - URL: `https://eliyaa.baitpait.space/`
   - ✅ يجب أن تظهر الصفحة الرئيسية

2. **لوحة التحكم:**
   - URL: `https://eliyaa.baitpait.space/admin`
   - ✅ يجب أن تظهر صفحة تسجيل الدخول

3. **API:**
   - URL: `https://eliyaa.baitpait.space/api/cities`
   - ✅ يجب أن يعمل API

4. **قائمة التسليم:**
   - URL: `https://eliyaa.baitpait.space/admin/delivery-list`
   - ✅ يجب أن يظهر النص العربي

5. **القائمة الجانبية:**
   - ✅ يجب أن يظهر الشعار في الأعلى

---

## 🆘 **حل المشاكل:**

### المشكلة: الصفحة تظهر بيضاء
```bash
# تحقق من Logs
tail -f storage/logs/laravel.log

# مسح Cache
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

### المشكلة: خطأ في الصلاحيات
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### المشكلة: خطأ في قاعدة البيانات
```bash
# تحقق من ملف .env
cat .env | grep DB_

# اختبار الاتصال
php artisan tinker
DB::connection()->getPdo();
```

### المشكلة: CSS/JS لا يظهر
```bash
# إعادة بناء Assets
npm run build

# مسح View Cache
php artisan view:clear
```

---

## 📝 **ملاحظات مهمة:**

1. **ملف .env:**
   - ✅ تم تغيير `APP_ENV=production` (بدلاً من local)
   - ✅ تم تغيير `APP_DEBUG=false` (للسيرفر)
   - ✅ تم تغيير `LOG_LEVEL=error` (بدلاً من debug)

2. **Composer:**
   - استخدم `--no-dev` لتثبيت Dependencies الإنتاج فقط
   - استخدم `--optimize-autoloader` لتحسين الأداء

3. **NPM:**
   - استخدم `npm run production` لبناء Assets للإنتاج

4. **Cache:**
   - بعد الرفع، يجب دائماً مسح Cache وإعادة إنشائه

---

## 🚀 **خطوات سريعة (Quick Steps):**

```bash
# 1. على جهازك - إنشاء ZIP
cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/water Aelea/eliyaa file/eliyaa"
zip -r eliyaa-full-deployment.zip . -x "node_modules/*" -x "vendor/*" -x ".git/*" -x ".env" -x "storage/logs/*.log" -x "storage/framework/cache/*" -x "*.zip"

# 2. رفع ZIP عبر Webuzo File Manager

# 3. على السيرفر - استخراج
cd /path/to/project
unzip -o eliyaa-full-deployment.zip

# 4. على السيرفر - إنشاء .env
nano .env
# الصق محتوى .env

# 5. على السيرفر - تثبيت Dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 6. على السيرفر - الصلاحيات
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod 600 .env

# 7. على السيرفر - Cache
php artisan key:generate
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

**تم إنشاء هذا الدليل:** 31 ديسمبر 2024
**آخر تحديث:** بعد طلب رفع المشروع الكامل

