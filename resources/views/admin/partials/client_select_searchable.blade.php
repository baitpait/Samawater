@php
    /**
     * Business Purpose: قائمة مشترك قابلة للبحث (Select2) — عرض الاسم فقط في الخيارات.
     *
     * @var string $name
     * @var mixed $selectedId
     * @var bool $allowEmpty
     * @var string $emptyLabel
     * @var bool $required
     * @var string $selectClass
     * @var string|null $selectId
     * @var string $placeholder
     * @var iterable|null $clients
     * @var array<int, string>|null $optionLabels تسميات مخصّصة حسب معرّف المشترك
     */
    $name = $name ?? 'client_id';
    $selectedId = $selectedId ?? request($name);
    $allowEmpty = $allowEmpty ?? true;
    $emptyLabel = $emptyLabel ?? 'الكل';
    $required = $required ?? false;
    $selectClass = trim(($selectClass ?? 'form-select form-control') . ' client-select-searchable');
    $selectId = $selectId ?? ('client-select-' . substr(md5($name . ($emptyLabel ?? '') . ($selectClass ?? '')), 0, 10));
    $placeholder = $placeholder ?? 'ابحث عن اسم المشترك…';
    $optionLabels = $optionLabels ?? [];

    if (! isset($clients)) {
        $clients = \App\Models\Client::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get(['id', 'name']);
    }
@endphp

@include('admin.partials.client_select_search_assets')

<select
    name="{{ $name }}"
    id="{{ $selectId }}"
    class="{{ $selectClass }}"
    @if($required) required @endif
    data-placeholder="{{ $placeholder }}"
>
    @if($allowEmpty)
        <option value="" @selected($selectedId === null || $selectedId === '')>{{ $emptyLabel }}</option>
    @endif
    @foreach($clients as $client)
        @php
            $clientId = is_array($client) ? ($client['id'] ?? null) : $client->id;
            $clientName = is_array($client) ? ($client['name'] ?? '') : $client->name;
            $label = $optionLabels[$clientId] ?? $clientName;
        @endphp
        <option value="{{ $clientId }}" @selected((string) $selectedId === (string) $clientId)>{{ $label }}</option>
    @endforeach
</select>
