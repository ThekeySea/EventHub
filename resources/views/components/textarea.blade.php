@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'rows' => 4,
    'placeholder' => '',
    'value' => '',
    'error' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
])

@php
    $textareaId = $id ?? ($name ?? 'textarea-' . uniqid());
    $hasError = !empty($error) || ($name && $errors->has($name));
    $errorMessage = $error ?? ($name && $errors->has($name) ? $errors->first($name) : null);
@endphp

<div class="space-y-1.5 w-full">
    @if($label)
        <div class="flex items-center justify-between">
            <label for="{{ $textareaId }}" class="block text-sm font-medium text-neutral-text">
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

    <div class="relative rounded-xl shadow-xs">
        <textarea 
            name="{{ $name }}"
            id="{{ $textareaId }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $attributes->merge([
                'class' => 'block w-full rounded-xl text-sm text-neutral-text placeholder:text-neutral-muted/60 p-3.5 transition-all duration-150 outline-none resize-y ' .
                ($hasError 
                    ? 'border-error focus:border-error focus:ring-2 focus:ring-error/20 bg-error-light/30 ' 
                    : 'border border-neutral-border bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 ') .
                ($disabled ? 'bg-neutral-bg text-neutral-muted cursor-not-allowed opacity-75 ' : '')
            ]) }}
        >{{ old($name, $value) }}</textarea>
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
