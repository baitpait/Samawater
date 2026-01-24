@php
    // جلب جميع العملاء الذين لديهم أمانات غير مسحوبة
    $clientsWithDeposits = \App\Models\Client::whereHas('deposits', function($query) {
        $query->where('is_withdrawn', false);
    })->orderBy('name', 'asc')->get();
    
    $currentClientId = request()->get('client_id');
@endphp

@if($clientsWithDeposits->count() > 0)
<div class="btn-group" style="margin-bottom: 15px;">
    <form method="POST" action="{{ route('client-deposit.withdraw-all') }}" style="display: inline-block;" onsubmit="return confirm('هل تريد سحب جميع الأمانات غير المسحوبة لهذا العميل وإرجاعها للمخزون؟');">
        @csrf
        <select name="client_id" class="form-control" style="display: inline-block; width: auto; margin-right: 10px;" required>
            <option value="">-- اختر العميل --</option>
            @foreach($clientsWithDeposits as $client)
                <option value="{{ $client->id }}" {{ $currentClientId == $client->id ? 'selected' : '' }}>
                    {{ $client->name }} ({{ $client->deposits()->where('is_withdrawn', false)->count() }} أمانة)
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-warning">
            <i class="la la-undo"></i> سحب جميع الأمانات
        </button>
    </form>
</div>
@endif
