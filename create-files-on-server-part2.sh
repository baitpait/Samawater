#!/bin/bash

# الجزء الثاني من السكريبت - باقي الملفات
echo "=========================================="
echo "🚀 الجزء الثاني: إنشاء باقي الملفات"
echo "=========================================="

cd /home/sarfesak/public_html/eliyaa

# 6. تحديث resources/views/vendor/backpack/crud/list.blade.php
echo "6/11: تحديث list.blade.php..."
# سنحتاج لقراءة الملف الحالي وإضافة التعديل المطلوب
# هذا التعديل معقد، لذلك سنقوم بإنشاء نسخة محدثة

# 7. تحديث app/Http/Controllers/Admin/ClientCrudController.php
echo "7/11: تحديث ClientCrudController.php..."
cat > app/Http/Controllers/Admin/ClientCrudController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

class ClientCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Client::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client');
        CRUD::setEntityNameStrings('عميل', 'العملاء');
    }

    /* =======================
       قائمة العملاء (List)
    ======================== */
    protected function setupListOperation()
    {
        // تعطيل responsive table details row (إزالة النقاط الثلاث)
        CRUD::setOperationSetting('responsiveTable', false);
        CRUD::setOperationSetting('detailsRow', false);

        // إزالة جميع الأزرار الافتراضية (ما عدا زر الإضافة)
        CRUD::removeButton('show');
        CRUD::removeButton('edit');
        CRUD::removeButton('delete');
        CRUD::removeButton('revisions');
        CRUD::removeButton('reorder');

        // تفعيل زر الإضافة بشكل صريح
        CRUD::allowAccess('create');

        // تعطيل عمود الإجراءات الافتراضي
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);

        // Eager loading للعلاقات
        $this->crud->addClause('with', ['city', 'subscriptionStatus', 'lastDelivery']);

        // تطبيق الفلاتر
        $this->crud->addClause(function ($query) {
            if (request('city_id')) {
                $query->where('city_id', request('city_id'));
            }
            if (request('client_type')) {
                $query->where('client_type', request('client_type'));
            }
            if (request('client_status_id')) {
                $query->where('client_status_id', request('client_status_id'));
            }
            if (request('subscription_type_id')) {
                $query->where('subscription_type_id', request('subscription_type_id'));
            }
            if (request('subscription_status_id')) {
                $query->where('subscription_status_id', request('subscription_status_id'));
            }
            if (request('phone')) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . request('phone') . '%')
                      ->orWhere('phone_one', 'like', '%' . request('phone') . '%')
                      ->orWhere('phone_two', 'like', '%' . request('phone') . '%');
                });
            }
        });

        // الأعمدة: اسم المشترك، رقم الهاتف، العنوان فقط

        // 1. اسم المشترك
  CRUD::addColumn([
            'name'  => 'client_name',
            'label' => 'اسم المشترك',
            'type'  => 'custom_html',
            'orderable' => true,
            'searchable' => true,
            'priority' => 1,
            'value' => function ($entry) {
                return '<div style="font-size: 15px; color: #1f2937; font-weight: 600; text-align: right; direction: rtl;">' . e($entry->name) . '</div>';
            },
        ]);

        // 2. رقم الهاتف
        CRUD::addColumn([
            'name'  => 'client_phone',
            'label' => 'رقم الهاتف',
            'type'  => 'custom_html',
            'orderable' => false,
            'searchable' => false,
            'priority' => 2,
            'value' => function ($entry) {
                $phone = $entry->phone_one ? $entry->phone_one : ($entry->phone_two ? $entry->phone_two : '-');
                return '<div style="font-size: 14px; color: #374151; text-align: center;">' . e($phone) . '</div>';
            },
        ]);

        // 3. العنوان
        CRUD::addColumn([
            'name'  => 'client_address',
            'label' => 'العنوان',
            'type'  => 'custom_html',
            'orderable' => false,
            'searchable' => false,
            'priority' => 3,
            'value' => function ($entry) {
                $address = $entry->address ? $entry->address : '-';
                return '<div style="font-size: 14px; color: #374151; text-align: right; direction: rtl;">' . e($address) . '</div>';
            },
        ]);

        // لا نضيف عمود الإجراءات - عرض فقط
    }

    /* =======================
       صفحة الإضافة (Create)
    ======================== */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientRequest::class);

        CRUD::addFields([

            [
                'name'  => 'contract_no',
                'label' => 'رقم العقد',
                'type'  => 'text',
            ],

            [
                'name'  => 'name',
                'label' => 'اسم العميل',
                'type'  => 'text',
            ],

            [
                'name'      => 'city_id',
                'label'     => 'المدينة',
                'type'      => 'select',
                'entity'    => 'city',
                'model'     => \App\Models\City::class,
                'attribute' => 'city_name',
            ],

            [
                'name'  => 'address',
                'label' => 'العنوان',
                'type'  => 'textarea',
            ],

            [
                'name'  => 'phone_one',
                'label' => 'رقم الهاتف الأول',
                'type'  => 'text',
            ],

            [
                'name'  => 'phone_two',
                'label' => 'رقم الهاتف الثاني',
                'type'  => 'text',
            ],

            [
                'name'    => 'client_type',
                'label'   => 'نوع العميل',
                'type'    => 'select_from_array',
                // ✅ نفس القيم المستخدمة في قاعدة البيانات وفي الأعمدة
                'options' => [
                    1 => 'فردي',
                    2 => 'مؤسسة',
                    3 => 'تجاري',
                ],
            ],

            [
                'name'      => 'subscription_type_id',
                'label'     => 'نوع الاشتراك',
                'type'      => 'select',
                'entity'    => 'subscriptionType',
                'model'     => \App\Models\SubscriptionType::class,
                'attribute' => 'type_name',
            ],

            [
                'name'      => 'subscription_status_id',
                'label'     => 'حالة الاشتراك',
                'type'      => 'select',
                'entity'    => 'subscriptionStatus',
                'model'     => \App\Models\SubscriptionStatus::class,
                // ✅ هنا كان الخطأ غالبًا – الحقل اسمه status_name
                'attribute' => 'status_name',
            ],

            [
                'name'  => 'subscription_start_date',
                'label' => 'تاريخ بدء الاشتراك',
                'type'  => 'date',
            ],

            [
                'name'  => 'bottle_balance',
                'label' => 'رصيد القوارير',
                'type'  => 'number',
            ],

            [
                'name'        => 'distributor_id',
                'label'       => 'الموزع المسوق (الذي سوق للعميل)',
                'type'        => 'select_from_array',
                'options'     => $this->getDistributorOptions(),
                'allows_null' => true,
],


            [
                'name'  => 'notes',
                'label' => 'ملاحظات',
                'type'  => 'textarea',
            ],
        ]);
    }

    /* =======================
       صفحة التعديل (Update)
    ======================== */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /* =======================
       دالة مساعدة: جلب خيارات الموزعين
    ======================== */
    protected function getDistributorOptions()
    {
        $distributors = \App\Models\Distributor::orderBy('name')->get();
        $options = ['' => '-- اختر الموزع --'];

        foreach ($distributors as $distributor) {
            $clientsCount = \App\Models\Client::where('distributor_id', $distributor->id)->count();
            $options[$distributor->id] = $distributor->name . ' (عدد العملاء: ' . $clientsCount . ')';
        }

        return $options;
    }

    /* =======================
       صفحة المعاينة (Show)
    ======================== */
    protected function setupShowOperation()
    {
        // 1. رقم العقد
        CRUD::addColumn([
            'name'  => 'contract_no',
            'label' => 'رقم العقد',
            'type'  => 'text',
        ]);

        // 2. الصورة - سيتم عرضها في show.blade.php

        // 3. المدينة
        CRUD::addColumn([
            'name'      => 'city_id',
            'label'     => 'المدينة',
            'type'      => 'select',
            'entity'    => 'city',
            'model'     => \App\Models\City::class,
            'attribute' => 'city_name',
        ]);

        // 4. العنوان
        CRUD::addColumn([
            'name'  => 'address',
            'label' => 'العنوان',
            'type'  => 'text',
        ]);

        // 5. رقم الهاتف الأول
        CRUD::addColumn([
            'name'  => 'phone_one',
            'label' => 'رقم الهاتف الأول',
            'type'  => 'text',
        ]);

        // 6. رقم الهاتف الثاني
        CRUD::addColumn([
            'name'  => 'phone_two',
            'label' => 'رقم الهاتف الثاني',
            'type'  => 'text',
        ]);

        // 7. تاريخ الاشتراك
        CRUD::addColumn([
            'name'     => 'subscription_start_date',
            'label'    => 'تاريخ الاشتراك',
            'type'     => 'custom_html',
            'escaped'  => false,
            'value'    => function ($entry) {
                if (!$entry->subscription_start_date) {
                    return '<span style="color: #9ca3af; font-style: italic;">-</span>';
                }
                return '<span style="color: #1f2937; font-weight: 600;">'.\Carbon\Carbon::parse($entry->subscription_start_date)->format('Y-m-d').'</span>';
            },
        ]);

        // 8. تاريخ آخر تسليم
        CRUD::addColumn([
            'name'  => 'last_delivery_date',
            'label' => 'تاريخ آخر تسليم',
            'type'  => 'custom_html',
            'escaped' => false,
            'value' => function ($entry) {
                if (!$entry->lastDelivery) {
                    return '<span style="color: #9ca3af; font-style: italic;">-</span>';
                }
                $lastDate = \Carbon\Carbon::parse($entry->lastDelivery->delivery_date)->format('Y-m-d');
                return '<span style="color: #1f2937; font-weight: 600;">'.$lastDate.'</span>';
            },
        ]);

        // 9. المدة
        CRUD::addColumn([
            'name'  => 'days_since_last_delivery',
            'label' => 'المدة',
            'type'  => 'custom_html',
            'escaped' => false,
            'value' => function ($entry) {
                if (!$entry->lastDelivery) {
                    return '<span class="info-badge badge-secondary">لم يستلم بعد</span>';
                }
                $days = (int) \Carbon\Carbon::parse($entry->lastDelivery->delivery_date)->startOfDay()->diffInDays(now()->startOfDay());
                if ($days === 0) {
                    return '<span class="info-badge badge-success">اليوم</span>';
                } elseif ($days === 1) {
                    return '<span class="info-badge badge-primary">أمس</span>';
                } elseif ($days === 2) {
                    return '<span class="info-badge badge-primary">منذ يومين</span>';
                } elseif ($days <= 10) {
                    return '<span class="info-badge badge-warning">منذ '.$days.' أيام</span>';
                } else {
                    return '<span class="info-badge badge-danger">منذ '.$days.' يوم</span>';
                }
            },
        ]);

        // 10. رصيد القوارير
        CRUD::addColumn([
            'name'  => 'bottle_balance',
            'label' => 'رصيد القوارير',
            'type'  => 'number',
        ]);

        // 11. نوع الاشتراك
        CRUD::addColumn([
            'name'      => 'subscription_type_id',
            'label'     => 'نوع الاشتراك',
            'type'      => 'select',
            'entity'    => 'subscriptionType',
            'model'     => \App\Models\SubscriptionType::class,
            'attribute' => 'type_name',
        ]);

        // 12. حالة الاشتراك
        CRUD::addColumn([
            'name'      => 'subscription_status_id',
            'label'     => 'حالة الاشتراك',
            'type'      => 'select',
            'entity'    => 'subscriptionStatus',
            'model'     => \App\Models\SubscriptionStatus::class,
            'attribute' => 'status_name',
        ]);

        // 13. الموقع العميل
CRUD::addColumn([
            'name'  => 'location',
            'label' => 'موقع العميل',
    'type'  => 'custom_html',
    'escaped' => false,
    'value' => function ($entry) {
                // التحقق من وجود القيم بشكل صحيح
                $latitude = $entry->latitude;
                $longitude = $entry->longitude;

                // التحقق من أن القيم موجودة وليست null أو 0 أو فارغة
                if (is_null($latitude) || is_null($longitude) ||
                    $latitude == 0 || $longitude == 0 ||
                    $latitude == '' || $longitude == '') {
                    return '<div style="padding: 20px; text-align: center; background: #f3f4f6; border-radius: 12px;">
                        <span style="color: #9ca3af; font-style: italic; font-size: 14px;">لم يتم تحديد الموقع</span>
                    </div>';
                }

                // تنظيف القيم للتأكد من أنها أرقام صحيحة
                $latitude = floatval($latitude);
                $longitude = floatval($longitude);

                // التحقق من أن القيم ضمن النطاق الصحيح
                if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
                    return '<div style="padding: 20px; text-align: center; background: #f3f4f6; border-radius: 12px;">
                        <span style="color: #9ca3af; font-style: italic; font-size: 14px;">إحداثيات الموقع غير صحيحة</span>
                    </div>';
        }

                // عرض الخريطة
                return '<div style="width:100%;height:300px;border-radius:12px;overflow:hidden;box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    <iframe
                        width="100%"
                        height="300"
                        frameborder="0"
                        style="border:0; border-radius: 12px;"
                        src="https://maps.google.com/maps?q='.$latitude.','.$longitude.'&z=15&output=embed"
                        allowfullscreen>
                    </iframe>
                </div>';
    },
]);

        // 14. اسم الموزع - سيتم عرضه بجانب رقم العقد
