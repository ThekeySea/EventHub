@props([
    'title' => null,
    'subtitle' => null,
    'action' => null,
    'padding' => 'p-6',
    'headerBorder' => true,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-neutral-border shadow-sm transition-all duration-200']) }}>
    @if($title || $subtitle || $action || isset($header))
        <div class="px-6 py-4.5 flex items-center justify-between gap-4 {{ $headerBorder ? 'border-b border-neutral-border' : '' }}">
            @if(isset($header))
                {{ $header }}
            @else
                <div>
                    @if($title)
                        <h3 class="text-base sm:text-lg font-semibold text-neutral-text tracking-tight">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-xs sm:text-sm text-neutral-muted mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
                @if($action)
                    <div class="flex items-center gap-2">
                        {{ $action }}
                    </div>
                @endif
            @endif
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    @if($footer || isset($footerSlot))
        <div class="px-6 py-4 bg-neutral-bg/60 border-t border-neutral-border rounded-b-2xl flex items-center justify-between gap-4">
            {{ $footer ?? $footerSlot }}
        </div>
    @endif
</div>
