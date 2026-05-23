<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Business Purpose: فهرس على عمود delivery_on_demand لتسريع استعلام قائمة التسليم الإضافي (عند الطلب).
     */
    public function up(): void
    {
        if (! Schema::hasColumn('clients', 'delivery_on_demand')) {
            return;
        }

        if (! $this->indexExists('clients', 'clients_delivery_on_demand_index')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->index('delivery_on_demand', 'clients_delivery_on_demand_index');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('clients')) {
            return;
        }
        if ($this->indexExists('clients', 'clients_delivery_on_demand_index')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropIndex('clients_delivery_on_demand_index');
            });
        }
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            $databaseName = $connection->getDatabaseName();
            $result = DB::select(
                'SELECT COUNT(*) as count
                 FROM information_schema.statistics
                 WHERE table_schema = ?
                 AND table_name = ?
                 AND index_name = ?',
                [$databaseName, $table, $indexName]
            );

            return isset($result[0]) && (int) $result[0]->count > 0;
        }

        try {
            return Schema::hasIndex($table, $indexName);
        } catch (\Throwable) {
            return false;
        }
    }
};
