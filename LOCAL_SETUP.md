# 🖥️ إعداد النظام للعمل على السيرفر المحلي

## 📋 الوضع الحالي

- ✅ **النظام يعمل حالياً على سيرفر بعيد:** https://eliyaa.baitpait.space
- ✅ **السيرفر المحلي يعمل الآن:** http://localhost:8000
- 🎯 **الهدف:** تطوير وتعديل النظام محلياً ثم رفعه على السيرفر

---

## 🔧 إعداد البيئة المحلية

### 1. قاعدة البيانات المحلية

لديك خياران:

#### الخيار 1: استخدام MySQL/MariaDB محلي

```env
# في ملف .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eliyaa_local
DB_USERNAME=root
DB_PASSWORD=your_local_password
```

**خطوات الإعداد:**
```bash
# 1. إنشاء قاعدة بيانات محلية
mysql -u root -p
CREATE DATABASE eliyaa_local CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
EXIT;

# 2. استيراد البيانات
mysql -u root -p eliyaa_local < database_eliyaa.sql
```

#### الخيار 2: استخدام SQLite (أسهل للتطوير)

```env
# في ملف .env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

**ملاحظة:** SQLite موجود بالفعل في `database/database.sqlite` لكنه فارغ.

---

### 2. تحديث ملف .env للمحلي

أنشئ نسخة محلية من `.env`:

```env
APP_NAME="Eliyaa Local"
APP_ENV=local
APP_KEY=base64:eTVtaWVpZmdqbm40czU5NXB3YXQ0cGk3ajZmaTJqZ3k=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000

APP_LOCALE=ar
APP_FALLBACK_LOCALE=ar

# قاعدة البيانات المحلية
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eliyaa_local
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
QUEUE_CONNECTION=sync

FILESYSTEM_DISK=local

# Reverb (للإشعارات الفورية - محلي)
REVERB_APP_ID=481276
REVERB_APP_KEY=8a70sj1ekpiluxp2kqns
REVERB_APP_SECRET=jljtvicenm1rk753bpxr
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

---

## 🚀 تشغيل النظام محلياً

### الخطوة 1: تنظيف الكاش

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### الخطوة 2: تحديث الإعدادات

```bash
php artisan config:cache
```

### الخطوة 3: تشغيل السيرفر

```bash
# السيرفر يعمل بالفعل على:
php artisan serve --host=0.0.0.0 --port=8000
```

**الروابط:**
- الصفحة الرئيسية: http://localhost:8000
- لوحة التحكم: http://localhost:8000/admin
- API: http://localhost:8000/api

---

## 🔄 سير العمل (Workflow)

### 1. التطوير المحلي
```
السيرفر المحلي (localhost:8000)
    ↓
قاعدة بيانات محلية (eliyaa_local)
    ↓
تعديل الكود
    ↓
اختبار التعديلات
```

### 2. الرفع على السيرفر
```
بعد التأكد من التعديلات
    ↓
رفع الملفات على السيرفر
    ↓
تحديث قاعدة البيانات (إذا لزم الأمر)
    ↓
اختبار على السيرفر
```

---

## 📝 ملاحظات مهمة

### 1. فصل البيئات
- ✅ **محلي:** `.env` مع `APP_ENV=local` و `APP_DEBUG=true`
- ✅ **إنتاج:** `.env` على السيرفر مع `APP_ENV=production` و `APP_DEBUG=false`

### 2. قاعدة البيانات
- **محلي:** `eliyaa_local` (للتطوير)
- **إنتاج:** `sarfesak_eliyaa` (على السيرفر)

### 3. الملفات التي لا يجب رفعها
```
❌ .env
❌ storage/logs/*.log
❌ node_modules/
❌ .git/
```

---

## 🛠️ أوامر مفيدة للتطوير

### عرض الأخطاء:
```bash
tail -f storage/logs/laravel.log
```

### إعادة بناء Assets:
```bash
npm run dev        # للتطوير (مع Hot Reload)
npm run build      # للإنتاج
```

### تشغيل Migrations (إذا أضفت migrations جديدة):
```bash
php artisan migrate
```

### إعادة تعيين قاعدة البيانات (⚠️ احذر: سيحذف البيانات):
```bash
php artisan migrate:fresh --seed
```

---

## ✅ قائمة التحقق

- [ ] قاعدة البيانات المحلية جاهزة
- [ ] ملف `.env` معد للمحلي
- [ ] السيرفر المحلي يعمل
- [ ] يمكن الوصول إلى لوحة التحكم
- [ ] API يعمل بشكل صحيح
- [ ] جاهز للتعديلات

---

## 🎯 الخطوات التالية

1. **الآن:** النظام يعمل محلياً على http://localhost:8000
2. **بعد التعديلات:** راجع `DEPLOYMENT_GUIDE.md` للرفع على السيرفر
3. **على السيرفر:** استخدم `.env` الخاص بالإنتاج

---

## 📞 استكشاف الأخطاء

### مشكلة: "Database connection failed"
```bash
# تحقق من بيانات قاعدة البيانات في .env
# تأكد من أن MySQL يعمل
mysql -u root -p

# تحقق من أن قاعدة البيانات موجودة
SHOW DATABASES;
```

### مشكلة: "500 Internal Server Error"
```bash
# تحقق من الصلاحيات
chmod -R 775 storage bootstrap/cache

# تحقق من الأخطاء
tail -f storage/logs/laravel.log
```

### مشكلة: "Class not found"
```bash
composer dump-autoload
php artisan optimize:clear
```

---

## 🎉 جاهز للتطوير!

النظام الآن جاهز للعمل محلياً. يمكنك:
- ✅ تعديل الكود
- ✅ اختبار التعديلات
- ✅ تطوير ميزات جديدة
- ✅ إصلاح الأخطاء

بعد الانتهاء، ارفع التعديلات على السيرفر باستخدام `DEPLOYMENT_GUIDE.md`.

