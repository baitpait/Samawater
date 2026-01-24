# ✅ إصلاح خط القائمة الجانبية - خط Cairo

## المشكلة:
القائمة الجانبية لا تستخدم خط Cairo العربي، بل تستخدم الخط الافتراضي.

## السبب:
ملف `vendor/backpack/theme-coreuiv2/resources/views/inc/sidebar.blade.php` يحتوي على CSS الخاص به الذي يتجاوز CSS الخاص بنا في `public/css/unified-forms.css`.

## الحل:
إنشاء ملف مخصص في `resources/views/vendor/backpack/theme-coreuiv2/inc/sidebar.blade.php` ليحل محل الملف الأصلي.

---

## الملفات المُنشأة/المُعدلة:

### ✅ `resources/views/vendor/backpack/theme-coreuiv2/inc/sidebar.blade.php` (جديد)
**الملف الكامل:** نسخة مخصصة من sidebar.blade.php مع خط Cairo

**المميزات:**
- ✅ `font-family: 'Cairo'` في جميع عناصر الـ sidebar
- ✅ نفس التصميم الأصلي
- ✅ جميع التأثيرات والألوان محفوظة

---

## خطوات التطبيق على السيرفر:

### 1️⃣ ارفع الملف الجديد:
```
resources/views/vendor/backpack/theme-coreuiv2/inc/sidebar.blade.php
→ /home/sarfesak/public_html/eliyaa/resources/views/vendor/backpack/theme-coreuiv2/inc/sidebar.blade.php
```

### 2️⃣ تأكد من إنشاء المجلد:
```bash
mkdir -p /home/sarfesak/public_html/eliyaa/resources/views/vendor/backpack/theme-coreuiv2/inc
```

### 3️⃣ إصلاح الأذونات:
```bash
chmod 644 /home/sarfesak/public_html/eliyaa/resources/views/vendor/backpack/theme-coreuiv2/inc/sidebar.blade.php
chown sarfesak:sarfesak /home/sarfesak/public_html/eliyaa/resources/views/vendor/backpack/theme-coreuiv2/inc/sidebar.blade.php
```

### 4️⃣ مسح الكاش:
```bash
cd /home/sarfesak/public_html/eliyaa
php artisan view:clear
php artisan cache:clear
```

### 5️⃣ اختبار التطبيق:
1. افتح: https://eliyaa.baitpait.space/admin
2. اضغط `Ctrl+Shift+R`
3. تحقق من خط القائمة - يجب أن يكون **Cairo**

---

## كيف يعمل الحل:

### Laravel View Override:
```php
// Laravel يبحث عن الملفات بالترتيب التالي:
1. resources/views/vendor/backpack/theme-coreuiv2/inc/sidebar.blade.php ✅ (موجود الآن)
2. vendor/backpack/theme-coreuiv2/resources/views/inc/sidebar.blade.php ❌ (يتجاهل)
```

### النتيجة:
- ✅ الملف المخصص يحل محل الملف الأصلي
- ✅ CSS الأصلي + خط Cairo العربي
- ✅ لا يؤثر على `composer update` (الملف في resources/)

---

## التحقق من النجاح:

### في المتصفح (Developer Tools):

**افتح:** `F12` → `Elements` → ابحث عن:
```css
.sidebar .nav .nav-link
```

**يجب أن ترى:**
```css
font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
```

### في الشكل البصري:
- ✅ "الرئيسية" بخط Cairo
- ✅ "إضافة تسليم" بخط Cairo
- ✅ "العملاء" بخط Cairo
- ✅ "نسخة احتياطية" بخط Cairo

---

## إذا لم يعمل:

### 1️⃣ تحقق من رفع الملف:
```bash
ls -la resources/views/vendor/backpack/theme-coreuiv2/inc/sidebar.blade.php
```

### 2️⃣ مسح الكاش مرة أخرى:
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

### 3️⃣ إعادة تحميل الصفحة:
```bash
Ctrl+Shift+R (مهم!)
```

### 4️⃣ فحص Console:
```javascript
// في Console، نفذ:
document.querySelector('.sidebar .nav-link').style.fontFamily
// يجب أن يرجع: "Cairo, Segoe UI, Tahoma, Geneva, Verdana, sans-serif"
```

---

## ملاحظات مهمة:

### ✅ لماذا هذا الحل آمن:
1. **لا يمس** ملفات vendor الأصلية
2. **لا يتأثر** بـ `composer update`
3. **يمكن التراجع** عنه بسهولة (حذف الملف)

### ✅ الفائدة:
- جميع عناصر القائمة تستخدم خط Cairo
- التصميم محفوظ كما هو
- الأداء لا يتأثر

---

## البديل (إذا لم يعمل):

### إضافة CSS قوي في unified-forms.css:
```css
/* في نهاية public/css/unified-forms.css */
.sidebar .nav-link,
.sidebar .nav-link *,
.app-body .sidebar * {
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    font-weight: inherit !important;
}
```

---

**تاريخ الإصلاح:** 31 ديسمبر 2024  
**الحالة:** ✅ جاهز للاختبار

