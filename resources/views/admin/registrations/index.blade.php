@extends('layouts.admin', ['activeNav' => 'registrations', 'pageTitle' => 'Semua Registrasi Event', 'breadcrumbs' => [['label' => 'Registrations']]])

@section('title', 'Semua Registrasi Event')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <!-- Flash Messages -->
        @if(session('success'))
            <x-alert type="success" dismissible="true" class="mb-6">
                {{ session('success') }}
            </x-alert>
        @endif

        @if(session('error'))
            <x-alert type="error" dismissible="true" class="mb-6">
                {{ session('error') }}
            </x-alert>
        @endif

        <!-- Header Section -->
        <div class="w-full min-w-0 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">
                    Semua Registrasi Event
                </h2>
                <p class="text-sm text-neutral-muted">
                    Pantau seluruh data pendaftaran tiket dan partisipasi peserta di semua event EventHub.
                </p>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <form method="GET" action="{{ route('admin.registrations.index') }}" class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border p-4 sm:p-5 shadow-xs space-y-4">
            <!-- Search Row -->
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search', request('q')) }}"
                    placeholder="Cari kode tiket, nama peserta, email, atau judul event..." 
                    class="w-full pl-10 pr-3.5 py-2.5 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text placeholder:text-neutral-muted/60 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                />
            </div>

            <!-- Filters Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                <!-- Status Filter -->
                <select 
                    name="status"
                    class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                >
                    <option value="">Semua Status</option>
                    <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Terdaftar (Registered)</option>
                    <option value="attended" {{ request('status') === 'attended' ? 'selected' : '' }}>Hadir (Attended)</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>

                <!-- Event Filter -->
                <select 
                    name="event_id"
                    class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                >
                    <option value="">Semua Event</option>
                    @foreach($events as $eventOption)
                        <option value="{{ $eventOption->id }}" {{ (string)request('event_id') === (string)$eventOption->id ? 'selected' : '' }}>
                            {{ $eventOption->title }}
                        </option>
                    @endforeach
                </select>

                <!-- Date From -->
                <input 
                    type="date" 
                    name="date_from" 
                    value="{{ request('date_from') }}"
                    placeholder="Dari Tanggal"
                    class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                />

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'q', 'status', 'event_id', 'date_from', 'date_to']))
                        <a href="{{ route('admin.registrations.index') }}" class="px-4 py-2 bg-neutral-bg text-neutral-text text-sm font-semibold rounded-xl hover:bg-neutral-border transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Main Table Card -->
        <div class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            <!-- Table Header Info -->
            <div class="px-6 py-4 border-b border-neutral-border/60 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-muted">Data Registrasi</span>
                <span class="text-xs text-neutral-muted">{{ $registrations->total() }} {{ Str::plural('registrasi', $registrations->total()) }} ditemukan</span>
            </div>

            @if($registrations->count() > 0)
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-bg/50 border-b border-neutral-border">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Kode Tiket</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Peserta</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Waktu Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-border">
                            @foreach($registrations as $reg)
                                <tr class="hover:bg-neutral-bg/30 transition-colors">
                                    <!-- Kode Tiket -->
                                    <td class="px-6 py-4">
                                        <code class="text-xs bg-neutral-bg px-2.5 py-1.5 rounded-lg border border-neutral-border font-mono font-semibold text-neutral-text">
                                            {{ $reg->registration_code }}
                                        </code>
                                    </td>

                                    <!-- Peserta -->
                                    <td class="px-6 py-4">
                                        @if($reg->user)
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-primary-light text-primary font-bold flex items-center justify-center text-xs shrink-0 border border-primary/20">
                                                    {{ strtoupper(substr($reg->user->name, 0, 2)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-semibold text-neutral-text truncate">
                                                        {{ $reg->user->name }}
                                                    </div>
                                                    <p class="text-xs text-neutral-muted truncate">{{ $reg->user->email }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-xs text-neutral-muted italic">User Dihapus</span>
                                        @endif
                                    </td>

                                    <!-- Event -->
                                    <td class="px-6 py-4">
                                        @if($reg->event)
                                            <div class="min-w-0 max-w-xs sm:max-w-sm">
                                                <a href="{{ route('events.show', $reg->event->slug) }}" target="_blank" class="text-sm font-semibold text-neutral-text hover:text-primary transition-colors line-clamp-1">
                                                    {{ $reg->event->title }}
                                                </a>
                                                <div class="flex items-center gap-2 mt-0.5 text-xs text-neutral-muted">
                                                    <span class="truncate">{{ $reg->event->category->name ?? 'Umum' }}</span>
                                                    <span>&bull;</span>
                                                    <span class="truncate">{{ $reg->event->city->name ?? $reg->event->location ?? 'Online' }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-xs text-neutral-muted italic">Event Dihapus</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        @if($reg->status === 'registered')
                                            <x-badge variant="success" size="sm">Terdaftar</x-badge>
                                        @elseif($reg->status === 'attended')
                                            <x-badge variant="info" size="sm">Hadir</x-badge>
                                        @elseif($reg->status === 'cancelled')
                                            <x-badge variant="error" size="sm">Dibatalkan</x-badge>
                                        @else
                                            <x-badge variant="neutral" size="sm">{{ ucfirst($reg->status) }}</x-badge>
                                        @endif
                                    </td>

                                    <!-- Waktu Registrasi -->
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-neutral-text font-medium">
                                            {{ $reg->registered_at ? $reg->registered_at->format('d M Y') : '—' }}
                                        </div>
                                        <div class="text-[11px] text-neutral-muted">
                                            {{ $reg->registered_at ? $reg->registered_at->format('H:i') . ' WIB' : '' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($registrations->hasPages())
                    <div class="px-6 py-4 border-t border-neutral-border/60">
                        {{ $registrations->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="py-16 px-6 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-neutral-bg text-neutral-muted/60 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold font-poppins text-neutral-text mb-1">Tidak Ada Registrasi</h3>
                    <p class="text-xs sm:text-sm text-neutral-muted max-w-sm mx-auto mb-4">
                        Tidak ada data registrasi event yang sesuai dengan filter pencarian yang kamu pilih.
                    </p>
                    @if(request()->hasAny(['search', 'q', 'status', 'event_id', 'date_from', 'date_to']))
                        <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white text-xs font-semibold rounded-xl hover:bg-primary-hover transition-colors">
                            Reset Filter
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
