<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

/**
 * Business Purpose: تقرير رصيد المشترك (المستحقات)
 * - يعرض رصيد المشترك المختار: إجمالي الفواتير المؤكدة، إجمالي المدفوعات، الرصيد المستحق
 */
class ClientBalanceReportController extends Controller
{
    /**
     * عرض تقرير الرصيد حسب المشترك المختار (client_id)
     */
    public function index(Request $request)
    {
        $clientsList = Client::whereNull('parent_id')
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'contract_no']);

        $clients = collect();
        $totalOpeningBalance = 0;
        $totalInvoices = 0;
        $totalPayments = 0;
        $totalBalance = 0;
        $selectedClientId = $request->get('client_id');

        if ($request->filled('client_id')) {
            $client = Client::with(['invoices' => function ($q) {
                $q->where('status', 'confirmed');
            }, 'payments'])
                ->whereNull('parent_id')
                ->find($selectedClientId);

            if ($client) {
                $totalOpeningBalance = (float) ($client->opening_balance_amount ?? 0);
                $totalInvoices = $client->invoices->sum('total_amount');
                $totalPayments = $client->payments->sum('amount');
                $totalBalance = $totalOpeningBalance + $totalInvoices - $totalPayments;
                $client->opening_balance_amount = $totalOpeningBalance;
                $client->total_invoices_amount = $totalInvoices;
                $client->total_paid_amount = $totalPayments;
                $client->balance = $totalBalance;
                $clients = collect([$client]);
            }
        }

        return view('admin.reports.client_balance', compact(
            'clientsList',
            'clients',
            'totalOpeningBalance',
            'totalInvoices',
            'totalPayments',
            'totalBalance',
            'selectedClientId'
        ));
    }
}
