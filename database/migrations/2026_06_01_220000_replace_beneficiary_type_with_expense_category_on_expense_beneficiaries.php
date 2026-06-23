<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: استبدال نوع صاحب المصروف الثابت بفئة مصروف من expense_categories.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('expense_beneficiaries')) {
            return;
        }

        Schema::table('expense_beneficiaries', function (Blueprint $table) {
            if (! Schema::hasColumn('expense_beneficiaries', 'expense_category_id')) {
                $table->foreignId('expense_category_id')
                    ->nullable()
                    ->after('name')
                    ->constrained('expense_categories')
                    ->restrictOnDelete();
                $table->index('expense_category_id');
            }
        });

        if (Schema::hasColumn('expense_beneficiaries', 'beneficiary_type')) {
            Schema::table('expense_beneficiaries', function (Blueprint $table) {
                $table->dropColumn('beneficiary_type');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('expense_beneficiaries')) {
            return;
        }

        if (! Schema::hasColumn('expense_beneficiaries', 'beneficiary_type')) {
            Schema::table('expense_beneficiaries', function (Blueprint $table) {
                $table->string('beneficiary_type', 32)->default('other')->after('name');
            });
        }

        if (Schema::hasColumn('expense_beneficiaries', 'expense_category_id')) {
            Schema::table('expense_beneficiaries', function (Blueprint $table) {
                $table->dropForeign(['expense_category_id']);
                $table->dropColumn('expense_category_id');
            });
        }
    }
};
