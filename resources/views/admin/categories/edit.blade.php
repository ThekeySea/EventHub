@extends('layouts.admin', ['activeNav' => 'categories', 'pageTitle' => 'Edit Tema', 'breadcrumbs' => [['label' => 'Event Themes', 'url' => route('admin.categories.index')], ['label' => 'Edit Tema']]])

@section('title', 'Edit Tema')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div class="w-full min-w-0 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 sm:p-8">
            <h2 class="text-xl font-bold text-neutral-text font-poppins mb-6">Edit Tema</h2>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <x-input 
                    label="Nama Tema" 
                    name="name" 
                    placeholder="e.g. Technology" 
                    hint="Contoh: Teknologi, Olahraga, Seni, Bisnis. Tema digunakan untuk mengklasifikasikan event." 
                    required="true"
                    value="{{ old('name', $category->name) }}"
                    :error="$errors->first('name')"
                />

                <x-input 
                    label="Slug" 
                    name="slug" 
                    placeholder="technology" 
                    hint="URL-friendly identifier (leave empty to auto-generate)" 
                    value="{{ old('slug', $category->slug) }}"
                    :error="$errors->first('slug')"
                />

                <div class="space-y-1.5 w-full">
                    <label class="block text-sm font-medium text-neutral-text">Description</label>
                    <textarea 
                        name="description"
                        class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 min-h-[120px] {{ $errors->has('description') ? 'border-error focus:border-error focus:ring-error/20' : '' }}"
                        placeholder="Briefly describe what this category represents..."
                    >{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-error font-medium flex items-center gap-1 mt-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_active" name="is_active" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary border-neutral-border cursor-pointer" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm font-medium text-neutral-text cursor-pointer">
                        Active
                        <span class="block text-[11px] text-neutral-muted font-normal">Toggle theme visibility. Only active themes are available for organizers to select.</span>
                    </label>
                </div>

                <div class="pt-6 border-t border-neutral-border space-y-3">
                    <div class="flex items-center justify-between p-3.5 bg-neutral-bg rounded-xl border border-neutral-border/60">
                        <div>
                            <p class="text-xs font-semibold text-neutral-text">ID Tema</p>
                            <p class="text-xs text-neutral-muted mt-0.5">#{{ $category->id }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium {{ $category->is_active ? 'text-success' : 'text-neutral-muted' }}">
                                {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <span class="text-[11px] font-mono bg-white px-2.5 py-1.5 rounded-lg border border-neutral-border text-neutral-muted">
                                Slug: {{ $category->slug }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all">
                            Perbarui Tema
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection