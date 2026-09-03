@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'isLoading' => false,
    'disabled' => false,
    'fullWidth' => false,
    'icon' => null,
    'leftIcon' => null,
    'rightIcon' => null,
])

@php
    // Base classes
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-xl transition-all duration-200 ease-in-out focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 select-none cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none';

    // Sizes
    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs gap-1.5 min-h-[32px]',
        'md' => 'px-4 py-2.5 text-sm gap-2 min-h-[42px]',
        'lg' => 'px-6 py-3.5 text-base gap-2.5 min-h-[50px]',
    ];

    // Variants (UI/UX Pro Max aesthetic definitions)
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-hover shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 focus-visible:ring-primary/40 active:scale-[0.98]',
        'secondary' => 'bg-secondary text-neutral-text font-semibold hover:bg-secondary-hover shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 focus-visible:ring-secondary/40 active:scale-[0.98]',
        'outline' => 'bg-transparent border border-neutral-border text-neutral-text hover:bg-neutral-bg hover:border-neutral-muted focus-visible:ring-primary/30 active:scale-[0.98]',
        'ghost' => 'bg-transparent text-neutral-text hover:bg-neutral-bg hover:text-primary focus-visible:ring-primary/30 active:scale-[0.98]',
        'danger' => 'bg-error text-white hover:bg-error shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 focus-visible:ring-error/40 active:scale-[0.98]',
        'success' => 'bg-success text-white hover:bg-success shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 focus-visible:ring-success/40 active:scale-[0.98]',
        'warning' => 'bg-warning text-white hover:bg-warning shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 focus-visible:ring-warning/40 active:scale-[0.98]',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $widthClass = $fullWidth ? 'w-full' : '';

    $classes = implode(' ', array_filter([$baseClasses, $sizeClass, $variantClass, $widthClass]));
    $isDisabled = $disabled || $isLoading;
@endphp

@if($href && !$isDisabled)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($isLoading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($leftIcon || $icon)
            <span class="inline-flex shrink-0 items-center justify-center">{{ $leftIcon ?? $icon }}</span>
        @endif

        <span class="truncate">{{ $slot }}</span>

        @if($rightIcon && !$isLoading)
            <span class="inline-flex shrink-0 items-center justify-center">{{ $rightIcon }}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $disabled || $isLoading ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if($isLoading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($leftIcon || $icon)
            <span class="inline-flex shrink-0 items-center justify-center">{{ $leftIcon ?? $icon }}</span>
        @endif

        <span class="truncate">{{ $slot }}</span>

        @if($rightIcon && !$isLoading)
            <span class="inline-flex shrink-0 items-center justify-center">{{ $rightIcon }}</span>
        @endif
    </button>
@endif
