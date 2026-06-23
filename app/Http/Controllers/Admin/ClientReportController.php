<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Distributor;
use App\Services\ClientDeliveryReportService;
use Illuminate\Http\Request;

class ClientReportController extends Controller
{
    public function __construct(
        private readonly ClientDeliveryReportService $clientDeliveryReport,
    ) {
    }

    /**
     * Business Purpose: عرض تقرير تسليمات مشترك مع تفاصيل مالية وعبوات مطابقة لنموذج إنشاء التسليم.
     */
    public function index(Request $request)
    {
        $client = null;
        $bottleSnapshot = null;
        $accountSnapshot = null;

        $clients = Client::select('id', 'name')->get();
        $distributors = Distributor::select('id', 'name')->orderBy('name')->get();

        $filterMeta = null;

        if ($request->filled('client_id')) {
            $report = $this->clientDeliveryReport->load($request, (int) $request->client_id);
            $client = $report['client'];
            $bottleSnapshot = $report['bottleSnapshot'];
            $accountSnapshot = $report['accountSnapshot'];
            $filterMeta = $report['filterMeta'];
        }

        return view('admin.client_report_page', compact(
            'clients',
            'client',
            'distributors',
            'bottleSnapshot',
            'accountSnapshot',
            'filterMeta',
        ));
    }
}
