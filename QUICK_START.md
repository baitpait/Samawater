# 🚀 دليل البدء السريع

## ✅ السيرفر المحلي يعمل الآن!

- **الرابط:** http://localhost:8000
- **الحالة:** ✅ يعمل

---

## 📋 ملخص النظام

**نظام توزيع المياه للمشتركين (إيليا)**

### المكونات الرئيسية:
1. **المشتركين** - إدارة العملاء
2. **الموزعين** - إدارة الموزعين والمدفوعات
3. **التوصيلات** - تسجيل التوصيلات اليومية
4. **التقارير** - تقارير المستحقات والأداء

---

## 🔗 الروابط المهمة

### على السيرفر المحلي:
- **الصفحة الرئيسية:** http://localhost:8000
- **لوحة التحكم:** http://localhost:8000/admin
- **API:** http://localhost:8000/api

### بعد الرفع على السيرفر:
- **الصفحة الرئيسية:** https://your-domain.com
- **لوحة التحكم:** https://your-domain.com/admin
- **API:** https://your-domain.com/api

---

## 📱 API Endpoints الرئيسية

### الموزعين:
```
POST   /api/distributor/login          - تسجيل الدخول
POST   /api/distributor/logout         - تسجيل الخروج
GET    /api/distributors                - قائمة الموزعين
GET    /api/distributor-balance/{id}    - رصيد الموزع
```

### التوصيلات:
```
POST   /api/deliveries                  - تسجيل توصيل جديد
PUT    /api/delivery/{id}               - تعديل توصيل
```

### المشتركين:
```
GET    /api/allclient                   - جميع المشتركين
GET    /api/clients-due                 - المشتركين المستحقين
POST   /api/update-client-location      - تحديث موقع المشترك
```

### المدن:
```
GET    /api/cities                      - قائمة المدن
```

---

## 🗄️ قاعدة البيانات

### معلومات قاعدة البيانات:
- **الاسم:** `sarfesak_eliyaa`
- **ملف SQL:** `database_eliyaa.sql`
- **الجداول:** 28 جدول

### استيراد قاعدة البيانات:
```bash
# عبر phpMyAdmin أو:
mysql -u username -p sarfesak_eliyaa < database_eliyaa.sql
```

---

## ⚙️ إعدادات مهمة

### ملف .env:
```env
APP_ENV=production          # للإنتاج
APP_DEBUG=false             # للإنتاج
APP_URL=https://your-domain.com
DB_DATABASE=sarfesak_eliyaa
```

### الصلاحيات:
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📚 الملفات التوثيقية

1. **SYSTEM_OVERVIEW.md** - نظرة عامة شاملة على النظام
2. **DATABASE_SETUP.md** - دليل إعداد قاعدة البيانات
3. **DEPLOYMENT_GUIDE.md** - دليل رفع النظام على السيرفر

---

## 🔧 أوامر مفيدة

```bash
# تنظيف الكاش
php artisan config:clear
php artisan cache:clear

# تحسين الأداء (بعد الرفع)
php artisan config:cache
php artisan route:cache

# عرض الأخطاء
tail -f storage/logs/laravel.log
```

---

## ✅ جاهز للتعديلات!

النظام يعمل الآن ويمكنك تحديد التعديلات المطلوبة.

