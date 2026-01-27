<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Business Purpose: ضمان عدم تكرار بيانات الموزعين الحرجة.
     */
    public function up(): void
    {
        if (Schema::hasTable('distributors')) {
            if (Schema::hasColumn('distributors', 'username') && ! $this->indexExists('distributors', 'distributors_username_unique')) {
                Schema::table('distributors', function (Blueprint $table): void {
                    $table->unique('username', 'distributors_username_unique');
                });
            }

            if (Schema::hasColumn('distributors', 'phone') && ! $this->indexExists('distributors', 'distributors_phone_unique')) {
                Schema::table('distributors', function (Blueprint $table): void {
                    $table->unique('phone', 'distributors_phone_unique');
                });
            }
        }
    }

    /**
     * Business Purpose: التراجع الآمن عن قيود التفرد للموزعين.
     */
    public function down(): void
    {
        if (Schema::hasTable('distributors')) {
            if ($this->indexExists('distributors', 'distributors_username_unique')) {
                Schema::table('distributors', function (Blueprint $table): void {
                    $table->dropUnique('distributors_username_unique');
                });
            }

            if ($this->indexExists('distributors', 'distributors_phone_unique')) {
                Schema::table('distributors', function (Blueprint $table): void {
                    $table->dropUnique('distributors_phone_unique');
                });
            }
        }
    }

    /**
     * Business Purpose: التحقق من وجود Index قبل إنشائه لتجنب أخطاء التنفيذ.
     */
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

        return false;
    }
};
