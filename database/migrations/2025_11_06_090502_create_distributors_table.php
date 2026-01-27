<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Business Purpose: إنشاء جدول distributors الأساسي للموزعين
     */
    public function up(): void
    {
        if (!Schema::hasTable('distributors')) {
            Schema::create('distributors', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('phone')->nullable();
                $table->string('username')->nullable();
                $table->string('password_hash')->nullable();
                $table->string('status')->nullable();
                $table->text('notes')->nullable();
                $table->decimal('latitude', 10, 7)->nullable();
                $table->decimal('longitude', 10, 7)->nullable();
                $table->timestamp('last_update')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('distributors', function (Blueprint $table) {
                if (!Schema::hasColumn('distributors', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('distributors', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (!Schema::hasColumn('distributors', 'username')) {
                    $table->string('username')->nullable();
                }
                if (!Schema::hasColumn('distributors', 'password_hash')) {
                    $table->string('password_hash')->nullable();
                }
                if (!Schema::hasColumn('distributors', 'status')) {
                    $table->string('status')->nullable();
                }
                if (!Schema::hasColumn('distributors', 'notes')) {
                    $table->text('notes')->nullable();
                }
                if (!Schema::hasColumn('distributors', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable();
                }
                if (!Schema::hasColumn('distributors', 'longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable();
                }
                if (!Schema::hasColumn('distributors', 'last_update')) {
                    $table->timestamp('last_update')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributors');
    }
};
