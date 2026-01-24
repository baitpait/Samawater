# 📋 الصفحات المفقودة من القائمة الجانبية

## 🔍 **التحليل:**

تم مراجعة جميع الـ routes في `routes/backpack/custom.php` ومقارنتها مع القائمة الجانبية في `menu_items.blade.php`.

---

## ❌ **الصفحات المفقودة:**

### 1. **المصروفات الشهرية الحالية**
- **Route:** `expenses.current-month`
- **URL:** `/admin/expenses/current-month`
- **Controller:** `CurrentMonthExpensesController`
- **الوصف:** عرض المصروفات الشهرية الحالية مع إمكانية نقلها للأشهر القادمة
- **التصنيف المقترح:** المالية والمصروفات (بعد "المصروفات")

### 2. **تقارير مع فلاتر**
- **Route:** `reports.filters`
- **URL:** `/admin/reports/filters`
- **Controller:** `ReportFilterController`
- **الوصف:** تقارير العملاء مع فلاتر متقدمة (المدينة، نوع العميل، حالة الاشتراك، إلخ)
- **التصنيف المقترح:** التقارير (بعد "التقارير الإحصائية")

### 3. **تقرير العملاء المستحقين المتقدم**
- **Route:** `reports.clients_due_advanced`
- **URL:** `/admin/reports/clients-due-advanced`
- **Controller:** `ClientsDueViewController`
- **الوصف:** تقرير متقدم للعملاء المستحقين مع تفاصيل أكثر
- **التصنيف المقترح:** التقارير (بعد "التقارير الإحصائية")

### 4. **العملاء المستحقين (CRUD)**
- **Route:** `clients-due` (CRUD)
- **URL:** `/admin/clients-due`
- **Controller:** `VClientsDueByTypeDaysIdsCrudController`
- **الوصف:** قائمة العملاء المستحقين (من view في قاعدة البيانات)
- **التصنيف المقترح:** التقارير أو العملاء

### 5. **تقرير العميل**
- **Route:** `client.report`
- **URL:** `/admin/client-report`
- **Controller:** `ClientReportController`
- **الوصف:** تقرير مفصل عن عميل معين
- **التصنيف المقترح:** التقارير أو العملاء

---

## 📝 **ملاحظات:**

### صفحات قد تكون موجودة في صفحات أخرى:
1. **عملاء الموزع** (`distributor.clients`) - قد يكون في صفحة الموزع نفسه
2. **التقرير المالي للموزع** (`distributor.financial-report`) - قد يكون في صفحة الموزع نفسه
3. **نتائج التقارير** (`reports.results`) - قد يكون صفحة داخلية (نتائج البحث)

### صفحات Export (تصدير):
- هذه الصفحات عادة تكون أزرار داخل الصفحات الرئيسية وليست صفحات مستقلة
- `reports.advanced.export.excel`
- `reports.advanced.export.pdf`
- `reports.clients_due_advanced.export.excel`
- `reports.clients_due_advanced.export.pdf`
- `reports.clients_delivery_overview.export.excel`
- `reports.clients_delivery_overview.export.pdf`
- `client.report.pdf`

---

## ✅ **التوصيات:**

### يجب إضافتها للقائمة:
1. ✅ **المصروفات الشهرية الحالية** - مهمة جداً
2. ✅ **تقارير مع فلاتر** - مفيدة للبحث المتقدم
3. ✅ **تقرير العملاء المستحقين المتقدم** - مفيد للتقارير

### اختيارية (حسب الحاجة):
4. ⚠️ **العملاء المستحقين (CRUD)** - قد يكون مكرر مع "تقرير العملاء المستحقين المتقدم"
5. ⚠️ **تقرير العميل** - قد يكون مكرر مع صفحات أخرى

---

**تاريخ المراجعة:** 2026-01-12
