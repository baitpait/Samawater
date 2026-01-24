# ADR-002-v2: نظام إدارة المصروفات مع الترحيل التلقائي

**التاريخ:** 2025-01-25  
**الحالة:** محدث بناءً على متطلبات المستخدم  
**القرار:** قيد التنفيذ

---

## 📋 السياق (Context)

- **المتطلب:** نظام مصروفات عامة (غير مربوطة بالموزعين)
- **الميزة الجديدة:** ترحيل تلقائي للمصروفات من "المصروفات الشهرية الحالية" إلى "قائمة المصروفات الرئيسية"
- **الهدف:** تتبع المصروفات الشهرية الحالية ثم ترحيلها للتاريخ

---

## 🎯 التصميم المحدث

### 1. **فئات المصروفات (Expense Categories)** - بدون تغيير

```php
- id
- name (string) - اسم الفئة
- description (text, nullable)
- is_active (boolean, default: true)
- created_at, updated_at
```

---

### 2. **المصروفات (Expenses)** - محدث

```php
- id
- expense_category_id (foreign key)
- name (string) - اسم المصروف
- total_amount (decimal) - المبلغ الإجمالي
- number_of_months (integer) - عدد الأشهر
- monthly_amount (decimal) - المبلغ الشهري (محسوب)
- start_month (date) - الشهر الأول
- end_month (date) - الشهر الأخير
- notes (text, nullable)
- created_by (foreign key to users)
- created_at, updated_at
```

---

### 3. **التوزيع الشهري (Expense Monthly Allocations)** - محدث ⭐

```php
- id
- expense_id (foreign key)
- month (date) - الشهر (YYYY-MM-01)
- amount (decimal) - المبلغ لهذا الشهر
- is_paid (boolean, default: false) - تم الدفع؟
- paid_at (date, nullable) - تاريخ الدفع
- is_transferred (boolean, default: false) - تم الترحيل؟ ⭐ جديد
- transferred_at (date, nullable) - تاريخ الترحيل ⭐ جديد
- notes (text, nullable)
- created_at, updated_at
```

---

## 🔄 منطق الترحيل التلقائي

### **الحالة 1: المصروفات الشهرية الحالية**

**المعيار:**
- `month` = الشهر الحالي
- `is_transferred` = `false`

**العرض:**
- صفحة منفصلة: "المصروفات الشهرية الحالية"
- تعرض فقط المصروفات للشهر الحالي التي لم يتم ترحيلها

---

### **الحالة 2: الترحيل التلقائي**

**السيناريوهات:**

#### أ) ترحيل تلقائي عند انتهاء الشهر
- عند بداية شهر جديد، يتم ترحيل جميع مصروفات الشهر السابق تلقائياً
- `is_transferred` = `true`
- `transferred_at` = تاريخ الترحيل

#### ب) ترحيل يدوي
- المستخدم يمكنه ترحيل مصروف معين يدوياً
- زر "ترحيل" في صفحة المصروفات الشهرية الحالية

#### ج) ترحيل تلقائي عند الدفع
- عند تحديد `is_paid = true`، يتم الترحيل تلقائياً
- `is_transferred` = `true`
- `transferred_at` = تاريخ الدفع

---

### **الحالة 3: قائمة المصروفات الرئيسية**

**المعيار:**
- جميع المصروفات (`expenses`)
- مع فلترة حسب:
  - الفئة
  - الشهر
  - حالة الترحيل
  - حالة الدفع

---

## 📊 الواجهات المقترحة

### 1. **صفحة: المصروفات الشهرية الحالية**

**Route:** `/admin/expenses/current-month`

**المعايير:**
```php
$currentMonth = now()->format('Y-m-01');
$allocations = ExpenseMonthlyAllocation::where('month', $currentMonth)
    ->where('is_transferred', false)
    ->with('expense', 'expense.category')
    ->get();
```

**العرض:**
- جدول يعرض:
  - اسم المصروف
  - الفئة
  - المبلغ
  - حالة الدفع
  - زر "ترحيل"
  - زر "دفع"

---

### 2. **صفحة: قائمة المصروفات الرئيسية**

**Route:** `/admin/expense`

