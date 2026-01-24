<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: dejavusans;
        direction: rtl;
        text-align: right;
        font-size: 11px;
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

<h2>تقرير التسليمات</h2>

<p><strong>تاريخ التقرير:</strong> {{ date('Y-m-d H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>اسم المشترك</th>
        <th>الهاتف</th>
        <th>المدينة</th>
        <th>تاريخ التسليم</th>
        <th>العبوات المستلمة</th>
        <th>العبوات الفارغة</th>
        <th>الدفعة</th>
        <th>الموزع</th>
        <th>حالة الاشتراك</th>
        <th>نوع الاشتراك</th>
    </tr>
    </thead>
    <tbody>
    @forelse($rows as $row)
        <tr>
            <td>{{ $row->client_name ?? '-' }}</td>
            <td>{{ $row->phone_one ?? '-' }}</td>
            <td>{{ $row->city_name ?? '-' }}</td>
            <td>{{ $row->last_delivery_date_actual ?? '-' }}</td>
            <td>{{ $row->total_bottle_received ?? 0 }}</td>
            <td>{{ $row->total_bottle_empty ?? 0 }}</td>
            <td>{{ number_format($row->last_paymant ?? 0) }} ₪</td>
            <td>{{ $row->distributor_name ?? '-' }}</td>
            <td>{{ $row->subscription_status_name ?? '-' }}</td>
            <td>{{ $row->subscription_type_name ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="10" class="text-center">لا توجد بيانات</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>

