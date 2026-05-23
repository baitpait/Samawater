<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\InventoryItem;
use App\Models\ClientPayment;
use App\Support\CachedDeliveryFormOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Business Purpose: صفحة إدخال جماعي للتسليمات (Excel-like)
 * - عرض جميع المشتركين من قائمة التسليم في جدول قابل للتعديل
 * - إدخال بيانات التسليم مباشرة في الخلايا
 * - حفظ جماعي أو حفظ لكل صف
 */
class BulkDeliveryController extends Controller
{
    /**
     * Business Purpose: عرض صفحة الإدخال الجماعي مع نفس فلاتر قائمة التسليم
     */
    public function index(Request $request)
    {
        $filterOptions = CachedDeliveryFormOptions::all();
        $cities = $filterOptions['cities'];
        $subscriptionTypes = $filterOptions['subscriptionTypes'];
        $subscriptionStatuses = $filterOptions['subscriptionStatuses'];
        $distributors = $filterOptions['distributors'];

        $bulkEntryDistributorLocked = false;
        $defaultBulkEntryDistributorId = null;
        $bulkEntryDistributorDisplayName = null;
        $user = backpack_user();
        if ($user && $user->isDistributor() && $user->distributor !== null) {
            $bulkEntryDistributorLocked = true;
            $defaultBulkEntryDistributorId = (int) $user->distributor->id;
            $bulkEntryDistributorDisplayName = $user->distributor->name;
        } elseif ($distributors->isNotEmpty()) {
            $defaultBulkEntryDistributorId = (int) $distributors->first()->id;
        }

        // جلب نفس البيانات من DeliveryListController
        $dueClientsQuery = DB::table('v_clients_due_by_type_days_ids')
            ->leftJoin('cities', 'cities.id', '=', 'v_clients_due_by_type_days_ids.city_id')
            ->leftJoin('clients', 'clients.id', '=', 'v_clients_due_by_type_days_ids.client_id')
            ->leftJoin('subscription_types', 'subscription_types.id', '=', 'clients.subscription_type_id')
            ->leftJoin('distributors', 'distributors.id', '=', 'clients.distributor_id')
            ->select(
                'v_clients_due_by_type_days_ids.client_id',
                'v_clients_due_by_type_days_ids.client_name',
                'v_clients_due_by_type_days_ids.phone_one',
                'v_clients_due_by_type_days_ids.days_since_last_delivery',
                'cities.city_name',
                'clients.client_type',
                'distributors.name as distributor_name',
                'subscription_types.id as subscription_type_id'
            );

        // توحيد فلتر حالة الاشتراك مع قائمة التسليم (id أو اسم الحالة من query النظام)
        $subscriptionStatusFilterId = $this->resolveSubscriptionStatusFilterId($request);

        // تطبيق الفلاتر
        if ($request->filled('q')) {
            $q = $request->q;
            $dueClientsQuery->where(function ($sub) use ($q) {
                $sub->where('v_clients_due_by_type_days_ids.client_name', 'like', "%{$q}%")
                    ->orWhere('v_clients_due_by_type_days_ids.phone_one', 'like', "%{$q}%")
                    ->orWhere('v_clients_due_by_type_days_ids.phone_two', 'like', "%{$q}%")
                    ->orWhere('v_clients_due_by_type_days_ids.contract_no', 'like', "%{$q}%")
                    ->orWhere('clients.address', 'like', "%{$q}%");
            });
        }

        if ($request->filled('city_id')) {
            $dueClientsQuery->where('v_clients_due_by_type_days_ids.city_id', $request->city_id);
        }

        if ($request->filled('subscription_type_id')) {
            $dueClientsQuery->where('clients.subscription_type_id', $request->subscription_type_id);
        }

        if ($subscriptionStatusFilterId !== null) {
            $dueClientsQuery->where('v_clients_due_by_type_days_ids.subscription_status_id', $subscriptionStatusFilterId);
        }

        $minDays = $request->filled('min_days') ? (int) $request->min_days : null;
        if ($request->has('search') && $minDays === null) {
            $minDays = 1;
        }
        if ($minDays !== null) {
            $operator = $request->get('days_operator', '>=');
            $dueClientsQuery->where('v_clients_due_by_type_days_ids.days_since_last_delivery', $operator, $minDays);
        }

        $dueClientsQuery->orderByDesc('v_clients_due_by_type_days_ids.days_since_last_delivery');

        // جلب المشتركين الذين delivery_on_demand = true
        $onDemandClientsQuery = null;
        $hasAnyDelivery = Delivery::query()->exists();
        if ($hasAnyDelivery) {
            $onDemandClientsQuery = Client::query()
                ->where('delivery_on_demand', true)
                ->leftJoin('cities', 'cities.id', '=', 'clients.city_id')
                ->leftJoin('subscription_types', 'subscription_types.id', '=', 'clients.subscription_type_id')
                ->leftJoin('subscription_statuses', 'subscription_statuses.id', '=', 'clients.subscription_status_id')
                ->leftJoin('distributors', 'distributors.id', '=', 'clients.distributor_id')
                ->select(
                    'clients.id as client_id',
                    'clients.contract_no',
                    'clients.name as client_name',
                    'clients.phone_one',
                    'clients.phone_two',
                    'clients.city_id',
                    'cities.city_name',
                    'clients.subscription_status_id',
                    'subscription_statuses.status_name as subscription_status_name',
                    'subscription_types.type_name as subscription_type_name',
                    'clients.subscription_type_id',
                    DB::raw('max(deliveries.delivery_date) as last_delivery_date'),
                    DB::raw('COALESCE(to_days(curdate()) - to_days(max(deliveries.delivery_date)), 999) as days_since_last_delivery'),
                    'clients.address',
                    'clients.client_type',
                    'distributors.name as distributor_name'
                )
                ->leftJoin('deliveries', 'deliveries.client_id', '=', 'clients.id')
                ->groupBy('clients.id', 'clients.contract_no', 'clients.name', 'clients.phone_one', 'clients.phone_two', 'clients.city_id', 'cities.city_name', 'clients.subscription_status_id', 'subscription_statuses.status_name', 'subscription_types.type_name', 'clients.subscription_type_id', 'clients.address', 'clients.client_type', 'distributors.name');
        }

        // تطبيق نفس الفلاتر على onDemandClientsQuery
        if ($onDemandClientsQuery && $request->filled('q')) {
            $q = $request->q;
            $onDemandClientsQuery->where(function ($sub) use ($q) {
                $sub->where('clients.name', 'like', "%{$q}%")
                    ->orWhere('clients.phone_one', 'like', "%{$q}%")
                    ->orWhere('clients.phone_two', 'like', "%{$q}%")
                    ->orWhere('clients.contract_no', 'like', "%{$q}%")
                    ->orWhere('clients.address', 'like', "%{$q}%");
            });
        }

        if ($onDemandClientsQuery && $request->filled('city_id')) {
            $onDemandClientsQuery->where('clients.city_id', $request->city_id);
        }

        if ($onDemandClientsQuery && $request->filled('subscription_type_id')) {
            $onDemandClientsQuery->where('clients.subscription_type_id', $request->subscription_type_id);
        }

        if ($onDemandClientsQuery && $subscriptionStatusFilterId !== null) {
            $onDemandClientsQuery->where('clients.subscription_status_id', $subscriptionStatusFilterId);
        }

        if ($onDemandClientsQuery && $minDays !== null) {
            $operator = $request->get('days_operator', '>=');
            $onDemandClientsQuery->havingRaw(
                'COALESCE(to_days(curdate()) - to_days(max(deliveries.delivery_date)), 999) ' . $operator . ' ?',
                [$minDays]
            );
        }

        // دمج النتائج
        $dueClients = $dueClientsQuery->get();
        $onDemandClients = $onDemandClientsQuery ? $onDemandClientsQuery->get() : collect();

        $allClients = collect($dueClients)->merge($onDemandClients)
            ->unique('client_id')
            ->sortByDesc('days_since_last_delivery')
            ->values();

        // جلب المخزون الحالي
        $inventoryItem = InventoryItem::where('id', 1)->first();
        $currentInventory = $inventoryItem ? $inventoryItem->quantity : 0;

        return view('admin.bulk_delivery_entry', compact(
            'allClients',
            'currentInventory',
            'cities',
            'subscriptionTypes',
            'subscriptionStatuses',
            'subscriptionStatusFilterId',
            'distributors',
            'bulkEntryDistributorLocked',
            'defaultBulkEntryDistributorId',
            'bulkEntryDistributorDisplayName'
        ));
    }

