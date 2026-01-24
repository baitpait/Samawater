#!/bin/bash

# Script لإنشاء الملفات مباشرة على السيرفر VPS Ubuntu
# بدلاً من رفعها واحدة تلو الأخرى

echo "=========================================="
echo "🚀 إنشاء الملفات مباشرة على السيرفر"
echo "=========================================="

cd /home/sarfesak/public_html/eliyaa

# إنشاء المجلدات المطلوبة
echo "📁 إنشاء المجلدات..."
mkdir -p resources/views/vendor/backpack/theme-coreuiv2/inc
mkdir -p storage/app/backups
mkdir -p public/css
mkdir -p resources/css

# إصلاح الأذونات
chmod 775 storage/app/backups
chown sarfesak:sarfesak storage/app/backups

echo "✅ تم إنشاء المجلدات"

echo ""
echo "📝 إنشاء الملفات..."

# 1. إنشاء public/css/unified-forms.css
echo "1/11: إنشاء public/css/unified-forms.css..."
cat > public/css/unified-forms.css << 'EOF'
/**
 * ============================================
 * Unified Forms Design System
 * توحيد تصميم النماذج في جميع أنحاء النظام
 * ============================================
 *
 * الألوان الأساسية:
 * - البنفسجي: #6f6af8, #7c7cff
 * - الأخضر: #34d399, #22c55e
 */

/* ============================================
   Filter Cards (بطاقات الفلاتر)
   ============================================ */
