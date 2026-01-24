<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: dejavusans;
        direction: rtl;
        text-align: right;
        font-size: 12px;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background: #f3f4f6;
        font-weight: bold;
        color: #1f2937;
    }

    tr:nth-child(even) {
        background: #f9fafb;
    }
</style>
</head>
<body>

<h2>التقارير المتقدمة</h2>

<p><strong>الفترة:</strong> {{ $startDate->format('Y-m-d') }} إلى {{ $endDate->format('Y-m-d') }}</p>
<p><strong>تاريخ التقرير:</strong> {{ date('Y-m-d H:i') }}</p>

<h3>الإحصائيات العامة</h3>
<table>
    <tr>
        <th>المؤشر</th>
        <th>القيمة</th>
    </tr>
    <tr>
        <td>إجمالي المشتركين</td>
        <td>{{ number_format($generalStats['total_clients']) }}</td>
    </tr>
    <tr>
        <td>المشتركين النشطين</td>
        <td>{{ number_format($generalStats['active_clients']) }}</td>
    </tr>
    <tr>
        <td>إجمالي التسليمات</td>
        <td>{{ number_format($generalStats['total_deliveries']) }}</td>
    </tr>
    <tr>
        <td>التسليمات في الفترة</td>
        <td>{{ number_format($generalStats['deliveries_in_period']) }}</td>
    </tr>
</table>

<h3>أداء الموزعين</h3>
<table>
    <thead>
    <tr>
        <th>اسم الموزع</th>
        <th>عدد التسليمات</th>
        <th>إجمالي الدفعات</th>
    </tr>
    </thead>
    <tbody>
    @forelse($distributorPerformance as $distributor)
        <tr>
            <td>{{ $distributor->name }}</td>
            <td>{{ number_format($distributor->deliveries_count) }}</td>
            <td>{{ number_format($distributor->total_payment ?? 0) }} ₪</td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center">لا توجد بيانات في هذه الفترة</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>

