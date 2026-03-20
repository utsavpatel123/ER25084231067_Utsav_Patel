@props([
    'value'  => 0,
    'max'    => 100,
    'color'  => 'auto',
    'height' => '6px',
    'label'  => true,
])

@php
$pct = $max > 0 ? min(100, round(($value / $max) * 100)) : 0;
if ($color === 'auto') {
    $barClass = match(true) {
        $pct >= 90 => 'prog-green',
        $pct >= 75 => 'prog-blue',
        $pct >= 60 => 'prog-amber',
        default    => 'prog-red',
    };
} else {
    $barClass = 'prog-' . $color;
}
@endphp

<div style="display:flex;align-items:center;gap:8px">
    <div class="progress" style="flex:1;height:{{ $height }}">
        <div class="progress-bar {{ $barClass }}"
             style="width:{{ $pct }}%"
             role="progressbar"
             aria-valuenow="{{ $value }}"
             aria-valuemin="0"
             aria-valuemax="{{ $max }}">
        </div>
    </div>
    @if($label)
        <span style="font-size:12px;color:var(--muted);min-width:34px;text-align:right">{{ $value }}%</span>
    @endif
</div>
