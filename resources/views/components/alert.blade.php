@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
    'icon' => null,
])

@php
    $typeConfigs = [
        'info' => [
            'container' => 'bg-info-light border-info/30 text-info',
            'title' => 'text-info font-semibold',
            'iconColor' => 'text-info',
            'defaultIcon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
        'success' => [
            'container' => 'bg-success-light border-success/30 text-success',
            'title' => 'text-success font-semibold',
            'iconColor' => 'text-success',
            'defaultIcon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
        'warning' => [
            'container' => 'bg-warning-light border-warning/30 text-warning',
            'title' => 'text-warning font-semibold',
            'iconColor' => 'text-warning',
            'defaultIcon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
        ],
        'error' => [
            'container' => 'bg-error-light border-error/30 text-error',
            'title' => 'text-error font-semibold',
            'iconColor' => 'text-error',
            'defaultIcon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
        'neutral' => [
            'container' => 'bg-neutral-bg border-neutral-border text-neutral-text',
            'title' => 'text-neutral-text font-semibold',
            'iconColor' => 'text-neutral-muted',
            'defaultIcon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
    ];

    $cfg = $typeConfigs[$type] ?? $typeConfigs['info'];
@endphp

<div 
    @if($dismissible) x-data="{ show: true }" x-show="show" x-transition.duration.200ms @endif
    {{ $attributes->merge(['class' => 'p-4 rounded-xl border flex items-start gap-3.5 ' . $cfg['container']]) }}
    role="alert"
>
    <!-- Icon -->
    <div class="shrink-0 mt-0.5 {{ $cfg['iconColor'] }}">
        @if($icon)
            {{ $icon }}
        @else
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $cfg['defaultIcon'] !!}
            </svg>
        @endif
    </div>

    <!-- Content -->
    <div class="flex-1 text-sm leading-relaxed">
        @if($title)
            <h4 class="font-semibold text-sm {{ $cfg['title'] }} mb-0.5">{{ $title }}</h4>
        @endif
        <div class="text-xs sm:text-sm">
            {{ $slot }}
        </div>
    </div>

    <!-- Dismiss button -->
    @if($dismissible)
        <button 
            type="button" 
            @click="show = false" 
            class="shrink-0 -mr-1 -mt-1 p-1 rounded-lg hover:bg-black/5 text-neutral-muted hover:text-neutral-text transition-colors focus:outline-none"
            aria-label="Dismiss alert"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</div>
