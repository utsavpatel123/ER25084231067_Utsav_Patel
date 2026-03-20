@props(['color' => 'blue'])

<span {{ $attributes->merge(['class' => 'badge badge-' . $color]) }}>
    {{ $slot }}
</span>
