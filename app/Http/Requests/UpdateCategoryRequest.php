<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $category = $this->route('category');
        $slug = $this->filled('slug') ? $this->slug : Str::slug($this->name);

        $this->merge([
            'slug' => $slug,
            'is_active' => $this->has('is_active') ? (bool) $this->is_active : false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $category = $this->route('category');
        $categoryId = is_object($category) ? $category->id : $category;

        return [
            'name' => ['required', 'string', 'max:100', 'unique:categories,name,' . $categoryId],
            'slug' => ['nullable', 'string', 'max:120', 'unique:categories,slug,' . $categoryId],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}