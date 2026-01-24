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

<h2>تقرير المشتركين المستحقين للتسليم</h2>

<p><strong>تاريخ التقرير:</strong> {{ date('Y-m-d H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>اسم المشترك</th>
        <th>الهاتف</th>
        <th>المدينة</th>
        <th>أيام بدون تسليم</th>
        <th>نوع الاشتراك</th>
        <th>حالة الالتزام</th>
        <th>عدد التسليمات</th>
        <th>القوارير المستلمة</th>
        <th>القوارير الفارغة</th>
    </tr>
    </thead>
    <tbody>
    @forelse($clients as $client)
        <tr>
            <td>{{ $client->client_name ?? '-' }}</td>
            <td>{{ $client->phone_one ?? '-' }}</td>
            <td>{{ $client->city_name ?? '-' }}</td>
            <td>{{ $client->days_since_last_delivery ?? 0 }}</td>
            <td>{{ $client->subscription_type_name ?? '-' }}</td>
            <td>{{ $client->client_status_name ?? '-' }}</td>
            <td>{{ $client->total_deliveries ?? 0 }}</td>
            <td>{{ $client->total_bottle_received ?? 0 }}</td>
            <td>{{ $client->total_bottle_empty ?? 0 }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">لا توجد بيانات</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>

