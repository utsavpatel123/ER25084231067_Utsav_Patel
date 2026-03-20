@props([
    'initials' => '?',
    'id'       => 0,
    'size'     => 'md',
])

@php
$sizes = [
    'sm' => 'width:26px;height:26px;font-size:11px',
    'md' => 'width:34px;height:34px;font-size:13px',
    'lg' => 'width:56px;height:56px;font-size:20px;border-radius:12px',
];
$style = $sizes[$size] ?? $sizes['md'];
@endphp

<div class="avatar av-{{ $id % 10 }}" style="{{ $style }}">
    {{ strtoupper($initials) }}
</div>