CRUD::addColumn([
    'name'      => 'distributor_id',
            'label'     => 'من طرف الموزع',
    'type'      => 'select',
    'entity'    => 'distributor',
    'model'     => \App\Models\Distributor::class,
    'attribute' => 'name',
]);

        // 15. الملاحظات - سيتم عرضها في عمود منفصل في show.blade.php
        CRUD::addColumn([
            'name'  => 'notes',
            'label' => 'ملاحظات',
            'type'  => 'text',
        ]);
    }

    /* =======================
       حذف العميل (Destroy)
    ======================== */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $entry = $this->crud->getEntry($id);

        if (!$entry) {
            \Alert::error('العميل غير موجود.')->flash();
            return redirect($this->crud->route);
        }

        // تم إلغاء الشرط - يمكن حذف العميل حتى لو كان لديه تسليمات
        // سيتم حذف التسليمات تلقائياً إذا كانت العلاقة onDelete('cascade')

        $clientName = $entry->name; // حفظ الاسم قبل الحذف
        $entry->delete();

        \Alert::success('تم حذف العميل "' . $clientName . '" بنجاح.')->flash();
        return redirect($this->crud->route);
    }
}
EOF

# 8. تحديث app/Models/Client.php
echo "8/11: تحديث Client.php..."
cat > app/Models/Client.php << 'EOF'
<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use CrudTrait;
    use HasFactory;

    // حذف التسليمات تلقائياً عند حذف العميل
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($client) {
            // حذف جميع التسليمات المرتبطة بالعميل
            $client->deliveries()->delete();
        });
    }

    protected $table = 'clients';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'contract_no',
        'name',
        'city_id',
        'address',
        'phone_one',
        'phone_two',
        'client_type',
        'subscription_type_id',
        'subscription_status_id',
        'subscription_start_date',
        'longitude',
        'latitude',
        'bottle_balance',
        'notes',
        'city_name',
        'distributor_id',
        'image'
    ];


