@props([
    'icon' => null,
    'title' => 'No data available',
    'description' => 'There are no records to display at this moment.',
    'actionText' => null,
    'actionHref' => null,
    'actionIcon' => null,
    'actionVariant' => 'primary',
    'compact' => false,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center ' . ($compact ? 'py-8 px-4' : 'py-12 sm:py-16 px-6') . ' rounded-2xl border border-dashed border-neutral-border bg-white']) }}>
    <!-- Icon Container -->
    <div class="w-16 h-16 rounded-2xl bg-neutral-bg border border-neutral-border flex items-center justify-center text-neutral-muted mb-4 shadow-xs">
        @if($icon)
            {{ $icon }}
        @else
            <!-- Default Box/Folder SVG -->
            <svg class="w-8 h-8 text-neutral-muted/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        @endif
    </div>

    <!-- Title & Description -->
    <h3 class="text-base sm:text-lg font-semibold text-neutral-text font-poppins">{{ $title }}</h3>
    @if($description)
        <p class="text-sm text-neutral-muted max-w-sm mt-1.5 leading-relaxed">{{ $description }}</p>
    @endif

    <!-- Optional CTA / Action Slot -->
    @if(isset($action))
        <div class="mt-6">
            {{ $action }}
        </div>
    @elseif($actionText)
        <div class="mt-6">
            <x-button 
                :variant="$actionVariant"
                :href="$actionHref"
                :leftIcon="$actionIcon"
            >
                {{ $actionText }}
            </x-button>
        </div>
    @endif

    {{ $slot }}
</div>
