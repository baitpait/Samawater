<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Allclient extends Controller
{
    public function index(Request $request)
    {
        $cityId = $request->query('city_id'); // فلترة حسب المدينة
        $statusName = $request->query('status'); // فلترة حسب حالة العميل (مثل ملتزم / غير ملتزم)

        $query = DB::table('v_clients_delivery_overview')
        ->select(
        'client_id',
        'total_deliveries',
        'contract_no',
        'client_name',
        'phone_one',
        'phone_two',
        'latitude',
        'longitude',
        'address',
        'subscription_status_name',
        'subscription_start_date',
        'subscription_months',
        'city_id',
        'subscription_status_id',
        'subscription_type_name',
        'bottle_on_hand_calculated',
        'distribution_days',
        'last_delivery_date',
        DB::raw("COALESCE(percentage_delivery_rate, 0) as percentage_delivery_rate"),
        'days_since_last_delivery',
        'client_status_name'
    );


        // ✅ فلترة حسب المدينة إن وُجدت
        if ($cityId) {
            $query->where('city_id', $cityId);
        }

        // ✅ فلترة حسب حالة العميل إن وُجدت
        if ($statusName) {
            $query->where('client_status_name', $statusName);
        }

        $clients = $query->orderBy('days_since_last_delivery', 'desc')->get();

        return response()->json([
            'status' => true,
            'clients' => $clients
        ]);
    }
}