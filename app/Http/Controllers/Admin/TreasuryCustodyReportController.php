<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TreasuryCustodyAggregationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Business Purpose: عرض تجزئة شفافة بين عهدة النقد بحوزة الموزِّع وبين ما دخل صندوق الشركة المركز ضمن الفترة
 * (من التحصيل الميداني عبر deliveries.paymant حسب تاريخ التسليم وبين توثيق السحب عبر cash_withdraws بحسب وقت التسجيل).
 */
class TreasuryCustodyReportController extends Controller
{
    public function __construct(
        private readonly TreasuryCustodyAggregationService $treasuryCustodyAggregation
    ) {}

    /**
     * عرض لوحة مجاميع وأسطر الموزَّع مع فلاتر تاريخ البداية والنهاية.
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
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

        $summary = $this->treasuryCustodyAggregation->summarize($from, $to);

        return view('admin.reports.treasury_custody', [
            'summary' => $summary,
            'fromInput' => $from->format('Y-m-d'),
            'toInput' => $to->format('Y-m-d'),
        ]);
    }
}
