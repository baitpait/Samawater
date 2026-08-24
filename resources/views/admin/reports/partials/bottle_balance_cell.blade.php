@php
    $snapshot = $snapshot ?? [
        'total_bottle_received' => 0,
        'total_bottle_empty' => 0,
        'bottle_balance' => 0,
    ];
    $received = (int) ($snapshot['total_bottle_received'] ?? 0);
    $empty = (int) ($snapshot['total_bottle_empty'] ?? 0);
    $balance = (int) ($snapshot['bottle_balance'] ?? 0);
    $showFormula = (bool) ($showFormula ?? true);
@endphp

<div class="bottle-balance-cell text-center">
    <div class="bottle-balance-value">{{ $balance }}</div>
    @if($showFormula)
        <div class="bottle-balance-formula">
            {{ $received }}
            <span class="opacity-75">−</span>
            {{ $empty }}
            <span class="opacity-75">=</span>
            {{ $balance }}
        </div>
        <div class="bottle-balance-hint">ممتلئة − فارغة (كل التسليمات)</div>
    @endif
</div>
