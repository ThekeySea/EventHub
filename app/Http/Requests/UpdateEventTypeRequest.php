<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateEventTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    protected function prepareForValidation(): void
    {
        $eventType = $this->route('eventType');
        $slug = $this->filled('slug') ? $this->slug : Str::slug($this->name);

        $this->merge([
            'slug' => $slug,
            'is_active' => $this->has('is_active') ? (bool) $this->is_active : false,
        ]);
    }

    public function rules(): array
    {
        $eventType = $this->route('eventType');
        $id = is_object($eventType) ? $eventType->id : $eventType;

        return [
            'name' => ['required', 'string', 'max:100', 'unique:event_types,name,' . $id],
            'slug' => ['nullable', 'string', 'max:120', 'unique:event_types,slug,' . $id],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
