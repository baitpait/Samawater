# دليل رفع الكود على سيرفر Ubuntu VPS - Webuzo
## Deployment Guide for Ubuntu VPS with Webuzo Control Panel

### 📋 المتطلبات الأساسية:
- ✅ سيرفر Ubuntu VPS
- ✅ لوحة تحكم Webuzo مثبتة
- ✅ وصول SSH إلى السيرفر
- ✅ وصول إلى لوحة تحكم Webuzo
- ✅ Laravel Application جاهز للرفع

---

## 🔧 الخطوة 1: التحضير المحلي (على جهازك)

### 1.1 التحقق من الملفات المعدلة:
```bash
# الملفات المعدلة في هذه الجلسة:
- resources/views/admin/delivery_list.blade.php
- resources/views/admin/reports/clients_delivery_overview.blade.php
- resources/views/vendor/backpack/ui/inc/menu_items.blade.php
- resources/views/vendor/backpack/crud/list.blade.php
- vendor/backpack/theme-coreuiv2/resources/views/inc/sidebar.blade.php
```

### 1.2 إنشاء ملف .zip للرفع:
```bash
# في مجلد المشروع
cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/water Aelea/eliyaa file/eliyaa"

# إنشاء ملف zip (استثناء node_modules, vendor, .git)
zip -r eliyaa-deployment.zip . \
  -x "node_modules/*" \
  -x "vendor/*" \
  -x ".git/*" \
  -x "storage/logs/*" \
  -x "storage/framework/cache/*" \
  -x "storage/framework/sessions/*" \
  -x "storage/framework/views/*" \
  -x ".env" \
  -x "*.zip"
```

---

## 🌐 الخطوة 2: الوصول إلى السيرفر

### 2.1 عبر SSH:
```bash
ssh username@your-server-ip
# أو
ssh username@your-domain.com
```

### 2.2 عبر لوحة تحكم Webuzo:
- افتح المتصفح واذهب إلى: `https://your-server-ip:2443`
- أو: `https://your-domain.com:2443`
- سجل الدخول باستخدام بيانات Webuzo

---

## 📁 الخطوة 3: تحديد موقع المشروع على السيرفر

### 3.1 عبر Webuzo File Manager:
1. سجل الدخول إلى Webuzo
2. اذهب إلى **File Manager**
3. ابحث عن مجلد المشروع (عادة في `/home/username/public_html` أو `/home/username/domains/yourdomain.com/public_html`)

### 3.2 عبر SSH:
```bash
# البحث عن مجلد Laravel
find /home -name "artisan" -type f 2>/dev/null
# أو
ls -la /home/username/public_html/
```

---

## 📤 الخطوة 4: رفع الملفات

### الطريقة 1: عبر Webuzo File Manager (الأسهل)

#### 4.1 رفع ملف ZIP:
1. سجل الدخول إلى Webuzo
2. اذهب إلى **File Manager**
3. انتقل إلى مجلد المشروع
4. اضغط **Upload**
5. اختر ملف `eliyaa-deployment.zip`
6. انتظر اكتمال الرفع

#### 4.2 استخراج الملفات:
1. في File Manager، انقر بزر الماوس الأيمن على `eliyaa-deployment.zip`
2. اختر **Extract** أو **Unzip**
3. تأكد من استخراج الملفات في المجلد الصحيح

### الطريقة 2: عبر SSH (أسرع)

#### 4.1 رفع الملفات باستخدام SCP:
```bash
# من جهازك المحلي
scp eliyaa-deployment.zip username@your-server-ip:/home/username/public_html/
```

#### 4.2 استخراج الملفات:
```bash
# على السيرفر
cd /home/username/public_html/
unzip -o eliyaa-deployment.zip
```

---

## 🔄 الخطوة 5: استبدال الملفات المعدلة

