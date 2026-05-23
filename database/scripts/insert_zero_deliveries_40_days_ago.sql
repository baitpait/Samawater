-- =============================================================================
-- إدراج تسليم واحد لكل المشتركين (من جدول clients)
-- القيم: كل الأرقام 0، التاريخ = اليوم ناقص 40 يوم، الموزع = 1
-- الاستخدام: نفّذ هذا الملف على قاعدة البيانات (مثلاً من phpMyAdmin أو mysql)
-- =============================================================================

-- تأكد من وجود صنف في inventory_items (مثلاً id=1). إن لم يكن موجوداً غيّر 1 إلى أي id صحيح أو احذف العمود من الـ INSERT إن كان الجدول يسمح بـ NULL.
INSERT INTO deliveries (
  client_id,
  delivery_date,
  bottle_received,
  bottle_empty,
  required_amount,
  paymant,
  inventory_item_id,
  client_payment_id,
  distributor_id,
  created_at,
  updated_at
)
SELECT
  c.id,
  DATE_SUB(CURDATE(), INTERVAL 40 DAY),
  0,
  0,
  0,
  0,
  IFNULL((SELECT id FROM inventory_items LIMIT 1), 1),
  NULL,
  1,
  NOW(),
  NOW()
FROM clients c;
