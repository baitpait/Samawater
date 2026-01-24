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
        if (!Schema::hasTable('client_statuses')) {
            Schema::create('client_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('status_name');
                $table->decimal('min_percentage', 5, 2)->nullable();
                $table->decimal('max_percentage', 5, 2)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_statuses');
    }
};
