@extends('layouts.admin', ['activeNav' => 'cities', 'pageTitle' => 'Create City', 'breadcrumbs' => [['label' => 'Kota / Lokasi', 'url' => route('admin.cities.index')], ['label' => 'Create']]])

@section('title', 'Create City')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div class="w-full min-w-0 max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 sm:p-8">
                <h2 class="text-xl font-bold text-neutral-text font-poppins mb-6">Tambah Kota Baru</h2>

                <form action="{{ route('admin.cities.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <x-input label="City Name" name="name" placeholder="e.g. Jakarta" hint="Display name of the city" required="true" value="{{ old('name') }}" :error="$errors->first('name')" />
                    <x-input label="Slug" name="slug" placeholder="jakarta" hint="URL-friendly identifier (leave empty to auto-generate)" value="{{ old('slug') }}" :error="$errors->first('slug')" />
                    <x-input label="Province" name="province" placeholder="e.g. DKI Jakarta" hint="Province or region (optional)" value="{{ old('province') }}" :error="$errors->first('province')" />

                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="is_active" name="is_active" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary border-neutral-border cursor-pointer" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="text-sm font-medium text-neutral-text cursor-pointer">Aktif <span class="block text-[11px] text-neutral-muted font-normal">Aktifkan visibilitas. Hanya kota aktif yang tersedia untuk organizer.</span></label>
                    </div>

                    <div class="pt-6 border-t border-neutral-border flex items-center justify-end gap-3">
                        <a href="{{ route('admin.cities.index') }}" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all">Save City</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
