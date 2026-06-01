<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: فواتير مشتريات الموردين مع بنود تزيد المخزون عند التأكيد.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('purchase_invoices')) {
            Schema::create('purchase_invoices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
                $table->string('invoice_number')->unique();
                $table->date('invoice_date');
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->enum('status', ['draft', 'confirmed', 'cancelled'])->default('draft');
                $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid');
                $table->decimal('amount_paid', 10, 2)->default(0);
                $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'credit_card', 'other'])->nullable();
                $table->date('payment_date')->nullable();
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
                $table->softDeletes();

                $table->index('vendor_id');
                $table->index('invoice_date');
                $table->index('status');
                $table->index('payment_status');
            });
        }

        if (! Schema::hasTable('purchase_invoice_items')) {
            Schema::create('purchase_invoice_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('purchase_invoice_id')->constrained('purchase_invoices')->cascadeOnDelete();
                $table->string('item_name');
                $table->unsignedInteger('quantity');
                $table->decimal('unit_cost', 10, 2);
                $table->decimal('total_cost', 10, 2);
                $table->timestamps();

                $table->index('purchase_invoice_id');
                $table->index('item_name');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_invoice_items');
        Schema::dropIfExists('purchase_invoices');
    }
};
