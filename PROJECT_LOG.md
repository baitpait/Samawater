# 📝 سجل المشروع - Project Log

---

## [2026-06-01] — لوحة المالك، أصحاب المصروف، تقارير القوارير، النشر على السيرفر

- **الهدف:** إكمال ميزات الإدارة المطلوبة (لوحة تحكم فعلية، مصروفات بأصحاب، رصيد قوارير، مخزون)، إصلاح أخطاء النشر على `server1`، وتوثيق مسار Git/Node للسحب الآمن.

- **التغييرات التقنية:**

  ### أ) لوحة التحكم (`/admin/dashboard`)
  - **`AdminController`:** المسؤولون → `vendor.backpack.ui.dashboard` بدلاً من `dashboard_admin` المحذوفة.
  - **`DashboardService`:** KPIs (تسليمات اليوم، كاش اليوم، عهدة، مستحقات)، رسوم بيانية، جدول تسليمات اليوم.
  - **`AppServiceProvider`:** View Composer يحقن `ownerDashboard`.
  - **إصلاح `ParseError`:** إغلاق `@if ($isDistributor)` بـ `@endif` في Blade.
  - **إزالة تنبيه مخزون منخفض** من الواجهة (يبقى تنبيه المصروفات غير المدفوعة فقط).
  - **ADR:** `docs/decisions/ADR-008-owner-dashboard-routing.md`

  ### ب) أصحاب المصروف (Expense Beneficiaries)
  - جداول: `expense_beneficiaries` + `expense_beneficiary_id` إلزامي على `expenses`.
  - الهجرة الثانية: `beneficiary_type` → `expense_category_id` (فئات من `expense_categories`).
  - عرض: `الفئة ( صاحب المصروف )` في القائمة، التصدير Excel/PDF، الفلاتر.
  - ربط تلقائي بـ `vendors` عند تطابق الاسم (`ExpenseBeneficiaryVendorLinkService`).
  - CRUD: `/admin/expense-beneficiary`
  - **ADR:** `docs/decisions/ADR-007-expense-beneficiaries.md`

  ### ج) تقارير رصيد القوارير
  - **`ClientBottleBalanceService`:** رصيد عائلة المشترك (أب + أبناء) من التسليمات.
  - **تقرير العميل:** لوحة «رصيد القوارير عنده» في رأس `client_report_page`.
  - **التقارير المتقدمة:** جدول + بطاقة ملخص لكل العملاء المفلترين.

  ### د) المخزون
  - عمود **المجموع** في `/admin/inventory-item`.
  - توحيد شارة الكمية مع عمود الأمانات.
  - `InventoryItem::activeDepositTotalsByItemName()` للمجاميع.

  ### هـ) دفتر مالي موحّد
  - **`UnifiedFinancialLedgerService`:** سطر التفصيل يعرض اسم صاحب المصروف بدلاً من `—`.

  ### و) تحسينات CRUD وواجهة
  - **`ClientSelectFieldService`:** بحث Select2 موحّد للمشتركين.
  - تحديثات على: مدفوعات، فواتير، تسليمات، أمانات، نظرة عامة التسليمات.
  - **`config/sama.php`:** `inventory_low_stock_threshold` (افتراضي 50).

- **الاختبارات الجديدة/المحدّثة:**
  `DashboardServiceTest`, `AdminDashboardViewTest`, `ExpenseBeneficiaryTest`, `ClientBottleBalanceServiceTest`, `InventoryItemActiveDepositTotalsTest`, `ClientSelectFieldServiceTest`, `ClientDeliveryReportServiceTest`, `ClientsDeliveryOverviewDateFilterTest`, `ClientsDeliveryOverviewClientDetailTest`, `ClientPaymentDeleteSyncsDeliveryTest`, `InvoiceDestroyDeletesAutoPaymentTest`, `UnifiedFinancialLedgerExcludesWithdrawsTest`, وغيرها.

- **Git والنشر:**
  - **كوميت رئيسي:** `8b3b54e` — `feat(admin): owner dashboard, expense beneficiaries, and reporting`
  - **المستودع:** https://github.com/baitpait/Samawater — **تحوّل إلى عام (Public)** لتسهيل `git pull` بدون token.
  - **مشاكل السيرفر الموثّقة:**
    1. HTTPS + كلمة مرور → مرفوض من GitHub.
    2. Deploy Key على repo `Doooor` → `Repository not found` لـ Samawater (مفتاح لكل repo).
    3. `npm run build` + Node قديم → `crypto.getRandomValues is not a function` → NVM + Node 20.
    4. `Nothing to migrate` عند فشل `git pull` — الكود لم يُسحَب.
  - **دليل النشر:** `docs/DEPLOYMENT.md`

- **التنبيه (يدوي على السيرفر بعد كل `pull` ناجح):**
  ```bash
  cd /home/sarfesak/public_html/sama
  git pull origin main
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan optimize:clear
  php artisan view:clear
  source ~/.nvm/nvm.sh && nvm use 20 && npm install && npm run build
  ```

- **Plan B (بدائل الموردين):**
  - Git: مستودع خاص + Deploy Key أو PAT بدلاً من Public.
  - Node: بناء `npm run build` محلياً ورفع مجلد `public/build` يدوياً (غير موصى به طويل الأمد).

---

## [2026-05-24] — استمرارية تشغيل: دفع الرئيسية، عنوان GitHub، هجرات إصلاح Elyaa، وتجاهل Excel

- **الهدف:** توحيد ممرّ النشر بين الأجهزة/SaaS بعد دمج كل التحديثات، وتقليل تكرار أخطاء الجداول/الأعمدة الناقصة عند قواعد `eliyaa_local`/الاستيراد، مع عدم ضياع الـ remote الصحيح بعد إعلان GitHub نقل الاسم إلى `baitpait`.

- **التغييرات:**
  - **استرداد مخطّط:** مجموعة هجرات إصلاح (تسليمات، فواتير وأصنافها، مدفوعات مشتركين وموردين، متابعة `vendor_payments`، سلسلة مصروفات+فئات + `vendors` إن غاب، `clients.parent_id`، `client_deposits` + أصنافها) مع FK متوافق INT/BIGINT حسب قراءة نوع عمود المرجع.
  - **أمان المسارات:** تم إحكام بعض المسارات خارج مجموعة Backpack عبر وسيط `admin` وتوحيد صفحة التشخيص تحت مسار Backpack.
  - **Git الشبكي:** `origin` الموصوف للمستودع: `https://github.com/baitpait/Samawater.git` (يجب اعتماده في كل جهات العمل لتفادي forks قديمة).
  - **`.gitignore`:** تجاهل `/*.xlsx` لتفادي إدراج مصنفات Excel تشغيلية من الجذر بالخطأ.

- **تصحيح نشر الإنتاج (2026-05-24):** إزالة المسار المطلق `@/usr/local/apps/php83/bin/php` من سكربتات Composer واستخدام `@php` القياسي حتى لا يُفشَل `package:discover`; إزالة `config.cache-dir` الموجِّه لمشروع `eliyaa` بالخطأ.

- **التنبيه (يدوي بعد كل `pull` أو نسخة جديدة):**
  ```bash
  php artisan migrate --no-interaction
  php artisan optimize:clear
  npm run build   # إن وُجدت بنية واجهة وجرى تعديل السكربتات؛ يتطلّب Node ≥ 18
  ```
  ومراجعة `docs/WIPE_AND_IMPORT_BACKUP.md` قبل مسح أو استبدال الإنتاج. لا تتم طباعة كلمات السر أو بيانات PII في السجل.

---

## [2026-04-28] - الرصيد/الدين المركّب، استعادة قاعدة البيانات، وتوثيق التشغيل

- **الهدف:**
  - إنهاء ظهور «رصيد سالب كاذب» لمشتركين لديهم تعادُل على أسطر التسليم (بيع بالتسليم) دون مطابقة محاسبة الفوترة المركّزة.
  - توثيق وإجراءات استيراد النسخ الاحتياطية، واستعادة بيانات المشتركين عند ضياع القاعدة.
  - تمكين تسجيل دخول المسؤول بعد الاستيراد دون اعتماد كلمة المرور المحفّوظة ضمن الهاش القديم غير الموثَّق علناً.

- **التغييرات التقنية (رمز القرار المعماري: راجع `docs/decisions/ADR-003-subscriber-balance-vs-delivery-payments.md`):**
  - **`App\Models\ClientPayment`:** إضافة علاقة `linkedDelivery()` (تمثّل أن التسليم سجّل هذه الدفعة كمدفوع على سطر البيع).
  - **`App\Models\Client`:** معادلة `balance` أصبحت تطرح من (افتتاحي + فواتير مؤكّدة) فقط **المدفوعات غير المرتبطة بتسليم** عبر `standalonePaymentsTotalFor()`. Accessor `total_paid_amount` أبقى إجمالي كل المدفوعات في الجدول (شفافية).
  - **`financialSnapshotForShow()`:** حقول إضافية: `payments_total`, `payments_from_deliveries`, `payments_standalone`, وتحديث وصف عمود الرصيد في الواجهة.
  - **`resources/views/admin/clients/show_financial_panel.blade.php`:** فصل السطور لتفسير ما يخصّ الفاتورة مقابل مدفوعات التسليم.
  - **`ClientBalanceReportController`:** حساب الرصيد يطابق المعادلة الجديدة.
  - **اختبارات:** `tests/Feature/ClientBalanceExcludesDeliveryBackedPaymentsTest.php` (ثلاث حالات أساسية).

