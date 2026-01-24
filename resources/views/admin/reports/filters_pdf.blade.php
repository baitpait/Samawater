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

<h2>قائمة المشتركين</h2>

<p><strong>تاريخ التقرير:</strong> {{ date('Y-m-d H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>اسم المشترك</th>
        <th>رقم العقد</th>
        <th>الهاتف</th>
        <th>المدينة</th>
        <th>نوع المشترك</th>
        <th>حالة الاشتراك</th>
        <th>نوع الاشتراك</th>
        <th>تاريخ بدء الاشتراك</th>
        <th>رصيد القوارير</th>
    </tr>
    </thead>
    <tbody>
    @forelse($clients as $client)
        <tr>
            <td>{{ $client->name ?? '-' }}</td>
            <td>{{ $client->contract_no ?? '-' }}</td>
            <td>{{ $client->phone_one ?? '-' }}</td>
            <td>{{ $client->city->city_name ?? '-' }}</td>
            <td>{{ $clientTypes[$client->client_type] ?? '-' }}</td>
            <td>{{ $client->subscriptionStatus->status_name ?? '-' }}</td>
            <td>{{ $client->subscriptionType->type_name ?? '-' }}</td>
            <td>{{ $client->subscription_start_date ?? '-' }}</td>
            <td>{{ $client->bottle_balance ?? 0 }}</td>
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

