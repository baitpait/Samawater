# دليل رفع النظام على السيرفر

## ✅ السيرفر المحلي يعمل الآن

- **الرابط المحلي:** http://localhost:8000
- **الرابط العام:** http://0.0.0.0:8000
- **الحالة:** ✅ يعمل بشكل صحيح

---

## 📤 خطوات رفع النظام على السيرفر

### 1. إعداد قاعدة البيانات على السيرفر

#### أ) استيراد قاعدة البيانات:

```bash
# عبر phpMyAdmin:
# 1. افتح phpMyAdmin
# 2. أنشئ قاعدة بيانات: sarfesak_eliyaa
# 3. استورد ملف: database_eliyaa.sql

# أو عبر SSH:
mysql -u username -p sarfesak_eliyaa < database_eliyaa.sql
```

#### ب) التحقق من قاعدة البيانات:
- تأكد من وجود جميع الجداول
- تأكد من وجود البيانات الأساسية (مدن، أنواع اشتراكات، إلخ)

---

### 2. رفع الملفات على السيرفر

#### أ) رفع الملفات عبر FTP/SFTP:

**ملفات يجب رفعها:**
```
✅ app/
✅ bootstrap/
✅ config/
✅ database/ (migrations فقط، ليس database.sqlite)
✅ public/
✅ resources/
✅ routes/
✅ storage/ (تأكد من الصلاحيات)
✅ vendor/ (أو قم بتشغيل composer install على السيرفر)
✅ artisan
✅ composer.json
✅ composer.lock
✅ package.json
✅ vite.config.js
✅ tailwind.config.js
✅ postcss.config.js
```

**ملفات لا يجب رفعها:**
```
❌ .env (سيتم إنشاؤه على السيرفر)
❌ .git/
❌ node_modules/
❌ storage/logs/*.log
❌ storage/framework/cache/*
❌ storage/framework/sessions/*
❌ storage/framework/views/*
```

#### ب) أو استخدام Git:

```bash
# على السيرفر:
git clone your-repository-url
cd eliyaa
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

---

### 3. إعداد ملف .env على السيرفر

أنشئ ملف `.env` على السيرفر مع الإعدادات التالية:

```env
APP_NAME="Eliyaa Water Distribution"
APP_ENV=production
APP_KEY=base64:eTVtaWVpZmdqbm40czU5NXB3YXQ0cGk3ajZmaTJqZ3k=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://your-domain.com

APP_LOCALE=ar
APP_FALLBACK_LOCALE=ar

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=sarfesak_eliyaa
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
QUEUE_CONNECTION=sync

FILESYSTEM_DISK=local

# Reverb (للإشعارات الفورية)
REVERB_APP_ID=481276
REVERB_APP_KEY=8a70sj1ekpiluxp2kqns
REVERB_APP_SECRET=jljtvicenm1rk753bpxr
REVERB_HOST=your-domain.com
REVERB_PORT=8080
REVERB_SCHEME=https

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

**ملاحظات مهمة:**
- ✅ غيّر `APP_DEBUG=false` في الإنتاج
- ✅ غيّر `APP_URL` إلى رابط السيرفر الفعلي
- ✅ غيّر بيانات قاعدة البيانات
- ✅ أنشئ `APP_KEY` جديد: `php artisan key:generate`

---

### 4. إعداد الصلاحيات (Permissions)

```bash
# على السيرفر:
cd /path/to/eliyaa

# إعطاء صلاحيات الكتابة للمجلدات المطلوبة
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# أو
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

### 5. تشغيل الأوامر على السيرفر

```bash
cd /path/to/eliyaa

# تثبيت المكتبات
composer install --no-dev --optimize-autoloader

# بناء Assets
npm install
npm run build

# تنظيف الكاش
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# تحسين الأداء
php artisan config:cache
php artisan route:cache
php artisan view:cache

