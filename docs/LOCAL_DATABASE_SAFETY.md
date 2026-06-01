# حماية قاعدة البيانات المحلية (`eliyaa_local`)

## لماذا تختفي البيانات؟

السبب الأكثر شيوعاً في هذا المشروع:

### 1. تشغيل `php artisan test` على `eliyaa_local` (السبب الرئيسي)

اختبارات Feature تستخدم `RefreshDatabase`، وهذا يعادل **`migrate:fresh`** على قاعدة الاختبار.

إذا كان `phpunit.xml` **لا** يحدد قاعدة منفصلة، PHPUnit يستخدم نفس `.env` → **`eliyaa_local`** → **يُمسح كل شيء** (عملاء، تسليمات، …) ويبقى الهيكل فقط.

**من يشغّل الاختبارات:** المطور، Cursor Agent، أو CI على الجهاز.

### 2. أوامر خطرة يدوياً

| الأمر | التأثير |
|--------|---------|
| `php artisan migrate:fresh` | حذف كل الجداول وإعادة إنشائها فارغة |
| `php artisan migrate:fresh --seed` | كما أعلاه + بيانات تجريبية فقط |
| `php artisan db:wipe-except-auth` | تفريغ كل الجداول ما عدا users/roles |
| `DROP DATABASE eliyaa_local` ثم `migrate` بدون استيراد SQL | قاعدة فارغة |

### 3. استيراد ناقص

بعد `DROP DATABASE` يجب دائماً استيراد ملف النسخة الاحتياطية `.sql`.

---

## الإعداد الصحيح (معتمد من الآن)

1. **التطوير:** `DB_DATABASE=eliyaa_local` في `.env`
2. **الاختبارات:** `DB_DATABASE=eliyaa_testing` في `phpunit.xml` فقط

إنشاء قاعدة الاختبار (مرة واحدة):

```bash
mysql -u root -h 127.0.0.1 -e \
  "CREATE DATABASE IF NOT EXISTS eliyaa_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

**لا تشغّل** `php artisan test` إذا ظهر خطأ يذكر `eliyaa_local`.

---

## استعادة البيانات بعد المسح

```bash
mysql -u root -h 127.0.0.1 -e \
  "DROP DATABASE IF EXISTS eliyaa_local; CREATE DATABASE eliyaa_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

mysql -u root -h 127.0.0.1 eliyaa_local < ~/Downloads/eliyaa_backup_2026-06-01_16-04-33.sql

cd "/path/to/Sama Water"
php artisan migrate --force
php artisan sama:repair-admin-login sama@baitpait.com --force
php artisan optimize:clear
```

---

## قاعدة ذهبية

| القاعدة | الاستخدام |
|---------|-----------|
| `eliyaa_local` | عمل يومي + نسخة احتياطية مستوردة |
| `eliyaa_testing` | `php artisan test` فقط |