### 5.1 نسخ الملفات الجديدة:
```bash
# على السيرفر
cd /home/username/public_html/your-project-name

# نسخ الملفات المعدلة
cp -r resources/views/admin/delivery_list.blade.php resources/views/admin/
cp -r resources/views/admin/reports/clients_delivery_overview.blade.php resources/views/admin/reports/
cp -r resources/views/vendor/backpack/ui/inc/menu_items.blade.php resources/views/vendor/backpack/ui/inc/
cp -r resources/views/vendor/backpack/crud/list.blade.php resources/views/vendor/backpack/crud/
cp -r vendor/backpack/theme-coreuiv2/resources/views/inc/sidebar.blade.php vendor/backpack/theme-coreuiv2/resources/views/inc/
```

---

## ⚙️ الخطوة 6: إعداد Laravel على السيرفر

### 6.1 تثبيت Dependencies:
```bash
cd /home/username/public_html/your-project-name

# تثبيت Composer Dependencies
composer install --no-dev --optimize-autoloader

# تثبيت NPM Dependencies (إذا لزم الأمر)
npm install
npm run build
```

### 6.2 إعداد Permissions:
```bash
# إعطاء صلاحيات للمجلدات
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 6.3 إعداد Environment:
```bash
# نسخ ملف .env (إذا لم يكن موجوداً)
cp .env.example .env

# تعديل ملف .env حسب إعدادات السيرفر
nano .env
# أو
vi .env
```

### 6.4 توليد Key و Cache:
```bash
# توليد Application Key
php artisan key:generate

# مسح Cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# إنشاء Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🗄️ الخطوة 7: قاعدة البيانات

### 7.1 عبر Webuzo phpMyAdmin:
1. سجل الدخول إلى Webuzo
2. اذهب إلى **phpMyAdmin**
3. تأكد من وجود قاعدة البيانات
4. تأكد من تحديث ملف `.env` بإعدادات قاعدة البيانات الصحيحة

### 7.2 تشغيل Migrations (إذا لزم الأمر):
```bash
php artisan migrate --force
```

---

## 🔐 الخطوة 8: إعدادات الأمان

### 8.1 تحديث Permissions:
```bash
# التأكد من صلاحيات الملفات
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
```

### 8.2 حماية ملف .env:
```bash
chmod 600 .env
```

---

## 🌍 الخطوة 9: إعداد Web Server

### 9.1 عبر Webuzo:
1. سجل الدخول إلى Webuzo
2. اذهب إلى **Apache Settings** أو **Nginx Settings**
3. تأكد من أن Document Root يشير إلى مجلد `public` في Laravel
4. مثال: `/home/username/public_html/your-project-name/public`

### 9.2 عبر SSH (إذا لزم الأمر):
```bash
# للتحقق من إعدادات Apache
cat /etc/apache2/sites-available/your-domain.conf

# إعادة تشغيل Apache
sudo systemctl restart apache2
# أو
sudo service apache2 restart
```

---

## ✅ الخطوة 10: التحقق والاختبار

### 10.1 التحقق من الملفات:
```bash
# التحقق من وجود الملفات المعدلة
ls -la resources/views/admin/delivery_list.blade.php
ls -la resources/views/admin/reports/clients_delivery_overview.blade.php
ls -la resources/views/vendor/backpack/ui/inc/menu_items.blade.php
```

### 10.2 اختبار الصفحات:
افتح المتصفح واختبر:
- ✅ `https://your-domain.com/admin/delivery-list` - التصفح والنص العربي
- ✅ `https://your-domain.com/admin/reports/clients_delivery_overview` - النموذج والتصفح
- ✅ `https://your-domain.com/admin/client-type` - التأكد من ظهور المحتوى
- ✅ `https://your-domain.com/admin/client-status` - التأكد من التوجيه الصحيح
- ✅ القائمة الجانبية - التأكد من ظهور الشعار

---

## 🔧 الخطوة 11: مسح Cache بعد الرفع

