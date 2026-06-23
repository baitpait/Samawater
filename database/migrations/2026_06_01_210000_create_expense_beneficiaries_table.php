<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: جدول أصحاب المصروف (موظف، كازية، جهة أخرى) مرتبط بالمصروفات التشغيلية.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('expense_beneficiaries')) {
            Schema::create('expense_beneficiaries', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('beneficiary_type', 32)->default('other');
                $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
                $table->boolean('is_active')->default(true);
                $table->text('notes')->nullable();
                $table->softDeletes();
                $table->timestamps();

                $table->index('name');
                $table->index('is_active');
                $table->index('vendor_id');
            });
        }

        if (Schema::hasTable('expenses') && ! Schema::hasColumn('expenses', 'expense_beneficiary_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->foreignId('expense_beneficiary_id')
                    ->nullable()
                    ->after('expense_category_id')
                    ->constrained('expense_beneficiaries')
                    ->nullOnDelete();
                $table->index('expense_beneficiary_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('expenses') && Schema::hasColumn('expenses', 'expense_beneficiary_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropForeign(['expense_beneficiary_id']);
                $table->dropColumn('expense_beneficiary_id');
            });
        }

        Schema::dropIfExists('expense_beneficiaries');
    }
};
