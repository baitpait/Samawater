# ✅ إصلاح Route صفحة الحساب

## المشكلة
كانت صفحة `/admin/account` تعطي خطأ 404 لأن Route غير موجود.

## الحل
تم إضافة Route redirect من `/admin/account` إلى `/admin/edit-account-info` (صفحة الحساب الفعلية).

## التعديلات

### الملف: `routes/backpack/custom.php`

**تم إضافة:**
```php
// Redirect /admin/account to /admin/edit-account-info
Route::get('account', function () {
    return redirect(route('backpack.account.info'));
})->name('backpack.account');
```

## Routes المتاحة الآن

1. **`/admin/account`** → يعيد التوجيه إلى `/admin/edit-account-info`
2. **`/admin/edit-account-info`** → صفحة تعديل معلومات الحساب (Route name: `backpack.account.info`)
3. **`/admin/change-password`** → صفحة تغيير كلمة المرور (Route name: `backpack.account.password`)

## التحقق

```bash
php artisan route:list --path=account
```

يجب أن يظهر:
- `GET|HEAD admin/account` → `backpack.account`
- `GET|HEAD admin/edit-account-info` → `backpack.account.info`
- `POST admin/edit-account-info` → `backpack.account.info.store`
- `POST admin/change-password` → `backpack.account.password`

## ✅ الحالة
- ✅ Route `/admin/account` يعمل الآن
- ✅ يعيد التوجيه تلقائياً إلى صفحة الحساب
- ✅ Routes تم تحديثها في cache
