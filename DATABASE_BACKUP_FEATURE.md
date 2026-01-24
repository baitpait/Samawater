# ✅ زر النسخ الاحتياطي في القائمة

## ما تم إضافته:

### 1️⃣ Controller جديد
**الملف:** `app/Http/Controllers/Admin/DatabaseBackupController.php`

**الوظائف:**
- ✅ إنشاء نسخة احتياطية كاملة من قاعدة البيانات
- ✅ تحميل الملف مباشرة على جهاز المستخدم
- ✅ حذف تلقائي للنسخ القديمة (أقدم من 7 أيام)
- ✅ طريقتان للنسخ الاحتياطي:
  - **الطريقة الأولى:** استخدام `mysqldump` (الأسرع)
  - **الطريقة البديلة:** استخدام Laravel (تعمل دائماً)

**اسم الملف المُحمَّل:**
```
eliyaa_backup_2024-12-31_15-30-45.sql
```

---

### 2️⃣ Route جديد
**الملف:** `routes/web.php`

**الإضافة:**
```php
Route::get('admin/backup/download', [App\Http\Controllers\Admin\DatabaseBackupController::class, 'download'])
    ->middleware(['web', 'admin'])
    ->name('backup.download');
```

**الحماية:**
- ✅ `middleware(['web', 'admin'])` - للمسؤولين فقط
- ✅ يتطلب تسجيل الدخول

---

### 3️⃣ زر في القائمة الجانبية
**الملف:** `resources/views/vendor/backpack/ui/inc/menu_items.blade.php`

**الموقع:** بعد "المدن" وقبل "الدعم الفني"

**التصميم:**
```
📦 نسخة احتياطية
```

**الأيقونة:** `la-download` (سهم تحميل)

---

## 🎯 كيف يعمل؟

### الخطوات:
1. المستخدم يضغط على **"نسخة احتياطية"** في القائمة
2. تظهر رسالة تأكيد
3. إذا وافق، يبدأ النظام في:
   - إنشاء ملف SQL يحتوي على **جميع** الجداول والبيانات
   - ضغط البيانات (إذا أمكن)
   - تحميل الملف على جهاز المستخدم
4. يُحفظ الملف في مجلد التنزيلات بصيغة:
   ```
   eliyaa_backup_2024-12-31_15-30-45.sql
   ```

---

## 📦 ما يتم نسخه احتياطياً؟

### جميع الجداول:
- ✅ `clients` - العملاء
- ✅ `delivery` - التسليمات
- ✅ `distributors` - الموزعين
- ✅ `cities` - المدن
- ✅ `users` - المستخدمين
- ✅ `subscription_types` - أنواع الاشتراكات
- ✅ `subscription_statuses` - حالات الاشتراك
- ✅ `client_statuses` - حالات العميل
- ✅ `client_types` - أنواع العميل
- ✅ `cash_withdraws` - عمليات السحب
- ✅ `distributor_balances` - أرصدة الموزعين
- ✅ جميع الجداول الأخرى

### البيانات المُصدَّرة:
- ✅ بنية الجداول (CREATE TABLE)
- ✅ جميع السجلات (INSERT INTO)
- ✅ المفاتيح الأساسية والأجنبية
- ✅ الفهارس (Indexes)

---

## 🔒 الأمان:

### الحماية المُطبقة:
1. ✅ **Middleware Admin:** للمسؤولين فقط
2. ✅ **Confirmation:** رسالة تأكيد قبل التحميل
3. ✅ **Temporary File:** الملف يُحذف بعد التحميل
4. ✅ **Auto Cleanup:** حذف النسخ القديمة (أقدم من 7 أيام)

---

## ⚙️ الإعدادات:

### مكان حفظ النسخ مؤقتاً:
```
storage/app/backups/
```

### مدة الاحتفاظ بالنسخ:
**7 أيام** (يمكن تغييرها في الكود)

### حجم الملف المتوقع:
- قاعدة بيانات صغيرة (1000 عميل): ~2-5 MB
- قاعدة بيانات متوسطة (10000 عميل): ~20-50 MB
- قاعدة بيانات كبيرة (100000 عميل): ~200-500 MB

---

## 🧪 اختبار الزر:

### على localhost:
1. شغّل السيرفر: `php artisan serve`
2. افتح: http://127.0.0.1:8000/admin
3. انظر في القائمة الجانبية
4. اضغط على **"نسخة احتياطية"**
5. يجب أن يُحمَّل ملف `.sql`

### على السيرفر:
1. ارفع الملفات الثلاثة
2. امسح الكاش: `php artisan route:clear && php artisan cache:clear`
3. اضغط على الزر
4. يجب أن يُحمَّل الملف

---

## 📋 الملفات المعدلة/المضافة:

```
✅ 1. app/Http/Controllers/Admin/DatabaseBackupController.php (جديد)
✅ 2. routes/web.php (تعديل)
✅ 3. resources/views/vendor/backpack/ui/inc/menu_items.blade.php (تعديل)
```

---

## 🚀 خطوات الرفع على السيرفر:

### 1️⃣ ارفع الملفات:
```bash
app/Http/Controllers/Admin/DatabaseBackupController.php
→ /home/sarfesak/public_html/eliyaa/app/Http/Controllers/Admin/DatabaseBackupController.php

routes/web.php
→ /home/sarfesak/public_html/eliyaa/routes/web.php

resources/views/vendor/backpack/ui/inc/menu_items.blade.php
→ /home/sarfesak/public_html/eliyaa/resources/views/vendor/backpack/ui/inc/menu_items.blade.php
```

### 2️⃣ إنشاء مجلد backups:
```bash
cd /home/sarfesak/public_html/eliyaa
mkdir -p storage/app/backups
chmod 775 storage/app/backups
chown sarfesak:sarfesak storage/app/backups
```

### 3️⃣ مسح الكاش:
```bash
php artisan route:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
```

### 4️⃣ اختبر:
اضغط على زر "نسخة احتياطية" في القائمة!

---

## ⚠️ ملاحظات مهمة:

### على السيرفر المشترك:
إذا كان `mysqldump` غير متاح، النظام سيستخدم تلقائياً **الطريقة البديلة** (Laravel).

### الطريقة البديلة:
- أبطأ قليلاً
- لكن **تعمل دائماً**
- تستخدم Laravel للوصول لقاعدة البيانات

### إذا فشل التحميل:
تحقق من:
```bash
# الأذونات
ls -la storage/app/backups

# يجب أن تكون:
drwxrwxr-x sarfesak sarfesak
```

---

## 🎉 الفوائد:

1. ✅ **نسخ احتياطي فوري** بضغطة زر واحدة
2. ✅ **بدون خادم خارجي** - كل شيء داخل النظام
3. ✅ **آمن** - للمسؤولين فقط
4. ✅ **تلقائي** - يحذف النسخ القديمة تلقائياً
5. ✅ **سهل** - لا يحتاج معرفة تقنية

---

## 🔄 استعادة النسخة الاحتياطية:

### إذا احتجت لاستعادة البيانات:

```bash
# 1. ارفع ملف SQL على السيرفر
# 2. نفذ:
mysql -u sarfesak_eliyaa -p sarfesak_eliyaa < eliyaa_backup_2024-12-31.sql

# أو من phpMyAdmin:
# Import → اختر الملف → Go
```

---

**تاريخ الإضافة:** 31 ديسمبر 2024  
**الحالة:** ✅ جاهز للاختبار!

