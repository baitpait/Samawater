@props([
    'color' => 'primary',
    'icon' => 'la la-chart-bar',
    'title' => '',
    'value' => 0,
])

<div class="col-md-3">
    <div class="card custom-card shadow-sm border-0">
        <div class="card-body d-flex align-items-center">
            <div class="icon-box bg-{{ $color }} text-white me-3">
                <i class="la {{ $icon }} fs-2"></i>
            </div>
            <div>
                <h6 class="text-muted mb-1">{{ $title }}</h6>
                <h3 class="fw-bold mb-0">{{ $value }}</h3>
            </div>
        </div>
    </div>
</div>