@extends('layouts.admin', ['activeNav' => 'events', 'pageTitle' => 'Semua Event', 'breadcrumbs' => [['label' => 'Events']]])

@section('title', 'Manajemen Event')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        @if(session('success'))
            <x-alert type="success" dismissible="true" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <div class="w-full min-w-0 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">Semua Event</h2>
                <p class="text-sm text-neutral-muted">Kelola semua event di EventHub.</p>
            </div>
            <a href="{{ route('admin.events.pending') }}" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-warning text-warning text-sm font-semibold hover:bg-warning hover:text-white hover:font-bold hover:shadow-md transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Review Pending
                @php($pendingCount = \App\Models\Event::where('status', 'pending')->count())
                @if($pendingCount > 0)
                    <span class="w-5 h-5 rounded-full bg-warning/20 text-warning group-hover:bg-white/20 group-hover:text-white text-[10px] font-bold flex items-center justify-center">{{ $pendingCount }}</span>
                @endif
            </a>
        </div>

        <form method="GET" action="{{ route('admin.events.index') }}" class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event..." class="w-full pl-10 pr-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text placeholder:text-neutral-muted/60 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none" />
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <select name="status" class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors">Filter</button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-neutral-bg text-neutral-text text-sm font-semibold rounded-xl hover:bg-neutral-border transition-colors">Hapus</a>
                @endif
            </div>
        </form>

        <div class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-border/60 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-muted">Daftar Event</span>
                <span class="text-xs text-neutral-muted">{{ $events->total() }} {{ Str::plural('event', $events->total()) }} ditemukan</span>
            </div>

            @if($events->count())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-bg/50 border-b border-neutral-border">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider hidden md:table-cell">Organizer</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider hidden lg:table-cell">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-text uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-border">
                            @foreach($events as $event)
                                <tr class="hover:bg-neutral-bg/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-neutral-text">{{ $event->title }}</div>
                                        <div class="text-xs text-neutral-muted mt-0.5">{{ $event->start_at ? $event->start_at->format('d M Y, H:i') : '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <div class="text-sm text-neutral-text">{{ $event->organizer->name ?? '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <div class="text-sm text-neutral-muted">{{ $event->category->name ?? '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php($statusColors = ['draft' => 'neutral', 'pending' => 'warning', 'published' => 'success', 'rejected' => 'error', 'cancelled' => 'neutral', 'completed' => 'info'])
                                        <x-badge variant="{{ $statusColors[$event->status] ?? 'neutral' }}" size="sm">{{ ucfirst($event->status) }}</x-badge>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.events.show', $event) }}" class="p-2 text-neutral-muted hover:text-primary hover:bg-primary-light rounded-lg transition-colors" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($events->hasPages())
                    <div class="px-6 py-4 border-t border-neutral-border">{{ $events->links() }}</div>
                @endif
            @else
                <div class="p-12 sm:p-16 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-neutral-bg border border-neutral-border text-neutral-muted flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-neutral-text font-poppins mb-1">Tidak ada event ditemukan</h3>
                    <p class="text-xs sm:text-sm text-neutral-muted max-w-sm">@if(request('search') || request('status')) Coba sesuaikan filter Anda. @else Belum ada event yang dibuat. @endif</p>
                </div>
            @endif
        </div>
    </div>
@endsection
