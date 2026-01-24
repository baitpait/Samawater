# ⚙️ تعليمات تحديث ملف .env للإنتاج
## .env Update Instructions for Production

**الدومين:** https://eliyaa.baitpait.space/

---

## ✅ **يمكنك رفع الملف القديم!**

إذا كان لديك ملف `.env` قديم، يمكنك رفعه مباشرة، لكن **يجب تعديل 3 إعدادات فقط**:

---

## 🔧 **التعديلات المطلوبة:**

### **1. APP_ENV:**
```env
# قبل (للحاسوب المحلي):
APP_ENV=local

# بعد (للإنتاج):
APP_ENV=production
```

### **2. APP_DEBUG:**
```env
# قبل (للحاسوب المحلي):
APP_DEBUG=true

# بعد (للإنتاج):
APP_DEBUG=false
```

### **3. LOG_LEVEL:**
```env
# قبل (للحاسوب المحلي):
LOG_LEVEL=debug

# بعد (للإنتاج):
LOG_LEVEL=error
```

---

## 📋 **خطوات التحديث:**

### **الطريقة 1: عبر Webuzo File Manager**

1. ارفع ملف `.env` من جهازك إلى السيرفر
2. انقر بزر الماوس الأيمن على ملف `.env`
3. اختر **Edit** أو **Open**
4. ابحث عن هذه الأسطر وعدّلها:
   - `APP_ENV=local` → `APP_ENV=production`
   - `APP_DEBUG=true` → `APP_DEBUG=false`
   - `LOG_LEVEL=debug` → `LOG_LEVEL=error`
5. احفظ الملف

### **الطريقة 2: عبر SSH**

```bash
cd /path/to/project

# تعديل الملف
nano .env

# ابحث عن هذه الأسطر وعدّلها:
# APP_ENV=local → APP_ENV=production
# APP_DEBUG=true → APP_DEBUG=false
# LOG_LEVEL=debug → LOG_LEVEL=error

# احفظ الملف (Ctrl+X, ثم Y, ثم Enter)
```

### **الطريقة 3: استخدام sed (أسرع)**

```bash
cd /path/to/project

# تعديل الإعدادات تلقائياً
sed -i 's/APP_ENV=local/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
sed -i 's/LOG_LEVEL=debug/LOG_LEVEL=error/' .env

# التحقق من التعديلات
grep -E "^(APP_ENV|APP_DEBUG|LOG_LEVEL)=" .env
```

---

## ✅ **باقي الإعدادات:**

جميع الإعدادات الأخرى **لا تحتاج تعديل**:
- ✅ `APP_URL=https://eliyaa.baitpait.space` - صحيح
- ✅ `DB_DATABASE=sarfesak_eliyaa` - صحيح
- ✅ `DB_USERNAME=sarfesak_eliyaa` - صحيح
- ✅ `DB_PASSWORD=(!7poSOM68` - صحيح
- ✅ جميع الإعدادات الأخرى - صحيحة

---

## 🔍 **التحقق من التعديلات:**

بعد التعديل، تحقق من أن الملف يحتوي على:

```bash
# عبر SSH
grep -E "^(APP_ENV|APP_DEBUG|LOG_LEVEL)=" .env
```

**يجب أن يظهر:**
```
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

---

## ⚠️ **ملاحظات مهمة:**

1. **APP_DEBUG=false:**
   - مهم جداً للإنتاج
   - يخفي رسائل الأخطاء من المستخدمين
   - يحسن الأمان

2. **APP_ENV=production:**
   - يفعّل إعدادات الإنتاج
   - يحسّن الأداء
   - يفعّل Cache

3. **LOG_LEVEL=error:**
   - يسجّل الأخطاء فقط
   - يقلل حجم ملفات السجلات
   - يحسّن الأداء

---

## ✅ **الخلاصة:**

- ✅ **يمكنك رفع الملف القديم**
- ✅ **عدّل 3 إعدادات فقط**
- ✅ **باقي الإعدادات صحيحة**

---

**جاهز!** بعد التعديل، استمر في الخطوات التالية (تثبيت Dependencies).

