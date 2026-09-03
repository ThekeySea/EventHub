@props([
    'name' => 'Category',
    'count' => 0,
    'icon' => null,
    'href' => '#',
    'color' => 'primary',
])

@php
    $colorClasses = [
        'primary' => [
            'iconBg' => 'bg-primary-light text-primary group-hover:bg-primary group-hover:text-white',
            'border' => 'group-hover:border-primary/50',
            'glow' => 'group-hover:shadow-primary/10',
        ],
        'secondary' => [
            'iconBg' => 'bg-secondary-light text-warning group-hover:bg-secondary group-hover:text-neutral-text',
            'border' => 'group-hover:border-secondary/50',
            'glow' => 'group-hover:shadow-amber-500/10',
        ],
        'success' => [
            'iconBg' => 'bg-success-light text-success group-hover:bg-success group-hover:text-white',
            'border' => 'group-hover:border-success/50',
            'glow' => 'group-hover:shadow-emerald-500/10',
        ],
        'info' => [
            'iconBg' => 'bg-info-light text-info group-hover:bg-info group-hover:text-white',
            'border' => 'group-hover:border-info/50',
            'glow' => 'group-hover:shadow-blue-500/10',
        ],
        'warning' => [
            'iconBg' => 'bg-warning-light text-warning group-hover:bg-warning group-hover:text-white',
            'border' => 'group-hover:border-warning/50',
            'glow' => 'group-hover:shadow-amber-500/10',
        ],
        'purple' => [
            'iconBg' => 'bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white',
            'border' => 'group-hover:border-purple-400',
            'glow' => 'group-hover:shadow-purple-500/10',
        ],
        'rose' => [
            'iconBg' => 'bg-rose-100 text-rose-600 group-hover:bg-rose-600 group-hover:text-white',
            'border' => 'group-hover:border-rose-400',
            'glow' => 'group-hover:shadow-rose-500/10',
        ],
    ];

    $style = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<a href="{{ $href }}" class="group relative block bg-neutral-surface border border-neutral-border rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-xl {{ $style['border'] }} {{ $style['glow'] }} hover:-translate-y-1.5 transition-all duration-300">
    <div class="flex items-center justify-between">
        <div class="w-12 h-12 rounded-xl {{ $style['iconBg'] }} flex items-center justify-center font-bold text-xl transition-all duration-300 shadow-xs">
            @if($icon)
                {{ $icon }}
            @else
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            @endif
        </div>
        
        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-neutral-bg text-neutral-muted group-hover:bg-primary-light group-hover:text-primary transition-colors">
            {{ $count }} Events
        </span>
    </div>

    <div class="mt-4 space-y-1">
        <h3 class="text-base sm:text-lg font-bold text-neutral-text group-hover:text-primary transition-colors font-poppins">
            {{ $name }}
        </h3>
        <p class="text-xs text-neutral-muted flex items-center gap-1 group-hover:text-neutral-text transition-colors">
            <span>Explore category</span>
            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </p>
    </div>
</a>

