<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Business Purpose: ربط المستخدم بالموزع لتمكين التعيين التلقائي.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (!Schema::hasColumn('users', 'distributor_id')) {
                $table->foreignId('distributor_id')
                    ->nullable()
                    ->after('role_id')
                    ->comment('ربط المستخدم بالموزع عند استخدام دور موزع')
                    ->constrained('distributors')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Business Purpose: التراجع الآمن عن ربط المستخدم بالموزع.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'distributor_id')) {
                $table->dropForeign(['distributor_id']);
                $table->dropColumn('distributor_id');
            }
        });
    }
};
