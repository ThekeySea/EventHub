@extends('layouts.admin', ['activeNav' => 'event-types', 'pageTitle' => 'Edit Jenis Acara', 'breadcrumbs' => [['label' => 'Jenis Acara', 'url' => route('admin.event-types.index')], ['label' => 'Edit']]])

@section('title', 'Edit Jenis Acara')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div class="w-full min-w-0 max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 sm:p-8">
                <h2 class="text-xl font-bold text-neutral-text font-poppins mb-6">Edit Jenis Acara</h2>

                <form action="{{ route('admin.event-types.update', $eventType) }}" method="POST" class="space-y-6">
                    @csrf @method('PATCH')
                    <x-input label="Name" name="name" placeholder="e.g. Daring (Online)" hint="Display name for this event type" required="true" value="{{ old('name', $eventType->name) }}" :error="$errors->first('name')" />
                    <x-input label="Slug" name="slug" placeholder="daring-online" hint="URL-friendly identifier" value="{{ old('slug', $eventType->slug) }}" :error="$errors->first('slug')" />

                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">Description</label>
                        <textarea name="description" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 min-h-[120px] {{ $errors->has('description') ? 'border-error' : '' }}">{{ old('description', $eventType->description) }}</textarea>
                        @error('description') <p class="text-xs text-error font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="is_active" name="is_active" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary border-neutral-border cursor-pointer" {{ old('is_active', $eventType->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="text-sm font-medium text-neutral-text cursor-pointer">Active <span class="block text-[11px] text-neutral-muted font-normal">Toggle visibility. Only active types are available for organizers.</span></label>
                    </div>

                    <div class="pt-6 border-t border-neutral-border space-y-3">
                        <div class="flex items-center justify-between p-3.5 bg-neutral-bg rounded-xl border border-neutral-border/60">
                            <div>
                                <p class="text-xs font-semibold text-neutral-text">Event Type ID</p>
                                <p class="text-xs text-neutral-muted mt-0.5">#{{ $eventType->id }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-medium {{ $eventType->is_active ? 'text-success' : 'text-neutral-muted' }}">{{ $eventType->is_active ? 'Active' : 'Inactive' }}</span>
                                <span class="text-[11px] font-mono bg-white px-2.5 py-1.5 rounded-lg border border-neutral-border text-neutral-muted">Slug: {{ $eventType->slug }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.event-types.index') }}" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Cancel</a>
                            <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all">Update Event Type</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
