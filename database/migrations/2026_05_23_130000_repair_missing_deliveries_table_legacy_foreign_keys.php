<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إصلاح الأنظمة المستوردة من Eliyaa حيث `clients.id` و`distributors.id` نوعًا `int`.
 * Laravel `foreignId()` يستخدم `bigint unsigned` فينعذر InnoDB خطأ (3780) عند وجود مخالفة.
 * بعض النسخ الاحتياطية تفتقد الجدول رغم تسجل هجرة `create_deliveries` كـ "تم التنفيذ".
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('deliveries')) {
            return;
        }

        if (! Schema::hasTable('clients') || ! Schema::hasTable('distributors')) {
            return;
        }

        Schema::create('deliveries', static function (Blueprint $table): void {
            $table->id();
            $table->integer('client_id');
            $table->date('delivery_date');
            $table->integer('bottle_received')->default(0);
            $table->integer('bottle_empty')->default(0);
            $table->decimal('paymant', 10, 2)->default(0);
            $table->integer('distributor_id')->nullable();
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');
            $table->foreign('distributor_id')
                ->references('id')
                ->on('distributors')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
