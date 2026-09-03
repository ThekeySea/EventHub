@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Welcome Header -->
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">
            Selamat datang kembali, {{ auth()->user()->name }}
        </h2>
        <p class="text-sm text-neutral-muted">
            Berikut aktivitas event hari ini.
        </p>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card 
            title="Total Event"
            value="{{ $totalEvents }}"
            badge="{{ $publishedEvents }} published"
            :change="null"
        >
            <x-slot name="icon">
                <x-icons.events />
            </x-slot>
        </x-stat-card>
        
        <x-stat-card 
            title="Total Anggota"
            value="{{ $totalUsers }}"
            badge="Pengguna terdaftar"
            :change="null"
            iconBg="bg-secondary-light text-secondary"
        >
            <x-slot name="icon">
                <x-icons.members />
            </x-slot>
        </x-stat-card>
        
        <x-stat-card 
            title="Menunggu Review"
            value="{{ $pendingEvents }}"
            badge="{{ $pendingEvents > 0 ? 'Perlu perhatian' : 'Semua clear' }}"
            :change="null"
            iconBg="bg-warning-light text-warning"
        >
            <x-slot name="icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </x-slot>
        </x-stat-card>
        
        <x-stat-card 
            title="Kategori"
            value="{{ $totalCategories }}"
            badge="Tema aktif"
            :change="null"
            iconBg="bg-info-light text-info"
        >
            <x-slot name="icon">
                <x-icons.tickets />
            </x-slot>
        </x-stat-card>
    </div>

    <!-- Pending Events Section -->
    <div class="mb-6" x-data="{ openReject: null }">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-neutral-text font-poppins">Event Menunggu Review</h3>
                <p class="text-xs text-neutral-muted">Event yang perlu persetujuan kamu</p>
            </div>
            @if($pendingEvents > 0)
                <a href="{{ route('admin.events.pending') }}" class="text-xs font-semibold text-primary hover:text-primary-hover transition-colors">
                    Lihat Semua →
                </a>
            @endif
        </div>

        @if($pendingEventsList->count())
            <div class="space-y-3">
                @foreach($pendingEventsList as $event)
                    <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-5 hover:shadow-md transition-shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="text-base font-bold text-neutral-text font-poppins truncate">{{ $event->title }}</h4>
                                    <x-badge variant="warning" size="sm">Pending</x-badge>
                                </div>
                                <div class="flex flex-wrap gap-x-3 gap-y-1 text-xs text-neutral-muted">
                                    <span>👤 {{ $event->organizer->name ?? '—' }}</span>
                                    <span>📂 {{ $event->category->name ?? '—' }}</span>
                                    <span>📅 {{ $event->start_at ? $event->start_at->format('d M Y, H:i') : '—' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('admin.events.show', $event) }}" class="px-3 py-1.5 text-xs font-semibold text-primary border border-primary/20 rounded-lg hover:bg-primary-light transition-colors">
                                    Detail
                                </a>
                                <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-success text-white text-xs font-semibold rounded-lg hover:opacity-90 transition-colors">
                                        ✓ Approve
                                    </button>
                                </form>
                                <button type="button" @click="openReject = openReject === {{ $event->id }} ? null : {{ $event->id }}" class="px-3 py-1.5 bg-error text-white text-xs font-semibold rounded-lg hover:opacity-90 transition-colors">
                                    ✕ Reject
                                </button>
                            </div>
                        </div>

                        <!-- Reject Form (inline expandable) -->
                        <div x-show="openReject === {{ $event->id }}" x-cloak x-transition class="mt-4 pt-4 border-t border-neutral-border">
                            <form action="{{ route('admin.events.reject', $event) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-neutral-text mb-1">Alasan Penolakan <span class="text-error">*</span></label>
                                    <textarea name="rejection_reason" required placeholder="Jelaskan alasan penolakan..." class="w-full rounded-xl border border-neutral-border bg-white p-3 text-sm focus:border-error focus:ring-2 focus:ring-error/20 outline-none transition-all min-h-[80px]"></textarea>
                                </div>
                                <div class="flex items-center gap-2 justify-end">
                                    <button type="button" @click="openReject = null" class="px-3 py-1.5 text-xs font-semibold text-neutral-text rounded-lg hover:bg-neutral-bg transition-colors">Batal</button>
                                    <button type="submit" class="px-3 py-1.5 bg-error text-white text-xs font-semibold rounded-lg hover:opacity-90 transition-colors">Kirim Penolakan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-neutral-border p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-success mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-semibold text-neutral-text">Tidak ada event pending 🎉</p>
                <p class="text-xs text-neutral-muted mt-1">Semua sudah direview.</p>
            </div>
        @endif
    </div>

    <!-- Two Column: Recent Events + Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Events -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-neutral-text font-poppins">Event Terbaru</h3>
                    <p class="text-xs text-neutral-muted">5 event terakhir dibbuat</p>
                </div>
                <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-primary hover:text-primary-hover">Lihat Semua →</a>
            </div>

            @if($recentEvents->count())
                <div class="space-y-3">
                    @foreach($recentEvents as $event)
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-neutral-bg/50 transition-colors">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-neutral-text truncate">{{ $event->title }}</p>
                                <p class="text-xs text-neutral-muted">{{ $event->organizer->name ?? '—' }} • {{ $event->created_at->diffForHumans() }}</p>
                            </div>
                            @php($statusColors = ['draft' => 'neutral', 'pending' => 'warning', 'published' => 'success', 'rejected' => 'error'])
                            <x-badge variant="{{ $statusColors[$event->status] ?? 'neutral' }}" size="sm">{{ ucfirst($event->status) }}</x-badge>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <p class="text-sm text-neutral-muted">Belum ada event.</p>
                </div>
            @endif
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-neutral-text font-poppins mb-4">Ringkasan</h3>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-success-light rounded-xl border border-success/20">
                    <span class="text-sm font-medium text-success">Published</span>
                    <span class="text-sm font-bold text-success">{{ $publishedEvents }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-warning-light rounded-xl border border-warning/20">
                    <span class="text-sm font-medium text-warning">Pending</span>
                    <span class="text-sm font-bold text-warning">{{ $pendingEvents }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-neutral-bg rounded-xl border border-neutral-border/60">
                    <span class="text-sm font-medium text-neutral-text">Total Pengguna</span>
                    <span class="text-sm font-bold text-neutral-text">{{ $totalUsers }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-neutral-bg rounded-xl border border-neutral-border/60">
                    <span class="text-sm font-medium text-neutral-text">Tema</span>
                    <span class="text-sm font-bold text-neutral-text">{{ $totalCategories }}</span>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="mt-6 pt-4 border-t border-neutral-border space-y-2">
                <a href="{{ route('admin.events.pending') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">
                    <svg class="w-4 h-4 text-neutral-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Review Event Pending
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">
                    <svg class="w-4 h-4 text-neutral-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kelola Tema
                </a>
                <a href="{{ route('admin.event-types.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">
                    <svg class="w-4 h-4 text-neutral-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Kelola Jenis Acara
                </a>
            </div>
        </div>
    </div>
@endsection
