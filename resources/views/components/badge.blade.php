@props([
    'variant' => 'neutral',
    'style' => 'subtle',
    'size' => 'md',
    'withDot' => false,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full tracking-wide transition-colors duration-150 select-none';

    // Sizes
    $sizes = [
        'sm' => 'px-2 py-0.5 text-[11px] gap-1',
        'md' => 'px-2.5 py-1 text-xs gap-1.5',
    ];

    // Variants and styles grid
    $stylesMap = [
        'subtle' => [
            'primary' => 'bg-primary-light text-primary border border-primary/20',
            'secondary' => 'bg-secondary-light text-secondary border border-secondary/30',
            'success' => 'bg-success-light text-success border border-success/20',
            'warning' => 'bg-warning-light text-warning border border-warning/20',
            'danger' => 'bg-error-light text-error border border-error/20',
            'info' => 'bg-info-light text-info border border-info/20',
            'neutral' => 'bg-neutral-bg text-neutral-muted border border-neutral-border',
        ],
        'solid' => [
            'primary' => 'bg-primary text-white shadow-xs',
            'secondary' => 'bg-secondary text-neutral-text shadow-xs',
            'success' => 'bg-success text-white shadow-xs',
            'warning' => 'bg-warning text-white shadow-xs',
            'danger' => 'bg-error text-white shadow-xs',
            'info' => 'bg-info text-white shadow-xs',
            'neutral' => 'bg-neutral-muted text-white shadow-xs',
        ],
        'outline' => [
            'primary' => 'bg-transparent text-primary border border-primary',
            'secondary' => 'bg-transparent text-secondary border border-secondary',
            'success' => 'bg-transparent text-success border border-success',
            'warning' => 'bg-transparent text-warning border border-warning',
            'danger' => 'bg-transparent text-error border border-error',
            'info' => 'bg-transparent text-info border border-info',
            'neutral' => 'bg-transparent text-neutral-muted border border-neutral-border',
        ],
    ];

    // Dot color map
    $dotColors = [
        'primary' => 'bg-primary',
        'secondary' => 'bg-secondary',
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'danger' => 'bg-error',
        'info' => 'bg-info',
        'neutral' => 'bg-neutral-muted',
    ];

    $selectedStyle = $stylesMap[$style][$variant] ?? $stylesMap['subtle']['neutral'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $dotColorClass = $dotColors[$variant] ?? 'bg-neutral-muted';

    $classes = implode(' ', array_filter([$baseClasses, $sizeClass, $selectedStyle]));
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($withDot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColorClass }} shrink-0"></span>
    @elseif($icon)
        <span class="inline-flex shrink-0 items-center justify-center">{{ $icon }}</span>
    @endif
    <span>{{ $slot }}</span>
</span>
