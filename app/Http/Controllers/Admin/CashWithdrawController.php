<?php

namespace App\Http\Controllers\Admin;

use App\Models\CashWithdraw;
use App\Models\Distributor;
use Illuminate\Http\Request;

class CashWithdrawController
{
    public function store(Request $request)
    {
        $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'total_amount'   => 'required|numeric|min:0.01',
            'notes'          => 'nullable|string',
        ]);

        $distributor = Distributor::findOrFail($request->distributor_id);

        // ✅ حماية حقيقية (حتى لو تم التحايل على JS)
        if ($request->total_amount > $distributor->balance) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ الرصيد غير كافٍ لإتمام عملية السحب'
            ], 422);
        }

        // ✅ حماية من الإرسال المزدوج: التحقق من آخر سحب في آخر 2 ثانية
        $recentWithdraw = CashWithdraw::where('distributor_id', $request->distributor_id)
            ->where('total_amount', $request->total_amount)
            ->where('created_at', '>=', now()->subSeconds(2))
            ->first();

        if ($recentWithdraw) {
            return response()->json([
                'status' => 'error',
                'message' => '⚠️ تم تنفيذ عملية السحب للتو. يرجى الانتظار قليلاً.'
            ], 422);
        }

        // إنشاء سجل السحب
        CashWithdraw::create([
            'distributor_id' => $request->distributor_id,
            'total_amount'   => $request->total_amount,
            'notes'          => $request->notes,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '✅ تم تنفيذ عملية السحب بنجاح'
        ]);
    }
}