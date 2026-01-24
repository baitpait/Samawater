<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client; // ← ضروري جداً

class ClientController extends Controller
{
    public function updateLocation(Request $request)
    {
        // 🔹 التحقق من البيانات
        $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            // 🔹 جلب العميل
            $client = Client::find($request->client_id);

            if (!$client) {
                return response()->json([
                    'status' => false,
                    'message' => 'العميل غير موجود'
                ], 404);
            }

            // 🔹 تحديث الموقع
            $client->latitude  = $request->latitude;
            $client->longitude = $request->longitude;
            $client->save();

            return response()->json([
                'status' => true,
                'message' => 'تم تحديث موقع العميل بنجاح',
                'client' => $client
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء التحديث',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function updateAddress(Request $request)
{
 
    try {
        //✅ التحقق من القيم الواردة
        $request->validate([
            'id'  => 'required|integer|exists:clients,id',
            'client_name'=> 'nullable|string|max:255',
            'phone_one'  => 'nullable|string|max:255',
            'phone_two'  => 'nullable|string|max:255',
            'address'    => 'nullable|string|max:255',
            'city_id'    => 'nullable|integer|exists:cities,id',
            'notes'      => 'nullable|string|max:255',
        ]);

        // البحث عن العميل
        $client = Client::find($request->id);

        if (!$client) {
            return response()->json([
                'status'  => false,
                'message' => 'Client not found',
            ], 404);
        }

        // تحديث جميع الحقول المرسلة
        $client->update([
            'name'      => $request->client_name,
            'phone_one' => $request->phone_one,
            'phone_two' => $request->phone_two,
            'address'   => $request->address,
            'city_id'   => $request->city_id,
            'notes'     => $request->notes,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Client updated successfully',
            'client'  => $client,
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $ve) {
        // رسائل التحقق (Validation errors)
        return response()->json([
            'status'  => false,
            'message' => 'Validation failed',
            'errors'  => $ve->errors(),
        ], 422);

    } catch (\Exception $e) {
        // أي خطأ آخر
        return response()->json([
            'status'  => false,
            'message' => 'Error updating client',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

public function uploadImage(Request $request)
{
    $request->validate([
        'client_id' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:4096',
    ]);

    $client = Client::find($request->client_id);

    if (!$client) {
        return response()->json([
            'status' => false,
            'message' => 'Client not found'
        ]);
    }

    // حفظ الصورة
    $path = $request->file('image')->store('clients', 'public');

    // تحديث سجل العميل
    $client->image = $path;
    $client->save();

    return response()->json([
        'status' => true,
        'image' => asset('storage/' . $path),
    ]);
}


}