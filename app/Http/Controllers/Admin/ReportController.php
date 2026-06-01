<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ClientDeliveryReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        private readonly ClientDeliveryReportService $clientDeliveryReport,
    ) {
    }

    /**
     * Business Purpose: تصدير تقرير تسليمات المشترك بصيغة PDF مع نفس أعمدة الصفحة (مالي + عبوات).
     */
    public function exportClientReportPdf(Request $request)
    {
        $report = $this->clientDeliveryReport->load($request, (int) $request->client_id);

        $html = view('reports.client-pdf', $report)->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'directionality' => 'rtl',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'client-report-'.$report['client']->id.'.pdf',
            'S'
        ))->header('Content-Type', 'application/pdf');
    }
}
