@php
    /**
     * Business Purpose: غلاف Backpack لحقل اختيار مشترك مع بحث Select2.
     */
    $fieldName = $name ?? 'client_id';
    $isRequired = (bool) ($required ?? false);
@endphp

<div class="form-group col-sm-12 mb-3{{ $isRequired ? ' required' : '' }}">
    <label class="form-label control-label" for="{{ $selectId ?? ('crud-'.$fieldName) }}">{{ $label }}</label>
    @include('admin.partials.client_select_searchable', [
        'name' => $fieldName,
        'selectedId' => $selectedId ?? null,
        'allowEmpty' => $allowEmpty ?? true,
        'emptyLabel' => $emptyLabel ?? 'الكل',
        'required' => $isRequired,
        'selectId' => $selectId ?? ('crud-'.$fieldName),
        'placeholder' => $placeholder ?? 'ابحث عن اسم المشترك…',
        'clients' => $clients ?? collect(),
        'optionLabels' => $optionLabels ?? [],
    ])
    @if(!empty($hint))
        <p class="help-block text-muted small mb-0 mt-1">{{ $hint }}</p>
    @endif
</div>
