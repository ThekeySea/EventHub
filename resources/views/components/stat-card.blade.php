@props([
    'title',
    'value',
    'change' => null,
    'trend' => 'up',
    'period' => 'vs last month',
    'icon' => null,
    'iconBg' => 'bg-primary-light text-primary',
    'badge' => 'Preview data',
])

@php
    $trendColors = [
        'up' => 'text-success bg-success-light border-success/20',
        'down' => 'text-error bg-error-light border-error/20',
        'neutral' => 'text-neutral-muted bg-neutral-bg border-neutral-border',
    ];
    $trendClass = $trendColors[$trend] ?? $trendColors['up'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-neutral-border p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between relative overflow-hidden group']) }}>
    <!-- Header with Title & Icon -->
    <div class="flex items-start justify-between gap-3">
        <div class="space-y-1">
            <span class="text-xs sm:text-sm font-medium text-neutral-muted">{{ $title }}</span>
            <div class="text-2xl sm:text-3xl font-bold text-neutral-text tracking-tight font-poppins mt-1">
                {{ $value }}
            </div>
        </div>

        @if(isset($icon))
            <div class="w-12 h-12 rounded-xl {{ $iconBg }} flex items-center justify-center shrink-0 shadow-xs transition-transform group-hover:scale-105 duration-200">
                {{ $icon }}
            </div>
        @endif
    </div>

    <!-- Bottom Trend & Period Info -->
    <div class="mt-4 pt-4 border-t border-neutral-border/60 flex items-center justify-between gap-2 text-xs">
        <div class="flex items-center gap-2 flex-wrap">
            @if($change)
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full font-medium border {{ $trendClass }}">
                    @if($trend === 'up')
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    @elseif($trend === 'down')
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/>
                        </svg>
                    @endif
                    <span>{{ $change }}</span>
                </span>
            @endif

            @if($period)
                <span class="text-neutral-muted text-[11px]">{{ $period }}</span>
            @endif
        </div>

        @if($badge)
            <span class="text-[10px] uppercase font-semibold tracking-wider text-neutral-muted/70 bg-neutral-bg px-2 py-0.5 rounded-md border border-neutral-border/60">
                {{ $badge }}
            </span>
        @endif
    </div>
</div>
