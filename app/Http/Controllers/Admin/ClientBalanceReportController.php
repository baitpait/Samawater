<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

/**
 * Business Purpose: تقرير رصيد العملاء (المستحقات)
 * - يعرض جميع العملاء مع:
 *   - إجمالي الفواتير المؤكدة
 *   - إجمالي المدفوعات
 *   - الرصيد المستحق (الفواتير - المدفوعات)
 */
class ClientBalanceReportController extends Controller
{
    /**
     * عرض تقرير رصيد العملاء
     */
    public function index(Request $request)
    {
        $query = Client::with(['invoices' => function($q) {
            $q->where('status', 'confirmed');
        }, 'payments']);

        // فلتر حسب اسم العميل
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // ملاحظة: سيتم فلترة العملاء الذين رصيدهم = 0 بعد حساب الرصيد

        $clients = $query->orderBy('name', 'asc')->get();

        // حساب الرصيد لكل عميل
        $clients = $clients->map(function($client) {
            $client->total_invoices_amount = $client->invoices->sum('total_amount');
            $client->total_paid_amount = $client->payments->sum('amount');
            $client->balance = $client->total_invoices_amount - $client->total_paid_amount;
            return $client;
        });

        // فلتر: إخفاء العملاء الذين رصيدهم = 0 (لا يوجد مستحقات)
        $clients = $clients->filter(function($client) {
            return $client->balance > 0;
        });

        // إحصائيات
        $totalInvoices = $clients->sum('total_invoices_amount');
        $totalPayments = $clients->sum('total_paid_amount');
        $totalBalance = $totalInvoices - $totalPayments;

        return view('admin.reports.client_balance', compact(
            'clients',
            'totalInvoices',
            'totalPayments',
            'totalBalance'
        ));
    }
}
