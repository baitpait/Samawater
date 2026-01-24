<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ===== Indexes على جدول deliveries =====
        // Index على delivery_date (للفلترة حسب التاريخ)
        if (!$this->indexExists('deliveries', 'deliveries_delivery_date_index')) {
            Schema::table('deliveries', function (Blueprint $table) {
                $table->index('delivery_date', 'deliveries_delivery_date_index');
            });
        }

        // Index على client_id (للفلترة حسب العميل)
        if (!$this->indexExists('deliveries', 'deliveries_client_id_index')) {
            Schema::table('deliveries', function (Blueprint $table) {
                $table->index('client_id', 'deliveries_client_id_index');
            });
        }

        // Index على distributor_id (للفلترة حسب الموزع)
        if (!$this->indexExists('deliveries', 'deliveries_distributor_id_index')) {
            Schema::table('deliveries', function (Blueprint $table) {
                $table->index('distributor_id', 'deliveries_distributor_id_index');
            });
        }

        // Composite Index على (client_id, delivery_date) للاستعلامات المشتركة
        // التحقق من وجود الأعمدة أولاً
        if (Schema::hasColumn('deliveries', 'client_id') && Schema::hasColumn('deliveries', 'delivery_date')) {
            if (!$this->indexExists('deliveries', 'deliveries_client_date_index')) {
                Schema::table('deliveries', function (Blueprint $table) {
                    $table->index(['client_id', 'delivery_date'], 'deliveries_client_date_index');
                });
            }
        }

        // ===== Indexes على جدول clients =====
        // Index على city_id (للفلترة حسب المدينة)
        if (Schema::hasColumn('clients', 'city_id') && !$this->indexExists('clients', 'clients_city_id_index')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->index('city_id', 'clients_city_id_index');
            });
        }

        // Index على subscription_status_id (للفلترة حسب حالة الاشتراك)
        if (Schema::hasColumn('clients', 'subscription_status_id') && !$this->indexExists('clients', 'clients_subscription_status_id_index')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->index('subscription_status_id', 'clients_subscription_status_id_index');
            });
        }

        // Index على subscription_type_id (للفلترة حسب نوع الاشتراك)
        if (Schema::hasColumn('clients', 'subscription_type_id') && !$this->indexExists('clients', 'clients_subscription_type_id_index')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->index('subscription_type_id', 'clients_subscription_type_id_index');
            });
        }

        // Index على distributor_id (للفلترة حسب الموزع)
        if (Schema::hasColumn('clients', 'distributor_id') && !$this->indexExists('clients', 'clients_distributor_id_index')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->index('distributor_id', 'clients_distributor_id_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف Indexes من deliveries
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropIndex('deliveries_delivery_date_index');
            $table->dropIndex('deliveries_client_id_index');
            $table->dropIndex('deliveries_distributor_id_index');
            $table->dropIndex('deliveries_client_date_index');
        });

        // حذف Indexes من clients
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex('clients_city_id_index');
            $table->dropIndex('clients_subscription_status_id_index');
            $table->dropIndex('clients_subscription_type_id_index');
            $table->dropIndex('clients_distributor_id_index');
        });
    }

    /**
     * التحقق من وجود Index
     * 
     * Business Purpose: التحقق من وجود Index قبل إنشائه لتجنب الأخطاء عند إعادة تشغيل Migration
     * يدعم MySQL/MariaDB فقط (تم إزالة دعم SQLite)
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();
        
        // MySQL/MariaDB
        if (in_array($driver, ['mysql', 'mariadb'])) {
            $databaseName = $connection->getDatabaseName();
            $result = DB::select(
                "SELECT COUNT(*) as count 
                 FROM information_schema.statistics 
                 WHERE table_schema = ? 
                 AND table_name = ? 
                 AND index_name = ?",
                [$databaseName, $table, $indexName]
            );

            return $result[0]->count > 0;
        }
        
        // Fallback: استخدام Schema::hasIndex() إذا كان متاحاً
        try {
            return Schema::hasIndex($table, $indexName);
        } catch (\Exception $e) {
            // إذا فشل، نفترض أن Index غير موجود
            return false;
        }
    }
};