    /**
     * Business Purpose: مطابقة فلتر الحالة بين نموذج الإدخال الجماعي (id) وروابط قائمة التسليم (اسم الحالة).
     */
    private function resolveSubscriptionStatusFilterId(Request $request): ?int
    {
        if ($request->filled('subscription_status_id')) {
            return (int) $request->subscription_status_id;
        }
        if ($request->filled('subscription_status_name')) {
            $id = DB::table('subscription_statuses')
                ->where('status_name', $request->subscription_status_name)
                ->value('id');

            return $id !== null ? (int) $id : null;
        }

        return null;
    }

    /**
     * Business Purpose: حفظ تسليم واحد (من صف في الجدول)
     */
    public function storeSingle(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'delivery_date' => 'required|date',
            'distributor_id' => 'required|integer|exists:distributors,id',
            'bottle_received' => 'required|integer|min:0',
            'bottle_empty' => 'required|integer|min:0',
            'required_amount' => 'required|numeric|min:0',
            'paymant' => 'required|numeric|min:0',
        ]);

        $result = $this->createDelivery($validated);
        
        // جلب المخزون المحدث
        $inventoryItem = InventoryItem::find(1);
        $result['inventory'] = $inventoryItem ? $inventoryItem->quantity : 0;
        
        return response()->json($result);
    }

    /**
     * Business Purpose: حفظ عدة تسليمات دفعة واحدة
     */
    public function storeBulk(Request $request)
    {
        $deliveries = $request->input('deliveries', []);
        $results = [];

        foreach ($deliveries as $deliveryData) {
            try {
                $validated = validator($deliveryData, [
                    'client_id' => 'required|integer|exists:clients,id',
                    'delivery_date' => 'required|date',
                    'distributor_id' => 'required|integer|exists:distributors,id',
                    'bottle_received' => 'required|integer|min:0',
                    'bottle_empty' => 'required|integer|min:0',
                    'required_amount' => 'required|numeric|min:0',
                    'paymant' => 'required|numeric|min:0',
                ])->validate();

                $result = $this->createDelivery($validated);
                $results[] = [
                    'client_id' => $validated['client_id'],
                    'success' => true,
                    'delivery_id' => $result['delivery_id'] ?? null,
                ];
            } catch (\Exception $e) {
                $results[] = [
                    'client_id' => $deliveryData['client_id'] ?? null,
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }

        // جلب المخزون المحدث
        $inventoryItem = InventoryItem::find(1);
        $currentInventory = $inventoryItem ? $inventoryItem->quantity : 0;

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ ' . count(array_filter($results, fn($r) => $r['success'])) . ' تسليم بنجاح',
            'results' => $results,
            'inventory' => $currentInventory,
        ]);
    }

    /**
     * Business Purpose: إنشاء تسليم مع إدارة المخزون والدفعات (نفس منطق DeliveryCrudController)
     */
    private function createDelivery(array $data)
    {
        // التحقق من وجود الصنف id=1 في المخزون
        $inventoryItem = InventoryItem::find(1);
        if (!$inventoryItem) {
            throw new \Exception('⚠️ صنف العبوات غير موجود في المخزون.');
        }

        // إنشاء التسليم
        $delivery = Delivery::create([
            'client_id' => $data['client_id'],
            'delivery_date' => $data['delivery_date'],
            'bottle_received' => $data['bottle_received'],
            'bottle_empty' => $data['bottle_empty'],
            'required_amount' => $data['required_amount'],
            'inventory_item_id' => 1,
            'paymant' => $data['paymant'] ?? 0,
            'distributor_id' => (int) $data['distributor_id'],
        ]);

        // إدارة المخزون
        if ($delivery->bottle_received > 0) {
            InventoryItem::subtractQuantity($inventoryItem->item_name, $delivery->bottle_received);
        }

        if ($delivery->bottle_empty > 0) {
            InventoryItem::addQuantity($inventoryItem->item_name, $delivery->bottle_empty);
        }

        // إرجاع delivery_on_demand إلى false بعد التسليم
        $client = Client::find($delivery->client_id);
        if ($client && $client->delivery_on_demand) {
            $client->update(['delivery_on_demand' => false]);
        }

        // إنشاء ClientPayment إذا كان paymant > 0
        if ($delivery->paymant > 0) {
            $parentClient = $client ? $client->getParentClient() : null;

            if ($parentClient) {
                $clientPayment = ClientPayment::create([
                    'client_id' => $parentClient->id,
                    'amount' => $delivery->paymant,
                    'payment_date' => $delivery->delivery_date,
                    'payment_method' => 'cash',
                    'notes' => "دفعة من تسليم #{$delivery->id}" . ($client->id != $parentClient->id ? " (عنوان: {$client->name})" : ''),
                    'created_by' => backpack_user()->id,
                ]);

                $delivery->client_payment_id = $clientPayment->id;
                $delivery->save();
            }
        }

        return [
            'success' => true,
            'delivery_id' => $delivery->id,
            'message' => 'تم حفظ التسليم بنجاح',
        ];
    }
}
