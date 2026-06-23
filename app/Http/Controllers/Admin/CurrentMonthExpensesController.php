<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseMonthlyAllocation;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Business Purpose: عرض المصروفات الشهرية الحالية
 * - يعرض جميع المصروفات لشهر معين (حتى لو كانت مقسمة على عدة أشهر)
 * - مثال: مصروف ثلاجة 900 شيكل على 9 أشهر → يظهر 100 شيكل في كل شهر من الـ 9 أشهر
 */
class CurrentMonthExpensesController extends Controller
{
    /**
     * عرض المصروفات الشهرية
     * 
     * Business Purpose: عرض جميع المصروفات لشهر معين مع إمكانية اختيار الشهر
     */
    public function index(Request $request)
    {
        // تحديد الشهر والسنة المطلوبة (افتراضياً الشهر الحالي)
        $selectedYear = (int)$request->get('year', Carbon::now()->format('Y'));
        $selectedMonthNum = (int)$request->get('month_num', Carbon::now()->format('m'));
        
        // التأكد من أن الشهر بين 1 و 12
        if ($selectedMonthNum < 1 || $selectedMonthNum > 12) {
            $selectedMonthNum = (int)Carbon::now()->format('m');
        }
        
        // بناء تاريخ الشهر (YYYY-MM-01)
        $selectedMonth = $selectedYear . '-' . str_pad($selectedMonthNum, 2, '0', STR_PAD_LEFT);
        $monthDate = Carbon::parse($selectedMonth . '-01')->format('Y-m-01');
        
        // جلب جميع التوزيعات الشهرية للشهر المحدد
        $allocations = ExpenseMonthlyAllocation::where('month', $monthDate)
            ->with(['expense.category', 'expense.beneficiary', 'expense.creator'])
            ->orderBy('expense_id')
            ->get();
        
        // حساب المجموع
        $totalAmount = $allocations->sum('amount');
        
        return view('admin.expenses.current_month', compact(
            'allocations',
            'totalAmount',
            'selectedMonth',
            'monthDate',
            'selectedYear',
            'selectedMonthNum'
        ));
    }
    
    /**
     * ترحيل مصروف واحد
     * 
     * Business Purpose: ترحيل مصروف من "المصروفات الشهرية الحالية" إلى "قائمة المصروفات الرئيسية"
     */
    public function transfer($id)
    {
        $allocation = ExpenseMonthlyAllocation::findOrFail($id);
        
        if ($allocation->is_transferred) {
            return redirect()->back()->with('error', 'هذا المصروف تم ترحيله مسبقاً.');
        }
        
        $allocation->transfer();
        
        return redirect()->back()->with('success', 'تم ترحيل المصروف بنجاح.');
    }
    
    /**
     * ترحيل جميع مصروفات الشهر
     * 
     * Business Purpose: ترحيل جميع مصروفات الشهر الحالي دفعة واحدة
     */
    public function transferAll(Request $request)
    {
        $selectedYear = (int)$request->get('year', Carbon::now()->format('Y'));
        $selectedMonthNum = (int)$request->get('month_num', Carbon::now()->format('m'));
        
        // التأكد من أن الشهر بين 1 و 12
        if ($selectedMonthNum < 1 || $selectedMonthNum > 12) {
            $selectedMonthNum = (int)Carbon::now()->format('m');
        }
        
        $selectedMonth = $selectedYear . '-' . str_pad($selectedMonthNum, 2, '0', STR_PAD_LEFT);
        $monthDate = Carbon::parse($selectedMonth . '-01')->format('Y-m-01');
        
        $count = ExpenseMonthlyAllocation::where('month', $monthDate)
            ->where('is_transferred', false)
            ->update([
                'is_transferred' => true,
                'transferred_at' => now(),
            ]);
        
        return redirect()->back()->with('success', "تم ترحيل {$count} مصروف بنجاح.");
    }
}
