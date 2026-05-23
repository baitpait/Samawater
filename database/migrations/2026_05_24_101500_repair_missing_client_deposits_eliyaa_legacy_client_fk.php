<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: استرداد سلسلة أمانات المشتركين (client_deposits + client_deposit_items) لواجهة Backpack بعد استيراد Eliyaa بدون هذه الجداول.
 * عمود clients.id القديم ذو نوع int يوجب استخدام FK من نوع INT بدلاً من foreignId الذي يخرج BIGINT UNSIGNED.
 * الشكل النهائي بدون عمودَي item_name و quantity على client_deposits لأنهما منتقلَان إلى client_deposit_items.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('clients')) {
            return;
        }

        $clientPkLegacy = self::referencedColumnIsLegacyInt('clients');

        if (! Schema::hasTable('client_deposits')) {
            Schema::create('client_deposits', function (Blueprint $table) use ($clientPkLegacy): void {
                $table->id();

                if ($clientPkLegacy === true) {
                    $table->integer('client_id');
                    $table->foreign('client_id')
                        ->references('id')
                        ->on('clients')
                        ->onDelete('cascade');
                } else {
                    $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
                }

                $table->date('date_given');
                $table->text('notes')->nullable();
                $table->boolean('is_withdrawn')->default(false);
                $table->timestamp('withdrawn_at')->nullable();

                if (Schema::hasTable('users')) {
                    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                } else {
                    $table->unsignedBigInteger('created_by')->nullable();
                }

                $table->timestamps();

                $table->index('client_id');
                $table->index('is_withdrawn');
                $table->index('date_given');
            });
        }

        if (! Schema::hasTable('client_deposit_items') && Schema::hasTable('client_deposits')) {
            Schema::create('client_deposit_items', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('client_deposit_id')->constrained('client_deposits')->onDelete('cascade');
                $table->string('item_name');
                $table->integer('quantity');
                $table->timestamps();

                $table->index('client_deposit_id');
                $table->index('item_name');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('client_deposit_items');
        Schema::dropIfExists('client_deposits');
    }

    private static function referencedColumnIsLegacyInt(string $table): bool
    {
        if (! Schema::hasTable($table)) {
            return false;
        }

        /** @var object|null $row */
        $row = DB::selectOne('SHOW COLUMNS FROM `' . str_replace('`', '', $table) . '` WHERE Field = ?', ['id']);

        if ($row === null) {
            return false;
        }

        $attrs = array_change_key_case((array) $row, CASE_LOWER);
        $type = $attrs['type'] ?? '';

        if (! is_string($type) || $type === '') {
            return false;
        }

        return self::mysqlTypeLooksLikeLegacyIntForeignKeyTarget($type);
    }

    private static function mysqlTypeLooksLikeLegacyIntForeignKeyTarget(string $type): bool
    {
        $t = strtolower($type);

        if (str_contains($t, 'bigint')) {
            return false;
        }

        return str_contains($t, 'int')
            || str_contains($t, 'mediumint')
            || str_contains($t, 'smallint');
    }
};
