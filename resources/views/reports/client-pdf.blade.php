<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: dejavusans;
        direction: rtl;
        text-align: right;
        font-size: 13px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 6px;
        text-align: center;
    }

    th {
        background: #f3f4f6;
    }
</style>
</head>
<body>

<h2 style="text-align:center">تقرير المشترك</h2>

<p><strong>اسم المشترك:</strong> {{ $client->name }}</p>
<p><strong>الهاتف:</strong> {{ $client->phone_one }}</p>
<p><strong>المدينة:</strong> {{ $client->city->city_name ?? '-' }}</p>
<p><strong>العنوان:</strong> {{ $client->address ?? '-' }}</p>
<p><strong>الرصيد المالي:</strong> ₪ {{ number_format($client->balance ?? 0, 0) }}</p>

<table>
    <thead>
    <tr>
        <th>التاريخ</th>
        <th>الموزع</th>
        <th>قوارير ممتلئة</th>
        <th>قوارير فارغة</th>
        <th>الفرق</th>
    </tr>
    </thead>
    <tbody>
    @foreach($client->deliveries as $row)
        <tr>
            <td>{{ $row->delivery_date }}</td>
            <td>{{ $row->distributor->name ?? '-' }}</td>
            <td>{{ $row->bottle_received }}</td>
            <td>{{ $row->bottle_empty }}</td>
            <td>{{ $row->bottle_received - $row->bottle_empty }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>