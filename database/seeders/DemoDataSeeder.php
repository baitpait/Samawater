<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\ClientType;
use App\Models\City;
use App\Models\Delivery;
use App\Models\Distributor;
use App\Models\InventoryItem;
use App\Models\Role;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ضمان عدم وجود تسليمات تجريبية
        Delivery::query()->delete();

        $this->seedLookups();
        $this->seedInventory();
        $distributors = $this->seedDistributors();
        $this->seedAdminUser();
        $this->seedClients($distributors, 20);
    }

    private function seedLookups(): void
    {
        $cities = [
            'رام الله', 'نابلس', 'الخليل', 'بيت لحم', 'جنين', 'طولكرم',
            'قلقيلية', 'سلفيت', 'طوباس', 'أريحا', 'دورا', 'يطا',
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(['city_name' => $city]);
        }

        $subscriptionTypes = [
            ['type_name' => 'يومي', 'distribution_days' => 1],
            ['type_name' => 'أسبوعي', 'distribution_days' => 7],
            ['type_name' => 'نصف شهري', 'distribution_days' => 14],
            ['type_name' => 'شهري', 'distribution_days' => 30],
        ];
        foreach ($subscriptionTypes as $type) {
            SubscriptionType::firstOrCreate(
                ['type_name' => $type['type_name']],
                ['distribution_days' => $type['distribution_days']]
            );
        }

        $subscriptionStatuses = ['نشط', 'متوقف', 'ملغي'];
        foreach ($subscriptionStatuses as $status) {
            SubscriptionStatus::firstOrCreate(['status_name' => $status]);
        }

        $clientStatuses = [
            ['status_name' => 'منتظم', 'min_percentage' => 80, 'max_percentage' => 100],
            ['status_name' => 'متوسط', 'min_percentage' => 50, 'max_percentage' => 79.99],
            ['status_name' => 'ضعيف', 'min_percentage' => 0, 'max_percentage' => 49.99],
        ];
        foreach ($clientStatuses as $status) {
            ClientStatus::firstOrCreate(
                ['status_name' => $status['status_name']],
                [
                    'min_percentage' => $status['min_percentage'],
                    'max_percentage' => $status['max_percentage'],
                ]
            );
        }

        $clientTypes = ['منزلي', 'تجاري', 'مؤسسة'];
        foreach ($clientTypes as $type) {
            ClientType::firstOrCreate(['type_name' => $type]);
        }
    }

    private function seedInventory(): void
    {
        InventoryItem::firstOrCreate(
            ['item_name' => 'عبوات'],
            ['quantity' => 2000]
        );
    }

    private function seedDistributors()
    {
        $names = [
            'موزع رام الله',
            'موزع نابلس',
            'موزع الخليل',
            'موزع بيت لحم',
        ];

        $distributors = [];
        foreach ($names as $index => $name) {
            $phone = '0599' . str_pad((string) (1100 + $index), 6, '0', STR_PAD_LEFT);
            $password = $phone;

            $distributor = Distributor::create([
                'name' => $name,
                'phone' => $phone,
                'username' => $phone,
                'password_hash' => bcrypt($password),
                'status' => 'active',
                'notes' => 'بيانات تجريبية',
                'latitude' => 31.9 + ($index * 0.01),
                'longitude' => 35.2 + ($index * 0.01),
                'last_update' => Carbon::now(),
            ]);

            $roleDistributor = Role::where('name', Role::NAME_DISTRIBUTOR)->first();
            User::create([
                'name' => $name,
                'email' => $phone . '@distributor.local',
                'password' => $password,
                'role_id' => $roleDistributor?->id,
                'distributor_id' => $distributor->id,
            ]);

            $distributors[] = $distributor;
        }

        return $distributors;
    }

    private function seedAdminUser(): void
    {
        $role = Role::where('name', Role::NAME_SUPER_ADMIN)->first();

        User::updateOrCreate(
            ['email' => 'admin@sama.test'],
            [
                'name' => 'مدير النظام',
                'password' => 'Admin@12345',
                'role_id' => $role?->id,
            ]
        );
    }

    private function seedClients(array $distributors, int $count): void
    {
        $firstNames = [
            'محمد', 'أحمد', 'محمود', 'علي', 'خالد', 'سامي', 'يوسف', 'عمر', 'طارق', 'بلال',
            'فاطمة', 'سارة', 'ليان', 'ريم', 'هند', 'سلمى', 'آية', 'نور', 'ميس', 'دانا',
        ];
        $lastNames = [
            'التميمي', 'العمور', 'القدومي', 'البرغوثي', 'النجار', 'العابد', 'الزيداني', 'حماد',
            'العبادلة', 'المقدسي', 'الحمامي', 'الكرمي', 'البدير', 'أبو عودة',
        ];

        $cities = City::all();
        $subscriptionTypes = SubscriptionType::all();
        $subscriptionStatuses = SubscriptionStatus::all();

        for ($i = 1; $i <= $count; $i++) {
            $first = $firstNames[array_rand($firstNames)];
            $last = $lastNames[array_rand($lastNames)];
            $fullName = $first . ' ' . $last;
            $phone = '059' . str_pad((string) random_int(1000000, 9999999), 7, '0', STR_PAD_LEFT);

            $city = $cities->random();
            $subscriptionType = $subscriptionTypes->random();
            $subscriptionStatus = $subscriptionStatuses->random();
            $distributor = $distributors[array_rand($distributors)];

            Client::create([
                'contract_no' => 'CT-2026-' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'name' => $fullName,
                'city_id' => $city->id,
                'address' => 'عنوان تجريبي في ' . $city->city_name,
                'phone_one' => $phone,
                'phone_two' => null,
                'client_type' => $i % 3 === 0 ? 'تجاري' : 'منزلي',
                'subscription_type_id' => $subscriptionType->id,
                'subscription_status_id' => $subscriptionStatus->id,
                'subscription_start_date' => Carbon::now()->subDays(random_int(10, 400)),
                'longitude' => 35.2 + (random_int(0, 100) / 1000),
                'latitude' => 31.9 + (random_int(0, 100) / 1000),
                'bottle_balance' => random_int(0, 20),
                'delivery_on_demand' => false,
                'notes' => 'بيانات تجريبية',
                'distributor_id' => $distributor->id,
            ]);
        }
    }
}
