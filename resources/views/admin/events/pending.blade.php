@extends('layouts.admin', ['activeNav' => 'events', 'pageTitle' => 'Pending Events', 'breadcrumbs' => [['label' => 'Events', 'url' => route('admin.events.index')], ['label' => 'Pending']]])

@section('title', 'Pending Events — Moderation')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        @if(session('success'))
            <x-alert type="success" dismissible="true" class="mb-6">{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
            <x-alert type="error" dismissible="true" class="mb-6">{{ session('error') }}</x-alert>
        @endif

        <div class="w-full min-w-0">
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">Pending Events</h2>
            <p class="text-sm text-neutral-muted">Review dan moderasi event yang menunggu persetujuan.</p>
        </div>

        @if($events->count())
            <div class="space-y-4">
                @foreach($events as $event)
                    <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 hover:shadow-md transition-shadow" x-data="{ showReject: false }">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-neutral-text font-poppins">{{ $event->title }}</h3>
                                    <x-badge variant="warning" size="sm">Pending</x-badge>
                                </div>
                                <div class="flex flex-wrap gap-2 text-xs text-neutral-muted mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        {{ $event->organizer->name ?? 'Unknown' }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $event->category->name ?? '—' }}</span>
                                    <span>•</span>
                                    <span>{{ $event->eventType->name ?? '—' }}</span>
                                    <span>•</span>
                                    <span>{{ $event->city->name ?? $event->location ?? '—' }}</span>
                                </div>
                                <p class="text-sm text-neutral-muted line-clamp-2">{{ $event->description }}</p>
                                <div class="flex items-center gap-4 mt-3 text-xs text-neutral-muted">
                                    <span>📅 {{ $event->start_at ? $event->start_at->format('d M Y, H:i') : '—' }}</span>
                                    <span>👥 Capacity: {{ $event->capacity ?? '—' }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 sm:items-end shrink-0">
                                <a href="{{ route('admin.events.show', $event) }}" class="px-4 py-2 text-sm font-semibold text-primary border border-primary/20 rounded-xl hover:bg-primary-light transition-colors text-center">
                                    View Details
                                </a>

                                <div class="flex gap-2">
                                    <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-success text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all">
                                            ✓ Approve
                                        </button>
                                    </form>
                                    <button type="button" @click="showReject = !showReject" class="px-4 py-2 bg-error text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all">
                                        ✕ Reject
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Form (expandable) -->
                        <div x-show="showReject" x-cloak x-transition class="mt-4 pt-4 border-t border-neutral-border">
                            <form action="{{ route('admin.events.reject', $event) }}" method="POST" class="space-y-3">
                                @csrf
                                <label class="block text-sm font-medium text-neutral-text">Alasan Penolakan <span class="text-error">*</span></label>
                                <textarea name="rejection_reason" required placeholder="Jelaskan alasan penolakan event ini..." class="w-full rounded-xl border border-neutral-border bg-white p-3 text-sm focus:border-error focus:ring-2 focus:ring-error/20 outline-none transition-all min-h-[80px]"></textarea>
                                <div class="flex items-center gap-2 justify-end">
                                    <button type="button" @click="showReject = false" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-error text-white text-sm font-semibold rounded-xl hover:opacity-90 transition-colors">Kirim Penolakan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($events->hasPages())
                <div class="flex justify-center">{{ $events->links() }}</div>
            @endif
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-neutral-border">
                <svg class="w-16 h-16 mx-auto text-success mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-lg font-semibold text-neutral-text mb-2">Semua sudah direview! 🎉</h3>
                <p class="text-sm text-neutral-muted">Tidak ada event pending saat ini.</p>
            </div>
        @endif
    </div>
@endsection
