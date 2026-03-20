@props(['type' => 'success', 'dismissible' => true])

@php
$classes = [
    'success' => 'alert-success',
    'error'   => 'alert-error',
    'warning' => 'alert-warning',
    'info'    => 'alert-info',
];
$class = $classes[$type] ?? 'alert-info';
@endphp

<div class="alert {{ $class }}" role="alert">
    <span class="alert-text">{{ $slot }}</span>
    @if($dismissible)
        <button class="alert-close" onclick="this.closest('[role=alert]').remove()">✕</button>
    @endif
</div>
