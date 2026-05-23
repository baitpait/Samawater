<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CompanyTreasuryReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Business Purpose: عرض لوحة صفحة واحدة لفهم وارد وصادر صندوق الشركة حسب الفترة (تسليمات ومبيعات مقابل مشتريات ومصروفات).
 */
class CompanyTreasuryReportController extends Controller
{
    public function __construct(
        private readonly CompanyTreasuryReportService $companyTreasuryReport
    ) {}

    /**
     * Business Purpose: عرض لوحة صندوق الشركة مع فلتر الفترة الافتراضي من أول الشهر إلى اليوم.
     */
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

        if ($to->copy()->startOfDay()->gt($from->copy()->addDays((int) CompanyTreasuryReportService::DEFAULT_MAX_RANGE_DAYS)->startOfDay())) {
            return redirect()
                ->route('reports.company-treasury', array_filter([
                    'from' => Carbon::now()->subDays((int) CompanyTreasuryReportService::DEFAULT_MAX_RANGE_DAYS)->format('Y-m-d'),
                    'to' => Carbon::now()->format('Y-m-d'),
                ]))
                ->with('error', 'الفترة أطول من ' . CompanyTreasuryReportService::DEFAULT_MAX_RANGE_DAYS . ' يوماً؛ عُرضت الفترة المسموحة.');
        }

        $summary = $this->companyTreasuryReport->summarize($from, $to);

        return view('admin.reports.company_treasury', [
            'summary' => $summary,
            'fromInput' => $from->format('Y-m-d'),
            'toInput' => $to->format('Y-m-d'),
        ]);
    }
}
