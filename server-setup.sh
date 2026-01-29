#!/usr/bin/env bash
# Sama Water — تنفيذ على السيرفر بعد git clone (sama.baitpait.space)
# يشغّل: composer install, .env من قالب، key:generate، صلاحيات، كاش، migrate، storage:link

set -e
cd "$(dirname "${BASH_SOURCE[0]}")"

if [[ ! -f artisan ]]; then
  echo "خطأ: شغّل السكربت من جذر المشروع (يجب وجود artisan)."
  exit 1
fi

echo "[1/7] تثبيت اعتماديات PHP..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "[2/7] ملف .env..."
if [[ ! -f .env ]]; then
  if [[ -f env.sama.production.example ]]; then
    cp env.sama.production.example .env
    echo "تم نسخ env.sama.production.example إلى .env — عدّل DB_PASSWORD و APP_KEY يُنشأ تالياً."
  else
    cp .env.example .env
    echo "تم نسخ .env.example إلى .env — عدّل DB_* و APP_URL."
  fi
else
  echo "ملف .env موجود، تخطي."
fi

echo "[3/7] مفتاح التطبيق..."
php artisan key:generate --force

echo "[4/7] مسح وبناء الكاش..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[5/7] صلاحيات storage و bootstrap/cache و .env..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod 600 .env 2>/dev/null || true

echo "[6/7] ربط التخزين..."
php artisan storage:link 2>/dev/null || true

echo "[7/7] تنفيذ Migrations..."
php artisan migrate --force

echo "——— انتهى. عدّل .env (DB_PASSWORD و APP_URL) إن لم تكن قد عدّلتهما، ثم اختبر: https://sama.baitpait.space"
