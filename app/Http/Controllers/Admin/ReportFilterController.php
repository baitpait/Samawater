<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use App\Models\City;
use App\Services\ClientBottleBalanceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
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

    /**
     * Business Purpose: تصدير CSV مطابق لأعمدة جدول الفلاتر (دين، رصيد قوارير، حسب الطلب، ملاحظات…).
     */
    public function exportExcel(Request $request)
    {
        $clients = $this->filteredClientsForExport($request);
        $bottleSnapshotsByClientId = $this->bottleSnapshotsFor($clients);

        $filename = 'قائمة_العملاء_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // BOM UTF-8 + علامة RTL لفتح Excel من اليمين لليسار
        $output = "\xEF\xBB\xBF\xE2\x80\x8F";
        $output .= implode(',', [
            'المشترك',
            'الهاتف',
            'المدينة',
            'العنوان',
            'طريقة التعامل',
            'دين المشترك',
            'رصيد القوارير',
            'آخر استلام',
            'الأيام',
            'نوع الاشتراك',
            'حسب الطلب',
            'ملاحظات العميل',
        ]) . "\n";

        foreach ($clients as $client) {
            $bottleSnapshot = $bottleSnapshotsByClientId[(int) $client->id] ?? [
                'bottle_balance' => 0,
            ];
            $lastDeliveryDate = $client->lastDelivery
                ? \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->format('Y-m-d')
                : '';

            $output .= implode(',', [
                $this->csvCell($client->name ?? ''),
                $this->csvCell($client->phone_one ?? ''),
                $this->csvCell($client->city->city_name ?? ''),
                $this->csvCell($client->address ?? ''),
                $this->csvCell($client->interaction_method ?? ''),
                $this->csvCell(number_format((float) ($client->combined_subscriber_debt ?? 0), 2, '.', '')),
                $this->csvCell((string) (int) ($bottleSnapshot['bottle_balance'] ?? 0)),
                $this->csvCell($lastDeliveryDate),
                $this->csvCell($this->daysSinceLastDeliveryLabel($client)),
                $this->csvCell($client->subscriptionType->type_name ?? ''),
                $this->csvCell($client->delivery_on_demand ? 'نعم' : 'لا'),
                $this->csvCell($client->notes ?? ''),
            ]) . "\n";
        }

        return response($output, 200, $headers);
    }

    /**
     * Business Purpose: تصدير PDF مطابق لجدول الفلاتر؛ يستخدم Output(S) حتى يصل الملف عبر استجابة Laravel.
     */
    public function exportPdf(Request $request)
    {
        $clients = $this->filteredClientsForExport($request);
        $bottleSnapshotsByClientId = $this->bottleSnapshotsFor($clients);

        $html = view('admin.reports.filters_pdf', compact('clients', 'bottleSnapshotsByClientId'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'directionality' => 'rtl',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        $filename = 'قائمة_العملاء_' . date('Y-m-d') . '.pdf';
        $pdfBinary = $mpdf->Output($filename, \Mpdf\Output\Destination::STRING_RETURN);

        return response($pdfBinary, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Business Purpose: نفس فلاتر صفحة التقارير لتصدير Excel/PDF دون ترقيم الصفحات.
     *
     * @return Collection<int, Client>
     */
    private function filteredClientsForExport(Request $request): Collection
    {
        $query = Client::query()->with([
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
            $query->whereBetween('subscription_start_date', [
                $request->from,
                $request->to,
            ]);
        }

        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        $this->applySubscriptionTypeFilter($query, $request);

        if ($request->subscription_status_id) {
            $query->where('subscription_status_id', $request->subscription_status_id);
        }

        return $query->orderBy('address')->get();
    }

    /**
     * Business Purpose: نص الأيام منذ آخر تسليم بنفس صياغة جدول الفلاتر.
     */
    private function daysSinceLastDeliveryLabel(Client $client): string
    {
        if (! $client->lastDelivery) {
            return 'لم يستلم';
        }

        $days = (int) \Carbon\Carbon::parse($client->lastDelivery->delivery_date)
            ->startOfDay()
            ->diffInDays(now()->startOfDay());

        if ($days === 0) {
            return 'اليوم';
        }
        if ($days === 1) {
            return 'أمس';
        }

        return "منذ {$days} يوم";
    }

    /**
     * Business Purpose: تهريب خلية CSV بأمان للعرض في Excel.
     */
    private function csvCell(string $value): string
    {
        return '"' . str_replace('"', '""', $value) . '"';
    }

    /**
     * Business Purpose: تفعيل/إلغاء «تسليم حسب الطلب» من جدول الفلاتر (JSON للـ AJAX أو redirect كاحتياطي).
     */
    public function toggleDeliveryOnDemand(Request $request, Client $client): RedirectResponse|JsonResponse
    {
        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        $client->delivery_on_demand = $request->boolean('enabled');
        $client->save();

        $enabled = (bool) $client->delivery_on_demand;
        $message = $enabled
            ? 'تم تفعيل التسليم حسب الطلب لهذا المشترك — سيظهر في قائمة التسليم حتى دون استحقاق الأيام.'
            : 'تم إلغاء التسليم حسب الطلب لهذا المشترك.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'enabled' => $enabled,
                'message' => $message,
                'client_id' => (int) $client->id,
            ]);
        }

        \Alert::success($message)->flash();

        return redirect()
            ->route('reports.filters', $this->filtersQueryFromRequest($request))
            ->with('success', $message);
    }

    /**
     * Business Purpose: استعادة فلاتر صفحة المشتركين بعد POST زر حسب الطلب.
     *
     * @return array<string, mixed>
     */
    private function filtersQueryFromRequest(Request $request): array
    {
        $query = collect($request->only([
            'q',
            'city_id',
            'subscription_type_id',
            'subscription_type_contains',
            'from',
            'to',
            'page',
        ]))->filter(static function ($value): bool {
            return $value !== null && $value !== '';
        })->all();

        // الإبقاء على «الكل» لحالة الاشتراك (قيمة فارغة صريحة) حتى لا يعود الافتراضي إلى «نشط».
        if ($request->has('subscription_status_id')) {
            $query['subscription_status_id'] = $request->input('subscription_status_id');
        }

        return $query;
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