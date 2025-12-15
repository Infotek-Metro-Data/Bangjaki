@props([
    'variant' => 'default', // default, hover
    'padding' => true
])

<div {{ $attributes->merge(['class' => 'card' . ($variant === 'hover' ? ' card-hover' : '') . ($padding ? '' : ' !p-0')]) }}>
    {{ $slot }}
</div>
