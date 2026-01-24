# ADR-002: نظام إدارة المصروفات مع التوزيع الشهري

**التاريخ:** 2025-01-25  
**الحالة:** تحت المناقشة  
**القرار:** قيد المراجعة

---

## 📋 السياق (Context)

- **المتطلب:** إضافة نظام لإدارة المصروفات مع إمكانية توزيع المصروف على عدة أشهر
- **مثال:** مصروف ثلاجة 900 شيكل، توزيع على 9 أشهر (100 شيكل/شهر)
- **الهدف:** تتبع المصروفات وتوزيعها على الفترات المالية

---

## 🔍 تحليل المتطلبات

### 1. **فئات المصروفات (Expense Categories)**

**الوصف:**
- جدول يحتوي على فئات المصروفات (مثل: صيانة، كهرباء، إيجار، إلخ)
- كل فئة لها: `id`, `name`, `description`, `created_at`, `updated_at`

**الحقول المقترحة:**
```php
- id (bigint, primary key)
- name (string, required) - اسم الفئة
- description (text, nullable) - وصف الفئة
- is_active (boolean, default: true) - نشط/غير نشط
- created_at, updated_at
```

---

### 2. **المصروفات (Expenses)**

**الوصف:**
- جدول يحتوي على المصروفات
- كل مصروف مربوط بفئة
- يحتوي على معلومات التوزيع الشهري

**الحقول المقترحة:**
```php
- id (bigint, primary key)
- expense_category_id (foreign key) - الفئة
- name (string, required) - اسم المصروف
- total_amount (decimal) - المبلغ الإجمالي
- number_of_months (integer) - عدد الأشهر للتوزيع
- monthly_amount (decimal) - المبلغ الشهري (محسوب تلقائياً)
- start_month (date) - الشهر الأول للتوزيع
- end_month (date) - الشهر الأخير للتوزيع
- notes (text, nullable) - ملاحظات
- created_by (foreign key to users) - من أنشأ السجل
- created_at, updated_at
```

---

### 3. **توزيع المصروفات الشهرية (Expense Monthly Allocations)**

**الوصف:**
- جدول يحتوي على توزيع كل مصروف على الأشهر
- كل شهر = سجل منفصل

**الحقول المقترحة:**
```php
- id (bigint, primary key)
- expense_id (foreign key) - المصروف
- month (date) - الشهر (YYYY-MM-01)
- amount (decimal) - المبلغ لهذا الشهر
- is_paid (boolean, default: false) - تم الدفع؟
- paid_at (date, nullable) - تاريخ الدفع
- notes (text, nullable) - ملاحظات
- created_at, updated_at
```

---

## 🎯 خيارات التصميم

### **الخيار 1: جدولان (Expenses + Monthly Allocations)** ⭐ **مستحسن**

**الوصف:**
- جدول `expenses` للمصروفات الأساسية
- جدول `expense_monthly_allocations` لتوزيع كل شهر

**المزايا:**
- ✅ مرونة عالية - يمكن تعديل مبلغ شهر معين
- ✅ تتبع دقيق - كل شهر له سجل منفصل
- ✅ يمكن إضافة معلومات إضافية لكل شهر (تاريخ دفع، ملاحظات)
- ✅ سهولة في التقارير (مجموع المصروفات لشهر معين)

**العيوب:**
- ⚠️ عدد سجلات أكبر (مصروف 12 شهر = 12 سجل)

---

### **الخيار 2: جدول واحد (Expenses فقط)**

**الوصف:**
- جدول `expenses` فقط مع حقول: `total_amount`, `number_of_months`, `monthly_amount`

**المزايا:**
- ✅ بسيط
- ✅ عدد سجلات أقل

**العيوب:**
- ❌ لا يمكن تتبع كل شهر بشكل منفصل
- ❌ لا يمكن تعديل مبلغ شهر معين
- ❌ صعوبة في التقارير الشهرية

---

### **الخيار 3: جدول واحد مع JSON**

**الوصف:**
- جدول `expenses` مع حقل JSON يحتوي على توزيع الأشهر

**المزايا:**
- ✅ مرونة في التخزين

**العيوب:**
- ❌ صعوبة في الاستعلامات (JSON في MySQL)
- ❌ لا يمكن عمل Foreign Keys
- ❌ صعوبة في التقارير

---

## ✅ التوصية النهائية

### **الخيار المختار: الخيار 1 - جدولان** ⭐

**السبب:**
1. **المرونة:** يمكن تعديل مبلغ شهر معين أو إضافة ملاحظات
2. **التقارير:** سهولة في حساب مجموع المصروفات لشهر معين
3. **التتبع:** يمكن تتبع حالة الدفع لكل شهر
4. **القابلية للتوسع:** يمكن إضافة حقول مستقبلية (مثل: فاتورة، إلخ)

---

## 📝 خطة التنفيذ

### المرحلة 1: إنشاء الجداول (Migrations)
1. `create_expense_categories_table`
2. `create_expenses_table`
3. `create_expense_monthly_allocations_table`

### المرحلة 2: إنشاء Models
1. `ExpenseCategory` Model
2. `Expense` Model
3. `ExpenseMonthlyAllocation` Model

### المرحلة 3: إنشاء Backpack CRUD Controllers
1. `ExpenseCategoryCrudController`
2. `ExpenseCrudController` (مع منطق التوزيع التلقائي)

### المرحلة 4: إضافة Routes
1. Routes للـ CRUD operations
2. Route خاص لإنشاء المصروف مع التوزيع التلقائي

### المرحلة 5: إضافة إلى القائمة الجانبية
1. إضافة "فئات المصروفات" في القائمة
2. إضافة "المصروفات" في القائمة

---

## 🔧 التفاصيل التقنية

### منطق التوزيع التلقائي

```php
// عند إنشاء مصروف جديد
$expense = Expense::create([
    'name' => 'ثلاجة',
    'total_amount' => 900,
    'number_of_months' => 9,
    'start_month' => '2025-01-01',
]);

// حساب المبلغ الشهري
$monthlyAmount = $expense->total_amount / $expense->number_of_months; // 100

// إنشاء سجلات للأشهر
for ($i = 0; $i < $expense->number_of_months; $i++) {
    ExpenseMonthlyAllocation::create([
        'expense_id' => $expense->id,
        'month' => Carbon::parse($expense->start_month)->addMonths($i)->format('Y-m-01'),
        'amount' => $monthlyAmount,
        'is_paid' => false,
    ]);
}
```

---

## ⚠️ اعتبارات إضافية

### 1. **التقارير**
- تقرير المصروفات الشهرية
- تقرير المصروفات حسب الفئة
- تقرير المصروفات المدفوعة/غير المدفوعة

### 2. **الصلاحيات**
- من يمكنه إضافة/تعديل/حذف المصروفات؟
- هل يحتاج صلاحيات خاصة؟

### 3. **التحقق من البيانات**
- التأكد من أن `number_of_months` > 0
- التأكد من أن `total_amount` > 0
- التأكد من أن `start_month` تاريخ صحيح

---

## 📊 الخلاصة

**التصميم المقترح:**
- ✅ 3 جداول: `expense_categories`, `expenses`, `expense_monthly_allocations`
- ✅ توزيع تلقائي عند إنشاء المصروف
- ✅ تتبع دقيق لكل شهر
- ✅ مرونة في التعديل

**الوقت المتوقع:** 2-3 ساعات  
**المخاطر:** منخفضة  
**التوصية:** ✅ المضي قدماً مع الخيار 1

---

**القرار النهائي:** قيد المناقشة
