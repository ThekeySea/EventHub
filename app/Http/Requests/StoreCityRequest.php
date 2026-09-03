<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    protected function prepareForValidation(): void
    {
        $slug = $this->filled('slug') ? $this->slug : Str::slug($this->name);

        $this->merge([
            'slug' => $slug,
            'is_active' => $this->has('is_active') ? (bool) $this->is_active : true,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:cities,name'],
            'slug' => ['nullable', 'string', 'max:120', 'unique:cities,slug'],
            'province' => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
        ];
    }
}
