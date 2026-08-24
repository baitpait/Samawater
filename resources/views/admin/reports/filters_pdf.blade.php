<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: dejavusans;
        direction: rtl;
        text-align: right;
        font-size: 9px;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 12px;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 5px;
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
        <th>المشترك</th>
        <th>الهاتف</th>
        <th>المدينة</th>
        <th>العنوان</th>
        <th>طريقة التعامل</th>
        <th>دين المشترك</th>
        <th>رصيد القوارير</th>
        <th>آخر استلام</th>
        <th>الأيام</th>
        <th>نوع الاشتراك</th>
        <th>حسب الطلب</th>
        <th>ملاحظات العميل</th>
    </tr>
    </thead>
    <tbody>
    @forelse($clients as $client)
        @php
            $bottleSnapshot = $bottleSnapshotsByClientId[(int) $client->id] ?? [
                'bottle_balance' => 0,
            ];
            $lastDeliveryDate = $client->lastDelivery
                ? \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->format('Y-m-d')
                : '-';
            if (! $client->lastDelivery) {
                $daysLabel = 'لم يستلم';
            } else {
                $days = (int) \Carbon\Carbon::parse($client->lastDelivery->delivery_date)
                    ->startOfDay()
                    ->diffInDays(now()->startOfDay());
                $daysLabel = $days === 0 ? 'اليوم' : ($days === 1 ? 'أمس' : "منذ {$days} يوم");
            }
        @endphp
        <tr>
            <td>{{ $client->name ?? '-' }}</td>
            <td>{{ $client->phone_one ?? '-' }}</td>
            <td>{{ $client->city->city_name ?? '-' }}</td>
            <td>{{ $client->address ?? '-' }}</td>
            <td>{{ $client->interaction_method ?? '-' }}</td>
            <td>{{ number_format((float) ($client->combined_subscriber_debt ?? 0), 2) }} ₪</td>
            <td>{{ (int) ($bottleSnapshot['bottle_balance'] ?? 0) }}</td>
            <td>{{ $lastDeliveryDate }}</td>
            <td>{{ $daysLabel }}</td>
            <td>{{ $client->subscriptionType->type_name ?? '-' }}</td>
            <td>{{ $client->delivery_on_demand ? 'نعم' : 'لا' }}</td>
            <td>{{ \Illuminate\Support\Str::limit((string) ($client->notes ?? '-'), 40) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="12" class="text-center">لا توجد بيانات</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
