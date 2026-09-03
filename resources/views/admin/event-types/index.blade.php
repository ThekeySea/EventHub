@extends('layouts.admin', ['activeNav' => 'event-types', 'pageTitle' => 'Jenis Acara', 'breadcrumbs' => [['label' => 'Jenis Acara']]])

@section('title', 'Jenis Acara Management')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        @if(session('success'))
            <x-alert type="success" dismissible="true" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <div class="w-full min-w-0 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">Jenis Acara</h2>
                <p class="text-sm text-neutral-muted">Kelola jenis acara (Daring, Luring, Hybrid) untuk event di EventHub.</p>
            </div>
            <a href="{{ route('admin.event-types.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-hover shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Jenis Acara
            </a>
        </div>

        <form method="GET" action="{{ route('admin.event-types.index') }}" class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis acara..." class="w-full pl-10 pr-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text placeholder:text-neutral-muted/60 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none" />
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <select name="is_active" class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors">Filter</button>
                @if(request('search') || request('is_active'))
                    <a href="{{ route('admin.event-types.index') }}" class="px-4 py-2 bg-neutral-bg text-neutral-text text-sm font-semibold rounded-xl hover:bg-neutral-border transition-colors">Hapus</a>
                @endif
            </div>
        </form>

        <div class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-border/60 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-muted">Jenis Acara</span>
                <span class="text-xs text-neutral-muted">{{ $eventTypes->total() }} {{ Str::plural('item', $eventTypes->total()) }} ditemukan</span>
            </div>

            @if($eventTypes->count())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-bg/50 border-b border-neutral-border">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider hidden md:table-cell">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-text uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-border">
                            @foreach($eventTypes as $type)
                                <tr class="hover:bg-neutral-bg/30 transition-colors">
                                    <td class="px-6 py-4"><div class="text-sm font-semibold text-neutral-text">{{ $type->name }}</div></td>
                                    <td class="px-6 py-4"><code class="text-xs text-neutral-muted bg-neutral-bg px-2 py-1 rounded">{{ $type->slug }}</code></td>
                                    <td class="px-6 py-4 hidden md:table-cell"><div class="text-sm text-neutral-muted line-clamp-2">{{ $type->description ?: '—' }}</div></td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('admin.event-types.toggle-status', $type) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="inline-flex items-center">
                                                @if($type->is_active) <x-badge variant="success" size="sm">Aktif</x-badge>
                                                @else <x-badge variant="neutral" size="sm">Nonaktif</x-badge> @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.event-types.edit', $type) }}" class="p-2 text-neutral-muted hover:text-primary hover:bg-primary-light rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($eventTypes->hasPages())
                    <div class="px-6 py-4 border-t border-neutral-border">{{ $eventTypes->links() }}</div>
                @endif
            @else
                <div class="p-12 sm:p-16 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-neutral-bg border border-neutral-border text-neutral-muted flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-neutral-text font-poppins mb-1">Tidak ada jenis acara ditemukan</h3>
                    <p class="text-xs sm:text-sm text-neutral-muted max-w-sm mb-6">@if(request('search') || request('is_active')) Coba sesuaikan filter Anda. @else Mulai dengan membuat jenis acara pertama Anda. @endif</p>
                    <a href="{{ route('admin.event-types.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-hover transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Jenis Acara
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
