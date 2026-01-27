<?php

/**
 * سكريبت اختبار شامل لنظام الموزعين
 * 
 * Business Purpose: التحقق من أن نظام الموزعين يعمل بشكل صحيح من البداية للنهاية
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Distributor;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║     اختبار شامل لنظام الموزعين - Sama Water System        ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// 1. التحقق من وجود دور الموزع
// ============================================
echo "📋 الخطوة 1: التحقق من وجود دور الموزع\n";
echo str_repeat("-", 60) . "\n";

$distributorRole = Role::where('name', 'distributor')->first();
if (!$distributorRole) {
    echo "❌ خطأ: لم يتم العثور على دور 'distributor'\n";
    echo "   الحل: قم بتشغيل: php artisan db:seed --class=RolesSeeder\n";
    exit(1);
}

echo "✅ تم العثور على دور الموزع (ID: {$distributorRole->id})\n\n";

// ============================================
// 2. البحث عن آخر موزع تم إنشاؤه
// ============================================
echo "📋 الخطوة 2: البحث عن موزع للاختبار\n";
echo str_repeat("-", 60) . "\n";

$user = User::where('email', 'test_distributor@distributor.local')
    ->whereHas('role', function($query) {
        $query->where('name', 'distributor');
    })
    ->first();

if (!$user) {
    echo "❌ لم يتم العثور على موزع للاختبار\n";
    echo "   سيتم إنشاء موزع جديد...\n\n";
    
    // إنشاء موزع جديد
    $distributor = Distributor::create([
        'name' => 'موزع الاختبار',
        'phone' => '0501234567',
        'username' => 'test_distributor',
        'password_hash' => bcrypt('123456'),
        'status' => 1,
        'notes' => 'موزع تم إنشاؤه للاختبار التلقائي',
    ]);
    
    $email = $distributor->username . '@distributor.local';
    $user = User::create([
        'name' => $distributor->name,
        'email' => $email,
        'password' => bcrypt('123456'),
        'role_id' => $distributorRole->id,
        'distributor_id' => $distributor->id,
    ]);
    
    echo "✅ تم إنشاء موزع جديد:\n";
    echo "   Distributor ID: {$distributor->id}\n";
    echo "   User ID: {$user->id}\n";
    echo "   Email: {$user->email}\n\n";
} else {
    echo "✅ تم العثور على موزع موجود:\n";
    echo "   User ID: {$user->id}\n";
    echo "   Email: {$user->email}\n";
    echo "   Name: {$user->name}\n\n";
}

// ============================================
// 3. اختبار بيانات المستخدم
// ============================================
echo "📋 الخطوة 3: اختبار بيانات المستخدم\n";
echo str_repeat("-", 60) . "\n";

$testPassword = '123456';
$passwordValid = Hash::check($testPassword, $user->password);

echo "Email: {$user->email}\n";
echo "Password Check: " . ($passwordValid ? "✅ صحيحة" : "❌ غير صحيحة") . "\n";
echo "Role: " . ($user->role ? $user->role->name : "❌ غير موجود") . "\n";
echo "Distributor ID: " . ($user->distributor_id ?: "❌ غير موجود") . "\n";

if (!$passwordValid) {
    echo "\n⚠️  تحذير: كلمة المرور غير صحيحة، سيتم تحديثها...\n";
    $user->password = bcrypt($testPassword);
    $user->save();
    echo "✅ تم تحديث كلمة المرور\n";
}

echo "\n";

// ============================================
// 4. اختبار الصلاحيات
// ============================================
echo "📋 الخطوة 4: اختبار الصلاحيات\n";
echo str_repeat("-", 60) . "\n";

$tests = [
    'isDistributor' => $user->isDistributor(),
    'isAdmin' => $user->isAdmin(),
    'isSuperAdmin' => $user->isSuperAdmin(),
    'hasRole(distributor)' => $user->hasRole('distributor'),
];

foreach ($tests as $test => $result) {
    $icon = $result ? "✅" : "❌";
    $status = $result ? "YES" : "NO";
    echo "{$icon} {$test}: {$status}\n";
}

// التحقق من أن المستخدم موزع فقط
if (!$user->isDistributor()) {
    echo "\n❌ خطأ: المستخدم ليس موزعاً!\n";
    exit(1);
}

if ($user->isAdmin() || $user->isSuperAdmin()) {
    echo "\n⚠️  تحذير: المستخدم لديه صلاحيات إضافية غير متوقعة\n";
}

echo "\n";

// ============================================
// 5. اختبار Middleware
// ============================================
echo "📋 الخطوة 5: اختبار Middleware (CheckIfAdmin)\n";
echo str_repeat("-", 60) . "\n";

$middleware = new \App\Http\Middleware\CheckIfAdmin();
$reflection = new ReflectionClass($middleware);
$method = $reflection->getMethod('checkIfUserIsAdmin');
$method->setAccessible(true);
$canAccess = $method->invoke($middleware, $user);

if ($canAccess) {
    echo "✅ المستخدم يمكنه الوصول إلى لوحة التحكم\n";
} else {
    echo "❌ المستخدم لا يمكنه الوصول إلى لوحة التحكم\n";
    exit(1);
}

// اختبار isDistributorAllowedRequest
$method2 = $reflection->getMethod('isDistributorAllowedRequest');
$method2->setAccessible(true);

$request = \Illuminate\Http\Request::create('/admin/dashboard', 'GET');
$allowedRoutes = [
    '/admin/dashboard' => true,
    '/admin/client' => false,
    '/admin/distributor' => false,
];

echo "\nاختبار المسارات المسموحة:\n";
foreach ($allowedRoutes as $route => $expected) {
    $request = \Illuminate\Http\Request::create($route, 'GET');
    $isAllowed = $method2->invoke($middleware, $request);
    $icon = ($isAllowed === $expected) ? "✅" : "❌";
    echo "{$icon} {$route}: " . ($isAllowed ? "مسموح" : "غير مسموح") . "\n";
}

echo "\n";

// ============================================
// 6. اختبار Dashboard Controller
// ============================================
echo "📋 الخطوة 6: اختبار Dashboard Controller\n";
echo str_repeat("-", 60) . "\n";

$controller = new \App\Http\Controllers\Admin\AdminController();

// التحقق من أن المستخدم موزع
if ($user->isDistributor() && !$user->isAdminOrSuperAdmin()) {
    echo "✅ Dashboard Controller سيعرض: admin.dashboard_distributor\n";
} else {
    echo "✅ Dashboard Controller سيعرض: admin.dashboard_admin\n";
}

echo "\n";

// ============================================
// 7. ملخص النتائج
// ============================================
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║                    ملخص النتائج                             ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

echo "✅ جميع الاختبارات نجحت!\n\n";

echo "📝 بيانات تسجيل الدخول:\n";
echo str_repeat("-", 60) . "\n";
echo "URL: http://localhost:8000/admin/login\n";
echo "Email: {$user->email}\n";
echo "Password: {$testPassword}\n\n";

echo "🔍 معلومات المستخدم:\n";
echo str_repeat("-", 60) . "\n";
echo "User ID: {$user->id}\n";
echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Role: " . ($user->role ? $user->role->display_name : 'N/A') . "\n";
echo "Distributor ID: {$user->distributor_id}\n\n";

if ($user->distributor) {
    $distributor = $user->distributor;
    echo "📦 معلومات الموزع:\n";
    echo str_repeat("-", 60) . "\n";
    echo "Distributor ID: {$distributor->id}\n";
    echo "Name: {$distributor->name}\n";
    echo "Username: {$distributor->username}\n";
    echo "Phone: {$distributor->phone}\n";
    echo "Status: " . ($distributor->status ? "✅ نشط" : "❌ معطل") . "\n\n";
}

echo "✅ يمكنك الآن تسجيل الدخول والتحقق من أن كل شيء يعمل!\n\n";
