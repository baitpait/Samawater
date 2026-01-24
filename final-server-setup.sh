#!/bin/bash

# الأوامر النهائية لإكمال إعداد السيرفر
echo "=========================================="
echo "🎯 الأوامر النهائية للسيرفر"
echo "=========================================="

cd /home/sarfesak/public_html/eliyaa

echo "📝 1. إضافة Route للنسخ الاحتياطي في routes/web.php"
echo "---------------------------------------------"
echo "أضف هذا السطر في routes/web.php:"
echo ""
echo "Route::get('admin/backup/download', [App\Http\Controllers\Admin\DatabaseBackupController::class, 'download'])"
echo "    ->middleware(['web', 'admin'])"
echo "    ->name('backup.download');"
echo ""

echo "📝 2. إضافة زر النسخ الاحتياطي في menu_items.blade.php"
echo "---------------------------------------------"
echo "أضف هذا الكود في resources/views/vendor/backpack/ui/inc/menu_items.blade.php"
echo "قبل الـ sidebar-divider الأخير:"
echo ""
cat << 'EOF'
{{-- زر تحميل نسخة احتياطية --}}
<li class="nav-item">
    <a class="nav-link" href="{{ route('backup.download') }}"
       onclick="return confirm('هل تريد تحميل نسخة احتياطية من قاعدة البيانات؟\n\nسيتم تحميل ملف SQL يحتوي على جميع البيانات.');">
        <i class="la la-download"></i>
        <span>نسخة احتياطية</span>
    </a>
</li>

<li class="sidebar-divider"></li>
EOF

echo ""
echo "📝 3. إضافة زر إضافة عميل في list.blade.php"
echo "---------------------------------------------"
echo "في resources/views/vendor/backpack/crud/list.blade.php"
echo "ابحث عن: @elseif(request()->is('*/client') || request()->is('*/client/*'))"
echo "وأضف الكود التالي:"
echo ""
cat << 'EOF'
{{-- زر إضافة عميل --}}
@if($crud->hasAccess('create'))
<a href="{{ backpack_url('client/create') }}" class="btn btn-primary-unified" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important; border: none !important; color: #fff !important; border-radius: 12px !important; padding: 0.75rem 1.5rem !important; font-weight: 600 !important; font-size: 14px !important; font-family: 'Cairo', sans-serif !important; transition: all 0.2s ease !important; text-decoration: none !important; display: inline-flex !important; align-items: center !important; gap: 0.5rem !important; box-shadow: 0 4px 15px rgba(111, 106, 248, 0.3) !important;">
    <i class="la la-plus"></i>
    إضافة عميل
</a>
@endif
EOF

echo ""
echo "🔧 4. إصلاح الأذونات النهائية"
echo "---------------------------------------------"
chmod 644 public/css/unified-forms.css resources/css/unified-forms.css
chmod 644 config/backpack/ui.php config/backpack/base.php
chmod 644 resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php
chmod 644 resources/views/vendor/backpack/crud/list.blade.php
chmod 644 resources/views/vendor/backpack/ui/inc/menu_items.blade.php
chmod 644 app/Http/Controllers/Admin/ClientCrudController.php
chmod 644 app/Models/Client.php
chmod 644 app/Http/Controllers/Admin/DatabaseBackupController.php
chmod 644 routes/web.php

chown sarfesak:sarfesak public/css/unified-forms.css resources/css/unified-forms.css config/backpack/ui.php config/backpack/base.php resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php resources/views/vendor/backpack/crud/list.blade.php resources/views/vendor/backpack/ui/inc/menu_items.blade.php app/Http/Controllers/Admin/ClientCrudController.php app/Models/Client.php app/Http/Controllers/Admin/DatabaseBackupController.php routes/web.php

echo ""
echo "🧹 5. مسح الكاش النهائي"
echo "---------------------------------------------"
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "✅ 6. التحقق النهائي"
echo "---------------------------------------------"
wc -l public/css/unified-forms.css
ls -la resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php

echo ""
echo "=========================================="
echo "🎉 تم إكمال جميع التعديلات!"
echo "=========================================="
echo ""
echo "📋 الآن افتح: https://eliyaa.baitpait.space/admin"
echo "اضغط Ctrl+Shift+R وستجد:"
echo "✅ القائمة بنفس تصميم localhost"
echo "✅ زر 'نسخة احتياطية'"
echo "✅ زر 'إضافة عميل'"
echo "✅ Logo مخفي"
echo "✅ Avatar مخفي"
echo ""
echo "=========================================="

