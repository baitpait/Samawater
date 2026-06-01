# ADR-006: فواتير مشتريات الموردين وزيادة المخزون

**التاريخ:** 2026-06-01  
**الحالة:** مقبول — مُنفَّذ  
**السياق:** الحاجة لتسجيل مشتريات متعددة الأصناف من مورد مع إدخال تلقائي للمخزون، منفصلة عن فواتير مبيعات المشتركين وعن «مصروف + صنف واحد».

## القرار

- جداول جديدة: `purchase_invoices`, `purchase_invoice_items`
- عند `status = confirmed`: `InventoryItem::addQuantity()` لكل بند
- عند الإلغاء/التراجع: `InventoryItem::subtractQuantity()`
- ربط الدفع: `vendor_payments.purchase_invoice_id`
- رصيد المورد: يشمل `SUM(purchase_invoices.total_amount)` للفواتير **المؤكدة** بالإضافة إلى `expenses`
- Kill switch: `config('features.purchase_invoices')` / `FEATURE_PURCHASE_INVOICES`

## البدائل المرفوضة

1. **توسيع `expenses` فقط** — يخلط التوزيع الشهري مع فواتير مخزون متعددة البنود.
2. **ربط `invoice_items` للموردين** — جدول المبيعات مربوط بـ `client_id` ولا يناسب الموردين.

## العواقب

- استخدم فواتير المشتريات لمشتريات المخزون؛ المصروفات التشغيلية تبقى في `expenses`.
- تجنب تسجيل نفس الشراء مرتين (مصروف مخزون + فاتورة مشتريات).
- Plan B للمخزون: الإبقاء على تعديل يدوي في `inventory_items` عند تعطيل الميزة.
