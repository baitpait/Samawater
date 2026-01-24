# 🚀 دليل الرفع السريع - المشروع الكامل
## Quick Full Deployment Guide

**الدومين:** https://eliyaa.baitpait.space/
**التاريخ:** 31 ديسمبر 2024

---

## 📦 **الملفات الجاهزة:**

1. ✅ `eliyaa-full-deployment.zip` (77M) - المشروع الكامل
2. ✅ `.env.production.txt` - ملف .env للإنتاج

---

## 🚀 **خطوات الرفع السريعة:**

### **1. رفع ملف ZIP عبر Webuzo:**
- سجل الدخول إلى Webuzo
- اذهب إلى **File Manager**
- انتقل إلى مجلد المشروع
- اضغط **Upload**
- اختر `eliyaa-full-deployment.zip`
- انتظر اكتمال الرفع (قد يستغرق وقتاً)

### **2. استخراج الملفات:**
- في File Manager، انقر بزر الماوس الأيمن على `eliyaa-full-deployment.zip`
- اختر **Extract** أو **Unzip**

### **3. إنشاء ملف .env:**
- في File Manager، أنشئ ملف جديد باسم `.env`
- افتح ملف `.env.production.txt` من جهازك
- انسخ المحتوى والصقه في ملف `.env` على السيرفر
- احفظ الملف

### **4. تثبيت Dependencies (عبر SSH):**
```bash
cd /path/to/project

# تثبيت Composer
composer install --no-dev --optimize-autoloader

# تثبيت NPM
npm install
npm run build
```

### **5. إعداد الصلاحيات:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod 600 .env
```

### **6. مسح وبناء Cache:**
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

---

## ✅ **قائمة التحقق:**

- [ ] تم رفع ZIP واستخراجه
- [ ] تم إنشاء ملف `.env`
- [ ] تم تثبيت `composer install`
- [ ] تم تثبيت `npm install`
- [ ] تم بناء Assets `npm run build`
- [ ] تم إعطاء الصلاحيات
- [ ] تم مسح Cache
- [ ] تم إنشاء Cache
- [ ] تم اختبار الموقع

---

## 🧪 **اختبار الموقع:**

- ✅ `https://eliyaa.baitpait.space/` - الصفحة الرئيسية
- ✅ `https://eliyaa.baitpait.space/admin` - لوحة التحكم
- ✅ `https://eliyaa.baitpait.space/api/cities` - API
- ✅ `https://eliyaa.baitpait.space/admin/delivery-list` - قائمة التسليم

---

**جاهز للرفع!** 🚀

