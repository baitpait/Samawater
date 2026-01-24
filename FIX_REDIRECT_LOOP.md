# 🔧 حل مشكلة ERR_TOO_MANY_REDIRECTS

## المشكلة
```
ERR_TOO_MANY_REDIRECTS
This page isn't working
eliyaa.baitpait.space redirected you too many times.
```

**السبب المحتمل:** 
- إعدادات APP_URL خاطئة (HTTP بدلاً من HTTPS أو العكس)
- مشكلة في Session/Cookie configuration
- حلقة إعادة توجيه في Routes

---

## ✅ الحل السريع

### الخطوة 1: التحقق من APP_URL في ملف .env

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
cat .env | grep APP_URL
```

**يجب أن يكون:**
```
APP_URL=https://eliyaa.baitpait.space
```

**وليس:**
```
APP_URL=http://eliyaa.baitpait.space
```

**إذا كان خاطئاً، عدّله:**
```bash
nano .env
```

**ابحث عن:**
```
APP_URL=http://eliyaa.baitpait.space
```

**غيّره إلى:**
```
APP_URL=https://eliyaa.baitpait.space
```

**احفظ:** `Ctrl+X` ثم `Y` ثم `Enter`

---

### الخطوة 2: إضافة إعدادات HTTPS في ملف .env

**أين:** في Terminal السيرفر

```bash
nano .env
```

**أضف هذه السطور (إذا لم تكن موجودة):**
```env
APP_URL=https://eliyaa.baitpait.space

# Force HTTPS
FORCE_HTTPS=true
```

**أو:**

```env
# Trust Proxies (مهم للسيرفرات خلف Load Balancer)
TRUSTED_PROXIES=*
```

**احفظ:** `Ctrl+X` ثم `Y` ثم `Enter`

---

### الخطوة 3: إصلاح Session Configuration

**أين:** في Terminal السيرفر

```bash
# التحقق من SESSION_DRIVER
cat .env | grep SESSION_DRIVER

# إذا كان database، تأكد من وجود جدول sessions
# إذا كان file، تأكد من الصلاحيات
```

**في ملف .env، تأكد من:**
```env
SESSION_DRIVER=file
SESSION_SECURE_COOKIE=false
```

**أو إذا كان HTTPS يعمل بشكل صحيح:**
```env
SESSION_DRIVER=file
SESSION_SECURE_COOKIE=true
```

---

### الخطوة 4: مسح Cache وإعادة التكوين

**أين:** في Terminal السيرفر

```bash
# مسح جميع أنواع Cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# إعادة إنشاء Cache
php artisan config:cache
php artisan route:cache
```

---

### الخطوة 5: التحقق من Trusted Proxies

**أين:** في Terminal السيرفر

```bash
# التحقق من ملف TrustProxies middleware
cat app/Http/Middleware/TrustProxies.php
```

**يجب أن يحتوي على:**
```php
protected $proxies = '*';
```

---

## 🔍 الحل البديل: إصلاح TrustProxies Middleware

**أين:** في Terminal السيرفر

```bash
nano app/Http/Middleware/TrustProxies.php
```

**تأكد من أن الملف يحتوي على:**
```php
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
```

**احفظ:** `Ctrl+X` ثم `Y` ثم `Enter`

---

## 📝 الأوامر الكاملة (نسخ ولصق)

```bash
# 1. التحقق من APP_URL
cat .env | grep APP_URL

# 2. تعديل .env (إذا لزم الأمر)
nano .env
# تأكد من: APP_URL=https://eliyaa.baitpait.space

# 3. مسح Cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# 4. إعادة إنشاء Cache
php artisan config:cache
php artisan route:cache

# 5. التحقق من TrustProxies
cat app/Http/Middleware/TrustProxies.php | grep proxies
```

---

## ⚠️ إذا استمرت المشكلة

### الحل 1: تعطيل HTTPS مؤقتاً للاختبار

```bash
nano .env
```

**غيّر:**
```
APP_URL=https://eliyaa.baitpait.space
```

**إلى:**
```
APP_URL=http://eliyaa.baitpait.space
```

**ثم:**
```bash
php artisan config:clear
php artisan config:cache
```

**جرب الوصول:** `http://eliyaa.baitpait.space/admin/login`

**إذا عمل، المشكلة في HTTPS configuration.**

---

### الحل 2: التحقق من Route Redirect Loop

```bash
# عرض جميع Routes
php artisan route:list | grep -E "GET|POST" | head -20
```

**تحقق من أن لا يوجد حلقة إعادة توجيه في routes/web.php**

---

### الحل 3: مسح Cookies في المتصفح

1. افتح Developer Tools (F12)
2. اذهب إلى Application/Storage
3. امسح جميع Cookies للموقع
4. جرب تسجيل الدخول مرة أخرى

---

## ✅ قائمة التحقق

- [ ] APP_URL في .env صحيح (https://eliyaa.baitpait.space)
- [ ] تم مسح Cache
- [ ] تم إعادة إنشاء Cache
- [ ] TrustProxies middleware صحيح
- [ ] Session configuration صحيح
- [ ] تم مسح Cookies في المتصفح

---

## 🎯 الحل الأكثر شيوعاً

**في 90% من الحالات، المشكلة في APP_URL:**

```bash
# تأكد من أن APP_URL في .env هو:
APP_URL=https://eliyaa.baitpait.space

# وليس:
APP_URL=http://eliyaa.baitpait.space
```

**ثم:**
```bash
php artisan config:clear
php artisan config:cache
```

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** حل مشكلة ERR_TOO_MANY_REDIRECTS