**Backpack CRUD** يعرض:
- جميع المصروفات (`expenses`)
- مع إمكانية:
  - إضافة مصروف جديد
  - تعديل مصروف
  - حذف مصروف
  - عرض التوزيع الشهري

---

### 3. **صفحة: التوزيع الشهري**

**Route:** `/admin/expense/{id}/allocations`

**العرض:**
- جدول يعرض جميع الأشهر للمصروف
- مع إمكانية:
  - تعديل مبلغ شهر معين
  - تحديد حالة الدفع
  - ترحيل شهر معين

---

## 🔧 التنفيذ التقني

### 1. **Command للترحيل التلقائي**

```php
// app/Console/Commands/TransferExpiredExpenses.php
php artisan expenses:transfer-expired
```

**المنطق:**
```php
$lastMonth = now()->subMonth()->format('Y-m-01');
$allocations = ExpenseMonthlyAllocation::where('month', $lastMonth)
    ->where('is_transferred', false)
    ->get();

foreach ($allocations as $allocation) {
    $allocation->update([
        'is_transferred' => true,
        'transferred_at' => now(),
    ]);
}
```

**الجدولة:**
```php
// app/Console/Kernel.php
$schedule->command('expenses:transfer-expired')
    ->monthlyOn(1, '00:00'); // أول يوم من كل شهر
```

---

### 2. **Controller للمصروفات الشهرية الحالية**

```php
// app/Http/Controllers/Admin/CurrentMonthExpensesController.php
public function index()
{
    $currentMonth = now()->format('Y-m-01');
    $allocations = ExpenseMonthlyAllocation::where('month', $currentMonth)
        ->where('is_transferred', false)
        ->with('expense.category')
        ->get();
    
    return view('admin.current_month_expenses', compact('allocations'));
}

public function transfer($id)
{
    $allocation = ExpenseMonthlyAllocation::findOrFail($id);
    $allocation->update([
        'is_transferred' => true,
        'transferred_at' => now(),
    ]);
    
    return redirect()->back()->with('success', 'تم الترحيل بنجاح');
}
```

---

### 3. **Event Listener للترحيل التلقائي عند الدفع**

```php
// app/Listeners/TransferExpenseOnPayment.php
public function handle(ExpensePaid $event)
{
    $event->allocation->update([
        'is_transferred' => true,
        'transferred_at' => now(),
    ]);
}
```

---

## 📝 خطة التنفيذ

### المرحلة 1: الجداول (Migrations)
1. ✅ `create_expense_categories_table`
2. ✅ `create_expenses_table`
3. ✅ `create_expense_monthly_allocations_table` (مع `is_transferred`, `transferred_at`)

### المرحلة 2: Models
1. ✅ `ExpenseCategory`
2. ✅ `Expense`
3. ✅ `ExpenseMonthlyAllocation`

### المرحلة 3: Backpack CRUD
1. ✅ `ExpenseCategoryCrudController`
2. ✅ `ExpenseCrudController`

### المرحلة 4: صفحات مخصصة
1. ✅ `CurrentMonthExpensesController` - المصروفات الشهرية الحالية
2. ✅ View: `current_month_expenses.blade.php`

### المرحلة 5: Command & Scheduler
1. ✅ `TransferExpiredExpenses` Command
2. ✅ جدولة تلقائية

### المرحلة 6: Routes & Menu
1. ✅ Routes للصفحات
2. ✅ إضافة إلى القائمة الجانبية

---

## ✅ الخلاصة

**التصميم النهائي:**
- ✅ 3 جداول: `expense_categories`, `expenses`, `expense_monthly_allocations`
- ✅ حقل `is_transferred` في `expense_monthly_allocations`
- ✅ صفحة "المصروفات الشهرية الحالية" (فقط الشهر الحالي غير المرحل)
- ✅ صفحة "قائمة المصروفات الرئيسية" (جميع المصروفات)
- ✅ ترحيل تلقائي عند انتهاء الشهر
- ✅ ترحيل يدوي
- ✅ ترحيل تلقائي عند الدفع

**الوقت المتوقع:** 3-4 ساعات  
**المخاطر:** منخفضة  
**التوصية:** ✅ المضي قدماً

---

**القرار النهائي:** ✅ موافق - جاهز للتنفيذ
