<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Mpdf\Mpdf;

class ReportController extends Controller
{
    public function exportClientReportPdf(Request $request)
    {
        $client = Client::with(['city','deliveries.distributor'])
            ->findOrFail($request->client_id);

        // HTML
        $html = view('reports.client-pdf', compact('client'))->render();

        $mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'directionality' => 'rtl',
    'default_font' => 'dejavusans',
    'tempDir' => storage_path('app/mpdf'),
]);


        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'client-report-'.$client->id.'.pdf',
            'S'
        ))->header('Content-Type', 'application/pdf');
    }
}