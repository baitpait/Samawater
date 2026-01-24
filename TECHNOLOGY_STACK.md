# 🛠️ قائمة الأدوات والمنصات المستخدمة في النظام

## 📋 نظرة عامة
نظام توزيع المياه (إيليا) - قائمة شاملة بجميع التقنيات والأدوات المستخدمة

---

## 🎯 **Backend Framework & Core**

### 1. **Laravel Framework**
- **الإصدار:** Laravel 11.31
- **الوصف:** Framework PHP الرئيسي
- **الاستخدام:** Backend API، Admin Panel، Authentication

### 2. **PHP**
- **الإصدار:** PHP 8.2+
- **الوصف:** لغة البرمجة الأساسية

---

## 🎨 **Admin Panel & UI Framework**

### 3. **Backpack for Laravel**
- **الإصدار:** Backpack CRUD 6.8
- **الوصف:** لوحة تحكم إدارية جاهزة
- **المكونات:**
  - `backpack/crud` - إدارة CRUD
  - `backpack/theme-coreuiv2` - Theme CoreUI v2
  - `backpack/theme-tabler` - Theme Tabler
  - `backpack/language-switcher` - تبديل اللغة
  - `backpack/generators` - مولدات الكود (للتنمية)

---

## 🔐 **Authentication & Security**

### 4. **Laravel Sanctum**
- **الإصدار:** 4.2
- **الوصف:** نظام المصادقة للـ API
- **الاستخدام:** Token-based authentication للموزعين

### 5. **Laravel Reverb**
- **الإصدار:** 1.6
- **الوصف:** WebSockets للاتصال الفوري
- **الاستخدام:** الإشعارات الفورية (إن وجدت)

---

## 🗄️ **Database**

### 6. **MySQL / MariaDB**
- **الوصف:** قاعدة البيانات الرئيسية
- **الاستخدام:** تخزين جميع البيانات
- **الترميز:** UTF8MB4 (دعم العربية)

### 7. **SQLite**
- **الوصف:** قاعدة بيانات محلية للتطوير
- **الاستخدام:** التطوير والاختبار المحلي

---

## 📊 **PDF & Document Generation**

### 8. **mPDF**
- **الإصدار:** 8.2
- **الوصف:** مكتبة إنشاء ملفات PDF
- **الاستخدام:** تصدير التقارير بصيغة PDF

### 9. **Laravel DomPDF**
- **الإصدار:** 3.1 (barryvdh/laravel-dompdf)
- **الوصف:** مكتبة أخرى لإنشاء PDF
- **الاستخدام:** تصدير التقارير

---

## 🎨 **Frontend Build Tools**

### 10. **Vite**
- **الإصدار:** 6.0.11
- **الوصف:** Build tool سريع للأصول
- **الاستخدام:** تجميع CSS و JavaScript

### 11. **Laravel Vite Plugin**
- **الإصدار:** 1.2.0
- **الوصف:** تكامل Vite مع Laravel

---

## 🎨 **CSS & Styling**

### 12. **Tailwind CSS**
- **الإصدار:** 3.4.13
- **الوصف:** Utility-first CSS framework
- **الاستخدام:** تصميم الصفحات

### 13. **PostCSS**
- **الإصدار:** 8.4.47
- **الوصف:** معالج CSS
- **الاستخدام:** معالجة Tailwind CSS

### 14. **Autoprefixer**
- **الإصدار:** 10.4.20
- **الوصف:** إضافة prefixes تلقائياً
- **الاستخدام:** دعم المتصفحات

---

## 📚 **JavaScript Libraries**

### 15. **jQuery**
- **الوصف:** مكتبة JavaScript (من Backpack)
- **الاستخدام:** DOM manipulation، AJAX

### 16. **Bootstrap**
- **الإصدار:** 4.6.2 (من Backpack)
- **الوصف:** CSS framework
- **الاستخدام:** Grid system، Components

### 17. **Chart.js**
- **الوصف:** مكتبة الرسوم البيانية
- **الاستخدام:** الرسوم البيانية في Dashboard والتقارير

### 18. **Axios**
- **الإصدار:** 1.7.4
- **الوصف:** HTTP client
- **الاستخدام:** AJAX requests

### 19. **Noty**
- **الإصدار:** 3.2.0-beta-deprecated
- **الوصف:** مكتبة الإشعارات
- **الاستخدام:** Toast notifications

### 20. **SweetAlert**
- **الإصدار:** 2.1.2
- **الوصف:** مكتبة Alert boxes جميلة
- **الاستخدام:** Confirmations، Alerts

### 21. **CoreUI**
- **الإصدار:** 2.1.16
- **الوصف:** Admin template (من Backpack)
- **الاستخدام:** UI components

### 22. **Popper.js**
- **الإصدار:** 2.11.6
- **الوصف:** Positioning library
- **الاستخدام:** Tooltips، Popovers

---

## 🗺️ **Maps & Location**

### 23. **Google Maps API**
- **الوصف:** خدمة الخرائط من Google
- **الاستخدام:** تتبع الموزعين، عرض مواقع العملاء

---

