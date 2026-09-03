<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    protected function prepareForValidation(): void
    {
        $city = $this->route('city');
        $slug = $this->filled('slug') ? $this->slug : Str::slug($this->name);

        $this->merge([
            'slug' => $slug,
            'is_active' => $this->has('is_active') ? (bool) $this->is_active : false,
        ]);
    }

    public function rules(): array
    {
        $city = $this->route('city');
        $id = is_object($city) ? $city->id : $city;

        return [
            'name' => ['required', 'string', 'max:100', 'unique:cities,name,' . $id],
            'slug' => ['nullable', 'string', 'max:120', 'unique:cities,slug,' . $id],
            'province' => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
        ];
    }
}
