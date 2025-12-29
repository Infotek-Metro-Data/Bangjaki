@props([
    'variant' => 'secondary' // success, warning, danger, info, secondary
])

@php
    $classes = match($variant) {
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger' => 'badge-danger',
        'info' => 'badge-info',
        default => 'badge-secondary',
    };
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . $classes]) }}>
    {{ $slot }}
</span>
