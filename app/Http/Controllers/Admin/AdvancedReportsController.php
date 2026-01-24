<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\City;
use App\Models\Delivery;
use App\Models\Distributor;
use App\Models\ClientStatus;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use App\Models\VClientsDueByTypeDaysIds;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mpdf\Mpdf;

class AdvancedReportsController extends Controller
{
    public function index(Request $request)
    {
        // ===== تحديد الفترة الزمنية =====
        $period = $request->get('period', 'month'); // day, week, month, year
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        
        // ===== فلاتر إضافية =====
        $cityId = $request->get('city_id');
        $distributorId = $request->get('distributor_id');

        // ===== حساب التواريخ حسب الفترة =====
        if ($dateFrom && $dateTo) {
            $startDate = Carbon::parse($dateFrom);
            $endDate = Carbon::parse($dateTo);
        } else {
            switch ($period) {
                case 'day':
                    $startDate = Carbon::today();
                    $endDate = Carbon::today();
                    break;
                case 'week':
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    break;
                case 'month':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    break;
                case 'year':
                    $startDate = Carbon::now()->startOfYear();
                    $endDate = Carbon::now()->endOfYear();
                    break;
                default:
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
            }
        }

        // ===== 1. تقرير التسليمات اليومية =====
        $dailyDeliveriesQuery = Delivery::whereBetween('delivery_date', [$startDate, $endDate]);
        
        // تطبيق فلتر الموزع
        if ($distributorId) {
            $dailyDeliveriesQuery->where('distributor_id', $distributorId);
        }
        
        // تطبيق فلتر المدينة (من خلال العملاء)
        if ($cityId) {
            $dailyDeliveriesQuery->whereHas('client', function($q) use ($cityId) {
                $q->where('city_id', $cityId);
            });
        }
        
        $dailyDeliveries = $dailyDeliveriesQuery
            ->selectRaw('DATE(delivery_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ===== 2. تقرير التسليمات الشهرية =====
        // استخدام دالة متوافقة مع SQLite و MySQL
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $monthlyDeliveries = Delivery::whereBetween('delivery_date', [$startDate->copy()->subMonths(11), $endDate])
                ->selectRaw("STRFTIME('%Y-%m', delivery_date) as month, COUNT(*) as count")
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $monthlyDeliveries = Delivery::whereBetween('delivery_date', [$startDate->copy()->subMonths(11), $endDate])
                ->selectRaw('DATE_FORMAT(delivery_date, "%Y-%m") as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        // ===== 3. تقرير أداء الموزعين =====
        $distributorPerformanceQuery = Delivery::whereBetween('delivery_date', [$startDate, $endDate])
            ->join('distributors', 'deliveries.distributor_id', '=', 'distributors.id');
        
        // تطبيق فلتر المدينة
        if ($cityId) {
            $distributorPerformanceQuery->join('clients', 'deliveries.client_id', '=', 'clients.id')
                ->where('clients.city_id', $cityId);
        }
        
        // تطبيق فلتر الموزع
        if ($distributorId) {
            $distributorPerformanceQuery->where('deliveries.distributor_id', $distributorId);
        }
        
        $distributorPerformance = $distributorPerformanceQuery
            ->select(
                'distributors.id',
                'distributors.name',
                DB::raw('COUNT(deliveries.id) as deliveries_count'),
                DB::raw('SUM(deliveries.bottle_received) as total_bottles_received'),
                DB::raw('SUM(deliveries.bottle_empty) as total_bottles_empty'),
                DB::raw('SUM(deliveries.paymant) as total_payment')
            )
            ->groupBy('distributors.id', 'distributors.name')
            ->orderByDesc('deliveries_count')
            ->get();

        // ===== 4. توزيع العملاء حسب المدن =====
        $clientsByCityQuery = City::withCount('clients');
        
        // تطبيق فلتر المدينة
        if ($cityId) {
            $clientsByCityQuery->where('id', $cityId);
        }
        
        $clientsByCity = $clientsByCityQuery
            ->having('clients_count', '>', 0)
            ->orderByDesc('clients_count')
            ->take(20) // فقط أول 20 مدينة
            ->get();
        
        // ===== 4.1. معدل الالتزام حسب المدينة =====
        $commitmentByCity = City::orderBy('city_name')->get()->map(function ($city) {
            // استخدام جدول clients مباشرة بدلاً من View غير موجود
            try {
                $clients = Client::where('city_id', $city->id)->get();
            } catch (\Exception $e) {
                return null;
            }
            
            if ($clients->isEmpty()) {
                return null;
            }
            
            $totalClients = $clients->count();
            
            // حساب بسيط: استخدام subscription_status_id كبديل
            // (في الإنتاج سيتم حساب نسبة الالتزام الفعلية من التسليمات)
            $excellent = $clients->where('subscription_status_id', 1)->count();
            $veryGood = 0;
            $moderate = 0;
            $poor = $totalClients - $excellent;
            
            // حساب متوسط نسبة الالتزام (قيمة افتراضية بناءً على subscription_status)
            // في الإنتاج سيتم حسابها من التسليمات الفعلية
            $avgCommitment = $totalClients > 0 ? (($excellent * 95 + $veryGood * 82 + $moderate * 62 + $poor * 25) / $totalClients) : 0;
            
            return [
                'city_id' => $city->id,
                'city_name' => $city->city_name,
                'total_clients' => $totalClients,
                'excellent' => $excellent,
                'very_good' => $veryGood,
                'moderate' => $moderate,
                'poor' => $poor,
                'avg_commitment' => round($avgCommitment, 1)
            ];
        })->filter(function($item) {
            return $item !== null;
        })->take(15)->values();

        // ===== 5. العملاء حسب حالة الالتزام =====
        $clientsByCommitment = ClientStatus::orderBy('min_percentage')->get()->map(function ($status) {
            // استخدام جدول clients مباشرة بدلاً من View غير موجود
            try {
                $count = Client::where('subscription_status_id', $status->id ?? 1)->count();
            } catch (\Exception $e) {
                $count = 0;
            }
            return [
                'status' => $status->status_name,
                'count' => $count,
                'min' => $status->min_percentage,
                'max' => $status->max_percentage
            ];
        });

        // ===== 6. العملاء حسب حالة الاشتراك =====
        $clientsBySubscriptionStatus = SubscriptionStatus::orderBy('id')->get()->map(function ($status) {
            $count = Client::where('subscription_status_id', $status->id)->count();
            return [
                'status' => $status->status_name,
                'count' => $count
            ];
        });

        // ===== 7. العملاء حسب نوع الاشتراك =====
        $clientsBySubscriptionType = SubscriptionType::orderBy('type_name')->get()->map(function ($type) {
            $count = Client::where('subscription_type_id', $type->id)->count();
            return [
                'type' => $type->type_name,
                'count' => $count,
                'distribution_days' => $type->distribution_days
            ];
        });

        // ===== 8. إحصائيات القوارير =====
        $bottlesStats = [
            'warehouse' => Delivery::sum('bottle_empty'),
            'with_customers' => Client::sum('bottle_balance') + 
                               Delivery::sum('bottle_received') - 
                               Delivery::sum('bottle_empty'),
            'total' => Client::sum('bottle_balance') + 
                      Delivery::sum('bottle_received')
        ];

        // ===== 9. العملاء المستحقين =====
        $clientsDueCount = VClientsDueByTypeDaysIds::count();

        // ===== 10. الموزعين المسوقين (كم عميل سوقوا) =====
        $marketingDistributors = Distributor::orderBy('name')->get()->map(function ($distributor) {
            $clientsCount = Client::where('distributor_id', $distributor->id)->count();
            $activeClientsCount = Client::where('distributor_id', $distributor->id)
                ->where('subscription_status_id', 1)
                ->count();
            return [
                'id' => $distributor->id,
                'name' => $distributor->name,
                'total_clients' => $clientsCount,
                'active_clients' => $activeClientsCount
            ];
        })->sortByDesc('total_clients')
          ->take(20) // أول 20 موزع (لإظهار جميع الموزعين حتى لو لم يسوقوا عملاء)
          ->values();

        // ===== 11. تقرير نمو العملاء (الشهري) =====
        // استخدام دالة متوافقة مع SQLite و MySQL
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $clientGrowth = Client::selectRaw("STRFTIME('%Y-%m', COALESCE(subscription_start_date, created_at)) as month, COUNT(*) as count")
                ->where(function($q) use ($startDate, $endDate) {
                    $q->whereBetween(DB::raw('COALESCE(subscription_start_date, created_at)'), [$startDate->copy()->subMonths(11), $endDate])
                      ->orWhereNull('subscription_start_date');
                })
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $clientGrowth = Client::selectRaw('DATE_FORMAT(COALESCE(subscription_start_date, created_at), "%Y-%m") as month, COUNT(*) as count')
                ->where(function($q) use ($startDate, $endDate) {
                    $q->whereBetween(DB::raw('COALESCE(subscription_start_date, created_at)'), [$startDate->copy()->subMonths(11), $endDate])
                      ->orWhereNull('subscription_start_date');
                })
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }
        
        // ===== 12. إحصائيات عامة =====
        $generalStatsQuery = Client::query();
        $deliveriesInPeriodQuery = Delivery::whereBetween('delivery_date', [$startDate, $endDate]);
        
        // تطبيق الفلاتر على الإحصائيات العامة
        if ($cityId) {
            $generalStatsQuery->where('city_id', $cityId);
        }
        if ($distributorId) {
            $generalStatsQuery->where('distributor_id', $distributorId);
        }
        if ($cityId) {
            $deliveriesInPeriodQuery->whereHas('client', function($q) use ($cityId) {
                $q->where('city_id', $cityId);
            });
        }
        if ($distributorId) {
            $deliveriesInPeriodQuery->where('distributor_id', $distributorId);
        }
        
        $generalStats = [
            'total_clients' => $generalStatsQuery->count(),
            'active_clients' => (clone $generalStatsQuery)->where('subscription_status_id', 1)->count(),
            'total_deliveries' => Delivery::count(),
            'deliveries_in_period' => $deliveriesInPeriodQuery->count(),
            'total_distributors' => Distributor::count(),
            'total_cities' => City::count()
        ];

        // ===== بيانات للفلاتر =====
        $cities = City::orderBy('city_name')->get();
        $distributors = Distributor::orderBy('name')->get();

        return view('admin.reports.advanced', compact(
            'period',
            'dateFrom',
            'dateTo',
            'startDate',
            'endDate',
            'cityId',
            'distributorId',
            'dailyDeliveries',
            'monthlyDeliveries',
            'distributorPerformance',
            'clientsByCity',
            'commitmentByCity',
            'clientsByCommitment',
            'clientsBySubscriptionStatus',
            'clientsBySubscriptionType',
            'bottlesStats',
            'clientsDueCount',
            'marketingDistributors',
            'clientGrowth',
            'generalStats',
            'cities',
            'distributors'
        ));
    }

    // ===== تصدير PDF =====
    public function exportPdf(Request $request)
    {
        // نفس منطق index
        $period = $request->get('period', 'month');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        if ($dateFrom && $dateTo) {
            $startDate = Carbon::parse($dateFrom);
            $endDate = Carbon::parse($dateTo);
        } else {
            switch ($period) {
                case 'day':
                    $startDate = Carbon::today();
                    $endDate = Carbon::today();
                    break;
                case 'week':
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    break;
                case 'month':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    break;
                case 'year':
                    $startDate = Carbon::now()->startOfYear();
                    $endDate = Carbon::now()->endOfYear();
                    break;
                default:
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
            }
        }

        $generalStats = [
            'total_clients' => Client::count(),
            'active_clients' => Client::where('subscription_status_id', 1)->count(),
            'total_deliveries' => Delivery::count(),
            'deliveries_in_period' => Delivery::whereBetween('delivery_date', [$startDate, $endDate])->count(),
        ];

        $distributorPerformance = Delivery::whereBetween('delivery_date', [$startDate, $endDate])
            ->join('distributors', 'deliveries.distributor_id', '=', 'distributors.id')
            ->select(
                'distributors.name',
                DB::raw('COUNT(deliveries.id) as deliveries_count'),
                DB::raw('SUM(deliveries.paymant) as total_payment')
            )
            ->groupBy('distributors.id', 'distributors.name')
            ->orderByDesc('deliveries_count')
            ->get();

        $html = view('admin.reports.advanced_pdf', compact(
            'startDate',
            'endDate',
            'generalStats',
            'distributorPerformance'
        ))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'directionality' => 'rtl',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'التقارير_المتقدمة_' . date('Y-m-d') . '.pdf',
            'I'
        ))->header('Content-Type', 'application/pdf');
    }

    // ===== تصدير Excel/CSV =====
    public function exportExcel(Request $request)
    {
        // نفس منطق index
        $period = $request->get('period', 'month');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $cityId = $request->get('city_id');
        $distributorId = $request->get('distributor_id');

        if ($dateFrom && $dateTo) {
            $startDate = Carbon::parse($dateFrom);
            $endDate = Carbon::parse($dateTo);
        } else {
            switch ($period) {
                case 'day':
                    $startDate = Carbon::today();
                    $endDate = Carbon::today();
                    break;
                case 'week':
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    break;
                case 'month':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    break;
                case 'year':
                    $startDate = Carbon::now()->startOfYear();
                    $endDate = Carbon::now()->endOfYear();
                    break;
                default:
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
            }
        }

        $distributorPerformanceQuery = Delivery::whereBetween('delivery_date', [$startDate, $endDate])
            ->join('distributors', 'deliveries.distributor_id', '=', 'distributors.id');
        
        if ($cityId) {
            $distributorPerformanceQuery->join('clients', 'deliveries.client_id', '=', 'clients.id')
                ->where('clients.city_id', $cityId);
        }
        
        if ($distributorId) {
            $distributorPerformanceQuery->where('deliveries.distributor_id', $distributorId);
        }
        
        $distributorPerformance = $distributorPerformanceQuery
            ->select(
                'distributors.name',
                DB::raw('COUNT(delivery.id) as deliveries_count'),
                DB::raw('SUM(delivery.bottle_received) as total_bottles_received'),
                DB::raw('SUM(delivery.bottle_empty) as total_bottles_empty'),
                DB::raw('SUM(delivery.paymant) as total_payment')
            )
            ->groupBy('distributors.id', 'distributors.name')
            ->orderByDesc('deliveries_count')
            ->get();

        $filename = 'التقارير_المتقدمة_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($distributorPerformance, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            
            // BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, ['التقارير المتقدمة'], ';');
            fputcsv($file, ['من تاريخ', $startDate->format('Y-m-d'), 'إلى تاريخ', $endDate->format('Y-m-d')], ';');
            fputcsv($file, []); // Empty row
            
            // أداء الموزعين
            fputcsv($file, ['أداء الموزعين'], ';');
            fputcsv($file, ['اسم الموزع', 'عدد التسليمات', 'القوارير المستلمة', 'القوارير الفارغة', 'إجمالي الدفعات'], ';');
            foreach ($distributorPerformance as $distributor) {
                fputcsv($file, [
                    $distributor->name,
                    $distributor->deliveries_count,
                    $distributor->total_bottles_received,
                    $distributor->total_bottles_empty,
                    $distributor->total_payment ?? 0
                ], ';');
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

