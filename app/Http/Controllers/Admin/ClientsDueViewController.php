<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VClientsDueByTypeDaysIds;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class ClientsDueViewController extends Controller
{
    public function index(Request $request)
    {
        /* ===============================
           Query الأساسي (مع اسم المدينة)
        =============================== */
        $query = VClientsDueByTypeDaysIds::query()
            ->leftJoin(
                'cities',
                'cities.id',
                '=',
                'v_clients_due_by_type_days_ids.city_id'
            )
            ->select(
                'v_clients_due_by_type_days_ids.*',
                'cities.city_name'
            );

        /* ===============================
           البحث
        =============================== */
        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($sub) use ($q) {
                $sub->where('client_name', 'like', "%{$q}%")
                    ->orWhere('phone_one', 'like', "%{$q}%")
                    ->orWhere('phone_two', 'like', "%{$q}%")
                    ->orWhere('contract_no', 'like', "%{$q}%");
            });
        }

        /* ===============================
           الفلاتر
        =============================== */
        if ($request->filled('city_id')) {
            $query->where(
                'v_clients_due_by_type_days_ids.city_id',
                $request->city_id
            );
        }

        if ($request->filled('subscription_type_name')) {
            $query->where(
                'subscription_type_name',
                $request->subscription_type_name
            );
        }

        if ($request->filled('min_days')) {
            $operator = $request->get('days_operator', '>='); // افتراضي: أكبر أو يساوي
            $query->where(
                'days_since_last_delivery',
                $operator,
                $request->min_days
            );
        }

        if ($request->filled('client_status_name')) {
            $query->where(
                'client_status_name',
                $request->client_status_name
            );
        }

        if ($request->filled('subscription_status_name')) {
            $query->where(
                'subscription_status_name',
                $request->subscription_status_name
            );
        }

        /* ===============================
           النتائج (فقط بعد الضغط على زر البحث)
        =============================== */
        $clients = collect(); // افتراضيًا لا نتائج
        $totalBottleReceived = 0;
        $totalBottleEmpty = 0;

        if ($request->has('search')) {
            // حساب إجمالي القوارير من جميع النتائج (قبل pagination)
            // إنشاء query جديد مطابق للـ query الأساسي
            $statsQuery = VClientsDueByTypeDaysIds::query()
                ->leftJoin('cities', 'cities.id', '=', 'v_clients_due_by_type_days_ids.city_id')
                ->select('v_clients_due_by_type_days_ids.*', 'cities.city_name');
            
            // تطبيق نفس الفلاتر
            if ($request->filled('q')) {
                $q = $request->q;
                $statsQuery->where(function ($sub) use ($q) {
                    $sub->where('client_name', 'like', "%{$q}%")
                        ->orWhere('phone_one', 'like', "%{$q}%")
                        ->orWhere('phone_two', 'like', "%{$q}%")
                        ->orWhere('contract_no', 'like', "%{$q}%");
                });
            }
            if ($request->filled('city_id')) {
                $statsQuery->where('v_clients_due_by_type_days_ids.city_id', $request->city_id);
            }
            if ($request->filled('subscription_type_name')) {
                $statsQuery->where('subscription_type_name', $request->subscription_type_name);
            }
            if ($request->filled('min_days')) {
                $operator = $request->get('days_operator', '>=');
                $statsQuery->where('days_since_last_delivery', $operator, $request->min_days);
            }
            if ($request->filled('client_status_name')) {
                $statsQuery->where('client_status_name', $request->client_status_name);
            }
            if ($request->filled('subscription_status_name')) {
                $statsQuery->where('subscription_status_name', $request->subscription_status_name);
            }
            
            // حساب الإجماليات
            $allClients = $statsQuery->get();
            $totalBottleReceived = (float)($allClients->sum('total_bottle_received') ?? 0);
            $totalBottleEmpty = (float)($allClients->sum('total_bottle_empty') ?? 0);
            
            // الآن نعمل pagination على الـ query الأصلي
            $clients = $query
                ->orderByDesc('days_since_last_delivery')
                ->paginate(50);
            
            // جلب بيانات آخر تسليم لكل عميل (الدفعة والموزع)
            $clientIds = $clients->pluck('client_id')->toArray();
            
            if (!empty($clientIds)) {
                // جلب آخر تسليم لكل عميل باستخدام subquery
                $lastDeliveryIds = \App\Models\Delivery::whereIn('client_id', $clientIds)
                    ->selectRaw('MAX(id) as id')
                    ->groupBy('client_id')
                    ->pluck('id')
                    ->toArray();
                
                $lastDeliveries = \App\Models\Delivery::whereIn('id', $lastDeliveryIds)
                    ->select('id', 'client_id', 'paymant', 'distributor_id', 'delivery_date')
                    ->with('distributor:id,name')
                    ->get()
                    ->keyBy('client_id');
                
                // إضافة بيانات آخر تسليم لكل عميل
                $clients->getCollection()->transform(function($client) use ($lastDeliveries) {
                    $lastDelivery = $lastDeliveries->get($client->client_id);
                    if ($lastDelivery) {
                        $client->last_delivery_payment = $lastDelivery->paymant ?? 0;
                        $client->last_delivery_distributor = $lastDelivery->distributor ? $lastDelivery->distributor->name : '-';
                        $client->last_delivery_date_formatted = $lastDelivery->delivery_date ? \Carbon\Carbon::parse($lastDelivery->delivery_date)->format('Y-m-d') : ($client->last_delivery_date ?? '-');
                    } else {
                        $client->last_delivery_payment = 0;
                        $client->last_delivery_distributor = '-';
                        $client->last_delivery_date_formatted = $client->last_delivery_date ?? '-';
                    }
                    return $client;
                });
            }
        }

        /* ===============================
           بيانات الـ Dropdown
        =============================== */

        // المدن
        $cities = City::orderBy('city_name')->get();

        // أنواع الاشتراك (من الـ VIEW نفسها)
        $subscriptionTypes = VClientsDueByTypeDaysIds::query()
            ->select('subscription_type_name')
            ->whereNotNull('subscription_type_name')
            ->distinct()
            ->orderBy('subscription_type_name')
            ->pluck('subscription_type_name');

        // حالات الالتزام (تصنيف العميل)
        $clientStatuses = VClientsDueByTypeDaysIds::query()
            ->select('client_status_name')
            ->whereNotNull('client_status_name')
            ->distinct()
            ->orderBy('client_status_name')
            ->pluck('client_status_name');

        // حالات الاشتراك
        $subscriptionStatuses = VClientsDueByTypeDaysIds::query()
            ->select('subscription_status_name')
            ->whereNotNull('subscription_status_name')
            ->distinct()
            ->orderBy('subscription_status_name')
            ->pluck('subscription_status_name');

        return view(
            'admin.reports.clients_due_advanced',
            compact('clients', 'cities', 'subscriptionTypes', 'clientStatuses', 'subscriptionStatuses', 'totalBottleReceived', 'totalBottleEmpty')
        );
    }

    public function show($client_id)
{
    $row = VClientsDueByTypeDaysIds::leftJoin('cities', 'cities.id', '=', 'v_clients_due_by_type_days_ids.city_id')
        ->select('v_clients_due_by_type_days_ids.*', 'cities.city_name')
        ->where('v_clients_due_by_type_days_ids.client_id', $client_id)
        ->firstOrFail();

    // جلب معلومات العميل الكاملة من جدول clients
    $client = \App\Models\Client::with(['city', 'subscriptionType', 'subscriptionStatus'])
        ->findOrFail($client_id);

    // جلب آخر تسليم مع تفاصيله
    $lastDelivery = \App\Models\Delivery::with('distributor')
        ->where('client_id', $client_id)
        ->latest('delivery_date')
        ->first();

    // جلب آخر 10 تسليمات للعميل
    $recentDeliveries = \App\Models\Delivery::with('distributor')
        ->where('client_id', $client_id)
        ->orderBy('delivery_date', 'desc')
        ->limit(10)
        ->get();

    return view(
        'admin.reports.clients_due_show',
        compact('row', 'client', 'lastDelivery', 'recentDeliveries')
    );
}

    // ===== تصدير Excel (CSV) =====
    public function exportExcel(Request $request)
    {
        $query = VClientsDueByTypeDaysIds::query()
            ->leftJoin('cities', 'cities.id', '=', 'v_clients_due_by_type_days_ids.city_id')
            ->select(
                'v_clients_due_by_type_days_ids.*',
                'cities.city_name'
            );

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('client_name', 'like', "%{$q}%")
                    ->orWhere('phone_one', 'like', "%{$q}%")
                    ->orWhere('phone_two', 'like', "%{$q}%")
                    ->orWhere('contract_no', 'like', "%{$q}%");
            });
        }

        if ($request->filled('city_id')) {
            $query->where('v_clients_due_by_type_days_ids.city_id', $request->city_id);
        }

        if ($request->filled('subscription_type_name')) {
            $query->where('subscription_type_name', $request->subscription_type_name);
        }

        if ($request->filled('min_days')) {
            $operator = $request->get('days_operator', '>='); // افتراضي: أكبر أو يساوي
            $query->where('days_since_last_delivery', $operator, $request->min_days);
        }

        if ($request->filled('client_status_name')) {
            $query->where('client_status_name', $request->client_status_name);
        }

        if ($request->filled('subscription_status_name')) {
            $query->where('subscription_status_name', $request->subscription_status_name);
        }

        $clients = $query->orderByDesc('days_since_last_delivery')->get();

        // إنشاء CSV
        $filename = 'العملاء_المستحقين_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // BOM للـ UTF-8 (للعربية)
        $output = "\xEF\xBB\xBF";

        $output .= "اسم العميل,الهاتف,المدينة,أيام بدون تسليم,نوع الاشتراك,حالة الالتزام,عدد التسليمات,القوارير المستلمة,القوارير الفارغة\n";

        foreach ($clients as $client) {
            $output .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                '"' . ($client->client_name ?? '') . '"',
                '"' . ($client->phone_one ?? '') . '"',
                '"' . ($client->city_name ?? '') . '"',
                $client->days_since_last_delivery ?? 0,
                '"' . ($client->subscription_type_name ?? '') . '"',
                '"' . ($client->client_status_name ?? '') . '"',
                $client->total_deliveries ?? 0,
                $client->total_bottle_received ?? 0,
                $client->total_bottle_empty ?? 0
            );
        }

        return response($output, 200, $headers);
    }

    // ===== تصدير PDF =====
    public function exportPdf(Request $request)
    {
        $query = VClientsDueByTypeDaysIds::query()
            ->leftJoin('cities', 'cities.id', '=', 'v_clients_due_by_type_days_ids.city_id')
            ->select(
                'v_clients_due_by_type_days_ids.*',
                'cities.city_name'
            );

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('client_name', 'like', "%{$q}%")
                    ->orWhere('phone_one', 'like', "%{$q}%")
                    ->orWhere('phone_two', 'like', "%{$q}%")
                    ->orWhere('contract_no', 'like', "%{$q}%");
            });
        }

        if ($request->filled('city_id')) {
            $query->where('v_clients_due_by_type_days_ids.city_id', $request->city_id);
        }

        if ($request->filled('subscription_type_name')) {
            $query->where('subscription_type_name', $request->subscription_type_name);
        }

        if ($request->filled('min_days')) {
            $operator = $request->get('days_operator', '>='); // افتراضي: أكبر أو يساوي
            $query->where('days_since_last_delivery', $operator, $request->min_days);
        }

        if ($request->filled('client_status_name')) {
            $query->where('client_status_name', $request->client_status_name);
        }

        if ($request->filled('subscription_status_name')) {
            $query->where('subscription_status_name', $request->subscription_status_name);
        }

        $clients = $query->orderByDesc('days_since_last_delivery')->get();

        $html = view('admin.reports.clients_due_advanced_pdf', compact('clients'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // Landscape
            'directionality' => 'rtl',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'العملاء_المستحقين_' . date('Y-m-d') . '.pdf',
            'I'
        ))->header('Content-Type', 'application/pdf');
    }
}