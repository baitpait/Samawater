# ADR-004: كشف حساب المشترك — ستة مؤشرات فقط

**التاريخ:** 2026-06-01  
**الحالة:** معتمد

---

## السياق

صفحة `/admin/reports/client-balance` كانت تعرض تفصيلاً محاسبياً كاملاً (افتتاحي، مدفوعات، جدول تفصيلي، جدول مشترك). المستخدم طلب **كشف حساب مختصر** للمشترك التشغيلي.

---

## القرار

عرض **ستة مؤشرات** عبر `Client::accountStatementSnapshot()`:

| المؤشر | التعريف |
|--------|---------|
| مجموع المبيعات | فواتير مؤكّدة على ملف الأب |
| مجموع التسليمات | ∑ `required_amount` لعائلة الأب والعناوين |
| مجموع المبيعات والتسليمات | مجموع الحجم (1)+(2) — ليس صافي الدين |
| الرصيد المستحق | `combined_subscriber_debt` (مطابق تقرير الفلاتر) |
| العبوات المتوفرة | `bottle_on_hand_calculated` من `v_clients_delivery_overview` أو `bottle_balance` المخزّن |
| الأمانات | كميات مجمّعة حسب الصنف لأمانات غير مسحوبة على الأب |

لا يُعرض الافتتاحي أو تفصيل المدفوعات في هذه الصفحة (تبقى في لوحة المعاينة و`financialSnapshotForShow`).

---

## العواقب

- ✅ واجهة أوضح للموظف الميداني.
- ⚠️ «مجموع المبيعات والتسليمات» قد يتضمن مسارين مختلفين (فاتورة + تسليم) دون ازدواج محاسبي في «المستحق».
- الرصيد المستحق يبقى معرّفاً في ADR-003.

---

## الملفات

- `app/Models/Client.php` — `accountStatementSnapshot()`
- `app/Http/Controllers/Admin/ClientBalanceReportController.php`
- `resources/views/admin/reports/client_balance.blade.php`
- `resources/views/admin/reports/partials/account_statement_summary.blade.php`
