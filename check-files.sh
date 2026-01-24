#!/bin/bash

echo "=========================================="
echo "🔍 التحقق من ملفات النظام قبل الرفع"
echo "=========================================="
echo ""

# الانتقال لمجلد المشروع
cd /home/sarfesak/public_html/eliyaa

echo "📁 1. التحقق من ملفات CSS:"
echo "------------------------------------------"
if [ -f "public/css/unified-forms.css" ]; then
    LINES=$(wc -l < public/css/unified-forms.css)
    SIZE=$(du -h public/css/unified-forms.css | cut -f1)
    echo "✅ public/css/unified-forms.css موجود"
    echo "   📊 الأسطر: $LINES (يجب أن يكون 1038)"
    echo "   💾 الحجم: $SIZE"
    
    if [ "$LINES" -eq 1038 ]; then
        echo "   ✅ عدد الأسطر صحيح!"
    else
        echo "   ❌ عدد الأسطر غير صحيح! يجب أن يكون 1038"
    fi
else
    echo "❌ public/css/unified-forms.css غير موجود!"
fi

echo ""

if [ -f "resources/css/unified-forms.css" ]; then
    LINES=$(wc -l < resources/css/unified-forms.css)
    echo "✅ resources/css/unified-forms.css موجود"
    echo "   📊 الأسطر: $LINES (يجب أن يكون 1038)"
else
    echo "❌ resources/css/unified-forms.css غير موجود!"
fi

echo ""
echo "📁 2. التحقق من ملفات Config:"
echo "------------------------------------------"
if [ -f "config/backpack/ui.php" ]; then
    echo "✅ config/backpack/ui.php موجود"
else
    echo "❌ config/backpack/ui.php غير موجود!"
fi

if [ -f "config/backpack/base.php" ]; then
    echo "✅ config/backpack/base.php موجود"
else
    echo "❌ config/backpack/base.php غير موجود!"
fi

echo ""
echo "📁 3. التحقق من ملفات Views:"
echo "------------------------------------------"
if [ -f "resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php" ]; then
    echo "✅ menu_user_dropdown.blade.php موجود"
else
    echo "❌ menu_user_dropdown.blade.php غير موجود!"
    echo "   يجب إنشاء المجلد: mkdir -p resources/views/vendor/backpack/theme-coreuiv2/inc"
fi

echo ""
echo "📁 4. التحقق من Controllers:"
echo "------------------------------------------"
if [ -f "app/Http/Controllers/Admin/ClientCrudController.php" ]; then
    echo "✅ ClientCrudController.php موجود"
else
    echo "❌ ClientCrudController.php غير موجود!"
fi

echo ""
echo "📁 5. التحقق من الأذونات:"
echo "------------------------------------------"
echo "Checking permissions..."

check_perms() {
    FILE=$1
    if [ -f "$FILE" ]; then
        PERMS=$(stat -c '%a' "$FILE" 2>/dev/null || stat -f '%A' "$FILE" 2>/dev/null)
        OWNER=$(stat -c '%U:%G' "$FILE" 2>/dev/null || stat -f '%Su:%Sg' "$FILE" 2>/dev/null)
        echo "   $FILE"
        echo "      أذونات: $PERMS (يجب: 644)"
        echo "      المالك: $OWNER (يفضل: sarfesak:sarfesak)"
    fi
}

check_perms "public/css/unified-forms.css"
check_perms "config/backpack/ui.php"

echo ""
echo "=========================================="
echo "✅ انتهى التحقق"
echo "=========================================="
echo ""
echo "الخطوات التالية:"
echo "1. إذا كانت الملفات غير موجودة: ارفعها من جهازك"
echo "2. إذا كانت الأذونات خاطئة: نفذ:"
echo "   chmod 644 public/css/unified-forms.css"
echo "   chown sarfesak:sarfesak public/css/unified-forms.css"
echo "3. بعد رفع الملفات: امسح الكاش:"
echo "   php artisan optimize:clear"
echo ""

