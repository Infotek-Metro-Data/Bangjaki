@props([
    'variant' => 'primary', // primary, secondary, success, danger, ghost
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'href' => null
])

@php
    $variantClasses = match($variant) {
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'success' => 'btn-success',
        'danger' => 'btn-danger',
        'ghost' => 'btn-ghost',
        default => 'btn-primary',
    };

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-6 py-3 text-base',
        default => '',
    };
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn ' . $variantClasses . ' ' . $sizeClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn ' . $variantClasses . ' ' . $sizeClasses]) }}>
        {{ $slot }}
    </button>
@endif
