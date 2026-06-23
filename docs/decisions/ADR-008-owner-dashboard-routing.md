# ADR-008: توجيه لوحة التحكم للمالك ومصدر البيانات

**التاريخ:** 2026-06-01  
**الحالة:** مقبول  
**القرار:** `AdminController::dashboard` يعرض `vendor.backpack.ui.dashboard` للمسؤولين، مع `DashboardService` عبر View Composer

---

## السياق

لوحة التحكم طُوِّرت في `resources/views/vendor/backpack/ui/dashboard.blade.php` مع KPIs ورسوم بيانية، لكن المسار `routes/backpack/custom.php` كان يوجّه المسؤولين إلى `admin.dashboard_admin` (صفحة مؤقتة بروابط فقط). النتيجة: «لم يتم تحديث شي» رغم وجود الكود.

## القرار

1. **`AdminController::dashboard`:** المسؤولون → `vendor.backpack.ui.dashboard`؛ الموزعون فقط → `admin.dashboard_distributor`.
2. **حذف** `resources/views/admin/dashboard_admin.blade.php`.
3. **`AppServiceProvider`:** View Composer على `vendor.backpack.ui.dashboard` يحقن `ownerDashboard` من `DashboardService::buildForOwner()` (لغير الموزعين).
4. **الجمهور:** لوحة المالك للـ Admin/Super Admin فقط.

### ترتيب KPIs الرئيسية (Hero)

1. تسليمات اليوم  
2. كاش اليوم  
3. عهدة الموزعين الآن  
4. عدد المستحقين للتوزيع  

### تنبيهات

- **مخزون منخفض:** أُزيل من الواجهة (يونيو 2026) — الإعداد `config/sama.php` → `inventory_low_stock_threshold` بقي للاستخدام المستقبلي.
- **مصروفات غير مدفوعة:** تبقى في شريط التنبيه عند وجودها.

### إصلاح Blade

`@if ($isDistributor) … @else …` كان ناقصاً `@endif` → `ParseError: unexpected end of file`. أُغلق الشرط قبل `@endsection`.

## البدائل المرفوضة

| البديل | السبب |
|--------|--------|
| الإبقاء على `dashboard_admin` | ازدواجية وارتباك النشر |
| منطق KPIs داخل Controller | يخالف فصل المسؤوليات؛ صعب الاختبار |
| استبدال الرسوم بالكامل | المطلوب إصلاح البيانات وليس إعادة بناء الواجهة |

## العواقب

- اختبارات: `DashboardServiceTest`, `AdminDashboardViewTest`
- بعد `git pull` على السيرفر: `view:clear` إلزامي عند تغيير Blade
- الرسوم البيانية تُحمَّل فقط لغير الموزع (`@section after_scripts`)

---
