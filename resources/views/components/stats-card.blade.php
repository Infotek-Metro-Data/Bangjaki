@props([
    'icon' => null,
    'iconBg' => 'bg-primary-100',
    'iconColor' => 'text-primary-600',
    'value' => '0',
    'label' => 'Label',
    'trend' => null,
    'trendUp' => true
])

<div class="stats-card">
    @if($icon)
        <div class="stats-card-icon {{ $iconBg }}">
            <span class="{{ $iconColor }}">{{ $icon }}</span>
        </div>
    @endif
    <p class="text-sm text-secondary-500 mb-1">{{ $label }}</p>
    <p class="stats-card-value">{{ $value }}</p>
    @if($trend)
        <div class="stats-card-trend {{ $trendUp ? 'text-green-600' : 'text-red-600' }}">
            @if($trendUp)
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            @else
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            @endif
            <span>{{ $trend }}</span>
        </div>
    @endif
</div>
