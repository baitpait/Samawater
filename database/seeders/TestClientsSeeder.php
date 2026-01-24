<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\City;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use App\Models\Distributor;
use Carbon\Carbon;

/**
 * Business Purpose: إضافة 10 عملاء تجريبيين لاختبار النظام
 */
class TestClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء بيانات أساسية إذا لم تكن موجودة
        $this->createBasicData();

        // بيانات العملاء التجريبيين
        $clients = [
            [
                'contract_no' => 'CT-2026-001',
                'name' => 'أحمد محمد علي',
                'phone_one' => '0599123456',
                'phone_two' => '0599123457',
                'address' => 'شارع النصر، حي الرمال، رام الله',
                'client_type' => 'منزلي',
                'subscription_start_date' => Carbon::now()->subMonths(6),
                'bottle_balance' => 5,
                'notes' => 'عميل نشط، يدفع بانتظام',
            ],
            [
                'contract_no' => 'CT-2026-002',
                'name' => 'فاطمة خالد إبراهيم',
                'phone_one' => '0599234567',
                'phone_two' => null,
                'address' => 'شارع يافا، وسط البلد، نابلس',
                'client_type' => 'منزلي',
                'subscription_start_date' => Carbon::now()->subMonths(3),
                'bottle_balance' => 2,
                'notes' => 'عميل جديد',
            ],
            [
                'contract_no' => 'CT-2026-003',
                'name' => 'مؤسسة الأمل للتجارة',
                'phone_one' => '022345678',
                'phone_two' => '022345679',
                'address' => 'المنطقة الصناعية، البيرة',
                'client_type' => 'تجاري',
                'subscription_start_date' => Carbon::now()->subMonths(12),
                'bottle_balance' => 20,
                'notes' => 'عميل تجاري كبير، طلب أسبوعي',
            ],
            [
                'contract_no' => 'CT-2026-004',
                'name' => 'محمد سعيد حسن',
                'phone_one' => '0599345678',
                'phone_two' => null,
                'address' => 'حي المصايف، بيت لحم',
                'client_type' => 'منزلي',
                'subscription_start_date' => Carbon::now()->subMonths(2),
                'bottle_balance' => 0,
                'notes' => 'عميل جديد، يحتاج متابعة',
            ],
            [
                'contract_no' => 'CT-2026-005',
                'name' => 'مطعم الشام الذهبي',
                'phone_one' => '022987654',
                'phone_two' => '022987655',
                'address' => 'شارع القدس، الخليل',
                'client_type' => 'تجاري',
                'subscription_start_date' => Carbon::now()->subMonths(8),
                'bottle_balance' => 15,
                'notes' => 'مطعم، طلب يومي',
            ],
            [
                'contract_no' => 'CT-2026-006',
                'name' => 'سارة محمود عبدالله',
                'phone_one' => '0599456789',
                'phone_two' => '0599456790',
                'address' => 'حي الطيرة، طولكرم',
                'client_type' => 'منزلي',
                'subscription_start_date' => Carbon::now()->subMonths(4),
                'bottle_balance' => 3,
                'notes' => 'عميل نشط',
            ],
            [
                'contract_no' => 'CT-2026-007',
                'name' => 'شركة النور للمياه',
                'phone_one' => '022111222',
                'phone_two' => '022111223',
                'address' => 'المنطقة الصناعية، جنين',
                'client_type' => 'تجاري',
                'subscription_start_date' => Carbon::now()->subMonths(18),
                'bottle_balance' => 50,
                'notes' => 'عميل تجاري كبير، عقد سنوي',
            ],
            [
                'contract_no' => 'CT-2026-008',
                'name' => 'خالد يوسف أحمد',
                'phone_one' => '0599567890',
                'phone_two' => null,
                'address' => 'حي الشهداء، سلفيت',
                'client_type' => 'منزلي',
                'subscription_start_date' => Carbon::now()->subMonths(1),
                'bottle_balance' => 1,
                'notes' => 'عميل جديد جداً',
            ],
            [
                'contract_no' => 'CT-2026-009',
                'name' => 'مقهى الأصالة',
                'phone_one' => '022333444',
                'phone_two' => '022333445',
                'address' => 'شارع السلام، قلقيلية',
                'client_type' => 'تجاري',
                'subscription_start_date' => Carbon::now()->subMonths(10),
                'bottle_balance' => 8,
                'notes' => 'مقهى، طلب أسبوعي',
            ],
            [
                'contract_no' => 'CT-2026-010',
                'name' => 'ليلى عمر محمود',
                'phone_one' => '0599678901',
                'phone_two' => '0599678902',
                'address' => 'حي النهضة، طوباس',
                'client_type' => 'منزلي',
                'subscription_start_date' => Carbon::now()->subMonths(5),
                'bottle_balance' => 4,
                'notes' => 'عميل نشط، يدفع مقدماً',
            ],
        ];

        // جلب البيانات المرتبطة
        $cities = City::all();
        $subscriptionStatuses = SubscriptionStatus::all();
        $subscriptionTypes = SubscriptionType::all();
        $distributors = Distributor::all();

        // إنشاء العملاء
        foreach ($clients as $index => $clientData) {
            Client::create([
                'contract_no' => $clientData['contract_no'],
                'name' => $clientData['name'],
                'city_id' => $cities->isNotEmpty() ? $cities->random()->id : null,
                'address' => $clientData['address'],
                'phone_one' => $clientData['phone_one'],
                'phone_two' => $clientData['phone_two'],
                'client_type' => $clientData['client_type'],
                'subscription_type_id' => $subscriptionTypes->isNotEmpty() ? $subscriptionTypes->random()->id : null,
                'subscription_status_id' => $subscriptionStatuses->isNotEmpty() ? $subscriptionStatuses->random()->id : null,
                'subscription_start_date' => $clientData['subscription_start_date'],
                'bottle_balance' => $clientData['bottle_balance'],
                'distributor_id' => $distributors->isNotEmpty() ? $distributors->random()->id : null,
                'notes' => $clientData['notes'],
                'longitude' => 35.2 + (rand(0, 100) / 1000), // إحداثيات تقريبية لفلسطين
                'latitude' => 31.9 + (rand(0, 100) / 1000),
            ]);
        }

        $this->command->info('✅ تم إنشاء 10 عملاء تجريبيين بنجاح!');
    }

    /**
     * إنشاء بيانات أساسية إذا لم تكن موجودة
     */
    private function createBasicData(): void
    {
        // إنشاء مدينة افتراضية
        if (City::count() === 0) {
            City::create(['name' => 'رام الله']);
            City::create(['name' => 'نابلس']);
            City::create(['name' => 'الخليل']);
            City::create(['name' => 'بيت لحم']);
            $this->command->info('✅ تم إنشاء مدن افتراضية');
        }

        // إنشاء حالة اشتراك افتراضية
        if (SubscriptionStatus::count() === 0) {
            SubscriptionStatus::create(['name' => 'نشط']);
            SubscriptionStatus::create(['name' => 'متوقف']);
            SubscriptionStatus::create(['name' => 'ملغي']);
            $this->command->info('✅ تم إنشاء حالات اشتراك افتراضية');
        }

        // إنشاء نوع اشتراك افتراضي
        if (SubscriptionType::count() === 0) {
            SubscriptionType::create(['name' => 'أسبوعي']);
            SubscriptionType::create(['name' => 'شهري']);
            SubscriptionType::create(['name' => 'يومي']);
            $this->command->info('✅ تم إنشاء أنواع اشتراك افتراضية');
        }

        // إنشاء موزع افتراضي
        if (Distributor::count() === 0) {
            Distributor::create(['name' => 'موزع افتراضي']);
            $this->command->info('✅ تم إنشاء موزع افتراضي');
        }
    }
}
