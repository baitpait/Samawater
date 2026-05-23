<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: استعادة سلسلة المصروفات لواجهة التقارير والـ CRUD عند غياب الجداول (استيراد Eliyaa / هجرات غير متزامنة).
 * المنطقة:
 * - expense_categories → expenses.expense_category_id
 * - vendors (اختياري) → expenses.vendor_id
 * - expenses (مع حقول الوضع القادم بعد الهجرات المتتابعة في المستودع)
 * - expense_monthly_allocations
 *
 * تُكتشَف أعمدة المفتاح الأصل int مقابل BIGINT لربط InnoDB الآمن ضد مخططات Eliyaa القديمة.
 */
return new class extends Migration
{
    public function up(): void
    {
        self::ensureExpenseCategories();
        self::ensureVendors();

        if (! Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table): void {
                $table->id();

                $categoryLegacy = self::referencedColumnIsLegacyInt('expense_categories');
                if ($categoryLegacy === true) {
                    $table->integer('expense_category_id');
                    $table->foreign('expense_category_id')
                        ->references('id')
                        ->on('expense_categories')
                        ->onDelete('restrict');
                } else {
                    $table->foreignId('expense_category_id')
                        ->constrained('expense_categories')
                        ->onDelete('restrict');
                }

                if (Schema::hasTable('vendors')) {
                    $vendorLegacy = self::referencedColumnIsLegacyInt('vendors');

                    if ($vendorLegacy === true) {
                        $table->integer('vendor_id')->nullable();
                        $table->foreign('vendor_id')
                            ->references('id')
                            ->on('vendors')
                            ->nullOnDelete();
                    } else {
                        $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
                    }
                } else {
                    $table->unsignedBigInteger('vendor_id')->nullable();
                }

                $table->boolean('is_inventory')->default(false);
                $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid');

                $table->decimal('total_amount', 10, 2);
                $table->integer('number_of_months')->nullable();
                $table->decimal('monthly_amount', 10, 2)->nullable();
                $table->date('start_month')->nullable();
                $table->date('end_month')->nullable();
                $table->date('payment_date');
                $table->text('notes')->nullable();

                if (Schema::hasTable('users')) {
                    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                } else {
                    $table->unsignedBigInteger('created_by')->nullable();
                }

                $table->timestamps();

                $table->index('vendor_id');
                $table->index('is_inventory');
                $table->index('payment_status');
            });
        }

        if (! Schema::hasTable('expense_monthly_allocations') && Schema::hasTable('expenses')) {
            Schema::create('expense_monthly_allocations', function (Blueprint $table): void {
                $table->id();

                $expenseLegacy = self::referencedColumnIsLegacyInt('expenses');

                if ($expenseLegacy === true) {
                    $table->integer('expense_id');
                    $table->foreign('expense_id')
                        ->references('id')
                        ->on('expenses')
                        ->onDelete('cascade');
                } else {
                    $table->foreignId('expense_id')->constrained('expenses')->onDelete('cascade');
                }

                $table->date('month');
                $table->decimal('amount', 10, 2);
                $table->boolean('is_transferred')->default(false);
                $table->timestamp('transferred_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index(['month', 'is_transferred']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_monthly_allocations');
        Schema::dropIfExists('expenses');
    }

    private static function ensureExpenseCategories(): void
    {
        if (Schema::hasTable('expense_categories')) {
            return;
        }

        Schema::create('expense_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    private static function ensureVendors(): void
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