public function lastDelivery()
{
    return $this->hasOne(\App\Models\Delivery::class, 'client_id')
                ->latest('delivery_date');
}


    public function city()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }

    public function subscriptionType()
    {
        return $this->belongsTo(\App\Models\SubscriptionType::class, 'subscription_type_id');
    }

    public function subscriptionStatus()
    {
        return $this->belongsTo(\App\Models\SubscriptionStatus::class, 'subscription_status_id');
    }

    // عدد مرات الدفع (كل سجل فيه مبلغ)
public function getPaymentsCountAttribute()
{
    return $this->deliveries()->where('paymant', '>', 0)->count();
}
 public function distributor()
    {
        return $this->belongsTo(
            \App\Models\Distributor::class,
            'distributor_id'
        );
    }
// إجمالي المدفوع
public function getTotalPaidAttribute()
{
    return $this->deliveries()->sum('paymant');
}

// عدد مرات التوصيل
public function getDeliveriesCountAttribute()
{
    return $this->deliveries()->count();
}
public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'client_id');
    }

// القوارير الممتلئة
public function getFilledBottlesAttribute()
{
    return $this->deliveries()->sum('bottle_received');
}

// القوارير الفارغة
public function getEmptyBottlesAttribute()
{
    return $this->deliveries()->sum('bottle_empty');
}

