<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VClientsDeliveryOverview;
use App\Models\City;
use App\Models\Distributor;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use App\Models\Delivery;
use Mpdf\Mpdf;

class ClientsDeliveryOverviewController extends Controller
{
   public function index(Request $request)
{
    $query = VClientsDeliveryOverview::query()
        ->leftJoin('cities', 'cities.id', '=', 'v_clients_delivery_overview.city_id')
        ->select(
    'v_clients_delivery_overview.*',
    'cities.city_name as city_name'
);

    // فلترة بين تاريخين (آخر تسليم)
    if ($request->filled('from') && $request->filled('to')) {
        $query->whereDate('last_delivery_date', '>=', $request->from)
              ->whereDate('last_delivery_date', '<=', $request->to);
    }

    // فلترة المدينة
    if ($request->filled('city_id')) {
        $query->where('v_clients_delivery_overview.city_id', $request->city_id);
    }

    // فلترة الموزع
    if ($request->filled('distributor_id')) {
        $query->where('v_clients_delivery_overview.distributor_id', $request->distributor_id);
    }

    // فلترة حالة الاشتراك
    if ($request->filled('subscription_status_id')) {
        $query->where('v_clients_delivery_overview.subscription_status_id', $request->subscription_status_id);
    }

    // فلترة نوع الاشتراك (من خلال join مع clients)
    if ($request->filled('subscription_type_id')) {
        $query->leftJoin('clients', 'clients.id', '=', 'v_clients_delivery_overview.client_id')
              ->where('clients.subscription_type_id', $request->subscription_type_id)
              ->groupBy('v_clients_delivery_overview.client_id'); // لمنع التكرار
    }

    $rows = collect();

    if ($request->has('search')) {
        $rows = $query->orderByDesc('last_delivery_date')
            ->orderByDesc('last_delivery_id') // ترتيب إضافي لإزالة التكرار
            ->get()
            ->unique('client_id') // إزالة التكرار - كل عميل مرة واحدة فقط
            ->values(); // إعادة ترتيب المفاتيح
        
        // تطبيق pagination يدوياً بعد إزالة التكرار
        $perPage = 50;
        $currentPage = $request->get('page', 1);
        $items = $rows->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $rows = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $rows->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        // جلب بيانات آخر تسليم لكل عميل
        foreach ($rows as $row) {
            $lastDelivery = null;
            
            // أولاً: البحث عن آخر تسليم (الأعلى ID) للعميل في تاريخ آخر تسليم
            if ($row->last_delivery_date) {
                $lastDelivery = \App\Models\Delivery::where('client_id', $row->client_id)
                    ->whereDate('delivery_date', $row->last_delivery_date)
                    ->orderByDesc('id') // نأخذ آخر delivery (الأعلى ID)
                    ->first();
            }
            
            // إذا لم نجد، نستخدم last_delivery_id من الـ View
            if (!$lastDelivery && $row->last_delivery_id) {
                $lastDelivery = \App\Models\Delivery::find($row->last_delivery_id);
            }
            
            if ($lastDelivery) {
                // إضافة بيانات آخر تسليم إلى الـ row
                $row->last_bottle_received = $lastDelivery->bottle_received;
                $row->last_bottle_empty = $lastDelivery->bottle_empty;
                $row->last_paymant = $lastDelivery->paymant; // الدفعة من الـ delivery الفعلي
                $row->last_delivery_date_actual = $lastDelivery->delivery_date; // تاريخ التسليم من الـ delivery الفعلي
                // تحديث last_delivery_id ليكون الصحيح
                $row->last_delivery_id = $lastDelivery->id;
            } else {
                $row->last_bottle_received = 0;
                $row->last_bottle_empty = 0;
                $row->last_paymant = 0;
                $row->last_delivery_date_actual = null;
            }
        }
    }

    $cities = City::orderBy('city_name')->get();
    $distributors = Distributor::select('id', 'name')->orderBy('name')->get();
    $subscriptionStatuses = SubscriptionStatus::orderBy('status_name')->get();
    $subscriptionTypes = SubscriptionType::orderBy('type_name')->get();

    return view('admin.reports.clients_delivery_overview', compact('rows', 'cities', 'distributors', 'subscriptionStatuses', 'subscriptionTypes'));
}
public function show($clientId, Request $request)
{
    $cityName = $request->query('city_name');

    $client = VClientsDeliveryOverview::where('client_id', $clientId)->firstOrFail();

    return view(
        'admin.reports.clients_due_show',
        compact('client', 'cityName')
    );
}

    // ===== تصدير Excel (CSV) =====
    public function exportExcel(Request $request)
    {
        // نفس منطق index لكن بدون pagination
        $query = VClientsDeliveryOverview::query()
            ->leftJoin('cities', 'cities.id', '=', 'v_clients_delivery_overview.city_id')
            ->select(
                'v_clients_delivery_overview.*',
                'cities.city_name as city_name'
            );

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereDate('last_delivery_date', '>=', $request->from)
                  ->whereDate('last_delivery_date', '<=', $request->to);
        }

