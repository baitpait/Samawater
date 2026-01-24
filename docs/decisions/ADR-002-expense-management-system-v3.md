# ADR-002-v3: نظام إدارة المصروفات - التصميم النهائي

**التاريخ:** 2025-01-25  
**الحالة:** التصميم النهائي  
**القرار:** ✅ موافق - جاهز للتنفيذ

---

## 📋 التوضيح المهم

### **السيناريو:**
- **المصروف:** ثلاجة 900 شيكل (تم الدفع بالفعل - دفعة واحدة)
- **الهدف:** توزيع المصروف على الفترات المالية للتقارير
- **التوزيع:** 9 أشهر × 100 شيكل (للتقارير المالية فقط)

### **الفهم الصحيح:**
- ✅ المصروف **تم دفعه بالفعل** عند الإنشاء
- ✅ التوزيع الشهري هو **للتقارير المالية فقط**
- ✅ كل شهر يظهر 100 شيكل في التقارير
- ✅ عند انتهاء الشهر، يتم ترحيله للقائمة الرئيسية

---

## 🎯 التصميم المحدث

### 1. **فئات المصروفات (Expense Categories)**

```php
- id
- name (string) - اسم الفئة
- description (text, nullable)
- is_active (boolean, default: true)
- created_at, updated_at
```

---

### 2. **المصروفات (Expenses)**

```php
- id
- expense_category_id (foreign key)
- name (string) - اسم المصروف (مثل: "ثلاجة")
- total_amount (decimal) - المبلغ الإجمالي المدفوع (900)
- number_of_months (integer) - عدد الأشهر للتوزيع (9)
- monthly_amount (decimal) - المبلغ الشهري (100) - محسوب تلقائياً
- start_month (date) - الشهر الأول للتوزيع
- end_month (date) - الشهر الأخير للتوزيع
- payment_date (date) - تاريخ الدفع الفعلي ⭐ جديد
- notes (text, nullable)
- created_by (foreign key to users)
- created_at, updated_at
```

**ملاحظة:** `payment_date` = تاريخ الدفع الفعلي (المصروف دُفع بالفعل)

---

### 3. **التوزيع الشهري (Expense Monthly Allocations)** - محدث ⭐

```php
- id
- expense_id (foreign key)
- month (date) - الشهر (YYYY-MM-01)
- amount (decimal) - المبلغ لهذا الشهر (100)
- is_transferred (boolean, default: false) - تم الترحيل؟ ⭐
- transferred_at (date, nullable) - تاريخ الترحيل ⭐
- notes (text, nullable)
- created_at, updated_at
```

**إزالة:** `is_paid`, `paid_at` (لأن المصروف دُفع بالفعل عند الإنشاء)

---

## 🔄 منطق الترحيل

### **المصروفات الشهرية الحالية**

**المعيار:**
```php
$currentMonth = now()->format('Y-m-01');
$allocations = ExpenseMonthlyAllocation::where('month', $currentMonth)
    ->where('is_transferred', false)
    ->with('expense.category')
    ->get();
```

**العرض:**
- جدول يعرض:
  - اسم المصروف
  - الفئة
  - المبلغ (100 شيكل)
  - الشهر
  - زر "ترحيل"

---

### **الترحيل التلقائي**

#### أ) ترحيل تلقائي عند انتهاء الشهر
```php
// Command: expenses:transfer-expired
$lastMonth = now()->subMonth()->format('Y-m-01');
$allocations = ExpenseMonthlyAllocation::where('month', $lastMonth)
    ->where('is_transferred', false)
    ->update([
        'is_transferred' => true,
        'transferred_at' => now(),
    ]);
```

#### ب) ترحيل يدوي
- زر "ترحيل" في صفحة المصروفات الشهرية الحالية
- يحدث `is_transferred = true`

---

### **قائمة المصروفات الرئيسية**

**المعيار:**
- جميع المصروفات (`expenses`)
- مع فلترة حسب:
  - الفئة
  - الشهر
  - حالة الترحيل

---

## 📊 التقارير المالية

### **تقرير المصروفات الشهرية**

```php
// مجموع المصروفات لشهر معين
$month = '2025-01-01';
$total = ExpenseMonthlyAllocation::where('month', $month)
    ->sum('amount');
```

