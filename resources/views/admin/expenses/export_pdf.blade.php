<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<style>
    body { font-family: dejavusans; direction: rtl; text-align: right; font-size: 11px; }
    h2 { text-align: center; color: #1e3a5f; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    th, td { border: 1px solid #ddd; padding: 6px; text-align: center; }
    th { background: #f3f4f6; font-weight: bold; }
    tr:nth-child(even) { background: #f9fafb; }
</style>
</head>
<body>
    <h2>المصروفات التشغيلية</h2>
    <p style="text-align: center; color: #64748b;">تاريخ التصدير: {{ now()->format('Y-m-d H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>المصروف</th>
                <th>صاحب المصروف</th>
                <th>المبلغ</th>
                <th>حالة الدفع</th>
                <th>تاريخ الدفع</th>
                <th>الأشهر</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                @php
                    $statusLabels = ['paid' => 'مدفوع', 'partial' => 'جزئي', 'unpaid' => 'غير مدفوع'];
                @endphp
                <tr>
                    <td>{{ $expenseQuery->formatExpenseLabel($expense) }}</td>
                    <td>{{ $expense->beneficiary?->name ?? '—' }}</td>
                    <td>{{ number_format((float) $expense->total_amount, 2) }} ₪</td>
                    <td>{{ $statusLabels[$expense->payment_status] ?? $expense->payment_status }}</td>
                    <td>{{ $expense->payment_date?->format('Y-m-d') ?? '—' }}</td>
                    <td>{{ (int) $expense->number_of_months }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">لا توجد مصروفات مطابقة للفلاتر</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
