<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VClientsDueByTypeDaysIds;
use App\Models\City;

class ClientsDueReportController extends Controller
{
    public function index(Request $request)
    {
        $query = VClientsDueByTypeDaysIds::query();

        // ---------- Filters ----------
        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->subscription_type_name) {
            $query->where('subscription_type_name', $request->subscription_type_name);
        }

        if ($request->client_status_name) {
            $query->where('client_status_name', $request->client_status_name);
        }

        if ($request->distribution_days) {
            $query->where('distribution_days', $request->distribution_days);
        }

        if ($request->days_min) {
            $query->where('days_since_last_delivery', '>=', $request->days_min);
        }

        if ($request->days_max) {
            $query->where('days_since_last_delivery', '<=', $request->days_max);
        }

        if ($request->rate_min) {
            $query->where('percentage_delivery_rate', '>=', $request->rate_min);
        }

        if ($request->rate_max) {
            $query->where('percentage_delivery_rate', '<=', $request->rate_max);
        }

        if ($request->bottle_balance) {
            $query->where('bottle_on_hand_calculated', $request->bottle_balance);
        }

        if ($request->date_from) {
            $query->whereDate('last_delivery_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('last_delivery_date', '<=', $request->date_to);
        }

        // ---------- Fetch Data ----------
        $clientsDue = $query->orderBy('client_id')->paginate(20);

        // ---------- Return ----------
        return view('admin.clients_due.index', [
            'clientsDue' => $clientsDue,
            'cities' => City::all(),
            'subscriptionTypes' => VClientsDueByTypeDaysIds::select('subscription_type_name')->distinct()->pluck('subscription_type_name'),
            'statuses' => VClientsDueByTypeDaysIds::select('client_status_name')->distinct()->pluck('client_status_name'),
            'distributionDaysOptions' => [1,2,3,4,5,6,7],
        ]);
    }
}