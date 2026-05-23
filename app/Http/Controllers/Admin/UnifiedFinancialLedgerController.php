<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UnifiedFinancialLedgerService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Business Purpose: صفحة واحدة تعرض حركات مالية ظاهرة ضمن فترة من عدة جداول بدون تكرار التحصيل الميداني ضمن دفعات العملاء.
 */
class UnifiedFinancialLedgerController extends Controller
{
    public function __construct(
        private readonly UnifiedFinancialLedgerService $ledgerService
    ) {}

    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        $from = isset($validated['from'])
            ? Carbon::parse($validated['from'])->startOfDay()
            : Carbon::now()->startOfMonth();

        $to = isset($validated['to'])
            ? Carbon::parse($validated['to'])->startOfDay()
            : Carbon::now()->startOfDay();

        if ($to->lt($from)) {
            [$from, $to] = [$to, $from];
        }

        if ($to->copy()->startOfDay()->gt($from->copy()->addDays((int) UnifiedFinancialLedgerService::DEFAULT_MAX_RANGE_DAYS)->startOfDay())) {
            return redirect()
                ->route('reports.financial-movements-unified', array_filter([
                    'from' => Carbon::now()->subDays((int) UnifiedFinancialLedgerService::DEFAULT_MAX_RANGE_DAYS)->format('Y-m-d'),
                    'to' => Carbon::now()->format('Y-m-d'),
                ]))
                ->with('error', 'الفترة أطول من ' . UnifiedFinancialLedgerService::DEFAULT_MAX_RANGE_DAYS . ' يوماً؛ عُرضت آخر سنة تقريباً.');
        }

        $ledger = $this->ledgerService->buildLedger($from, $to);

        return view('admin.reports.financial_movements_unified', [
            'ledger' => $ledger,
            'fromInput' => $from->format('Y-m-d'),
            'toInput' => $to->format('Y-m-d'),
        ]);
    }
}
