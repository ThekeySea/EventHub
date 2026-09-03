@extends('layouts.organizer')

@section('content')
<div class="space-y-8">
    <!-- Greeting Section -->
    <section>
        <h1 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins">
            Selamat datang kembali, {{ auth()->user()->name }}
        </h1>
        <p class="mt-2 text-neutral-muted max-w-2xl">
            Kelola eventmu dan pantau status review.
        </p>
    </section>

    <!-- Statistics Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-neutral-border hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-neutral-muted">Total Event</span>
                <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-neutral-text font-poppins">{{ $totalEvents }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-neutral-border hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-neutral-muted">Drafts</span>
                <div class="w-10 h-10 rounded-xl bg-warning-light text-warning flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-neutral-text font-poppins">{{ $draftEvents }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-neutral-border hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-neutral-muted">Menunggu Review</span>
                <div class="w-10 h-10 rounded-xl bg-info-light text-info flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-neutral-text font-poppins">{{ $pendingEvents }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-neutral-border hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-neutral-muted">Published</span>
                <div class="w-10 h-10 rounded-xl bg-success-light text-success flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-neutral-text font-poppins">{{ $publishedEvents }}</p>
        </div>
    </section>

    <!-- Event Terbaru -->
    <section class="bg-white rounded-2xl p-6 shadow-sm border border-neutral-border">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-neutral-text font-poppins">Event Terbaru</h2>
            <a href="{{ route('organizer.events.create') }}" class="text-sm font-medium text-primary hover:text-primary/80 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Event
            </a>
        </div>
        @if($recentEvents->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="border-b border-neutral-border">
                        <th class="text-left text-sm font-medium text-neutral-muted py-3 px-2">Event</th>
                        <th class="text-left text-sm font-medium text-neutral-muted py-3 px-2">Date</th>
                        <th class="text-left text-sm font-medium text-neutral-muted py-3 px-2">Status</th>
                        <th class="text-left text-sm font-medium text-neutral-muted py-3 px-2">Actions</th>
                    </tr></thead>
                    <tbody class="divide-y divide-neutral-border/60">
                        @foreach($recentEvents as $event)
                            <tr>
                                <td class="py-4 px-2"><div class="font-medium text-neutral-text">{{ $event->title }}</div><div class="text-xs text-neutral-muted">{{ $event->category->name ?? 'Tanpa Kategori' }}</div></td>
                                <td class="py-4 px-2 text-sm text-neutral-text">{{ $event->start_at ? $event->start_at->format('M d, Y') : '-' }}</td>
                                <td class="py-4 px-2">@php($sc = ['published'=>'success','draft'=>'warning','pending'=>'info','rejected'=>'danger','cancelled'=>'neutral'])<x-badge variant="{{ $sc[$event->status] ?? 'neutral' }}" size="sm">{{ ucfirst($event->status) }}</x-badge></td>
                                <td class="py-4 px-2"><div class="flex items-center gap-3"><a href="{{ route('organizer.events.show', $event) }}" class="text-sm font-medium text-info hover:text-info/80">View</a><a href="{{ route('organizer.events.edit', $event) }}" class="text-sm font-medium text-primary hover:text-primary/80">Edit</a></div></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12"><h3 class="text-sm font-semibold text-neutral-text">Kamu belum membuat event apapun</h3><a href="{{ route('organizer.events.create') }}" class="mt-6 inline-flex items-center px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">Buat Event</a></div>
        @endif
    </section>
</div>
@endsection
