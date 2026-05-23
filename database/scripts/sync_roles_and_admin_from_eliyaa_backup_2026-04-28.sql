-- =============================================================================
-- استيراد أدوار + حساب المدير من نسخة: eliyaa_backup_2026-04-28_15-16-54.sql
-- قاعدة المصدر في النسخة: sarfesak_sama
-- Business Purpose: مزامنة الأدوار وجعل sama@baitpait.com مدير super_admin مع هاش النسخة.
--
-- ملاحظة: لا يوجد جدول permissions منفصل في النسخة؛ الصلاحيات مبنية على جدول roles فقط.
--
-- التنفيذ (مثال):
--   mysql -u root eliyaa_local < database/scripts/sync_roles_and_admin_from_eliyaa_backup_2026-04-28.sql
-- =============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `is_super_admin`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'مسؤول رئيسي', 'المسؤول الرئيسي - يمكنه إدارة المستخدمين وجميع الصلاحيات', 1, '2026-01-27 09:39:55', '2026-01-27 09:39:55'),
(2, 'admin', 'مسؤول', 'مسؤول - له كل الصلاحيات إلا إدارة المستخدمين', 0, '2026-01-27 09:39:55', '2026-01-27 09:39:55'),
(3, 'distributor', 'موزع', 'موزع - صلاحيات محددة لعرض العملاء والتسليمات فقط', 0, '2026-01-27 09:39:55', '2026-01-27 09:39:55')
ON DUPLICATE KEY UPDATE
    `display_name` = VALUES(`display_name`),
    `description` = VALUES(`description`),
    `is_super_admin` = VALUES(`is_super_admin`),
    `updated_at` = VALUES(`updated_at`);

-- تحديث إن وُجد البريد؛ وإلا إدراج بدون تثبيت id لتفادي تعارض المفاتيح
UPDATE `users` SET
    `role_id` = 1,
    `distributor_id` = NULL,
    `name` = 'مدير النظام',
    `password` = '$2y$12$dzdkKqxLGw6eQRxLc1c0Set3gbcmkGWx0MkhK6eXaZZE5ydDj7SpC',
    `remember_token` = NULL,
    `updated_at` = NOW()
WHERE `email` = 'sama@baitpait.com'
LIMIT 1;

INSERT INTO `users` (`role_id`, `distributor_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`)
SELECT
    1,
    NULL,
    'مدير النظام',
    'sama@baitpait.com',
    NULL,
    '$2y$12$dzdkKqxLGw6eQRxLc1c0Set3gbcmkGWx0MkhK6eXaZZE5ydDj7SpC',
    NULL,
    NOW(),
    NOW()
WHERE NOT EXISTS (SELECT 1 FROM `users` WHERE `email` = 'sama@baitpait.com' LIMIT 1);

SET FOREIGN_KEY_CHECKS = 1;
