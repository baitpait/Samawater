<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إنشاء vendor_payments (ومِلء vendors الأساسية إذا نُقِصت).
 * مخططات Eliyaa قد تستخدم عمودًا id من نوع int في vendors/expenses؛ foreignId Laravel يولّد BIGINT UNSIGNED فيفشل المفتاح (3780).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('vendor_payments')) {
            $this->ensureVendorsSkeleton();

            Schema::create('vendor_payments', function (Blueprint $table): void {
                $vendorLegacy = self::referencedColumnIsLegacyInt('vendors');

                if ($vendorLegacy === true) {
                    $table->integer('vendor_id');
                    $table->foreign('vendor_id')
                        ->references('id')
                        ->on('vendors')
                        ->onDelete('cascade');
                } else {
                    $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
                }

                if (Schema::hasTable('expenses')) {
                    $expenseLegacy = self::referencedColumnIsLegacyInt('expenses');

                    if ($expenseLegacy === true) {
                        $table->integer('expense_id')->nullable();
                        $table->foreign('expense_id')
                            ->references('id')
                            ->on('expenses')
                            ->nullOnDelete();
                    } else {
                        $table->foreignId('expense_id')->nullable()->constrained('expenses')->nullOnDelete();
                    }
                } else {
                    $table->unsignedBigInteger('expense_id')->nullable();
                }

                $table->decimal('amount', 10, 2);
                $table->enum('method', ['cash', 'bank_transfer', 'check', 'credit_card', 'other'])->default('cash');
                $table->date('payment_date');
                $table->string('reference_number')->nullable();
                $table->text('notes')->nullable();
                if (Schema::hasTable('users')) {
                    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                } else {
                    $table->unsignedBigInteger('created_by')->nullable();
                }
                $table->timestamps();

                $table->index('vendor_id');
                $table->index('expense_id');
                $table->index('payment_date');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_payments');
    }

    /**
     * Business Purpose: إنشاء جدول vendors بأعمدة التطبيق عند الغياب (قبل FK من vendor_payments).
     */
    private function ensureVendorsSkeleton(): void
    {
        if (Schema::hasTable('vendors')) {
            return;
        }

        Schema::create('vendors', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->decimal('opening_balance', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('name');
            $table->index('is_active');
        });
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

    /**
     * Business Purpose: التمييز بين PK كـ BIGINT (Laravel) و INT (نسخ Elyaa/قديمة) لقرار نوع FK.
     */
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
