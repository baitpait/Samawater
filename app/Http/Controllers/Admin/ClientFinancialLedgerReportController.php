<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\ClientFinancialLedgerService;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Business Purpose: عرض كشف الحساب المالي التراكمي للمشترك (كل الحركات + أرصدة جارية).
 */
class ClientFinancialLedgerReportController extends Controller
{
    public function __construct(
        private readonly ClientFinancialLedgerService $ledgerService
    ) {}

    /**
     * Business Purpose: كشف حساب مالي شامل مع فلتر تاريخ اختياري.
     */
    public function index(Request $request): View
    {
        $clientsList = Client::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get(['id', 'name', 'contract_no']);

        $selectedClientId = $request->get('client_id');
        $from = $request->filled('from') ? (string) $request->get('from') : null;
        $to = $request->filled('to') ? (string) $request->get('to') : null;
        $ledger = null;
        $selectedClient = null;
        $selectParentId = null;

        if ($request->filled('client_id')) {
            $selectedClient = Client::query()->find($selectedClientId);
            if ($selectedClient !== null) {
                $ledger = $this->ledgerService->build($selectedClient, $from, $to);
                $selectParentId = (int) ($ledger['billing_parent_id'] ?? $selectedClient->id);
            }
        }

        return view('admin.reports.client_ledger', compact(
            'clientsList',
            'ledger',
            'selectedClient',
            'selectedClientId',
            'selectParentId',
            'from',
            'to',
        ));
    }
}
