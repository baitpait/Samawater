<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceDestroyDeletesAutoPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_auto_payment_query_deletes_only_linked_payment(): void
    {
        $client = Client::create(['name' => 'Invoice Delete Client']);

        $invoice = Invoice::create([
            'client_id' => $client->id,
            'invoice_number' => 'INV-2026-099',
            'invoice_date' => '2026-06-23',
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'amount_paid' => '100.00',
            'total_amount' => '100.00',
            'payment_method' => 'cash',
            'payment_date' => '2026-06-23',
        ]);

        $autoPayment = ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '100.00',
            'payment_date' => '2026-06-23',
            'payment_method' => 'cash',
            'notes' => 'دفعة تلقائية من الفاتورة: INV-2026-099',
        ]);

        $manualPayment = ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '25.00',
            'payment_date' => '2026-06-23',
            'payment_method' => 'cash',
            'notes' => 'دفعة يدوية مستقلة',
        ]);

        ClientPayment::query()
            ->where('client_id', $invoice->client_id)
            ->where('notes', 'like', $invoice->autoPaymentNotesLikePattern())
            ->delete();

        $invoice->delete();

        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
        $this->assertDatabaseMissing('client_payments', ['id' => $autoPayment->id]);
        $this->assertDatabaseHas('client_payments', ['id' => $manualPayment->id]);
    }
}
