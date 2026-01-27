<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Business Purpose: إنشاء جدول subscription_types لأنواع الاشتراكات
     */
    public function up(): void
    {
        if (!Schema::hasTable('subscription_types')) {
            Schema::create('subscription_types', function (Blueprint $table) {
                $table->id();
                $table->string('type_name')->nullable();
                $table->string('description')->nullable();
                $table->integer('distribution_days')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_types');
    }
};
