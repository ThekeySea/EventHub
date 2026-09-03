@extends('layouts.admin', ['activeNav' => 'event-types', 'pageTitle' => 'Tambah Jenis Acara', 'breadcrumbs' => [['label' => 'Jenis Acara', 'url' => route('admin.event-types.index')], ['label' => 'Create']]])

@section('title', 'Tambah Jenis Acara')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div class="w-full min-w-0 max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 sm:p-8">
                <h2 class="text-xl font-bold text-neutral-text font-poppins mb-6">Tambah Jenis Acara Baru</h2>

                <form action="{{ route('admin.event-types.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <x-input label="Name" name="name" placeholder="e.g. Daring (Online)" hint="Display name for this event type" required="true" value="{{ old('name') }}" :error="$errors->first('name')" />
                    <x-input label="Slug" name="slug" placeholder="daring-online" hint="URL-friendly identifier (leave empty to auto-generate)" value="{{ old('slug') }}" :error="$errors->first('slug')" />

                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">Description</label>
                        <textarea name="description" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 min-h-[120px] {{ $errors->has('description') ? 'border-error focus:border-error focus:ring-error/20' : '' }}" placeholder="Briefly describe this event type...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-xs text-error font-medium flex items-center gap-1 mt-1"><svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>{{ $message }}</span></p> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="is_active" name="is_active" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary border-neutral-border cursor-pointer" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="text-sm font-medium text-neutral-text cursor-pointer">Active <span class="block text-[11px] text-neutral-muted font-normal">Toggle visibility. Only active types are available for organizers.</span></label>
                    </div>

                    <div class="pt-6 border-t border-neutral-border flex items-center justify-end gap-3">
                        <a href="{{ route('admin.event-types.index') }}" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all">Save Event Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