- **البيانات وقاعدة التشغيل المحلية (أمثلة نفِّذَت على هذا المشروع):**
  - **استيراد كامل mysqldump (الأصلي):** `~/Downloads/eliyaa_backup_2026-04-28_15-16-54.sql` — يحوي هيكلاً وبيانات (مثل **260** مشتركًا و**513** تسليمًا عند النسخة الموثَّقة)، يُرفع بعد `DROP/CREATE DATABASE` ثم `< backup.sql`.
  - **نسخ «بيانات فقط» داخل المشروع:** مثل `database/scripts/eliyaa_backup_2026-04-28_data_import.sql` تتطلّب جداولاً وفق مخطّط Laravel الحالي؛ احتيج لإزالة مؤقتة لعمد `for_future_obligation` ثم إعادته، وتصحيح إدراج `vendors` عند تعارض ترتيب الأعمدة؛ **ملف الجذر `database_eliyaa.sql` قديم ولا يشمل بعض الجداول التشغيلية** (لا يعتمد وحده لتجربة تشغيل كاملة).
  - **بعد أي استيراد كامل أو جزئي:** `php artisan migrate --force` لاستكمال أي ترحيلات أحدث من النسخة، ثم `php artisan optimize:clear`.

- **المصادقة والمسؤولين (بدون طباعة كلمة سر في الملفات أو السجل الدائم):**
  - تسجيل الدخول عبر Backpack: حقول الموازع الهاتفيّة؛ المسؤول عادةً بالبريد `email`.
  - **استعادة دخول المسؤول:** `php artisan sama:repair-admin-login sama@baitpait.com --force` (كلمة مرور جديدة ≥ 8 أحرف، لا تُلصق في الوثائق).
  - **حساب تجريبي افتراضي من السيدر (إذا شُغِّلَ):** `AdminLoginRepairSeeder` يعرّض `admin@sama.test` — راجع تعريف السيدر؛ لا تستخدم في إنتاج.
  - **Plan B خارج التطبيق:** نسخ MySQL منتظمة من الخادم + تخزين آمن وفصل صلاحيات `.env`.

- **التنبيهات:**
  - لا ترفع إلى Git حقول حساسة (كلمة المرور الفعلية، توكن SSH، نسخ DB كاملة حاوية معلومات شخصية خارج سياسات الخصوصية).
  - عند ظهور «لا مشتركين» بعد استيراد: تأكّد أن الملف كان **dump كامل** وليس جزءًا فاشلاً؛ راقب عدد أسطر `INSERT INTO clients` في المصدر قبل الاستيراد.
  - `docs/WIPE_AND_IMPORT_BACKUP.md` لا يزال مرجعاً لمسح الجداول واستبدال القاعدة على السيرفر.

- **ملفات مرتبطة:** انظر أيضاً قرار المعمارية التفصيلي أعلاه؛ `database/scripts/sync_roles_and_admin_from_eliyaa_backup_2026-04-28.sql` (أدوار + تحديث هاش لمستخدم إن وجد)، `docs/WIPE_AND_IMPORT_BACKUP.md`.

---

## [2026-01-27] - إصلاح Pagination على السيرفر + إنهاء الجلسة

- **الهدف:** إصلاح خطأ `View [vendor.pagination.modern] not found` على sama.baitpait.space وإنهاء جلسة التطوير موثّقة.
- **التغييرات:**
  - استبدال `vendor.pagination.modern` بـ `pagination::bootstrap-4` في: `reports/filters.blade.php`، `delivery_list.blade.php`، `reports/clients_delivery_overview.blade.php` (القالب modern لم يكن مرفوعاً على الريبو فالسيرفر لا يجده).
  - توثيق أوامر السيرفر: `git checkout -- server-setup.sh` ثم `git pull origin main` ثم `view:clear` و`cache:clear`.
- **الملفات المعدلة:** `resources/views/admin/reports/filters.blade.php`, `resources/views/admin/delivery_list.blade.php`, `resources/views/admin/reports/clients_delivery_overview.blade.php`.
- **إنهاء الجلسة:** جميع تعديلات الجلسة (قوائم CRUD، فلاتر، مجاميع، هوية بصرية، تذييل، pagination) موثّقة أعلاه ومرفوعة على GitHub. السيرفر يُحدَّث عبر `git pull` ثم أوامر الـ artisan حسب الحاجة.

---

## [2026-01-27] - تحسينات قوائم CRUD، الفلاتر، المجاميع، والهوية البصرية (جلسة توثيق)

- **الهدف:** توحيد تجربة قوائم المدير (أمانات، مصروفات، مدفوعات الموردين، المخزون، المدن)، إضافة فلاتر ومجاميع، وإصلاح التكرار والتمرير والتذييل.
- **التغييرات:**

  - **أمانات المشتركين (client-deposit):**
    - إزالة أعمدة: تاريخ السحب، الحالة، الملاحظات من جدول القائمة.
    - توسيع عمود «الأصناف» (`min-width: 300px`).
  - **أزرار الإجراءات في جداول CRUD:**
    - إخفاء نصوص (معاينة، تعديل، حذف) وإظهار الأيقونات فقط عبر CSS في `list.blade.php`.
    - ترتيب الأزرار بدون فراغات (flex, gap: 0) وإزالة الـ margin بينها.
  - **جدول CRUD العام:**
    - لف الجدول بـ `div.crud-table-scroll-x` مع `overflow-x: auto` لسكرول أفقي عند زيادة عرض الجدول.
  - **القائمة الجانبية والتمرير:**
    - إلغاء حفظ/استعادة موضع التمرير عند التنقل؛ تحميل أي صفحة من القائمة يبدأ من أعلى الصفحة (`scrollTo(0,0)` في `load`).
    - إزالة `saveScrollPosition()` وكل استدعاءاتها من `menu_items.blade.php`.
  - **المصروفات (expense):**
    - إضافة `identifiableAttribute()` في نموذج `Vendor` لتفادي خطأ «no columns / identifiableAttribute».
    - إنشاء `expense_filters.blade.php` (فئة، مورد، حالة الدفع، من/إلى تاريخ الدفع) وربطها في `list.blade.php` و`ExpenseCrudController` عبر `addClause`.
  - **قاعدة البيانات:**
    - هجرات تأكد وجود الجداول: `2026_01_28_120000_ensure_vendors_table_exists.php`، `2026_01_28_120001_ensure_vendor_payments_table_exists.php` لإنشاء `vendors` و`vendor_payments` إن لم تكونا موجودتين.
  - **مدفوعات الموردين (vendor-payment):**
    - إنشاء `vendor_payment_filters.blade.php` (مورد، طريقة الدفع، من/إلى تاريخ) وربطها في القائمة والكونترولر.
  - **المخزون (inventory-item):**
    - إزالة تكرار عمود الإجراءات: إزالة أزرار السطر في `setup()` بعد `parent::setup()`، وعدم إضافة عمود الإجراءات الافتراضي عند وجود عمود مخصص باسم `actions` في `list.blade.php`.
    - توحيد الهوية البصرية: أيقونة المستودع، عنوان «المخزون»، زر «إضافة صنف»، وتنسيق صفحة المخزون (إخفاء `h1::before/::after`).
    - إضافة `escaped => false` لعمود الإجراءات المخصص حتى يظهر الـ HTML.
    - إنشاء `inventory_item_filters.blade.php` (اسم الصنف، كمية من/إلى) وربطها في القائمة والكونترولر.
    - عرض «مجموع الكميات (النتائج المفلترة)»: حساب المجموع في الكونترولر (`inventoryQuantityTotal`) وعرضه تحت الفلتر مع تنسيق (خط أكبر، فراغ، لون النص أسود).
  - **المدن (city):**
    - توحيد الهوية البصرية: أيقونة الموقع، عنوان «المدن»، زر «إضافة مدينة»، وإخفاء أيقونة الـ h1 الافتراضية.
    - تصحيح تسمية عمود الإجراءات في `HasUnifiedActionsDropdown`: «أجراءات» → «إجراءات».
    - ترتيب الصفوف أبجدياً: `orderBy('city_name', 'asc')`.
    - تنسيق أعمدة جدول المدن: عمود اسم المدينة (يمين، min-width 200px)، عمود الإجراءات (وسط، عرض 120px).
  - **التذييل (Footer):**
    - تغيير النص من «تم التطوير بواسطة بيت البرمجيات وتكنولوجيا المعلومات» إلى «تطوير وبرمجة بيت البرمجيات وتكنولوجيا المعلومات» في `config/backpack/ui.php` وصفحة تسجيل الدخول.