# إنشاء مفتاح التطبيق (إذا لم يكن موجوداً)
php artisan key:generate
```

---

### 6. إعداد Web Server

#### Apache (.htaccess موجود في public/)

تأكد من أن `DocumentRoot` يشير إلى مجلد `public/`:

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /path/to/eliyaa/public
    
    <Directory /path/to/eliyaa/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/eliyaa/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

### 7. إعداد SSL (HTTPS)

```bash
# استخدام Let's Encrypt
sudo certbot --nginx -d your-domain.com
# أو
sudo certbot --apache -d your-domain.com
```

---

### 8. التحقق من الإعداد

#### أ) تحقق من الملفات:
- ✅ ملف `.env` موجود وصحيح
- ✅ صلاحيات `storage/` و `bootstrap/cache/` صحيحة
- ✅ قاعدة البيانات متصلة

#### ب) تحقق من الروابط:
- ✅ الصفحة الرئيسية: `https://your-domain.com`
- ✅ لوحة التحكم: `https://your-domain.com/admin`
- ✅ API: `https://your-domain.com/api/cities`

#### ج) تحقق من الأخطاء:
```bash
# عرض آخر الأخطاء
tail -f storage/logs/laravel.log
```

---

### 9. إعداد Cron Jobs (مهم جداً)

أضف هذا السطر في `crontab`:

```bash
* * * * * cd /path/to/eliyaa && php artisan schedule:run >> /dev/null 2>&1
```

أو:

```bash
crontab -e
# أضف:
* * * * * /usr/bin/php /path/to/eliyaa/artisan schedule:run >> /dev/null 2>&1
```

---

### 10. إعداد Queue Worker (إذا كنت تستخدم Queues)

```bash
# إنشاء systemd service
sudo nano /etc/systemd/system/eliyaa-queue.service
```

```ini
[Unit]
Description=Eliyaa Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /path/to/eliyaa/artisan queue:work --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

```bash
sudo systemctl enable eliyaa-queue
sudo systemctl start eliyaa-queue
```

---

## 🔧 استكشاف الأخطاء

### مشكلة: "500 Internal Server Error"
```bash
# تحقق من الصلاحيات
chmod -R 775 storage bootstrap/cache

# تحقق من الأخطاء
tail -f storage/logs/laravel.log

# تحقق من .env
php artisan config:clear
```

### مشكلة: "Database connection failed"
- تحقق من بيانات قاعدة البيانات في `.env`
- تحقق من أن قاعدة البيانات موجودة
- تحقق من صلاحيات المستخدم

### مشكلة: "Class not found"
```bash
composer dump-autoload
php artisan optimize:clear
```

---

## 📱 API Endpoints بعد الرفع

بعد الرفع، ستكون الروابط:

- **Base URL:** `https://your-domain.com`
- **API Base:** `https://your-domain.com/api`
- **Admin Panel:** `https://your-domain.com/admin`

### أمثلة:
- `GET https://your-domain.com/api/cities`
- `POST https://your-domain.com/api/distributor/login`
- `GET https://your-domain.com/api/allclient`

---

## ✅ قائمة التحقق النهائية

- [ ] قاعدة البيانات مستوردة
- [ ] ملف `.env` معد بشكل صحيح
- [ ] الصلاحيات صحيحة
- [ ] `composer install` تم بنجاح
- [ ] `npm run build` تم بنجاح
- [ ] الكاش تم تنظيفه
- [ ] Web Server معد بشكل صحيح
- [ ] SSL مفعل (HTTPS)
- [ ] Cron Jobs معد
- [ ] النظام يعمل بشكل صحيح

---

## 🎉 جاهز للاستخدام!

بعد إكمال جميع الخطوات، النظام جاهز للاستخدام على السيرفر.

**لوحة التحكم:** `https://your-domain.com/admin`
**API:** `https://your-domain.com/api`

---

## 📞 الدعم

إذا واجهت أي مشاكل، تحقق من:
1. ملف `storage/logs/laravel.log`
2. صلاحيات الملفات
3. إعدادات قاعدة البيانات
4. إعدادات Web Server

