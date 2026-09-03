<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'organizer';
    }

    protected function prepareForValidation(): void
    {
        $title = $this->input('title');
        $baseSlug = $this->filled('slug') ? $this->slug : ($title ? Str::slug($title) : '');
        
        if (empty($baseSlug)) {
            $slug = 'draft-' . Str::random(8);
        } else {
            $slug = $baseSlug;
            $count = \App\Models\Event::where('slug', $slug)->count();
            if ($count > 0) {
                $slug = $baseSlug . '-' . Str::random(4);
            }
        }

        $this->merge([
            'slug' => $slug,
            'timezone' => $this->filled('timezone') ? $this->timezone : 'Asia/Jakarta',
        ]);
    }

    public function rules(): array
    {
        $isSubmit = $this->input('submit_type') === 'submit';

        if (!$isSubmit) {
            return [
                'title' => ['required', 'string', 'min:3', 'max:160'],
                'slug' => ['required', 'string', 'max:200', 'unique:events,slug'],
                'category_id' => ['required', 'exists:categories,id'],
                'description' => ['nullable', 'string'],
                'event_type' => ['nullable', 'string'],
                'city' => ['nullable', 'string', 'max:100'],
                'location' => ['nullable', 'string', 'max:255'],
                'online_url' => ['nullable', 'string', 'max:500'],
                'start_at' => ['nullable', 'date'],
                'end_at' => ['nullable', 'date'],
                'timezone' => ['nullable', 'string', 'max:50'],
                'capacity' => ['nullable', 'integer', 'min:1'],
                'registration_deadline' => ['nullable', 'date'],
                'payment_method' => ['nullable', 'string', 'in:free,upfront,onsite'],
                'payment_info' => ['nullable', 'string', 'max:1000'],
                'banner' => ['nullable', 'image', 'max:2048'],
                'event_type_id' => ['nullable', 'exists:event_types,id'],
                'event_format_id' => ['nullable', 'exists:event_formats,id'],
                'city_id' => ['nullable', 'exists:cities,id'],
            ];
        }

        return [
            'title' => ['required', 'string', 'min:3', 'max:160'],
            'slug' => ['required', 'string', 'max:200', 'unique:events,slug'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'event_type' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'online_url' => ['nullable', 'string', 'max:500'],
            'start_at' => ['required', 'date', 'after:now'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'timezone' => ['required', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1'],
            'registration_deadline' => ['nullable', 'date', 'before:start_at'],
            'payment_method' => ['nullable', 'string', 'in:free,upfront,onsite'],
            'payment_info' => ['nullable', 'string', 'max:1000'],
            'banner' => ['nullable', 'image', 'max:2048'],
            'event_type_id' => ['nullable', 'exists:event_types,id'],
            'event_format_id' => ['nullable', 'exists:event_formats,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->category_id) {
                $category = \App\Models\Category::find($this->category_id);
                if ($category && !$category->is_active) {
                    $validator->errors()->add('category_id', 'Kategori yang dipilih tidak aktif.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'event_type.in' => 'Jenis acara harus salah satu dari: luring, daring, hybrid.',
        ];
    }
}