        if ($request->filled('city_id')) {
            $query->where('v_clients_delivery_overview.city_id', $request->city_id);
        }

        if ($request->filled('distributor_id')) {
            $query->where('v_clients_delivery_overview.distributor_id', $request->distributor_id);
        }

        if ($request->filled('subscription_status_id')) {
            $query->where('v_clients_delivery_overview.subscription_status_id', $request->subscription_status_id);
        }

        if ($request->filled('subscription_type_id')) {
            $query->leftJoin('clients', 'clients.id', '=', 'v_clients_delivery_overview.client_id')
                  ->where('clients.subscription_type_id', $request->subscription_type_id)
                  ->groupBy('v_clients_delivery_overview.client_id');
        }

        $rows = $query->orderByDesc('last_delivery_date')
            ->orderByDesc('last_delivery_id')
            ->get()
            ->unique('client_id')
            ->values();

        // جلب بيانات آخر تسليم
        foreach ($rows as $row) {
            $lastDelivery = null;
            if ($row->last_delivery_date) {
                $lastDelivery = Delivery::where('client_id', $row->client_id)
                    ->whereDate('delivery_date', $row->last_delivery_date)
                    ->orderByDesc('id')
                    ->first();
            }
            if (!$lastDelivery && $row->last_delivery_id) {
                $lastDelivery = Delivery::find($row->last_delivery_id);
            }
            if ($lastDelivery) {
                $row->last_paymant = $lastDelivery->paymant;
                $row->last_delivery_date_actual = $lastDelivery->delivery_date;
            } else {
                $row->last_paymant = 0;
                $row->last_delivery_date_actual = null;
            }
        }

        // إنشاء CSV
        $filename = 'التسليمات_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // BOM للـ UTF-8 (للعربية)
        $output = "\xEF\xBB\xBF";

        $output .= "اسم العميل,الهاتف,المدينة,تاريخ التسليم,العبوات المستلمة,العبوات الفارغة,الدفعة,الموزع,حالة الاشتراك,نوع الاشتراك\n";

        foreach ($rows as $row) {
            $output .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                '"' . ($row->client_name ?? '') . '"',
                '"' . ($row->phone_one ?? '') . '"',
                '"' . ($row->city_name ?? '') . '"',
                '"' . ($row->last_delivery_date_actual ?? '') . '"',
                $row->total_bottle_received ?? 0,
                $row->total_bottle_empty ?? 0,
                $row->last_paymant ?? 0,
                '"' . ($row->distributor_name ?? '') . '"',
                '"' . ($row->subscription_status_name ?? '') . '"',
                '"' . ($row->subscription_type_name ?? '') . '"'
            );
        }

        return response($output, 200, $headers);
    }

    // ===== تصدير PDF =====
    public function exportPdf(Request $request)
    {
        // نفس منطق exportExcel
        $query = VClientsDeliveryOverview::query()
            ->leftJoin('cities', 'cities.id', '=', 'v_clients_delivery_overview.city_id')
            ->select(
                'v_clients_delivery_overview.*',
                'cities.city_name as city_name'
            );

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereDate('last_delivery_date', '>=', $request->from)
                  ->whereDate('last_delivery_date', '<=', $request->to);
        }

        if ($request->filled('city_id')) {
            $query->where('v_clients_delivery_overview.city_id', $request->city_id);
        }

        if ($request->filled('distributor_id')) {
            $query->where('v_clients_delivery_overview.distributor_id', $request->distributor_id);
        }

        if ($request->filled('subscription_status_id')) {
            $query->where('v_clients_delivery_overview.subscription_status_id', $request->subscription_status_id);
        }

        if ($request->filled('subscription_type_id')) {
            $query->leftJoin('clients', 'clients.id', '=', 'v_clients_delivery_overview.client_id')
                  ->where('clients.subscription_type_id', $request->subscription_type_id)
                  ->groupBy('v_clients_delivery_overview.client_id');
        }

        $rows = $query->orderByDesc('last_delivery_date')
            ->orderByDesc('last_delivery_id')
            ->get()
            ->unique('client_id')
            ->values();

        // جلب بيانات آخر تسليم
        foreach ($rows as $row) {
            $lastDelivery = null;
            if ($row->last_delivery_date) {
                $lastDelivery = Delivery::where('client_id', $row->client_id)
                    ->whereDate('delivery_date', $row->last_delivery_date)
                    ->orderByDesc('id')
                    ->first();
            }
            if (!$lastDelivery && $row->last_delivery_id) {
                $lastDelivery = Delivery::find($row->last_delivery_id);
            }
            if ($lastDelivery) {
                $row->last_paymant = $lastDelivery->paymant;
                $row->last_delivery_date_actual = $lastDelivery->delivery_date;
            } else {
                $row->last_paymant = 0;
                $row->last_delivery_date_actual = null;
            }
        }

        $html = view('admin.reports.clients_delivery_overview_pdf', compact('rows'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // Landscape
            'directionality' => 'rtl',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'التسليمات_' . date('Y-m-d') . '.pdf',
            'I'
        ))->header('Content-Type', 'application/pdf');
    }
}
