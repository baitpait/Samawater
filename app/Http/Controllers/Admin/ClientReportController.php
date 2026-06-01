<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Distributor;
use Illuminate\Http\Request;

class ClientReportController extends Controller
{
    public function index(Request $request)
    {
        // ✅ يجب تعريف client دائمًا
        $client = null;
        $bottleSnapshot = null;

        $clients = Client::select('id', 'name')->get();
        
        // جلب قائمة الموزعين للـ Modal
        $distributors = Distributor::select('id', 'name')->orderBy('name')->get();

        if ($request->filled('client_id')) {
            $client = Client::with([
                'city',
                'deliveries' => function ($q) use ($request) {
                    if ($request->filled('from')) {
                        $q->whereDate('delivery_date', '>=', $request->from);
                    }
                    if ($request->filled('to')) {
                        $q->whereDate('delivery_date', '<=', $request->to);
                    }
                    $q->with('distributor')
                      ->orderBy('delivery_date', 'desc');
                }
            ])->findOrFail($request->client_id);

            $bottleSnapshot = $client->bottleBalanceFromDeliveriesFormula();
        }

        return view('admin.client_report_page', compact(
            'clients',
            'client',
            'distributors',
            'bottleSnapshot',
        ));

    }
}