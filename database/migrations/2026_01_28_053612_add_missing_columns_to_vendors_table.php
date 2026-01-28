<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            if (!Schema::hasColumn('vendors', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('vendors', 'phone')) {
                $table->string('phone')->nullable()->after('name');
            }
            if (!Schema::hasColumn('vendors', 'email')) {
                $table->string('email')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('vendors', 'address')) {
                $table->text('address')->nullable()->after('email');
            }
            if (!Schema::hasColumn('vendors', 'opening_balance')) {
                $table->decimal('opening_balance', 10, 2)->default(0)->after('address');
            }
            if (!Schema::hasColumn('vendors', 'notes')) {
                $table->text('notes')->nullable()->after('opening_balance');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $columns = ['name', 'phone', 'email', 'address', 'opening_balance', 'notes'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('vendors', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
