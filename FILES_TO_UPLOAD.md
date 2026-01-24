# 📤 الملفات التي يجب رفعها على السيرفر

## ✅ الملفات المعدلة فقط (يجب رفعها):

### 1. ملفات Views (المعدلة):
```
✅ resources/views/admin/client_report_page.blade.php
   - تم إضافة ميزة التعديل على التوصيلات (Modal مع JavaScript)
   - تم إضافة عرض عمود الدفع في الجدول (الحقل موجود في قاعدة البيانات لكن لم يكن يظهر)
   - تم تغيير "الفرق" إلى "رصيد القوارير"
   - تم إضافة زر تعديل لكل صف في الجدول
   - تم تغيير "⚖️ الرصيد المتبقي" إلى "رصيد القوارير" في بطاقة الإحصائيات
```

### 2. ملف قاعدة البيانات (إذا لم تكن مستوردة بعد):
```
✅ database_eliyaa.sql
   - تم إصلاح 3 أخطاء في Views:
     * dist.name``name → dist.name
     * st.distribution_days``distribution_days → st.distribution_days
     * قوس إضافي في v_distributor_balance
```

---

## ❌ الملفات التي لا يجب رفعها:

```
❌ .env (سيتم إنشاؤه على السيرفر)
❌ .git/
❌ node_modules/
❌ storage/logs/*.log
❌ storage/framework/cache/*
❌ storage/framework/sessions/*
❌ storage/framework/views/*
❌ vendor/ (يمكن تثبيته على السيرفر)
❌ cache/
❌ الملفات التوثيقية (*.md) - اختياري
```

---

## 🚀 الطريقة الموصى بها:

### الطريقة 1: رفع الملفات المعدلة فقط (الأسرع)

```bash
# الملفات التي تم تعديلها:
resources/views/admin/client_report_page.blade.php
database_eliyaa.sql (إذا لم تكن مستوردة)
```

### الطريقة 2: رفع مجلد resources بالكامل (أكثر أماناً)

```bash
# رفع مجلد resources/ بالكامل
resources/
```

---

## 📋 خطوات الرفع السريع:

### 1. رفع الملف المعدل:
```
resources/views/admin/client_report_page.blade.php
```

### 2. على السيرفر، قم بتشغيل:
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

### 3. إذا لم تكن قاعدة البيانات مستوردة:
```
رفع: database_eliyaa.sql
ثم استيرادها على السيرفر
```

---

## ✅ ملخص:

**الحد الأدنى المطلوب:**
- ✅ `resources/views/admin/client_report_page.blade.php` (الملف المعدل)

**اختياري:**
- ✅ `database_eliyaa.sql` (إذا لم تكن قاعدة البيانات مستوردة)

**بعد الرفع:**
```bash
php artisan view:clear
php artisan cache:clear
```

---

## 🎯 الخلاصة:

**لا حاجة لرفع كل الملفات!**

فقط ارفع:
1. ✅ `resources/views/admin/client_report_page.blade.php`
2. ✅ `database_eliyaa.sql` (إذا لزم الأمر)

ثم قم بتشغيل أوامر تنظيف الكاش على السيرفر.

