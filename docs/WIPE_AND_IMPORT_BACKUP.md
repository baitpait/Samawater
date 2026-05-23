# مسح قاعدة البيانات واستيراد النسخة الاحتياطية (على السيرفر)

## 1. مسح كل البيانات (جداول + views)

شغّل أحد الخيارين:

### خيار أ: ملف SQL جاهز (من جذر المشروع)

```bash
# استبدل USER و DATABASE_NAME ومسار الملف حسب السيرفر
mysql -u USER -p DATABASE_NAME < database/scripts/wipe_then_import_backup.sql
```

مثال إذا كان اسم القاعدة من `.env` هو `eliyaa_local`:

```bash
mysql -u root -p eliyaa_local < database/scripts/wipe_then_import_backup.sql
```

### خيار ب: من داخل MySQL

```bash
mysql -u USER -p DATABASE_NAME
```

ثم الصق محتوى الملف `database/scripts/wipe_then_import_backup.sql` أو نفّذ:

```sql
SET FOREIGN_KEY_CHECKS = 0;

DELIMITER //
DROP PROCEDURE IF EXISTS drop_all_tables_and_views//
CREATE PROCEDURE drop_all_tables_and_views()
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE tname VARCHAR(255);
  DECLARE ttype VARCHAR(64);
  DECLARE cur CURSOR FOR
    SELECT table_name, table_type
    FROM information_schema.tables
    WHERE table_schema = DATABASE();
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  OPEN cur;
  read_loop: LOOP
    FETCH cur INTO tname, ttype;
    IF done THEN LEAVE read_loop; END IF;
    IF ttype = 'VIEW' THEN
      SET @sql = CONCAT('DROP VIEW IF EXISTS `', tname, '`');
    ELSE
      SET @sql = CONCAT('DROP TABLE IF EXISTS `', tname, '`');
    END IF;
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
  END LOOP;
  CLOSE cur;
END//
DELIMITER ;

CALL drop_all_tables_and_views();
DROP PROCEDURE IF EXISTS drop_all_tables_and_views;

SET FOREIGN_KEY_CHECKS = 1;
```

---

## 2. استيراد النسخة الاحتياطية الجديدة

بعد رفع ملف النسخة الاحتياطية (مثلاً `eliyaa_backup_2026-01-27_12-00-00.sql`) إلى السيرفر:

```bash
mysql -u USER -p DATABASE_NAME < مسار/ملف_النسخة_الاحتياطية.sql
```

مثال:

```bash
mysql -u root -p eliyaa_local < /path/to/eliyaa_backup_2026-01-27_12-00-00.sql
```

---

## 3. سطر واحد (مسح + استيراد)

إذا الملف الجديد اسمه مثلاً `backup.sql` في المجلد الحالي:

```bash
mysql -u USER -p DATABASE_NAME < database/scripts/wipe_then_import_backup.sql && mysql -u USER -p DATABASE_NAME < backup.sql
```

استبدل `USER` و `DATABASE_NAME` و `backup.sql` بقيم السيرفر واسم ملف النسخة الاحتياطية.

---

## 4. تصنيف النسخ وماذا بعد الاستيراد

| النوع | الوصف | متى تستخدمه |
|--------|--------|----------------|
| **Dump كامل (`mysqldump`)** | يحوي `DROP/CREATE TABLE` وبيانات. مثال يُعتمد لمشروع سما محلياً: نسخة باسم `eliyaa_backup_2026-04-28_15-16-54.sql`. | عند ضياع القاعدة كليًا؛ يُعيد الجداول + المشتركين والتسليمات دفعة واحدة. |
| **بيانات فقط (`TRUNCATE` + `INSERT`)** | مثل `database/scripts/eliyaa_backup_2026-04-28_data_import.sql`. | بعد أن يكون المخطّط مطابقًا لبيئة Laravel (`migrate` حديث)؛ قد يتطلّب تعديل عمود واحد بين النسخ (مثل `for_future_obligation`) أو إصلاح أسطر لا تطابق ترتيب الجدول الجديد (`vendors`، إلخ). |

بعد أي استيراد بنجاح:

```bash
php artisan migrate --force
php artisan optimize:clear
```

**لا تستخدم** وحده ملف **`database_eliyaa.sql`** في الجذر كاستعادة كاملة محدَّثة إن غابت عنه جداول تشغيلية مهمة وفق مخطَّط الكود الحالي.

**مزيد توثيق:** `PROJECT_LOG.md` (مدخل 2026-04-28)، قرار معماري ذو صلة: `docs/decisions/ADR-003-subscriber-balance-vs-delivery-payments.md`.
