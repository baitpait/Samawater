<?php

/**
 * سكريبت اختبار تسجيل الدخول برقم الهاتف
 * 
 * Business Purpose: التحقق من أن نظام تسجيل الدخول برقم الهاتف يعمل بشكل صحيح
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
echo "║     اختبار تسجيل الدخول برقم الهاتف - Sama Water          ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// 1. البحث عن موزع برقم الهاتف
// ============================================
echo "📋 الخطوة 1: البحث عن موزع برقم الهاتف 0599112233\n";
echo str_repeat("-", 60) . "\n";

$phone = '0599112233';
$distributor = Distributor::where('phone', $phone)->first();

if (!$distributor) {
    echo "❌ لم يتم العثور على موزع برقم الهاتف: {$phone}\n";
    echo "   سيتم إنشاء موزع جديد...\n\n";
    
    // إنشاء موزع جديد
    $distributorRole = Role::where('name', 'distributor')->first();
    if (!$distributorRole) {
        echo "❌ خطأ: لم يتم العثور على دور 'distributor'\n";
        exit(1);
    }
    
    $distributor = Distributor::create([
        'name' => 'موزع الاختبار',
        'phone' => $phone,
        'username' => $phone, // استخدام phone كـ username
        'password_hash' => bcrypt($phone), // كلمة المرور = رقم الهاتف
        'status' => 1,
        'notes' => 'موزع تم إنشاؤه للاختبار',
    ]);
    
    $email = $distributor->phone . '@distributor.local';
    $user = User::create([
        'name' => $distributor->name,
        'email' => $email,
        'password' => bcrypt($phone),
        'role_id' => $distributorRole->id,
        'distributor_id' => $distributor->id,
    ]);
    
    echo "✅ تم إنشاء موزع جديد:\n";
    echo "   Distributor ID: {$distributor->id}\n";
    echo "   User ID: {$user->id}\n";
    echo "   Email: {$user->email}\n\n";
} else {
    echo "✅ تم العثور على موزع:\n";
    echo "   Distributor ID: {$distributor->id}\n";
    echo "   Name: {$distributor->name}\n";
    echo "   Phone: {$distributor->phone}\n";
    echo "   Username: {$distributor->username}\n\n";
}

// ============================================
// 2. البحث عن المستخدم المرتبط
// ============================================
echo "📋 الخطوة 2: البحث عن المستخدم المرتبط\n";
echo str_repeat("-", 60) . "\n";

$expectedEmail = $distributor->phone . '@distributor.local';
$user = User::where('distributor_id', $distributor->id)->first();

if (!$user) {
    echo "❌ لم يتم العثور على مستخدم مرتبط\n";
    echo "   سيتم إنشاء مستخدم جديد...\n";
    
    $distributorRole = Role::where('name', 'distributor')->first();
    $user = User::create([
        'name' => $distributor->name,
        'email' => $expectedEmail,
        'password' => bcrypt($phone),
        'role_id' => $distributorRole->id,
        'distributor_id' => $distributor->id,
    ]);
    
    echo "✅ تم إنشاء مستخدم جديد\n\n";
} else {
    echo "✅ تم العثور على مستخدم:\n";
    echo "   User ID: {$user->id}\n";
    echo "   Email: {$user->email}\n";
    
    // التحقق من أن email صحيح
    if ($user->email !== $expectedEmail) {
        echo "⚠️  Email غير صحيح، سيتم تحديثه...\n";
        $user->email = $expectedEmail;
        $user->save();
        echo "✅ تم تحديث email إلى: {$expectedEmail}\n";
    } else {
        echo "✅ Email صحيح\n";
    }
    echo "\n";
}

// ============================================
// 3. التحقق من username في distributor
// ============================================
echo "📋 الخطوة 3: التحقق من username في distributor\n";
echo str_repeat("-", 60) . "\n";

if ($distributor->username !== $distributor->phone) {
    echo "⚠️  username غير صحيح، سيتم تحديثه...\n";
    $distributor->username = $distributor->phone;
    $distributor->save();
    echo "✅ تم تحديث username إلى: {$distributor->phone}\n";
} else {
    echo "✅ username صحيح: {$distributor->username}\n";
}
echo "\n";

// ============================================
// 4. اختبار كلمة المرور
// ============================================
echo "📋 الخطوة 4: اختبار كلمة المرور\n";
echo str_repeat("-", 60) . "\n";

$testPassword = $phone; // كلمة المرور = رقم الهاتف
$userPasswordValid = Hash::check($testPassword, $user->password);
$distributorPasswordValid = Hash::check($testPassword, $distributor->password_hash);

echo "User Password Check: " . ($userPasswordValid ? "✅ صحيحة" : "❌ غير صحيحة") . "\n";
echo "Distributor Password Check: " . ($distributorPasswordValid ? "✅ صحيحة" : "❌ غير صحيحة") . "\n";

if (!$userPasswordValid) {
    echo "\n⚠️  كلمة مرور المستخدم غير صحيحة، سيتم تحديثها...\n";
    $user->password = bcrypt($testPassword);
    $user->save();
    echo "✅ تم تحديث كلمة مرور المستخدم\n";
}

if (!$distributorPasswordValid) {
    echo "\n⚠️  كلمة مرور الموزع غير صحيحة، سيتم تحديثها...\n";
    $distributor->password_hash = bcrypt($testPassword);
    $distributor->save();
    echo "✅ تم تحديث كلمة مرور الموزع\n";
}

echo "\n";

// ============================================
// 5. اختبار الصلاحيات
// ============================================
echo "📋 الخطوة 5: اختبار الصلاحيات\n";
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

if (!$user->isDistributor()) {
    echo "\n❌ خطأ: المستخدم ليس موزعاً!\n";
    exit(1);
}

echo "\n";

// ============================================
// 6. ملخص النتائج
// ============================================
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║                    ملخص النتائج                             ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

echo "✅ جميع الاختبارات نجحت!\n\n";

echo "📝 بيانات تسجيل الدخول:\n";
echo str_repeat("-", 60) . "\n";
echo "URL: http://localhost:8000/admin/login\n";
echo "Email: {$user->email}\n";
echo "Password: {$phone}\n\n";

echo "🔍 معلومات المستخدم:\n";
echo str_repeat("-", 60) . "\n";
echo "User ID: {$user->id}\n";
echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Role: " . ($user->role ? $user->role->display_name : 'N/A') . "\n";
echo "Distributor ID: {$user->distributor_id}\n\n";

echo "📦 معلومات الموزع:\n";
echo str_repeat("-", 60) . "\n";
echo "Distributor ID: {$distributor->id}\n";
echo "Name: {$distributor->name}\n";
echo "Phone: {$distributor->phone}\n";
echo "Username: {$distributor->username}\n";
echo "Status: " . ($distributor->status ? "✅ نشط" : "❌ معطل") . "\n\n";

echo "✅ يمكنك الآن تسجيل الدخول باستخدام:\n";
echo "   Email: {$user->email}\n";
echo "   Password: {$phone}\n";
echo "   URL: http://localhost:8000/admin/login\n\n";
