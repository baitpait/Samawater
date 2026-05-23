-- =============================================================================
-- مسح كامل لقاعدة البيانات ثم استيراد النسخة الاحتياطية
-- الاستخدام على السيرفر:
--   1. تشغيل هذا الملف لمسح كل الجداول والـ views:
--      mysql -u USER -p DATABASE_NAME < wipe_then_import_backup.sql
--   2. استيراد النسخة الاحتياطية الجديدة:
--      mysql -u USER -p DATABASE_NAME < eliyaa_backup_YYYY-MM-DD_HH-MM-SS.sql
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- حذف كل الـ views أولاً ثم الجداول (ديناميكياً)
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

  -- تعطيل فحص المفاتيح الأجنبية داخل الإجراء حتى لا يفشل DROP
  SET SESSION FOREIGN_KEY_CHECKS = 0;

  OPEN cur;
  read_loop: LOOP
    FETCH cur INTO tname, ttype;
    IF done THEN
      LEAVE read_loop;
    END IF;
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

  SET SESSION FOREIGN_KEY_CHECKS = 1;
END//
DELIMITER ;

CALL drop_all_tables_and_views();
DROP PROCEDURE IF EXISTS drop_all_tables_and_views;

SET FOREIGN_KEY_CHECKS = 1;

-- انتهى المسح. الخطوة التالية: استيراد ملف النسخة الاحتياطية.
