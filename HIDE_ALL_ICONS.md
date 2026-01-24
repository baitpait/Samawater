# ✅ إخفاء جميع الأيقونات (Logo و Avatar)

## الطلب:
إخفاء جميع الأيقونات من الـ Header (الشعار وصورة المستخدم) تماماً، محلياً وعلى السيرفر.

---

## التعديلات المطبقة:

### 1️⃣ إخفاء Logo (الشعار) من Navbar
**الملف:** `config/backpack/ui.php`  
**السطر:** 66

**التعديل:**
```php
'project_logo' => false,  // تم إخفاء الشعار
```

**النتيجة:**
- ❌ لن يظهر الشعار في الـ Header
- ✅ سيبقى اسم المشروع فقط (إذا كان محدداً)

---

### 2️⃣ إخفاء Avatar (صورة المستخدم) من Navbar
**الملف:** `resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php`

**قبل:**
```php
<img class="img-avatar" src="{{ backpack_avatar_url(backpack_auth()->user()) }}" ...>
<span class="backpack-avatar-menu-container" ...>
  {{backpack_user()->getAttribute('name') ? mb_substr(backpack_user()->name, 0, 1, 'UTF-8') : 'A'}}
</span>
```

**بعد:**
```php
{{-- لا يوجد avatar --}}
<span style="color: #333; font-weight: 500; font-size: 14px;">
  {{ backpack_user()->name }}
</span>
<i class="la la-angle-down"></i>
```

**النتيجة:**
- ❌ لن تظهر الصورة الدائرية (Avatar)
- ❌ لن يظهر الحرف الأول
- ✅ سيظهر اسم المستخدم كاملاً + سهم للأسفل

---

### 3️⃣ تعطيل Gravatar تماماً
**الملف:** `config/backpack/base.php`  
**السطر:** 147

**التعديل:**
```php
'avatar_type' => null,  // لا يوجد avatar
```

**النتيجة:**
- ❌ لن يتم تحميل صور من Gravatar
- ❌ لن يتم استخدام Basset لحفظ الصور

---

## الملفات المعدلة للرفع:

```
✅ config/backpack/ui.php
✅ config/backpack/base.php
✅ resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php
```

---

## خطوات التطبيق على السيرفر:

### 1️⃣ ارفع الملفات الثلاثة:
```bash
config/backpack/ui.php
→ /home/sarfesak/public_html/eliyaa/config/backpack/ui.php

config/backpack/base.php
→ /home/sarfesak/public_html/eliyaa/config/backpack/base.php

resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php
→ /home/sarfesak/public_html/eliyaa/resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php
```

### 2️⃣ تأكد من وجود المجلد:
```bash
mkdir -p /home/sarfesak/public_html/eliyaa/resources/views/vendor/backpack/theme-coreuiv2/inc
```

### 3️⃣ امسح الكاش:
```bash
cd /home/sarfesak/public_html/eliyaa

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan view:cache
```

### 4️⃣ حدّث الصفحة:
- افتح: https://eliyaa.baitpait.space
- اضغط `Ctrl+Shift+R`

---

## النتيجة المتوقعة:

### Header (الشريط العلوي):
```
┌─────────────────────────────────────────────────┐
│  [لا شعار]     اسم المشروع     admin ▼          │
└─────────────────────────────────────────────────┘
```

- ❌ **لا يوجد Logo/شعار** في الـ Navbar
- ❌ **لا توجد صورة دائرية** للمستخدم
- ✅ **يظهر اسم المستخدم فقط** (مثل: "admin") مع سهم للأسفل
- ✅ **القائمة المنسدلة تعمل** (حسابي / تسجيل الخروج)

---

## ملاحظات مهمة:

### 1️⃣ الملف في مجلد vendor
الملف `menu_user_dropdown.blade.php` موجود في:
```
resources/views/vendor/backpack/theme-coreuiv2/inc/
```

هذا المجلد يُستخدم **لتخصيص** ملفات Backpack.  
Laravel ستبحث في `resources/views/vendor/` **قبل** `vendor/backpack/`.

### 2️⃣ إذا لم يتم إنشاء المجلد
يجب إنشاء المجلد يدوياً:
```bash
mkdir -p resources/views/vendor/backpack/theme-coreuiv2/inc
```

### 3️⃣ composer update لن يحذف الملف
لأن الملف في `resources/views/vendor/` وليس `vendor/backpack/`.  
حتى لو نفذت `composer update`، الملف سيبقى.

---

## أوامر سريعة للنسخ واللصق:

```bash
cd /home/sarfesak/public_html/eliyaa

# إنشاء المجلد إذا لم يكن موجوداً
mkdir -p resources/views/vendor/backpack/theme-coreuiv2/inc

# مسح الكاش
php artisan config:clear && php artisan cache:clear && php artisan view:clear

# إعادة بناء الكاش
php artisan config:cache && php artisan view:cache

echo "✅ تم إخفاء جميع الأيقونات"
```

---

## إذا أردت إرجاع الأيقونات لاحقاً:

### لإرجاع Logo:
```php
// في config/backpack/ui.php السطر 66
'project_logo' => '<img src="' . asset('logo/Logo-2.png') . '" style="width: 80px;">',
```

### لإرجاع Avatar:
```bash
# احذف الملف المخصص
rm resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php

# امسح الكاش
php artisan view:clear
```

---

**تاريخ الإصلاح:** 31 ديسمبر 2024

