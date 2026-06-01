<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<style>
    body { font-family: dejavusans; direction: rtl; text-align: right; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    th, td { border: 1px solid #ddd; padding: 5px; text-align: center; }
    th { background: #f3f4f6; }
    .meta p { margin: 4px 0; }
</style>
</head>
<body>

@php
    $amountDue = (float) ($accountSnapshot['amount_due'] ?? ($client->combined_subscriber_debt ?? 0));
@endphp

<h2 style="text-align:center">تقرير تسليمات المشترك</h2>

<div class="meta">
    <p><strong>اسم المشترك:</strong> {{ $client->name }}</p>
    @if(!empty($client->contract_no))
    <p><strong>رقم العقد:</strong> {{ $client->contract_no }}</p>
    @endif
    <p><strong>الهاتف:</strong> {{ $client->phone_one ?? '-' }}@if(!empty($client->phone_two)) / {{ $client->phone_two }}@endif</p>
    <p><strong>المدينة:</strong> {{ $client->city->city_name ?? '-' }}</p>
    <p><strong>العنوان:</strong> {{ $client->address ?? '-' }}</p>
    @if(!empty(trim((string) ($client->notes ?? ''))))
    <p><strong>ملاحظات:</strong> {{ $client->notes }}</p>
    @endif
    <p><strong>المبلغ المستحق (إجمالي):</strong> ₪ {{ number_format($amountDue, 2) }}</p>
    <p><strong>رصيد القوارير (كل التسليمات):</strong> {{ (int) ($bottleSnapshot['bottle_balance'] ?? 0) }}
        ({{ (int) ($bottleSnapshot['total_bottle_received'] ?? 0) }} − {{ (int) ($bottleSnapshot['total_bottle_empty'] ?? 0) }})</p>
</div>

<table>
    <thead>
    <tr>
        <th>التاريخ</th>
        <th>الموزع</th>
        <th>ممتلئة</th>
        <th>فارغة</th>
        <th>فرق اليوم</th>
        <th>مطلوب</th>
        <th>مدفوع</th>
        <th>دين</th>
    </tr>
    </thead>
    <tbody>
    @forelse($client->deliveries as $row)
        @php
            $required = (float) ($row->required_amount ?? 0);
            $paid = (float) ($row->paymant ?? 0);
            $remaining = round($required - $paid, 2);
            $dayDelta = (int) $row->bottle_received - (int) $row->bottle_empty;
        @endphp
        <tr>
            <td>{{ $row->delivery_date ? \Carbon\Carbon::parse($row->delivery_date)->format('Y-m-d') : '-' }}</td>
            <td>{{ $row->distributor->name ?? '-' }}</td>
            <td>{{ $row->bottle_received }}</td>
            <td>{{ $row->bottle_empty }}</td>
            <td>{{ $dayDelta }}</td>
            <td>{{ number_format($required, 2) }}</td>
            <td>{{ number_format($paid, 2) }}</td>
            <td>{{ number_format($remaining, 2) }}</td>
        </tr>
    @empty
        <tr><td colspan="8">لا توجد تسليمات</td></tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
