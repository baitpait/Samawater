<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VClientsDueByTypeDaysIds;
use App\Models\City;
use App\Models\SubscriptionType;
use App\Models\ClientStatus;
use App\Models\SubscriptionStatus;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DeliveryListController extends Controller
{
    /**
     * Business Purpose: عرض قائمة التسليم مع فلاتر البحث لتمكين فريق التشغيل من تحديد المشتركين المستحقين بسرعة.
     */
    public function index(Request $request)
    {
        /* ===============================
           Query الأساسي (مع اسم المدينة ونوع المشترك والموزع)
           يشمل: المشتركين من VClientsDueByTypeDaysIds + المشتركين الذين delivery_on_demand = true
        =============================== */
        
        // جلب المشتركين من VClientsDueByTypeDaysIds (حسب أيام الاشتراك)
        $dueClientsQuery = VClientsDueByTypeDaysIds::query()
            ->leftJoin('cities', 'cities.id', '=', 'v_clients_due_by_type_days_ids.city_id')
            ->leftJoin('clients', 'clients.id', '=', 'v_clients_due_by_type_days_ids.client_id')
            ->leftJoin('subscription_types', 'subscription_types.id', '=', 'clients.subscription_type_id')
            ->leftJoin('distributors', 'distributors.id', '=', 'clients.distributor_id')
            ->select('v_clients_due_by_type_days_ids.*', 'cities.city_name', 'clients.client_type', 'distributors.name as distributor_name', 'subscription_types.id as subscription_type_id');

        /* ===============================
           البحث النصي
        =============================== */
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

        /* ===============================
           الفلاتر
        =============================== */
        if ($request->filled('city_id')) {
            $dueClientsQuery->where('v_clients_due_by_type_days_ids.city_id', $request->city_id);
        }

        if ($request->filled('subscription_type_name')) {
            $dueClientsQuery->where('subscription_type_name', $request->subscription_type_name);
        }
        
        if ($request->filled('subscription_type_id')) {
            $dueClientsQuery->where('clients.subscription_type_id', $request->subscription_type_id);
        }

        if ($request->filled('min_days')) {
            $operator = $request->get('days_operator', '>=');
            $dueClientsQuery->where('days_since_last_delivery', $operator, $request->min_days);
        }

        if ($request->filled('subscription_status_name')) {
            $dueClientsQuery->where('subscription_status_name', $request->subscription_status_name);
        }
        
        if ($request->filled('subscription_status_id')) {
            $dueClientsQuery->where('v_clients_due_by_type_days_ids.subscription_status_id', $request->subscription_status_id);
        }

        /* ===============================
           الترتيب
        =============================== */
        $dueClientsQuery->orderByDesc('days_since_last_delivery');

        /* ===============================
           النتائج (فقط بعد الضغط على زر البحث)
        =============================== */
        $clients = collect();
        $totalBottleReceived = 0;
        $totalBottleEmpty = 0;

        // عرض النتائج فقط بعد الضغط على زر البحث
        if ($request->has('search')) {
            // 1. جلب المشتركين من VClientsDueByTypeDaysIds
            $dueClients = $dueClientsQuery->get();
            
            // 2. جلب المشتركين الذين delivery_on_demand = true (تسليم حسب الطلب)
            $onDemandClientsQuery = \App\Models\Client::query()
                ->where('delivery_on_demand', true)
                ->leftJoin('cities', 'cities.id', '=', 'clients.city_id')
                ->leftJoin('subscription_types', 'subscription_types.id', '=', 'clients.subscription_type_id')
                ->leftJoin('subscription_statuses', 'subscription_statuses.id', '=', 'clients.subscription_status_id')
                ->leftJoin('client_statuses', function($join) {
                    $join->on(DB::raw('0'), '>=', 'client_statuses.min_percentage')
                         ->on(DB::raw('0'), '<=', 'client_statuses.max_percentage');
                })
                ->leftJoin('delivery', 'delivery.client_id', '=', 'clients.id')
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
                    'subscription_types.distribution_days',
                    'clients.subscription_start_date',
                    DB::raw('period_diff(date_format(curdate(),\'%Y%m\'),date_format(clients.subscription_start_date,\'%Y%m\')) as subscription_months'),
                    DB::raw('max(delivery.delivery_date) as last_delivery_date'),
                    DB::raw('count(delivery.id) as total_deliveries'),
                    DB::raw('COALESCE(to_days(curdate()) - to_days(max(delivery.delivery_date)), 999) as days_since_last_delivery'),
                    'clients.latitude',
                    'clients.longitude',
                    'clients.address',
                    'clients.notes',
                    DB::raw('coalesce(clients.bottle_balance,0) as bottle_balance_stored'),
                    DB::raw('0 as total_bottle_received'),
                    DB::raw('0 as total_bottle_empty'),
                    DB::raw('coalesce(clients.bottle_balance,0) as bottle_on_hand_calculated'),
                    DB::raw('0 as percentage_delivery_rate'),
                    'client_statuses.status_name as client_status_name',
                    'clients.image as client_image',
                    'clients.client_type',
                    'distributors.name as distributor_name',
                    'subscription_types.id as subscription_type_id'
                )
                ->groupBy('clients.id', 'clients.contract_no', 'clients.name', 'clients.phone_one', 'clients.phone_two', 'clients.city_id', 'cities.city_name', 'clients.subscription_status_id', 'subscription_statuses.status_name', 'subscription_types.type_name', 'subscription_types.distribution_days', 'clients.subscription_start_date', 'clients.latitude', 'clients.longitude', 'clients.address', 'clients.notes', 'clients.bottle_balance', 'client_statuses.status_name', 'clients.image', 'clients.client_type', 'distributors.name', 'subscription_types.id');
            
            // تطبيق نفس الفلاتر على onDemandClientsQuery
            if ($request->filled('q')) {
                $q = $request->q;
                $onDemandClientsQuery->where(function ($sub) use ($q) {
                    $sub->where('clients.name', 'like', "%{$q}%")
                        ->orWhere('clients.phone_one', 'like', "%{$q}%")
                        ->orWhere('clients.phone_two', 'like', "%{$q}%")
                        ->orWhere('clients.contract_no', 'like', "%{$q}%")
                        ->orWhere('clients.address', 'like', "%{$q}%");
                });
            }
            if ($request->filled('city_id')) {
                $onDemandClientsQuery->where('clients.city_id', $request->city_id);
            }
            if ($request->filled('subscription_type_id')) {
                $onDemandClientsQuery->where('clients.subscription_type_id', $request->subscription_type_id);
            }
            if ($request->filled('subscription_status_id')) {
                $onDemandClientsQuery->where('clients.subscription_status_id', $request->subscription_status_id);
            }
            
            $onDemandClients = $onDemandClientsQuery->get();
            
            // 3. دمج النتائج وإزالة التكرار (بناءً على client_id)
            $allClients = $dueClients->merge($onDemandClients)
                ->unique('client_id')
                ->values();
            
            // 4. حساب الإجماليات
            $totalBottleReceived = $allClients->sum('total_bottle_received') ?? 0;
            $totalBottleEmpty = $allClients->sum('total_bottle_empty') ?? 0;
            
            // 5. الترتيب
            $allClients = $allClients->sortByDesc('days_since_last_delivery')->values();
            
            // 6. Pagination
            $perPage = $request->get('per_page', 10);
            $perPage = in_array($perPage, [10, 50, 100, 'all']) ? $perPage : 10;
            $page = $request->get('page', 1);
            $total = $allClients->count();
            
            if ($perPage === 'all') {
                $items = $allClients;
                $clients = new LengthAwarePaginator(
                    $items,
                    $total,
                    $total > 0 ? $total : 1,
                    1,
                    ['path' => $request->url(), 'query' => $request->query()]
                );
            } else {
                $items = $allClients->slice(($page - 1) * $perPage, $perPage)->values();
                $clients = new LengthAwarePaginator(
                    $items,
                    $total,
                    $perPage,
                    $page,
                    ['path' => $request->url(), 'query' => $request->query()]
                );
            }
        }

        /* ===============================
           البيانات للفلاتر
        =============================== */
        $cities = City::orderBy('city_name')->get();
        
        // أنواع الاشتراك من View
        $subscriptionTypes = SubscriptionType::orderBy('type_name')->get();
        
        // حالات الالتزام من View
        $clientStatuses = ClientStatus::orderBy('status_name')->get();
        
        // حالات الاشتراك من View
        $subscriptionStatuses = SubscriptionStatus::orderBy('status_name')->get();
        
        // الموزعين
        $distributors = \App\Models\Distributor::orderBy('name')->get();

        return view('admin.delivery_list', compact(
            'clients',
            'cities',
            'subscriptionTypes',
            'clientStatuses',
            'subscriptionStatuses',
            'distributors',
            'totalBottleReceived',
            'totalBottleEmpty'
        ));
    }
}
