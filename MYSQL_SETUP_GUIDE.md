# دليل إعداد MySQL في TablePlus

## 📋 الخطوات

### 1. إنشاء قاعدة بيانات جديدة في TablePlus

1. افتح **TablePlus**
2. اضغط على **"Create a new connection"** أو **"+"**
3. اختر **MySQL**
4. أدخل بيانات الاتصال:
   ```
   Name: Eliyaa Local (أو أي اسم تريده)
   Host: localhost (أو 127.0.0.1)
   Port: 3306
   User: root (أو اسم المستخدم الخاص بك)
   Password: (كلمة مرور MySQL)
   Database: (اتركه فارغاً - سننشئ قاعدة البيانات لاحقاً)
   ```
5. اضغط **Test** للتأكد من الاتصال
6. اضغط **Save** لحفظ الاتصال

---

### 2. إنشاء قاعدة البيانات

#### الطريقة 1: من TablePlus

1. بعد الاتصال، اضغط على **"New Query"** (أو `Cmd/Ctrl + E`)
2. نفذ الأمر التالي:
   ```sql
   CREATE DATABASE eliyaa_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. اضغط **Run** (أو `Cmd/Ctrl + R`)
4. اضغط على **"Refresh"** لرؤية قاعدة البيانات الجديدة

#### الطريقة 2: من Terminal

```bash
mysql -u root -p
```

ثم نفذ:
```sql
CREATE DATABASE eliyaa_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

---

### 3. تحديث ملف .env

افتح ملف `.env` في المشروع وحدّث إعدادات قاعدة البيانات:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eliyaa_local
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

**⚠️ مهم:** استبدل `your_mysql_password` بكلمة مرور MySQL الخاصة بك.

---

### 4. تشغيل Migrations

بعد تحديث `.env`، شغّل:

```bash
php artisan config:clear
php artisan migrate:fresh --seed
```

**ملاحظة:** `migrate:fresh` سيمحو جميع الجداول الموجودة ويُنشئها من جديد. إذا كان لديك بيانات مهمة، استخدم `php artisan migrate` بدلاً من ذلك.

---

### 5. التحقق من النجاح

1. افتح TablePlus
2. اختر قاعدة البيانات `eliyaa_local`
3. تأكد من وجود جميع الجداول:
   - `users`
   - `clients`
   - `deliveries`
   - `distributors`
   - `cities`
   - `subscription_types`
   - `subscription_statuses`
   - `client_types`
   - `client_statuses`
   - `cash_withdraws`
   - وغيرها...

---

## ✅ التحقق النهائي

شغّل الأمر التالي للتحقق من أن النظام يعمل:

```bash
php artisan tinker
```

ثم نفذ:
```php
DB::connection()->getDriverName(); // يجب أن يعيد "mysql"
DB::table('users')->count(); // يجب أن يعيد عدد المستخدمين
```

---

## 🔧 استكشاف الأخطاء

### خطأ: "Access denied for user"
- تأكد من أن اسم المستخدم وكلمة المرور صحيحة
- تأكد من أن MySQL يعمل: `mysql.server start` (macOS) أو `sudo systemctl start mysql` (Linux)

### خطأ: "Unknown database"
- تأكد من أن قاعدة البيانات `eliyaa_local` موجودة
- تحقق من اسم قاعدة البيانات في `.env`

### خطأ: "Table already exists"
- استخدم `php artisan migrate:fresh` لإعادة إنشاء الجداول
- أو احذف الجداول يدوياً من TablePlus

---

## 📝 ملاحظات

- **الترميز:** قاعدة البيانات تستخدم `utf8mb4_unicode_ci` لدعم اللغة العربية بشكل كامل
- **النسخ الاحتياطي:** استخدم TablePlus لتصدير قاعدة البيانات: **File > Export > SQL**
- **الاستيراد:** استخدم TablePlus لاستيراد ملف SQL: **File > Import > SQL**

---

## 🎯 الخطوة التالية

بعد إعداد قاعدة البيانات، شغّل:

```bash
php artisan serve
```

ثم افتح: http://localhost:8000/admin/login
- Email: `admin@gmail.com`
- Password: `100200300`
