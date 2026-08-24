<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use App\Models\City;
use App\Services\ClientBottleBalanceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Mpdf\Mpdf;

class ReportFilterController extends Controller
{
    public function __construct(
        private readonly ClientBottleBalanceService $clientBottleBalance,
    ) {
    }

    /**
     * Business Purpose: قائمة المشتركين المفلترين مع رصيد القوارير بنفس معادلة كشف الحساب (عائلة: ممتلئة − فارغة).
     */
    public function index(Request $request)
    {
        $query = Client::query()
            ->with([
                'city',
                'subscriptionStatus',
                'subscriptionType',
                'lastDelivery',
                'invoices',
                'payments',
                'parent.invoices',
                'parent.payments',
            ]);

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
            $query->whereBetween('subscription_start_date', [$request->from, $request->to]);
        }

        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        $this->applySubscriptionTypeFilter($query, $request);

        $defaultActiveStatusId = SubscriptionStatus::where('status_name', 'نشط')->value('id');
        $requestedStatus = $request->input('subscription_status_id');
        if ($request->has('subscription_status_id')) {
            // زيارة تحتوي المعامل صراحةً: فارغ أو "الكل" = لا فلترة بالحالة
            $selectedSubscriptionStatusId = ($requestedStatus === '' || $requestedStatus === null)
                ? null
                : $requestedStatus;
        } else {
            // لا يوجد معامل في الرابط ← الافتراضي نشط (عرض وحفظ القيمة في القائمة)
            $selectedSubscriptionStatusId = $defaultActiveStatusId;
        }

        if ($request->has('subscription_status_id')) {
            if ($request->filled('subscription_status_id')) {
                $query->where('subscription_status_id', $request->subscription_status_id);
            }
        } elseif ($defaultActiveStatusId) {
            $query->where('subscription_status_id', $defaultActiveStatusId);
        }

        $query->orderBy('address', 'asc');

        $clients = $query->paginate(50);
        $bottleSnapshotsByClientId = $this->bottleSnapshotsFor($clients->getCollection());

        return view('admin.reports.filters', [
            'clients'                      => $clients,
            'bottleSnapshotsByClientId'    => $bottleSnapshotsByClientId,
            'cities'                       => City::orderBy('city_name')->get(),
            'subscriptions'                => SubscriptionType::orderBy('type_name')->get(),
            'subscriptionStatuses'         => SubscriptionStatus::orderBy('status_name')->get(),
            'selectedSubscriptionStatusId' => $selectedSubscriptionStatusId,
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
            ->when($request->subscription_status_id, fn($q) =>
                $q->where('subscription_status_id', $request->subscription_status_id)
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

        $query = Client::query()->with('city', 'subscriptionStatus', 'subscriptionType', 'lastDelivery');

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

        $this->applySubscriptionTypeFilter($query, $request);

        if ($request->subscription_status_id) {
            $query->where('subscription_status_id', $request->subscription_status_id);
        }

        $clients = $query->get();
        $bottleSnapshotsByClientId = $this->bottleSnapshotsFor($clients);

        // إنشاء CSV
        $filename = 'قائمة_العملاء_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // BOM للـ UTF-8 + علامة RTL لفتح Excel من اليمين لليسار
        $output = "\xEF\xBB\xBF\xE2\x80\x8F";

        // ترتيب الأعمدة من اليمين لليسار: المشترك، العنوان، الهاتف الأول، الهاتف الثاني، ...
        $output .= "اسم المشترك,العنوان,رقم العقد,الهاتف الأول,الهاتف الثاني,المدينة,نوع العميل,حالة الاشتراك,نوع الاشتراك,تاريخ آخر تسليم,رصيد القوارير\n";

        foreach ($clients as $client) {
            $lastDeliveryDate = $client->lastDelivery ? \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->format('Y-m-d') : '';
            $bottleSnapshot = $bottleSnapshotsByClientId[(int) $client->id] ?? [
                'total_bottle_received' => 0,
                'total_bottle_empty' => 0,
                'bottle_balance' => 0,
            ];
            $bottleCell = sprintf(
                '%d − %d = %d',
                (int) $bottleSnapshot['total_bottle_received'],
                (int) $bottleSnapshot['total_bottle_empty'],
                (int) $bottleSnapshot['bottle_balance']
            );
            $output .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                '"' . str_replace('"', '""', (string)($client->name ?? '')) . '"',
                '"' . str_replace('"', '""', (string)($client->address ?? '')) . '"',
                '"' . str_replace('"', '""', (string)($client->contract_no ?? '')) . '"',
                '"' . str_replace('"', '""', (string)($client->phone_one ?? '')) . '"',
                '"' . str_replace('"', '""', (string)($client->phone_two ?? '')) . '"',
                '"' . str_replace('"', '""', (string)($client->city->city_name ?? '')) . '"',
                '"' . ($clientTypes[$client->client_type] ?? '') . '"',
                '"' . ($client->subscriptionStatus->status_name ?? '') . '"',
                '"' . ($client->subscriptionType->type_name ?? '') . '"',
                $lastDeliveryDate,
                '"' . $bottleCell . '"'
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

        $query = Client::query()->with('city', 'subscriptionStatus', 'subscriptionType', 'lastDelivery');

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

        $this->applySubscriptionTypeFilter($query, $request);

        if ($request->subscription_status_id) {
            $query->where('subscription_status_id', $request->subscription_status_id);
        }

        $clients = $query->get();
        $bottleSnapshotsByClientId = $this->bottleSnapshotsFor($clients);

        $html = view('admin.reports.filters_pdf', compact('clients', 'clientTypes', 'bottleSnapshotsByClientId'))->render();

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

    /**
     * تفعيل أو إلغاء «تسليم حسب الطلب» من جدول تقارير الفلاتر.
     */
    public function toggleDeliveryOnDemand(Request $request, Client $client): RedirectResponse
    {
        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        $client->delivery_on_demand = $request->boolean('enabled');
        $client->save();

        \Alert::success(
            $client->delivery_on_demand
                ? 'تم تفعيل التسليم حسب الطلب لهذا المشترك.'
                : 'تم إلغاء التسليم حسب الطلب لهذا المشترك.'
        )->flash();

        return redirect()->back();
    }

    /**
     * Business Purpose: لقطات رصيد القوارير لصفوف القائمة دون استعلام N+1، بنفس معادلة كشف الحساب.
     *
     * @param  Collection<int, Client>  $clients
     * @return array<int, array{billing_parent_id: int, total_bottle_received: int, total_bottle_empty: int, bottle_balance: int}>
     */
    private function bottleSnapshotsFor(Collection $clients): array
    {
        return $this->clientBottleBalance->familySnapshotsForClients($clients);
    }

    /**
     * Filters by subscription type: partial match on subscription_types.type_name
     * overrides exact subscription_type_id when the text field is filled.
     */
    private function applySubscriptionTypeFilter(Builder $query, Request $request): void
    {
        if ($request->filled('subscription_type_contains')) {
            $term = trim((string) $request->input('subscription_type_contains'));
            if ($term !== '') {
                $escaped = addcslashes($term, '%_\\');
                $pattern = '%'.$escaped.'%';
                $query->whereHas('subscriptionType', static function (Builder $relation) use ($pattern): void {
                    $relation->where('type_name', 'like', $pattern);
                });
            }
        } elseif ($request->filled('subscription_type_id')) {
            $query->where('subscription_type_id', $request->subscription_type_id);
        }
    }
}