<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Business Purpose: كشف حساب مختصر للمشترك (مبيعات، تسليمات، مستحق، عبوات، أمانات) دون تفصيل محاسبي إضافي.
 */
class ClientBalanceReportController extends Controller
{
    /**
     * Business Purpose: عرض كشف الحساب عند اختيار مشترك (يدعم معرف الأب أو عنوان فرعي في الرابط).
     */
    public function index(Request $request): View
    {
        $clientsList = Client::query()
            ->whereNull('parent_id')
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'contract_no']);

        $selectedClientId = $request->get('client_id');
        $statement = null;
        $selectedClient = null;
        $selectParentId = null;

        if ($request->filled('client_id')) {
            $selectedClient = Client::query()->find($selectedClientId);
            if ($selectedClient !== null) {
                $statement = $selectedClient->accountStatementSnapshot();
                $selectParentId = (int) ($statement['billing_parent_id'] ?? $selectedClient->id);
            }
        }

        return view('admin.reports.client_balance', compact(
            'clientsList',
            'statement',
            'selectedClient',
            'selectedClientId',
            'selectParentId',
        ));
    }
}
