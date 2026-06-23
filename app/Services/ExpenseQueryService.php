<?php

namespace App\Services;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Business Purpose: استعلام موحّد لقائمة المصروفات التشغيلية (قائمة، تصدير، تقارير).
 */
class ExpenseQueryService
{
    /**
     * Business Purpose: مصروفات تشغيلية مع فلاتر الصفحة الحالية.
     */
    public function filteredOperationalQuery(Request $request): Builder
    {
        $query = Expense::query()
            ->with(['category', 'beneficiary', 'creator'])
            ->where('is_inventory', false)
            ->orderByDesc('created_at');

        if ($request->filled('expense_category_id')) {
            $query->where('expense_category_id', (int) $request->input('expense_category_id'));
        }

        if ($request->filled('expense_beneficiary_id')) {
            $query->where('expense_beneficiary_id', (int) $request->input('expense_beneficiary_id'));
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', (int) $request->input('vendor_id'));
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', (string) $request->input('payment_status'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->input('date_to'));
        }

        return $query;
    }

    /**
     * Business Purpose: تسمية عرض المصروف = الفئة ( صاحب المصروف ).
     */
    public function formatExpenseLabel(Expense $expense): string
    {
        $category = trim((string) ($expense->category?->name ?? '—'));
        $beneficiary = trim((string) ($expense->beneficiary?->name ?? ''));

        if ($beneficiary === '') {
            return $category;
        }

        return $category.' ( '.$beneficiary.' )';
    }
}