- **الملفات المعدلة/المضافة:**
  - **Controllers:** `ClientDepositCrudController`, `ExpenseCrudController`, `VendorPaymentCrudController`, `InventoryItemCrudController`, `CityCrudController`.
  - **Models:** `Vendor` (identifiableAttribute).
  - **Traits:** `HasUnifiedActionsDropdown` (تصحيح تسمية العمود).
  - **Views:** `resources/views/vendor/backpack/crud/list.blade.php` (فلاتر، مجاميع، تنسيق، منطق عمود الإجراءات، scroll، مدينة/مخزون)، `resources/views/vendor/backpack/ui/inc/menu_items.blade.php` (التمرير)، `resources/views/vendor/backpack/theme-coreuiv2/auth/login.blade.php` (نص التذييل).
  - **فلاتر جديدة:** `admin/expense_filters.blade.php`, `admin/vendor_payment_filters.blade.php`, `admin/inventory_item_filters.blade.php`.
  - **Config:** `config/backpack/ui.php` (developer_name).
  - **Migrations:** `2026_01_28_120000_ensure_vendors_table_exists.php`, `2026_01_28_120001_ensure_vendor_payments_table_exists.php`.

- **تنبيه:** بعد رفع التعديلات على السيرفر يُنصح بتشغيل `php artisan migrate --force` و`php artisan config:clear` و`php artisan view:clear` إن لزم.

---

## [2026-01-29] - نشر النظام على sama.baitpait.space وإعداد السيرفر
- **الهدف:** رفع نظام مياه سما على السيرفر (VPS Ubuntu + Webuzo) وجاهزية التشغيل من GitHub.
- **التغييرات:**
    - **دليل النشر:** إنشاء `DEPLOY_SAMA_BAITPAIT_SPACE.md` مع المسارات والخطوات (الدومين، Document Root، قاعدة البيانات).
    - **سكربتات:** إنشاء `deploy-sama.sh` (أرشفة للرفع)، `server-setup.sh` (تنفيذ على السيرفر بعد git clone)، وقالب `env.sama.production.example`.
    - **إعداد السيرفر:** تم استنساخ المستودع من GitHub، تشغيل `server-setup.sh`، إنشاء مجلدات الكاش، تعديل `.env`، تشغيل migrations و seed، صلاحيات storage/bootstrap/cache.
    - **إصلاح 500 (قراءة .env):** الويب سيرفر كان لا يقرأ `.env` (Access denied for user 'root'@'localhost' (using password: NO)). الحل: `chmod 644 .env` أو `chown root:www-data .env` + `chmod 640 .env` حسب مستخدم PHP-FPM.
    - **CSP:** إضافة `https://maxst.icons8.com` إلى `style-src` في `DisableCSPForBackpack.php` لتحميل Line Awesome (لم يُرفع على السيرفر لعدم نجاح git pull بالتوكن).
- **بيانات الدخول للوحة التحكم (من DemoDataSeeder):** البريد `admin@sama.test`، كلمة المرور `Admin@12345`.
- **ما تبقى للمتابعة:**
    - في حال عودة خطأ 500: تشغيل `tail -100 .../storage/logs/laravel.log` وإرسال آخر رسالة خطأ لتشخيص السبب.
    - تحديث الكود على السيرفر (إصلاح CSP وغيره): إما `git pull` بتوكن صالح، أو رفع الملفات المعدلة يدوياً ثم `php artisan config:clear && php artisan view:clear`.
    - توثيق صلاحيات `.env` النهائية في دليل النشر (644 أو 640 حسب بيئة السيرفر).
- **الملفات المعدلة/المضافة:** `DEPLOY_SAMA_BAITPAIT_SPACE.md`, `deploy-sama.sh`, `server-setup.sh`, `env.sama.production.example`, `app/Http/Middleware/DisableCSPForBackpack.php`, `server-setup.sh` (إضافة إنشاء مجلدات الكاش).
- **تنبيه:** لا تخزّن كلمات مرور حقيقية في الملفات أو Git؛ استخدم التوكن فقط على السيرفر لـ git pull.

---

## [2026-01-27 18:00] - تطبيق شامل للهوية البصرية الموحدة على جميع صفحات النظام
- **الهدف:** توحيد مظهر جميع صفحات النظام لتتناسب مع الهوية البصرية الموحدة وتحسين تجربة المستخدم بشكل شامل.
- **التغييرات:**
    - **صفحة المستخدمين:**
        - إعادة تصميم عرض الأعمدة باستخدام `custom_html` بدلاً من `relationship`
        - تحسين عرض "نوع المستخدم" و "الموزع" مع badges ملونة
        - تقييد خيارات "نوع المستخدم" إلى "مسؤول" و "موزع" فقط
        - إضافة CSS مخصص لتحسين تصميم الجدول
    - **إعادة تنظيم القائمة الجانبية:**
        - نقل "التقارير الإحصائية" إلى قسم "إدارة العملاء" وإعادة تسميتها إلى "المشتركين"
        - إزالة رابط "العملاء" من القائمة
        - نقل "رصيد المشتركين"، "تقرير العميل"، و "التقارير المتقدمة" إلى قسم "إدارة العملاء"
        - إضافة رابط "الدعم الفني" الذي يفتح واتساب برقم 970599814758
        - تحسين عناوين الأقسام لتكون بيضاء، bold، وخط أكبر
    - **تحسين Header السايدبار:**
        - إزالة نص "مياه سما" وتقليل المسافات
    - **إعادة تصميم الصفحات:**
        - صفحة التقارير المتقدمة: Header gradient، فلاتر عصرية، بطاقات إحصائية، رسوم بيانية محسّنة
        - صفحة حسابي: تطبيق الهوية البصرية الموحدة على جميع العناصر
        - صفحة تقرير رصيد المشتركين: تصميم عصري شامل
        - صفحة قائمة التسليم: تصميم موحد مع باقي الصفحات
        - صفحة التقارير الإحصائية (المشتركين): تصميم عصري مع فلاتر محسّنة
        - صفحة تقرير التسليمات: تصميم موحد مع الهوية البصرية
    - **إصلاحات:**
        - إصلاح رابط النسخة الاحتياطية مع تحسين معالجة الأخطاء
        - إصلاح Modal السحب المالي: إزالة زر "إلغاء"، إصلاح زر الإغلاق (X)
        - تحسين Footer بتصميم gradient متناسق
        - إخفاء Footer في صفحة تسجيل الدخول
- **النتائج:**
    - نظام موحد ومنسق يعكس الهوية البصرية بشكل احترافي
    - تحسين كبير في تجربة المستخدم
    - تصميم متجاوب لجميع الشاشات
- **الملفات المعدلة:** 12 ملف view، 2 ملف controller، 1 ملف CSS
- **التوثيق:** تم إنشاء `SESSION_SUMMARY_2026_01_27.md` لتوثيق الجلسة بالكامل

---

