@props([
    'label' => '',
    'value' => '0',
    'sub'   => '',
    'color' => 'blue',
    'icon'  => '',
])

<div class="stat-card">
    <div class="stat-icon-wrap {{ $color }}">
        {!! $icon !!}
    </div>
    <div class="stat-body">
        <div class="stat-label">{{ $label }}</div>
        <div class="stat-value">{{ $value }}</div>
        @if($sub)
            <div class="stat-sub">{{ $sub }}</div>
        @endif
    </div>
</div>
