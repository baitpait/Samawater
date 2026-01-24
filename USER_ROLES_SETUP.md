# 🔐 دليل إعداد نظام المستخدمين والصلاحيات

## ✅ **ما تم إنجازه:**

### 1. **إنشاء جدول `roles`:**
- `id` - المعرف
- `name` - الاسم الفني (super_admin, admin)
- `display_name` - الاسم المعروض (مسؤول رئيسي, مسؤول)
- `description` - الوصف
- `is_super_admin` - هل هو مسؤول رئيسي؟

### 2. **إضافة `role_id` إلى جدول `users`:**
- كل مستخدم له `role_id` يشير إلى نوع المستخدم

### 3. **أنواع المستخدمين:**
- **مسؤول رئيسي (Super Admin):** يمكنه إدارة المستخدمين + كل الصلاحيات
- **مسؤول (Admin):** له كل الصلاحيات إلا إدارة المستخدمين

### 4. **Middleware للصلاحيات:**
- `CheckUserManagementPermission` - يتحقق من أن المستخدم هو Super Admin فقط

---

## 📋 **خطوات الإعداد:**

### **1. تحديث المستخدم الحالي (admin) ليكون Super Admin:**

```sql
-- الحصول على ID للمسؤول الرئيسي
SELECT id FROM roles WHERE name = 'super_admin';

-- تحديث المستخدم الحالي (admin@gmail.com) ليكون Super Admin
UPDATE users 
SET role_id = (SELECT id FROM roles WHERE name = 'super_admin') 
WHERE email = 'admin@gmail.com';
```

أو من Laravel Tinker:
```bash
php artisan tinker
```

```php
$superAdminRole = \App\Models\Role::where('name', 'super_admin')->first();
$admin = \App\Models\User::where('email', 'admin@gmail.com')->first();
$admin->role_id = $superAdminRole->id;
$admin->save();
```

---

## 🔧 **الاستخدام:**

### **1. إضافة مستخدم جديد:**
- فقط **Super Admin** يمكنه الوصول إلى `/admin/user`
- يمكنه إضافة مستخدمين جدد وتحديد نوعهم

### **2. تعديل مستخدم:**
- فقط **Super Admin** يمكنه تعديل المستخدمين

### **3. حذف مستخدم:**
- فقط **Super Admin** يمكنه حذف المستخدمين

---

## 📝 **ملاحظات مهمة:**

### **1. القائمة الجانبية:**
- رابط "المستخدمين" يظهر فقط للمستخدمين الذين لديهم صلاحية (Super Admin)

### **2. الحماية:**
- جميع Routes الخاصة بإدارة المستخدمين محمية بـ `CheckUserManagementPermission` Middleware
- إذا حاول مستخدم عادي الوصول، سيحصل على خطأ 403

### **3. الصلاحيات:**
- **Super Admin:** كل الصلاحيات + إدارة المستخدمين
- **Admin:** كل الصلاحيات إلا إدارة المستخدمين

---

## ✅ **التحقق من الإعداد:**

### **1. التحقق من أن المستخدم الحالي هو Super Admin:**
```php
$user = \App\Models\User::where('email', 'admin@gmail.com')->first();
$user->isSuperAdmin(); // يجب أن يعيد true
$user->canManageUsers(); // يجب أن يعيد true
```

### **2. التحقق من ظهور رابط "المستخدمين":**
- سجل دخول كـ Super Admin
- يجب أن يظهر رابط "المستخدمين" في القائمة الجانبية

### **3. التحقق من الحماية:**
- أنشئ مستخدم جديد بنوع "مسؤول" (ليس Super Admin)
- حاول الوصول إلى `/admin/user`
- يجب أن تحصل على خطأ 403

---

## 🚀 **الخطوات التالية:**

1. ✅ تحديث المستخدم الحالي ليكون Super Admin
2. ✅ اختبار إضافة مستخدم جديد
3. ✅ اختبار تعديل مستخدم
4. ✅ اختبار الحماية (محاولة الوصول كمستخدم عادي)

---

## 📁 **الملفات التي تم إنشاؤها/تعديلها:**

- `database/migrations/2025_12_28_213948_create_roles_table.php` - جدول Roles
- `database/migrations/2025_12_28_213949_add_role_id_to_users_table.php` - إضافة role_id
- `app/Models/Role.php` - Model للـ Role
- `app/Models/User.php` - تحديث لإضافة العلاقة والـ Methods
- `app/Http/Controllers/Admin/UserCrudController.php` - Controller لإدارة المستخدمين
- `app/Http/Middleware/CheckUserManagementPermission.php` - Middleware للصلاحيات
- `database/seeders/RolesSeeder.php` - Seeder لإضافة Roles الافتراضية
- `routes/backpack/custom.php` - Routes محمية بـ Middleware
- `resources/views/vendor/backpack/ui/inc/menu_items.blade.php` - رابط "المستخدمين" في القائمة

