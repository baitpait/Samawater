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
        if (!Schema::hasTable('distributors')) {
            Schema::create('distributors', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('cash_withdraws')) {
            Schema::create('cash_withdraws', function (Blueprint $table) {
                $table->id();
                $table->foreignId('distributor_id')->constrained('distributors')->onDelete('cascade');
                $table->decimal('total_amount', 10, 2);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_withdraws');
    }
};
