<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إكمال أعمدة التسليمات لحساب رصيد المشترك في قواعد Eliyaa المستوردة.
 * هجرة 2026_01_09_204125 قد تبقى «معلّقة» بينما الجداول موجودة مسبقاً؛ ربط client_payment_id
 * ضروري لاستعلام whereDoesntHave('linkedDelivery') على مدفوعات العملاء.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('deliveries')) {
            return;
        }

        Schema::table('deliveries', function (Blueprint $table): void {
            if (! Schema::hasColumn('deliveries', 'required_amount')) {
                $table->decimal('required_amount', 10, 2)->default(0)->after('bottle_empty');
            }

            if (! Schema::hasColumn('deliveries', 'inventory_item_id')) {
                $after = Schema::hasColumn('deliveries', 'required_amount') ? 'required_amount' : 'bottle_empty';
                $table->unsignedBigInteger('inventory_item_id')->nullable()->after($after);
            }

            if (! Schema::hasColumn('deliveries', 'client_payment_id')) {
                $table->unsignedBigInteger('client_payment_id')->nullable()->after('paymant');
            }
        });

        $this->addForeignKeyIfPossible(
            'deliveries',
            'client_payment_id',
            'client_payments',
            'id',
            'set null'
        );

        if (Schema::hasTable('inventory_items')) {
            $this->addForeignKeyIfPossible(
                'deliveries',
                'inventory_item_id',
                'inventory_items',
                'id',
                'restrict'
            );
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('deliveries')) {
            return;
        }

        Schema::table('deliveries', function (Blueprint $table): void {
            if (Schema::hasColumn('deliveries', 'client_payment_id')) {
                try {
                    $table->dropForeign(['client_payment_id']);
                } catch (\Throwable) {
                }
                $table->dropColumn('client_payment_id');
            }

            if (Schema::hasColumn('deliveries', 'inventory_item_id')) {
                try {
                    $table->dropForeign(['inventory_item_id']);
                } catch (\Throwable) {
                }
                $table->dropColumn('inventory_item_id');
            }

            if (Schema::hasColumn('deliveries', 'required_amount')) {
                $table->dropColumn('required_amount');
            }
        });
    }

    /**
     * Business Purpose: إضافة مفتاح أجنبي فقط عند غيابه (بدون Doctrine DBAL).
     */
    private function addForeignKeyIfPossible(
        string $table,
        string $column,
        string $referencedTable,
        string $referencedColumn,
        string $onDelete
    ): void {
        if (! Schema::hasTable($referencedTable) || ! Schema::hasColumn($table, $column)) {
            return;
        }

        $constraint = "{$table}_{$column}_foreign";

        $exists = Schema::getConnection()->selectOne(
            'SELECT COUNT(*) AS c FROM information_schema.TABLE_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?
               AND CONSTRAINT_TYPE = \'FOREIGN KEY\'',
            [$table, $constraint]
        );

        if ((int) ($exists->c ?? 0) > 0) {
            return;
        }

        try {
            Schema::table($table, function (Blueprint $blueprint) use ($column, $referencedTable, $referencedColumn, $onDelete): void {
                $foreign = $blueprint->foreign($column)->references($referencedColumn)->on($referencedTable);
                if ($onDelete === 'set null') {
                    $foreign->nullOnDelete();
                } else {
                    $foreign->restrictOnDelete();
                }
            });
        } catch (\Throwable) {
            // قد يفشل الربط على بيانات قديمة؛ العمود وحده يكفي لاستعلامات الرصيد.
        }
    }
};
