<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: استعادة جدول client_payments لقواعد Eliyaa حيث clients.id ذو نوع INT.
 * هجرة الإنشاء الافتراضية foreignId على client_id تفشل مع InnoDB (3780).
 * يدمج عمود for_future_obligation المتوقَّع بعد الهجرة اللاحقة.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('clients')) {
            return;
        }

        if (Schema::hasTable('client_payments')) {
            return;
        }

        Schema::create('client_payments', function (Blueprint $table): void {
            $table->id();
            $table->integer('client_id');
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'credit_card', 'other'])->default('cash');
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('for_future_obligation')->default(false);
            if (Schema::hasTable('users')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            } else {
                $table->unsignedBigInteger('created_by')->nullable();
            }
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

            $table->index('client_id');
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_payments');
    }
};
