@extends('layouts.organizer', ['activeNav' => 'events', 'pageTitle' => 'Event Saya', 'breadcrumbs' => [['label' => 'Event Saya']]])

@section('title', 'Event Saya')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <!-- Header Section -->
        <div class="w-full min-w-0 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">
                    Event Saya
                </h2>
                <p class="text-sm text-neutral-muted">
                    Kelola dan pantau semua event yang telah Anda buat.
                </p>
            </div>

            <div>
                <a 
                    href="/organizer/events/create"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-hover shadow-sm transition-all"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Event
                </a>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <form method="GET" action="/organizer/events" class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search"
                    placeholder="Cari event..." 
                    class="w-full pl-10 pr-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text placeholder:text-neutral-muted/60 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                />
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <select 
                    name="status"
                    class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                    onchange="this.form.submit()"
                >
                    <option value="">Semua Status</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors">
                    Filter
                </button>
            </div>
        </form>

        <!-- Events Table Card -->
        <div class="bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            <!-- Table Header Info -->
            <div class="px-6 py-4 border-b border-neutral-border/60 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-muted">Daftar Event</span>
                <span class="text-xs text-neutral-muted">{{ $events->total() }} events</span>
            </div>

            @if($events->isEmpty())
                <!-- Empty State -->
                <div class="p-12 sm:p-16 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-neutral-bg border border-neutral-border text-neutral-muted flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-neutral-text font-poppins mb-1">Tidak ada event ditemukan</h3>
                    <p class="text-xs sm:text-sm text-neutral-muted max-w-sm mb-6">
                        Mulai dengan membuat event pertama Anda. Bagikan visi Anda dengan dunia!
                    </p>
                    <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-hover transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Event
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-neutral-text">
                        <thead class="bg-neutral-bg/50 border-b border-neutral-border text-neutral-muted uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3">Event</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-border/60">
                            @foreach($events as $event)
                                <tr>
                                    <td class="px-6 py-4 font-medium">{{ $event->title }}</td>
                                    <td class="px-6 py-4">{{ $event->category->name }}</td>
                                    <td class="px-6 py-4">
                                        @php($statusVariant = match($event->status) {
                                            'published' => 'success',
                                            'pending' => 'warning',
                                            'rejected' => 'error',
                                            default => 'neutral'
                                        })
                                        <x-badge variant="{{ $statusVariant }}" size="sm">{{ ucfirst($event->status) }}</x-badge>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('organizer.events.show', $event) }}" class="text-info font-semibold hover:text-info/80">Lihat</a> <span class="text-neutral-border mx-1">|</span> <a href="{{ route('organizer.events.edit', $event) }}" class="text-primary font-semibold hover:text-primary-hover">Edit</a> <span class="text-neutral-border mx-1">|</span>
                                        <form method="POST" action="{{ route('organizer.events.clone', $event) }}" class="inline" onsubmit="return confirm('Duplikasi event ini sebagai draft baru?')">
                                            @csrf
                                            <button type="submit" class="text-warning font-semibold hover:text-warning/80">Duplikat</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-neutral-border/60">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
