@props(['score' => 0])

@php
$label = match(true) {
    $score >= 90 => 'A',
    $score >= 80 => 'B',
    $score >= 70 => 'C',
    $score >= 60 => 'D',
    default      => 'F',
};
@endphp

<div class="grade-chip g{{ $label }}" title="{{ $score }}%">{{ $label }}</div>
