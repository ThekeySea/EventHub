@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'error' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'icon' => null,
    'rightIcon' => null,
    'prefix' => null,
    'suffix' => null,
])

@php
    $inputId = $id ?? ($name ?? 'input-' . uniqid());
    $hasError = !empty($error) || ($name && $errors->has($name));
    $errorMessage = $error ?? ($name && $errors->has($name) ? $errors->first($name) : null);
@endphp

<div class="space-y-1.5 w-full">
    @if($label)
        <div class="flex items-center justify-between">
            <label for="{{ $inputId }}" class="block text-sm font-medium text-neutral-text">
                {{ $label }}
                @if($required)
                    <span class="text-error ml-0.5">*</span>
                @endif
            </label>
            @if(isset($labelExtra))
                <span class="text-xs text-neutral-muted">{{ $labelExtra }}</span>
            @endif
        </div>
    @endif

    <div class="relative flex items-center rounded-xl shadow-xs">
        @if($prefix)
            <span class="inline-flex items-center px-3.5 py-2.5 rounded-l-xl border border-r-0 border-neutral-border bg-neutral-bg text-neutral-muted text-sm font-medium select-none">
                {{ $prefix }}
            </span>
        @elseif($icon)
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-muted">
                {{ $icon }}
            </div>
        @endif

        <input 
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $attributes->merge([
                'class' => 'block w-full text-sm text-neutral-text placeholder:text-neutral-muted/60 transition-all duration-150 outline-none ' .
                ($prefix ? 'rounded-r-xl ' : ($suffix ? 'rounded-l-xl ' : 'rounded-xl ')) .
                ($icon && !$prefix ? 'pl-10 ' : 'px-3.5 ') .
                ($rightIcon && !$suffix ? 'pr-10 ' : 'py-2.5 ') .
                ($hasError 
                    ? 'border-error focus:border-error focus:ring-2 focus:ring-error/20 bg-error-light/30 ' 
                    : 'border border-neutral-border bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 ') .
                ($disabled ? 'bg-neutral-bg text-neutral-muted cursor-not-allowed opacity-75 ' : '')
            ]) }}
        />

        @if($suffix)
            <span class="inline-flex items-center px-3.5 py-2.5 rounded-r-xl border border-l-0 border-neutral-border bg-neutral-bg text-neutral-muted text-sm font-medium select-none">
                {{ $suffix }}
            </span>
        @elseif($rightIcon)
            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-neutral-muted">
                {{ $rightIcon }}
            </div>
        @endif
    </div>

    @if($errorMessage)
        <p class="text-xs text-error font-medium flex items-center gap-1 mt-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $errorMessage }}</span>
        </p>
    @elseif($hint)
        <p class="text-xs text-neutral-muted mt-1">{{ $hint }}</p>
    @endif
</div>
