<?php

namespace App\Http\Controllers\Api;

use App\Models\Delivery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeliveryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'bottle_received' => 'required|integer|min:0',
            'bottle_empty' => 'required|integer|min:0',
            'paymant' => 'required|integer|min:0',
            'distributor_id' => 'required|integer',
        ]);

        DB::table('deliveries')->insert([
            'client_id' => $request->client_id,
            'delivery_date' => Carbon::now(),
            'bottle_received' => $request->bottle_received,
            'bottle_empty' => $request->bottle_empty,
            'paymant' => $request->paymant,
            'distributor_id' => $request->distributor_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل التسليم بنجاح ✅',
        ]);
    }
    
    public function edit(Delivery $delivery)
    {
        return response()->json($delivery);
    }

    // تحديث التوصيل
    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([
            'bottle_received' => 'required|integer|min:0',
            'bottle_empty'    => 'required|integer|min:0',
            'paymant'         => 'nullable|integer|min:0',
            'delivery_date'   => 'nullable|date',
            'distributor_id'  => 'nullable|integer|exists:distributors,id',
        ]);

        $delivery->update([
            'bottle_received' => $request->bottle_received,
            'bottle_empty'    => $request->bottle_empty,
            'paymant'         => $request->paymant ?? $delivery->paymant,
            'delivery_date'   => $request->delivery_date ?? $delivery->delivery_date,
            'distributor_id'  => $request->distributor_id ?? $delivery->distributor_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث بيانات التوصيل بنجاح'
        ]);
    }

}