## 🎨 **Icons & Fonts**

### 24. **Line Awesome**
- **الإصدار:** 1.3.0
- **الوصف:** مكتبة الأيقونات
- **الاستخدام:** الأيقونات في الواجهة

### 25. **Cairo Font**
- **الوصف:** خط عربي من Google Fonts
- **الاستخدام:** الخط الرئيسي للنظام

---

## 🔧 **Development Tools**

### 26. **Laravel Tinker**
- **الإصدار:** 2.9
- **الوصف:** REPL للتفاعل مع Laravel
- **الاستخدام:** اختبار الكود، استكشاف الأخطاء

### 27. **Concurrently**
- **الإصدار:** 9.0.1
- **الوصف:** تشغيل أوامر متعددة في نفس الوقت
- **الاستخدام:** Development workflow

### 28. **Laravel Pail**
- **الإصدار:** 1.1
- **الوصف:** عرض Logs في الوقت الفعلي
- **الاستخدام:** Debugging

---

## 🧪 **Testing**

### 29. **PHPUnit**
- **الإصدار:** 11.0.1
- **الوصف:** Unit testing framework
- **الاستخدام:** اختبار الكود

### 30. **Mockery**
- **الإصدار:** 1.6
- **الوصف:** Mocking library
- **الاستخدام:** اختبار الوحدات

### 31. **Faker**
- **الإصدار:** 1.23 (fakerphp/faker)
- **الوصف:** توليد بيانات وهمية
- **الاستخدام:** Testing، Seeding

---

## 🎨 **Code Quality**

### 32. **Laravel Pint**
- **الإصدار:** 1.13
- **الوصف:** Code style fixer
- **الاستخدام:** تنسيق الكود

### 33. **Nunomaduro Collision**
- **الإصدار:** 8.1
- **الوصف:** Error handler محسّن
- **الاستخدام:** عرض الأخطاء بشكل أفضل

---

## 🚀 **Deployment & Server**

### 34. **Laravel Sail**
- **الإصدار:** 1.26
- **الوصف:** Docker environment
- **الاستخدام:** بيئة التطوير (اختياري)

---

## 📦 **Package Managers**

### 35. **Composer**
- **الوصف:** PHP dependency manager
- **الاستخدام:** إدارة مكتبات PHP

### 36. **NPM (Node Package Manager)**
- **الوصف:** JavaScript package manager
- **الاستخدام:** إدارة مكتبات JavaScript

---

## 🌐 **CDN & Assets**

### 37. **Basset**
- **الوصف:** نظام Backpack لتحميل وتخزين Assets من CDN
- **الاستخدام:** تحميل CSS/JS من CDN وتخزينها محلياً

### 38. **CDN Sources:**
- **cdnjs.cloudflare.com** - jQuery، Line Awesome
- **cdn.jsdelivr.net** - Bootstrap، Popper.js، Noty، SweetAlert

---

## 🔄 **Real-time Communication**

### 39. **Laravel Echo**
- **الإصدار:** 2.2.6
- **الوصف:** مكتبة WebSockets للعميل
- **الاستخدام:** Real-time updates

### 40. **Pusher JS**
- **الإصدار:** 8.4.0
- **الوصف:** WebSocket client
- **الاستخدام:** Real-time communication

---

## 📝 **Additional Libraries**

### 41. **Animate.css**
- **الإصدار:** 4.1.1
- **الوصف:** مكتبة Animations
- **الاستخدام:** Animations في الواجهة

---

## 🗂️ **File Structure**

### 42. **Git**
- **الوصف:** Version control
- **الاستخدام:** إدارة الكود

### 43. **GitHub**
- **الوصف:** مستودع الكود
- **الرابط:** `git@github.com:baiitpait/eliyaa-water-distribution.git`

---

## 🌐 **Hosting & Server**

### 44. **Production Server**
- **الدومين:** https://eliyaa.baitpait.space
- **قاعدة البيانات:** `sarfesak_eliyaa`

### 45. **Local Development**
- **الرابط:** http://localhost:8000
- **قاعدة البيانات:** SQLite (محلي)

---

## 📊 **Summary**

### **Backend:**
- Laravel 11.31
- PHP 8.2+
- MySQL/MariaDB
- SQLite (للتنمية)

### **Admin Panel:**
- Backpack CRUD 6.8
- CoreUI v2 Theme
- Tabler Theme

### **Frontend:**
- Vite 6.0.11
- Tailwind CSS 3.4.13
- jQuery
- Bootstrap 4.6.2
- Chart.js
- Line Awesome Icons

### **Authentication:**
- Laravel Sanctum 4.2
- Backpack Auth

### **PDF Generation:**
- mPDF 8.2
- Laravel DomPDF 3.1

### **Real-time:**
- Laravel Reverb 1.6
- Laravel Echo 2.2.6
- Pusher JS 8.4.0

### **Maps:**
- Google Maps API

### **Development:**
- Laravel Tinker
- Laravel Pail
- PHPUnit
- Laravel Pint

---

**تاريخ الإنشاء:** 2025-01-XX  
**آخر تحديث:** 2025-01-XX
