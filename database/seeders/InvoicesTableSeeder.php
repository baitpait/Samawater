<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Client;
use App\Models\InventoryItem;
use Carbon\Carbon;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // تأكد من وجود عملاء وعناصر مخزون
        $client = Client::whereNull('parent_id')->first();
        if (!$client) {
            $this->command->info('No parent client found. Please seed clients first.');
            return;
        }

        $inventoryItem = InventoryItem::first();
        if (!$inventoryItem) {
             // Create a dummy inventory item if none exists
             $inventoryItem = InventoryItem::create([
                 'item_name' => 'قارورة مياه 19 لتر',
                 'quantity' => 100,
                 'unit_price' => 10.00
             ]);
        }

        // إنشاء 5 فواتير
        for ($i = 1; $i <= 5; $i++) {
            $invoice = Invoice::create([
                'client_id' => $client->id,
                'invoice_number' => 'INV-' . date('Y') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'invoice_date' => Carbon::now()->subDays($i),
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'amount_paid' => 50.00, // 5 * 10
                'payment_method' => 'cash',
                'payment_date' => Carbon::now(),
                'total_amount' => 50.00,
                'created_by' => 1, // Assuming admin user id 1
                'notes' => 'فاتورة تجريبية ' . $i
            ]);

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $inventoryItem->item_name,
                'quantity' => 5,
                'unit_price' => 10.00,
                'total_price' => 50.00
            ]);
        }
    }
}
