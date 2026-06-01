@php
    $clientsWithDeposits = \App\Models\Client::whereHas('deposits', function ($query) {
        $query->where('is_withdrawn', false);
    })
        ->withCount(['deposits as open_deposits_count' => function ($query) {
            $query->where('is_withdrawn', false);
        }])
        ->orderBy('name', 'asc')
        ->get();

    $currentClientId = request()->get('client_id');
    $depositOptionLabels = [];
    foreach ($clientsWithDeposits as $client) {
        $depositOptionLabels[$client->id] = $client->name . ' (' . (int) $client->open_deposits_count . ' أمانة)';
    }
@endphp

@if($clientsWithDeposits->count() > 0)
<div class="btn-group" style="margin-bottom: 15px;">
    <form method="POST" action="{{ route('client-deposit.withdraw-all') }}" style="display: inline-block;" onsubmit="return confirm('هل تريد سحب جميع الأمانات غير المسحوبة لهذا المشترك وإرجاعها للمخزون؟');">
        @csrf
        <div style="display: inline-block; width: auto; min-width: 220px; margin-right: 10px; vertical-align: middle;">
            @include('admin.partials.client_select_searchable', [
                'clients' => $clientsWithDeposits,
                'optionLabels' => $depositOptionLabels,
                'selectedId' => $currentClientId,
                'allowEmpty' => true,
                'emptyLabel' => '-- اختر المشترك --',
                'required' => true,
                'selectClass' => 'form-control',
                'selectId' => 'withdraw-all-client-select-list',
                'placeholder' => 'ابحث عن اسم المشترك…',
            ])
        </div>
        <button type="submit" class="btn btn-warning">
            <i class="la la-undo"></i> سحب جميع الأمانات
        </button>
    </form>
</div>
@endif