.filter-card {
    background: #fcfdff;
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.filter-card .card-body {
    padding: 1.5rem;
}

/* ============================================
   Form Labels (تسميات الحقول)
   ============================================ */
.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #55607b;
    margin-bottom: 8px;
    display: block;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.form-label.required::after {
    content: ' *';
    color: #ef4444;
}

/* ============================================
   Form Controls (حقول الإدخال)
   ============================================ */
.form-control,
.form-select,
.modern-input {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    transition: all 0.2s ease;
    background: #ffffff;
}

.form-control:focus,
.form-select:focus,
.modern-input:focus {
    border-color: #6f6af8;
    box-shadow: 0 0 0 3px rgba(111, 106, 248, 0.1);
    outline: none;
}

.form-control::placeholder,
.modern-input::placeholder {
    color: #9ca3af;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ============================================
   Buttons (الأزرار)
   ============================================ */
.btn {
    border-radius: 12px !important;
    font-weight: 600 !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    transition: all 0.2s ease !important;
    border: none !important;
}

.btn-primary {
    background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
    color: #ffffff !important;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5b56d6 0%, #6b6be8 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(111, 106, 248, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, #34d399 0%, #22c55e 100%) !important;
    color: #ffffff !important;
}

.btn-success:hover {
    background: linear-gradient(135deg, #10b981 0%, #16a34a 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(52, 211, 153, 0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    color: #ffffff !important;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* ============================================
   Cards (البطاقات)
   ============================================ */
.card {
    border: none !important;
    border-radius: 20px !important;
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06) !important;
    overflow: hidden !important;
}

.card-header {
    background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
    color: #ffffff !important;
    border: none !important;
    padding: 1.5rem !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    font-weight: 600 !important;
}

.card-body {
    padding: 2rem !important;
    background: #ffffff !important;
}

/* ============================================
   Tables (الجداول)
   ============================================ */
.table {
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05) !important;
}

.table thead th {
    background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
    color: #ffffff !important;
    border: none !important;
    font-weight: 600 !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    padding: 1rem !important;
    text-align: center !important;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background: rgba(111, 106, 248, 0.05) !important;
}

.table tbody td {
    border: none !important;
    padding: 1rem !important;
    vertical-align: middle !important;
    text-align: center !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

/* ============================================
   Sidebar (القائمة الجانبية)
   ============================================ */

/* High Specificity Selectors for Sidebar */
body .sidebar .nav,
body .sidebar .navbar-nav,
body aside .nav,
body aside .navbar-nav,
.sidebar .nav,
.sidebar .navbar-nav {
    padding: 0.5rem 0 !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

/* Sidebar Logo */
.sidebar-logo-wrapper {
    padding: 1.5rem !important;
    text-align: center !important;
    border-bottom: 1px solid #e5e7eb !important;
    margin-bottom: 1rem !important;
}

.sidebar-logo {
    max-width: 120px !important;
    height: auto !important;
    display: block !important;
    margin: 0 auto !important;
}

.sidebar-logo-link {
    display: block !important;
    text-decoration: none !important;
}

/* Nav Items - High Specificity */
body .sidebar .nav-item,
body aside .nav-item,
.sidebar .nav-item,
.nav-item {
    margin-bottom: 4px !important;
}

/* Nav Links - High Specificity to Override CoreUI */
body .sidebar .nav-link,
body .sidebar .navbar-nav .nav-link,
body aside .nav-link,
body aside .navbar-nav .nav-link,
.sidebar .nav-link,
.sidebar .navbar-nav .nav-link,
.sidebar.sidebar-pills .nav-link,
.nav-link {
    padding: 12px 20px !important;
    color: #374151 !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    border-radius: 12px !important;
    margin: 0 8px 4px 8px !important;
    transition: all 0.2s ease !important;
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

/* Nav Link Hover - High Specificity */
body .sidebar .nav-link:hover,
body .sidebar .navbar-nav .nav-link:hover,
body aside .nav-link:hover,
body aside .navbar-nav .nav-link:hover,
.sidebar .nav-link:hover,
.sidebar .navbar-nav .nav-link:hover,
.sidebar.sidebar-pills .nav-link:hover,
.nav-link:hover {
    background: linear-gradient(135deg, rgba(111, 106, 248, 0.1) 0%, rgba(124, 124, 255, 0.1) 100%) !important;
    color: #6f6af8 !important;
    transform: translateX(-4px) !important;
}

/* Nav Link Active - High Specificity */
body .sidebar .nav-link.active,
body .sidebar .nav-link[aria-current="page"],
body .sidebar .navbar-nav .nav-link.active,
body .sidebar .navbar-nav .nav-link[aria-current="page"],
body aside .nav-link.active,
body aside .nav-link[aria-current="page"],
.sidebar .nav-link.active,
.sidebar .nav-link[aria-current="page"],
.sidebar.sidebar-pills .nav-link.active,
.nav-link.active,
.nav-link[aria-current="page"] {
    background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(111, 106, 248, 0.3) !important;
}

body .sidebar .nav-link.active:hover,
body .sidebar .nav-link[aria-current="page"]:hover,
body .sidebar .navbar-nav .nav-link.active:hover,
body .sidebar .navbar-nav .nav-link[aria-current="page"]:hover,
body aside .nav-link.active:hover,
body aside .nav-link[aria-current="page"]:hover,
.sidebar .nav-link.active:hover,
.sidebar .nav-link[aria-current="page"]:hover,
.sidebar.sidebar-pills .nav-link.active:hover,
.nav-link.active:hover,
.nav-link[aria-current="page"]:hover {
    background: linear-gradient(135deg, #5b56d6 0%, #6b6be8 100%) !important;
    transform: translateX(-4px) !important;
}

/* Nav Icons - High Specificity */
body .sidebar .nav-link i,
body .sidebar .nav-link .nav-icon,
body .sidebar .nav-link .la,
body aside .nav-link i,
body aside .nav-link .nav-icon,
body aside .nav-link .la,
.sidebar .nav-link i,
.sidebar .nav-link .nav-icon,
.sidebar .nav-link .la,
.nav-link i,
.nav-link .nav-icon,
.nav-link .la {
    font-size: 18px !important;
    width: 24px !important;
    text-align: center !important;
    color: inherit !important;
}

/* Sidebar Divider */
.sidebar-divider {
    height: 1px !important;
    background: #e5e7eb !important;
    margin: 12px 16px !important;
    border: none !important;
}

/* Dropdown Menu in Sidebar */
.sidebar .nav-dropdown,
.sidebar .dropdown-menu {
    background: #f9fafb !important;
    border: none !important;
    border-radius: 12px !important;
    margin: 4px 8px !important;
    padding: 8px !important;
    box-shadow: none !important;
}

.sidebar .nav-dropdown .nav-link {
    padding: 10px 16px !important;
    margin: 2px 0 !important;
    font-size: 13px !important;
}

.sidebar .nav-dropdown .nav-link:hover {
    background: rgba(111, 106, 248, 0.1) !important;
    color: #6f6af8 !important;
}

/* RTL Support */
[dir="rtl"] .nav-link:hover {
    transform: translateX(4px) !important;
}

[dir="rtl"] .nav-link.active:hover,
[dir="rtl"] .nav-link[aria-current="page"]:hover {
    transform: translateX(4px) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .nav-link {
        padding: 10px 16px !important;
        font-size: 13px !important;
    }

    .nav-link i,
    .nav-link .nav-icon,
    .nav-link .la {
        font-size: 16px !important;
        width: 20px !important;
    }
}
EOF

# 2. إنشاء resources/css/unified-forms.css (نفس المحتوى)
echo "2/11: إنشاء resources/css/unified-forms.css..."
cp public/css/unified-forms.css resources/css/unified-forms.css

# 3. إنشاء config/backpack/ui.php
echo "3/11: إنشاء config/backpack/ui.php..."
cat > config/backpack/ui.php << 'EOF'
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme (User Interface)
    |--------------------------------------------------------------------------
    */
    // Change the view namespace in order to load a different theme than the one Backpack provides.
    // You can create child themes yourself, by creating a view folder anywhere in your resources/views
    // and choosing that view_namespace instead of the default one. Backpack will load a file from there
    // if it exists, otherwise it will load it from the fallback namespace.

    'view_namespace' => 'backpack.theme-coreuiv2::',
    'view_namespace' => 'backpack.theme-coreuiv2::',
    /*
    |--------------------------------------------------------------------------
    | Look & feel customizations
    |--------------------------------------------------------------------------
    |
    | To make the UI feel yours.
    |
    | Note that values set here might be overridden by theme config files
    | (eg. config/backpack/theme-tabler.php) when that theme is in use.
    |
    */

    // Date & Datetime Format Syntax: https://carbon.nesbot.com/docs/#api-localization
    'default_date_format' => 'D MMM YYYY',
    'default_datetime_format' => 'D MMM YYYY, HH:mm',

    // Direction, according to language
    // (left-to-right vs right-to-left)
    'html_direction' => 'rtl',

    // ----
    // HEAD
    // ----

    // Project name - shown in the window title
    'project_name' => 'مياه ايلياء',
    'theme' => 'backpack/backpack.theme-coreuiv2',

    // Content of the HTML meta robots tag to prevent indexing and link following
    'meta_robots_content' => 'noindex, nofollow',

    // ------
    // HEADER
    // ------

    // When clicking on the admin panel's top-left logo/name,
    // where should the user be redirected?
    // The string below will be passed through the url() helper.
    // - default: '' (project root)
    // - alternative: 'admin' (the admin's dashboard)
    'home_link' => '',

    // Menu logo. You can replace this with an <img> tag if you have a logo.
    'project_logo' => false,  // تم إخفاء الشعار

    // Show / hide breadcrumbs on admin panel pages.
    'breadcrumbs' => false,

    // ------
    // FOOTER
    // ------

    // Developer or company name. Shown in footer.
    'developer_name' => 'تم التطوير بواسطة بيت البرمجيات وتكنولوجيا المعلومات',

    // Developer website. Link in footer. Type false if you want to hide it.
    'developer_link' => 'https://baitpait.com/',

    // Show powered by Laravel Backpack in the footer? true/false
    'show_powered_by' => false,

    // ---------
    // DASHBOARD
    // ---------

    // Show "Getting Started with Backpack" info block?
    'show_getting_started' => env('APP_ENV') == 'false',

    // -------------
    // GLOBAL STYLES
    // -------------

    // CSS files that are loaded in all pages, using Laravel's asset() helper
    'styles' => [
        // 'css/unified-forms.css', // سيتم تحميله عبر @push في views
    ],

    // CSS files that are loaded in all pages, using Laravel's mix() helper
    'mix_styles' => [ // file_path => manifest_directory_path
        // 'css/app.css' => '',
    ],

    // CSS files that are loaded in all pages, using Laravel's @vite() helper
    // Please note that support for Vite was added in Laravel 9.19. Earlier versions are not able to use this feature.
    'vite_styles' => [ // resource file_path
        // 'resources/css/app.css',
    ],

    // --------------
    // JAVASCRIPT
    // --------------

    // JS files that are loaded in all pages, using Laravel's asset() helper
    'scripts' => [
        // 'js/app.js',
    ],

    // JS files that are loaded in all pages, using Laravel's mix() helper
    'mix_scripts' => [ // file_path => manifest_directory_path
        // 'js/app.js' => '',
    ],

    // JS files that are loaded in all pages, using Laravel's @vite() helper
    // Please note that support for Vite was added in Laravel 9.19. Earlier versions are not able to use this feature.
    'vite_scripts' => [ // resource file_path
        // 'resources/js/app.js',
    ],

    // -------------
    // GLOBAL SCRIPTS
    // -------------

    // Custom JavaScript code that will run on every admin panel page
    'scripts_code' => '
        // Your custom JavaScript code here
    ',

    // -------------
    // PAGE SPECIFIC
    // -------------

    // Load different assets on different pages
    'page_specific' => [
        // 'admin/dashboard' => [
        //     'styles' => ['css/dashboard.css'],
        //     'scripts' => ['js/dashboard.js'],
        // ],
    ],
];
EOF

# 4. إنشاء config/backpack/base.php
echo "4/11: إنشاء config/backpack/base.php..."
cat > config/backpack/base.php << 'EOF'
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backpack Base Configuration
    |--------------------------------------------------------------------------
    |
    | This is where you can configure Backpack Base to your liking.
    |
    */

    // The prefix for the admin panel route
    'route_prefix' => 'admin',

    // The guard to use for authentication
    'guard' => 'web',

    // The user model to use for authentication
    'user_model' => App\Models\User::class,

    // The password broker to use for password reset
    'passwords' => 'backpack',

    // Avatar configuration
    'avatar_type' => null,  // لا يوجد avatar

    // Gravatar fallback options are 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank'
    'gravatar_fallback' => 'blank',

    /*
    |--------------------------------------------------------------------------
    | Admin panel route middleware
    |--------------------------------------------------------------------------
    |
    | This is the middleware that will be applied to the admin panel routes.
    | You can add your own middleware here.
    |
    */

    'middleware_class' => [
        // Add your own middleware here
    ],

    'middleware_key' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | File System
    |--------------------------------------------------------------------------
    */

    // Backpack\Base sets up its own filesystem disk, just like you would by
    // creating one in config/filesystems.php
    'disk_name' => 'backpack',

    /*
    |--------------------------------------------------------------------------
    | Backpack Routes
    |--------------------------------------------------------------------------
    |
    | This is where you can configure the routes that Backpack will register.
    | You can disable routes you don't need, or add your own.
    |
    */

    'routes' => [
        'web' => [
            'enabled' => true,
            'middleware' => ['web', 'admin'],
        ],
        'api' => [
            'enabled' => false,
            'middleware' => ['api'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Backpack Setup Routes
    |--------------------------------------------------------------------------
    |
    | These are the routes that Backpack uses to set up the admin panel.
    | You can disable them if you don't need them.
    |
    */

    'setup_routes' => [
        'enabled' => true,
        'middleware' => ['web'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Backpack Auth Routes
    |--------------------------------------------------------------------------
    |
    | These are the routes that Backpack uses for authentication.
    | You can disable them if you use your own authentication.
    |
    */

    'auth_routes' => [
        'enabled' => true,
        'middleware' => ['web'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Backpack Account Routes
    |--------------------------------------------------------------------------
    |
    | These are the routes that Backpack uses for the user account pages.
    | You can disable them if you don't need them.
    |
    */

    'account_routes' => [
        'enabled' => true,
        'middleware' => ['web', 'admin'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Backpack CRUD Routes
    |--------------------------------------------------------------------------
    |
    | These are the routes that Backpack uses for CRUD operations.
    | You can disable them if you don't need them.
    |
    */

    'crud_routes' => [
        'enabled' => true,
        'middleware' => ['web', 'admin'],
    ],
];
EOF

# 5. إنشاء resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php
echo "5/11: إنشاء menu_user_dropdown.blade.php..."
cat > resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php << 'EOF'
<li class="nav-item dropdown pr-4">
  {{-- تم إخفاء Avatar بالكامل - سيظهر اسم المستخدم فقط --}}
  <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center; gap: 10px;">
    {{-- لا يوجد avatar --}}
    <span style="color: #333; font-weight: 500; font-size: 14px; font-family: 'Cairo', sans-serif;">
      {{ backpack_user()->name }}
    </span>
    <i class="la la-angle-down" style="font-size: 14px; color: #666;"></i>
  </a>
  <div class="dropdown-menu {{ backpack_theme_config('html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-4 pb-1 pt-1">
    @if(config('backpack.base.setup_my_account_routes'))
      <a class="dropdown-item" href="{{ route('backpack.account.info') }}"><i class="la la-user"></i> {{ trans('backpack::base.my_account') }}</a>
      <div class="dropdown-divider"></div>
    @endif
    <a class="dropdown-item" href="{{ backpack_url('logout') }}"><i class="la la-lock"></i> {{ trans('backpack::base.logout') }}</a>
  </div>
</li>
EOF

echo "✅ تم إنشاء الملفات بنجاح!"

echo ""
echo "=========================================="
echo "📋 ملخص الملفات المُنشأة:"
echo "=========================================="
echo "✅ 1. public/css/unified-forms.css (1038 سطر)"
echo "✅ 2. resources/css/unified-forms.css"
echo "✅ 3. config/backpack/ui.php"
echo "✅ 4. config/backpack/base.php"
echo "✅ 5. resources/views/vendor/backpack/theme-coreuiv2/inc/menu_user_dropdown.blade.php"
echo "⏳ 6-11. باقي الملفات..."
echo ""
echo "🚀 الخطوة التالية: تشغيل الجزء الثاني من السكريبت"
echo "=========================================="
EOF

<xai:function_call> <parameter name="run_terminal_cmd">
<parameter name="command">chmod +x create-files-on-server.sh && echo "✅ تم إنشاء السكريبت الأول"
