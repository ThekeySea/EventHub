@extends('layouts.admin', ['activeNav' => 'events', 'pageTitle' => 'Detail Event', 'breadcrumbs' => [['label' => 'Events', 'url' => route('admin.events.index')], ['label' => $event->title]]])

@section('title', $event->title . ' — Admin')

@section('content')
    <div class="w-full min-w-0 max-w-4xl mx-auto space-y-6">
        @if(session('success'))
            <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
        @endif

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-neutral-text font-poppins">{{ $event->title }}</h2>
                <p class="text-sm text-neutral-muted mt-1">Created {{ $event->created_at->diffForHumans() }} by {{ $event->organizer->name ?? 'Unknown' }}</p>
            </div>
            <div class="flex items-center gap-2">
                @php($statusColors = ['draft' => 'neutral', 'pending' => 'warning', 'published' => 'success', 'rejected' => 'error', 'cancelled' => 'neutral'])
                <x-badge variant="{{ $statusColors[$event->status] ?? 'neutral' }}">{{ ucfirst($event->status) }}</x-badge>
                <a href="{{ route('admin.events.index') }}" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">← Back</a>
            </div>
        </div>

        <!-- Rejection Reason -->
        @if($event->status === 'rejected' && $event->rejection_reason)
            <div class="p-4 rounded-xl bg-error-light border border-error/20 text-error text-sm">
                <span class="font-semibold block mb-1">Rejection Reason:</span>
                {{ $event->rejection_reason }}
            </div>
        @endif

        <!-- Event Details -->
        <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Description</p>
                        <p class="text-sm text-neutral-text">{{ $event->description ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Theme</p>
                        <p class="text-sm text-neutral-text">{{ $event->category->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Jenis Acara</p>
                        <p class="text-sm text-neutral-text">{{ $event->eventType->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Format</p>
                        <p class="text-sm text-neutral-text">{{ $event->eventFormat->name ?? '—' }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Date & Time</p>
                        <p class="text-sm text-neutral-text">{{ $event->start_at ? $event->start_at->format('d M Y, H:i') : '—' }} — {{ $event->end_at ? $event->end_at->format('d M Y, H:i') : '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Timezone</p>
                        <p class="text-sm text-neutral-text">{{ $event->timezone }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Location</p>
                        <p class="text-sm text-neutral-text">{{ $event->city->name ?? '—' }} {{ $event->location ? '— ' . $event->location : '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Online URL</p>
                        <p class="text-sm text-neutral-text">{{ $event->online_url ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Capacity</p>
                        <p class="text-sm text-neutral-text">{{ $event->capacity ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Registration Deadline</p>
                        <p class="text-sm text-neutral-text">{{ $event->registration_deadline ? $event->registration_deadline->format('d M Y, H:i') : '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Moderation Actions -->
        @if($event->status === 'pending')
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6" x-data="{ showReject: false }">
                <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Moderation Actions</h3>
                <div class="flex flex-col sm:flex-row gap-3">
                    <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-success text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Approve & Publish
                        </button>
                    </form>
                    <button type="button" @click="showReject = !showReject" class="px-6 py-3 bg-error text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reject Event
                    </button>
                </div>

                <div x-show="showReject" x-cloak x-transition class="mt-6 pt-6 border-t border-neutral-border">
                    <form action="{{ route('admin.events.reject', $event) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-neutral-text mb-2">Alasan Penolakan <span class="text-error">*</span></label>
                            <textarea name="rejection_reason" required placeholder="Jelaskan alasan penolakan secara detail..." class="w-full rounded-xl border border-neutral-border bg-white p-4 text-sm focus:border-error focus:ring-2 focus:ring-error/20 outline-none transition-all min-h-[120px]"></textarea>
                        </div>
                        <div class="flex items-center gap-3 justify-end">
                            <button type="button" @click="showReject = false" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 bg-error text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all">Kirim Penolakan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Delete Event -->
        @if($event->status !== 'cancelled')
        <div class="bg-white rounded-2xl border border-error/20 shadow-sm p-6" x-data="{ showDelete: false }">
            <h3 class="text-lg font-bold text-error font-poppins mb-1">Danger Zone</h3>
            <p class="text-xs text-neutral-muted mb-4">Hapus event ini secara permanen.</p>
            <button type="button" @click="showDelete = !showDelete" class="px-5 py-2.5 bg-error text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus Event
            </button>
            <div x-show="showDelete" x-cloak x-transition class="mt-6 pt-6 border-t border-error/20">
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <div>
                        <label class="block text-sm font-semibold text-neutral-text mb-2">Alasan Penghapusan <span class="text-error">*</span></label>
                        <textarea name="delete_reason" required placeholder="Jelaskan alasan mengapa event ini dihapus..." class="w-full rounded-xl border border-neutral-border bg-white p-4 text-sm focus:border-error focus:ring-2 focus:ring-error/20 outline-none transition-all min-h-[100px]"></textarea>
                    </div>
                    <div class="flex items-center gap-3 justify-end">
                        <button type="button" @click="showDelete = false" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Batal</button>
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus event ini?')" class="px-5 py-2.5 bg-error text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
@endsection
