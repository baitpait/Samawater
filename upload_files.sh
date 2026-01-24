#!/bin/bash
# سكريبت رفع الملفات المعدلة على السيرفر

echo "🚀 بدء عملية الرفع..."

# معلومات السيرفر (عدّل هذه القيم)
SERVER_USER="username"
SERVER_IP="eliyaa.baitpait.space"
SERVER_PATH="/home/username/public_html"  # أو المسار الصحيح لمشروعك

# الملفات للرفع
FILES=(
    "resources/views/admin/delivery_list.blade.php"
    "resources/views/admin/reports/clients_delivery_overview.blade.php"
    "resources/views/vendor/backpack/ui/inc/menu_items.blade.php"
    "resources/views/vendor/backpack/crud/list.blade.php"
    "vendor/backpack/theme-coreuiv2/resources/views/inc/sidebar.blade.php"
    "public/logo/Logo-2.png"
)

echo "📤 رفع الملفات..."
for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "  ✅ رفع: $file"
        scp "$file" "$SERVER_USER@$SERVER_IP:$SERVER_PATH/$file"
    else
        echo "  ⚠️  الملف غير موجود: $file"
    fi
done

echo ""
echo "✅ تم رفع الملفات!"
echo ""
echo "📋 الخطوات التالية على السيرفر:"
echo "  1. ssh $SERVER_USER@$SERVER_IP"
echo "  2. cd $SERVER_PATH"
echo "  3. php artisan view:clear"
echo "  4. php artisan cache:clear"
echo "  5. php artisan config:clear"
echo "  6. php artisan config:cache"
echo "  7. php artisan route:cache"
echo "  8. php artisan view:cache"
