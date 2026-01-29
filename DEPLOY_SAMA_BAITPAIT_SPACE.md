# رفع نظام مياه سما على السيرفر
## Sama Water — Deployment to sama.baitpait.space

**الدومين:** https://sama.baitpait.space  
**المسار العام (Document Root):** `/home/sarfesak/public_html/sama/public`  
**جذر المشروع (Laravel root):** `/home/sarfesak/public_html/sama`  
**السيرفر:** VPS Ubuntu + لوحة Webuzo  
**تاريخ الدليل:** 2026-01-29

---

## 1. بيانات السيرفر وقاعدة البيانات

| العنصر | القيمة |
|--------|--------|
| الدومين | sama.baitpait.space |
| مسار التطبيق | /home/sarfesak/public_html/sama |
| مسار الدخول للموقع (Document Root) | /home/sarfesak/public_html/sama/public |
| اسم قاعدة البيانات | sarfesak_sama |
| مستخدم قاعدة البيانات | sarfesak_sama |
| كلمة مرور قاعدة البيانات | (من لوحة التحكم — لا تُدرج في الملفات داخل المشروع) |
| مستخدم SSH / لوحة Webuzo | sarfesak (أو حسب إعداد الاستضافة) |

**تنبيه أمني:** لا تضف كلمة مرور قاعدة البيانات أو كلمات سر السيرفر داخل ملفات المشروع أو داخل Git. استخدمها فقط عند تعديل `.env` على السيرفر.

---

## 2. التحضير المحلي (على جهازك)

### 2.1 إنشاء أرشفة للرفع (بدون vendor و node_modules و .env)

من جذر المشروع:

```bash
cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/Sama Water"
chmod +x deploy-sama.sh
./deploy-sama.sh
```

أو يدوياً:

```bash
cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/Sama Water"
zip -r sama-deployment.zip . \
  -x "node_modules/*" \
  -x "vendor/*" \
  -x ".git/*" \
  -x ".env" \
  -x "storage/logs/*" \
  -x "storage/framework/cache/*" \
  -x "storage/framework/sessions/*" \
  -x "storage/framework/views/*" \
  -x "*.zip" \
  -x ".DS_Store" \
  -x "*.log"
```

النتيجة: ملف `sama-deployment.zip` في نفس المجلد.

### 2.2 (اختياري) نسخ قالب .env للإنتاج

الملف `env.sama.production.example` يحتوي قالباً لـ `.env` على السيرفر. انسخه إلى جهازك أو افتحه وانسخ المحتوى لإنشاء `.env` على السيرفر بعد الرفع.

---

## 3. رفع الملفات إلى السيرفر

### الطريقة أ: عبر لوحة Webuzo (File Manager)

1. الدخول إلى لوحة Webuzo (عادة: `https://sama.baitpait.space:2443` أو عنوان السيرفر + المنفذ 2443).
2. فتح **File Manager** والانتقال إلى `/home/sarfesak/public_html/`.
3. إنشاء مجلد `sama` إن لم يكن موجوداً.
4. رفع ملف `sama-deployment.zip` داخل `sama`.
5. استخراج المحتويات داخل مجلد `sama` (Unzip/Extract) بحيث يصبح `artisan` و `composer.json` داخل `/home/sarfesak/public_html/sama/`.

### الطريقة ب: عبر SCP من جهازك

```bash
scp sama-deployment.zip sarfesak@<عنوان-السيرفر-أو-الدومين>:/home/sarfesak/public_html/
```

ثم عبر SSH على السيرفر:

```bash
cd /home/sarfesak/public_html/
mkdir -p sama
cd sama
unzip -o ../sama-deployment.zip
```

---

## 4. على السيرفر — إعداد التطبيق

تنفذ الأوامر التالية عبر **SSH** أو **Terminal** داخل Webuzo (إن وُجد).

### 4.1 الدخول لمجلد المشروع

```bash
cd /home/sarfesak/public_html/sama
```

### 4.2 إنشاء ملف .env

```bash
cp .env.example .env
# أو إذا أرفقت قالب الإنتاج:
# cp env.sama.production.example .env
nano .env
```

تعديل القيم التالية في `.env`:

```env
APP_NAME="Sama Water"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sama.baitpait.space

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sarfesak_sama
DB_USERNAME=sarfesak_sama
DB_PASSWORD=كلمة_مرور_قاعدة_البيانات_من_لوحة_التحكم
```

احفظ الملف (في nano: Ctrl+O ثم Enter ثم Ctrl+X).

### 4.3 تثبيت الاعتماديات

```bash
composer install --no-dev --optimize-autoloader
```

إذا كان المشروع يستخدم Vite/أصول أمامية:

```bash
npm ci
npm run build
```

### 4.4 مفتاح التطبيق والكاش

```bash
php artisan key:generate
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4.5 قاعدة البيانات

تأكد أن قاعدة البيانات `sarfesak_sama` موجودة ومستخدمها له صلاحيات كاملة (عبر phpMyAdmin أو لوحة Webuzo). ثم:

```bash
php artisan migrate --force
```

(اختياري) إذا كان لديك Seeder للمستخدم الافتراضي:

```bash
php artisan db:seed --force
```

### 4.6 الصلاحيات

```bash
chmod -R 775 storage bootstrap/cache
chmod 600 .env
```

إذا كان مستخدم الويب (مثلاً `www-data` أو `sarfesak`):

```bash
# استبدل www-data بالمستخدم الفعلي إن لزم
sudo chown -R www-data:www-data storage bootstrap/cache
```

إن لم يكن لديك sudo، استخدم المستخدم الذي تشغّل به Apache/Nginx (غالباً اسم الحساب مثل `sarfesak`).

### 4.7 ربط التخزين (Storage)

```bash
php artisan storage:link
```

---

## 5. إعداد الويب سيرفر (Document Root)

يجب أن يكون **Document Root** للموقع يشير إلى مجلد `public` فقط:

- **المسار الصحيح:** `/home/sarfesak/public_html/sama/public`

في Webuzo: إعدادات الدومين أو الـ vHost — تعيين Document Root إلى المسار أعلاه.  
بعد أي تعديل: إعادة تحميل أو إعادة تشغيل Nginx/Apache حسب ما تستخدمه اللوحة.

---

## 6. التحقق بعد الرفع

- الصفحة الرئيسية: https://sama.baitpait.space  
- لوحة الإدارة: https://sama.baitpait.space/admin  
- تسجيل الدخول بحساب Admin من الـ Seeder أو الذي أنشأته.

إذا ظهر خطأ 500:

```bash
tail -f /home/sarfesak/public_html/sama/storage/logs/laravel.log
```

وتحقق من:

- صلاحيات `storage` و `bootstrap/cache`
- صحة بيانات قاعدة البيانات في `.env`
- أن Document Root هو `.../sama/public`

---

## 7. قائمة تحقق سريعة

- [ ] رفع `sama-deployment.zip` واستخراجه في `/home/sarfesak/public_html/sama`
- [ ] إنشاء `.env` وتعديل `APP_URL` و `DB_*`
- [ ] تشغيل `composer install --no-dev --optimize-autoloader`
- [ ] تشغيل `npm run build` إن لزم
- [ ] تشغيل `php artisan key:generate` ومسح/بناء الكاش
- [ ] تشغيل `php artisan migrate --force`
- [ ] ضبط صلاحيات `storage` و `bootstrap/cache` و `.env`
- [ ] تعيين Document Root إلى `.../sama/public`
- [ ] اختبار الموقع ولوحة الإدارة

---

**آخر تحديث:** 2026-01-29
