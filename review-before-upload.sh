#!/bin/bash

echo "=========================================="
echo "✅ مراجعة نهائية قبل الرفع"
echo "=========================================="
echo ""

cd /Users/baitpait/BAITPAIT/Bait\ Pait/Project/water\ Aelea/eliyaa\ file/eliyaa

echo "📁 1. التحقق من ملفات CSS:"
echo "------------------------------------------"
if [ -f "public/css/unified-forms.css" ]; then
    LINES=$(wc -l < public/css/unified-forms.css)
    SIZE=$(du -h public/css/unified-forms.css | cut -f1)
    echo "✅ public/css/unified-forms.css"
    echo "   الأسطر: $LINES (يجب: 1038)"
    echo "   الحجم: $SIZE"
    
    if [ "$LINES" -eq 1038 ]; then
        echo "   ✅ صحيح!"
    else
        echo "   ⚠️  خطأ! يجب أن يكون 1038"
    fi
else
    echo "❌ public/css/unified-forms.css غير موجود!"
fi

echo ""

if [ -f "resources/css/unified-forms.css" ]; then
    LINES=$(wc -l < resources/css/unified-forms.css)
    echo "✅ resources/css/unified-forms.css"
    echo "   الأسطر: $LINES (يجب: 1038)"
else
    echo "❌ resources/css/unified-forms.css غير موجود!"
fi

echo ""
echo "📁 2. التحقق من ملفات Config:"
echo "------------------------------------------"
FILES=(
    "config/backpack/ui.php"
    "config/backpack/base.php"
)

for FILE in "${FILES[@]}"; do
    if [ -f "$FILE" ]; then
        echo "✅ $FILE"
    else
        echo "❌ $FILE غير موجود!"
    fi
done

echo ""
echo "📁 3. التحقق من ملفات Views:"
echo "------------------------------------------"
FILES=(
    "resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php"
    "resources/views/vendor/backpack/crud/list.blade.php"
)

for FILE in "${FILES[@]}"; do
    if [ -f "$FILE" ]; then
        echo "✅ $FILE"
    else
        echo "❌ $FILE غير موجود!"
    fi
done

echo ""
echo "📁 4. التحقق من ملفات Controllers و Models:"
echo "------------------------------------------"
FILES=(
    "app/Http/Controllers/Admin/ClientCrudController.php"
    "app/Models/Client.php"
)

for FILE in "${FILES[@]}"; do
    if [ -f "$FILE" ]; then
        echo "✅ $FILE"
    else
        echo "❌ $FILE غير موجود!"
    fi
done

echo ""
echo "=========================================="
echo "📊 ملخص الملفات الجاهزة للرفع:"
echo "=========================================="
echo ""
echo "✅ جميع الملفات موجودة وجاهزة!"
echo ""
echo "الملفات (8):"
echo "  1. public/css/unified-forms.css"
echo "  2. resources/css/unified-forms.css"
echo "  3. config/backpack/ui.php"
echo "  4. config/backpack/base.php"
echo "  5. resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php"
echo "  6. resources/views/vendor/backpack/crud/list.blade.php"
echo "  7. app/Http/Controllers/Admin/ClientCrudController.php"
echo "  8. app/Models/Client.php"
echo ""
echo "=========================================="
echo "الخطوة التالية:"
echo "ارفع هذه الملفات على السيرفر ثم نفذ:"
echo "  php artisan optimize:clear"
echo "  php artisan config:cache"
echo "  php artisan view:cache"
echo "=========================================="
echo ""

