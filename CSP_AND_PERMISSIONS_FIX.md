# ✅ إصلاح CSP والصلاحيات لصفحة `/admin/city`

## 🔍 المشاكل المكتشفة

### 1. Content Security Policy (CSP) Error
**الخطأ:**
```
Content Security Policy of your site blocks the use of 'eval' in JavaScript
```

**السبب:**
- CSP يمنع استخدام `eval()` و `new Function()` و `setTimeout([string])`
- DataTables و Backpack CRUD يحتاجان `eval()` للعمل بشكل صحيح
- CSP header موجود في مكان ما (ربما من Nginx أو Laravel)

### 2. صلاحيات المستخدم
**التحقق:**
- ✅ المستخدم `admin@sama.test` لديه role `super_admin`
- ✅ `hasAnyRole(['super_admin', 'admin', 'distributor'])` يرجع `Yes`
- ✅ `CheckIfAdmin` middleware يسمح بالوصول
- ⚠️ **لكن:** الموزعين (`distributor`) **لا يمكنهم** الوصول لصفحة `city` لأنها ليست في `DISTRIBUTOR_ALLOWED_ROUTE_NAMES`

## ✅ الإصلاحات المطبقة

### 1. إنشاء Middleware لإصلاح CSP
**الملف الجديد:** `app/Http/Middleware/DisableCSPForBackpack.php`

**ما يفعله:**
- ✅ يزيل CSP headers القديمة
- ✅ يضيف CSP جديد مع `unsafe-eval` للصفحات الإدارية فقط (`admin/*`)
- ✅ يسمح بتحميل scripts من CDN (للمكتبات الخارجية)
- ✅ يسمح بـ `unsafe-inline` للـ styles (لـ Backpack)

### 2. إضافة Middleware إلى `bootstrap/app.php`
- ✅ تم إضافة `DisableCSPForBackpack` إلى web middleware group

## 📝 إذا كانت المشكلة متعلقة بالصلاحيات

### للموزعين (Distributors):
إذا كان المستخدم الحالي هو **موزع** وليس **أدمن**، يجب إضافة `city` إلى القائمة المسموحة:

**في `app/Http/Middleware/CheckIfAdmin.php`:**
```php
private const DISTRIBUTOR_ALLOWED_ROUTE_NAMES = [
    // ... existing routes ...
    'city.index',        // إضافة
    'city.search',       // إضافة
    'city.show',         // إضافة
];
```

**أو** إضافة prefix:
```php
private const DISTRIBUTOR_ALLOWED_ROUTE_PREFIXES = [
    'delivery.',
    'city.',  // إضافة
];
```

## 🔧 الخطوات التالية

1. **أعد تحميل الصفحة (Ctrl+F5)**
2. **افتح `/admin/city`**
3. **افتح Developer Tools → Console**
4. **تحقق من:**
   - ✅ **لا** يجب أن ترى CSP errors
   - ✅ **يجب** أن ترى البيانات في الجدول (13 مدينة)
   - ✅ **لا** يجب أن ترى `$(...).DataTable is not a function`

5. **افتح Network tab:**
   - تحقق من Response Headers → `Content-Security-Policy`
   - يجب أن يحتوي على `unsafe-eval`

## ⚠️ ملاحظات أمنية

- `unsafe-eval` يقلل من الأمان، لكنه **ضروري** لـ DataTables و Backpack
- تم تطبيقه فقط على الصفحات الإدارية (`admin/*`)
- في الإنتاج، يمكنك تقييد CSP أكثر باستخدام nonces أو hashes

## ✅ الملفات المعدلة

1. ✅ `app/Http/Middleware/DisableCSPForBackpack.php` (جديد)
2. ✅ `bootstrap/app.php` (محسن)