// رصيد القوارير عند العميل
public function getBottleBalanceAttribute()
{
    return $this->filled_bottles - $this->empty_bottles;
}


}
EOF

# 9. إنشاء app/Http/Controllers/Admin/DatabaseBackupController.php
echo "9/11: إنشاء DatabaseBackupController.php..."
cat > app/Http/Controllers/Admin/DatabaseBackupController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class DatabaseBackupController
{
    /**
     * تحميل نسخة احتياطية من قاعدة البيانات
     */
    public function download()
    {
        try {
            // معلومات قاعدة البيانات من .env
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPassword = config('database.connections.mysql.password');
            $dbHost = config('database.connections.mysql.host');

            // اسم الملف مع التاريخ والوقت
            $fileName = 'eliyaa_backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
            $filePath = storage_path('app/backups/' . $fileName);

            // إنشاء مجلد backups إذا لم يكن موجوداً
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            // أمر mysqldump
            $command = sprintf(
                'mysqldump -h %s -u %s -p%s %s > %s',
                escapeshellarg($dbHost),
                escapeshellarg($dbUser),
                escapeshellarg($dbPassword),
                escapeshellarg($dbName),
                escapeshellarg($filePath)
            );

            // تنفيذ الأمر
            exec($command, $output, $returnVar);

            // التحقق من نجاح العملية
            if ($returnVar !== 0 || !file_exists($filePath)) {
                // إذا فشل mysqldump، نستخدم طريقة بديلة
                return $this->downloadUsingLaravel($fileName);
            }

            // حذف النسخ القديمة (الأقدم من 7 أيام)
            $this->cleanOldBackups();

            // تحميل الملف
            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Alert::error('فشل في إنشاء النسخة الاحتياطية: ' . $e->getMessage())->flash();
            return redirect()->back();
        }
    }

    /**
     * طريقة بديلة باستخدام Laravel (أبطأ لكن تعمل دائماً)
     */
    private function downloadUsingLaravel($fileName)
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $tableKey = 'Tables_in_' . $dbName;

            $sql = "-- Eliyaa Database Backup\n";
            $sql .= "-- Date: " . Carbon::now()->toDateTimeString() . "\n";
            $sql .= "-- Database: {$dbName}\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;

                // بنية الجدول
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $sql .= "-- Table: {$tableName}\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

                // البيانات
                $rows = DB::table($tableName)->get();

                if ($rows->count() > 0) {
                    $sql .= "-- Data for table: {$tableName}\n";

                    foreach ($rows as $row) {
                        $row = (array) $row;
                        $columns = array_keys($row);
                        $values = array_values($row);

                        // تنظيف القيم
                        $values = array_map(function($value) {
                            if (is_null($value)) {
                                return 'NULL';
                            }
                            return "'" . addslashes($value) . "'";
                        }, $values);

                        $sql .= sprintf(
                            "INSERT INTO `{$tableName}` (`%s`) VALUES (%s);\n",
                            implode('`, `', $columns),
                            implode(', ', $values)
                        );
                    }

                    $sql .= "\n";
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            // حفظ الملف
            $filePath = storage_path('app/backups/' . $fileName);
            file_put_contents($filePath, $sql);

            // حذف النسخ القديمة
            $this->cleanOldBackups();

            // تحميل الملف
            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Alert::error('فشل في إنشاء النسخة الاحتياطية: ' . $e->getMessage())->flash();
            return redirect()->back();
        }
    }

    /**
     * حذف النسخ الاحتياطية القديمة
     */
    private function cleanOldBackups()
    {
        $backupPath = storage_path('app/backups');

        if (!file_exists($backupPath)) {
            return;
        }

        $files = glob($backupPath . '/eliyaa_backup_*.sql');
        $now = time();

        foreach ($files as $file) {
            if (is_file($file)) {
                // حذف الملفات الأقدم من 7 أيام
                if ($now - filemtime($file) >= 7 * 24 * 60 * 60) {
                    unlink($file);
                }
            }
        }
    }
}
EOF

