<?php

/**
 * سكريبت اختبار وإصلاح مشاكل تسجيل الدخول
 * 
 * Business Purpose: التحقق من مشاكل تسجيل الدخول وإصلاحها تلقائياً
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
echo "║     اختبار وإصلاح مشاكل تسجيل الدخول                      ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

$phone = '0599111222';
$password = $phone;

// ============================================
// 1. البحث عن الموزع
// ============================================
echo "📋 الخطوة 1: البحث عن موزع برقم الهاتف: {$phone}\n";
echo str_repeat("-", 60) . "\n";

$distributor = Distributor::where('phone', $phone)->first();

if (!$distributor) {
    echo "❌ لم يتم العثور على موزع برقم الهاتف: {$phone}\n";
    exit(1);
}

echo "✅ تم العثور على الموزع:\n";
echo "   ID: {$distributor->id}\n";
echo "   Name: {$distributor->name}\n";
echo "   Phone: {$distributor->phone}\n";
echo "   Username: {$distributor->username}\n";
echo "   Status: " . ($distributor->status ? "✅ نشط" : "❌ معطل") . "\n\n";

// ============================================
// 2. البحث عن المستخدم المرتبط
// ============================================
echo "📋 الخطوة 2: البحث عن المستخدم المرتبط\n";
echo str_repeat("-", 60) . "\n";

$expectedEmail = $distributor->phone . '@distributor.local';
$user = User::where('distributor_id', $distributor->id)->first();

if (!$user) {
    echo "❌ لم يتم العثور على مستخدم مرتبط!\n";
    echo "   سيتم إنشاء مستخدم جديد...\n\n";
    
    $distributorRole = Role::where('name', 'distributor')->first();
    if (!$distributorRole) {
        echo "❌ خطأ: لم يتم العثور على دور 'distributor'\n";
        exit(1);
    }
    
    $user = User::create([
        'name' => $distributor->name,
        'email' => $expectedEmail,
        'password' => bcrypt($password),
        'role_id' => $distributorRole->id,
        'distributor_id' => $distributor->id,
    ]);
    
    echo "✅ تم إنشاء مستخدم جديد\n\n";
} else {
    echo "✅ تم العثور على مستخدم:\n";
    echo "   User ID: {$user->id}\n";
    echo "   Email: {$user->email}\n";
    echo "   Expected Email: {$expectedEmail}\n";
    
    // إصلاح المشاكل
    $fixed = false;
    
    // إصلاح email
    if ($user->email !== $expectedEmail) {
        echo "   ⚠️  Email غير صحيح، سيتم تحديثه...\n";
        $user->email = $expectedEmail;
        $user->save();
        echo "   ✅ تم تحديث email إلى: {$expectedEmail}\n";
        $fixed = true;
    }
    
    // إصلاح username في distributor
    if ($distributor->username !== $distributor->phone) {
        echo "   ⚠️  Username غير صحيح، سيتم تحديثه...\n";
        $distributor->username = $distributor->phone;
        $distributor->save();
        echo "   ✅ تم تحديث username إلى: {$distributor->phone}\n";
        $fixed = true;
    }
    
    if (!$fixed) {
        echo "   ✅ Email و Username صحيحان\n";
    }
    
    echo "\n";
}

// ============================================
// 3. اختبار وإصلاح كلمة المرور
// ============================================
echo "📋 الخطوة 3: اختبار وإصلاح كلمة المرور\n";
echo str_repeat("-", 60) . "\n";

$userPasswordValid = Hash::check($password, $user->password);
$distributorPasswordValid = Hash::check($password, $distributor->password_hash);

echo "Password: {$password}\n";
echo "User Password: " . ($userPasswordValid ? "✅ صحيحة" : "❌ غير صحيحة") . "\n";
echo "Distributor Password: " . ($distributorPasswordValid ? "✅ صحيحة" : "❌ غير صحيحة") . "\n";

if (!$userPasswordValid) {
    echo "\n⚠️  كلمة مرور المستخدم غير صحيحة، سيتم تحديثها...\n";
    $user->password = bcrypt($password);
    $user->save();
    echo "✅ تم تحديث كلمة مرور المستخدم\n";
}

if (!$distributorPasswordValid) {
    echo "\n⚠️  كلمة مرور الموزع غير صحيحة، سيتم تحديثها...\n";
    $distributor->password_hash = bcrypt($password);
    $distributor->save();
    echo "✅ تم تحديث كلمة مرور الموزع\n";
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
// 5. محاولة تسجيل الدخول (محاكاة)
// ============================================
echo "📋 الخطوة 5: محاكاة تسجيل الدخول\n";
echo str_repeat("-", 60) . "\n";

// محاكاة عملية تسجيل الدخول
$loginEmail = $user->email;
$loginPassword = $password;

// البحث عن المستخدم بالـ email
$loginUser = User::where('email', $loginEmail)->first();

if (!$loginUser) {
    echo "❌ خطأ: لم يتم العثور على مستخدم بالـ email: {$loginEmail}\n";
    exit(1);
}

// التحقق من كلمة المرور
if (!Hash::check($loginPassword, $loginUser->password)) {
    echo "❌ خطأ: كلمة المرور غير صحيحة!\n";
    exit(1);
}

// التحقق من الصلاحيات
if (!$loginUser->isDistributor()) {
    echo "❌ خطأ: المستخدم ليس موزعاً!\n";
    exit(1);
}

echo "✅ تسجيل الدخول ناجح!\n";
echo "   User ID: {$loginUser->id}\n";
echo "   Name: {$loginUser->name}\n";
echo "   Email: {$loginUser->email}\n";
echo "   Role: " . ($loginUser->role ? $loginUser->role->display_name : 'N/A') . "\n\n";

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
echo "Password: {$password}\n\n";

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
echo "   Password: {$password}\n";
echo "   URL: http://localhost:8000/admin/login\n\n";
