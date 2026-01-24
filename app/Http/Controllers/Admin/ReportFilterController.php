<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\ClientType;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use App\Models\City;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class ReportFilterController extends Controller
{
    public function index(Request $request)
    {
        $clientTypes = [
            1 => 'فردي',
            2 => 'مؤسسة',
            3 => 'تجاري',
        ];

        $query = Client::query()
            ->with('city', 'subscriptionStatus');

        /* ===== البحث ===== */
        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('phone_one', 'like', "%{$q}%")
                    ->orWhere('phone_two', 'like', "%{$q}%")
                    ->orWhere('address', 'like', "%{$q}%");
            });
        }

        /* ===== الفلاتر ===== */
        if ($request->from && $request->to) {
            $query->whereBetween('subscription_start_date', [
                $request->from,
                $request->to
            ]);
        }

        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->client_type_id) {
            $query->where('client_type', $request->client_type_id);
        }

        if ($request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->subscription_type_id) {
            $query->where('subscription_type_id', $request->subscription_type_id);
        }

        if ($request->subscription_status_id) {
            $query->where('subscription_status_id', $request->subscription_status_id);
        }

        $clients = $query->paginate(50);

        return view('admin.reports.filters', [
            'clients'               => $clients,
            'clientTypes'           => $clientTypes,
            'cities'                => City::all(),
            'statuses'              => ClientStatus::all(),
            'subscriptions'         => SubscriptionType::all(),
            'subscriptionStatuses'  => SubscriptionStatus::all(),
        ]);
    }

    public function results(Request $request)
    {
        $clients = Client::query()
            ->when($request->from, fn($q) =>
                $q->whereHas('deliveries', fn($d) =>
                    $d->whereDate('delivery_date', '>=', $request->from)
                )
            )
            ->when($request->to, fn($q) =>
                $q->whereHas('deliveries', fn($d) =>
                    $d->whereDate('delivery_date', '<=', $request->to)
                )
            )
            ->when($request->status_id, fn($q) =>
                $q->where('status_id', $request->status_id)
            )
            ->when($request->subscription_type_id, fn($q) =>
                $q->where('subscription_type_id', $request->subscription_type_id)
            )
            ->when($request->city_id, fn($q) =>
                $q->where('city_id', $request->city_id)
            )
            ->with(['city', 'deliveries'])
            ->get();

        return view('admin.reports.results', compact('clients'));
    }

    // ===== تصدير Excel (CSV) =====
    public function exportExcel(Request $request)
    {
        $clientTypes = [
            1 => 'فردي',
            2 => 'مؤسسة',
            3 => 'تجاري',
        ];

        $query = Client::query()->with('city', 'subscriptionStatus');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('phone_one', 'like', "%{$q}%")
                    ->orWhere('phone_two', 'like', "%{$q}%")
                    ->orWhere('address', 'like', "%{$q}%");
            });
        }

        if ($request->from && $request->to) {
            $query->whereBetween('subscription_start_date', [
                $request->from,
                $request->to
            ]);
        }

        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->client_type_id) {
            $query->where('client_type', $request->client_type_id);
        }

        if ($request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->subscription_type_id) {
            $query->where('subscription_type_id', $request->subscription_type_id);
        }

        if ($request->subscription_status_id) {
            $query->where('subscription_status_id', $request->subscription_status_id);
        }

        $clients = $query->get();

        // إنشاء CSV
        $filename = 'قائمة_العملاء_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // BOM للـ UTF-8 (للعربية)
        $output = "\xEF\xBB\xBF";

        $output .= "اسم العميل,رقم العقد,الهاتف,المدينة,نوع العميل,حالة الاشتراك,نوع الاشتراك,تاريخ بدء الاشتراك,رصيد القوارير\n";

        foreach ($clients as $client) {
            $output .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                '"' . ($client->name ?? '') . '"',
                '"' . ($client->contract_no ?? '') . '"',
                '"' . ($client->phone_one ?? '') . '"',
                '"' . ($client->city->city_name ?? '') . '"',
                '"' . ($clientTypes[$client->client_type] ?? '') . '"',
                '"' . ($client->subscriptionStatus->status_name ?? '') . '"',
                '"' . ($client->subscriptionType->type_name ?? '') . '"',
                $client->subscription_start_date ?? '',
                $client->bottle_balance ?? 0
            );
        }

        return response($output, 200, $headers);
    }

    // ===== تصدير PDF =====
    public function exportPdf(Request $request)
    {
        $clientTypes = [
            1 => 'فردي',
            2 => 'مؤسسة',
            3 => 'تجاري',
        ];

        $query = Client::query()->with('city', 'subscriptionStatus', 'subscriptionType');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('phone_one', 'like', "%{$q}%")
                    ->orWhere('phone_two', 'like', "%{$q}%")
                    ->orWhere('address', 'like', "%{$q}%");
            });
        }

        if ($request->from && $request->to) {
            $query->whereBetween('subscription_start_date', [
                $request->from,
                $request->to
            ]);
        }

        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->client_type_id) {
            $query->where('client_type', $request->client_type_id);
        }

        if ($request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->subscription_type_id) {
            $query->where('subscription_type_id', $request->subscription_type_id);
        }

        if ($request->subscription_status_id) {
            $query->where('subscription_status_id', $request->subscription_status_id);
        }

        $clients = $query->get();

        $html = view('admin.reports.filters_pdf', compact('clients', 'clientTypes'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // Landscape
            'directionality' => 'rtl',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'قائمة_العملاء_' . date('Y-m-d') . '.pdf',
            'I'
        ))->header('Content-Type', 'application/pdf');
    }
}