```bash
# على السيرفر
cd /home/username/public_html/your-project-name

# مسح جميع أنواع Cache
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# إعادة إنشاء Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📝 ملاحظات مهمة:

### ⚠️ قبل الرفع:
1. **Backup**: قم بعمل نسخة احتياطية من الملفات الحالية على السيرفر
2. **Database Backup**: قم بعمل نسخة احتياطية من قاعدة البيانات
3. **Test Locally**: تأكد من أن كل شيء يعمل محلياً

### ⚠️ بعد الرفع:
1. **Clear Browser Cache**: امسح cache المتصفح (Ctrl+F5)
2. **Check Logs**: راجع ملفات السجلات في `storage/logs/`
3. **Test All Features**: اختبر جميع الميزات للتأكد من عملها

### 📦 الملفات المهمة للرفع:
- ✅ `resources/views/` - جميع ملفات Views
- ✅ `vendor/backpack/theme-coreuiv2/resources/views/inc/sidebar.blade.php`
- ✅ `public/css/unified-forms.css` (إذا كان موجوداً)
- ✅ `public/logo/Logo-2.png` (الشعار)

### ❌ الملفات التي لا يجب رفعها:
- ❌ `node_modules/` - سيتم تثبيتها على السيرفر
- ❌ `vendor/` - سيتم تثبيتها عبر composer
- ❌ `.env` - يجب إنشاؤه على السيرفر
- ❌ `storage/logs/*` - ملفات السجلات
- ❌ `.git/` - مجلد Git

---

## 🚀 خطوات سريعة (Quick Steps):

```bash
# 1. على جهازك - إنشاء ZIP
zip -r eliyaa-deployment.zip . -x "node_modules/*" -x "vendor/*" -x ".git/*" -x ".env" -x "*.zip"

# 2. رفع ZIP إلى السيرفر
scp eliyaa-deployment.zip username@server-ip:/home/username/public_html/

# 3. على السيرفر - استخراج
cd /home/username/public_html/
unzip -o eliyaa-deployment.zip

# 4. على السيرفر - تثبيت Dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# 5. على السيرفر - مسح Cache
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. على السيرفر - Permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🆘 حل المشاكل الشائعة:

### مشكلة: الصفحة تظهر بيضاء
```bash
# تحقق من Logs
tail -f storage/logs/laravel.log

# مسح Cache
php artisan view:clear
php artisan config:clear
```

### مشكلة: خطأ في الصلاحيات
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### مشكلة: CSS لا يظهر
```bash
# مسح View Cache
php artisan view:clear

# التأكد من وجود ملف unified-forms.css
ls -la public/css/unified-forms.css
```

### مشكلة: الشعار لا يظهر
```bash
# التأكد من وجود ملف الشعار
ls -la public/logo/Logo-2.png

# التحقق من الصلاحيات
chmod 644 public/logo/Logo-2.png
```

---

## ✅ قائمة التحقق النهائية:

- [ ] تم رفع جميع الملفات المعدلة
- [ ] تم تثبيت Composer Dependencies
- [ ] تم إعداد ملف .env بشكل صحيح
- [ ] تم إعطاء الصلاحيات الصحيحة
- [ ] تم مسح Cache
- [ ] تم اختبار جميع الصفحات
- [ ] تم التحقق من ظهور الشعار
- [ ] تم التحقق من النص العربي في التصفح
- [ ] تم التحقق من روابط القائمة الجانبية

---

## 📞 الدعم:

إذا واجهت أي مشاكل:
1. راجع ملفات السجلات: `storage/logs/laravel.log`
2. تحقق من صلاحيات الملفات
3. تأكد من إعدادات قاعدة البيانات في `.env`
4. تأكد من أن Web Server يشير إلى مجلد `public`

---

**تم إنشاء هذا الدليل بتاريخ:** 2025-01-01
**آخر تحديث:** بعد جلسة التطوير الحالية