## [2026-01-27 16:30] - تحديث الهوية البصرية، ميزة إشعارات الواتساب، وتحسينات الإدخال الجماعي
- **الهدف:** توحيد مظهر النظام ليعكس العلامة التجارية "مياه سما"، إضافة ميزة التواصل التلقائي مع العملاء، وتحسين سرعة إدخال البيانات.
- **التغييرات:**
    - **الهوية البصرية (Branding):**
        - توحيد ألوان النظام بالكامل لتعتمد على الأزرق الداكن الملكي (#1e3a5f) المستوحى من الشعار.
        - جعل جميع الحواف دائرية (16px) والظلال ناعمة (Soft Shadows) في جميع البطاقات والجداول.
        - تحديث القائمة الجانبية (Sidebar) لتكون بيضاء بالكامل (نصوص وأيقونات) مع تباين احترافي.
        - إعادة تصميم صفحة تسجيل الدخول لتكون واجهة تسويقية عصرية.
        - جعل النظام مستجيباً بالكامل للموبايل (Mobile Responsive) مع زر عائم للمنيو.
    - **إشعارات الواتساب (WhatsApp Integration):**
        - إضافة ميزة إرسال رسالة واتساب تلقائية واحترافية للعميل فور تسجيل عملية تسليم.
        - الرسالة تتضمن (العبوات المستلمة، الفارغة، المبالغ، والدين الإجمالي المتبقي).
        - إضافة خيار (Checkbox) للتحكم في إرسال الرسالة أو عدمه قبل الحفظ.
    - **الإدخال الجماعي (Bulk Entry Improvements):**
        - تحسين نظام التنقل باستخدام مفتاح Enter بين الخلايا وصولاً لزر الحفظ.
        - جعل الصف يختفي تلقائياً بحركة انسيابية فور الحفظ لتسهيل متابعة العمل.
        - تحديث عداد المشتركين المتبقين لحظياً.
    - **إصلاحات تقنية:**
        - حل مشكلة تعطل القوائم المنسدلة (Dropdowns) من خلال ضبط الـ Overflow و Z-index.
        - توحيد استخدام Bootstrap 4 dropdowns لضمان الاستقرار.
- **النتائج:**
    - نظام عصري، احترافي، وسهل الاستخدام يعكس قوة العلامة التجارية.
    - تحسن كبير في سرعة إنجاز المهام اليومية للموزعين والموظفين.
    - تواصل فعال وفوري مع العملاء عبر الواتساب.

---

## [2026-01-27 14:30] - الإصلاح الشامل لمشكلة DataTables و Noty في جميع الصفحات
- **الهدف:** حل مشكلة فشل تحميل جداول البيانات (DataTables) وظهور أخطاء `Noty.overrideDefaults` و `Cannot read Modal` التي كانت تعطل النظام في صفحات الإعدادات والمدن.
- **التغييرات:**
    - **نظام التحميل (scripts.blade.php):** 
        - فرض تحميل متزامن (Synchronous) للمكتبات الأساسية (jQuery, Popper, Bootstrap, DataTables).
        - تجاوز محرك Basset للمكتبات الحساسة لضمان الترتيب الصحيح.
    - **إزالة التعارضات (AMD Shim):** 
        - حذف كود `window.define.amd` الذي كان يضلل المكتبات ويمنعها من الارتباط بـ jQuery.
    - **تحسين الحماية (Guards):** 
        - تحديث `early-guards.js` و `backpack-guards.js` لإضافة وظائف وهمية (Stubs) تمنع توقف الكود قبل اكتمال التحميل.
    - **نظام الانتظار (datatables_logic.blade.php):** 
        - تطوير نظام ذكي ينتظر جاهزية جميع المكتبات (حتى 20 ثانية) قبل تشغيل الجداول، مع طباعة جدول تشخيصي في حال الفشل.
- **النتائج:** 
    - عودة جميع الجداول للعمل بشكل مثالي في صفحات (المدن، أنواع الاشتراكات، حالات المشتركين، إلخ).
    - اختفاء كامل لجميع أخطاء JavaScript في Console.
- **تنبيه:** تم استخدام روابط CDN مستقرة لضمان عدم تأثر النظام بملفات محلية تالفة.

---


- **الهدف:** إعادة بناء Sidebar Menu بسيطة وثابتة (مثل المثال الطبي الأزرق) مع زر واحد فقط لإخفاء/إظهار المنيو بدون تعقيدات.
- **التغييرات:**
  - **CSS (unified-forms.css):**
    - Sidebar بعرض ثابت (270px)
    - Layout مبني على Flexbox
    - التحكم بالإخفاء عبر class واحدة (`sidebar-closed`)
    - عند الإخفاء: Sidebar تختفي بالكامل خارج الشاشة (transform: translateX)
    - المحتوى يتمدد تلقائياً بدون margin/padding يدوي
    - انتقال سلس (transition: 0.3s ease)
    - دعم RTL كامل
  - **JavaScript (sidebar-toggle.js):**
    - JavaScript بسيط (class toggle فقط)
    - حفظ الحالة في localStorage
    - بدون تعقيدات أو animations معقدة
  - **Header (main_header.blade.php):**
    - إضافة زر Toggle في Header
    - تصميم بسيط مع أيقونة bars
    - ألوان متناسقة مع الهوية البصرية
  - **Menu Items (menu_items.blade.php):**
    - تنظيم في أقسام واضحة (Section Labels)
    - عناصر مسطحة بدون nesting عميق
    - Module-based structure:
      - لوحة التحكم
      - إدارة العملاء
      - التسليمات
      - المالية
      - التقارير
      - المخزون
      - الإعدادات
      - النظام
      - الحساب
- **النتائج:**
  - Sidebar بسيطة وثابتة
  - زر واحد فقط للتحكم
  - انتقال سلس بدون تعقيدات
  - المحتوى يتمدد تلقائياً
  - الحفاظ الكامل على الهوية البصرية
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** 
  - Sidebar ظاهرة افتراضيًا على الشاشات الكبيرة
  - عند الإخفاء: تختفي بالكامل خارج الشاشة
  - الحالة تُحفظ في localStorage
  - دعم RTL كامل

---

>>>>>>> Incoming (Background Agent changes)
## [2026-01-25 06:34] - إعادة تصميم Sidebar مع هوية بصرية جديدة

- **الهدف:** تطبيق تصميم Sidebar حديث (أزرق داكن) مع الحفاظ على الهوية البصرية للنظام (خط Cairo، الألوان البنفسجية للعناصر النشطة).
- **التغييرات:**
  - **CSS (unified-forms.css):**
    - تغيير خلفية Sidebar من أبيض إلى أزرق داكن متدرج (#1e3a5f إلى #1a2f4a)
    - تحديث ألوان النصوص إلى أبيض مع شفافية
    - الحفاظ على الألوان البنفسجية (#6f6af8, #7c7cff) للعناصر النشطة
    - إضافة CSS لشريط البحث في Sidebar
    - إضافة CSS لزر الإخفاء/الإظهار
    - إضافة CSS للفئات القابلة للطي
    - دعم حالة Sidebar المطوية (70px عرض)
    - تحسين RTL support
  - **JavaScript (sidebar-enhanced.js):**
    - إنشاء ملف JavaScript جديد للتحكم في Sidebar
    - وظيفة إخفاء/إظهار Sidebar مع حفظ الحالة في localStorage
    - وظيفة البحث في عناصر المنيو
    - وظيفة طي/فتح الفئات
    - إنشاء ديناميكي لزر الإخفاء/الإظهار وشريط البحث
  - **Config (backpack/ui.php):**
    - إضافة `sidebar-enhanced.js` إلى قائمة الـ scripts العامة
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** 
  - التصميم يحافظ على خط Cairo والألوان البنفسجية للهوية البصرية
  - Sidebar يمكن إخفاؤه/إظهاره عبر زر في أعلى Sidebar
  - حالة الإخفاء/الإظهار تُحفظ تلقائياً في localStorage
  - شريط البحث يعمل على فلترة عناصر المنيو
  - الفئات القابلة للطي جاهزة للاستخدام (تتطلب تحديث menu_items.blade.php)

---

## [2026-01-24 21:53] - إنشاء صفحة الإدخال الجماعي للتسليمات (Excel-like)

- **الهدف:** تسريع عملية إدخال بيانات التسليم عبر صفحة واحدة تشبه Excel تتيح إدخال بيانات عدة مشتركين دفعة واحدة.
- **التغييرات:**
  - إنشاء `BulkDeliveryController` جديد مع 3 methods:
    - `index()`: عرض صفحة Excel-like مع نفس فلاتر قائمة التسليم
    - `storeSingle()`: حفظ تسليم واحد (من صف في الجدول)
    - `storeBulk()`: حفظ عدة تسليمات دفعة واحدة
    - `createDelivery()`: منطق إنشاء التسليم مع إدارة المخزون والدفعات (نفس منطق `DeliveryCrudController`)
  - إنشاء View جديد `bulk_delivery_entry.blade.php`:
    - جدول Excel-like قابل للتعديل مباشرة (inline editing)
    - أعمدة: اسم المشترك (read-only) | العبوات المستلمة (editable) | العبوات الفارغة (editable) | المبلغ المطلوب (editable) | المبلغ المدفوع (editable) | الدين المتبقي (auto-calculated) | إجراءات
    - عرض المخزون الحالي في الأعلى
    - نفس فلاتر قائمة التسليم (q, city_id, subscription_type_id, subscription_status_id)
    - JavaScript للتحرير المباشر: نقر مزدوج للتحرير، Enter للحفظ والانتقال، Escape للإلغاء
    - حساب تلقائي للدين المتبقي لكل صف
    - زر "حفظ" لكل صف
    - زر "حفظ جميع التغييرات" للحفظ الجماعي مع إعادة تحميل الصفحة
  - إضافة Routes جديدة:
    - `GET /admin/delivery/bulk-entry` - عرض الصفحة
    - `POST /admin/delivery/bulk-entry/single` - حفظ صف واحد
    - `POST /admin/delivery/bulk-entry/bulk` - حفظ جميع الصفوف
  - تعديل `delivery_list.blade.php`: إضافة زر "إدخال جماعي" في الـ header
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** 
  - الصفحة تستخدم نفس منطق `DeliveryCrudController::store()` لإدارة المخزون والدفعات
  - عند الحفظ الجماعي، يتم إعادة تحميل الصفحة تلقائياً بعد ثانية واحدة
  - عند حفظ صف واحد، يتم فقط إعادة تعيين القيم في الصف (بدون إعادة تحميل)
  - الرابط: `/admin/delivery/bulk-entry`
---

## [2026-01-23 16:00] - إزالة فلتر حالة الالتزام من قائمة التسليم

- **الهدف:** تبسيط فلاتر البحث بعرض الحقول المطلوبة فقط.
- **التغييرات:** حذف فلتر حالة الالتزام من واجهة `delivery_list.blade.php` وإزالة شرطه من `DeliveryListController`.
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** لا يوجد إجراء يدوي إضافي.
---

## [2026-01-23 15:50] - إعادة ترتيب فلاتر قائمة التسليم

- **الهدف:** تحسين ترتيب الفلاتر بإبراز حقل البحث في صف مستقل وتقليل الفراغات.
- **التغييرات:** نقل حقل البحث لصف منفصل وإعادة توزيع باقي الفلاتر على صفّين متوازنين في `delivery_list.blade.php`.
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** لا يوجد إجراء يدوي إضافي.
---

## [2026-01-23 15:40] - تثبيت جدول التسليم وإظهار شريط أفقي

- **الهدف:** منع خروج الجدول من البطاقة وإظهار شريط تمرير أفقي عند ضيق الشاشة.
- **التغييرات:** تقوية `overflow-x` على `card-body` و`table-responsive` وزيادة `min-width` للجدول في `delivery_list.blade.php`.
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** لا يوجد إجراء يدوي إضافي.
---

## [2026-01-23 15:30] - تثبيت جدول قائمة التسليم داخل الحاوية

- **الهدف:** ضمان بقاء جدول قائمة التسليم داخل نفس البطاقة مع شريط تمرير أفقي عند صغر الشاشة.
- **التغييرات:** ضبط `table-responsive` على `overflow-x: auto` وتحديد `min-width` للجدول في `delivery_list.blade.php`.
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** لا يوجد إجراء يدوي إضافي.
---

## [2026-01-23 15:20] - عرض العنوان داخل عمود المدينة في قائمة التسليم

- **الهدف:** تحسين وضوح موقع المشترك عبر عرض العنوان مع المدينة في نفس العمود.
- **التغييرات:** تحديث جدول `delivery_list.blade.php` لإظهار العنوان أسفل المدينة وتحديث عنوان العمود.
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** لا يوجد إجراء يدوي إضافي.
---

## [2026-01-23 15:05] - توسيع بحث قائمة التسليم ليشمل العنوان

- **الهدف:** تمكين البحث عن المشتركين في قائمة التسليم باستخدام العنوان ضمن نفس حقل البحث.
- **التغييرات:** تحديث منطق البحث في `DeliveryListController` ليشمل `address` في الاستعلامين؛ تحديث placeholder في `delivery_list.blade.php`.
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** لا يوجد إجراء يدوي إضافي.
---

## [2026-01-23 14:30] - إصلاح فلترة عرض قائمة المشتركين

- **الهدف:** توحيد نتائج الفلاتر بين العداد والجدول وضمان ظهور البيانات المفلترة بشكل صحيح.
- **التغييرات:** توحيد منطق الفلترة في عرض قائمة المشتركين داخل `resources/views/vendor/backpack/crud/list.blade.php` ليدعم البحث بالاسم/الهاتف/العنوان مع نفس شروط الفلاتر؛ تحديث النص إلى "مشترك".
- **الأدوات:** لا توجد مكتبات جديدة.
- **تنبيه:** لا يوجد إجراء يدوي إضافي.
---

## [2026-01-12 17:00] - تغيير المصطلحات من "عميل/عملاء" إلى "مشترك/مشتركين"

### **الهدف:**
تحديث جميع المصطلحات في النظام من "عميل/عملاء" إلى "مشترك/مشتركين" لتحسين الدقة في التسمية.

### **التغييرات:**

#### 1. Controllers
- **الملفات المعدلة:**
  - `app/Http/Controllers/Admin/ClientCrudController.php`
  - `app/Http/Controllers/Admin/DeliveryCrudController.php`
  - `app/Http/Controllers/Admin/InvoiceCrudController.php`
  - `app/Http/Controllers/Admin/ClientPaymentCrudController.php`
  - `app/Http/Controllers/Admin/DeliveryListController.php`
- **التغييرات:**
  - تغيير `setEntityNameStrings('عميل', 'العملاء')` إلى `setEntityNameStrings('مشترك', 'المشتركين')`
  - تحديث جميع الـ labels من "العميل" إلى "المشترك"
  - تحديث جميع الـ hints والرسائل
  - تحديث جميع التعليقات في الكود

#### 2. Models
- **الملفات المعدلة:**
  - `app/Models/Client.php`
  - `app/Models/Invoice.php`
  - `app/Models/ClientPayment.php`
  - `app/Models/ClientDeposit.php`
  - `app/Models/City.php`
  - `app/Models/Distributor.php`
  - `app/Models/ClientType.php`
  - `app/Models/SubscriptionType.php`
  - `app/Models/SubscriptionStatus.php`
- **التغييرات:**
  - تحديث جميع الـ DocBlocks والتعليقات
  - تغيير "العميل الأب" إلى "المشترك الأب"
  - تغيير "عميل فرعي" إلى "مشترك فرعي"
  - تحديث جميع أوصاف العلاقات

#### 3. Views
- **الملفات المعدلة:**
  - `resources/views/admin/delivery_list.blade.php`
- **التغييرات:**
  - تغيير "عدد العملاء" إلى "عدد المشتركين"
  - تغيير "العميل" إلى "المشترك" في رؤوس الجداول
  - تحديث جميع النصوص المعروضة للمستخدم

#### 4. Routes
- **الملفات المعدلة:**
  - `routes/backpack/custom.php`
- **التغييرات:**
  - تحديث التعليقات من "رصيد العملاء" إلى "رصيد المشتركين"

#### 5. Migrations
- **الملفات المعدلة:**
  - `database/migrations/2026_01_12_160554_add_delivery_on_demand_to_clients_table.php`
- **التغييرات:**
  - تحديث التعليقات في الـ DocBlocks

### **الأدوات:**
- Laravel
- Backpack CRUD
- Blade Templates

### **تنبيه:**
- تم تغيير جميع النصوص التي يراها المستخدم مباشرة
- تم تحديث التعليقات والـ DocBlocks في الكود
- لا توجد تغييرات في قاعدة البيانات (الأسماء في قاعدة البيانات لم تتغير)
- بعض ملفات Views الأخرى قد تحتاج تحديث يدوي (مثل `menu_items.blade.php` إذا كان محمياً)

---

## [2026-01-12 16:30] - إضافة ميزة "تسليم حسب الطلب" وإصلاحات نهائية

### **الهدف:**
إضافة ميزة "تسليم حسب الطلب" للعملاء، إصلاح مشكلة عدم ظهور الحقول في صفحة العملاء، وإكمال جميع الميزات المطلوبة.

### **التغييرات:**

#### 1. إضافة ميزة "تسليم حسب الطلب" (Delivery on Demand)
- **الملفات المعدلة:**
  - `database/migrations/2026_01_12_160554_add_delivery_on_demand_to_clients_table.php` (جديد)
  - `app/Models/Client.php`
  - `app/Http/Controllers/Admin/ClientCrudController.php`
  - `app/Http/Controllers/Admin/DeliveryListController.php`
  - `app/Http/Controllers/Admin/DeliveryCrudController.php`
- **التغييرات:**
  - **إضافة حقل `delivery_on_demand`:**
    - نوع: `boolean` (default: `false`)
    - يظهر في صفحة إضافة/تعديل العميل كـ checkbox
    - إذا كان `true`، يظهر العميل في قائمة التسليم حتى لو لم يتجاوز `distribution_days`
  - **منطق التطبيق:**
    - في `DeliveryListController`: يتم عرض العملاء الذين `delivery_on_demand = true` بالإضافة إلى العملاء المستحقين حسب أيام الاشتراك
    - في `DeliveryCrudController`: بعد إنشاء/تحديث تسليم، يتم إرجاع `delivery_on_demand` إلى `false` تلقائياً
  - **إصلاح نوع الحقل:**
    - تغيير نوع الحقل من `boolean` إلى `checkbox` في Backpack CRUD لضمان ظهوره بشكل صحيح

#### 2. إصلاح مشكلة عدم ظهور الحقول
- **الملف:** `app/Http/Controllers/Admin/ClientCrudController.php`
- **المشكلة:** حقل `delivery_on_demand` لم يظهر في صفحة إضافة/تعديل العميل
- **الحل:** تغيير نوع الحقل من `boolean` إلى `checkbox` مع `default => 0`

### **الأدوات:**
- Laravel Migrations
- Backpack CRUD
- Eloquent ORM

### **تنبيه:**
- حقل `delivery_on_demand` يظهر فقط في صفحة إضافة/تعديل العميل (`/admin/client/create` أو `/admin/client/{id}/edit`)
- لا يظهر في قائمة العملاء (`/admin/client`) - لأنها صفحة عرض فقط
- بعد التسليم، يتم إرجاع `delivery_on_demand` إلى `false` تلقائياً

---

## [2026-01-09 20:45] - تحسينات نظام التسليمات والمخزون والعلامة التجارية

### **الهدف:**
تحسين نظام التسليمات مع إدارة المخزون التلقائية، ربط الدفعات بالعملاء، حماية الصنف الأساسي، تحديث العلامة التجارية، وإعادة ترتيب القائمة الجانبية.

### **التغييرات:**

#### 1. تحسين نظام التسليمات (Deliveries)
- **الملفات المعدلة:**
  - `database/migrations/2026_01_09_204125_add_required_amount_to_deliveries_table.php` (جديد)
  - `app/Models/Delivery.php`
  - `app/Http/Requests/DeliveryRequest.php`
  - `app/Http/Controllers/Admin/DeliveryCrudController.php`
- **التغييرات:**
  - **إضافة حقول جديدة:**
    - `required_amount` (decimal 10,2): المبلغ المطلوب الكامل من العميل
    - `inventory_item_id` (foreign key, default=1): ربط بصنف العبوات في المخزون
    - `client_payment_id` (nullable foreign key): ربط بالدفعة المرتبطة
  - **إدارة المخزون التلقائية:**
    - العبوات المستلمة (`bottle_received`) → تنقص من المخزون تلقائياً
    - العبوات الفارغة (`bottle_empty`) → تزيد في المخزون تلقائياً
    - يتم استخدام الصنف `id=1` (قوارير مياه) افتراضياً
  - **إنشاء الدفعات تلقائياً:**
    - إذا كان `paymant > 0` → يتم إنشاء `ClientPayment` تلقائياً
    - الدفعات تُحمل على العميل الأب (parent client) فقط
    - إذا كان التسليم لعميل فرعي (child)، تُضاف ملاحظة في `notes` تشير إلى العنوان
  - **منطق التعديل:**
    - عند التعديل: إرجاع الكميات القديمة للمخزون (عكس العملية)
    - ثم تطبيق الكميات الجديدة
    - تحديث `ClientPayment` أو إنشاؤه/حذفه حسب الحاجة
  - **منطق الحذف:**
    - إرجاع العبوات المستلمة للمخزون
    - خصم العبوات الفارغة من المخزون
    - حذف `ClientPayment` المرتبط إن وجد
  - **واجهة المستخدم:**
    - إضافة حقل "المبلغ المطلوب" و "المبلغ المدفوع"
    - إضافة JavaScript لإظهار الدين المتبقي تلقائياً (`required_amount - paymant`)
    - حقل `inventory_item_id` مخفي (default=1)

#### 2. حماية الصنف الأساسي في المخزون (id=1)
- **الملف:** `app/Http/Controllers/Admin/InventoryItemCrudController.php`
- **التغييرات:**
  - **منع التعديل:**
    - في `setupUpdateOperation()`: جعل الحقول `readonly` و `disabled` للصنف `id=1`
    - إضافة رسائل توضيحية: "هذا الصنف محمي من التعديل"
  - **منع الحذف:**
    - في `destroy()`: منع الحذف مع رسالة خطأ واضحة
    - في `setupListOperation()`: إخفاء زر الحذف للصنف `id=1`
    - عرض أيقونة قفل بدلاً من زر الحذف مع رسالة توضيحية
  - **الحماية المزدوجة:**
    - في الواجهة: إخفاء زر الحذف
    - على مستوى الخادم: منع الحذف حتى لو تم الوصول مباشرة

#### 3. تحديث العلامة التجارية
- **الملفات المعدلة:**
  - `config/backpack/ui.php`
  - `resources/views/welcome.blade.php`
  - `resources/views/driver_map.blade.php`
- **التغييرات:**
  - تغيير `project_name` من "مياه ايلياء" إلى "مياه سما"
  - تحديث جميع عناوين الصفحات (`<title>`) من "مياه إيلياء" إلى "مياه سما"
  - تحديث النصوص في صفحات الواجهة

#### 4. إعادة ترتيب القائمة الجانبية
- **الملف:** `resources/views/vendor/backpack/ui/inc/menu_items.blade.php`
- **التغييرات:**
  - **ترتيب القائمة حسب التصنيفات:**
    1. الرئيسية
    2. التقارير (التقارير الإحصائية، رصيد العملاء)
    3. التسليمات (إضافة تسليم، قائمة التسليم، التسليمات)
    4. العملاء (العملاء، نوع العميل، حالة العميل)
    5. الموزعين
    6. الإعدادات (أنواع الاشتراكات، حالة الاشتراك، المدن)
    7. المالية والمصروفات (فئات المصروفات، المصروفات، الموردين، مدفوعات الموردين)
    8. المخزون
    9. المبيعات والعملاء (الفواتير، مدفوعات العملاء، أمانات العملاء)
    10. النظام (المستخدمين، نسخة احتياطية، الدعم الفني)
    11. الحساب (حسابي، تسجيل الخروج)
  - **تحسين الشعار:**
    - زيادة الحجم إلى 140px
    - إضافة خلفية متدرجة خفيفة
    - إضافة تأثير hover (تكبير عند التمرير)
    - تحسين التباعد والحدود
  - **إصلاح مشكلة الانتقال إلى أعلى:**
    - إضافة JavaScript لحفظ موضع التمرير في `sessionStorage`
    - استعادة الموضع عند تحميل الصفحة
    - حفظ الموضع تلقائياً عند التمرير
    - إضافة `onclick="saveScrollPosition()"` لجميع الروابط
  - **تنظيف القائمة:**
    - إزالة الفراغات والفواصل الزائدة
    - توحيد استخدام `<x-backpack::menu-item>` و `<li class="nav-item">`
    - إضافة تعليقات توضيحية لكل قسم

#### 5. إصلاح مشكلة Closure في custom_html
- **الملف:** `app/Http/Controllers/Admin/DeliveryCrudController.php`
- **المشكلة:** استخدام Closure في `value()` لحقل `custom_html` يسبب خطأ "Object of class Closure could not be converted to string"
- **الحل:** استبدال `value(function() { return '...'; })` بـ `value('...')` مباشرة

### **الأدوات:**
- Laravel Migrations
- Backpack CRUD
- Eloquent ORM
- JavaScript (لحفظ موضع التمرير وإظهار الدين المتبقي)
- SessionStorage (لحفظ موضع التمرير)

### **تنبيه:**
- الصنف `id=1` (قوارير مياه) محمي من التعديل والحذف - يُستخدم في نظام التسليمات
- الدفعات من التسليمات تُحمل على العميل الأب (parent client) فقط
- عند إنشاء تسليم لعميل فرعي (child)، الدفعة تُحمل على حساب الأب مع ملاحظة في `notes`
- جميع التعديلات على التسليمات تؤثر تلقائياً على المخزون (العبوات)

---

## [2026-01-09 18:30] - تحسينات نظام الفواتير والأمانات

### **الهدف:**
تحسين نظام الفواتير (إظهار/إخفاء حقول الدفع)، إصلاح القائمة الجانبية، تحسين تقرير رصيد العملاء، وإنشاء نظام الأمانات الكامل.

### **التغييرات:**

#### 1. تحسين منطق حقول الدفع في الفواتير
- **الملف:** `app/Http/Controllers/Admin/InvoiceCrudController.php`
- **التغييرات:**
  - تحديث JavaScript لإظهار/إخفاء حقول الدفع حسب حالة الدفع:
    - **"دين" (unpaid):** إخفاء جميع حقول الدفع، المبلغ الإجمالي = الدين
    - **"مدفوع كامل" (paid):** إخفاء جميع حقول الدفع، المبلغ المدفوع = المبلغ الإجمالي تلقائياً
    - **"مدفوع جزئي" (partial):** إظهار حقل "المبلغ المدفوع" فقط
  - تحديث منطق `store()` و `update()` لإنشاء دفعات تلقائياً حسب الحالة
  - تحسين رسائل النجاح لتوضيح حالة الدفع

#### 2. إصلاح القائمة الجانبية
- **الملف:** `resources/views/vendor/backpack/ui/inc/menu_items.blade.php`
- **التغييرات:**
  - إزالة التكرارات:
    - حذف "المخزون" المكرر (كان موجوداً مرتين)
    - حذف "Inventory items" (إنجليزي)
    - حذف "Invoices" (إنجليزي)
  - إضافة الروابط المفقودة:
    - "الفواتير" (`/admin/invoice`)
    - "مدفوعات العملاء" (`/admin/client-payment`)
    - "رصيد العملاء" (`/admin/reports/client-balance`)
  - ترتيب القائمة بشكل منطقي

#### 3. تحسين تقرير رصيد العملاء
- **الملف:** `app/Http/Controllers/Admin/ClientBalanceReportController.php`
- **الملف:** `resources/views/admin/reports/client_balance.blade.php`
- **التغييرات:**
  - إضافة فلتر تلقائي لإخفاء العملاء الذين رصيدهم = 0
  - تحديث الواجهة: إزالة خيار "عرض المدينين فقط" (أصبح افتراضي)
  - إضافة ملاحظة توضيحية: "يتم عرض العملاء الذين لديهم مستحقات فقط (الرصيد > 0)"
  - الإحصائيات تُحسب فقط للعملاء المعروضين

#### 4. إنشاء نظام الأمانات الكامل (Client Deposits)
- **الملفات الجديدة:**
  - `database/migrations/2026_01_09_183335_create_client_deposits_table.php`
  - `app/Models/ClientDeposit.php`
  - `app/Http/Controllers/Admin/ClientDepositCrudController.php`
  - `resources/views/vendor/backpack/crud/buttons/withdraw_all.blade.php`
- **التغييرات في الملفات الموجودة:**
  - `app/Models/Client.php`: إضافة علاقة `deposits()`
  - `routes/backpack/custom.php`: إضافة Routes للأمانات
  - `resources/views/vendor/backpack/ui/inc/menu_items.blade.php`: إضافة رابط "أمانات العملاء"
- **الميزات:**
  - **جدول الأمانات:** `client_id`, `item_name`, `quantity`, `date_given`, `notes`, `is_withdrawn`, `withdrawn_at`
  - **إعطاء أمانة:** خصم تلقائي من المخزون عند الإنشاء
  - **سحب أمانة واحدة:** زر "سحب" لكل صنف في القائمة
  - **سحب كل الأمانات:** زر في أعلى الصفحة لسحب جميع أمانات عميل معين
  - **السجلات تبقى:** مع توضيح تاريخ السحب (لا يتم حذفها)
  - **منع التعديل:** لا يمكن تعديل أمانة مسحوبة
  - **إرجاع تلقائي:** عند الحذف، يتم إرجاع الكمية للمخزون (إذا لم تكن مسحوبة)

#### 5. إصلاح مشكلة الفلاتر (Backpack PRO)
- **الملف:** `app/Http/Controllers/Admin/ClientDepositCrudController.php`
- **المشكلة:** الفلاتر (`CRUD::filter`) تتطلب Backpack PRO
- **الحل:**
  - إزالة جميع الفلاتر (`CRUD::filter`)
  - استبدالها بالبحث العادي عبر `addClause`:
    - البحث حسب الحالة (معارة/مسحوبة)
    - البحث حسب العميل عبر `whereHas`

### **الأدوات:**
- Laravel Migrations
- Backpack CRUD
- Eloquent ORM
- JavaScript (لإظهار/إخفاء الحقول)

### **تنبيه:**
- تم إزالة الفلاتر من `ClientDepositCrudController` لأنها تتطلب Backpack PRO
- البحث يعمل الآن عبر `addClause` (بدون PRO)
- جميع الأمانات المسحوبة تبقى كسجل تاريخي مع توضيح تاريخ السحب

---

---

## [2025-01-25 12:00] - إصلاح قاعدة البيانات وإنشاء الجداول المفقودة

- **الهدف:** إصلاح أخطاء قاعدة البيانات وإنشاء الجداول المفقودة لضمان عمل النظام بشكل صحيح
- **التغييرات:**
  - إنشاء migration لجدول `subscription_statuses`
  - إنشاء migration لجدول `client_statuses`
  - إنشاء migration لجدول `client_types`
  - إنشاء migration لجدول `cities`
  - إنشاء migration لجدول `cash_withdraws`
  - تشغيل migrations بنجاح
  - تنظيف الكاش الكامل
  - بناء الأصول (npm run build)
- **الأدوات:** Laravel Migrations, SQLite (للتنمية)
- **تنبيه:** تم إنشاء الجداول فارغة - قد تحتاج إلى Seeder لإضافة البيانات الأساسية
- **الحالة:** ✅ مكتمل - النظام يعمل الآن بدون أخطاء

---

## [2025-01-25 12:15] - إصلاح مشكلة Basset (404 Errors) وملفات CDN

- **الهدف:** إصلاح أخطاء 404 لملفات CSS/JS من CDN وتحسين تجربة المستخدم
- **المشكلة:** ملفات Basset غير متاحة عبر public/storage مما يسبب أخطاء 404
- **التغييرات:**
  - تشغيل `php artisan basset:internalize` لتحميل 69 ملف من CDN
  - إصلاح storage link (كان مجلد عادي بدلاً من symbolic link)
  - حذف `public/storage` القديم وإنشاء link جديد
  - التحقق من أن جميع ملفات Basset متاحة (HTTP 200)
  - تنظيف الكاش بعد الإصلاحات
- **الأدوات:** Laravel Basset, Storage Link
- **النتيجة:** ✅ جميع ملفات CSS/JS متاحة الآن (jQuery, Noty, Line Awesome, Bootstrap, إلخ)
- **الحالة:** ✅ مكتمل - لا توجد أخطاء 404

---

## [2025-01-25 12:20] - إصلاح خطأ 500 - جداول فارغة ومشاكل SQLite

- **الهدف:** إصلاح خطأ 500 (Internal Server Error) في جميع الصفحات
- **المشاكل:** 
  1. جدول `deliveries` فارغ - كان يحتوي فقط على `id` و `timestamps`
  2. جدول `clients` فارغ - كان يحتوي فقط على `id` و `timestamps`
  3. استخدام `DATE_FORMAT` الذي لا يدعمه SQLite
  4. استخدام Views غير موجودة (`v_clients_delivery_overview`)
- **التغييرات:**
  - إنشاء migration لإضافة جميع الأعمدة المفقودة إلى جدول `deliveries`
  - إنشاء migration لإضافة جميع الأعمدة المفقودة إلى جدول `clients` (18 عمود)
  - إصلاح استخدام `DATE_FORMAT` ليدعم SQLite (`STRFTIME`) و MySQL
  - استبدال استخدام Views غير الموجودة بجداول مباشرة
  - إصلاح حساب معدل الالتزام حسب المدينة
- **الأدوات:** Laravel Migrations, SQLite, PHP
- **النتيجة:** ✅ جميع الجداول تحتوي على الأعمدة المطلوبة، جميع الصفحات تعمل
- **الحالة:** ✅ مكتمل - خطأ 500 تم إصلاحه في جميع الصفحات

---

## [2025-01-25 13:00] - تحويل النظام من SQLite إلى MySQL

- **الهدف:** تحويل النظام بالكامل من SQLite إلى MySQL للاستعداد للرفع على السيرفر
- **المشاكل المحتملة:**
  1. Migrations تستخدم `PRAGMA table_info()` - خاص بـ SQLite فقط
  2. Migrations تستخدم `sqlite_master` - خاص بـ SQLite فقط
  3. Config files تستخدم `sqlite` كـ default connection
- **التغييرات:**
  - إصلاح `add_columns_to_deliveries_table.php` - استبدال `PRAGMA` بـ `Schema::hasColumn()`
  - إصلاح `add_columns_to_clients_table.php` - استبدال `PRAGMA` بـ `Schema::hasColumn()`
  - إصلاح `add_indexes_for_performance.php` - إزالة `PRAGMA` و `sqlite_master`، استخدام `information_schema` لـ MySQL
  - تحديث `config/database.php` - تغيير default من `sqlite` إلى `mysql`
  - تحديث `config/queue.php` - تغيير default من `sqlite` إلى `mysql`
  - إضافة DocBlocks توضيحية لجميع Migrations (حسب القاعدة 11 من الدستور)
- **الأدوات:** Laravel Migrations, MySQL, TablePlus
- **الملفات المعدلة:**
  - `database/migrations/2025_01_25_121000_add_columns_to_deliveries_table.php`
  - `database/migrations/2025_01_25_121100_add_columns_to_clients_table.php`
  - `database/migrations/2025_12_29_041932_add_indexes_for_performance.php`
  - `config/database.php`
  - `config/queue.php`
- **التوثيق:**
  - إنشاء `MYSQL_SETUP_GUIDE.md` - دليل شامل لإعداد MySQL في TablePlus
  - إنشاء `docs/decisions/ADR-001-sqlite-to-mysql-migration.md` - Engineering Decision Record
- **النتيجة:** ✅ جميع Migrations متوافقة مع MySQL، جاهزة للرفع على السيرفر
- **الحالة:** ✅ مكتمل - النظام جاهز للعمل على MySQL
- **تنبيه:** يجب تحديث ملف `.env` لاستخدام MySQL قبل تشغيل Migrations

---

## [2025-01-25 13:30] - إصلاح خطأ 500 بعد التحويل إلى MySQL

- **الهدف:** إصلاح خطأ 500 (Internal Server Error) بعد التحويل إلى MySQL
- **المشاكل:**
  1. ملف `.env` غير موجود - النظام يحاول الاتصال بقاعدة بيانات `laravel` الافتراضية
  2. Migrations تحاول إنشاء جداول موجودة مسبقاً
  3. Migrations تحاول إضافة indexes على أعمدة غير موجودة
- **التغييرات:**
  - إنشاء ملف `.env` جديد مع إعدادات MySQL المحلية (`eliyaa_local`)
  - تعديل جميع migrations `create_*_table` للتحقق من وجود الجدول قبل الإنشاء
  - تعديل migration `add_indexes_for_performance` للتحقق من وجود الأعمدة قبل إنشاء indexes
  - تشغيل جميع Migrations بنجاح
  - تشغيل DatabaseSeeder لإنشاء المستخدم الإداري الافتراضي
- **الأدوات:** Laravel Migrations, MySQL, TablePlus
- **الملفات المعدلة:**
  - `.env` (تم إنشاؤه)
  - `database/migrations/2025_11_06_090502_create_clients_table.php`
  - `database/migrations/2025_11_06_090502_create_deliveries_table.php`
  - `database/migrations/2025_11_06_090502_create_distributors_table.php`
  - `database/migrations/2025_11_06_090503_create_subscription_types_table.php`
  - `database/migrations/2025_12_29_041932_add_indexes_for_performance.php`
- **النتيجة:** ✅ جميع Migrations تم تشغيلها بنجاح، النظام يعمل على MySQL
- **الحالة:** ✅ مكتمل - خطأ 500 تم إصلاحه، النظام جاهز للاستخدام

---

## [2025-01-25 14:00] - إزالة روابط غير ضرورية من القائمة الجانبية

- **الهدف:** إزالة روابط "تتبع الموزعين" و "نسخ رابط التطبيق" من القائمة الجانبية
- **المشاكل:**
  - روابط غير ضرورية في الوقت الحالي
  - كود JavaScript غير مستخدم
- **التغييرات:**
  - إزالة رابط "تتبع الموزعين" من `menu_items.blade.php`
  - إزالة رابط "نسخ رابط التطبيق" و script `copyAppLink()` من `menu_items.blade.php`
  - إزالة Route `/drivers-map` من `routes/backpack/custom.php`
- **الأدوات:** Laravel, Blade Templates
- **الملفات المعدلة:**
  - `resources/views/vendor/backpack/ui/inc/menu_items.blade.php`
  - `routes/backpack/custom.php`
- **النتيجة:** ✅ تم إزالة جميع الروابط والكود المتعلق بنجاح
- **الحالة:** ✅ مكتمل - القائمة الجانبية نظيفة

---

## [2026-01-08 19:40] - إضافة نظام إدارة المصروفات الكامل

- **الهدف:** إضافة نظام شامل لإدارة المصروفات مع إمكانية توزيعها على عدة أشهر للتقارير المالية
- **المتطلبات:**
  - فئات المصروفات (Expense Categories)
  - المصروفات مع توزيع شهري تلقائي
  - صفحة عرض المصروفات الشهرية الحالية
- **التغييرات:**
  - إنشاء migration لجدول `expense_categories` (name, description, is_active)
  - إنشاء migration لجدول `expenses` (expense_category_id, name, total_amount, number_of_months, monthly_amount, start_month, end_month, payment_date, notes, created_by)
  - إنشاء migration لجدول `expense_monthly_allocations` (expense_id, month, amount, is_transferred, transferred_at)
  - إنشاء Models: `ExpenseCategory`, `Expense`, `ExpenseMonthlyAllocation`
  - إنشاء Backpack CRUD Controllers: `ExpenseCategoryCrudController`, `ExpenseCrudController`
  - إنشاء `CurrentMonthExpensesController` لعرض المصروفات الشهرية
  - إنشاء View `current_month.blade.php` مع فلتر السنة والشهر
  - إضافة Routes للصفحات الجديدة
  - إضافة روابط في القائمة الجانبية (فئات المصروفات، المصروفات، المصروفات الشهرية)
  - تطبيق منطق التوزيع التلقائي: عند إنشاء مصروف، يتم توزيعه تلقائياً على الأشهر المحددة
- **الأدوات:** Laravel Migrations, Backpack CRUD, Carbon (للتواريخ)
- **الملفات الجديدة:**
  - `database/migrations/2026_01_08_194302_create_expense_categories_table.php`
  - `database/migrations/2026_01_08_194302_create_expenses_table.php`
  - `database/migrations/2026_01_08_194303_create_expense_monthly_allocations_table.php`
  - `app/Models/ExpenseCategory.php`
  - `app/Models/Expense.php`
  - `app/Models/ExpenseMonthlyAllocation.php`
  - `app/Http/Controllers/Admin/ExpenseCategoryCrudController.php`
  - `app/Http/Controllers/Admin/ExpenseCrudController.php`
  - `app/Http/Controllers/Admin/CurrentMonthExpensesController.php`
  - `resources/views/admin/expenses/current_month.blade.php`
- **النتيجة:** ✅ نظام إدارة المصروفات الكامل جاهز للاستخدام
- **الحالة:** ✅ مكتمل - يمكن إضافة المصروفات وتوزيعها تلقائياً على الأشهر

---

## [2026-01-08 20:00] - تحسين نظام المصروفات: الترحيل التلقائي وإزالة الأزرار

- **الهدف:** جعل جميع المصروفات مرحلة تلقائياً عند الإضافة وإزالة أزرار الترحيل اليدوي
- **التغييرات:**
  - تعديل `ExpenseCrudController::store()` - جميع التوزيعات الشهرية تكون `is_transferred = true` مباشرة
  - تعديل `Expense::createMonthlyAllocations()` - جميع المصروفات مرحلة تلقائياً
  - إزالة زر "ترحيل" الفردي من View `current_month.blade.php`
  - إزالة زر "ترحيل الكل" من View
  - إزالة عمود "الإجراءات" المتعلق بالترحيل
  - إضافة عمود "الإجراءات" مع زر "تعديل" يفتح صفحة تعديل المصروف
  - تحديث جميع المصروفات القديمة لتصبح مرحلة
- **الأدوات:** Laravel, Backpack CRUD
- **الملفات المعدلة:**
  - `app/Http/Controllers/Admin/ExpenseCrudController.php`
  - `app/Models/Expense.php`
  - `resources/views/admin/expenses/current_month.blade.php`
  - `app/Http/Controllers/Admin/CurrentMonthExpensesController.php`
- **النتيجة:** ✅ جميع المصروفات مرحلة تلقائياً عند الإضافة، واجهة نظيفة بدون أزرار ترحيل
- **الحالة:** ✅ مكتمل - النظام يعمل بشكل تلقائي بالكامل

---

## [2026-01-08 20:15] - إزالة حقل "اسم المصروف" من النظام

- **الهدف:** إزالة حقل "اسم المصروف" من النظام وقاعدة البيانات - الاعتماد على الفئة فقط
- **التغييرات:**
  - إنشاء migration `2026_01_08_201019_remove_name_from_expenses_table.php` لحذف عمود `name`
  - إزالة `'name'` من `$fillable` في Model `Expense`
  - إزالة عمود `name` من `setupListOperation()` في `ExpenseCrudController`
  - إزالة حقل `name` من `setupCreateOperation()` في `ExpenseCrudController`
  - إزالة `name` من Validation في `store()` method
  - إزالة `'name' => $request->name` من `Expense::create()`
  - إزالة عمود "اسم المصروف" من View `current_month.blade.php`
  - تحديث `colspan` في `tfoot` للجدول
- **الأدوات:** Laravel Migrations, Backpack CRUD
- **الملفات المعدلة:**
  - `database/migrations/2026_01_08_201019_remove_name_from_expenses_table.php` (جديد)
  - `app/Models/Expense.php`
  - `app/Http/Controllers/Admin/ExpenseCrudController.php`
  - `resources/views/admin/expenses/current_month.blade.php`
- **النتيجة:** ✅ تم إزالة حقل "اسم المصروف" بالكامل من النظام وقاعدة البيانات
- **الحالة:** ✅ مكتمل - النظام يعمل بدون حقل "اسم المصروف"، الاعتماد على الفئة فقط

---

## [2026-01-08 20:30] - إضافة منطق التعديل والحذف للمصروفات

- **الهدف:** إضافة منطق كامل لتعديل وحذف المصروفات مع إعادة إنشاء التوزيعات الشهرية
- **التغييرات:**
  - إضافة method `update()` مخصص في `ExpenseCrudController` لتحديث المصروف
  - عند التعديل: حذف التوزيعات القديمة وإنشاء توزيعات جديدة حسب البيانات المحدثة
  - إضافة method `destroy()` مخصص لحذف المصروف مع جميع التوزيعات الشهرية
  - إضافة معالجة للأخطاء (try-catch) عند محاولة الوصول لمصروف غير موجود
  - إصلاح مشكلة حقل `name` في قاعدة البيانات (تم حذفه يدوياً)
- **الأدوات:** Laravel, Backpack CRUD
- **الملفات المعدلة:**
  - `app/Http/Controllers/Admin/ExpenseCrudController.php`
  - `database/migrations/2026_01_08_194302_create_expenses_table.php`
- **النتيجة:** ✅ يمكن الآن تعديل وحذف المصروفات بشكل كامل مع إعادة إنشاء التوزيعات تلقائياً
- **الحالة:** ✅ مكتمل - جميع العمليات (Create, Read, Update, Delete) تعمل بشكل صحيح

---

## [2026-01-08 20:45] - تحسين عرض البيانات في جدول المصروفات

- **الهدف:** إصلاح عرض الفئة وإضافة عمود الملاحظات وتحويل الأزرار إلى dropdown menu
- **المشاكل:**
  - عمود "الفئة" كان يعرض JSON بدلاً من اسم الفئة
  - الأزرار (معاينة، تعديل، حذف) كانت منفصلة وغير منظمة
  - لم يكن هناك عمود للملاحظات
- **التغييرات:**
  - تغيير عرض عمود "الفئة" من `type('relationship')` إلى `type('custom_html')` لعرض اسم الفئة بشكل صحيح
  - إضافة عمود "الملاحظات" مع تقطيع النص إذا كان أطول من 50 حرفاً
  - إزالة الأزرار الافتراضية (show, edit, delete)
  - إضافة dropdown menu موحد للأزرار (معاينة، تعديل، حذف)
  - تعطيل عمود الإجراءات الافتراضي باستخدام `setOperationSetting('lineButtonsAsDropdown', false)`
- **الأدوات:** Laravel, Backpack CRUD, Bootstrap 4
- **الملفات المعدلة:**
  - `app/Http/Controllers/Admin/ExpenseCrudController.php`
- **النتيجة:** ✅ جدول نظيف ومنظم مع dropdown menu للأزرار وعرض صحيح للبيانات
- **الحالة:** ✅ مكتمل - الواجهة محسنة وجاهزة للاستخدام

---

## [2026-01-24 23:00] - إصلاح مشكلة تسجيل الدخول للموزعين وإنشاء Dashboard مخصص
- **الهدف:** حل مشكلة عدم قدرة الموزعين على تسجيل الدخول وتوفير واجهة مخصصة لهم.
- **المشاكل المكتشفة:** 
  - إضافة موزع جديد لا ينشئ حساب مستخدم تلقائياً للمصادقة.
  - Dashboard الرئيسي معطل بخطأ `ParseError` في ملف vendor.
- **الحلول المطبقة:**
  - تحديث `DistributorCrudController` بـ methods `store()` و `update()` لإنشاء/تحديث حسابات المستخدمين تلقائياً.
  - إنشاء `AdminController` مخصص مع dashboard منفصل للموزعين (`dashboard_distributor.blade.php`).
  - إضافة route مخصص للـ dashboard في `routes/backpack/custom.php`.
  - إصلاح route names في templates.
- **النتائج:** 
  - ✅ تسجيل دخول ناجح للموزع "مصطفى" (admin@distributor.local).
  - ✅ Dashboard مخصص يعرض فقط: المشتركين، قائمة التسليم، التسليمات، حسابي.
  - ✅ زر إظهار/إخفاء كلمة المرور يعمل بشكل احترافي.
- **الأدوات:** Laravel Routing، Backpack CRUD، Bootstrap، Custom Controllers.
- **تنبيه:** تم تجاوز مشكلة vendor dashboard المعطل بـ dashboard مخصص.

---
