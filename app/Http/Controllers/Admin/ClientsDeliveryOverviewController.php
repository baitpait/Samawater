<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\Distributor;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use App\Models\VClientsDeliveryOverview;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mpdf\Mpdf;

class ClientsDeliveryOverviewController extends Controller
{
    public function index(Request $request)
    {
        $rows = collect();
        $overviewTotals = null;
        $reportMode = 'overview';

        if ($request->has('search')) {
            $allRows = $this->resolveReportRows($request);
            $reportMode = $this->isClientDeliveryDetailMode($request) ? 'client_deliveries' : 'overview';

            $overviewTotals = [
                'total_paymant' => round($allRows->sum(static fn ($row): float => (float) ($row->last_paymant ?? 0)), 2),
                'row_count' => $allRows->count(),
                'mode' => $reportMode,
            ];

            $rows = $this->paginateRows($allRows, $request);
        }

        $cities = City::orderBy('city_name')->get();
        $distributors = Distributor::select('id', 'name')->orderBy('name')->get();
        $subscriptionStatuses = SubscriptionStatus::orderBy('status_name')->get();
        $subscriptionTypes = SubscriptionType::orderBy('type_name')->get();
        $clients = Client::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.reports.clients_delivery_overview', compact(
            'rows',
            'overviewTotals',
            'reportMode',
            'cities',
            'distributors',
            'subscriptionStatuses',
            'subscriptionTypes',
            'clients',
        ));
    }

    /**
     * Business Purpose: عند اختيار مشترك محدد نعرض كل تسليماته؛ وإلا صفاً واحداً لكل مشترك (آخر تسليم).
     */
    private function resolveReportRows(Request $request): Collection
    {
        if ($this->isClientDeliveryDetailMode($request)) {
            return $this->buildClientDeliveryRows($request);
        }

        $query = VClientsDeliveryOverview::query()
            ->leftJoin('cities', 'cities.id', '=', 'v_clients_delivery_overview.city_id')
            ->select(
                'v_clients_delivery_overview.*',
                'cities.city_name as city_name'
            );

        $this->applyOverviewFilters($query, $request);

        $allRows = $query->orderByDesc('v_clients_delivery_overview.last_delivery_date')
            ->orderByDesc('v_clients_delivery_overview.last_delivery_id')
            ->get()
            ->unique('client_id')
            ->sortByDesc(function ($row) {
                $d = $row->last_delivery_date ?? null;
                if ($d === null || $d === '') {
                    return PHP_INT_MIN;
                }

                return \Carbon\Carbon::parse($d)->timestamp * 10_000 + (int) ($row->last_delivery_id ?? 0);
            })
            ->values();

        foreach ($allRows as $row) {
            $this->enrichOverviewRowLastDelivery($row);
        }

        return $allRows;
    }

    /**
     * Business Purpose: التحقق من وضع تفصيل تسليمات مشترك واحد بدلاً من ملخص آخر تسليم.
     */
    private function isClientDeliveryDetailMode(Request $request): bool
    {
        return $request->filled('client_id');
    }

    /**
     * Business Purpose: جلب كل تسليمات ملف المشترك (الأب + العناوين الفرعية) ضمن فلاتر التاريخ والموزع.
     */
    private function buildClientDeliveryRows(Request $request): Collection
    {
        $client = Client::query()->findOrFail((int) $request->client_id);
        $familyIds = $client->familyClientIds();

        $query = Delivery::query()
            ->whereIn('client_id', $familyIds)
            ->with(['distributor', 'client.city']);

        if ($request->filled('from')) {
            $query->whereDate('delivery_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('delivery_date', '<=', $request->to);
        }

        if ($request->filled('distributor_id')) {
            $query->where('distributor_id', (int) $request->distributor_id);
        }

        if ($request->filled('city_id')) {
            $query->whereHas('client', static function (Builder $clientQuery) use ($request): void {
                $clientQuery->where('city_id', (int) $request->city_id);
            });
        }

        return $query->orderByDesc('delivery_date')
            ->orderByDesc('id')
            ->get()
            ->map(static function (Delivery $delivery): object {
                $owner = $delivery->client;

                return (object) [
                    'client_id' => (int) $delivery->client_id,
                    'client_name' => $owner->name ?? '-',
                    'city_name' => $owner?->city?->city_name,
                    'phone_one' => $owner->phone_one ?? null,
                    'subscription_status_name' => null,
                    'subscription_type_name' => null,
                    'last_delivery_date_actual' => $delivery->delivery_date,
                    'last_bottle_received' => $delivery->bottle_received,
                    'last_bottle_empty' => $delivery->bottle_empty,
                    'last_required_amount' => $delivery->required_amount ?? 0,
                    'last_paymant' => $delivery->paymant,
                    'last_delivery_id' => (int) $delivery->id,
                    'distributor_name' => $delivery->distributor->name ?? null,
                ];
            })
            ->values();
    }

    /**
     * Business Purpose: ترقيم نتائج التقرير مع الحفاظ على معاملات الفلترة في الروابط.
     */
    private function paginateRows(Collection $allRows, Request $request): LengthAwarePaginator
    {
        $perPage = 50;
        $currentPage = (int) $request->get('page', 1);
        $items = $allRows->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $items,
            $allRows->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

    /**
     * Business Purpose: إثراء صف التقرير ببيانات آخر تسليم (عبوات ومبالغ) كما في الجدول.
     */
    private function enrichOverviewRowLastDelivery(object $row): void
    {
        $lastDelivery = null;

        if ($row->last_delivery_date) {
            $lastDelivery = Delivery::query()
                ->where('client_id', $row->client_id)
                ->whereDate('delivery_date', $row->last_delivery_date)
                ->orderByDesc('id')
                ->first();
        }

        if ($lastDelivery === null && $row->last_delivery_id) {
            $lastDelivery = Delivery::query()->find($row->last_delivery_id);
        }

        if ($lastDelivery !== null) {
            $row->last_bottle_received = $lastDelivery->bottle_received;
            $row->last_bottle_empty = $lastDelivery->bottle_empty;
            $row->last_paymant = $lastDelivery->paymant;
            $row->last_required_amount = $lastDelivery->required_amount ?? 0;
            $row->last_delivery_date_actual = $lastDelivery->delivery_date;
            $row->last_delivery_id = (int) $lastDelivery->id;

            return;
        }

        $row->last_bottle_received = 0;
        $row->last_bottle_empty = 0;
        $row->last_paymant = 0;
        $row->last_required_amount = 0;
        $row->last_delivery_date_actual = null;
        $row->last_delivery_id = null;
    }

    /**
     * Business Purpose: تطبيق فلاتر تقرير التسليمات (تاريخ، مدينة، موزع، مشترك) على ملخص المشتركين.
     */
    private function applyOverviewFilters(Builder $query, Request $request): void
    {
        if ($request->filled('from')) {
            $query->whereDate('last_delivery_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('last_delivery_date', '<=', $request->to);
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

        if ($request->filled('client_id')) {
            $query->where('v_clients_delivery_overview.client_id', (int) $request->client_id);
        } elseif ($request->filled('name')) {
            $query->where('v_clients_delivery_overview.client_name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('subscription_type_id')) {
            $query->leftJoin('clients', 'clients.id', '=', 'v_clients_delivery_overview.client_id')
                ->where('clients.subscription_type_id', $request->subscription_type_id)
                ->groupBy('v_clients_delivery_overview.client_id');
        }
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

    /**
     * Business Purpose: تصدير نتائج التقرير إلى CSV بنفس أعمدة الجدول.
     */
    public function exportExcel(Request $request)
    {
        $rows = $this->resolveReportRows($request);

        $filename = 'التسليمات_'.date('Y-m-d').'.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $output = "\xEF\xBB\xBF";
        $output .= "المشترك,المدينة,الهاتف,تاريخ الاستلام,العبوات المستلمة,العبوات الفارغة,رصيد العبوات,المبلغ المطلوب,المبلغ المدفوع,الدين المتبقي,الموزع,حالة الاشتراك,نوع الاشتراك\n";

        foreach ($rows as $row) {
            $received = (int) ($row->last_bottle_received ?? 0);
            $empty = (int) ($row->last_bottle_empty ?? 0);
            $balance = $received - $empty;
            $required = (float) ($row->last_required_amount ?? 0);
            $paymant = (float) ($row->last_paymant ?? 0);
            $remainingDebt = $required - $paymant;
            $output .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                '"'.($row->client_name ?? '').'"',
                '"'.($row->city_name ?? '').'"',
                '"'.($row->phone_one ?? '').'"',
                $row->last_delivery_date_actual ? '"'.\Carbon\Carbon::parse($row->last_delivery_date_actual)->format('Y-m-d').'"' : '""',
                $received,
                $empty,
                $balance,
                $required,
                $paymant,
                $remainingDebt,
                '"'.($row->distributor_name ?? '').'"',
                '"'.($row->subscription_status_name ?? '').'"',
                '"'.($row->subscription_type_name ?? '').'"'
            );
        }

        return response($output, 200, $headers);
    }

    /**
     * Business Purpose: تصدير نتائج التقرير إلى PDF بنفس أعمدة الجدول.
     */
    public function exportPdf(Request $request)
    {
        $rows = $this->resolveReportRows($request);

        $html = view('admin.reports.clients_delivery_overview_pdf', compact('rows'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'directionality' => 'rtl',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'التسليمات_'.date('Y-m-d').'.pdf',
            'I'
        ))->header('Content-Type', 'application/pdf');
    }
}
