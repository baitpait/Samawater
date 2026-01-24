# 💧 نظام توزيع المياه - إيليا

## 📍 الوضع الحالي

### ✅ السيرفر البعيد (الإنتاج)
- **الرابط:** https://eliyaa.baitpait.space
- **الحالة:** ✅ يعمل بشكل طبيعي
- **قاعدة البيانات:** `sarfesak_eliyaa` على السيرفر

### 🖥️ السيرفر المحلي (التطوير)
- **الرابط:** http://localhost:8000
- **الحالة:** ✅ يعمل الآن
- **الغرض:** التطوير والتعديل قبل الرفع

---

## 🚀 البدء السريع

### 1. إعداد البيئة المحلية

#### الطريقة السريعة (مستحسن):
```bash
./setup_local.sh
```

#### الطريقة اليدوية:
```bash
# تنظيف الكاش
php artisan config:clear
php artisan cache:clear

# تحديث الإعدادات
php artisan config:cache

# تشغيل السيرفر
php artisan serve --host=0.0.0.0 --port=8000
```

### 2. إعداد قاعدة البيانات المحلية

#### إنشاء قاعدة بيانات محلية:
```bash
mysql -u root -p
CREATE DATABASE eliyaa_local CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
EXIT;
```

#### استيراد البيانات:
```bash
mysql -u root -p eliyaa_local < database_eliyaa.sql
```

#### تحديث ملف .env:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eliyaa_local
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. الوصول إلى النظام

- **الصفحة الرئيسية:** http://localhost:8000
- **لوحة التحكم:** http://localhost:8000/admin
- **API:** http://localhost:8000/api

---

## 📚 الملفات التوثيقية

1. **LOCAL_SETUP.md** - دليل إعداد البيئة المحلية
2. **DEPLOYMENT_GUIDE.md** - دليل رفع النظام على السيرفر
3. **SYSTEM_OVERVIEW.md** - نظرة عامة على النظام
4. **DATABASE_SETUP.md** - دليل إعداد قاعدة البيانات
5. **QUICK_START.md** - دليل البدء السريع

---

## 🔄 سير العمل (Workflow)

```
1. التطوير المحلي
   ↓
   localhost:8000
   قاعدة بيانات محلية
   تعديل الكود
   ↓
2. اختبار التعديلات
   ↓
3. الرفع على السيرفر
   ↓
   eliyaa.baitpait.space
   قاعدة بيانات الإنتاج
```

---

## 🛠️ أوامر مفيدة

### التطوير:
```bash
# تشغيل السيرفر
php artisan serve

# عرض الأخطاء
tail -f storage/logs/laravel.log

# إعادة بناء Assets
npm run dev
```

### قبل الرفع:
```bash
# تنظيف الكاش
php artisan optimize:clear

# بناء Assets للإنتاج
npm run build

# تحسين الأداء
php artisan config:cache
php artisan route:cache
```

---

## 📋 قائمة التحقق قبل الرفع

- [ ] التعديلات تعمل محلياً
- [ ] تم اختبار جميع الميزات
- [ ] لا توجد أخطاء في `storage/logs/laravel.log`
- [ ] تم بناء Assets (`npm run build`)
- [ ] تم تحديث ملف `.env` على السيرفر
- [ ] تم رفع الملفات على السيرفر
- [ ] تم اختبار النظام على السيرفر

---

## 🔐 معلومات مهمة

### ملفات لا يجب رفعها:
```
❌ .env
❌ storage/logs/*.log
❌ node_modules/
❌ .git/
❌ vendor/ (يمكن تثبيته على السيرفر)
```

### ملفات يجب رفعها:
```
✅ app/
✅ bootstrap/
✅ config/
✅ database/migrations/
✅ public/
✅ resources/
✅ routes/
✅ storage/ (المجلد فقط، ليس الملفات)
✅ artisan
✅ composer.json
✅ composer.lock
```

---

## 📞 الدعم

إذا واجهت أي مشاكل:

1. تحقق من `storage/logs/laravel.log`
2. تحقق من صلاحيات الملفات
3. تحقق من إعدادات قاعدة البيانات
4. راجع الملفات التوثيقية

---

## ✅ جاهز للتطوير!

النظام الآن جاهز للعمل محلياً. يمكنك:
- ✅ تعديل الكود
- ✅ اختبار التعديلات
- ✅ تطوير ميزات جديدة
- ✅ إصلاح الأخطاء

بعد الانتهاء، ارفع التعديلات على السيرفر باستخدام `DEPLOYMENT_GUIDE.md`.

