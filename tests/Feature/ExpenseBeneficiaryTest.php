<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\ExpenseBeneficiary;
use App\Models\ExpenseCategory;
use App\Models\Vendor;
use App\Services\ExpenseBeneficiaryVendorLinkService;
use App\Services\ExpenseQueryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseBeneficiaryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Business Purpose: ربط صاحب المصروف تلقائياً بمورد بنفس الاسم.
     */
    public function test_beneficiary_auto_links_vendor_with_matching_name(): void
    {
        $category = ExpenseCategory::create([
            'name' => 'سولار',
            'is_active' => true,
        ]);
        $vendor = Vendor::create([
            'name' => 'كازية الجنوب',
            'is_active' => true,
        ]);

        $beneficiary = ExpenseBeneficiary::create([
            'name' => 'كازية الجنوب',
            'expense_category_id' => $category->id,
            'is_active' => true,
        ]);

        app(ExpenseBeneficiaryVendorLinkService::class)->syncVendorLink($beneficiary->fresh());

        $this->assertSame((int) $vendor->id, (int) $beneficiary->fresh()->vendor_id);
    }

    /**
     * Business Purpose: تسمية المصروف = الفئة ( صاحب المصروف ).
     */
    public function test_expense_display_label_includes_beneficiary(): void
    {
        $category = ExpenseCategory::create([
            'name' => 'راتب',
            'is_active' => true,
        ]);
        $beneficiary = ExpenseBeneficiary::create([
            'name' => 'علي',
            'expense_category_id' => $category->id,
            'is_active' => true,
        ]);

        $expense = Expense::create([
            'expense_category_id' => $category->id,
            'expense_beneficiary_id' => $beneficiary->id,
            'vendor_id' => null,
            'is_inventory' => false,
            'payment_status' => 'paid',
            'total_amount' => 3000,
            'number_of_months' => 1,
            'monthly_amount' => 3000,
            'start_month' => '2026-06-01',
            'end_month' => '2026-06-01',
            'payment_date' => '2026-06-01',
        ]);

        $label = app(ExpenseQueryService::class)->formatExpenseLabel($expense->load(['category', 'beneficiary']));

        $this->assertSame('راتب ( علي )', $label);
    }

    /**
     * Business Purpose: الحركة المالية الشاملة تعرض صاحب المصروف في عمود التفاصيل.
     */
    public function test_unified_ledger_expense_detail_includes_beneficiary_name(): void
    {
        $category = ExpenseCategory::create([
            'name' => 'رواتب',
            'is_active' => true,
        ]);
        $beneficiary = ExpenseBeneficiary::create([
            'name' => 'علي',
            'expense_category_id' => $category->id,
            'is_active' => true,
        ]);

        Expense::create([
            'expense_category_id' => $category->id,
            'expense_beneficiary_id' => $beneficiary->id,
            'vendor_id' => null,
            'is_inventory' => false,
            'payment_status' => 'paid',
            'total_amount' => 2500,
            'number_of_months' => 1,
            'monthly_amount' => 2500,
            'start_month' => '2026-06-01',
            'end_month' => '2026-06-01',
            'payment_date' => '2026-06-10',
        ]);

        $ledger = app(\App\Services\UnifiedFinancialLedgerService::class)->buildLedger(
            \Carbon\Carbon::parse('2026-06-01'),
            \Carbon\Carbon::parse('2026-06-30'),
        );

        $expenseRows = array_values(array_filter(
            $ledger['rows'],
            static fn (array $row): bool => ($row['gate_ar'] ?? '') === 'المصروفات'
        ));

        $this->assertCount(1, $expenseRows);
        $this->assertSame('رواتب · علي', $expenseRows[0]['detail']);
    }
}
