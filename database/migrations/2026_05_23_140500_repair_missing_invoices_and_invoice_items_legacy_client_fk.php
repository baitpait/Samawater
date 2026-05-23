<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: استعادة جداول الفواتير عند قواعد Eliyaa المستوردة حيث clients.id ذو نوع INT.
 * هجرة create_invoices الأساسية تستخدم foreignId (bigint unsigned) فيفشل الربط مع InnoDB ضد عمود المرجع int.
 *
 * تنشئ invoices و invoice_items مع أعمدة الدفع المتوقَّعة في الطبقة (تفادي فشل واجهات التقارير قبل تشغيل بقية الهجرات).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('clients')) {
            return;
        }

        if (! Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table): void {
                $table->id();
                $table->integer('client_id');
                $table->string('invoice_number')->unique();
                $table->date('invoice_date');
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->enum('status', ['draft', 'confirmed', 'cancelled'])->default('draft');
                $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid');
                $table->decimal('amount_paid', 10, 2)->default(0);
                $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'credit_card', 'other'])->nullable();
                $table->date('payment_date')->nullable();
                $table->text('notes')->nullable();
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
                $table->index('invoice_number');
                $table->index('status');
                $table->index('invoice_date');
                $table->index('payment_status');
            });
        }

        if (! Schema::hasTable('invoice_items') && Schema::hasTable('invoices')) {
            Schema::create('invoice_items', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
                $table->string('item_name');
                $table->integer('quantity');
                $table->decimal('unit_price', 10, 2);
                $table->decimal('total_price', 10, 2);
                $table->timestamps();

                $table->index('invoice_id');
                $table->index('item_name');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