**مثال:**
- يناير 2025: 100 شيكل (من مصروف الثلاجة)
- فبراير 2025: 100 شيكل (من مصروف الثلاجة)
- ... حتى سبتمبر 2025

---

## 🔧 التنفيذ التقني

### 1. **إنشاء مصروف جديد**

```php
// عند إنشاء مصروف
$expense = Expense::create([
    'name' => 'ثلاجة',
    'expense_category_id' => 1,
    'total_amount' => 900,
    'number_of_months' => 9,
    'start_month' => '2025-01-01',
    'payment_date' => '2025-01-15', // تاريخ الدفع الفعلي
]);

// حساب المبلغ الشهري
$monthlyAmount = $expense->total_amount / $expense->number_of_months; // 100

// حساب الشهر الأخير
$endMonth = Carbon::parse($expense->start_month)
    ->addMonths($expense->number_of_months - 1)
    ->format('Y-m-01');

$expense->update([
    'monthly_amount' => $monthlyAmount,
    'end_month' => $endMonth,
]);

// إنشاء سجلات للأشهر
for ($i = 0; $i < $expense->number_of_months; $i++) {
    ExpenseMonthlyAllocation::create([
        'expense_id' => $expense->id,
        'month' => Carbon::parse($expense->start_month)
            ->addMonths($i)
            ->format('Y-m-01'),
        'amount' => $monthlyAmount,
        'is_transferred' => false,
    ]);
}
```

---

### 2. **صفحة المصروفات الشهرية الحالية**

```php
// app/Http/Controllers/Admin/CurrentMonthExpensesController.php
public function index()
{
    $currentMonth = now()->format('Y-m-01');
    
    $allocations = ExpenseMonthlyAllocation::where('month', $currentMonth)
        ->where('is_transferred', false)
        ->with(['expense.category'])
        ->orderBy('expense_id')
        ->get();
    
    $totalAmount = $allocations->sum('amount');
    
    return view('admin.expenses.current_month', compact('allocations', 'totalAmount', 'currentMonth'));
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

public function transferAll()
{
    $currentMonth = now()->format('Y-m-01');
    ExpenseMonthlyAllocation::where('month', $currentMonth)
        ->where('is_transferred', false)
        ->update([
            'is_transferred' => true,
            'transferred_at' => now(),
        ]);
    
    return redirect()->back()->with('success', 'تم ترحيل جميع المصروفات بنجاح');
}
```

---

### 3. **Command للترحيل التلقائي**

```php
// app/Console/Commands/TransferExpiredExpenses.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExpenseMonthlyAllocation;
use Carbon\Carbon;

class TransferExpiredExpenses extends Command
{
    protected $signature = 'expenses:transfer-expired';
    protected $description = 'ترحيل مصروفات الشهر السابق تلقائياً';

    public function handle()
    {
        $lastMonth = Carbon::now()->subMonth()->format('Y-m-01');
        
        $count = ExpenseMonthlyAllocation::where('month', $lastMonth)
            ->where('is_transferred', false)
            ->update([
                'is_transferred' => true,
                'transferred_at' => now(),
            ]);
        
        $this->info("تم ترحيل {$count} مصروف من شهر {$lastMonth}");
    }
}
```

**الجدولة:**
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('expenses:transfer-expired')
        ->monthlyOn(1, '00:00'); // أول يوم من كل شهر
}
```

---

## ✅ الخلاصة النهائية

**التصميم:**
- ✅ 3 جداول: `expense_categories`, `expenses`, `expense_monthly_allocations`
- ✅ المصروف **دُفع بالفعل** عند الإنشاء (`payment_date`)
- ✅ التوزيع الشهري **للتقارير المالية فقط**
- ✅ حقل `is_transferred` للترحيل (بدون `is_paid`)
- ✅ صفحة "المصروفات الشهرية الحالية" (الشهر الحالي غير المرحل)
- ✅ صفحة "قائمة المصروفات الرئيسية" (جميع المصروفات)
- ✅ ترحيل تلقائي عند انتهاء الشهر
- ✅ ترحيل يدوي

**الوقت المتوقع:** 3-4 ساعات  
**المخاطر:** منخفضة  
**التوصية:** ✅ جاهز للتنفيذ

---

**القرار النهائي:** ✅ موافق - جاهز للتنفيذ
