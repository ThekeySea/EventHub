@extends('layouts.admin', ['activeNav' => 'cities', 'pageTitle' => 'Edit Kota', 'breadcrumbs' => [['label' => 'Kota / Lokasi', 'url' => route('admin.cities.index')], ['label' => 'Edit']]])

@section('title', 'Edit Kota')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div class="w-full min-w-0 max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 sm:p-8">
                <h2 class="text-xl font-bold text-neutral-text font-poppins mb-6">Edit Kota</h2>

                <form action="{{ route('admin.cities.update', $city) }}" method="POST" class="space-y-6">
                    @csrf @method('PATCH')
                    <x-input label="City Name" name="name" placeholder="e.g. Jakarta" hint="Display name of the city" required="true" value="{{ old('name', $city->name) }}" :error="$errors->first('name')" />
                    <x-input label="Slug" name="slug" placeholder="jakarta" hint="URL-friendly identifier" value="{{ old('slug', $city->slug) }}" :error="$errors->first('slug')" />
                    <x-input label="Province" name="province" placeholder="e.g. DKI Jakarta" hint="Province or region (optional)" value="{{ old('province', $city->province) }}" :error="$errors->first('province')" />

                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="is_active" name="is_active" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary border-neutral-border cursor-pointer" {{ old('is_active', $city->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="text-sm font-medium text-neutral-text cursor-pointer">Aktif <span class="block text-[11px] text-neutral-muted font-normal">Aktifkan visibilitas. Hanya kota aktif yang tersedia untuk organizer.</span></label>
                    </div>

                    <div class="pt-6 border-t border-neutral-border space-y-3">
                        <div class="flex items-center justify-between p-3.5 bg-neutral-bg rounded-xl border border-neutral-border/60">
                            <div>
                                <p class="text-xs font-semibold text-neutral-text">City ID</p>
                                <p class="text-xs text-neutral-muted mt-0.5">#{{ $city->id }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-medium {{ $city->is_active ? 'text-success' : 'text-neutral-muted' }}">{{ $city->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                <span class="text-[11px] font-mono bg-white px-2.5 py-1.5 rounded-lg border border-neutral-border text-neutral-muted">Slug: {{ $city->slug }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.cities.index') }}" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Cancel</a>
                            <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all">Update City</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
