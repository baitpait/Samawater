-- ============================================================
-- تنفيذ يدوي: إنشاء جدول vendors و vendor_payments (إن لم يكونا موجودين)
-- قاعدة البيانات: MySQL / MariaDB
-- ============================================================

-- 1) جدول الموردين (vendors)
-- نفّذ فقط إذا لم يكن الجدول موجوداً
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text,
  `opening_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendors_name_index` (`name`),
  KEY `vendors_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2) جدول مدفوعات الموردين (vendor_payments)
-- يتطلب وجود: vendors, expenses, users
-- نفّذ فقط إذا لم يكن الجدول موجوداً
CREATE TABLE IF NOT EXISTS `vendor_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint unsigned NOT NULL,
  `expense_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('cash','bank_transfer','check','credit_card','other') NOT NULL DEFAULT 'cash',
  `payment_date` date NOT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `notes` text,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_payments_vendor_id_index` (`vendor_id`),
  KEY `vendor_payments_expense_id_index` (`expense_id`),
  KEY `vendor_payments_payment_date_index` (`payment_date`),
  CONSTRAINT `vendor_payments_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vendor_payments_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `vendor_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