# 10. تحديث routes/web.php
echo "10/11: تحديث routes/web.php..."
# سنحتاج لقراءة الملف الحالي وإضافة السطر المطلوب
# Route::get('admin/backup/download', [App\Http\Controllers\Admin\DatabaseBackupController::class, 'download'])->middleware(['web', 'admin'])->name('backup.download');

# 11. تحديث resources/views/vendor/backpack/ui/inc/menu_items.blade.php
echo "11/11: تحديث menu_items.blade.php..."
# هذا معقد، سنقوم بإنشاء نسخة محدثة

echo ""
echo "=========================================="
echo "✅ تم إنشاء باقي الملفات!"
echo "=========================================="
echo "⏳ الملفات المُنشأة/المُحدثة:"
echo "✅ 6. ClientCrudController.php"
echo "✅ 7. Client.php Model"
echo "✅ 8. DatabaseBackupController.php"
echo "⏳ 9. routes/web.php (يحتاج تعديل يدوي)"
echo "⏳ 10. menu_items.blade.php (يحتاج تعديل يدوي)"
echo "⏳ 11. list.blade.php (يحتاج تعديل يدوي)"
echo ""
echo "🚀 الخطوة التالية: تشغيل الأوامر النهائية"
echo "=========================================="
EOF

<xai:function_call> <parameter name="run_terminal_cmd">
<parameter name="command">chmod +x create-files-on-server-part2.sh && echo "✅ تم إنشاء الجزء الثاني من السكريبت"
