# 🔧 حل مشكلة صلاحيات ملف .env

## المشكلة
```
file_get_contents(): Failed to open stream: Permission denied
```

**السبب:** ملف `.env` لا يملك صلاحيات القراءة/الكتابة الصحيحة.

---

## ✅ الحل السريع

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
# 1. التحقق من صلاحيات ملف .env
ls -la .env

# 2. إصلاح الصلاحيات
chmod 644 .env
chown www-data:www-data .env

# أو إذا لم يعمل www-data
chown sarfesak:sarfesak .env

# 3. التحقق من أن الملف قابل للقراءة
cat .env | head -5

# 4. التحقق من تنسيق الملف (لا يجب أن يكون هناك أخطاء)
php -r "parse_ini_file('.env'); echo 'OK';"
```

---

## 🔍 التحقق من المشاكل الشائعة

### 1. التحقق من الصلاحيات

```bash
ls -la .env
```

**يجب أن ترى:**
```
-rw-r--r-- 1 www-data www-data  .env
```

**إذا كان مختلفاً، أصلحه:**
```bash
chmod 644 .env
chown www-data:www-data .env
```

---

### 2. التحقق من تنسيق الملف

```bash
# التحقق من وجود أخطاء في التنسيق
cat .env | grep -E "^[^#=]*=" | head -10

# التحقق من وجود أسطر فارغة أو مشاكل
cat -A .env | head -20
```

---

### 3. التحقق من أن الملف موجود

```bash
# التحقق من وجود الملف
test -f .env && echo "موجود" || echo "غير موجود"

# التحقق من حجم الملف
wc -l .env
```

---

## 📝 إصلاح شامل

```bash
# 1. نسخ احتياطي من ملف .env
cp .env .env.backup

# 2. إصلاح الصلاحيات
chmod 644 .env
chown www-data:www-data .env

# 3. التحقق من التنسيق
php -r "if(file_exists('.env')) { echo 'File exists'; } else { echo 'File not found'; }"

# 4. اختبار قراءة الملف
php -r "echo file_get_contents('.env') ? 'Readable' : 'Not readable';"

# 5. مسح Cache
php artisan config:clear
php artisan cache:clear
```

---

## ⚠️ إذا استمرت المشكلة

### الحل 1: إعادة إنشاء ملف .env

```bash
# 1. نسخ احتياطي
cp .env .env.backup

# 2. حذف الملف القديم
rm .env

# 3. إنشاء ملف جديد
touch .env

# 4. إعطاء الصلاحيات
chmod 644 .env
chown www-data:www-data .env

# 5. إضافة المحتوى (انسخ محتوى .env.backup)
nano .env
# الصق المحتوى واحفظه
```

---

### الحل 2: استخدام مستخدم مختلف

```bash
# إذا كان www-data لا يعمل، استخدم sarfesak
chown sarfesak:sarfesak .env
chmod 644 .env
```

---

### الحل 3: التحقق من SELinux (إذا كان مفعلاً)

```bash
# التحقق من حالة SELinux
getenforce

# إذا كان Enforcing، جرب:
chcon -R -t httpd_sys_rw_content_t .env
```

---

## ✅ قائمة التحقق

- [ ] ملف .env موجود
- [ ] صلاحيات الملف صحيحة (644)
- [ ] المالك صحيح (www-data أو sarfesak)
- [ ] الملف قابل للقراءة
- [ ] تنسيق الملف صحيح (لا أخطاء)
- [ ] تم مسح Cache

---

## 🎯 الحل السريع (نسخ ولصق)

```bash
# إصلاح الصلاحيات
chmod 644 .env
chown www-data:www-data .env

# إذا لم يعمل www-data
chown sarfesak:sarfesak .env

# التحقق
ls -la .env

# مسح Cache
php artisan config:clear
php artisan cache:clear
```

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** حل مشكلة صلاحيات ملف .env

