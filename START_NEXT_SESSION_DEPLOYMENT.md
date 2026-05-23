# متابعة الجلسة — نشر sama.baitpait.space

**آخر تحديث:** 2026-01-29

---

## ما تم إنجازه

- رفع المشروع على GitHub (سكربتات النشر + دليل + قالب .env).
- استنساخ المستودع على السيرفر في `/home/sarfesak/public_html/sama`.
- تشغيل `server-setup.sh`: composer، .env، key:generate، migrations، seed، صلاحيات، storage:link.
- إصلاح خطأ 500 بسبب عدم قراءة `.env`: تم استخدام `chmod 644 .env` وعاد الموقع للعمل.
- تسجيل الدخول: **admin@sama.test** / **Admin@12345**.

---

## ما تبقى للمتابعة

### 1. إذا عاد خطأ 500

على السيرفر:

```bash
tail -100 /home/sarfesak/public_html/sama/storage/logs/laravel.log
```

انسخ آخر رسالة `production.ERROR` أو `previous exception` وأرسلها لتشخيص السبب.

### 2. تحديث الكود على السيرفر (CSP + أي تعديلات)

- إما `git pull` بتوكن GitHub صالح، ثم:
  ```bash
  cd /home/sarfesak/public_html/sama && git pull origin main && php artisan config:clear && php artisan view:clear
  ```
- أو رفع الملفات المعدلة يدوياً (مثلاً `app/Http/Middleware/DisableCSPForBackpack.php` لإصلاح Line Awesome)، ثم:
  ```bash
  php artisan config:clear && php artisan view:clear
  ```

### 3. صلاحيات .env (اختياري — أمان أفضل)

إذا عرفتَ مستخدم PHP-FPM الذي يخدم الموقع (مثلاً `www-data`):

```bash
chown root:www-data /home/sarfesak/public_html/sama/.env && chmod 640 /home/sarfesak/public_html/sama/.env
```

إذا عاد 500 بعدها، أرجع إلى `chmod 644 .env`.

---

## مراجع سريعة

| العنصر | القيمة |
|--------|--------|
| الدومين | https://sama.baitpait.space |
| مسار المشروع | /home/sarfesak/public_html/sama |
| Document Root | /home/sarfesak/public_html/sama/public |
| تسجيل الدخول | admin@sama.test / Admin@12345 |
| دليل النشر | DEPLOY_SAMA_BAITPAIT_SPACE.md |

---

تم حفظ الجلسة؛ يمكن المتابعة لاحقاً من هذا الملف و `PROJECT_LOG.md` و`docs/WIPE_AND_IMPORT_BACKUP.md` (استعادة قاعدة كاملة مقابل بيانات فقط) و`docs/decisions/ADR-003-subscriber-balance-vs-delivery-payments.md` (منطق الرصيد مقابل مدفوعات التسليم).
