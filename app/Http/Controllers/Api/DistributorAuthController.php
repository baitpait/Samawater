<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use Illuminate\Support\Facades\Hash;

class DistributorAuthController extends Controller
{
   public function login(Request $request)
   {
    $request->validate([
        'phone' => 'nullable|string',
        'username' => 'nullable|string',
        'password' => 'required|string',
    ]);

    $loginValue = $request->phone ?: $request->username;

    if (empty($loginValue)) {
        return response()->json([
            'status' => false,
            'message' => 'يرجى إدخال رقم الهاتف أو اسم المستخدم',
        ], 422);
    }

    $distributor = Distributor::where('phone', $loginValue)
        ->orWhere('username', $loginValue)
        ->first();

    if (!$distributor || !Hash::check($request->password, $distributor->password_hash)) {
        return response()->json([
            'status' => false,
            'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة',
        ], 401);
    }

    // ❌ منع تسجيل الدخول إذا الحساب معطل
    if ($distributor->status == 0) {
        return response()->json([
            'status' => false,
            'message' => 'الحساب معطل ولا يمكن تسجيل الدخول',
        ], 403);
    }

    // تحديث الحالة إلى 1 (نشط)
    $distributor->status = 1;
    $distributor->save();

    $token = $distributor->createToken('distributor_token')->plainTextToken;

    return response()->json([
        'status' => true,
        'token' => $token,
        'distributor' => [
            'id' => $distributor->id,
            'name' => $distributor->name,
            'phone' => $distributor->phone,
            'username' => $distributor->username,
            'status' => $distributor->status,
            'notes' => $distributor->notes,
        ]
    ]);
}


    public function logout(Request $request)
    {
        $distributor = $request->user();

        // تحديث الحالة إلى غير نشط
        $distributor->status = 0;
        $distributor->save();

        // حذف التوكن (اختياري)
        $distributor->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }

    // دالة تعطيل الحساب (بدل الحذف)
    public function deactivate(Request $request)
    {
        $distributor = $request->user();

        $distributor->status = 0;   // 0 = محذوف/غير نشط
        $distributor->save();

        // حذف التوكن بعد التعطيل
        $distributor->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'تم تعطيل الحساب'
        ]);
    }
}